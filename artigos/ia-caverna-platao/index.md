# LLMs na Caverna de Platão: uma hipótese, não um mecanismo comprovado

Published: 2025-06-22
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/ia-caverna-platao/
Tags: IA, Filosofia

---

Por que modelos treinados para prever texto demonstraram capacidade em tarefas
de código, matemática e escrita, enquanto a previsão de vídeo não produziu o
mesmo tipo de sistema de uso geral?

Sergey Levine explora essa pergunta no ensaio
[*Language Models in Plato’s Cave*](https://sergeylevine.substack.com/p/language-models-in-platos-cave),
publicado em 8 de junho de 2025. A explicação proposta é provocativa: em vez de
aprender sobre o mundo pelo mesmo caminho usado pelas pessoas, modelos de
linguagem poderiam reproduzir parte das estruturas cognitivas humanas presentes
nos textos produzidos por elas.

O texto original deste post apresentou essa ideia como uma descrição do
funcionamento dos LLMs. Isso ia além da evidência disponível. O ensaio de Levine
oferece uma hipótese e uma metáfora; não demonstra que modelos reconstroem
literalmente a mente humana.

## A hipótese apresentada no ensaio

O argumento começa com uma diferença entre os dados.

Vídeos registram estados e mudanças do mundo físico. Textos, por outro lado,
registram resultados de atividades humanas: explicações, decisões, programas,
provas, histórias e descrições de problemas. Para Levine, prever texto pode
permitir que o modelo aprenda regularidades desses resultados sem repetir todo o
processo de experiência que levou uma pessoa a produzi-los.

A Caverna de Platão entra como metáfora. O mundo e a experiência humana estão
fora da caverna; os textos publicados são sombras projetadas em sua parede; o
modelo observa essas sombras. Ele pode reproduzir padrões úteis sem ter acesso
direto às experiências que deram origem a eles.

Levine usa essa hipótese para explicar duas observações:

- modelos de linguagem conseguem imitar algumas capacidades expressas em texto;
- ainda apresentam limitações para adquirir novas habilidades diretamente pela
  interação com o mundo físico.

Essas são as conclusões do autor. O ensaio não apresenta um experimento que
isole essa explicação de outras possibilidades.

## A metáfora não descreve o mecanismo interno

Dizer que um modelo faz “engenharia reversa da cognição humana” produz uma imagem
forte, mas não identifica o que foi aprendido em seus parâmetros nem demonstra
equivalência com processos mentais humanos.

O comportamento observado também não basta para responder essa questão. Se um
modelo resolve um problema escrito, podemos avaliar a resposta, o custo e os
erros. Não podemos concluir apenas desse resultado que ele utilizou a mesma
representação ou o mesmo processo de uma pessoa.

A comparação com vídeo também precisa de cuidado. “Modelo de linguagem” e
“modelo de vídeo” abrangem arquiteturas, dados, objetivos e avaliações
diferentes. O desempenho de produtos específicos não prova que texto é uma rota
superior para toda forma de aprendizado.

Além disso, uma aplicação pode combinar texto, imagem, áudio, ferramentas,
memória e ambientes externos. A fronteira entre observar texto e interagir com o
mundo não é fixa. O argumento continua útil como pergunta de pesquisa, mas não
deve virar uma lei sobre o que qualquer sistema conseguirá aprender.

## O que a hipótese ajuda a decidir

Minha interpretação prática é mais restrita do que a tese sobre cognição.

Quando uma tarefa deixa rastros textuais abundantes, um modelo de linguagem pode
encontrar exemplos relevantes para produzir um candidato. Código, documentação,
registros de decisões e procedimentos operacionais são artefatos que tornam
parte do trabalho observável no treinamento ou no contexto.

Isso não elimina a validação. Um modelo pode reproduzir a forma de uma solução
sem respeitar as restrições do projeto. Testes, tipos, políticas, revisão e
dados de origem continuam necessários para ligar a resposta ao problema real.

Em tarefas que dependem de interação física ou de informação ausente, texto
sozinho oferece menos apoio. Um robô manipulando um objeto novo precisa de
sensores, ações e retorno do ambiente. Uma descrição de produto sem dados de
compatibilidade não se torna correta porque o modelo conhece descrições
parecidas. Nesses casos, a aplicação precisa obter evidência fora da geração.

A distinção útil não é “LLM serve” contra “LLM não serve”. É perguntar onde está
a evidência que permite corrigir o sistema.

## Um critério para avaliar projetos

Antes de delegar uma tarefa a um modelo, eu usaria quatro perguntas:

1. **Representação:** o problema e suas restrições estão registrados em texto,
   dados ou exemplos acessíveis?
2. **Retorno:** existe um teste, uma medição ou uma pessoa capaz de avaliar o
   resultado?
3. **Interação:** a tarefa exige observar mudanças no ambiente depois de cada
   ação?
4. **Novidade:** o sistema está recombinando soluções conhecidas ou precisa
   descobrir uma habilidade que não aparece nas fontes disponíveis?

Quanto menor a representação e mais importante a interação, menos eu dependeria
apenas da geração de texto. Adicionaria ferramentas, sensores, simuladores ou
aprovação humana conforme o efeito da ação.

O ensaio de Levine ajuda a formular esse limite. Seu valor está menos em provar
como um LLM pensa e mais em lembrar que texto é um registro parcial da realidade.
Um sistema pode aprender muito com esse registro. O risco começa quando
confundimos uma resposta plausível sobre a sombra com evidência do que existe
fora da caverna.
