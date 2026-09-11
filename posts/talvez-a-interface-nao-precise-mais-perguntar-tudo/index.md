# Talvez a interface não precise mais perguntar tudo

Published: 2026-09-02
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/talvez-a-interface-nao-precise-mais-perguntar-tudo/
Tags: Personal Competency Graph, Design de interfaces, Agentes de IA, Produto, Experiência do usuário

---

Nas últimas semanas tenho trabalhado em um projeto pessoal chamado **Personal
Competency Graph**, ou PCG.

A ideia começou relativamente simples: manter um mapa do que eu sei, onde quero
chegar e o que vale a pena estudar agora.

O sistema foi crescendo. Vieram competências, níveis, objetivos, caminhos,
autoavaliação, evidências e integração com meu vault do Obsidian.

E, inevitavelmente, começaram a aparecer telas.

Foi aí que percebi que talvez estivesse projetando uma coisa nova com uma cabeça
velha.

## O formulário apareceu quase automaticamente

Se existe um objetivo, fazemos uma tela para cadastrar objetivos.

Então aparecem os campos:

- intenção;
- critérios de sucesso;
- estratégias de aprendizagem;
- área;
- competências;
- níveis desejados.

E, no final, um botão:

**Salvar.**

Se existe uma competência, fazemos outra tela. Se existe uma evidência, outro
formulário.

É quase automático pensar software dessa maneira.

Durante muito tempo construímos sistemas assim porque, em algum lugar, havia uma
tabela no banco de dados que precisava receber aqueles valores. A interface era
uma maneira mais amigável de preencher essa tabela.

Claro que estou simplificando, mas o padrão mental continua aparecendo: CRUD.

Create, Read, Update, Delete.

Mesmo quando a tela fica bonita, muitas vezes ainda estamos oferecendo ao
usuário uma forma sofisticada de alimentar as estruturas internas do software.

## Só que agora tem um agente no meio

Enquanto olhava a nova interface do PCG, comecei a pensar: por que eu deveria
preencher tudo isso?

Se quero melhorar meu inglês, provavelmente vou dizer algo como:

> Quero sair de B1 para B2. Vou continuar com minhas aulas de conversação,
> exercícios de gramática e leitura de literatura em inglês.

Para mim, isso já contém muita informação.

Um agente consegue interpretar que existe ali um objetivo. Consegue distinguir
uma intenção de uma estratégia de aprendizagem. Pode consultar o catálogo de
competências, olhar o que já existe no meu vault e perceber que CEFR é uma
referência externa, evitando inventar uma equivalência com a escala interna do
sistema.

A partir disso, pode preparar uma proposta.

Então por que a primeira interação deveria ser:

```text
Intenção: ______________________

Critérios de sucesso:
________________________________

Estratégias:
________________________________

Competências:
[ selecionar ]

Nível:
[ selecionar ]
```

Talvez não devesse.

## Intenção antes de estrutura

Comecei então a imaginar a interface de outra maneira.

Em vez de:

> Novo objetivo

poderia aparecer:

> **O que você quer desenvolver?**

E um campo de texto.

Eu escrevo:

> Quero melhorar minha matemática porque sinto falta de base quando leio coisas
> sobre probabilidade, estatística e álgebra linear em IA.

O agente pode responder:

> Entendi que você quer construir fundamentos matemáticos para compreender
> melhor esses assuntos.
>
> Encontrei algumas notas relacionadas no seu vault.
>
> Ainda não existe um domínio de Matemática no catálogo.
>
> Preparei uma sugestão inicial de competências, mas antes preciso saber se seu
> foco é compreensão conceitual ou resolução de exercícios.

Isso me parece muito mais natural.

Eu não estou **cadastrando um objeto**. Estou declarando uma intenção.

O sistema é que conhece seu próprio modelo de dados.

## O agente não precisa decidir tudo

Isso não significa entregar o sistema para um agente sair alterando tudo
sozinho.

Na verdade, comecei a gostar de outra ideia: a **proposta do agente**.

O fluxo seria algo assim:

```text
intenção
   ↓
agente investiga
   ↓
proposta estruturada
   ↓
decisão humana
   ↓
mudança no sistema
```

O agente pode trabalhar bastante: ler o catálogo, relacionar competências,
encontrar notas, comparar pré-requisitos e preparar uma sugestão.

Mas, quando chega a uma decisão importante, ele me mostra:

> É isso que entendi. Posso fazer assim?

Eu aceito, ajusto, converso ou descarto.

A interface deixa de ser principalmente um lugar onde digito dados e passa a
ser um lugar onde **compreendo o estado e tomo decisões**.

## Isso muda também a navegação

Outra coisa que começou a me incomodar foi a navegação tradicional.

No PCG eu tinha coisas como:

**Visão geral**

**Autoavaliação**

