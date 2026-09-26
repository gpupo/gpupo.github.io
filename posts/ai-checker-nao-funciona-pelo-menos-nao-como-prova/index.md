# AI checkers: por que um score não prova uso de IA

Published: 2026-08-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/ai-checker-nao-funciona-pelo-menos-nao-como-prova/
Tags: Inteligência Artificial, Detecção de IA, Integridade acadêmica, Educação, LLM

---

Nos últimos dias li vários relatos no Threads de pessoas fazendo um experimento simples: pegar um texto antigo, escrito muito antes do ChatGPT existir, e jogar em uma dessas ferramentas que prometem detectar conteúdo produzido por inteligência artificial.

Um TCC escrito e aprovado em 2008 apareceu como texto de IA.

Uma tese de 2007 também.

Outra pessoa colocou um texto de 2008 e recebeu algo como 30% de conteúdo produzido por IA.

Alguém até comentou que iria procurar um trabalho de 1999 para fazer o mesmo teste.

Esses relatos não formam uma amostra controlada. Servem aqui como ponto de partida, não como medida da precisão dessas ferramentas.

É engraçado até você lembrar que alguém pode estar usando exatamente esse tipo de ferramenta para decidir se outra pessoa fraudou um trabalho acadêmico.

E aí deixa de ser engraçado.

## O problema começa no nome

“AI checker” passa uma sensação de certeza que a tecnologia simplesmente não oferece.

Não existe ali uma máquina do tempo tentando descobrir quem escreveu o texto.

O detector recebe o texto pronto e procura características estatísticas que considera mais compatíveis com textos humanos ou textos produzidos por determinados modelos.

É uma **classificação probabilística**.

Isso é muito diferente de comprovar a procedência do texto.

Se eu pegar um documento que escrevi em 2008 e um detector disser que ele “parece ter sido escrito por IA”, nós temos uma informação interessante sobre **o detector**.

Não sobre quem escreveu meu documento.

## E AI checker não é detector de plágio

Outra confusão apareceu várias vezes nas discussões que li.

Plágio e geração por IA não são a mesma coisa.

Um detector de similaridade pode encontrar trechos de um texto que aparecem em outras fontes e apresentar essas correspondências para análise.

Já um detector de IA tenta inferir alguma coisa sobre **como aquele texto teria sido produzido**.

São problemas completamente diferentes.

Um texto escrito por IA pode ser original e não conter plágio.

Um texto escrito por uma pessoa pode conter plágio.

E um texto completamente original, escrito por uma pessoa em 2007, pode perfeitamente ser classificado por um detector como “provavelmente produzido por IA”.

O score não transforma uma hipótese em evidência.

## Isso não é apenas história de Threads

O interessante é que as próprias empresas envolvidas reconhecem o problema.

