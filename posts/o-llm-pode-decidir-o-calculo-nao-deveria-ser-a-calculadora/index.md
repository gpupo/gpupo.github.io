# LLMs e cálculos: o modelo interpreta, o software soma

Published: 2026-08-20
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/o-llm-pode-decidir-o-calculo-nao-deveria-ser-a-calculadora/
Tags: Agentes de IA, LLM, Engenharia de software, Confiabilidade, Orquestração

---

Nos dois primeiros textos, organizei a arquitetura em torno de três conceitos:

**Agent decide.**

**Crew colabora.**

**Flow controla.**

Falta uma camada que não deveria ficar implícita:

**software garante.**

Essa conclusão veio de um caso de análise de um agente financeiro. A ferramenta
retornou registros, mas o modelo recebeu dezenas de linhas e fez a soma em
texto livre. A mesma pergunta, repetida seis vezes para a mesma conta, gerou
seis valores diferentes; nenhum era o correto.

O problema não era apenas de estilo de resposta. A definição de “não vencido”,
o tratamento da data atual e o limite de paginação também precisavam estar
fechados no contrato da ferramenta. Esses pontos pertenciam à camada de dados e
execução, não ao número de Agents dentro da Crew.

## Quando os dados estão certos e a conclusão está errada

Imagine uma Tool que consulta registros financeiros. Ela não falha, não perde
linhas e retorna os dados que pediu.

Então o Agent recebe:

```text
10
20
30
```

e precisa responder ao usuário. Se o modelo calcula em texto, uma execução pode
produzir `60`, outra `50` e uma terceira `70`.

O exemplo é propositalmente pequeno. O ponto não é a dificuldade da soma. É a
propriedade esperada:

**mesma entrada, mesma saída.**

Isso é um `Deterministic Step`.

Uma soma, uma contagem, uma comparação, uma ordenação e uma regra de data não
precisam de criatividade. Elas precisam de uma implementação que possa ser
executada, testada e auditada.

## Retry não é verificação

É tentador corrigir uma resposta errada com:

> tente novamente.

Mas uma nova geração é outra inferência. Ela pode produzir outro número sem
criar qualquer relação confiável com o resultado anterior.

Também não basta acrescentar uma frase:

```text
LLM calcula
    ↓
LLM confere
    ↓
✓ validado
```

O segundo LLM pode criticar a explicação, mas continua sem uma fonte
independente para provar a aritmética. O selo mudou; a natureza do processo não.

## O modelo pode decidir o que precisa ser calculado

Isso não significa retirar o LLM do processo. A pergunta:

> Quanto tenho em aberto e ainda não vencido?

pode ser transformada em uma intenção estruturada:

```json
{
  "status": "open",
  "due_date": {"greater_than_or_equal": "today"},
  "operation": "sum",
  "field": "original_amount"
}
```

Interpretar variações como “o que ainda falta pagar?” ou “qual é minha
exposição até o fim do mês?” é uma parte semântica do problema. O modelo pode
propor o filtro, o período, o campo e a operação.

Mas esse resultado ainda é uma proposta. Antes de executar, o software precisa
validar o schema, limitar campos e operações permitidos e aplicar a regra de
negócio para datas. O LLM não deve decidir sozinho se “hoje” entra no conjunto
de não vencidos.

Depois disso, o runtime executa:

```text
SUM(original_amount)
```

e devolve um resultado estruturado para o LLM explicar.

## Tool não precisa ser uma função para cada frase

Uma interface composável pode manter a flexibilidade sem delegar a aritmética
ao modelo:

```text
aggregate(
    dataset="payments",
    filters={
        status: "open",
        due_date: >= today
    },
    group_by=["due_date"],
    metrics=[
        count(),
        sum("original_amount")
    ]
)
```

O Agent decide os parâmetros que correspondem à intenção. A Tool valida e
executa. O resultado pode incluir contagem, total, agrupamentos, intervalo de
datas, indicação de truncamento e identificadores das fontes usadas.

Essa divisão permite responder a muitas perguntas sem criar uma função especial
para cada frase do usuário.

## O contrato da Tool precisa carregar as regras

O caso que motivou esta série mostrou por que uma Tool não é apenas um acesso ao
banco. Ela também precisa explicitar o contrato do dado.

Eu verificaria pelo menos:

- qual é a definição de “aberto”, “vencido” e “não vencido”;
- qual fuso e qual data do servidor representam `today`;
- se o dia atual entra ou não em cada filtro;
- qual campo monetário pode ser agregado;
- se a resposta foi truncada por limite de página;
- como o consumidor descobre que ainda existem registros;
- qual resumo determinístico acompanha as linhas retornadas.

Se o limite da Tool for excedido silenciosamente, o cálculo pode estar correto
para as linhas recebidas e errado para o conjunto que o usuário perguntou. O
modelo não deveria ter de deduzir isso olhando para uma lista parcial.

## Quando a pergunta ultrapassa a agregação

Algumas perguntas pedem transformações mais abertas:

> Retire os três maiores pagamentos, compare as duas quinzenas e calcule como muda a concentração.

Não é necessário criar uma função para essa frase específica. Uma alternativa é
deixar o LLM definir uma transformação limitada e executar o código em um
sandbox:

```text
LLM define transformação
        ↓
validação de schema e permissões
        ↓
sandbox executa código
        ↓
resultado estruturado
        ↓
LLM explica
```

O sandbox não transforma código gerado em código confiável automaticamente. Ele
precisa de limites de recursos, acesso restrito aos dados, operações permitidas,
tempo máximo e registro da execução. A escolha depende do impacto da operação e
do ambiente em que ela roda.

## Guardrail não deveria ser apenas uma frase

Considere a instrução:

> se houver divergência, não continue.

Ela pode estar no prompt. Também pode existir no Flow e no código:

```text
if result != deterministic_result:
    stop()
```

São mecanismos diferentes. A primeira é uma orientação que o modelo pode
interpretar. A segunda é uma condição do sistema.

Quanto maior o impacto de uma operação, mais eu prefiro que a regra importante
seja executável: limite de valor, autorização, idempotência, consistência,
retry, parada e escalonamento.

## O lugar do humano

Automação não precisa significar que toda exceção será resolvida pelo modelo.

Se uma validação falhar, duas fontes divergirem, uma alteração tiver alto
impacto ou o resultado não puder ser explicado com os dados disponíveis, o Flow
pode interromper:

```text
situação normal
      ↓
automação

situação excepcional
      ↓
revisão humana
```

Isso não é uma falha da arquitetura. É a consequência de reconhecer que o
processo tem estados em que a evidência não sustenta uma decisão automática.

## O desenho completo

Depois desta série, o modelo mental que estou usando é:

```text
                    FLOW
             controla o processo
                    │
       ┌────────────┼────────────┐
       ↓            ↓            ↓
     AGENT        CÓDIGO        CREW
     decide       garante      colabora
       │                           │
       ↓                           ↓
     SKILLS                     AGENTS
       │                           │
       ↓                           ↓
     TOOLS                      TOOLS
```

Ao redor de tudo isso ficam permissões, observabilidade, limites e intervenção
humana. Não existe uma única peça responsável por garantir o sistema inteiro.

Quando eu desenho o próximo Agent, tento responder antes:

1. qual parte da entrada é ambígua;
2. qual decisão precisa de julgamento;
3. qual operação precisa ser repetível;
4. qual evidência valida a saída;
5. quem ou o que interrompe o processo quando essa evidência não aparece.

O LLM pode decidir o cálculo que representa a intenção do usuário. A execução
do cálculo, porém, deve ficar em uma camada que não precise improvisar.
