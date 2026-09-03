# Como versionar uma rede de agentes além dos microserviços

Published: 2026-08-04
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/pipeline-de-agentes-rede-versionada/
Tags: IA, Agentes, Arquitetura, Microsserviços, Versionamento, Observabilidade

---

Recentemente, um cliente me perguntou como deveria versionar os microserviços de
uma plataforma de chatbots, agentes e automações.

O sistema não era um conjunto tradicional de APIs independentes. Cada
microserviço representava uma etapa de processamento: um recebia a entrada,
outro classificava a intenção, outro buscava contexto, outro executava uma ação
e, no final, algum componente consolidava a resposta.

A primeira reação seria aplicar versionamento semântico em cada serviço e seguir
em frente:

```text
intent-classifier: 1.4.0
context-retriever: 2.1.3
response-generator: 3.0.1
```

Isso resolve apenas uma parte do problema.

Quando esses serviços trabalham juntos para produzir um único resultado, não
basta saber qual versão de cada componente está implantada. Também é necessário
saber qual combinação de componentes formava o fluxo, como eles estavam
conectados e quais configurações determinavam o comportamento daquela execução.

Foi nesse ponto que passei a representar o sistema como uma rede versionada.
Essa representação ajuda a enxergar cada agente ou automação como um nó dentro
de um grafo organizado em camadas.

## Da esteira linear para a rede de processamento

É comum representar uma automação como uma linha:

```text
Entrada → Classificação → Consulta → Processamento → Resposta
```

Essa representação funciona enquanto o fluxo é simples.

Na prática, sistemas baseados em agentes rapidamente deixam de ser lineares.

Uma mensagem pode ser enviada simultaneamente para:

- um classificador de intenção;
- um detector de risco;
- um mecanismo de recuperação de contexto;
- um agente responsável por identificar o cliente;
- uma política de segurança;
- um mecanismo de decisão.

Os resultados podem ser encaminhados para diferentes agentes especializados, que
posteriormente alimentam outro componente responsável por consolidar a saída.

O fluxo passa a se parecer mais com isto:

```text
Entradas
   ↓
Camada de preparação
   ↓
Camada de entendimento
   ↓
Camada de decisão
   ↓
Camada de execução
   ↓
Camada de consolidação
   ↓
Saída
```

Dentro de cada camada podem existir vários nós.

Alguns são executados em paralelo. Outros são acionados apenas quando uma
determinada condição é atendida. Alguns podem falhar sem interromper todo o
processamento. Outros são críticos para a resposta final.

Essa visão muda a discussão sobre versionamento.

![Diagrama de um pipeline tradicional comparado com uma rede de agentes organizada em camadas.](/assets/images/pipeline-agentes-rede-versionada.png){: .rounded }

## Cada agente funciona como um nó da rede

Cada agente, serviço ou automação pode ser tratado como um nó.

Ele recebe determinadas entradas, realiza uma transformação e produz uma saída.

Por exemplo, um nó pode receber:

```json
{
  "message": "Quero cancelar minha assinatura",
  "customer_id": "12345"
}
```

E produzir:

```json
{
  "intent": "subscription_cancellation",
  "confidence": 0.94
}
```

Outro nó pode receber essa intenção e decidir qual política deve ser aplicada. Um
terceiro pode consultar o histórico do cliente. Um quarto pode verificar se
existe alguma pendência financeira.

O resultado final não é produzido por um único serviço. Ele emerge da combinação
dos nós que participaram da execução.

Essa é a parte mais importante da representação: o comportamento pertence à
rede, não apenas a cada nó individualmente.

Um classificador pode continuar funcionando perfeitamente quando testado
sozinho e, mesmo assim, alterar o comportamento global do sistema ao mudar a
forma como classifica determinadas mensagens.

Uma mudança aparentemente pequena em um nó pode direcionar milhares de execuções
para caminhos diferentes.

## Uma camada representa uma responsabilidade