A [OpenAI chegou a lançar seu próprio classificador de textos em 2023](https://openai.com/index/new-ai-classifier-for-indicating-ai-written-text/). Nos testes publicados pela empresa, ele identificava apenas **26% dos textos produzidos por IA** como “provavelmente escritos por IA” e classificava incorretamente **9% dos textos humanos** como produzidos por IA.

Em 20 de julho de 2023, a OpenAI retirou a ferramenta do ar justamente por causa da baixa precisão.

Também existe pesquisa acadêmica testando essas ferramentas.

Um [estudo publicado no *International Journal for Educational Integrity*](https://doi.org/10.1007/s40979-023-00146-z) avaliou 14 detectores, incluindo serviços comerciais usados no meio acadêmico. A conclusão dos pesquisadores foi bastante direta: as ferramentas testadas não eram suficientemente precisas nem confiáveis para serem usadas como evidência de má conduta acadêmica.

Outro trabalho, [publicado na revista *Patterns* por pesquisadores de Stanford](https://doi.org/10.1016/j.patter.2023.100779), encontrou um problema ainda mais preocupante.

Ao testar sete detectores em textos de pessoas que não tinham o inglês como língua nativa, os pesquisadores encontraram uma taxa média de falso positivo de **61,3%** nos ensaios analisados. Textos perfeitamente humanos estavam sendo classificados como IA simplesmente porque determinadas características linguísticas também pareciam “previsíveis” para os detectores.

Ou seja: além de errar, o detector pode errar de maneira desigual dependendo da forma como alguém escreve.

## Até quem vende a ferramenta pede cautela

Talvez esse seja o detalhe mais importante.

A [própria Turnitin diz atualmente em sua documentação](https://guides.turnitin.com/hc/en-us/articles/22774058814093-Using-the-AI-Writing-Report) que seu modelo **pode classificar incorretamente tanto textos humanos quanto textos produzidos por IA** e que o resultado não deve ser utilizado isoladamente para tomar medidas contra um estudante.

A empresa inclusive deixou de exibir percentuais entre 1% e 19% justamente para reduzir problemas relacionados a falsos positivos.

Em [outra orientação](https://guides.turnitin.com/hc/en-us/articles/27139000787853-How-should-I-review-the-AI-Writing-report), a Turnitin é ainda mais clara: o score deve ser tratado como **um dado dentro de uma investigação**, não como uma resposta definitiva.

Isso muda bastante a conversa.

Porque existe uma enorme diferença entre:

> “Essa ferramenta encontrou um sinal que talvez mereça investigação.”

e:

> “O detector mostrou que você usou IA.”

A segunda frase simplesmente não decorre da primeira.

## O falso positivo é o problema mais perigoso

Podemos discutir durante horas quantos textos de IA passam despercebidos pelos detectores.

Esse é um problema técnico interessante.

Mas, em ambientes educacionais e profissionais, considero o falso positivo muito mais sério.

Porque agora temos uma pessoa real precisando provar que escreveu aquilo que escreveu.

Imagine alguém apresentar uma dissertação, artigo, relatório ou TCC e ouvir:

“Nosso sistema indicou 78% de IA.”

Como essa pessoa prova o contrário?

Mostra os commits?

Os rascunhos?

O histórico de edição?

As fontes?

As versões anteriores?

O documento de 2008?

Curiosamente, todas essas coisas são evidências muito melhores de autoria do que o percentual apresentado pelo detector.

## Talvez estejamos tentando resolver o problema errado

A pergunta interessante talvez não seja:

**“Como descobrir se este texto foi escrito por IA?”**

Mas:

**“Como verificar o processo pelo qual este trabalho foi produzido?”**

São perguntas diferentes.

Em educação, isso pode significar acompanhar versões, referências, raciocínio, discussão oral, rascunhos e capacidade do aluno de explicar aquilo que entregou.

Em empresas, pode significar revisão, rastreabilidade, responsabilidade sobre o conteúdo e validação das afirmações.

E isso continua funcionando mesmo quando IA participa do processo.

Porque essa é outra complicação de 2026: entre “escrito por humano” e “escrito por IA” existe um território gigantesco.

Uma pessoa pode escrever e pedir revisão.

Pode pesquisar com IA.

Pode pedir sugestões.

Pode reescrever um parágrafo.

Pode traduzir.

Pode usar autocomplete.

Pode produzir um primeiro rascunho com IA e substituir metade dele.

Qual percentual disso transforma o documento em “texto de IA”?

A própria pergunta começa a perder sentido.

## Então AI checker não funciona?

Depende do significado de “funcionar”.

Se significa **produzir um sinal estatístico que pode servir como ponto de partida para uma análise**, algumas ferramentas certamente conseguem fazer isso.

Se significa:

**“coloque o texto aqui e descubra se uma pessoa usou IA”**,

não.

E muito menos:

**“use esse número como prova para acusar alguém.”**

Os relatos que encontrei no Threads são interessantes justamente porque tornam o problema absurdamente concreto.

Um documento de 2008 não poderia ter sido escrito pelo ChatGPT.

Se o detector diz que foi, não descobrimos uma conspiração envolvendo viagem no tempo e inteligência artificial.

Descobrimos um **falso positivo**.

E talvez a lição mais importante seja esta:

**um score de detector de IA é uma opinião estatística de outro modelo.**

Não é autoria.

Não é procedência.

Não é plágio.

E definitivamente não deveria ser tratado como prova.
