# AI Skills são fluxos reutilizáveis, não agentes

Published: 2026-04-18
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/ai-skills-como-capacidades-configuradas/
Tags: IA, Agentes, Desenvolvimento, Automação

---

No Codex, uma [skill](https://developers.openai.com/plugins/concepts/skills) não
é um agente independente. É um pacote de instruções, recursos e scripts
opcionais que ensina o agente a seguir um workflow reutilizável. O agente
continua responsável por interpretar a tarefa, carregar a skill adequada e
executar o trabalho.

Essa definição é mais útil do que tratar uma skill como um prompt longo que
“sabe fazer tudo”. Uma skill bem definida tem escopo, entrada, saída e critérios
para saber se o trabalho terminou.

## O contrato de uma skill

Eu descreveria cada skill com pelo menos:

- objetivo;
- contexto mínimo necessário;
- ferramentas que pode usar;
- arquivos ou sistemas que pode alterar;
- formato da saída;
- condições de parada;
- situações que exigem escalonamento.

Uma skill para revisar testes não deveria orientar alterações na arquitetura
inteira. Uma skill para consultar logs não deveria autorizar o reinício de um
serviço. A restrição deixa o workflow mais previsível.

## Estratégia, execução e timing

O operador define a estratégia, e o agente aplica as skills adequadas em cada
etapa. Isso permite combinar workflows diferentes: explorar um repositório,
escrever uma proposta, executar testes, revisar uma mudança ou resumir um
incidente.

O momento importa. Se o agente carregar uma skill de revisão antes de a
implementação existir, não terá o material necessário. Uma skill de compactação
aplicada tarde demais pode deixar o contexto caro. O fluxo precisa indicar
quando cada skill entra e qual evidência entrega para a próxima etapa.

## Como evitar um catálogo de skills confuso

Eu começaria com poucas skills e observaria:

1. quais tarefas cada uma realmente conclui;
2. onde o contexto costuma faltar;
3. quais ferramentas produzem risco;
4. quais saídas precisam de validação humana;
5. se a divisão reduz trabalho ou apenas adiciona coordenação.

Também registraria as execuções. Sem histórico, fica difícil saber se a skill melhorou o processo ou apenas produziu respostas mais longas.

O valor de uma skill não está em parecer autônoma. Está em tornar um workflow
reutilizável, limitado e observável. Com instruções, recursos e critérios de
conclusão explícitos, o agente deixa de depender de uma única conversa perfeita
e passa a executar responsabilidades que podem ser testadas.
