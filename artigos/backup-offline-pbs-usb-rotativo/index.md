# Backup offline com PBS, LUKS e dois discos USB rotativos

Published: 2026-08-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/backup-offline-pbs-usb-rotativo/
Tags: Backup, Proxmox, Homelab, Segurança, LUKS

---

Um backup que permanece conectado ao servidor continua exposto ao mesmo incidente que derruba a produção. Se um ransomware obtém acesso ao host, ele pode alcançar também o destino de backup. Se o disco quebra junto com o servidor, a cópia local não resolve o problema.

Para reduzir esse risco no meu homelab, estou desenhando uma estratégia com Proxmox Backup Server (PBS), dois discos USB externos criptografados e uma rotação semanal. O objetivo é simples: o disco que recebe o backup não fica conectado depois que o trabalho termina.

Esta é uma arquitetura planejada, não um relato de um restore já medido em produção. O valor do desenho está em deixar claras as operações, os pontos de falha e o teste que ainda precisa ser feito.

## O desenho da solução

A produção continua no Proxmox VE. O PBS organiza os datastores e executa as verificações. Os discos USB funcionam como destinos alternados:

```text
                 backup semanal
Proxmox VE ─────────────────────────▶ PBS
                                      │
                                      ├── PBS_ROT_A (conectado)
                                      └── PBS_ROT_B (offline)

Depois do verify:
  desmontar → fechar LUKS → remover o disco
```

Cada disco recebe seu próprio container LUKS e seu próprio filesystem. O PBS enxerga um datastore montado; o sistema operacional só enxerga os dados enquanto o disco está desbloqueado e conectado.

O stack proposto é:

- Proxmox VE para as cargas de produção;
- Proxmox Backup Server para os backups e as verificações;
- dois discos USB externos, identificados como `PBS_ROT_A` e `PBS_ROT_B`;
- LUKS2/dm-crypt para criptografia em repouso;
- ext4 para o filesystem do datastore;
- montagem manual ou automação controlada por systemd.

## Por que dois discos rotativos

Um único disco offline cria uma janela sem cópia quando está conectado para receber o backup. Com dois discos, um pode estar no servidor e o outro guardado em outro lugar enquanto a operação acontece.

| Semana | Disco usado no backup | Outro disco |
| --- | --- | --- |
| 1 | `PBS_ROT_A` | `PBS_ROT_B` offline |
| 2 | `PBS_ROT_B` | `PBS_ROT_A` offline |
| 3 | `PBS_ROT_A` | `PBS_ROT_B` offline |

A rotação não transforma o backup em uma cópia externa automaticamente. Se os dois discos ficam na mesma gaveta, incêndio, roubo ou um erro físico ainda pode destruir os dois. Para um nível de proteção maior, eu levaria um dos discos para outro local após cada ciclo ou adicionaria uma cópia remota.

## A preparação do disco precisa ser destrutiva e explícita

O fluxo de preparação é curto:

1. identificar o disco pelo caminho estável em `/dev/disk/by-id`;
2. criar uma tabela GPT e uma partição que ocupe o disco;
3. aplicar LUKS2 na partição;
4. abrir o container com um nome previsível;
5. criar o filesystem ext4;
6. aplicar o label do disco;
7. montar o filesystem em `/mnt/pbs-usb`;
8. criar o datastore PBS dentro desse mountpoint.

O ponto mais importante é não usar `/dev/sdb` ou outro nome que possa mudar quando um segundo disco for conectado. O identificador precisa ser conferido com `lsblk` e com o conteúdo de `/dev/disk/by-id` antes de qualquer operação.

> [!warning] A preparação apaga o disco
> `cryptsetup luksFormat`, `wipefs` e a criação da partição destroem a estrutura anterior. Eu executaria esses comandos somente depois de conferir o modelo, o número de série e o caminho completo do dispositivo. Um erro nessa etapa pode apagar o disco errado.

Depois da criação, o label do filesystem ajuda na leitura, mas não deve substituir a identificação por hardware. O caminho do dispositivo e o nome do container LUKS precisam estar registrados no inventário da infraestrutura.

## O ciclo semanal

O procedimento operacional que estou considerando é este:

