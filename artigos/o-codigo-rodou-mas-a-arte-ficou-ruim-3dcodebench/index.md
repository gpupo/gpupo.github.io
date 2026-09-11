# O código rodou, mas a arte ficou ruim: o que o 3DCodeBench revela sobre IA e modelagem 3D

Published: 2026-08-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/o-codigo-rodou-mas-a-arte-ficou-ruim-3dcodebench/
Tags: Inteligência Artificial, Modelos de linguagem, Agentes de IA, Blender, 3D, Benchmarks

---

Eu estava com meu filho olhando o desempenho de modelos de linguagem na construção de objetos 3D. Eu, como criador de conteúdo, via ali um assunto interessante. Ele fazia uma cara pouco entusiasmada com a ideia de usar inteligência artificial para fazer arte em 3D.

Então abrimos o [3DCodeBench](https://www.3dcodebench.com/), um benchmark criado por pesquisadores do Google DeepMind, Google Research e University of Southern California. Entre tabelas, modelos e métricas, também vimos exemplos visualmente ruins: formas simplificadas demais, partes desconectadas e objetos que até lembravam a referência, mas pareciam montados sem compreender como suas peças deveriam ocupar o mesmo espaço.

A cara feia dele ganhou um argumento.

Mas o benchmark também ajuda a tornar a conversa mais precisa. A pergunta não é apenas se uma IA consegue “fazer arte 3D”. O teste avalia se modelos multimodais conseguem escrever código Python para o Blender, executar esse código, observar erros e produzir uma geometria procedural parecida com uma referência.

Isso envolve programação, percepção visual, raciocínio espacial e uso de ferramentas. Arte é uma discussão ainda maior.

## O que o 3DCodeBench realmente mede

Na modelagem procedural, o objeto não nasce apenas de uma malha manipulada manualmente. Ele é descrito por regras e código: dimensões, proporções, repetições, transformações, materiais e relações entre partes.

Essa abordagem tem vantagens importantes. O resultado pode ser determinístico, editável e reproduzível. Em vez de receber uma forma fechada produzida por um gerador neural, o artista ou desenvolvedor recebe um programa que pode alterar e executar novamente.

O [paper do 3DCodeBench](https://arxiv.org/abs/2606.01057) usa o Blender 5.0 como ambiente de execução. Dado um texto ou um conjunto de imagens de referência, o modelo precisa gerar um script Python que construa o objeto do zero. O benchmark reúne 212 categorias, incluindo animais, plantas, móveis, utensílios e fragmentos arquitetônicos.

Não são apenas cubos empilhados. O paper informa uma mediana de 387 linhas por script de referência e uma média de 531. Categorias como pássaros, caranguejos e libélulas exigem centenas de linhas de código e relações geométricas mais difíceis do que combinar primitivas simples.

O projeto também disponibiliza um corpus maior, o 3DCodeData, com 12.720 instâncias procedurais, código Blender, objetos GLB e 52 mil renderizações em múltiplos ângulos. O [código do benchmark está disponível no GitHub](https://github.com/gaoypeng/3dcodebench), junto com as tarefas e métricas usadas na avaliação.

## Executar não é modelar bem

A primeira métrica é objetiva: o script executa no Blender e produz uma malha não vazia?

Essa pergunta é necessária, mas insuficiente. Um código pode rodar perfeitamente e produzir um peixe com partes flutuando, uma pia estruturalmente estranha ou uma lagosta formada por volumes que não parecem pertencer ao mesmo corpo.

Por isso, o benchmark combina diferentes avaliações:

- **Executabilidade:** o código roda no Blender e produz uma malha?
- **Similaridade visual:** as renderizações se parecem com as imagens de referência segundo SigLIP-2 e DINOv3?
- **Similaridade geométrica:** a malha se aproxima da referência segundo Chamfer Distance e Uni3D?
- **Preferência humana:** qual resultado as pessoas preferem quando comparam duas alternativas na 3DCodeArena?

Essa separação explica parte das artes ruins que vimos. O modelo pode conhecer Python, lembrar nomes da API do Blender e produzir uma cena válida sem compreender bem anatomia, apoio, continuidade, espessura ou alinhamento estrutural.

Em outras palavras: passar no compilador não significa passar no olhar.

## O ranking mostra competências diferentes

Na tabela pública de resultados *single-shot* para texto em 3D, consultada em 6 de agosto de 2026, alguns números chamavam a atenção:

| Modelo | Execução no Blender | Elo de preferência humana |
| --- | ---: | ---: |
| GPT-5.5 | 87,3% | 1167 |
| Gemini 3.1 Pro | 69,3% | 1149 |
| Gemini 3.5 Flash | 41,0% | 1112 |
| Claude Opus 4.7 | 88,1% | 1008 |

O Elo da arena é dinâmico e pode mudar com novos votos, por isso essa tabela é um retrato, não um ranking eterno.

Ainda assim, ela mostra algo importante. Claude Opus 4.7 apresentou uma taxa de execução ligeiramente maior que GPT-5.5 nesse recorte, mas ficou bem abaixo na preferência humana. Gemini 3.5 Flash executou menos da metade dos casos em uma única tentativa, porém os resultados que chegaram à arena foram relativamente bem avaliados.

As métricas não estão medindo a mesma competência. Uma fala sobre confiabilidade de código. Outra tenta capturar semelhança e qualidade percebida. Comparar apenas a taxa de execução premiaria modelos capazes de construir alguma coisa, mesmo quando essa coisa é visualmente fraca.

Também existe um cuidado estatístico: comparações de qualidade normalmente consideram os casos que foram executados com sucesso. Um modelo pode produzir poucos objetos, mas ter bons resultados entre os sobreviventes. Outro pode executar quase tudo e expor também uma cauda maior de geometrias medíocres.

## Os agentes consertam o código, não necessariamente a forma

O aspecto mais útil do estudo é que ele não para na geração em uma única tentativa.

Em um dos experimentos, quando o script falha, o modelo recebe o código anterior e o traceback do Blender. Ele pode tentar novamente até duas vezes. Esse ciclo elevou a executabilidade agregada de aproximadamente 70% para 97%, um ganho superior a 27 pontos percentuais.

A maior parte da melhora veio de erros localizados na API do Blender 5.0. Com acesso ao traceback, os modelos conseguem trocar uma chamada incompatível, corrigir um parâmetro ou ajustar um trecho de código. É um cenário conhecido para quem trabalha com agentes de programação: a ferramenta fornece uma evidência objetiva, e o modelo usa essa evidência para reparar a implementação.

O benchmark também colocou os modelos dentro de agentes de código como Codex CLI, Claude Code, Gemini CLI e Antigravity. Com autonomia para escrever o arquivo, executar o Blender e editar o resultado, a taxa de sucesso ficou próxima do teto.

Mas aqui aparece a diferença decisiva: entre os scripts que já executavam, o agente praticamente não melhorou a qualidade condicional das formas. No paper, a variação média foi de apenas -0,010 em similaridade visual SigLIP-2, +0,001 em Chamfer Distance e -0,003 em similaridade Uni3D.

O agente resolveu erros de software. Ele não passou a compreender muito melhor o objeto.

Esse resultado é uma boa vacina contra demonstrações superficiais. Ver um agente abrindo o Blender, executando comandos e terminando com uma malha na tela é impressionante. Mas a atividade visível da automação não prova que o resultado tenha coerência geométrica, qualidade estética ou utilidade profissional.

## Por que algumas artes ficam tão ruins

Os autores apontam a plausibilidade física como o principal gargalo depois da executabilidade. Nos exemplos qualitativos, os modelos capturam silhuetas básicas, mas produzem partes desconectadas, fragmentos geométricos e primitivas flutuantes.

Isso faz sentido porque um objeto 3D exige relações que uma imagem isolada pode esconder.

Uma perna precisa realmente encontrar o assento. Uma torneira precisa estar conectada à cuba. As partes de um animal precisam funcionar em vários ângulos, não somente na vista que favorece a ilusão. Espessura, simetria e centro de massa precisam permanecer coerentes quando a câmera gira.

O benchmark fornece até quatro vistas de referência em alguns experimentos. Mesmo assim, aumentar de uma para quatro imagens não trouxe ganhos consistentes depois das primeiras vistas. Mais pixels não resolveram automaticamente a falta de um modelo interno robusto sobre estrutura tridimensional.

Há também uma diferença entre reconhecer e construir. Um modelo pode identificar imediatamente que uma imagem mostra uma lagosta. Construí-la por código exige decompor o corpo em volumes, definir articulações, preservar proporções e escrever operações válidas para o Blender. O nome do objeto cabe em uma palavra; sua geometria não.

## Onde a IA pode ajudar um artista 3D

As limitações do benchmark não tornam a tecnologia inútil. Elas ajudam a escolher tarefas compatíveis com o que ela sabe fazer hoje.

Um sistema desse tipo pode ser útil para:

- criar uma primeira estrutura procedural editável;
- gerar variações paramétricas de um objeto;
- automatizar elementos repetitivos;
- converter uma descrição em um ponto de partida no Blender;
- experimentar proporções antes do refinamento manual;
- produzir código que um artista técnico possa revisar;
- acelerar protótipos e objetos secundários de uma cena.

O erro começa quando “ponto de partida” vira “obra concluída” apenas porque o processo terminou sem mensagens vermelhas.

Para um criador, a possibilidade mais interessante talvez não seja pedir que o modelo substitua a autoria. É usar o código gerado como material intermediário: algo que pode ser inspecionado, corrigido, parametrizado e incorporado a um processo maior.

Isso é diferente de apertar um botão e aceitar qualquer malha que aparecer.

## O benchmark não mede arte inteira

Também seria injusto usar o 3DCodeBench como uma sentença definitiva sobre IA e arte.

O teste mede a reconstrução procedural de categorias específicas no Blender. Ele não mede intenção artística, originalidade, narrativa, estilo, direção de arte ou a relação de uma peça com o restante de uma obra. A arena registra preferências humanas sobre formas geradas, mas não transforma gosto e significado em uma escala completa.

O próprio conjunto de referência nasce de fábricas procedurais do Infinigen e passa por uma curadoria com agentes, ferramentas de validação e revisão humana. É um ambiente muito mais controlado do que o trabalho aberto de um artista diante de uma ideia nova.

Portanto, existem duas conclusões ruins que devemos evitar:

1. “Alguns resultados ficaram feios, então IA nunca terá utilidade em 3D.”
2. “Quase todos os scripts executaram com agentes, então artistas 3D serão substituídos.”

O benchmark não sustenta nenhuma das duas.

## A cara feia continua sendo importante

No fim, a reação do meu filho me pareceu mais valiosa do que uma aceitação automática da tecnologia.

Ferramentas de IA chegam acompanhadas de uma pressão para admirar o processo: o prompt, o agente abrindo programas, o código aparecendo, a renderização pronta em poucos minutos. Quem olha primeiro para a qualidade do objeto pode parecer resistente, mas está fazendo uma pergunta essencial: ficou bom?

O 3DCodeBench mostra que os modelos avançaram bastante na parte mensurável da engenharia. Eles escrevem scripts complexos, corrigem erros quando recebem feedback e conseguem produzir objetos executáveis em uma ampla variedade de categorias.

Também mostra que ainda existe uma distância entre dominar a interface de uma ferramenta e compreender forma, estrutura e intenção.

Para mim, essa é a parte mais interessante da conversa entre criação e inteligência artificial. O código pode rodar. A automação pode terminar. O benchmark pode registrar sucesso.

E a arte ainda pode estar ruim.

### Referências

- [3DCodeBench — página do projeto](https://www.3dcodebench.com/)
- [Paper no arXiv: 3DCodeBench: Benchmarking Agentic Procedural 3D Modeling Via Code](https://arxiv.org/abs/2606.01057)
- [Código-fonte e instruções de reprodução](https://github.com/gaoypeng/3dcodebench)
- [3DCodeArena e leaderboard](https://www.3dcodebench.com/leaderboard)
