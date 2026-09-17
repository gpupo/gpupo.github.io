# O que meu cozy game me ensinou sobre coordenar agentes de IA

Published: 2026-08-12
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/coordenar-agentes-de-ia-como-rts/
Tags: Agentes de IA, Engenharia de Software, Produtividade

---

Ontem joguei três partidas de *Age of Empires II* com meu amigo Elton. Surramos
a IA em duas delas.

AOE2 é o nosso *cozy game*. Não é relaxante no sentido tradicional: tem invasão,
cerco, economia entrando em colapso, aldeão perseguido por cavaleiro e aquele
momento em que percebo que esqueci de produzir comida. Mesmo assim, sempre
voltamos. Conhecemos as regras e conseguimos conversar enquanto construímos uma
civilização e tentamos não morrer.

Enquanto administrava minha população, percebi que parte do meu trabalho atual
com agentes de IA produz uma sensação parecida. A analogia não prova que
orquestrar agentes é o mesmo que jogar um RTS. Ela apenas me ajudou a nomear um
problema que tenho observado: quando a capacidade paralela aumenta, a
coordenação começa a consumir a vantagem que ela criou.

<figure>
  <img src="/assets/images/age-of-empires-ii-vila-coordenacao.jpg" alt="Cidade de Age of Empires II cercada por água, com uma fortaleza, edifícios de cúpulas turquesa, cavalaria, aldeões e onagros distribuídos pelas ruas." width="1920" height="1080" loading="lazy" decoding="async">
  <figcaption>Mais unidades ampliam a capacidade da cidade e também o trabalho necessário para manter economia, defesa e movimentação na mesma direção.</figcaption>
</figure>

## Mais unidades mudam o problema

