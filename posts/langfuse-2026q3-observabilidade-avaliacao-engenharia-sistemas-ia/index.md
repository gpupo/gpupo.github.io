# Como uso o Langfuse v4 para transformar traces em testes do próximo release

Published: 2026-08-17
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/langfuse-2026q3-observabilidade-avaliacao-engenharia-sistemas-ia/
Tags: Langfuse, Observabilidade, Avaliação de IA, OpenTelemetry, Engenharia de Software, Agentes de IA

---

Colocar uma aplicação com LLM em produção leva rapidamente a perguntas que um
log de entrada e saída não responde bem:

- qual prompt e qual modelo produziram a resposta;
- onde ficou a maior parte do custo e da latência;
- qual ferramenta o agente decidiu chamar;
- se o retriever trouxe os documentos adequados;
- qual versão da aplicação estava ativa;
- se a resposta foi boa e, quando não foi, qual parte falhou.

É nesse espaço que uso o Langfuse. O projeto se apresenta como uma plataforma
*open source* de AI Engineering que reúne tracing, métricas, gestão de prompts,
avaliações, datasets e experiments. Essas capacidades estão documentadas no
[repositório oficial](https://github.com/langfuse/langfuse) e na
[visão geral do produto](https://langfuse.com/docs).

O ponto que me interessa não é apenas enxergar uma chamada ao modelo. É
acompanhar o comportamento de uma aplicação de IA como um sistema de software e
transformar falhas observadas em casos reproduzíveis para o próximo release.

Este texto é um recorte de 17 de agosto de 2026. Os exemplos seguem os conceitos
do Langfuse v4 e a API atual do SDK Python v4. Não são uma aplicação completa:
funções como `search_documents()` e `generate_answer()` pertencem ao sistema
que está sendo instrumentado. Como os SDKs mudam, vale conferir o
[guia de migração do Python v3 para v4](https://langfuse.com/docs/observability/sdk/upgrade-path/python-v3-to-v4)
antes de copiar um trecho para outra versão.

## O problema aparece quando a aplicação vira um sistema

Uma chamada isolada pode ser representada assim:

```text
usuário → prompt → LLM → resposta
```

Registrar entrada, saída, tokens e latência resolve boa parte da investigação
nesse caso. Um agente real tende a acrescentar outras fronteiras:

```text
request
└── agent
    ├── retriever
    ├── generation
    ├── tool → API externa
    ├── outro agent
    │   ├── retriever
    │   └── generation
    ├── guardrail
    └── resposta
```

A resposta final pode estar errada mesmo quando a geração funcionou como
esperado. O retriever pode ter escolhido o documento errado, a ferramenta pode
ter recebido argumentos incorretos, a API externa pode ter devolvido dados
incompletos ou o guardrail pode ter alterado a saída.

Sem a árvore inteira, tudo isso tende a aparecer como “o modelo falhou”. Com a
árvore, a investigação começa na etapa que produziu o comportamento.

## Observation, trace e session têm papéis diferentes

O [modelo de dados do
Langfuse](https://langfuse.com/docs/observability/data-model) organiza a
telemetria em três conceitos:

```text
session
└── trace
    ├── observation
    ├── observation
    └── observation
```

Uma **observation** é uma unidade de trabalho: geração, chamada de ferramenta,
retrieval, avaliação ou outro passo. Observations podem ser aninhadas.

Um **trace** agrupa as observations de uma operação lógica, como processar uma
mensagem. Uma **session** pode agrupar vários traces relacionados, por exemplo
os turnos de uma conversa.

Os [tipos de
observation](https://langfuse.com/docs/observability/features/observation-types)
incluem `generation`, `agent`, `tool`, `chain`, `retriever`, `evaluator`,
`embedding`, `guardrail`, `span` e `event`. A tipagem não é decorativa. Uma
`generation`, por exemplo, comporta modelo, uso e custo; uma `tool` pode ser
filtrada separadamente quando quero avaliar seleção e argumentos.

Uma árvore útil preserva o vocabulário da aplicação:

```text
customer-support-agent
├── retriever: search-documentation
├── generation: analyze-question
├── tool: billing-api
├── generation: compose-answer
└── guardrail: validate-output
```

## A instrumentação manual precisa contar a mesma história

O primeiro passo é instalar o SDK e configurar as credenciais. Para Langfuse
Cloud, a URL depende da região; em uma instalação própria, aponta para a
instância local.

```bash
python -m pip install --upgrade langfuse

export LANGFUSE_SECRET_KEY="sk-lf-..."
export LANGFUSE_PUBLIC_KEY="pk-lf-..."
export LANGFUSE_BASE_URL="https://cloud.langfuse.com"
```

O exemplo abaixo instrumenta um fluxo pequeno, mas coerente. O contexto é
propagado antes de abrir a observation raiz; retrieval e generation aparecem
como filhos. O código registra a quantidade de documentos, não seu conteúdo
integral — uma escolha que precisa ser revista conforme a política de dados e a
necessidade de depuração.

```python
from langfuse import get_client, propagate_attributes

langfuse = get_client()

with propagate_attributes(
    user_id=user_id,
    session_id=session_id,
    environment="production",
    version=RELEASE,
    tags=["customer-support"],
):
    with langfuse.start_as_current_observation(
        as_type="agent",
        name="answer-user",
        input={"question": question},
    ) as agent:
        with langfuse.start_as_current_observation(
            as_type="retriever",
            name="search-knowledge-base",
            input={"query": question},
        ) as retrieval:
            documents = search_documents(question)
            retrieval.update(
                output={"documents_found": len(documents)}
            )

        with langfuse.start_as_current_observation(
            as_type="generation",
            name="compose-answer",
            model=MODEL,
            input={
                "question": question,
                "document_count": len(documents),
            },
        ) as generation:
            answer = generate_answer(question, documents)
            generation.update(output={"answer": answer})

        agent.update(output={"answer": answer})

langfuse.flush()
```

O uso de `start_as_current_observation()` mantém o contexto OpenTelemetry ativo
e faz os filhos herdarem o pai. Essa é a forma principal descrita no
[guia oficial de
instrumentação](https://langfuse.com/docs/observability/sdk/instrumentation).
Em processos curtos, `flush()` evita encerrar antes de enviar os eventos
pendentes; aplicações servidoras normalmente deixam o SDK agrupar e enviar os
eventos em segundo plano.

## Integrações automáticas e OpenTelemetry podem conviver

Quando a aplicação usa diretamente o SDK Python da OpenAI, o wrapper do
Langfuse preserva uma interface familiar e cria a generation:

```python
from langfuse.openai import openai

completion = openai.chat.completions.create(
    name="support-answer",
    model=MODEL,
    messages=[
        {
            "role": "system",
            "content": "Answer using the provided context.",
        },
        {"role": "user", "content": question},
    ],
)
```

A integração e os parâmetros suportados estão no
[cookbook oficial para OpenAI](https://langfuse.com/guides/cookbook/integration_openai_sdk).
Se a chamada ocorrer dentro de uma observation ativa, ela entra naquela árvore
em vez de ficar isolada.

No LangChain, o `CallbackHandler` transforma eventos do framework em
observations. A instrumentação manual continua útil para acrescentar a unidade
de domínio que o framework não conhece:

```python
from langfuse import propagate_attributes
from langfuse.langchain import CallbackHandler

handler = CallbackHandler()

with propagate_attributes(
    user_id=user_id,
    session_id=session_id,
    environment="production",
    version=RELEASE,
):
    response = chain.invoke(
        {"question": question},
        config={"callbacks": [handler]},
    )
```

O [guia inicial de
observabilidade](https://langfuse.com/docs/observability/get-started) mantém
exemplos do handler. O cuidado é não assumir que instrumentação automática
produzirá, sozinha, a melhor árvore para o domínio.

Os SDKs atuais são baseados em OpenTelemetry. Isso permite manter o Langfuse na
camada especializada de IA e outra stack para HTTP, banco, CPU, filas e
infraestrutura:

```text
                    aplicação
                        │
              contexto OpenTelemetry
                 ┌──────┴──────┐
                 ↓             ↓
          observabilidade    Langfuse
            tradicional
          HTTP · DB · CPU    LLM · agent
          filas · infra      tools · evals
```

Não significa que todos os spans devam ir para todos os destinos. O SDK possui
filtros por escopo de instrumentação, e a seleção precisa equilibrar capacidade
de diagnóstico, ruído e custo. A documentação de
[recursos avançados](https://langfuse.com/docs/observability/sdk/advanced-features)
explica filtragem, sampling e isolamento de providers OpenTelemetry.

## Contexto transforma volume em diagnóstico

Um trace isolado já ajuda a depurar. Milhões de traces só permitem comparação
quando carregam dimensões consistentes, como usuário, sessão, ambiente, release,
feature e versão do agente ou do prompt.

Esses atributos permitem perguntas que importam para a operação:

- qual release começou a produzir mais erros;
- qual feature concentra custo ou latência;
- quais traces pertencem à mesma sessão;
- como um agente se comporta por ambiente;
- quanto uma conversa ou um tenant consome.

O `propagate_attributes()` usado no exemplo é o mecanismo atual para propagar
`user_id`, `session_id`, `version`, `tags`, `metadata` e `environment`. A
[documentação de
instrumentação](https://langfuse.com/docs/observability/sdk/instrumentation)
ressalta que `environment` é um atributo de primeira classe no SDK Python, não
apenas uma chave arbitrária em metadata.

Custo também precisa de proveniência. O Langfuse pode receber uso e custo do
provedor ou inferi-los a partir da definição do modelo; valores enviados têm
prioridade. A [documentação de tokens e
custos](https://langfuse.com/docs/observability/features/token-and-cost-tracking)
também alerta que buckets sobrepostos podem contar tokens duas vezes.

Latência precisa ser decomposta pelo mesmo motivo. Os números abaixo são
ilustrativos, não uma medição deste projeto:

| Etapa | Latência ilustrativa |
| --- | ---: |
| retrieval | 400 ms |
| generation 1 | 1.800 ms |
| tool HTTP | 4.700 ms |
| generation 2 | 900 ms |
| validation | 200 ms |

“O agente demorou oito segundos” descreve o sintoma. A árvore mostra qual
fronteira merece investigação.

## Observar ainda não diz se a resposta foi boa

Uma execução pode ter baixa latência, custo pequeno e nenhum erro técnico, mas
entregar uma resposta incorreta. Por isso, tracing e avaliação precisam se
encontrar.

No Langfuse, **scores** armazenam resultados de avaliação. Eles podem vir de
feedback do usuário, revisão humana, código, LLM-as-a-Judge ou outro pipeline e
podem ser ligados a trace, observation, session ou dataset run. A
[documentação de scores](https://langfuse.com/docs/evaluation/scores/overview)
distingue valores numéricos, categóricos, booleanos e textuais.

A granularidade muda o diagnóstico. Em vez de um único “bom” ou “ruim” para a
execução inteira, posso separar:

| Alvo | Exemplo de sinal | Pergunta respondida |
| --- | --- | --- |
| retriever | `retrieval_relevance` | Os documentos sustentavam a resposta? |
| tool | `tool_selection` | O agente escolheu a operação correta? |
| generation | `answer_correctness` | A saída respondeu ao pedido? |
| trace | `user_satisfaction` | O resultado final serviu ao usuário? |

Uma resposta ruim pode vir de uma geração boa apoiada no documento errado. Um
score único esconderia essa diferença.

## LLM-as-a-Judge é um sinal, não uma sentença

Um Judge recebe entrada, saída, contexto e rubrica, e devolve um score com uma
justificativa. A [documentação de
LLM-as-a-Judge](https://langfuse.com/docs/evaluation/evaluation-methods/llm-as-a-judge)
permite aplicar avaliadores a observations de produção ou a experiments com
datasets.

Isso ajuda a avaliar volume, mas eu evitaria transformar o Judge em árbitro
absoluto. Uso três sinais com autoridades diferentes:

| Sinal | Onde ajuda | Limitação principal |
| --- | --- | --- |
| regra determinística | schema, regex, campos e contratos objetivos | só prova a regra implementada |
| LLM-as-a-Judge | critérios semânticos e revisão em escala | pode reproduzir vieses e discordar de especialistas |
| avaliação humana | decisão contextual e casos de alto impacto | custa tempo e não escala da mesma forma |

As [Annotation Queues](https://langfuse.com/docs/evaluation/evaluation-methods/annotation-queues)
organizam revisão manual de traces, observations ou sessions e permitem que
especialistas acrescentem scores, comentários e saídas corrigidas.

Em outro post, mostrei [como uso Langfuse com LLM-as-a-Judge sem tratar score
como verdade](/posts/langfuse-llm-as-a-judge/). Ali há
uma execução observada, números reais, diferenças entre dois projetos e os
motivos pelos quais o Judge ainda não funciona como gate. Este texto tem outro
papel: organizar as peças da plataforma e o loop que elas podem formar.

## Dataset, experiment e prompt fecham o loop

Um caso interessante encontrado em produção pode deixar de ser apenas um
incidente e entrar no conjunto permanente de avaliação:

```text
falha em produção
      ↓
trace + análise
      ↓
dataset item
      ↓
experiment
      ↓
proteção contra regressão
```

O [guia de datasets](https://langfuse.com/docs/evaluation/experiments/datasets)
define cada dataset como uma coleção de entradas e, opcionalmente, saídas
esperadas. O [modelo de avaliação](https://langfuse.com/docs/evaluation/core-concepts)
combina esses itens com uma task, métodos de avaliação e uma execução do
experiment.

O mesmo dataset permite comparar prompts, modelos, retrievers ou releases do
agente. Os números abaixo também são hipotéticos; mostram o formato da decisão,
não o resultado de um benchmark:

| Métrica | Versão A | Versão B |
| --- | ---: | ---: |
| correctness | 0,82 | 0,89 |
| latência | 2,1 s | 2,4 s |
| custo por caso | US$ 0,011 | US$ 0,008 |

Não existe vencedor universal nessa tabela. A versão B melhora dois sinais e
piora outro; a escolha depende do limite de latência, da relevância do ganho de
qualidade e da confiabilidade do método que produziu o score.

Prompt Management acrescenta proveniência. Versões preservam o conteúdo exato;
labels como `staging` e `production` apontam para a versão usada por cada
ambiente. A [documentação de controle de
versão](https://langfuse.com/docs/prompt-management/features/prompt-version-control)
mostra que mover o label também permite rollback.

```text
prompt version
      ↓
experiment
      ↓
evaluation
      ↓
production label
      ↓
traces e scores
```

O trace precisa continuar ligado à versão efetivamente usada. Caso contrário,
o prompt fica versionado na plataforma, mas a resposta em produção perde a
proveniência.

## Self-hosting controla o destino, não o conteúdo capturado

O Langfuse pode ser executado na própria infraestrutura. A arquitetura atual é
formada por Web, Worker, PostgreSQL, ClickHouse, Redis ou Valkey e object
storage. Um desenho simplificado é:

```text
SDKs e usuários
       ↓
   Langfuse Web
   ├── PostgreSQL
   ├── ClickHouse
   ├── object storage
   └── Redis / Valkey → Worker
                        ├── PostgreSQL
                        ├── ClickHouse
                        └── object storage
```

A [arquitetura mantida no repositório
oficial](https://github.com/langfuse/langfuse/blob/main/CONTRIBUTING.md#architecture-overview)
explica o papel desses componentes. O
[Docker Compose](https://langfuse.com/self-hosting/deployment/docker-compose) é
o caminho mais simples para uma máquina ou ambiente de teste, mas a própria
documentação registra que esse arranjo não oferece alta disponibilidade,
escalabilidade horizontal ou backup. Para cargas maiores, existe o
[deployment com Kubernetes e Helm](https://langfuse.com/self-hosting/deployment/kubernetes-helm),
inclusive com serviços de dados externos.

Eu já descrevi [um upgrade real do Langfuse no meu
homelab](/artigos/email-marvin-gerencio-infraestrutura-2026/),
com backup, restauração, Nomad e uma pendência de compatibilidade que permaneceu
depois do deploy.

Self-hosting ajuda a controlar onde os traces ficam. Não decide quais dados
deveriam entrar neles. Prompt, documentos recuperados, parâmetros de tools,
respostas, dados de usuário e metadata podem carregar informações pessoais,
segredos ou conteúdo interno.

A política precisa responder, antes da captura:

- quais campos são necessários para investigar e avaliar;
- o que não pode sair da aplicação;
- o que precisa ser mascarado;
- quem pode acessar cada ambiente;
- quanto tempo os dados serão mantidos;
- quando basta registrar ids, tamanhos ou contagens.

O Langfuse oferece [masking no
SDK](https://langfuse.com/docs/observability/features/masking), inclusive no
estágio de exportação OpenTelemetry. Masking é uma barreira adicional; não
substitui reduzir a coleta na origem. Observabilidade não deve criar um novo
vazamento em nome de investigar o anterior.

## Eu começaria pelo caminho crítico

Em uma aplicação nova, eu não instrumentaria tudo nem criaria dez scores de uma
vez. Começaria pelo fluxo cuja falha possui consequência identificável:

```text
request
   ↓
agent
   ↓
retrieval
   ↓
tools
   ↓
generations
   ↓
response
```

Depois acrescentaria:

1. `user_id`, `session_id`, ambiente, release e versões de agente e prompt;
2. entrada e saída estritamente necessárias para revisar o caso;
3. latência, uso, custo e feedback do usuário;
4. um ou dois checks determinísticos ligados ao contrato;
5. uma rubrica semântica curta, quando houver razão para usar um Judge;
6. revisão humana associada exatamente à saída avaliada.

O próximo hábito é perguntar, depois de cada falha relevante: **este caso deve
entrar no dataset?** Se a resposta for sim, o incidente passa a proteger uma
comparação futura. A aplicação não aprende sozinha; o processo de engenharia
acumula casos reais e os usa para avaliar releases.

## O dashboard não é o objetivo

É fácil instalar observabilidade, abrir uma tela cheia de traces e sentir que o
problema foi resolvido. Milhares de traces sem processo continuam sendo apenas
milhares de traces.

O valor aparece quando existe um loop operacional:

```text
observar
   ↓
entender e medir
   ↓
transformar em caso reproduzível
   ↓
experimentar e comparar
   ↓
mudar e medir novamente ↺
```

Tracing é a porta de entrada. O ganho maior aparece quando uma execução fica
ligada a usuário, sessão, release, prompt, custo, latência, score, feedback,
dataset e experiment.

Nesse ponto, a pergunta deixa de ser apenas “o que o modelo respondeu?” e passa
a orientar a evolução do sistema:

> **Como sabemos se este sistema está ficando melhor?**

Para mim, essa é uma das perguntas centrais de AI Engineering em 2026.