**Objetivos**

**Caminho**

**Projetos e evidências**

Tudo correto do ponto de vista do modelo.

Mas será que eu, como usuário, acordo pensando:

> Hoje vou entrar na seção Autoavaliação.

Provavelmente não.

Talvez eu pense:

> O que vale estudar agora?

Ou:

> Quero começar a estudar uma coisa nova.

Ou ainda:

> Será que já tenho alguma nota que pode me ajudar nisso?

Então comecei a imaginar uma home baseada menos nas entidades internas e mais
nessas intenções.

Um campo para dizer o que quero fazer. Meus objetivos atuais. O que merece
minha atenção em cada um deles. E algumas coisas que os agentes encontraram e
precisam da minha decisão.

## Agentes podem trabalhar enquanto a interface fica quieta

Essa talvez seja a parte que mais me interessa.

Não quero transformar tudo em chat.

Uma interface com agentes não precisa ser uma enorme caixa de conversa. O agente
pode trabalhar por trás e aparecer quando existe algo relevante para eu avaliar.

Por exemplo:

> Encontrei três notas do seu vault relacionadas ao seu foco atual em guitarra.

Ou:

> Seu objetivo de inglês já tem critérios e estratégias, mas ainda não tem
> competências suficientes para calcular um caminho. Preparei uma proposta.

Ou:

> “Aprimorar minha matemática” ainda está amplo demais. Tenho duas perguntas
> antes de estruturar isso.

O restante pode continuar sendo visual.

Cards. Caminhos. Competências. Recursos. Relações.

A diferença é que eu não preciso construir tudo manualmente.

## O software começa a conhecer o próprio software

Talvez exista uma mudança interessante aí.

No software tradicional, muitas vezes o usuário precisava entender parte do
modelo interno do produto para conseguir operá-lo.

Se havia Cliente, Projeto, Categoria e Status, em algum momento ele precisava
aprender onde criar Cliente, onde escolher Categoria e quais Status existiam.

Com agentes, uma parte dessa tradução pode ser feita pela própria aplicação.

O usuário diz:

> Quero aprender isso.

E o sistema responde:

> Para o modelo que uso internamente, isso parece um Objetivo envolvendo estas
> Competências, com estas relações e estes recursos.

O modelo continua existindo. Talvez fique até mais rigoroso.

Só não precisa estar exposto em cada interação.

## O terminal também pode ser interface

Outra consequência interessante para mim é que a interface web deixa de ser
necessariamente o centro de tudo.

Posso estar trabalhando no terminal e escrever para um agente:

> Cadastre esses quatro objetivos no PCG.

Posso estar no navegador e escrever:

> Quero melhorar uma habilidade nova.

Talvez, no futuro, eu faça uma anotação no Obsidian que dispare o mesmo tipo de
análise.

Se todos conversam com o mesmo núcleo, a web passa a ser uma das interfaces
possíveis.

Uma interface especialmente boa para visualizar meus caminhos, minhas
competências, meu foco atual, propostas dos agentes e recursos relacionados.

Não necessariamente para digitar tudo.

## Ainda preciso de interface

Nada disso elimina UI.

Pelo contrário.

Depois que o agente interpreta minha intenção, quero uma interface muito boa
para verificar o que ele entendeu.

Quero enxergar:

> Você quer chegar aqui.
>
> Estas competências parecem necessárias.
>
> Estas já estão no nível desejado.
>
> Estas merecem atenção agora.
>
> Estas vêm depois.
>
> Você já possui estes materiais no seu vault.

A linguagem natural é ótima para **expressar intenção**.

Uma interface estruturada é muito melhor para **compreender estado**.

Talvez essa combinação seja uma parte importante desse novo tipo de software.

## Acho que minha pergunta mudou

No início, eu estava perguntando:

> Como faço uma boa tela para cadastrar um objetivo?

Agora estou mais interessado em:

> **Por que estou cadastrando isso manualmente?**

E isso muda bastante o desenho.

Talvez muitas interfaces que estamos produzindo hoje ainda sejam sistemas
tradicionais com um chatbot colocado ao lado.

Estou começando a achar mais interessante partir do outro lado.

O agente recebe a intenção. O software conhece sua estrutura. A interface mostra
o resultado dessa interpretação e me oferece controle.

No caso do PCG, cheguei a uma frase que está começando a orientar essa ideia:

> **Eu não quero cadastrar o mapa. Quero dizer para onde pretendo ir e ter
> agentes me ajudando a construir e manter esse mapa.**

Ainda estou experimentando.

É bem possível que algumas coisas voltem a virar formulários porque simplesmente
funcionam melhor assim.

Mas o formulário deixou de ser minha resposta automática.

E só essa mudança de pergunta já está alterando bastante a maneira como estou
pensando interfaces.
