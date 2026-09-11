# O e-mail do Marvin e como gerencio minha infraestrutura em 2026

Published: 2026-08-04
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/email-marvin-gerencio-infraestrutura-2026/
Tags: Homelab, Ansible, Nomad, Observabilidade, Infraestrutura, Agentes

---

> **De:** Marvin<br>
> **Para:** Gilmar<br>
> **Assunto:** [Homelab] Langfuse atualizado para 4.4.0
>
> Gilmar,
>
> O upgrade do Langfuse foi concluído em 2026-08-04.
>
> Estado final:
>
> - Langfuse web/worker: 4.4.0
> - ClickHouse: 25.12.11.4
> - Redis dedicado: 7.2.10, `noeviction` e AOF
> - Modo de dados: `events_only`, sem compatibilidade legada
> - Nomad: deployment saudável, quatro tasks em execução e zero restarts
> - Migrações: nove concluídas, nenhuma pendente e nenhuma falha
> - Histórico validado: 1.380 eventos v4; 660 traces e 718 observations preservados
> - Persistência: LV thin dedicado de 500 GB, com 466 GiB livres
> - Garage: bucket e chave dedicados; escrita confirmada
> - Backup PostgreSQL anterior ao upgrade criado, restore testado e modo `0600`
> - Wiki: páginas de serviço e índice atualizados e verificados
>
> Impacto aceito:
>
> O LiteLLM atual usa Langfuse Python SDK 2.59.7 e pode deixar de enviar novos traces ao endpoint `events_only` até ser modernizado.
>
> Atenção operacional:
>
> O volume de sistema chegou a 94% após os pulls das imagens de migração. O garbage collection do Nomad foi acionado, mas imagens Docker antigas ainda podem exigir limpeza administrativa.
>
> Marvin

![Captura de tela do e-mail de Marvin sobre o upgrade do Langfuse para a versão 4.4.0](/assets/images/langfuse-upgrade-4-4-0-email.png){: .rounded }

Receber esse e-mail é um resultado mais interessante do que receber apenas “deploy concluído”. Ele resume uma mudança de infraestrutura com estado final, evidências, uma limitação aceita e uma pendência operacional.

É assim que tenho procurado administrar meu homelab em 2026: não como uma coleção de máquinas onde entro por SSH para consertar algo, mas como um sistema com estado desejado no Git, aplicação repetível, validação técnica e comunicação explícita depois de mudanças relevantes.

O upgrade do Langfuse para a versão 4.4.0 é um bom exemplo porque reuniu quase todos os componentes dessa prática: Ansible, Nomad, volumes persistentes, migração de dados, backup, storage de objetos, documentação, observabilidade e um agente que transforma a execução em um relatório para revisão humana.

## O repositório não é só um conjunto de playbooks

O centro operacional desse ambiente é o repositório `homelab-ansible`.

Ele contém playbooks de provisionamento e deploy, templates de jobs do Nomad, configurações de serviços, scripts de verificação, testes e documentação que alimenta a Wiki interna. O objetivo não é automatizar toda ação possível. É registrar o estado que quero poder reconstruir e o caminho para aplicá-lo.

Uma visão simplificada da estrutura é esta:

```text
homelab-ansible/
├── playbooks/
│   ├── deploy-langfuse.yml
│   └── provision-langfuse-storage.yml
├── templates/services/
│   └── langfuse.nomad.hcl.j2
├── docs/
│   ├── adr/
│   └── wiki/
├── scripts/
└── tests/
```

O playbook descreve as pré-condições e a configuração de um serviço. O template transforma variáveis em um job do Nomad. A documentação registra o que foi entregue e como operar. Os testes evitam que utilitários importantes se deteriorem silenciosamente.

Há também uma separação intencional entre dois tipos de workload:

* aplicações com repositório próprio, que seguem seu pipeline de entrega;
* serviços compartilhados de infraestrutura, que são declarados e implantados a partir do `homelab-ansible`.

Essa divisão evita colocar a configuração de um serviço de plataforma no mesmo ciclo de vida de uma aplicação comum. Também reduz a tentação de resolver uma manutenção de banco, proxy ou observabilidade com uma alteração ad hoc no servidor.

## O estado desejado precisa declarar versões e limites

No upgrade do Langfuse, as imagens de web, worker, ClickHouse e Redis estão declaradas no playbook. Não há uma instrução genérica para “baixar a última versão”.

```yaml
langfuse_web_image: docker.io/langfuse/langfuse:4.4.0
langfuse_worker_image: docker.io/langfuse/langfuse-worker:4.4.0
langfuse_clickhouse_image: docker.io/clickhouse/clickhouse-server:25.12.11.4
langfuse_redis_image: docker.io/library/redis:7.2.10
```