```text
1. conectar o disco da semana
2. identificar o dispositivo
3. desbloquear o container LUKS
4. montar o filesystem
5. executar o backup no PBS
6. executar verify no datastore
7. testar um restore pequeno quando previsto no calendário
8. desmontar o filesystem
9. fechar o container LUKS
10. remover o disco e registrar a rotação
```

O backup só termina quando o disco volta a ficar offline. Deixar o USB montado porque o `verify` terminou transforma uma cópia offline em um volume permanentemente disponível para o host.

Uma automação futura pode chamar o job do PBS e o `verify`, mas eu manteria a conexão física, o desbloqueio e a remoção como passos conscientes até que o procedimento esteja bem testado. A simplicidade aqui é uma característica de segurança, não uma falta de automação.

## Verificar não é restaurar

O `verify` ajuda a detectar inconsistências no datastore, mas não prova que uma máquina virtual inicia ou que um arquivo importante voltou ao estado esperado.

Por isso, o plano inclui testes de restore em duas escalas:

- restore de um arquivo para validar a recuperação granular;
- restore de um LXC ou de uma VM para validar a recuperação operacional.

A meta inicial é conseguir restaurar uma VM crítica em menos de 15 minutos. Esse número é um objetivo de projeto, não um resultado já medido. Para transformá-lo em evidência, eu registraria o tamanho do backup, o tempo de transferência, o tempo de boot e quais etapas ainda exigem intervenção manual.

O checklist mensal ficaria assim:

```text
[ ] backup executado
[ ] verify executado
[ ] restore de arquivo testado
[ ] restore de LXC ou VM testado
[ ] SMART dos discos verificado
[ ] rotação registrada
[ ] LUKS desbloqueado e fechado corretamente
[ ] recovery key acessível
```

## A chave de recuperação é parte do backup

Criptografar o disco protege os dados se a mídia for roubada, mas cria uma nova dependência: alguém precisa conseguir desbloqueá-la quando o servidor original não existir mais.

Eu manteria a recovery key em pelo menos dois meios controlados, por exemplo:

- um gerenciador de senhas;
- uma cópia física guardada em local seguro.

A chave não deve existir somente no host PBS. Se o host e os discos forem perdidos no mesmo incidente, a cópia que ficou no servidor não ajuda no restore.

Também separaria a senha de desbloqueio das credenciais usadas pelo PBS. São camadas diferentes: uma protege o volume físico e a outra controla o serviço de backup.

## O que essa arquitetura protege

O desenho reduz alguns riscos específicos:

- ransomware que alcança o host enquanto o disco está guardado offline;
- exposição de dados em caso de roubo do disco, porque o volume está criptografado;
- perda de todas as cópias por uma falha isolada de um disco;
- restaurações que nunca foram testadas, ao transformar o restore em uma tarefa mensal.

Ele não resolve tudo. Dois discos no mesmo local continuam vulneráveis a incêndio, enchente, roubo simultâneo e erro operacional. A criptografia também não protege contra a perda da recovery key. E um `verify` sem restore não garante que a aplicação recuperada funcionará.

## Próximo passo: medir a recuperação

O próximo passo não é comprar mais storage. É executar um ciclo completo com dados não críticos:

1. preparar um dos discos usando um identificador estável;
2. criar o datastore e realizar um backup;
3. executar `verify`;
4. desmontar e fechar o LUKS;
5. desconectar o disco;
6. reconectar depois, desbloquear e restaurar uma VM de teste;
7. documentar o tempo e as decisões manuais.

Depois desse ensaio, fica mais fácil decidir se a rotação semanal é suficiente, se um dos discos deve permanecer fora da residência ou se uma cópia remota precisa entrar na arquitetura.

## Conclusão

O princípio da estratégia é manter o destino de backup desconectado por padrão e tornar o restore uma operação praticada, não uma promessa. PBS organiza a cópia e a verificação; LUKS reduz a exposição física; os dois discos criam rotação; o teste de restore mostra se o conjunto realmente funciona.

Para o meu contexto, eu começaria com esse ciclo pequeno, documentado e auditável. Só aumentaria a automação depois de provar que consigo recuperar um serviço sem depender de memória ou de comandos improvisados.