A camada não precisa ser apenas uma divisão visual. Ela pode representar uma
responsabilidade arquitetural.

Em uma plataforma de agentes, eu poderia organizar o fluxo desta forma.

### Camada de entrada

Recebe mensagens, eventos, arquivos, chamadas de API ou comandos.

Também pode normalizar formatos, remover conteúdo inválido e adicionar
metadados iniciais.

### Camada de interpretação

Identifica intenção, idioma, assunto, prioridade, risco e contexto provável.

É onde normalmente aparecem classificadores, extratores e pequenos modelos
especializados.

### Camada de contexto

Consulta documentos, bancos de dados, memória da conversa, sistemas internos e
serviços externos.

Aqui podem estar mecanismos de busca, RAG, APIs corporativas e ferramentas de
enriquecimento.

### Camada de decisão

Escolhe o caminho de processamento.

Pode decidir qual agente deve ser executado, quais ferramentas são permitidas,
se a operação exige aprovação humana ou se a solicitação deve ser bloqueada.

### Camada de execução

Executa ações concretas.

Pode abrir um chamado, atualizar um cadastro, emitir um documento, gerar uma
análise ou acionar outra automação.

### Camada de saída

Consolida resultados, aplica políticas de resposta, formata o conteúdo e entrega
a saída ao usuário ou ao sistema seguinte.

Essa organização permite substituir um nó sem redesenhar toda a rede, desde que os
contratos de entrada e saída continuem compatíveis.

## Substituir um nó sem substituir a rede

Imagine que a camada de interpretação possua um serviço chamado
`intent-classifier`.

A versão atual utiliza um modelo maior e relativamente caro:

```text
intent-classifier: 2.3.0
```

A equipe desenvolve uma versão mais rápida:

```text
intent-classifier: 2.4.0
```

A nova versão mantém o mesmo contrato de entrada e saída, mas usa outro modelo e
um prompt revisado.

Na arquitetura tradicional, poderíamos simplesmente substituir a imagem do
container.

Na visão da rede, tratamos isso como a substituição de um nó.

A nova versão pode receber uma porcentagem do tráfego, operar em modo sombra ou
ser utilizada apenas para determinados clientes. O restante da rede continua
igual.

Isso permite realizar:

- testes A/B;
- *canary releases*;
- tráfego em sombra (*shadow traffic*);
- comparação de custo;
- comparação de latência;
- avaliação de qualidade;
- *rollback* isolado.

A vantagem não é apenas técnica. A organização passa a evoluir o sistema por
partes, sem transformar cada mudança em uma nova versão completa da plataforma.

## O nó tem uma versão. A rede também precisa ter

Versionar apenas os microserviços é insuficiente.

