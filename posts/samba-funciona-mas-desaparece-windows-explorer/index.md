# Por que o Samba voltou sem reaparecer no Windows 11

Published: 2026-08-18
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/samba-funciona-mas-desaparece-windows-explorer/
Tags: Samba, Windows 11, Ansible, Homelab, Diagnóstico, WS-Discovery

---

Seis atalhos do Windows apontavam para compartilhamentos que pareciam ter
desaparecido:

```text
\\192.168.0.140\common-shared
\\192.168.0.140\inbox-empresa
\\192.168.0.140\inbox-geral
\\192.168.0.140\inbox-pessoal
\\192.168.0.140\public-shared
\\192.168.0.140\work-shared
```

As portas SMB respondiam, mas o Explorer não mostrava os diretórios. Depois que
o acesso direto voltou, surgiu uma segunda estranheza: o servidor continuava
ausente em **Rede** no Windows 11.

Os dois sintomas pareciam parte da mesma falha. O diagnóstico mostrou duas
causas independentes:

- uma permissão Unix no diretório-pai bloqueava um dos acessos guest;
- o Samba não publicava o servidor pelo mecanismo usado pelo Explorer moderno.

A diferença importa porque cada camada exige um teste próprio. Uma porta 445
aberta não demonstra que o share aceita determinada identidade. Um share
acessível por caminho UNC também não demonstra que o servidor será descoberto
na tela **Rede**.

## O que eu precisava distinguir

O servidor era um LXC com Debian 13 no Proxmox, disponível em
`192.168.0.140`. O Samba, gerenciado por Ansible, oferecia seis áreas:

| Share | Política |
|---|---|
| `inbox-geral` | privado, leitura e escrita por `gpupo` |
| `inbox-empresa` | privado, leitura e escrita por `gpupo` |
| `inbox-pessoal` | privado, leitura e escrita por `gpupo` |
| `work-shared` | escrita por `gpupo` e pelo grupo `sambashare` |
| `common-shared` | leitura guest e escrita autenticada |
| `public-shared` | leitura e escrita guest |

O cliente usado no diagnóstico foi o `node6`, um Windows 11 em
`192.168.0.56`.

Antes de mudar a configuração, separei três perguntas:

```text
TCP 445 responde?
        ↓
o share aceita a identidade usada?
        ↓
o servidor é descoberto pelo Explorer?
```

Essa sequência acabou sendo mais útil que tratar “o Samba não funciona” como
um único estado.

## A porta respondia, mas o acesso guest falhava

Comecei pelo servidor, sem reiniciar serviços:

```bash
systemctl is-active smbd nmbd
testparm -s
ss -lntp | grep -E ':139|:445'
smbstatus --shares
```

O resultado enfraqueceu a hipótese de falha geral:

- `smbd` e `nmbd` estavam ativos;
- `testparm` carregava a configuração sem erros;
- os seis shares apareciam na configuração efetiva;
- existia uma conexão aberta em `common-shared`.

O host tinha iniciado pouco antes, o que explicava parte da indisponibilidade
vista minutos antes. Não explicava, porém, por que o acesso guest ao
`common-shared` ainda recebia `STATUS_ACCESS_DENIED`.

Testei os seis caminhos pelo protocolo SMB com a credencial mantida fora do
repositório. Todos funcionaram de forma autenticada. Como guest, o resultado
foi diferente:

```text
public-shared: OK
common-shared: STATUS_ACCESS_DENIED
inbox-geral:   STATUS_ACCESS_DENIED (esperado)
```

Se `public-shared` aceitava guest, uma explicação genérica como “o Windows
bloqueia acesso anônimo” não cobria o que eu observava. A diferença estava nos
caminhos ou na identidade efetiva usada por cada share.

## A permissão problemática estava um nível acima

A configuração do `common-shared` parecia coerente com a política:

```ini
[common-shared]
   path = /data/common-shared
   browseable = yes
   read only = yes
   guest ok = yes
   write list = gpupo
```

O próprio diretório também não indicava o bloqueio:

```text
drwxr-xr-x gpupo:gpupo /data/common-shared
```

