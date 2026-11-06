# Dar ferramentas à IA não é dar autorização

Published: 2026-10-29
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/dar-ferramentas-a-ia-nao-e-dar-autorizacao/
Tags: Agentes de IA, MCP, Segurança, Arquitetura de software, Autorização

---

Imagine um assistente conectado ao sistema financeiro de uma empresa.

O usuário pergunta quanto vendeu no mês. O assistente consulta os dados e apresenta o resultado.

Depois, pergunta quais clientes estão inadimplentes. O assistente faz outra consulta, organiza as informações e responde.

Até aqui, estamos usando um modelo de linguagem como interface para consultar um sistema.

Mas então vem um terceiro pedido:

"Envie uma cobrança para todos esses clientes."

A conversa continua acontecendo na mesma interface. Para o usuário, parece apenas mais uma instrução.

Do ponto de vista da arquitetura, porém, alguma coisa importante mudou.

O assistente deixou de apenas consultar informações e passou a solicitar uma operação que produz efeitos fora da conversa.

**É nessa passagem, da resposta para a ação, que considero estar uma das decisões mais importantes da arquitetura de agentes.**

## Uma API disponível não é uma autorização

Durante muito tempo, projetamos interfaces para pessoas operarem sistemas. Construímos telas, formulários, botões e fluxos de confirmação.

Agora podemos oferecer essas mesmas capacidades diretamente a agentes de IA.

Protocolos como o [MCP](/artigos/mcp/) facilitam essa integração. Um agente pode descobrir ferramentas, consultar informações e solicitar operações sem precisar navegar pela interface gráfica.

Mas disponibilizar uma ferramenta não resolve a questão de quem está autorizado a utilizá-la.

No exemplo financeiro, consultar inadimplência e enviar cobranças são capacidades diferentes.

A primeira exige acesso a informações. A segunda pode produzir consequências comerciais, financeiras e até jurídicas.

Não gostaria que essa distinção dependesse apenas de uma instrução dizendo ao modelo para tomar cuidado.

Se um agente não tem autorização para enviar cobranças, a ferramenta responsável pelo envio deve impedir a operação.

O modelo pode decidir solicitar uma ação. O sistema precisa decidir se aceita executá-la.

Essa separação é importante porque modelos de linguagem não são mecanismos de controle de acesso.

Eles interpretam instruções, trabalham com contexto e podem cometer erros. Permissões e regras de negócio precisam continuar sendo verificadas por componentes que ofereçam garantias mais previsíveis.

## Nem toda decisão precisa de um agente

Há também uma tendência de transformar qualquer automação em uma solução agêntica.

Se o sistema precisa calcular o total vendido no mês, uma consulta SQL resolve o problema.

Se precisa identificar títulos vencidos, regras convencionais conseguem fazer isso.

Não vejo vantagem em entregar essas operações a um modelo de linguagem para que ele descubra, a cada execução, como realizar cálculos que já são conhecidos.

O agente começa a acrescentar valor quando precisa interpretar uma solicitação, escolher entre capacidades disponíveis ou lidar com situações que não cabem facilmente num fluxo predefinido.

Mesmo nesses casos, prefiro que a execução continue apoiada em operações explícitas.

O agente pode interpretar o pedido "quero entender por que a inadimplência aumentou" e decidir quais consultas realizar.

Mas [os cálculos, os filtros e as regras de acesso continuam pertencendo ao sistema](/posts/o-llm-pode-decidir-o-calculo-nao-deveria-ser-a-calculadora/).

Essa divisão evita que a IA precise reconstruir regras de negócio dentro do prompt.

Também facilita os testes. Posso verificar separadamente se a consulta produz o resultado correto e se o agente escolhe a consulta adequada.

**Nem tudo que o agente consegue fazer precisa ser delegado ao modelo.**

## A informação pode estar errada

Outro problema aparece quando o agente utiliza informações para decidir o próximo passo.

Suponha que ele encontre uma cobrança vencida e recomende entrar em contato com o cliente.

E se o pagamento tiver sido realizado há poucos minutos, mas ainda não estiver conciliado?

O agente pode ter consultado corretamente o sistema e chegado a uma conclusão inadequada porque os dados disponíveis estavam desatualizados.

