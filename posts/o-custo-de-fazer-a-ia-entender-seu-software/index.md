# O custo de fazer a IA entender seu software

Published: 2026-10-29
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/o-custo-de-fazer-a-ia-entender-seu-software/
Tags: Agentes de IA, Arquitetura de software, Custos, Contexto, Engenharia de software

---

Peça a um agente de IA para fazer uma pequena alteração numa aplicação. Talvez mudar uma regra de validação, acrescentar um campo ou corrigir um comportamento.

A alteração pode exigir poucas linhas de código. Mesmo assim, o agente começa lendo arquivos, procurando referências, investigando dependências e tentando descobrir como o sistema funciona.

Às vezes, depois de consumir milhares de tokens, finalmente encontra o lugar certo para fazer a mudança.

Na sessão seguinte, diante de outra tarefa, parte desse trabalho começa novamente.

É fácil olhar para esse processo e concluir que estamos gastando tokens demais. Mas a pergunta que me interessa é outra: **por que foi necessário tanto trabalho para entender uma alteração tão pequena?**

Talvez estejamos pagando para a IA descobrir relações que a própria arquitetura deveria tornar evidentes.

## O código não se explica sozinho

Uma das promessas dos agentes de programação é que podemos entregar uma tarefa e deixar que eles investiguem o repositório, encontrem os arquivos necessários e implementem a solução.

Isso funciona. Mas investigar um sistema tem custo.

Imagine uma regra de negócio distribuída entre o backend, o frontend e alguns processos auxiliares. Para um desenvolvedor familiarizado com o projeto, essas relações podem fazer parte do conhecimento acumulado ao longo dos meses.

Para um agente iniciado numa sessão nova, elas precisam ser descobertas.

Ele procura referências, lê implementações e tenta reconstruir as dependências entre os componentes. Quando as responsabilidades estão misturadas ou dependem de convenções não documentadas, essa investigação cresce.

Não estamos diante de um problema novo. Desenvolvedores também gastam tempo compreendendo sistemas.

A diferença é que uma pessoa preserva parte desse conhecimento entre tarefas, enquanto um agente frequentemente precisa receber ou recuperar o contexto novamente.

Com IA, parte desse esforço passa a aparecer como consumo de tokens.

Se uma mudança exige menos contexto para ser compreendida, isso pode indicar uma arquitetura mais fácil de modificar. É uma hipótese interessante, mas eu teria cuidado ao transformar o consumo de tokens numa métrica direta de qualidade.

## Tokens não medem arquitetura

O consumo de tokens depende de muitas coisas além do código.

O modelo escolhido, a maneira como utiliza ferramentas, o histórico da conversa e a quantidade de tentativas podem alterar bastante o resultado.

Um agente pode consumir menos tokens simplesmente porque recebeu menos informações. Isso não significa que tenha compreendido melhor o problema. Talvez tenha deixado de examinar uma dependência importante.

Também posso reduzir o consumo impedindo que execute verificações adicionais. A conta diminui, mas o risco pode aumentar.

Para mim, o indicador mais interessante seria o **custo para concluir uma mudança corretamente**.

Isso inclui investigação, implementação, testes, correções e revisão.

Um agente que consome mais tokens porque executou testes relevantes pode ser mais econômico do que outro que produziu uma resposta curta e deixou um defeito para alguém encontrar depois.

O consumo continua sendo útil. Só precisa ser interpretado junto com o resultado.

## O agente não precisa conhecer a empresa inteira

Nos meus trabalhos com agentes, tenho dado bastante atenção a arquivos de instrução, como [`AGENTS.md`](/artigos/agents-md-nao-e-um-readme/), e a maneiras de preservar decisões entre sessões.

A ideia não é criar uma enciclopédia sobre o projeto e entregá-la inteira ao modelo.

É justamente o contrário.

Um agente precisa entender qual tarefa deve executar, quais restrições deve respeitar, onde procurar informações relevantes e como verificar se terminou.

Isso exige selecionar contexto.

Um arquivo `AGENTS.md` pode apresentar a organização do repositório, os comandos de teste e as regras fundamentais de desenvolvimento. Documentações específicas permanecem separadas, disponíveis quando necessárias.

O mesmo vale para decisões arquiteturais. Se uma equipe decidiu não adicionar determinada dependência, não é necessário reconstruir toda a discussão a cada nova sessão.