Fixar versões não elimina o risco de uma atualização. Ele torna a mudança identificável. Quando surge um problema, consigo responder qual conjunto de componentes estava ativo e qual arquivo declarou essa decisão.

O mesmo vale para o modo de dados. O estado final usa `events_only`, sem manter uma camada de compatibilidade para os caminhos legados. Essa é uma decisão de simplificação, mas vem com uma consequência: clientes que ainda dependem do SDK anterior podem deixar de enviar novos traces até serem atualizados.

Eu prefiro registrar essa consequência como impacto aceito do que esconder um modo de compatibilidade indefinidamente. A dívida fica visível, tem um motivo e pode entrar no próximo ciclo de trabalho.

## Upgrade não começa com pull de imagem

Para um serviço com dados, a mudança de versão é apenas uma parte do trabalho. Antes de aplicar o job, o playbook valida se a home do Langfuse está em um volume lógico thin dedicado.

O motivo é direto: ClickHouse, dados temporários e imagens de containers podem crescer rápido. Deixar esse conjunto crescer sobre o volume de sistema do host transforma uma atualização de aplicação em risco para a máquina inteira.

O serviço passou a usar um volume dedicado de 500 GB. Ao final do upgrade, havia 466 GiB livres. Essa informação é melhor do que saber apenas que o processo terminou sem erro: ela mostra que existe margem para operar e que a persistência está no local planejado.

A divisão que procuro manter é simples:

```text
volume de sistema
  → sistema operacional, ferramentas e espaço controlado

volume dedicado do serviço
  → dados persistentes, logs e crescimento esperado

backup independente
  → recuperação após falha ou decisão ruim
```

O playbook falha se o volume dedicado não estiver montado. Esse tipo de bloqueio é valioso porque transforma uma convenção de arquitetura em uma pré-condição executável.

## Backup útil é backup restaurado

Antes de uma migração relevante, foi criado um dump PostgreSQL com permissões restritas. Isso é o começo, não o fim da proteção.

O playbook também restaura o arquivo em um banco temporário e verifica o resultado. Só então o backup passa a ser evidência de recuperação possível.

Eu tento seguir uma regra simples: um backup que nunca foi restaurado é uma hipótese.

Na prática, a validação respondeu a perguntas concretas:

* o arquivo foi realmente produzido?
* ele pode ser lido pelo `pg_restore`?
* o conteúdo consegue ser restaurado sem erro?
* as tabelas esperadas estão presentes depois da restauração?
* o arquivo não ficou acessível a qualquer usuário do host?

Esse cuidado aumenta o tempo do deploy, mas diminui muito a incerteza. Em uma atualização de dados, a parte difícil não é executar a migração quando tudo funciona. É saber o que fazer quando ela não funciona como esperado.

## O Nomad é a camada de execução, não a única evidência

Depois de preparar armazenamento e configuração, o Ansible renderiza o job do Nomad e o aplica. O job agrupa quatro tasks: web, worker, ClickHouse e Redis.

Cada uma tem seu próprio health check. A aplicação web só entra como saudável quando responde ao endpoint de prontidão; o worker, o banco analítico e o Redis também são verificados de forma independente.

Esse desenho é importante porque “a alocação está rodando” pode esconder uma dependência que ainda não está pronta. O estado final do e-mail traz quatro tasks em execução e zero restarts, mas essa informação vem acompanhada das outras evidências: migrações concluídas, dados preservados e escrita no storage de objetos confirmada.

O Redis, por exemplo, foi configurado com AOF e política `noeviction`. A intenção é preservar um log de operações e evitar que o serviço descarte silenciosamente chaves quando atinge o limite de memória. Se não houver espaço, prefiro uma falha observável a uma perda invisível de estado.

