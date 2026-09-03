# Agent decide, Crew colabora e Flow orquestra sistemas com IA

Published: 2026-08-20
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/agent-crew-flow-nao-sao-a-mesma-coisa/
Tags: Agentes de IA, Arquitetura de software, Orquestração, Crew, Flow

---

Uma análise de um agente financeiro me deixou com dois problemas diferentes.

As respostas eram mais lentas do que deveriam para perguntas simples. E, em
um caso documentado, a mesma pergunta, para a mesma conta, produziu seis
números diferentes em seis tentativas — nenhum deles correto.

Na configuração analisada, uma única `Crew` hierárquica reunia 12 membros e
recebia uma tarefa genérica. Era fácil atribuir todos os problemas à
orquestração. Mas os dois sintomas apontavam para camadas diferentes: o
roteamento podia estar caro e pouco preciso; a aritmética precisava de uma
fonte independente do modelo.

Não trato esse caso como benchmark. Ele é a observação de uma configuração
específica e de uma proposta que ainda estava em discussão. O que ele mudou foi
minha forma de nomear as responsabilidades.

<figure>
  <img src="/assets/images/agent-crew-flow-orchestration.png" alt="Diagrama em estilo de esboço mostrando agentes e ferramentas distribuídos ao redor de um fluxo com etapas de execução e validação" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Uma leitura visual da composição: agentes interpretam e decidem, o fluxo coordena etapas e o software executa e verifica operações concretas.</figcaption>
</figure>

## Agent é autonomia

Minha definição de trabalho é simples: um `Agent` recebe um objetivo, interpreta
o contexto disponível, pode usar ferramentas e escolhe como avançar.

O valor está na liberdade sobre o caminho. Um agente pode investigar uma
situação, escolher uma fonte, comparar alternativas ou decidir qual especialista
deve ser consultado.

Isso não quer dizer que toda tarefa interpretativa precisa de um agente
independente. Um único Agent pode executar várias etapas de investigação quando
elas pertencem ao mesmo objetivo e não precisam de coordenação entre papéis.

O limite aparece quando a tarefa já tem uma sequência conhecida e uma regra
exata de saída. Para calcular uma soma ou verificar uma igualdade, autonomia
não acrescenta julgamento útil. Pode apenas introduzir variação.

## Crew é colaboração

Uma `Crew` é uma equipe de Agents. Mas uma lista de Agents não forma uma equipe
automaticamente.

Eu usaria essa abstração quando existe colaboração real, por exemplo:

- um agente delega uma parte do problema a outro;
- o resultado de um especialista muda a investigação do seguinte;
- os participantes compartilham contexto e dependem uns dos outros;
- alguém precisa escolher dinamicamente quais especialistas serão envolvidos.

Na análise que motivou esta série, a relação de delegação dinâmica aparecia
principalmente no núcleo de Soluções, que podia escolher entre quatro
executores. Outros especialistas tinham domínio próprio, produziam uma análise
ou apenas traduziam um resultado. Colocá-los na mesma `Crew` não transformava
essas atividades em colaboração.

Uma Crew começa a fazer sentido quando a cooperação é parte do trabalho, não
quando queremos que o diagrama pareça mais sofisticado.

## Flow é o processo

Existe uma responsabilidade diferente: decidir a ordem e as condições da
execução.

O `Flow` pode determinar:

- qual caminho uma solicitação seguirá;
- quais etapas rodam em paralelo;
- quando os resultados serão consolidados;
- quais erros permitem nova tentativa;
- quando uma validação interrompe o processo;
- quando é necessária aprovação humana.

Minha definição ficou assim:

**Agent é a unidade de autonomia.**

**Crew é a unidade de colaboração.**

**Flow é a unidade de orquestração.**

Flow não significa que tudo dentro dele seja determinístico. Ele pode chamar um
LLM para interpretar uma pergunta, executar código para calcular um valor,
consultar uma API e pedir revisão humana. O que o define é tornar o processo
explícito e controlável.

## Quando tudo vira uma Crew

Um desenho como este pode parecer completo:

```text
Crew

├── Agent de classificação
├── Agent especialista
├── Agent calculador
├── Agent auditor
└── Agent redator
```

Mas ele mistura responsabilidades de naturezas diferentes:

- classificação e interpretação podem justificar uma chamada a modelo;
- cálculo deve seguir uma regra executável;
- validação factual precisa comparar valores ou invariantes;
- redação pode usar um LLM depois que os fatos estiverem fechados;
- roteamento, retry e parada pertencem ao processo.

Dar o nome `Agent` a cada caixa não resolve essa mistura. Apenas torna
probabilísticas tarefas que talvez pudessem ser testadas com uma entrada e uma
saída bem definidas.

## Um vocabulário para decidir a implementação

Antes de criar um Agent, eu classificaria a responsabilidade:

| Responsabilidade | Abstração que eu avaliaria primeiro | Critério principal |
| --- | --- | --- |
| Interpretar linguagem ambígua | LLM ou Agent | Há contexto ou julgamento a explorar? |
| Consultar um sistema externo | Tool | Existe um contrato de entrada e saída? |
| Somar, contar ou comparar | Código | A mesma entrada deve produzir a mesma saída? |
| Escolher o próximo caminho | Flow | A regra de roteamento precisa ser observável? |
| Delegar entre especialistas | Crew | O trabalho realmente muda conforme as contribuições? |
| Explicar o resultado | LLM | Os fatos já foram calculados e validados? |

Essa tabela não é uma taxonomia universal. É um filtro para evitar que a
primeira decisão seja “qual Agent vamos criar?”. A pergunta anterior é “qual
tipo de responsabilidade existe aqui?”.

## Menos Agents pode concentrar autonomia

Retirar cálculo, retry, permissões e regras de parada de um Agent não reduz
necessariamente o uso de IA. Minha interpretação é a oposta: a autonomia fica
concentrada onde ela ajuda a lidar com ambiguidade, investigação e julgamento.

O Agent pode operar dentro de estruturas que garantem limites, estado e
repetibilidade. Ele não precisa substituir o código que já sabe executar essas
funções.

Quando desenho uma arquitetura nova, começo então por uma lista de
responsabilidades. Só depois decido quais delas serão Agent, Crew, Flow, Tool
ou código.

No [próximo texto da série](/posts/flow-por-fora-agents-onde-autonomia-agrega/), aplico essa separação a um chatbot que consulta informações financeiras.