Em uma partida padrão de AOE2, cada império pode ocupar até 200 espaços de
população, e a própria interface mostra quando existem aldeões ociosos. A
[documentação oficial do jogo](https://www.ageofempires.com/learn-to-play/control-resources-aoe2/)
explica esses dois limites porque eles afetam diretamente a economia da partida.

Chegar a 200 unidades parece significar mais capacidade. Na prática, 200
unidades mal administradas podem produzir menos resultado do que 100 bem
organizadas. Aparecem aldeões parados, unidades militares atravessando o mapa
sem necessidade, madeira acumulada enquanto falta comida e um grupo de
cavalaria atacando sozinho por causa de uma ordem antiga.

O problema deixou de ser produção. Virou coordenação.

Quando comecei a usar agentes para desenvolvimento, o fluxo era quase serial:
eu entregava uma tarefa, esperava e revisava o resultado. Hoje posso ter um
agente analisando arquitetura enquanto outro implementa uma funcionalidade, um
terceiro escreve testes e outro investiga um bug. Já descrevi essa escolha como
[separar responsabilidades sem assumir que sempre precisamos de vários
agentes](/posts/multiplos-agentes-especializados/).

Colocar vários agentes para trabalhar é fácil. Continuar respondendo com clareza
quem está fazendo o quê é mais difícil. Capacidade paralela não elimina
coordenação; ela aumenta a necessidade dela.

## Atividade não é progresso

O botão de localizar aldeão ocioso existe porque uma unidade parada é capacidade
desperdiçada. Com agentes, encontrei uma versão menos visível do mesmo problema:
o agente pode estar trabalhando e, ainda assim, não produzir progresso.

Ele pode estar lendo arquivos e alterando código enquanto resolve um problema
que não deveria existir. Pode partir de uma premissa errada, refatorar uma área
que outro agente acabou de modificar ou produzir um documento que ninguém
precisa.

Isso é mais caro do que um agente parado. Existe consumo de tokens, mudanças que
precisam ser compreendidas e, às vezes, trabalho adicional para desfazer o
resultado. Por isso passei a prestar menos atenção na quantidade de atividade e
mais na direção: qual decisão a tarefa apoia, qual resultado deve produzir e
como saberei que terminou.

## Grupos de controle organizam funções

Depois de certo tamanho de exército, selecionar unidade por unidade deixa de
funcionar. O próprio guia do jogo recomenda [grupos de
controle](https://www.ageofempires.com/learn-to-play/match-goals-aoe2/) para
recuperar rapidamente conjuntos de unidades.

Com agentes, não quero pensar apenas que existem oito execuções simultâneas.
Quero distinguir funções:

- um fluxo explora o problema;
- outro implementa;
- outro valida;
- outro critica o resultado.

Os papéis podem ser percorridos por um único agente ou distribuídos entre
vários. A separação serve para explicitar entradas, saídas e critérios, não para
criar uma multidão de processos independentes.

A especialização também muda a escolha do modelo. Algumas tarefas exigem
exploração e contexto de produto; outras precisam de execução disciplinada a
partir de um contrato pequeno. Algumas justificam um modelo maior; outras podem
ser resolvidas por um modelo menor, mais barato e rápido. A pergunta deixa de
ser “qual é o melhor modelo?” e passa a ser “qual composição atende esta tarefa
com custo e risco aceitáveis?”.

## A economia continua por trás das unidades

AOE2 não é apenas um jogo sobre exércitos. Antes da cavalaria, alguém coletou
comida e ouro. Antes do castelo, alguém trouxe pedra. A produção militar depende
de uma economia que continua funcionando enquanto a batalha ocupa a tela.

O que aparece na interface de um agente é a resposta do modelo, mas existe uma
economia sustentando a execução: contexto, tokens, ferramentas, memória,
documentação, infraestrutura, APIs, GPU, tempo de revisão e atenção humana. A
[janela de contexto também participa desse custo](/posts/custo-da-janela-de-contexto/).

No meu fluxo, a atenção é o primeiro recurso a saturar. Posso iniciar mais
execuções quase instantaneamente, mas não aumento na mesma velocidade a
quantidade de decisões, mudanças e resultados que consigo compreender e
validar.

Não concluo daí que a atenção humana será o gargalo universal de qualquer
sistema com agentes. É uma limitação observada no meu ambiente. Para decidir se
mais paralelismo ajuda, eu compararia o tempo economizado na execução com o
tempo gasto para revisar, reconciliar e corrigir as saídas.

## Boas ordens não corrigem tudo, mas reduzem ambiguidade

Se eu selecionar vinte cavaleiros e clicar no lugar errado, eles executarão a
ordem errada com bastante disciplina. Agentes também conseguem produzir uma
mudança coerente com uma premissa ruim.

Por isso tenho dado mais importância ao que existe antes da execução:

- [PRDs com problema, escopo e critérios de aceitação](/artigos/prd-md-contexto-produto-agentes-ia/);
- ADRs que registram decisões e consequências;
- [DESIGN.md com as regras visuais do produto](/artigos/design-md-memoria-visual-agentes-ia/);
- convenções do projeto;
- testes e formas de validação;
- skills com limites e critérios de conclusão.

Esses artefatos funcionam como uma *build order* para agentes. Eles não garantem
um bom resultado, mas reduzem o espaço de interpretação e tornam divergências
mais fáceis de identificar.

Uma skill também se parece com um tipo de unidade. Eu não preciso explicar em
cada partida que um arqueiro ataca à distância. Da mesma forma, não quero
reescrever em toda tarefa como revisar código, investigar um incidente ou
atualizar um PRD. [Uma skill pode empacotar esse contrato de
trabalho](/posts/ai-skills-como-capacidades-configuradas/),
enquanto a solicitação informa o resultado necessário.

## Definir um limite populacional

O limite de população força uma decisão. Se estou em 200/200 e preciso de
unidades de cerco, talvez existam aldeões demais, uma composição inadequada ou
unidades antigas ocupando espaço sem entregar valor.

Comecei a pensar da mesma forma sobre trabalhos paralelos com agentes. Não sei
qual seria um número ideal, e não assumiria que ele é igual entre projetos. O
limite útil é cognitivo: quantas mudanças consigo supervisionar antes que o
custo de reconciliação fique maior do que o ganho de paralelismo?

Antes de iniciar outra execução, eu verificaria:

- quem responde pelo resultado;
- qual objetivo e critério de conclusão estão registrados;
- quais arquivos, dados ou ambientes o agente pode alterar;
- quando haverá um ponto de revisão;
- qual condição deve interromper o trabalho.

Se essas respostas não estão claras, adicionar outro agente apenas aumenta o
trabalho em andamento. Às vezes a decisão adequada não é abrir uma nova
execução. É encerrar uma que deixou de fazer sentido.

<figure>
  <img src="/assets/images/age-of-empires-ii-batalha-coordenacao.jpg" alt="Exércitos azuis e verdes combatem ao redor de uma cidade murada de Age of Empires II, com cavalaria, infantaria e máquinas de cerco próximas a uma ponte." width="1920" height="1080" loading="lazy" decoding="async">
  <figcaption>Durante a batalha, atividade é evidente. Ordens, grupos e prioridades determinam se ela vira progresso.</figcaption>
</figure>

## De chatbot para RTS

Há alguns anos, trabalhar com IA significava principalmente conversar com um
chatbot. Meu ambiente atual se parece mais com um pequeno sistema operacional de
trabalho: existem agentes, ferramentas, skills, contextos, filas, dependências e
resultados que precisam ser integrados.

Nesse cenário, escrever um bom prompt continua útil, mas não resolve a
orquestração. Também preciso distribuir recursos, perceber gargalos, interromper
trabalhos e evitar o controle manual de cada unidade.

Elton e eu provavelmente continuaremos voltando a AOE2. Existe algo curioso em
usar [um jogo lançado originalmente em 1999](https://www.ageofempires.com/news/age-of-empires-ii-definitive-edition-update-99311/)
para pensar em uma mudança recente na maneira como construo software.

Minha próxima melhoria não é colocar mais um agente para trabalhar. É olhar para
a tela cheia de atividade e ainda conseguir responder: quem está fazendo o quê,
por quê e qual execução deveria estar parada? Se eu não consigo responder, a
população já passou do limite que consigo administrar.