Com [`noeviction`](https://redis.io/docs/latest/develop/reference/eviction/), o Redis preserva as chaves existentes, mas pode rejeitar novas escritas quando atinge o limite de memória, por isso essa configuração ainda exige monitoramento.

## Contar os dados faz parte da migração

Uma migração pode terminar com código de saída zero e ainda assim deixar para trás dados que deveriam estar disponíveis.

Por isso, a validação não parou no estado do deployment. Ela conferiu o histórico após o upgrade: 1.380 eventos no modelo v4, com 660 traces e 718 observations preservados.

Essas contagens não provam sozinhas que cada evento foi convertido perfeitamente. Elas são uma verificação de sanidade que reduz o risco de aceitar uma migração vazia, truncada ou apontando para o banco errado.

Em uma mudança desse tipo, eu procuraria três níveis de evidência:

| Nível | Pergunta | Exemplo |
| --- | --- | --- |
| Runtime | O serviço está vivo? | tasks saudáveis e sem reinícios |
| Estrutura | A migração terminou? | passos concluídos, sem pendências ou falhas |
| Conteúdo | Os dados esperados existem? | contagens, consultas e amostras verificadas |

O upgrade só fica aceitável quando os três níveis estão presentes.

## Documentação é uma etapa de deploy

No `homelab-ansible`, um deploy não é considerado completo sem atualização da Wiki. Para o Langfuse, a página do serviço e o índice de serviços foram atualizados e verificados.

Essa regra parece burocrática quando tudo está funcionando. Ela deixa de parecer quando alguém precisa entender, semanas depois, qual versão está em operação, onde ficam os dados, como o backup é feito ou qual compatibilidade foi retirada.

Eu não quero que essas respostas dependam de procurar mensagens antigas ou de lembrar qual máquina recebeu uma alteração manual. A documentação deve apontar para o estado que o playbook aplica e para os procedimentos de recuperação que foram testados.

O e-mail do Marvin fecha esse ciclo. Ele não substitui a Wiki nem o Git. Ele comunica que uma operação relevante terminou, quais evidências foram observadas e o que ainda precisa de atenção.

## Agentes executam; pessoas aceitam consequências

Marvin é a identidade operacional que uso para agentes dentro desse ambiente. Isso ajuda a distinguir um relatório gerado após uma execução de uma decisão humana sobre risco e prioridade.

O agente pode preparar um plano, alterar um playbook, executar validações, atualizar documentação e enviar o resumo. Ainda assim, duas partes do e-mail continuam exigindo julgamento:

* aceitar que o LiteLLM antigo pode não produzir novos traces enquanto sua integração não for modernizada;
* decidir como limpar imagens antigas sem remover algo que o host ainda precisa para recuperar ou iniciar serviços.

Essa fronteira é importante. Um agente pode mostrar que um volume de sistema chegou a 94%, mas não deveria receber uma autorização genérica para apagar tudo que parece antigo.

No caso das imagens, eu começaria por inventário: espaço usado, camadas não referenciadas, jobs que ainda podem precisar de rollback e impacto de remover cache. O garbage collection do Nomad ajuda, mas não assume a responsabilidade de uma limpeza administrativa de imagens Docker. A ação precisa ser deliberada porque liberar espaço hoje não pode criar um atraso ou uma indisponibilidade inesperada amanhã.

## O que o alerta de disco realmente diz

O alerta sobre o volume de sistema é uma parte importante do relatório, não uma nota de rodapé inconveniente.

Durante a migração, pulls de imagens aumentaram o uso do `pve-root` para 94%. O dado persistente do Langfuse está protegido no volume dedicado, mas o host ainda precisa de espaço para imagens, logs e operações normais.

Eu interpreto esse alerta como uma mudança de estado operacional:

```text
upgrade concluído
      ↓
serviço saudável
      ↓
capacidade do host reduzida
      ↓
inventário e limpeza planejada
```

Não como um motivo para declarar o deploy inválido, mas também não como algo que pode ser esquecido. A pendência deve ter um responsável, uma janela de ação e uma validação posterior de espaço livre.

Essa é uma das razões para o relatório ter uma seção de atenção operacional. Uma infraestrutura gerenciável não é aquela que nunca produz pendências. É aquela que não deixa pendências importantes escondidas atrás de uma mensagem verde.

## A gestão de infraestrutura em 2026 é um sistema de evidências

No meu caso, o fluxo completo fica próximo disto:

```text
Decisão e mudança no Git
        ↓
Playbook idempotente e pré-condições verificáveis
        ↓
Renderização e aplicação do job no Nomad
        ↓
Health checks, migrações e validação de dados
        ↓
Backup restaurado em ambiente temporário
        ↓
Wiki atualizada
        ↓
Relatório operacional do agente
        ↓
Aceite humano de riscos e pendências
```

Nem todas as operações precisam desse nível de cuidado. Alterar uma variável sem efeito em dados persistentes é diferente de mover uma plataforma de observabilidade para um novo modelo de eventos.

Mas, quanto maior for o impacto em dados, disponibilidade ou segurança, menos eu aceito “funcionou na minha sessão” como critério de conclusão.

## Conclusão

O upgrade do Langfuse terminou com quatro tasks saudáveis, dados históricos preservados, backup restaurado, storage dedicado e documentação atualizada. Isso é o resultado técnico.

O e-mail também registrou o que não terminou: a modernização do LiteLLM para voltar a enviar traces no modo `events_only` e a limpeza planejada do volume de sistema depois dos pulls de migração. Isso é o resultado operacional.

É essa combinação que procuro manter no meu homelab: Git para declarar, Ansible para repetir, Nomad para executar, testes e observabilidade para verificar, documentação para preservar contexto, agentes para acelerar o ciclo e uma pessoa para aceitar as consequências que não devem ser automatizadas.
