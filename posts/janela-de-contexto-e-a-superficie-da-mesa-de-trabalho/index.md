# Janela de contexto e a superfície da mesa de trabalho

Published: 2026-11-24
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/janela-de-contexto-e-a-superficie-da-mesa-de-trabalho/
Tags: Inteligência Artificial, Agentes de IA, Janela de contexto

---

A janela de contexto limita quanto material um modelo consegue considerar em uma execução. Durante uma aula sobre agentes de IA, usei uma mesa de trabalho para explicar esse limite.

<figure class="editorial-photo">
  <img src="/assets/images/janela-de-contexto-e-a-superficie-da-mesa-de-trabalho.webp" alt="Mesa vista de cima com livros, documentos e um notebook fechado à esquerda, deixando espaço livre para um caderno aberto e uma caneta à direita." width="1200" height="800" loading="eager" decoding="async">
</figure>

Imagine uma mesa pequena. Você coloca o notebook, abre um caderno e já precisa procurar onde apoiar o resto. Numa mesa maior, consegue espalhar documentos, consultar referências e manter o trabalho em andamento à vista.

A janela de contexto tem uma relação parecida com essa superfície. Isso muda a maneira como preparo tarefas, escolho modelos e organizo conversas com agentes.

## O que ocupa essa mesa

Quando entrego uma tarefa a um agente, a pergunta que acabei de escrever é apenas parte do material que ele recebe.

Também podem estar sobre a mesa as instruções de funcionamento, o histórico da conversa, trechos de documentos, resultados de buscas e respostas de ferramentas. Aquilo que o agente produziu antes pode voltar como material de consulta na próxima etapa.

Esse espaço é medido em tokens, unidades em que o conteúdo é representado para o modelo. Para usar a analogia, basta entender que cada material ocupa uma parte da superfície disponível.

