# Obsidian para escrever: o que desliguei e o que mantive

Published: 2026-08-24
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/meu-obsidian-de-escrita-tem-o-grafo-desligado/
Tags: Obsidian, Escrita, Configuração, Produtividade

---

Meu Obsidian de escrita tem o grafo desligado. Canvas, notas diárias,
apresentações, gravador de áudio, contador de palavras e nota aleatória também
estão desligados.

Isso não veio de uma defesa teórica do minimalismo. É o estado observado no
arquivo atual de plugins nativos do vault. Ao lado das opções desativadas,
continuam ligados o explorador de arquivos, busca, backlinks, links de saída,
propriedades, templates, outline e Bases.

A configuração descreve melhor meu ambiente de escrita do que uma lista de
recursos que o Obsidian oferece.

## A recomendação e a configuração

Em janeiro de 2026, guardei uma nota sobre transformar o Obsidian num aplicativo
de escrita focado. Ela compilava recomendações de Live Preview, dobramento de
seções, backlinks, outline, Better Word Count, tempo de leitura, metas de
palavras, atalhos para notas de rodapé e diferentes plugins de “modo zen”.

Na configuração atual, boa parte dessa lista não aparece. Better Word Count,
Reading Time, Writing Goals, ProZen, Typewriter Scroll e Stille não estão entre
os plugins comunitários habilitados. O contador nativo de palavras está
desligado.

O contraste é útil porque separa uma nota de pesquisa do ambiente realmente
adotado. A primeira dizia “estas opções podem ajudar”. O JSON atual diz “estas
opções estão ligadas”. Não são a mesma evidência.

Os recursos que ficaram ativos podem ser agrupados pelo trabalho que realizam:

| Trabalho | Recursos ativos |
|---|---|
| encontrar arquivo | explorador, busca global e seletor rápido |
| percorrer um texto longo | outline |
| relacionar notas | backlinks e links de saída |
| manter metadados | propriedades e Bases |
| iniciar uma estrutura | templates e identificador único |
| editar | Live Preview, conversão de HTML e arquivos Markdown locais |

O `app.json` cria novas notas dentro de `notes`, envia anexos para `assets`,
mantém Live Preview ligado e usa o modo fonte como visualização padrão. O
comprimento de linha “legível” está desativado e números de linha também. É uma
combinação específica, não uma receita universal de foco.

Há ainda nove plugins comunitários ativos, entre eles Dataview, Kanban,
Templater, Pandoc, Omnisearch e Excalidraw. Portanto, “grafo desligado” não quer
dizer “Obsidian puro” nem “sem plugins”. Quer dizer apenas que a superfície
visível foi escolhida por função, e o grafo não ocupa um lugar nessa superfície
hoje.

Backlinks e grafo partem das mesmas relações, mas respondem a perguntas
diferentes. Um painel de backlinks ajuda a localizar quais notas mencionam o
arquivo aberto. O grafo mostra uma rede maior, que pode ser útil para explorar
conexões, mas não é necessário para editar um parágrafo.

O mesmo ocorre com notas diárias. Desligá-las não torna a escrita melhor. Apenas
retira um fluxo temporal que não está ativo neste vault. Templates continuam
ligados porque reduzem trabalho repetitivo na criação de certos tipos de nota.

Minha interpretação é que a configuração atual prioriza ações locais: abrir,
escrever, navegar pelo outline, seguir uma referência, pesquisar e aplicar
metadados. Essa interpretação vem dos arquivos de configuração; não medi
distração, velocidade de escrita ou qualidade do texto antes e depois de cada
mudança.

## Desligado não significa rejeitado

Uma armadilha ao documentar configuração pessoal é transformar estado em
doutrina. `"graph": false` prova que o recurso está desligado neste momento. Não
prova que grafos são inúteis, que nunca foram usados ou que ninguém deveria
ativá-los.

Também há escolhas que merecem revisão independente. O `file-recovery` está
desligado, por exemplo. Um backup do vault pode reduzir parte do risco, mas não
substitui necessariamente a recuperação local de uma edição recente. A
configuração registra a decisão; não demonstra que todas as consequências foram
testadas.

Se eu reconstruísse o ambiente em outra máquina, começaria pelos recursos
ativos no JSON, não pela nota de recomendações. Depois acrescentaria uma função
somente diante de uma tarefa que ela resolve. O valor deste inventário não está
em ensinar a configuração “certa” do Obsidian. Está em lembrar que o aplicativo
de escrita efetivo é o conjunto que permanece ligado, não o conjunto que um dia
pareceu interessante numa nota.
