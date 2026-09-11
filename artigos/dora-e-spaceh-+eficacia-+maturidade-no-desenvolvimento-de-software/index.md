# DORA e SPACE medem coisas diferentes — e não são rankings de equipes

Published: 2023-05-19
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/dora-e-spaceh-+eficacia-+maturidade-no-desenvolvimento-de-software/
Tags: Engenharia de Software, Produtividade, Métricas

---

DORA e SPACE aparecem com frequência na mesma conversa porque ambos ajudam a observar o trabalho de engenharia de software. Eles não são, porém, duas escalas concorrentes de maturidade.

As métricas DORA descrevem resultados do processo de entrega de software. SPACE organiza diferentes dimensões da produtividade de quem desenvolve software. Uma equipe pode usar os dois referenciais, desde que formule a pergunta antes de escolher a métrica.

O erro começa quando o indicador vira objetivo: aumentar implantações, reduzir tempo de revisão ou contar contribuições sem verificar o efeito no produto, na estabilidade e nas pessoas.

## O que as métricas DORA observam

DORA é um programa de pesquisa sobre desempenho de entrega e operação de software. Seu conjunto de métricas evoluiu ao longo do tempo.

As quatro métricas historicamente conhecidas como *four keys* eram frequência de implantação, tempo de entrega de mudanças, taxa de falha de mudanças e tempo de recuperação. Em 2023, o antigo tempo de restauração foi refinado para **tempo de recuperação de implantação com falha**, delimitando incidentes causados por uma mudança. Em 2024, o modelo passou a incluir a **taxa de retrabalho de implantação**.