**Guardar conhecimento não significa colocar todo o conhecimento na janela de contexto.**

A informação pode estar no repositório, numa base de conhecimento ou em outro armazenamento persistente. O importante é conseguir recuperá-la quando se tornar relevante.

Essa distinção muda a responsabilidade de quem desenvolve sistemas com agentes.

Não basta escolher um bom modelo. É preciso projetar o ambiente em que ele trabalha.

## O custo de começar novamente

Uma característica dos agentes é que suas sessões podem ser temporárias. O contexto usado para resolver um problema hoje talvez não esteja disponível amanhã.

Esse comportamento me levou a valorizar algo bastante simples: [checkpoints](/posts/versionar-e-criar-checkpoints/).

Quando uma tarefa exige várias etapas, algumas informações deveriam sobreviver à conversa.

O que foi decidido? O que já foi implementado? Quais testes foram executados? O que falta verificar?

Essas informações podem ser preservadas em arquivos versionados, planos de execução ou outros mecanismos persistentes.

Na sessão seguinte, o agente recupera o estado necessário e continua a partir dele.

O objetivo não é eliminar a investigação, mas evitar que ela precise recomeçar continuamente.

Isso também vale para as ferramentas utilizadas pelo agente.

Se uma consulta retorna centenas de informações, mas a decisão depende de apenas três, por que enviar tudo ao modelo?

Filtros, consultas e transformações convencionais podem preparar os dados antes de entregá-los à IA.

Há uma diferença importante entre **dar acesso à informação e colocar toda a informação dentro do prompt**.

Menos dados irrelevantes podem significar menor consumo, mas também menos distrações durante a execução.

## A arquitetura continua importando

É tentador imaginar que modelos cada vez mais capazes tornarão desnecessários alguns cuidados tradicionais de engenharia.

Se a IA consegue compreender um sistema complexo, por que dedicar tanto esforço à organização do código?

Porque compreender não é a mesma coisa que modificar com segurança.

Um agente pode identificar que uma regra está espalhada por vários componentes. Isso não elimina as dependências entre eles.

Uma arquitetura com responsabilidades claras ajuda tanto quem escreve código manualmente quanto quem delega tarefas a agentes.

E o ganho não vem simplesmente de ter menos arquivos ou menos linhas.

Às vezes, separar responsabilidades aumenta a quantidade de código, mas reduz o conhecimento necessário para modificar uma parte específica do sistema.

Um módulo com dependências explícitas e testes próprios pode ser mais fácil de compreender do que uma função curta que depende de comportamentos espalhados pela aplicação.

O mesmo problema aparece quando um desenvolvedor novo entra no projeto.

**A IA não elimina o custo da complexidade. Em muitos casos, apenas muda a maneira como pagamos por ela.**

## O custo que realmente me preocupa

Quando penso no uso de IA em desenvolvimento, não quero apenas saber quanto custa uma chamada ao modelo.

Quero entender quanto trabalho é necessário para transformar uma intenção em uma mudança confiável.

Uma tarefa pode parecer barata porque o modelo gerou código rapidamente. Mas talvez ainda exija uma revisão extensa ou várias correções.

Outra pode consumir mais tokens e entregar uma implementação acompanhada de testes e evidências suficientes para facilitar a revisão.

Comparar apenas a fatura dessas tarefas seria pouco informativo.

Também não atribuiria automaticamente um consumo elevado a problemas de arquitetura.

Às vezes, a tarefa é difícil. Às vezes, o agente está mal configurado. Às vezes, as ferramentas devolvem informações demais. E, em outras situações, o código é realmente complicado de alterar.

Antes de propor uma refatoração para reduzir tokens, eu procuraria entender onde o esforço está sendo gasto.

O agente está relendo os mesmos arquivos? Está repetindo investigações anteriores? Precisa atravessar muitos módulos para executar uma alteração localizada?

Cada resposta aponta para uma intervenção diferente.

Algumas envolvem arquitetura de software. Outras envolvem organização do conhecimento, ferramentas ou o próprio ambiente de execução do agente.

O objetivo não é produzir software que consuma o menor número possível de tokens.

É construir sistemas em que pessoas e agentes consigam trabalhar sem precisar redescobrir continuamente o que já deveria estar claro.

**Se a IA precisa reaprender o projeto a cada mudança, talvez o problema não seja quanto custa a inteligência. Seja quanto custa a falta de organização do conhecimento.**
