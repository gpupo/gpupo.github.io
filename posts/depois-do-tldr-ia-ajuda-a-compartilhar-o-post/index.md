# ChatGPT e Claude no fim do post: sugestões para compartilhar o artigo

Published: 2026-08-21
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/depois-do-tldr-ia-ajuda-a-compartilhar-o-post/
Tags: Inteligência Artificial, ChatGPT, Claude, Jekyll, UX

---

No post anterior, **[“Um favorito para pedir o TL;DR de qualquer página ao ChatGPT”](/posts/bookmarklet-tldr-chatgpt/)**, eu mostrei uma pequena conveniência que comecei a usar nos meus sites: em vez de obrigar o leitor a decidir entre ler tudo ou abandonar a página, ofereço um terceiro caminho.

Ele pode pedir ao ChatGPT ou ao Claude que leia o artigo e prepare um TL;DR.

A implementação é quase banal. O site pega a URL do post, monta um prompt, faz o URL encoding e abre uma nova conversa no modelo escolhido.

Mas gostei da ideia por outro motivo: **o link não usa IA para produzir o conteúdo do meu site. Ele usa IA para ajudar o leitor a interagir com o conteúdo.**

E agora resolvi levar essa ideia para a outra ponta da leitura.

## Antes de ler, resumir. Depois de ler, compartilhar.

O primeiro bloco aparece no começo dos meus posts:

> Se preferir começar por um resumo, peça um TL;DR ao ChatGPT ou ao Claude.

A lógica é simples.

Talvez você tenha chegado ao artigo sem saber se vale os próximos cinco ou dez minutos. Em vez de eu escrever um resumo tentando convencer você, entrego a URL ao modelo e deixo você conversar com ele sobre o texto.

Agora coloquei outro bloco no **final** dos posts:

> **Gostou? Compartilhe com suas palavras — com uma pequena ajuda da IA.**
>
> Peça ao ChatGPT ou ao Claude três sugestões de texto prontas para compartilhar este post nas suas redes.

Os dois links abrem o modelo escolhido com um prompt que pede três variações:

1. uma direta;
2. uma mais pessoal e conversacional;
3. uma que provoque reflexão.

Todas devem incluir a URL original do artigo.

## Não é um botão de compartilhar

Eu poderia simplesmente colocar os tradicionais botões:

**LinkedIn · Threads · Bluesky · X · Facebook**

Mas eles resolvem apenas uma parte do problema.

O navegador sabe **onde** você quer compartilhar.

Ele não sabe **o que você quer dizer sobre aquilo que acabou de ler**.

E esse pequeno espaço entre clicar em “compartilhar” e escrever alguma coisa talvez seja justamente onde um modelo de linguagem seja mais útil.

Não para decidir se você gostou.

Não para fingir uma opinião sua.

Mas para oferecer alguns pontos de partida.

Você lê três versões, descarta duas, mistura trechos, muda uma frase ou simplesmente percebe que prefere escrever do zero.

Ainda assim, a página ajudou você a sair da leitura para a expressão.

## O prompt faz parte da interface

Tenho pensado cada vez mais nisso.

Durante muito tempo, quando falávamos de interface web, pensávamos em links, formulários, botões, menus e APIs.

Agora existe outro elemento possível:

**um link que carrega contexto para uma conversa.**

Neste caso, o botão não executa uma função sofisticada no meu servidor.

Ele basicamente diz:

“Abra este artigo, entenda o que está aqui e ajude esta pessoa a fazer a próxima coisa.”

No TL;DR, a próxima coisa era **entender rapidamente**.

No novo bloco, é **compartilhar**.

A arquitetura continua simples. Não existe chamada de API no meu site, token sendo consumido pelo servidor nem resposta de modelo sendo armazenada por mim.

O navegador apenas abre ChatGPT ou Claude levando consigo um prompt e a URL pública do artigo — a mesma abordagem que descrevi no post anterior.

O limite continua o mesmo do TL;DR: abrir o prompt não garante que o artigo foi lido. O resultado depende de o modelo conseguir acessar a URL pública; se a página bloquear acesso automatizado, a resposta pode não refletir o conteúdo real.

## Três opções, não uma resposta definitiva

Também escolhi pedir **três textos** de propósito.

Uma única sugestão facilmente parece uma resposta.

Três sugestões deixam mais explícito que aquilo é matéria-prima.

Quero que uma seja objetiva, outra pareça uma conversa com alguém conhecido e outra parta de uma reflexão provocada pelo artigo.

Minha hipótese é que pedir variações ajuda a reduzir um comportamento de IA que particularmente me incomoda nas redes: dezenas de pessoas compartilhando conteúdos diferentes com textos que parecem escritos pela mesma pessoa.

A intenção não é automatizar personalidade.

É diminuir a fricção da página em branco.

## Um pequeno ciclo ao redor do conteúdo

Com os dois componentes, meus posts passam a ter um ciclo que achei interessante.

**Antes da leitura:**

`artigo → IA → resumo → decisão de continuar`

**Depois da leitura:**

`artigo → leitor → IA → sugestões → compartilhamento`

O artigo continua sendo o centro.

A IA aparece nas bordas.

Ela ajuda alguém a entrar no conteúdo e, depois, ajuda alguém a sair dele levando uma ideia adiante.

Talvez essa seja uma forma interessante de pensar IA em websites.

Não necessariamente como chatbot flutuando no canto inferior direito.

Não necessariamente como um grande recurso chamado **AI** no menu.

Às vezes ela pode ser apenas uma pequena transição entre uma ação humana e a próxima.

## E isso abre outras possibilidades

Depois de colocar os dois blocos no site, comecei naturalmente a enxergar outras variações.

No fim de um artigo técnico:

**“Peça ao modelo para transformar este post em um checklist para seu projeto.”**

Em um texto conceitual:

**“Discuta com o modelo os argumentos contrários a esta ideia.”**

Em um tutorial:

**“Peça ao modelo para adaptar este exemplo à sua stack.”**

Em um texto longo:

**“Transforme os conceitos deste artigo em perguntas para estudar depois.”**

Não quero encher cada página de botões para modelos de linguagem.

Mas gosto da ideia de identificar alguns lugares em que o leitor normalmente pensa:

**“Certo. E agora?”**

Ali talvez exista espaço para um bom prompt.

## O website começa a apontar para conversas

O primeiro experimento nasceu de um bookmarklet para resumir páginas.

Depois virou um componente dos meus sites.

Agora ganhou seu complemento no final dos posts.

É uma mudança pequena de código.

Mas gosto bastante do princípio por trás dela.

Durante muitos anos colocamos links nos websites para levar pessoas a **outras páginas**.

Agora também podemos colocar links que levam pessoas a **conversas sobre a página em que estavam**.

E talvez alguns dos usos mais interessantes de IA na web não sejam enormes sistemas generativos escondidos atrás da interface.

Talvez sejam justamente esses pequenos convites:

**leia isto, pense sobre isto, converse sobre isto — e depois conte para alguém o que ficou com você.**
