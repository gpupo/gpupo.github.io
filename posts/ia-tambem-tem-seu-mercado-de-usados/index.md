# IA também tem seu mercado de usados

Published: 2026-08-13
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/ia-tambem-tem-seu-mercado-de-usados/
Tags: Inteligência Artificial, Modelos de linguagem, Engenharia de Software, Agentes de IA, Arquitetura de software

---

No mercado de usados, vejo anúncios de **Core i7 de 4ª geração** escritos como se fossem tecnologia recém-lançada.

“Processador i7.”
“Máquina profissional.”
“Alta performance.”

Tecnicamente, não há mentira. Continua sendo um i7. O problema é o contexto que desapareceu.

Aquele processador pertence a outra geração de hardware, outra expectativa de desempenho, outro consumo, outra plataforma. Enquanto isso, a Intel mudou gerações, arquiteturas e até a forma de nomear seus processadores.

Quando olho minha timeline sobre inteligência artificial, às vezes tenho exatamente a mesma sensação.

<figure>
  <img src="/assets/images/ia-mercado-de-usados.png" alt="Computador antigo com etiqueta Core i7 de quarta geração, processador Intel e caderno com arquitetura de IA ao lado de uma timeline de 2018 a 2026" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Uma técnica pode continuar válida, mesmo quando a camada da solução em que ela vive muda.</figcaption>
</figure>

Vejo posts anunciando como novidade técnicas que já passaram por várias gerações de uso:

> “Descobri que você precisa dar contexto para a IA.”

Sim.

> “O segredo é dividir o problema em etapas.”

Também.

> “Você pode criar agentes especializados.”

Claro.

> “É melhor fornecer exemplos do resultado esperado.”

Few-shot prompting já discutia isso há anos.

> “Você precisa avaliar a saída do modelo, não apenas confiar nela.”

Bem-vindo à engenharia de software.

O problema não é alguém descobrir algo que já existia. **Redescobrir faz parte do aprendizado.**

O problema começa quando uma técnica antiga é apresentada sem timeline, sem contexto e sem explicar **em qual geração tecnológica ela fazia sentido**.

É o equivalente a vender um i7 de 4ª geração destacando apenas o adesivo “Core i7”.

## Em IA, o nome da técnica envelhece mais devagar que a tecnologia

Isso gera uma confusão interessante: um conceito pode continuar válido enquanto sua implementação muda completamente.

RAG continua sendo útil.

Mas o RAG de 2023 não é necessariamente a arquitetura que eu escolheria em 2026.

Prompt engineering continua existindo.

Mas gastar horas procurando uma frase mágica para obrigar o modelo a seguir uma instrução perdeu importância relativa quando comparado a trabalhar com:

* contexto estruturado;
* arquivos de instrução;
* tools;
* MCP;
* memória;
* validação automática;
* evals;
* structured outputs;
* agentes executando código;
* loops de teste;
* modelos com contextos muito maiores.

O conceito sobrevive.

**O que muda é a proporção da solução ocupada por ele.**

Quando alguém diz:

> “Você precisa aprender prompt engineering.”

Minha primeira pergunta hoje seria:

**qual prompt engineering?**

Aquele de tentar comprimir toda a inteligência da aplicação em um prompt gigante?

Ou o de construir um ambiente no qual o modelo recebe contexto, ferramentas, restrições, feedback e critérios de validação?

São coisas bem diferentes.

## A unidade de trabalho mudou

Talvez essa seja uma das maiores mudanças que aconteceram silenciosamente.

No começo da popularização dos LLMs, a unidade de interação era praticamente:

**humano → prompt → modelo → resposta**

Depois passou a ser:

**aplicação → contexto → modelo → resposta estruturada**

Hoje, em muitos dos meus projetos, penso mais em:

**objetivo → agente → ferramentas → execução → observação → correção → resultado**

O prompt continua lá.

Mas deixou de ser o produto inteiro.

É parecido com programação. O código-fonte continua importante, mas ninguém descreve um sistema moderno olhando apenas para uma função isolada.

Existem bancos de dados, infraestrutura, observabilidade, testes, filas, APIs, configuração, segurança e operação.

Com agentes, começa a acontecer a mesma coisa.

## Algumas discussões envelhecem muito rápido

Essa velocidade cria um fenômeno estranho.

Um post tecnicamente correto publicado há dois anos pode hoje ensinar uma arquitetura pela qual eu não recomendaria começar.

Não porque estivesse errado.

Porque estava certo **para aquela geração de modelos e ferramentas**.

Context windows eram menores. Tool calling era mais limitado. Modelos eram piores seguindo instruções. Structured outputs eram menos confiáveis. Modelos locais tinham capacidades menores. A infraestrutura em volta dos modelos também estava menos madura.

As soluções naturalmente compensavam essas limitações.

Por isso, tenho cada vez mais cuidado quando encontro artigos com títulos como:

**“A arquitetura definitiva para agentes de IA.”**

Minha primeira pergunta não é mais “funciona?”.

É:

**quando isso foi escrito?**

Em IA, a data passou a fazer parte da arquitetura.

## Técnicas não ficam inúteis. Elas mudam de camada.

Esse talvez seja o ponto que mais me interessa.

Não acho que técnicas antigas simplesmente morram.

