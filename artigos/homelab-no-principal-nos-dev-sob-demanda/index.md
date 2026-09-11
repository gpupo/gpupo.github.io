# Meu homelab não precisa de três nós sempre ligados

Published: 2026-04-19
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/homelab-no-principal-nos-dev-sob-demanda/
Tags: Homelab, Proxmox, Nomad, Infraestrutura, DevOps

---

Eu queria montar um homelab com três máquinas, mas não queria pagar energia e ruído para manter as três ligadas o tempo todo. Ao mesmo tempo, alguns serviços precisavam continuar disponíveis: DNS da rede, repositórios de código, gestão de senhas, automações e os componentes que sustentam o próprio ambiente.

Os outros dois nós tinham uma finalidade diferente. Eles existem para levantar ambientes de desenvolvimento, containers mais pesados e tarefas de agentes de código quando há trabalho a executar. Quando não há, podem ficar desligados.

Esse detalhe muda a arquitetura. Não se trata de um cluster de alta disponibilidade com três hosts equivalentes. É uma infraestrutura com dois níveis de disponibilidade:

```text
Nó principal, sempre ligado
  → serviços persistentes e dados críticos
  → controle e observabilidade

Nós de desenvolvimento, sob demanda
  → ambientes efêmeros
  → builds, testes e tarefas intensivas
  → desligados fora do período de uso
```

A decisão principal foi aceitar esse desenho pelo que ele é: uma forma de manter o ambiente operável por uma pessoa, reduzir custo contínuo e ainda ter capacidade extra quando ela realmente importa.

## A disponibilidade não precisa ser uniforme

Em muitos diagramas de cluster, todos os nós parecem iguais. Na prática, eles raramente têm a mesma função.

Um servidor que mantém o DNS local, os repositórios e o banco de dados de um serviço interno não pode depender de uma máquina que só é ligada durante uma sessão de desenvolvimento. Já um ambiente de teste criado para um agente executar uma tarefa pode ser descartado ao final do dia.

Tratar os dois casos como se precisassem da mesma disponibilidade aumenta a infraestrutura sem melhorar o resultado.

Eu separei os workloads em duas classes.

| Classe | Exemplos | Expectativa operacional |
| --- | --- | --- |
| Permanente | DNS, repositórios, gestão de segredos, proxy, observabilidade, dados de aplicações internas | Disponível depois de reinicialização; dados preservados; recuperação documentada |
| Sob demanda | Ambientes de desenvolvimento, agentes de código, jobs de build, testes de integração | Pode aguardar o host ligar; pode ser destruído; dados são efêmeros ou reproduzíveis |

A classificação precisa vir antes de escolher Kubernetes, Nomad, Ceph ou qualquer outra ferramenta. Se todos os workloads forem tratados como críticos, o ambiente inteiro passa a exigir uma disponibilidade que ele não precisa entregar.

## O nó principal é uma fundação, não um cluster de HA

O nó sempre ligado concentra os serviços que mantêm o ambiente utilizável. Ele também concentra os dados persistentes desses serviços.

Isso traz simplicidade. A aplicação que precisa de um volume local tem uma localização conhecida. Um reinício dos nós de desenvolvimento não desloca um banco de dados para um host que pode ser desligado algumas horas depois. E o primeiro milestone pode ser concluído antes de comprar, configurar e operar toda a capacidade adicional.

Mas é importante não chamar isso de alta disponibilidade.

Se o nó principal falhar, os serviços permanentes param. O restante do cluster não deve criar uma falsa expectativa de failover automático quando os dados residem naquele host. A estratégia de continuidade, nesse caso, é outra:

```text
dados persistentes no nó principal
        ↓
backup independente e verificável
        ↓
procedimento de restauração testado
        ↓
recuperação em hardware disponível
```

Para um homelab, eu prefiro essa limitação explícita a configurar uma solução distribuída que depende dos nós que normalmente estarão desligados.

## O armazenamento segue o ciclo de vida dos dados

O erro mais provável seria usar o mesmo storage para tudo.

Dados de um serviço permanente precisam sobreviver a reinicializações, atualizações e erros humanos. Dados de uma máquina criada para uma sessão de desenvolvimento não precisam, necessariamente, atravessar o dia seguinte.

