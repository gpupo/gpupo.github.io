# Um agente ou vários? O que muda ao separar responsabilidades

Published: 2026-06-12
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/multiplos-agentes-especializados/
Tags: IA, Agentes, Desenvolvimento, Codificação

---

Tenho acompanhado experiências com subagentes e testado formas de separar o
trabalho em fluxos de desenvolvimento com IA. Vejo valor na divisão de
responsabilidades, mas ainda não considero que vários agentes devam ser a
escolha padrão.

A distinção mais útil, para mim, está entre executar tudo em uma única etapa e
separar o trabalho em papéis que possam ser inspecionados. Esses papéis podem
ser assumidos por um único agente em momentos diferentes ou distribuídos entre
vários agentes.

Um fluxo possível separa:

- planejamento;
- definição dos testes;
- implementação;
- revisão.

Primeiro vem o plano. Depois, os critérios de aceitação, a implementação e a
revisão do diff. A separação não determina quantos agentes devem participar;
ela apenas torna explícito o que precisa ser produzido e verificado em cada
momento.

## O que a divisão resolve

Quando tudo acontece em uma única etapa, o agente precisa interpretar o
objetivo, decidir a estratégia, editar os arquivos e avaliar o próprio
resultado. Isso concentra muitas decisões em uma saída difícil de auditar.

Quando os papéis são separados, cada etapa produz um artefato que pode ser
inspecionado. O plano pode ser corrigido antes do código. Os testes podem ser
discutidos antes de a implementação criar uma falsa sensação de progresso. A
revisão recebe uma mudança concreta, e não apenas a promessa de que a tarefa foi
concluída.

A divisão não cria capacidade automaticamente. Ela cria pontos de controle,
mesmo quando o mesmo agente executa todas as etapas.

## Um contrato entre as etapas

Para o fluxo funcionar, eu definiria uma entrada e uma saída para cada papel. Por exemplo:

| Etapa | Entrada | Saída esperada |
| --- | --- | --- |
| Planejamento | problema, contexto e restrições | plano com arquivos e riscos |
| Testes | plano e comportamento esperado | casos de aceitação |
| Implementação | plano aprovado e testes | diff executável |
| Revisão | diff, testes e contexto | achados e decisão de aprovação |

Com um único agente, há menos coordenação e maior continuidade de contexto, mas
a revisão pode repetir as mesmas suposições usadas na implementação. Com vários
agentes, é possível obter uma segunda leitura ou executar partes independentes
em paralelo, ao custo de mais contexto, coordenação e consumo.

Também é possível combinar modelos diferentes. Um modelo econômico pode
explorar o repositório ou preparar uma primeira versão. Um modelo mais capaz
pode revisar uma alteração crítica. Essa distribuição só faz sentido quando a
independência ou o paralelismo compensam o custo adicional.

## Onde manter uma pessoa no circuito

Eu manteria aprovação humana quando o plano altera arquitetura, toca dados sensíveis, modifica operações ou pode gerar um custo relevante. A pessoa não precisa revisar cada linha, mas deve entender a decisão e ter uma forma de interromper o fluxo.

Também é importante evitar um fluxo em que todas as etapas compartilham a mesma
suposição errada. Testes independentes, revisão com critérios claros e execução
em ambiente controlado continuam necessários, com um ou vários agentes.

Eu começaria separando os artefatos e os pontos de verificação. Depois decidiria
se o mesmo agente deve percorrer todas as etapas ou se alguma delas justifica um
agente independente. A escolha depende da complexidade, do custo de coordenação,
da necessidade de paralelismo e do risco de uma revisão repetir as mesmas
suposições da implementação.