O detalhe apareceu quando inspecionei todos os componentes do caminho:

```bash
namei -l /data/common-shared
```

```text
drwxr-xr-x root:root   /
drwx------ gpupo:gpupo data
drwxr-xr-x gpupo:gpupo common-shared
```

O diretório `/data` estava em `0700`. Quando o Samba mapeava um usuário
desconhecido para a conta guest `nobody`, essa conta não conseguia atravessar o
diretório-pai. O log registrava a mesma identidade e a mesma falha:

```text
vfs_ChDir(/data/common-shared) failed: Permission denied
Current token: uid=65534, gid=65534
```

Esse comportamento corresponde à resolução de caminhos no Linux: cada
componente intermediário precisa conceder permissão de busca, representada pelo
bit de execução em diretórios. Sem ela, a resolução termina com `EACCES`, ainda
que o diretório final tenha permissões mais abertas. A distinção entre leitura
e busca está descrita em
[`path_resolution(7)`](https://man7.org/linux/man-pages/man7/path_resolution.7.html).

O `public-shared` escondia o problema porque sua configuração usava
`force user = gpupo`. A operação acabava executada com uma identidade que podia
atravessar `/data`. Os dois shares aceitavam guest no Samba, mas chegavam ao
sistema de arquivos com identidades diferentes.

## `0711` abriu a travessia, não a listagem

Minha correção foi alterar somente a raiz `/data` para `0711`:

```yaml
- name: Garantir raiz de dados atravessavel pelos acessos guest
  ansible.builtin.file:
    path: /data
    state: directory
    owner: gpupo
    group: gpupo
    mode: "0711"
```

O bit de execução permite atravessar o diretório quando o nome do próximo
componente é conhecido. Como a conta guest não recebeu leitura na raiz, ela
continua sem poder listar o conteúdo de `/data`.

As permissões específicas permaneceram nos diretórios finais:

```text
/data                       0711
/data/inbox-geral           0700
/data/inbox-empresa         0700
/data/inbox-pessoal         0700
/data/work-shared           2770
/data/common-shared         0755
/data/public-shared         0777
```

Isso não torna `0711` uma recomendação universal para toda raiz de shares. A
decisão fez sentido aqui porque os nomes publicados pelo Samba são conhecidos,
os diretórios privados continuam fechados e a política de cada share permanece
explícita. ACLs, identidades forçadas ou outra organização de caminhos podem
pedir uma fronteira diferente.

## O playbook precisava provar mais que a configuração

Durante o diagnóstico encontrei uma falha no próprio processo de automação. O
playbook tentava usar `smbclient`, mas não instalava o pacote. A validação
também acontecia antes de a configuração ser publicada e antes de os serviços
estarem garantidos como ativos.

Reordenei o fluxo para:

1. instalar `samba`, `samba-common`, `smbclient` e, depois, `wsdd2`;
2. criar usuários, grupos e diretórios;
3. validar o template antes de substituir `smb.conf`;
4. garantir os serviços ativos;
5. aplicar handlers pendentes;
6. listar os seis shares com autenticação;
7. listar `common-shared` e `public-shared` como guest.

O template passou a usar a validação oferecida pelo módulo
[`ansible.builtin.template`](https://docs.ansible.com/projects/ansible/latest/collections/ansible/builtin/template_module.html):

```yaml
- name: Deploy Samba smb.conf configuration
  ansible.builtin.template:
    src: "/../templates/services/samba.conf.j2"
    dest: /etc/samba/smb.conf
    owner: root
    group: root
    mode: "0644"
    validate: testparm -s %s
  notify: Restart Samba services
```


Depois da correção, uma segunda execução terminou assim:

```text
samba-server: ok=15 changed=0 failed=0
```

Nesse ponto eu tinha evidência para a segunda pergunta: os shares aceitavam as
identidades esperadas. Ainda não tinha respondido por que o servidor não
aparecia em **Rede**.

## Acesso por UNC e descoberta são capacidades diferentes

No `node6`, o caminho direto funcionava:

```powershell
Test-Path '\\192.168.0.140\common-shared'
```

```text
True
```

Mesmo assim, o servidor não aparecia em **Explorador de Arquivos → Rede**.

A [documentação da
Microsoft](https://learn.microsoft.com/en-us/windows-server/storage/file-server/troubleshoot/smbv1-not-installed-by-default-in-windows)
explica a separação histórica: o antigo serviço Computer Browser dependia de
SMB1 e, sem ele, o Explorer deixa de listar computadores pelo método legado de
browsing via datagramas NetBIOS. O Windows 11 não instala cliente nem servidor
SMB1 por padrão, e a Microsoft recomenda não reinstalar o protocolo por causa
de seus problemas de segurança.

A [FAQ do
Samba](https://wiki.samba.org/index.php/FAQ#Why_does_Windows_Network_Neighborhood_not_show_Samba_server(s)?)
descreve a consequência prática: com SMB2 ou SMB3, o recurso ainda pode ser
aberto diretamente por nome ou IP, enquanto a descoberta de rede usa WSD e
LLMNR. Era exatamente a divisão observada no `node6`.

Minha configuração manteve `min protocol = SMB2`. Reativar SMB1 para recuperar
a tela **Rede** teria alterado o protocolo de compartilhamento para corrigir um
problema de publicação.

## O servidor passou a responder por WS-Discovery

No Debian 13 usado no LXC, `apt-cache` não apresentava candidato para `wsdd`,
mas oferecia `wsdd2` na versão `1.8.7+dfsg-1.2`. O
[`wsdd2` empacotado pelo
Debian](https://packages.debian.org/stable/wsdd2) é descrito como um daemon WSD
que anuncia compartilhamentos e responde a Probes de clientes Windows. O pacote
também implementa resolução multicast por LLMNR.

Acrescentei o pacote e o serviço ao playbook do Samba:

```yaml
- name: Install Samba packages
  ansible.builtin.apt:
    name:
      - samba
      - samba-common
      - smbclient
      - wsdd2
    state: present

- name: Ensure Samba services are enabled and started
  ansible.builtin.service:
    name: ""
    state: started
    enabled: true
  loop:
    - smbd
    - nmbd
    - wsdd2
```

Depois do deploy, observei o daemon em UDP e TCP 3702, usados na descoberta e
na troca de metadados, e em UDP e TCP 5355 para LLMNR. O nome anunciado era
`SAMBA-SERVER`, no workgroup `WORKGROUP`.

O `nmbd` permaneceu ativo para compatibilidade e nomes NetBIOS. O resultado do
teste, porém, não dependia de reativar o browsing legado.

## Eu também normalizei o lado do Windows

No cliente encontrei este estado:

```text
Rede "Cogumelo": Public
fdPHost:             Running / Manual
FDResPub:            Stopped / Manual
```

Como se tratava de uma rede doméstica confiável, criei um playbook dedicado ao
`node6` que:

- altera somente perfis de rede ativos para `Private`;
- mantém `fdPHost` e `FDResPub` automáticos e ativos;
- habilita somente as regras privadas do grupo nativo **Network Discovery**;
- confirma que `common-shared` continua acessível.

Os serviços ficaram declarados assim:

```yaml
- name: Garantir servicos de descoberta ativos
  ansible.windows.win_service:
    name: ""
    start_mode: auto
    state: started
  loop:
    - fdPHost
    - FDResPub
```

As regras foram selecionadas por grupo e perfil, sem abrir portas para o perfil
público:

```powershell
Get-NetFirewallRule -DisplayGroup 'Network Discovery' |
  Where-Object {
    $_.Profile.ToString() -match 'Private' -and
    $_.Enabled -ne 'True'
  } |
  Enable-NetFirewallRule
```

A orientação da Microsoft para diagnosticar aplicações WSD inclui verificar a
exceção de firewall **Network Discovery** e as portas de descoberta e troca de
metadados. Esse é o limite que usei para as regras, conforme a documentação de
[configuração de adaptador e
firewall](https://learn.microsoft.com/en-us/windows/win32/wsdapi/inspecting-adapter-and-firewall-settings).

A segunda execução do playbook do Windows também ficou limpa:

```text
node6: ok=4 changed=0 failed=0
```

Eu não isolei cada mudança do cliente em experimentos separados. Portanto, o
resultado não demonstra que mudar o perfil, iniciar os dois serviços e
habilitar as regras tenham sido individualmente necessários para este servidor
aparecer. O que validei foi o estado final desejado e o tráfego WSD completo
nesse estado.

## A interface do Explorer não foi meu teste principal

Uma sessão SSH no Windows não reproduz perfeitamente o namespace, o cache e o
ciclo de atualização da sessão gráfica do Explorer. Em vez de tratar a tela
**Rede** como única evidência, validei as etapas do protocolo:

1. o `node6` enviou um Probe multicast para `239.255.255.250:3702`;
2. o `wsdd2` recebeu o Probe;
3. o `node6` recebeu `ProbeMatches` de `192.168.0.140`;
4. `SAMBA-SERVER` resolveu para `192.168.0.140` por LLMNR;
5. o cliente alcançou TCP 3702 para obter os metadados WSD;
6. `\\SAMBA-SERVER\common-shared` abriu e listou o conteúdo.

O fluxo é compatível com a especificação publicada pela Microsoft: o cliente
envia um Probe multicast e o serviço descoberto devolve um Probe Match. A
sequência está descrita no cenário de
[descoberta dinâmica por
WS-Discovery](https://learn.microsoft.com/en-us/openspecs/windows_protocols/ms-netod/a0315263-20cf-4401-95f0-1a16c942e245).

O resumo do teste ficou assim:

```text
wsd-server=192.168.0.140
probe-match=True
resolved-address=192.168.0.140
tcp445=True
wsd-tcp3702=True
share-by-name=True
```

Esse teste prova mais que uma captura da interface: o servidor respondeu ao
protocolo, o nome resolveu, as portas necessárias estavam alcançáveis e o share
abriu pelo nome anunciado.

## Dois falsos caminhos também fizeram parte do diagnóstico

Meu primeiro Probe manual foi rejeitado pelo `wsdd2` como
`Unsupported query`. O XML era semanticamente equivalente ao esperado e outros
dispositivos responderam, mas eu tinha usado aliases de namespace como `a:` e
`d:`. O parser do `wsdd2` esperava os prefixos convencionais `wsa:` e `wsd:`.
Quando repeti o envelope com esses prefixos, o Samba respondeu imediatamente
com `ProbeMatches`.

Não generalizo esse resultado para XML ou para toda implementação de
WS-Discovery. Foi uma incompatibilidade observada neste parser, nesta versão,
durante um teste manual.

Também investiguei a bridge e o firewall do Proxmox porque um listener auxiliar
parecia não receber multicast. O debug do próprio `wsdd2` mostrou que o Probe do
`node6` chegava normalmente. Descartei a hipótese de bloqueio na virtualização
sem alterar o firewall.

## O estado que consigo sustentar

Ao final da manutenção:

- os seis shares funcionavam com autenticação;
- `common-shared` e `public-shared` funcionavam como guest;
- `SAMBA-SERVER` respondia a Probes WS-Discovery;
- o `node6` resolvia o nome e abria o share sem usar o IP;
- o Windows estava em perfil privado, com os serviços e as regras de descoberta
  declarados pelo playbook;
- os dois playbooks repetiam com `changed=0`;
- a configuração operacional estava registrada na Wiki do homelab.

Neste ambiente, “Samba funcionando” precisava ser dividido em disponibilidade,
autorização e descoberta. Para uma ocorrência semelhante, eu começaria pelos
mesmos limites: testaria TCP 445, depois cada share com a identidade relevante
e somente então o Probe WSD. Essa ordem reduz a chance de alterar o firewall ou
reativar um protocolo legado para corrigir uma permissão que estava em
`/data`.

*Ambiente validado em 18 de agosto de 2026: Debian 13 em LXC/Proxmox, Samba
4.22.10, wsdd2 1.8.7, Windows 11 e Ansible Core 2.21.1.*
