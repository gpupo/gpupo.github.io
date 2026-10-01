# Não crie um agente que saiba a empresa inteira

Published: 2026-10-01
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/nao-crie-um-agente-que-saiba-a-empresa-inteira/
Tags: Agentes de IA, Arquitetura de software, Gestão de contexto, Orquestração

---

Quando uma empresa começa a trabalhar com agentes de IA, aparece rapidamente
uma ambição compreensível:

> **Vamos criar um agente que conheça a empresa inteira.**

Produtos, clientes, processos, documentos, comercial, financeiro, operação,
pós-venda, contratos e pessoas.

Parece eficiente. Em vez de decidir qual agente deve receber uma tarefa, basta
perguntar tudo ao mesmo lugar.

Na prática, eu não começaria assim.

O problema não é permitir que um sistema consulte várias fontes da empresa. O
problema é presumir que um único agente deve manter todos esses domínios,
instruções e exceções ativos ao mesmo tempo e decidir sozinho como conciliá-los.

## O problema não é só tamanho

Modelos têm uma janela de contexto limitada. Mesmo quando a informação cabe
nessa janela, ainda precisamos decidir o que merece estar presente em cada
tarefa.

Um material da OpenAI sobre
[engenharia de contexto](https://developers.openai.com/cookbook/examples/agents_sdk/session_memory)
descreve o equilíbrio: contexto demais pode causar distração, ineficiência ou
falhas; contexto de menos pode fazer o agente perder coerência. A implicação que
tiro disso não é que toda instrução adicional piora o resultado. É que contexto
precisa de seleção.

Quanto mais regras, documentos e exceções colocamos no mesmo agente, mais
difícil fica saber qual parte interferiu numa decisão ruim. Também aumentam o
custo de execução e o trabalho necessário para testar mudanças.

Foi por isso que, numa conversa recente, resumi de forma simples:

> **Se eu quiser fazer um agente que saiba a empresa inteira, não vai dar
> certo.**

Não quero dizer que exista uma incapacidade absoluta de consultar conhecimento
corporativo amplo. O risco está em tentar transformar todo esse conhecimento em
contexto permanente de uma única unidade de trabalho.

## Acesso não é contexto ativo

Um agente pode ter acesso autorizado a uma base extensa sem receber a base
inteira em toda solicitação.

Ele pode conhecer as fontes disponíveis e consultar apenas o que a tarefa
exige:

```text
solicitação comercial
        ↓
identificar as fontes necessárias
        ↓
consultar CRM + política de preços
        ↓
responder com o contexto recuperado
```

Outra tarefa pode usar fontes diferentes:

```text
revisão de contrato
        ↓
modelo contratual + cláusulas aprovadas
        ↓
análise
```

Nos dois casos, o conhecimento continua acessível. Ele apenas não ocupa o
contexto quando não é relevante.

Essa distinção também ajuda com permissões. Um agente não precisa receber acesso
de escrita a todos os sistemas apenas porque talvez um dia execute uma tarefa
relacionada a eles. Ferramentas e fontes podem ser disponibilizadas conforme a
responsabilidade e o risco de cada fluxo.

## Pense em especialização

Uma forma melhor de começar é pensar no agente como alguém especializado.

Um agente pode cuidar de um processo comercial. Outro pode gerar documentos.
Outro pode apoiar uma operação específica.

Cada um possui:

```text
responsabilidade clara
contexto necessário
regras próprias
ferramentas
fontes relevantes
permissões
saídas esperadas
```

Isso reduz a quantidade de informação que precisa estar ativa ao mesmo tempo.
Também torna mais fácil explicar o que deveria acontecer, construir casos de
teste e perceber quando o resultado começa a piorar.

Especialização não exige imediatamente vários processos ou modelos. Podemos
começar com um único agente e separar instruções, fontes, ferramentas e
artefatos por responsabilidade. A fronteira lógica vem antes da decisão de
executar cada parte como um agente independente.

## Mas também não divida demais

Existe uma armadilha no sentido contrário.

Quando percebemos que especialização funciona, surge a vontade de criar um
agente para cada pequena ação:

- um para consultar o CRM;
- outro para escrever um e-mail;
- outro para gerar uma tabela;
- outro para revisar a tabela;
- outro para salvar o arquivo.

Logo temos dezenas de agentes e ninguém mais sabe quem responde pelo resultado
final.

Na reunião, quando surgiu a pergunta “quanto mais agentes eu dividir, melhor?”,
minha resposta foi:

**há um ponto de equilíbrio.**

Cada separação cria contratos, transferências de contexto, tratamento de erro,
observabilidade e manutenção. Se esses custos forem maiores do que o ganho de
foco, a divisão piora a arquitetura.

## Use o mesmo teste que usaria com uma pessoa

Gosto de fazer uma pergunta simples:

> **Eu daria essas responsabilidades para a mesma pessoa?**

Se sim, elas provavelmente podem começar no mesmo agente. Se a resposta passar
a ser “isso já parece dois trabalhos diferentes”, talvez exista uma divisão
natural.

Por exemplo:

```text
consultar informações
+
gerar relatório
```

Essas responsabilidades podem pertencer ao mesmo trabalho. Um agente consulta
fontes conhecidas, organiza os dados e produz uma saída reconhecível.

Mas, se esse fluxo crescer, acumular regras incompatíveis ou falhar de maneira
recorrente, podemos separar:

```text
agente de análise
        ↓
dados estruturados
        ↓
agente de documentos
```

Nesse desenho, a divisão tem um contrato visível: o primeiro entrega dados
estruturados; o segundo transforma esses dados num documento. Ainda será
necessário decidir quem valida a passagem e o que acontece quando a entrada
está incompleta.

A arquitetura pode evoluir quando a necessidade aparecer. Não precisamos
prever todas as fronteiras no primeiro dia.

## Quando manter responsabilidades juntas

Eu começaria com o mesmo agente quando:

- as tarefas perseguem o mesmo objetivo;
- usam fontes e regras semelhantes;
- uma etapa depende diretamente do raciocínio da anterior;
- existe uma saída final pela qual uma única unidade pode responder;
- o custo de transferir contexto seria maior do que o ganho de isolamento.

Separar papéis continua útil mesmo nesse cenário. Planejamento, execução e
revisão podem produzir artefatos distintos sem exigir três agentes. Essa é a
diferença discutida em
[Um agente ou vários? O que muda ao separar responsabilidades](/posts/multiplos-agentes-especializados/).

## Organize para poder separar depois

Mesmo quando mantemos responsabilidades juntas, podemos organizar os artefatos
de maneira que uma futura divisão seja mais simples:

```text
projeto/
├── dados/
├── analises/
├── documentos/
└── output/
```

Se amanhã uma dessas áreas ganhar complexidade suficiente para justificar um
agente próprio, parte da separação já estará preparada.

Também ajuda manter formatos explícitos entre as áreas. Uma análise salva em
dados estruturados pode ser consumida por outro processo com menos ambiguidade
do que uma conclusão escondida no histórico de uma conversa.

Isso é mais saudável do que desenhar dezenas de agentes antes de descobrir
onde estão os limites reais do trabalho.

## Compartilhe capacidades, não todo o contexto

Agentes especializados não precisam viver isolados. Eles podem compartilhar:

- Skills;
- regras corporativas aplicáveis a todos;
- referências para fontes oficiais;
- schemas;
- templates;
- bases de conhecimento.

Compartilhar uma capacidade não significa colocar todo o conhecimento da
empresa dentro de cada agente.

Um agente comercial pode saber **como consultar** determinada fonte sem
carregar permanentemente tudo que existe nela. Uma
[Skill pode empacotar essa capacidade](/posts/uma-skill-e-muito-menos-magica-do-que-parece/),
enquanto a ferramenta recupera apenas os dados necessários para a tarefa.

Regras realmente universais podem ficar no contexto comum. Conhecimento de
domínio, instruções ocasionais e grandes conjuntos de documentos podem ser
carregados sob demanda.

## O sinal para dividir

Eu não dividiria um agente apenas porque ele parece grande. Observaria seu
comportamento em tarefas representativas.

Alguns sinais:

- falhas recorrentes concentradas num tipo de trabalho;
- instruções importantes sendo ignoradas;
- contexto crescendo continuamente;
- tarefas muito diferentes disputando as mesmas regras e ferramentas;
- permissões amplas demais para parte das solicitações;
- dificuldade para explicar claramente a responsabilidade do agente;
- saídas que já precisam de contratos e validações independentes.

Um sinal isolado não decide a arquitetura. Instruções ignoradas, por exemplo,
podem indicar um prompt ruim ou uma regra contraditória, não necessariamente a
necessidade de outro agente.

Antes de dividir, eu registraria os casos que falham e compararia o fluxo atual
com uma separação pequena. O critério seria observar qualidade, custo, tempo e
trabalho de coordenação. Sem essa comparação, podemos apenas trocar um agente
confuso por vários agentes difíceis de manter.

## O objetivo não é ter muitos agentes

Também não é ter poucos.

O objetivo é ter **agentes compreensíveis**.

Um agente deve ser especializado o suficiente para manter foco, mas amplo o
suficiente para executar um trabalho coerente de ponta a ponta.

Por isso, em vez de começar perguntando:

> **Quantos agentes nossa empresa precisa?**

prefiro outra pergunta:

> **Quais trabalhos fazem sentido existir como unidades independentes?**

A arquitetura aparece a partir daí.

Não tente criar um cérebro artificial que mantenha a empresa inteira ativa ao
mesmo tempo. Crie bons especialistas e deixe que consultem apenas aquilo de que
precisam para concluir cada trabalho.
