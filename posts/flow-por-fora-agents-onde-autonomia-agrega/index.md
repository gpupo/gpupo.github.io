# Flow por fora: quando usar Agent solo, fan-out ou Crew

Published: 2026-08-20
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/flow-por-fora-agents-onde-autonomia-agrega/
Tags: Agentes de IA, Arquitetura de software, Orquestração, Flow, Crew

---

No [primeiro texto desta série](/posts/agent-crew-flow-nao-sao-a-mesma-coisa/), propus uma separação:

**Agent é autonomia. Crew é colaboração. Flow é orquestração.**

Essa distinção fica útil quando uma pergunta aparentemente simples começa a
misturar responsabilidades.

Considere:

> Quanto tenho em aberto e ainda não vencido?

Para responder, o sistema pode precisar interpretar o significado de “não
vencido”, definir o período, consultar os registros, calcular o total, validar
os dados e redigir a resposta.

É possível colocar tudo dentro de um Agent. A possibilidade, porém, não decide
se essa é uma boa fronteira.

## O Flow controla o caminho

Eu começaria descrevendo o processo sem escolher uma biblioteca:

```text
Flow

├── interpretar intenção
├── validar parâmetros
├── consultar dados
├── calcular
├── validar
├── analisar contexto
└── comunicar
```

Depois atribuiria uma implementação a cada etapa:

```text
interpretar_intencao  → LLM ou Agent
validar_parametros    → código
consultar_dados       → Tool / API
calcular              → código
validar               → código
analisar_contexto     → Agent ou Crew
comunicar             → LLM
```

O Flow não é “a parte determinística”. Ele é o lugar onde a ordem, as
dependências, as exceções e as regras de parada ficam visíveis. Dentro dele
podem existir etapas probabilísticas e determinísticas.

## Pergunta simples: Agent solo

Se a pergunta pertence claramente a um único domínio, eu chamaria o especialista
diretamente:

```text
Flow
  ↓
Agent especializado
  ↓
verificação
  ↓
resposta
```

Não há motivo automático para criar uma Crew. O Agent pode interpretar a
solicitação e pedir à Tool os dados necessários. O Flow ainda mantém a
verificação e decide o que fazer se ela falhar.

Essa rota também reduz o custo de uma decisão desnecessária: um manager não
precisa escolher entre especialistas que não têm relação com a pergunta.

## Pergunta combinada: fan-out e fan-in

Agora imagine:

> Como meus próximos pagamentos se relacionam com o caixa previsto para o período?

Há pelo menos dois domínios. Uma Crew pode ser uma opção, mas eu perguntaria
primeiro se os Agents precisam conversar ou delegar entre si.

Se cada análise puder ser feita de forma independente, o Flow pode coordenar o
trabalho:

```text
                         Flow
                          │
                  ┌───────┴───────┐
                  ↓               ↓
             Agent Caixa     Agent Pagamentos
                  │               │
                  └───────┬───────┘
                          ↓
                         merge
                          ↓
                       análise
```

Eu chamaria esse desenho de fan-out/fan-in: o processo distribui as partes,
espera os resultados e os reúne. Os Agents trabalham em paralelo, mas não
precisam ser apresentados como uma equipe se não existe colaboração entre eles.

O `merge` também precisa de um contrato. O Flow deve saber quais campos cada
Agent precisa retornar, como representar ausência de dados e o que fazer quando
uma das análises falha.

## Recomendação de solução: Crew

A Crew aparece quando a investigação muda conforme as contribuições dos
especialistas.

Considere:

> Que alternativas temos para reduzir a pressão financeira das próximas semanas?

Um Agent responsável por soluções pode decidir quais alternativas avaliar:

```text
Crew Soluções

        Manager
           │
     decide e delega
     ┌─────┼─────┐
     ↓     ↓     ↓
  Agent A Agent B Agent C
```

Aqui há uma razão concreta para a Crew: delegação dinâmica. Um especialista
pode escolher uma combinação de executores e usar o resultado de uma análise
para orientar a próxima.

Na proposta que motivou esta série, esse era o caso mais claro de colaboração.
O desenho ainda não tinha sido aplicado em produção; portanto, não apresento
ganhos de velocidade ou qualidade como resultado medido. A proposta apenas
separa o lugar em que a Crew parece necessária dos caminhos que podem ser
coordenados pelo Flow.

## Auditoria qualitativa e verificação factual

O mesmo cuidado vale para um Agent auditor.

Um auditor pode avaliar:

- se a conclusão é coerente com os dados apresentados;
- se a recomendação respeita as restrições;
- se alguma premissa foi ignorada;
- se há contradição ou problema de comunicação.

Isso é diferente de verificar:

```text
40 registros somam 985626.84?
```

Para essa pergunta, eu usaria:

```text
sum(records) == reported_total
```

Minha recomendação é deixar a auditoria qualitativa no Agent e a verificação
computável no código. Um segundo LLM pode produzir uma crítica útil, mas não é
uma fonte independente para a soma que o primeiro LLM fez.

## Regras de parada também pertencem ao Flow

Quando uma resposta é contestada, “tente novamente” não deveria ser a política
inteira:

```text
novo resultado
    ↓
nova contestação
    ↓
outro resultado
```

O Flow pode transformar o caso em uma regra explícita:

```text
resultado divergiu?
       ↓
recalcular por caminho determinístico
       ↓
continua divergindo?
   ┌───────┴───────┐
  não             sim
   ↓               ↓
seguir        interromper
                  ↓
            revisão humana
```

Uma divergência factual não deve ser tratada como convite para sortear um novo
número. Ela precisa de uma nova consulta, de um cálculo independente ou de uma
interrupção.

## O risco que o Flow introduz

Separar caminhos também cria um novo ponto de falha: o classificador de
intenção. Se ele mandar uma pergunta combinada para um Agent solo, a resposta
pode parecer completa e deixar um domínio de fora.

Eu testaria essa fronteira antes de afirmar que o novo desenho melhorou o
sistema. Um conjunto pequeno já ajuda: variações de fraseado para a mesma
pergunta, contas com volumes diferentes e casos que exigem paginação. O critério
não seria apenas uma resposta correta; seria também encaminhar cada caso para o
caminho que consegue responder por inteiro.

Flow por fora não é uma defesa contra Agents. É uma forma de reservar autonomia
para as decisões que precisam dela e manter o processo observável quando as
peças começam a interagir.

No [terceiro texto](/posts/o-llm-pode-decidir-o-calculo-nao-deveria-ser-a-calculadora/), trato da fronteira mais concreta dessa arquitetura: o LLM pode decidir qual cálculo deve acontecer, mas não deveria ser a calculadora.