A [skill GitOps Service Versioning](https://www.bpstrat.com.br/post/bp-strat-publica-skill-gitops-service-versioning/) trata uma parte operacional desse problema ao auditar tags, drift upstream e registros vivos de versões de serviços.

Suponha que uma execução tenha utilizado:

```text
input-normalizer: 1.2.0
intent-classifier: 2.4.0
customer-context: 3.1.2
policy-engine: 1.8.0
response-generator: 4.0.3
```

Essa lista ainda não informa:

- quais conexões estavam habilitadas;
- quais nós foram ignorados;
- quais regras de roteamento estavam ativas;
- quais prompts foram usados;
- qual modelo cada agente utilizou;
- quais ferramentas estavam disponíveis;
- qual política determinou a saída;
- quais parâmetros de inferência estavam configurados.

Por isso, além da versão de cada nó, eu recomendo manter uma **versão do
grafo**.

Ela representa uma configuração imutável da rede de processamento.

```text
customer-support-graph: 7.3.0
```

A versão `7.3.0` não precisa conter o código dos serviços. Ela aponta para uma
composição específica de componentes, contratos e configurações.

## O manifesto da rede

Uma forma prática de fazer isso é manter um manifesto versionado.

```yaml
graph:
  name: customer-support
  version: 7.3.0

nodes:
  input-normalizer:
    version: 1.2.0
    output-contract: normalized-message.v2

  intent-classifier:
    version: 2.4.0
    input-contract: normalized-message.v2
    output-contract: classified-intent.v3
    model: qwen3.5-9b
    prompt-version: intent-classifier.14

  customer-context:
    version: 3.1.2
    output-contract: customer-context.v4

  policy-engine:
    version: 1.8.0
    policy-version: support-policy.23

  response-generator:
    version: 4.0.3
    prompt-version: response-generator.31
    model: internal-chat-model-2026-07

routing:
  - from: input-normalizer
    to:
      - intent-classifier
      - customer-context

  - from: intent-classifier
    to: policy-engine

  - from: customer-context
    to: policy-engine

  - from: policy-engine
    to: response-generator
```

Esse manifesto responde a uma pergunta essencial:

> Qual rede produziu essa resposta?

Sem isso, uma investigação de incidente pode terminar em uma coleção de versões
de containers sem nenhuma representação confiável do comportamento completo.

## O comportamento de um agente não está apenas no código

Em um microserviço tradicional, o comportamento normalmente está concentrado no
código e na configuração.

Em sistemas de agentes, isso se fragmenta.

Um nó pode mudar de comportamento por causa de uma alteração em:

- código;
- prompt;
- modelo;
- quantização;
- temperatura;
- ferramentas disponíveis;
- base de conhecimento;
- política de segurança;
- parâmetros de recuperação;
- esquema da mensagem;
- configuração do orquestrador.

Por isso, dizer que um agente está na versão `2.4.0` pode não ser suficiente.

A mesma imagem de container, usando o mesmo endpoint, pode produzir respostas
diferentes se o prompt ou o modelo forem alterados.

Uma identificação mais completa poderia ser:

```text
node_version: 2.4.0
prompt_version: intent-classifier.14
model_version: qwen3.5-9b-q4_k_m
toolset_version: classifier-tools.3
policy_version: support-policy.23
```

Para garantir reprodutibilidade, o ideal é registrar também uma revisão
imutável da configuração:

```text
runtime_revision: sha256:93f2c1...
```

O ponto não é criar complexidade documental. É conseguir responder por que uma
execução se comportou de determinada maneira.

## Versionamento semântico ainda é útil

Eu continuaria utilizando versionamento semântico nos nós:

```text
MAJOR.MINOR.PATCH
```

Uma interpretação possível:

- `PATCH`: correção interna sem alteração esperada no contrato ou no comportamento relevante;
- `MINOR`: nova capacidade compatível com o contrato atual;
- `MAJOR`: mudança incompatível de contrato ou comportamento.

O cuidado está na expressão “comportamento relevante”.

Em aplicações tradicionais, uma mudança compatível com a API costuma ser
considerada segura. Em um agente, a resposta pode mudar mesmo que o JSON
continue idêntico.

Por exemplo, um classificador continua retornando:

```json
{
  "intent": "string",
  "confidence": 0.91
}
```

O contrato não mudou. Entretanto, uma revisão do prompt pode modificar a
classificação de 12% das entradas.

Do ponto de vista da API, a alteração é compatível. Do ponto de vista do produto,
pode ser uma mudança significativa.

Por isso, SemVer deve ser acompanhado por avaliações de comportamento.

## Contratos conectam os nós da rede

Os contratos definem como a informação circula entre os nós.

Cada conexão precisa deixar claro:

- o formato da mensagem;
- os campos obrigatórios;
- os campos opcionais;
- a semântica de cada valor;
- os códigos de erro;
- as regras de compatibilidade;
- os limites de tempo;
- o comportamento em caso de falha.

Um problema frequente é tratar o JSON como contrato suficiente.

Não é.

Considere este campo:

```json
{
  "confidence": 0.82
}
```

O número pode representar uma probabilidade calibrada, uma pontuação relativa,
uma heurística do modelo ou uma estimativa sem garantia estatística.

O formato é o mesmo, mas a semântica pode mudar.

Versionar contratos significa versionar também o significado dos dados.

```text
classified-intent.v3
```

Uma nova versão deve ser criada quando um consumidor não puder interpretar a
saída da mesma maneira.

## Nem todo nó precisa ser um microserviço

A representação em rede não deve virar justificativa para criar dezenas de
serviços independentes.

Um nó é uma unidade lógica de processamento. Ele pode ser implementado como:

- uma função dentro de um serviço;
- um worker;
- uma chamada a um modelo;
- uma etapa de workflow;
- um job;
- uma API externa;
- um microserviço;
- uma intervenção humana.

A topologia lógica e a topologia de implantação são decisões diferentes.

Posso ter vinte nós lógicos sendo executados por três serviços. Também posso
separar um nó crítico em um serviço independente porque ele exige escala,
isolamento ou governança específica.

A rede descreve o processamento. Os microserviços descrevem uma possível forma
de implantação.

Confundir as duas coisas costuma produzir uma arquitetura distribuída mais cara
do que o problema exige.

## A remoção de um nó também precisa ser planejada

A remoção de um nó em uma rede de agentes pode acontecer quando:

- dois agentes são consolidados;
- uma validação deixa de ser necessária;
- um modelo passa a executar múltiplas tarefas;
- uma integração é descontinuada;
- uma política é substituída;
- uma etapa não demonstra valor suficiente.

A remoção não deveria começar apagando o serviço.

Primeiro, o nó pode ser retirado do caminho principal. Depois, continua recebendo
tráfego em modo sombra para comparação. Em seguida, os consumidores e contratos
antigos são desativados. Só então o componente é removido.

Essa abordagem evita que uma dependência pouco visível apareça apenas depois do
desligamento.

## Rollback do nó ou rollback da rede?

Essa é uma decisão que precisa estar explícita.

Quando o contrato continua compatível, pode ser possível reverter apenas um nó:

```text
intent-classifier 2.4.0 → 2.3.0
```

Mas uma nova versão do nó pode ter sido implantada junto com:

- um novo contrato;
- uma nova regra de roteamento;
- uma nova política;
- uma nova versão do agente seguinte.

Nesse caso, o rollback isolado pode produzir uma combinação que nunca foi
testada.

A alternativa mais segura é reativar uma versão anterior do grafo:

```text
customer-support-graph 7.3.0 → 7.2.1
```

Por isso, cada versão do grafo deve ser imutável. Um manifesto publicado não deve
ser alterado silenciosamente. Uma mudança deve gerar uma nova versão.

## Observabilidade precisa acompanhar a topologia

Em uma rede de agentes, logs isolados de microserviços não são suficientes.

Cada execução precisa carregar um identificador de correlação do início ao fim.
Idealmente, o trace deve mostrar:

```text
Entrada
  → Normalização
  → Classificação
  → Busca de contexto
  → Decisão
  → Execução
  → Consolidação
  → Saída
```

Cada nó deve registrar pelo menos:

```text
trace_id
graph_version
node_name
node_version
contract_version
prompt_version
model_version
runtime_revision
duration
status
token_usage
estimated_cost
```

Assim, quando uma resposta incorreta for reportada, será possível reconstruir a
execução.

Sem isso, a investigação tende a terminar com perguntas vagas:

> Qual modelo estava rodando naquele momento?

> O prompt já tinha sido atualizado?

> O classificador novo estava recebendo todo o tráfego?

> O cliente passou pela regra antiga ou pela nova?

Uma arquitetura versionada sem telemetria continua difícil de operar.

## Testar a rede, não apenas os nós

Testes unitários e testes de contrato continuam importantes. Mas eles não
validam, sozinhos, o comportamento emergente da rede.

Eu incluiria pelo menos três níveis de avaliação.

O primeiro valida o nó isoladamente. O classificador reconhece as intenções
esperadas? O agente retorna um JSON válido? A ferramenta é acionada corretamente?

O segundo valida as conexões. A saída de um nó é interpretada corretamente pelo
próximo? Os contratos são compatíveis? Os erros são tratados?

O terceiro valida o grafo completo. Dada uma entrada conhecida, o sistema chega
ao resultado esperado? O caminho escolhido foi adequado? O custo e a latência
ficaram dentro do limite?

Em sistemas de agentes, esse terceiro nível é o equivalente mais próximo de um
teste de produto.

## A versão da rede é uma decisão de produto

Uma nova versão do grafo não precisa ser criada apenas quando há uma mudança
técnica.

Ela pode representar uma decisão de produto:

```text
support-graph 7.4.0
```

A versão `7.4.0` pode incluir:

- um novo agente de retenção;
- uma política mais restritiva para cancelamentos;
- recuperação de contexto aprimorada;
- aprovação humana para determinados casos;
- um modelo mais barato para solicitações simples.

Isso significa que a versão da rede pode ser ligada diretamente a métricas de
negócio:

```text
taxa de resolução
tempo médio de resposta
custo por conversa
taxa de transferência humana
taxa de erro
satisfação do cliente
```

O CTO deixa de observar apenas disponibilidade e latência. Passa a relacionar
cada composição da rede ao resultado produzido.

## Uma estratégia prática de versionamento

Para implementar essa abordagem, eu separaria o versionamento em quatro
dimensões.

**Versão do nó** identifica a implementação de um agente ou etapa.

```text
intent-classifier: 2.4.0
```

**Versão do contrato** identifica o formato e a semântica da comunicação.

```text
classified-intent.v3
```

**Versão do comportamento** identifica prompts, modelos, políticas e ferramentas.

```text
intent-classifier-runtime.14
```

**Versão do grafo** identifica a composição completa da rede.

```text
customer-support-graph: 7.3.0
```

A execução deve registrar as quatro.

Com isso, a organização consegue alterar um componente isoladamente sem perder a
capacidade de identificar qual sistema realmente estava em produção.

## O erro de versionar tudo como um monólito

Uma alternativa seria publicar uma única versão para a plataforma inteira:

```text
chatbot-platform: 12.7.0
```

Isso simplifica a comunicação, mas cria acoplamento operacional.

Uma pequena correção em um agente pode exigir uma nova versão global. Equipes
diferentes passam a depender da mesma janela de release. O rollback de um
componente pode obrigar a reversão de todos os outros.

No extremo oposto, versionar apenas os serviços individualmente também falha. A
empresa conhece as peças, mas não consegue reconstruir a composição.

A solução está no meio:

- nós com ciclos independentes;
- contratos explícitos;
- comportamento imutável;
- grafos versionados;
- releases reproduzíveis.

## Evoluir por substituição, não por reconstrução

A principal vantagem de representar o sistema como uma rede é mostrar que ele
pode evoluir pela substituição gradual de nós.

Um agente antigo pode continuar ativo enquanto o novo é avaliado. Um nó mais caro
pode ser usado apenas nos casos difíceis. Um componente especializado pode ser
adicionado a uma camada sem alterar os consumidores finais.

A plataforma deixa de ser uma esteira rígida e passa a ser uma rede evolutiva.

Mas essa flexibilidade só funciona quando sabemos exatamente:

- qual nó estava ativo;
- qual versão foi usada;
- qual contrato conectava os componentes;
- qual configuração determinava o comportamento;
- qual topologia produziu a saída.

Sem isso, a flexibilidade vira indeterminação.

## Comece pela versão do grafo

Versionar apenas os microserviços não permite reconstruir o sistema que produziu
uma resposta. A investigação precisa partir de outra pergunta:

> Qual versão da rede produziu esta decisão?

Se eu estivesse implementando esse fluxo, começaria registrando a versão do
grafo junto ao trace de cada execução. Depois acrescentaria as versões dos
contratos, prompts, modelos e ferramentas. Esse primeiro passo já transforma uma
investigação baseada em suposições em uma investigação baseada em evidências.