E a mesa precisa acomodar o trabalho que ainda será produzido. Entrada e saída compartilham o limite da janela; em modelos de raciocínio, tokens usados nesse processamento também podem entrar nessa conta. Existe ainda um limite próprio para a saída. Uma mesa grande, portanto, não significa uma resposta de tamanho ilimitado. A documentação da OpenAI detalha essa [contagem de entrada, saída e raciocínio](https://developers.openai.com/api/docs/guides/conversation-state#managing-the-context-window).

## Precisa sobrar espaço para trabalhar

Na aula, desenhei uma entrada crescendo até deixar pouco espaço para a saída. É uma maneira de visualizar um limite concreto: se eu ocupar quase toda a janela com material de entrada, reduzo a capacidade disponível para a continuação.

Isso não significa que toda pergunta longa receberá uma resposta curta ou ruim. Enquanto houver capacidade suficiente, uma entrada extensa pode ser justamente o que a tarefa exige. Ao se aproximar do limite, o comportamento depende da ferramenta: ela pode impedir a execução, reduzir o contexto, compactar o histórico ou limitar a continuação.

Na mesa física, é a diferença entre ter os documentos necessários abertos e empilhar tantos papéis que já não há onde escrever.

Por isso, antes de acrescentar mais um arquivo, gosto de perguntar: **esse material ajuda a executar a tarefa atual?**

## O arquivo pode continuar no armário

Um ponto dessa comparação merece atenção: ter um documento disponível e estar usando seu conteúdo naquele momento são situações diferentes.

Posso ter uma pasta com centenas de arquivos e colocar apenas três documentos sobre a mesa. Os demais continuam guardados e podem ser consultados quando necessário.

Com um agente que dispõe de ferramentas de leitura e busca, posso organizar o trabalho da mesma maneira: localizar os arquivos relevantes, ler os trechos necessários e voltar às fontes quando surgir uma dúvida.

A existência do arquivo no computador não garante que seu conteúdo esteja no contexto. Da mesma forma, retirar seu conteúdo da conversa não precisa significar apagar o arquivo.

Essa distinção ajuda a separar o que está guardado do que está sendo considerado agora. As [fichas organizadas com Bases do Obsidian](/posts/bases-obsidian-organizar-notas-agentes-ia/) são um exemplo de material que posso manter em arquivos e consultar conforme a tarefa.

## Uma mesa maior não resolve tudo

Na escolha de um modelo, o tamanho da janela é uma característica importante. Mas ele precisa ser avaliado junto com a capacidade de executar a tarefa.

Uma pessoa pode ter uma mesa enorme e ainda assim não saber analisar os documentos que recebeu. A analogia também tem esse limite: espaço disponível e competência para trabalhar são dimensões diferentes.

Por isso, não deduzo o tamanho da janela apenas pelo preço, pelo nome ou pela posição de um modelo numa família. Também não trato uma configuração de maior esforço de raciocínio como se ela aumentasse a mesa.

Eu preciso observar se o modelo comporta o material necessário e se consegue produzir um resultado adequado. E preciso revisar esse resultado.

## Compactar é reorganizar o material

Conforme a conversa avança, novos papéis chegam à mesa. Algumas ferramentas usam compactação para continuar trabalhando: reduzem a representação do histórico e preservam informações para as próximas etapas.

Na analogia, é como substituir parte da pilha por fichas de continuidade. A implementação pode ir além de um resumo legível, mas a ideia prática é liberar espaço carregando adiante o estado necessário. A [compactação da OpenAI](https://developers.openai.com/api/docs/guides/compaction), por exemplo, pode produzir um item opaco que transporta estado e raciocínio com menos tokens.

A compactação é útil. O cuidado está em verificar se aquilo que importa para a próxima tarefa continua disponível: decisões, restrições, exceções e referências.

Uma decisão registrada apenas no meio da conversa fica dependente de como esse histórico será tratado. Prefiro transformar decisões importantes em registros que eu possa revisar e que o agente possa consultar novamente.

## Antes de limpar a mesa, guarde o trabalho

Na aula, minha orientação foi limpar a mesa quando houver uma troca de atividade.

Isso exige preparar a continuidade. Se passei uma hora definindo regras com o agente e inicio outra sessão sem registrar essas regras, posso precisar reconstruir parte do trabalho.

Antes de encerrar uma etapa, posso pedir:

> Registre o objetivo atual, as decisões aprovadas, as restrições, os arquivos produzidos, as pendências e o próximo passo. Indique onde estão as fontes que precisaremos consultar novamente.

Reviso esse registro e o guardo junto ao projeto. Na próxima sessão, ele serve como ponto de partida, acompanhado das instruções e dos documentos necessários.

O arquivo só ajuda se for carregado ou consultado. Guardá-lo faz parte do trabalho; preparar sua recuperação também. Detalho esse cuidado em [O trabalho do agente precisa sobreviver à conversa](/posts/o-trabalho-do-agente-precisa-sobreviver-a-conversa/).

## Organizar o contexto faz parte da execução

No exemplo da aula, estávamos criando um agente para apoiar a preparação de encontros de uma célula da igreja. Havia uma etapa de pesquisa e definição das orientações, seguida da produção do material da semana.

Depois de registrar as orientações aprovadas, a etapa de produção poderia começar com essas regras e com a mensagem que serviria de base para o encontro. Os documentos da pesquisa continuariam disponíveis para consulta.

É assim que procuro organizar o trabalho com agentes: definir o que precisa estar sobre a mesa agora, registrar o que foi decidido e preparar a próxima etapa.

Antes de procurar uma mesa maior, vale olhar para os papéis que deixei espalhados.

## Referências técnicas

- [OpenAI — Conversation state](https://developers.openai.com/api/docs/guides/conversation-state): limites da janela, entrada, saída e tokens de raciocínio.

- [OpenAI — Compaction](https://developers.openai.com/api/docs/guides/compaction): redução do contexto e continuidade de estado.