Elas descem de camada.

Aquilo que ontem exigia um artigo inteiro hoje pode virar uma linha de configuração.

O que exigia código próprio pode virar funcionalidade do modelo.

Um pipeline sofisticado pode ser substituído por um contexto maior.

Algo que dependia de prompt pode migrar para uma ferramenta.

E algo que dependia do modelo pode migrar para validação determinística.

É uma evolução parecida com a de outras áreas da computação. Já implementamos manualmente muita coisa que depois virou biblioteca, framework, runtime, sistema operacional ou hardware.

A abstração sobe.

O conhecimento anterior continua útil, principalmente para entender **por que aquela abstração existe**.

## O risco é otimizar para limitações que já desapareceram

É aqui que uma arquitetura velha começa a custar caro.

Imagine projetar hoje um sistema inteiro assumindo que o modelo só consegue trabalhar com alguns milhares de tokens.

Ou construir uma enorme camada de parsing porque partimos do pressuposto de que o modelo não consegue retornar JSON de maneira confiável.

Ou criar cinco agentes apenas porque um modelo antigo não conseguia manter contexto suficiente para executar a tarefa inteira.

Talvez ainda existam bons motivos para fazer tudo isso.

Mas essas escolhas precisam voltar a ser **decisões, não dogmas**.

Uma técnica pode continuar válida e, ao mesmo tempo, deixar de ser necessária para o problema que você tem.

## O benchmark deveria vir antes do framework

Tenho tentado inverter a ordem.

Antes de perguntar:

> “Qual arquitetura de agente devo usar?”

Prefiro perguntar:

> “O modelo atual consegue resolver esse problema sozinho?”

Começo pelo caso mais simples possível.

Modelo.

Contexto.

Ferramentas mínimas.

Dataset de teste.

Métrica.

Se funcionar, paro ali.

Se não funcionar, adiciono uma camada: RAG, memória, agente especializado, workflow, validação, outro modelo, fine-tuning.

Só adiciono complexidade quando consigo apontar **qual falha aquela complexidade está corrigindo**.

Parece óbvio, mas boa parte do conteúdo sobre IA faz o contrário.

Começa pelo framework.

Depois procura um problema que justifique a arquitetura.

## Complexidade herdada também existe em IA

Na engenharia de software, estamos acostumados a falar de legado.

Código legado.

Arquitetura legada.

Infraestrutura legada.

Estou começando a enxergar também uma espécie de **legado conceitual de IA**.

São soluções carregadas de decisões tomadas para contornar limitações de modelos anteriores:

prompts gigantescos, pipelines enormes, fragmentação excessiva, agentes demais, RAG aplicado automaticamente, frameworks empilhados, camadas de abstração que ninguém mais sabe exatamente por que existem.

Tudo continua funcionando.

Então ninguém mexe.

Até que alguém executa o mesmo problema com um modelo atual, 200 linhas de código e duas ferramentas e pergunta:

> “Por que temos tudo isso?”

É o equivalente a abrir um servidor antigo e descobrir um Xeon enorme fazendo um trabalho que um pequeno computador moderno executaria consumindo uma fração da energia.

## O contexto histórico virou parte da competência técnica

Por isso, acho que trabalhar com IA hoje exige uma habilidade que nem sempre aparece nas listas de competências:

**saber posicionar uma técnica na timeline.**

Não basta perguntar se a técnica funciona.

Também preciso entender **qual problema ela resolvia, qual limitação existia quando surgiu e se essa limitação ainda existe**.

Preciso saber se o modelo atual já absorveu parte daquela responsabilidade e se o custo da arquitetura continua se justificando.

Esse exercício evita dois erros opostos.

Um é vender tecnologia antiga como novidade.

O outro é achar que, por ser antiga, ela deixou de ter valor.

## Eu não quero a técnica mais nova

Também não quero simplesmente correr atrás da novidade.

Meu objetivo não é usar a arquitetura de agentes mais sofisticada de 2026.

É encontrar **a menor arquitetura capaz de resolver o problema com qualidade mensurável**.

Às vezes será um único modelo com um bom contexto.

Às vezes, RAG.

Às vezes, uma ferramenta determinística.

Às vezes, vários agentes.

Às vezes, um modelo pequeno rodando localmente.

Às vezes, nem haverá motivo para usar IA.

A maturidade não está em conhecer mais técnicas.

Está em conseguir dizer:

> **“Eu sei que essa técnica existe, sei por que foi criada e sei por que não preciso dela aqui.”**

## Sempre olhe o ano do processador

Quando vejo um computador usado anunciado apenas como “Core i7”, procuro imediatamente a geração.

Estou começando a fazer a mesma coisa com conteúdo sobre IA.

Quando alguém apresenta uma arquitetura, técnica ou “novo paradigma”, mentalmente procuro a etiqueta que não aparece no anúncio:

**de que geração de modelos estamos falando?**

Porque “usa agentes”, “usa RAG”, “usa chain of thought” ou “usa prompt engineering” diz cada vez menos quando aparece sozinho.

Assim como “tem um i7”.

Pode ser uma ótima solução.

Pode inclusive ser exatamente o que eu preciso.

Mas, antes de comprar, quero saber **de que geração é**.