Por isso, a organização ficou próxima desta:

```text
Nó principal
  ├─ volumes locais para serviços permanentes
  ├─ dados de observabilidade com retenção definida
  ├─ área compartilhada para artefatos e cache
  └─ backups em armazenamento separado

Nós de desenvolvimento
  ├─ disco local para VMs e containers temporários
  └─ montagem compartilhada apenas quando ela é necessária
```

O compartilhamento de rede é adequado para repositórios de trabalho, artefatos de build, imagens e caches que precisam circular entre os nós. Eu não o usaria automaticamente para bancos de dados de serviços críticos apenas para que tudo pareça distribuído.

O mesmo critério explica por que eu não começaria com Ceph. Ele é uma solução distribuída importante, mas seus benefícios dependem de nós e discos que participam continuamente do cluster. Quando dois hosts foram planejados para ficar desligados com frequência, o custo operacional e o modelo de falha deixam de combinar com o problema. O Proxmox suporta tanto storage local quanto compartilhado ou distribuído; a escolha não precisa ser a mesma para todos os ambientes. [A documentação de requisitos do Proxmox](https://www.proxmox.com/en/products/proxmox-virtual-environment/requirements) ajuda a enquadrar essas opções.

## Por que escolhi um orquestrador para workloads que entram e saem

Os nós de desenvolvimento precisam aparecer e desaparecer sem transformar cada mudança de energia em incidente de infraestrutura.

Para os jobs, usei Nomad. O scheduler diferencia jobs de serviço, batch e system, filtra nós não saudáveis e permite restringir a execução com constraints. [A documentação de agendamento do Nomad](https://developer.hashicorp.com/nomad/docs/concepts/scheduling/how-scheduling-works) descreve como o scheduler seleciona nós viáveis; as [constraints de placement](https://developer.hashicorp.com/nomad/docs/concepts/scheduling/placement) funcionam como requisitos rígidos de localização.

No desenho adotado, cada nó recebe uma função por metadado:

```text
node-main  → role = core
node-dev-1 → role = dev
node-dev-2 → role = dev
```

Um serviço permanente declara que só pode rodar no nó `core`:

```hcl
constraint {
  attribute = "${meta.role}"
  value     = "core"
}
```

Um ambiente de desenvolvimento declara o contrário:

```hcl
constraint {
  attribute = "${meta.role}"
  value     = "dev"
}
```

Assim, o scheduler não improvisa o local de um serviço persistente quando um nó de desenvolvimento aparece com mais recursos livres. E um job de desenvolvimento pode ficar pendente enquanto não houver um nó `dev` disponível, em vez de consumir o nó principal por acidente.

Esse comportamento não elimina o planejamento. Ele torna a intenção de cada workload verificável no arquivo de job.

## Desligar um nó é uma operação, não um desaparecimento

O ganho de energia só existe se o ciclo de ligar e desligar for previsível.

Eu trataria esse ciclo como um procedimento explícito:

```text
1. Solicitar o ambiente de desenvolvimento
2. Ligar o nó por Wake-on-LAN ou ação manual
3. Esperar o cliente do orquestrador ficar elegível
4. Criar ou executar os jobs de desenvolvimento
5. Acompanhar logs, recursos e término do trabalho
6. Destruir os recursos temporários
7. Confirmar que não há alocações em execução
8. Desligar o nó
```

Há uma diferença importante entre desligar um host inesperadamente e colocá-lo em manutenção. O Nomad oferece recursos de *drain* e de elegibilidade para retirar um cliente do agendamento antes de uma intervenção. [A referência de elegibilidade de nós](https://developer.hashicorp.com/nomad/commands/node/eligibility) explica esse fluxo.

Para nós de desenvolvimento, eu não desligaria a máquina apenas porque a CPU parece ociosa. Antes, verificaria se ainda existe uma alocação, um teste em andamento, um volume montado ou uma sessão de agente aguardando resposta. Automação sem esse estado pode transformar economia de energia em perda de trabalho.

## Quorum ainda precisa ser planejado

O desenho com hosts intermitentes traz uma consequência para o cluster de virtualização: o comportamento em perda de quorum precisa ser conhecido antes de uma falha.

Durante a operação, observei que não basta ter três máquinas registradas no Proxmox. Se apenas uma volta depois de um reboot ou de uma queda parcial, algumas operações podem exigir intervenção conforme a configuração de quorum e o estado do cluster. Essa é uma área em que “funcionou no primeiro boot” não é validação suficiente.

Eu incluiria no runbook testes controlados para responder perguntas objetivas:

* o que acontece quando apenas o nó principal volta após uma queda de energia?
* quais VMs ou containers iniciam automaticamente?
* quais serviços dependem de armazenamento ou rede já disponíveis?
* como o quorum é restaurado sem introduzir uma configuração permanente inadequada?
* onde está o procedimento para recuperar o nó principal?

O objetivo não é transformar o homelab em uma instalação corporativa. É saber, antes de uma falha, quais ações humanas serão necessárias. Uma arquitetura pequena pode aceitar recuperação manual; o que ela não pode aceitar é recuperação desconhecida.

## Observabilidade serve também para saber quando não ligar uma máquina

Com nós sob demanda, observabilidade não é apenas um painel bonito. Ela ajuda a decidir se vale a pena ativar capacidade extra.

Eu acompanharia no nó principal:

* CPU e memória sustentadas, não apenas picos;
* espaço livre nos volumes persistentes;
* saúde dos serviços permanentes;
* idade e resultado do último backup;
* número de jobs pendentes por falta de nó `dev`;
* tempo entre ligar um nó e ele ficar pronto para receber trabalho.

Essas métricas mostram duas coisas diferentes. A primeira é se o nó principal está saudável. A segunda é se ele já não deveria estar assumindo trabalho de desenvolvimento que merece outro host.

Por exemplo, um job pendente não é necessariamente falha. Pode significar que a política está funcionando: o ambiente só usa recursos de desenvolvimento quando um nó apropriado estiver disponível. A falha estaria em deixar o job parado sem uma forma clara de pedir capacidade ou sem comunicar o motivo para quem o iniciou.

## Começar pelo nó principal reduziu o risco do projeto

Outro benefício do desenho assimétrico é permitir entrega incremental.

Eu não precisava esperar três hosts, storage distribuído e automação completa para começar. O primeiro passo foi fazer o nó principal funcionar com os serviços permanentes, volumes locais, observabilidade básica e backup. Só depois os nós de desenvolvimento entrariam no fluxo de Wake-on-LAN, infraestrutura como código e ambientes efêmeros.

Essa sequência torna o projeto testável em etapas:

| Etapa | Pergunta que ela responde |
| --- | --- |
| Nó principal | Os serviços essenciais continuam operáveis e recuperáveis? |
| Backup e restauração | Consigo recuperar dados, e não apenas gerar arquivos de backup? |
| Primeiro nó de desenvolvimento | Consigo criar, usar e destruir um ambiente sob demanda? |
| Segundo nó de desenvolvimento | A capacidade adicional melhora o trabalho sem complicar a operação? |

O ponto de entrada não é o hardware disponível. É o primeiro serviço que precisa permanecer útil todos os dias.

## Quando esse modelo deixa de fazer sentido

Eu mudaria a arquitetura se os serviços permanentes passassem a ter uma exigência de indisponibilidade muito menor, se mais pessoas dependessem deles continuamente ou se os dados não pudessem ser recuperados dentro de uma janela aceitável.

Também reconsideraria a separação se os nós de desenvolvimento estivessem ligados quase o tempo todo. Nesse caso, a economia desaparece e talvez seja melhor distribuir capacidade, rever o storage ou evoluir para outro modelo de cluster.

Os sinais práticos para reavaliar são:

* restaurações demoradas demais para o impacto de uma falha;
* nó principal operando próximo do limite durante longos períodos;
* tarefas de desenvolvimento aguardando capacidade com frequência;
* dados que precisam estar acessíveis em mais de um host ao mesmo tempo;
* manutenção do nó principal causando interrupções inaceitáveis.

Não existe mérito em manter uma arquitetura pequena quando o problema cresceu. O mérito está em saber qual pressuposto deixou de ser verdadeiro.