O [guia atual do DORA](https://dora.dev/guides/dora-metrics/) organiza cinco métricas em dois grupos.

**Vazão da entrega:**

- **tempo de entrega da mudança:** do commit à implantação bem-sucedida em produção;
- **frequência de implantação:** quantas implantações ocorrem em um período;
- **tempo de recuperação de implantação com falha:** quanto demora para recuperar o serviço após uma implantação que exige intervenção.

**Instabilidade da entrega:**

- **taxa de falha de mudanças:** proporção de implantações que exigem correção imediata, como rollback ou hotfix;
- **taxa de retrabalho de implantação:** proporção de implantações não planejadas realizadas para corrigir problemas.

Essa mudança histórica importa porque dashboards e artigos podem usar nomes ou definições de anos diferentes. Antes de comparar períodos, é necessário registrar qual definição foi aplicada.

DORA também recomenda medir no contexto de uma aplicação ou serviço. Agregar sistemas com riscos e processos diferentes ou transformar o resultado em competição entre equipes reduz a utilidade do dado.

## O que SPACE significa

SPACE não significa *Software Performance and Capability Evaluation* e não foi criado como avaliação de maturidade do processo.

O framework foi apresentado em 2021 por Nicole Forsgren, Margaret-Anne Storey, Chandra Maddila, Thomas Zimmermann, Brian Houck e Jenna Butler. O [artigo original](https://www.microsoft.com/en-us/research/publication/the-space-of-developer-productivity-theres-more-to-it-than-you-think/) parte de uma premissa: produtividade de desenvolvimento não pode ser representada por uma única atividade ou dimensão.

O acrônimo reúne cinco dimensões:

- **S — Satisfaction and well-being:** satisfação com o trabalho, ferramentas e cultura, além de aspectos de bem-estar;
- **P — Performance:** resultado ou valor produzido, observado no nível adequado ao sistema;
- **A — Activity:** ações ou produtos contabilizáveis durante o trabalho;
- **C — Communication and collaboration:** como pessoas e equipes coordenam o trabalho e compartilham informação;
- **E — Efficiency and flow:** capacidade de avançar com poucas interrupções, esperas e transferências desnecessárias.

Atividade é apenas uma dessas dimensões. Linhas de código, commits, tickets concluídos e revisões podem descrever ações, mas não demonstram sozinhos valor, qualidade ou produtividade.

SPACE também não entrega um placar universal. Ele funciona como estrutura para escolher um conjunto equilibrado de medidas de acordo com o objetivo e o nível analisado: indivíduo, equipe ou sistema. Algumas medidas vêm de telemetria; outras dependem da percepção das pessoas. Nenhuma das duas fontes é automaticamente superior.

## DORA e SPACE respondem a perguntas diferentes

Uma forma prática de separar os referenciais é começar pela pergunta.

| Pergunta | Referência mais próxima | Exemplo de medida |
|---|---|---|
| Quanto tempo uma mudança leva para chegar à produção? | DORA | Tempo de entrega da mudança |
| As implantações estão exigindo mais correções? | DORA | Taxa de falha e retrabalho |
| As interrupções impedem períodos de concentração? | SPACE | Eficiência e fluxo |
| As revisões promovem colaboração ou criam espera? | SPACE | Comunicação, colaboração e fluxo |
| O resultado melhorou sem degradar a experiência da equipe? | DORA e SPACE | Entrega, estabilidade, satisfação e fluxo |

Essa aproximação não implica causalidade. Se o tempo de entrega caiu depois de uma mudança no processo, o dado mostra uma associação temporal. Para atribuir a melhora à intervenção, é preciso considerar outras alterações, sazonalidade, tipo de demanda e qualidade da coleta.

## Um exemplo de plano de medição

Imagine uma equipe que acredita estar demorando demais para colocar correções pequenas em produção.

A hipótese pode ser escrita assim:

> Reduzir o tamanho dos lotes e automatizar uma etapa manual de aprovação diminuirá o tempo entre commit e implantação sem aumentar falhas ou sobrecarregar a equipe.

O plano poderia incluir:

- **resultado principal:** tempo de entrega da mudança;
- **contramétricas de estabilidade:** taxa de falha e tempo de recuperação de implantação com falha;
- **fluxo:** tempo em espera nas etapas de revisão e aprovação;
- **percepção:** avaliação periódica sobre interrupções e clareza do processo;
- **segmentação:** aplicação, tipo de mudança e período;
- **janela de avaliação:** definida antes da intervenção.

Essas medidas não precisam virar um índice único. Mantê-las separadas ajuda a enxergar tensões: a entrega pode ficar mais rápida enquanto o retrabalho ou a insatisfação aumentam.

## O que evitar

### Comparar equipes diferentes como se fossem equivalentes

Uma API interna, um aplicativo móvel e um sistema regulado possuem perfis de risco, implantação e demanda distintos. O valor está em acompanhar o mesmo contexto ao longo do tempo e investigar mudanças relevantes.

### Transformar a métrica em meta individual

Cobrar quantidade de commits, pull requests ou implantações incentiva divisão artificial do trabalho e outras formas de manipulação. Métricas de sistema devem orientar conversas sobre o sistema, não servir como nota de desempenho de uma pessoa.

### Medir apenas velocidade

Frequência e tempo de entrega precisam ser lidos ao lado de falhas, retrabalho, recuperação e resultados do produto. Velocidade sem estabilidade pode apenas deslocar o custo para produção.

### Coletar tudo antes de formular a pergunta

Uma plataforma sofisticada de métricas pode custar mais do que a decisão que pretende apoiar. Começar com uma hipótese, poucas medidas e definições explícitas torna a interpretação mais segura.

### Tratar correlação como receita

Os referenciais ajudam a observar padrões e restrições. Eles não garantem que copiar a prática de outra organização produzirá o mesmo efeito local.

Quando essa investigação precisa abranger arquitetura, segurança, qualidade, operação e produtividade, o [Assessment de Maturidade Técnica da BP STRAT](https://www.bpstrat.com.br/servicos/maturidade-tecnica.html) organiza essas dimensões em uma avaliação estruturada.

## Métricas devem iniciar uma investigação

DORA ajuda a observar vazão e instabilidade da entrega. SPACE impede que produtividade seja reduzida a uma contagem de atividade. Juntos, podem ampliar a análise, mas não substituem a definição do problema nem explicam sozinhos por que um indicador mudou.

Uma boa implementação registra definições, contexto e limitações; combina resultados técnicos e experiência das pessoas; e usa os números para escolher o próximo problema a investigar. O objetivo não é alcançar uma pontuação abstrata de maturidade. É aprender se uma mudança tornou o sistema de trabalho mais capaz de entregar resultados sustentáveis.