Não basta saber qual informação foi recuperada. É importante conhecer sua origem, seu momento de atualização e as condições em que pode ser considerada válida.

Esse cuidado ganha importância quando a informação deixa de sustentar apenas uma resposta e passa a justificar uma operação.

Antes de enviar a cobrança, por exemplo, o sistema poderia verificar novamente a situação do título.

A checagem não precisa ser feita pelo modelo. Pode ser uma regra convencional executada no momento da operação.

Isso reduz a dependência da capacidade do agente de perceber sozinho que uma informação merece confirmação.

Também ajuda a separar duas responsabilidades: interpretar o que deve ser feito e garantir que as condições para fazer aquilo continuam válidas.

## Autonomia precisa ter limites diferentes para ações diferentes

Não acredito que a autonomia de um agente deva ser tratada como uma configuração única: ligado ou desligado, autônomo ou supervisionado.

Ela depende do que está sendo executado.

No exemplo financeiro, eu permitiria que o agente consultasse informações dentro das permissões concedidas e preparasse propostas de cobrança.

O envio efetivo poderia exigir aprovação.

Em outro cenário, a empresa poderia autorizar cobranças automáticas de determinados tipos, respeitando limites e regras previamente definidos.

O importante é que a autorização pertença à operação, não à confiança que alguém deposita no modelo.

Também considero o impacto de uma decisão e a dificuldade de desfazê-la.

Uma consulta equivocada pode produzir uma resposta incorreta. Uma cobrança enviada indevidamente já alcançou outra pessoa. Cancelar a operação no sistema não faz o destinatário deixar de ter recebido a mensagem.

Isso significa que interromper, reverter e compensar são problemas diferentes.

Um agente pode ser interrompido antes da próxima ação. Uma operação concluída talvez possa ser revertida. Outras exigirão uma medida compensatória.

Essas possibilidades precisam fazer parte do desenho do sistema.

## Executar não é concluir

Existe uma diferença que considero especialmente importante nas integrações: a diferença entre solicitar uma operação e confirmar seu resultado.

Uma API pode responder que aceitou o envio de uma mensagem.

Isso não significa necessariamente que a mensagem foi entregue.

Da mesma forma, registrar uma solicitação de pagamento não significa que o pagamento foi realizado.

Um agente que recebe uma resposta de sucesso e imediatamente comunica ao usuário que a operação terminou pode estar antecipando uma conclusão.

Por isso, prefiro tratar operações com efeitos externos como processos cujo estado precisa ser acompanhado.

A solicitação foi recebida? Foi executada? Houve confirmação? Pode ser repetida sem gerar duplicidade?

Essas perguntas são familiares na engenharia de sistemas distribuídos.

Agentes não eliminam esses problemas. Na verdade, podem torná-los mais frequentes, porque passam a decidir quando solicitar operações e quando tentar novamente.

Uma integração confiável precisa oferecer ao agente maneiras de verificar o resultado sem depender de uma interpretação otimista da resposta anterior.

## Quem responde pelo que o agente faz?

Quando um agente recebe uma ferramenta, estamos criando uma nova maneira de acionar uma capacidade que já possui regras, responsabilidades e consequências.

Não deveríamos enfraquecer essas regras apenas porque a solicitação agora chega por linguagem natural.

Também não precisamos colocar uma pessoa aprovando cada pequena operação. Isso eliminaria parte do benefício da automação.

O que precisamos é decidir antecipadamente quais operações podem acontecer automaticamente, quais exigem confirmação e quais não devem estar disponíveis.

E registrar o suficiente para compreender o que aconteceu.

Quem solicitou a ação? Quais dados foram utilizados? Qual operação foi executada? O que o sistema confirmou?

Sem essas respostas, fica difícil investigar erros e ampliar a autonomia com segurança.

Acredito que boa parte da engenharia de agentes será menos sobre criar prompts capazes de tomar decisões e mais sobre construir ambientes nos quais essas decisões possam ser executadas, verificadas e limitadas.

A interface pode continuar sendo uma conversa. Mas, atrás dela, continuam existindo sistemas com estados, permissões, transações e responsabilidades.

**Um agente pode decidir o que solicitar. A arquitetura determina o que ele realmente consegue fazer.**
