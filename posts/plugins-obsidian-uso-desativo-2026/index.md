# Meus plugins do Obsidian em 2026: quais mantenho ligados e quais desativo

Published: 2026-11-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/plugins-obsidian-uso-desativo-2026/
Tags: Obsidian, Configuração, Gestão do conhecimento

---

<figure class="editorial-photo">
  <img src="/assets/images/plugins-obsidian-2026.webp" alt="Caderno aberto com notas interligadas e módulos de busca, templates, desenho e cartões iluminados; outros módulos estão desconectados sobre a mesa." width="1536" height="1024" loading="eager" decoding="async">
  <figcaption>Ilustração conceitual gerada por IA: módulos ativos e desativados em um caderno de notas.</figcaption>
</figure>

Meu cofre do Obsidian reúne notas de estudo, referências, textos e inventários.
Para trabalhar com esse material, mantenho recursos nativos de busca, navegação
e propriedades, além de extensões para templates, desenhos, exportação e estudo.

Em 6 de novembro de 2026, a configuração tem **sete plugins comunitários
habilitados e oito instalados, mas desligados**. No arquivo dos nativos, há 13
entradas ligadas e 18 desligadas.

Este inventário cruza a configuração com os arquivos do cofre. Estar habilitado
não mede frequência de uso, e uma desativação não explica, sozinha, o motivo da
escolha. Há inclusive consultas e atalhos que permaneceram depois que seus
plugins foram desligados.

## Os sete comunitários que mantenho habilitados

As versões abaixo são as instaladas no meu cofre. Os nomes e as funções vêm dos
manifestos locais; os links levam aos projetos correspondentes.

| Plugin | Versão instalada | Função |
|---|---|---|
| [Kanban](https://github.com/obsidian-community/obsidian-kanban) | 2.0.51 | Criar quadros apoiados em arquivos Markdown. |
| [Templater](https://github.com/silentvoid13/Templater) | 2.18.1 | Criar e usar templates. |
| [Pandoc Plugin](https://github.com/oliverbalfour/obsidian-pandoc) | 0.4.1 | Oferecer comandos de exportação para formatos como DOCX, ePub e PDF. |
| [Local Images Plus](https://github.com/sergei-korneev/obsidian-local-images-plus) | 0.16.4 | Baixar mídias externas e ajustar os links das notas para arquivos locais. |
| [Omnisearch](https://github.com/scambier/obsidian-omnisearch) | 1.28.2 | Acrescentar um mecanismo de busca ao cofre. |
| [Excalidraw](https://github.com/zsviczian/obsidian-excalidraw-plugin) | 2.20.6 | Editar e visualizar desenhos do Excalidraw. |
| [Spaced Repetition](https://github.com/st3v3nmw/obsidian-spaced-repetition) | 1.13.8 | Revisar flashcards e notas com repetição espaçada. |

### Templates, busca e exportação

O Templater aponta para a pasta `Templates` e está configurado para disparar na
criação de arquivos. Há um atalho associado ao template de nota efêmera e um
arquivo com sintaxe do Templater nessa pasta. O recurso nativo de templates
também está ligado e usa o mesmo diretório.

Na busca, o Omnisearch tem o atalho `Mod+Shift+F`. Nesse arquivo de configuração,
`Mod` representa `Ctrl` no Linux e `Cmd` no macOS, conforme a
[definição da API](https://github.com/obsidianmd/obsidian-api/blob/master/obsidian.d.ts).
A busca nativa permanece habilitada, mas seu comando de abertura está sem
atalho personalizado. Os dois mecanismos coexistem.

O Pandoc tem um atalho para exportação em PDF. É um caminho preparado para
exportar, embora este levantamento não tenha testado a execução do Pandoc nem
suas dependências externas.

### Imagens, desenhos, cartões e quadros

O Local Images Plus está configurado para processar arquivos criados, com a
atualização em tempo real desligada. O próprio Obsidian envia novos anexos para
`assets`. São configurações coerentes com manter mídia junto das notas, sem que
isso permita atribuir ao plugin a origem de cada imagem armazenada.

Na pasta `notes`, três arquivos contêm a propriedade `excalidraw-plugin`, que
identifica material no formato do Excalidraw.

O Spaced Repetition deixa um registro mais específico: cinco arquivos dessa
pasta contêm comentários de agendamento de revisão ``. A
configuração reconhece `#flashcards`, usa `#review` para revisão de notas e
permite lacunas com chaves. Já descrevi esse arranjo no post sobre
[flashcards e repetição espaçada](/posts/usando-flashcards-e-repeticao-espacada-no-obsidian/).

O Kanban também tem material no cofre: quatro arquivos, fora de `notes`, têm a
propriedade `kanban-plugin: board`. Procurar apenas na pasta principal de notas
teria deixado esses quadros fora do levantamento.

## Os oito comunitários instalados que estão desligados

| Plugin | Versão instalada | Função |
|---|---|---|
| Auto Rename from ID | 0.1.0 | Renomear notas ao salvar, a partir da propriedade `id`. |
| [BuJo Bullets](https://github.com/frankolson/obsidian-bujo-bullets) | 1.2.1 | Acrescentar tipos de checkbox para marcadores de Bullet Journal. |
| [Dataview](https://github.com/blacksmithgu/obsidian-dataview) | 0.5.68 | Criar consultas e visualizações de dados. |
| [Highlightr](https://github.com/chetachiezikeuzor/Highlightr-Plugin) | 1.2.2 | Oferecer um menu de marcação com cores configuráveis. |
| [Mermaid Tools](https://github.com/dartungar/obsidian-mermaid) | 1.3.0 | Acrescentar ferramentas visuais para diagramas Mermaid. |
| [Shell commands](https://github.com/taitava/obsidian-shellcommands) | 0.23.0 | Definir comandos do sistema e associá-los a atalhos ou automações. |
| [Remove Newlines](https://github.com/handcartcactus/obsidian-remove-newlines) | 1.0.7 | Remover quebras de linha ou linhas vazias de texto selecionado ou colado. |
| [Typographer](https://github.com/coignard/obsidian-typographer) | 1.0.1 | Aplicar ajustes tipográficos, substituições e pareamento de caracteres. |

O Dataview é o caso que mais chama atenção. No
[retrato de agosto](/posts/meu-obsidian-de-escrita-tem-o-grafo-desligado/), ele
aparecia entre os habilitados. Agora está desligado, mas 103 arquivos Markdown
diretamente em `notes` ainda contêm a abertura de bloco `dataview`.

As consultas continuam guardadas, embora o plugin que as executa esteja
desativado. Bases está ligado e há 19 arquivos `.base` fora da lixeira do cofre.
A coexistência desses arquivos não comprova uma migração completa do Dataview
para Bases.

Também ficaram atalhos para Highlightr, BuJo Bullets e Remove Newlines. No
celular, a barra de ferramentas ainda referencia um comando do BuJo Bullets.
Por isso, a lista de atalhos não serve, sozinha, como inventário de plugins
ativos.

Há ainda 19 arquivos diretamente em `notes` com blocos `mermaid`, embora
Mermaid Tools esteja desligado. Desativar uma extensão não apaga o material
associado a ela.

## Os plugins nativos que ficam ligados

Os [plugins nativos](https://obsidian.md/help/plugins) são os recursos incluídos
no Obsidian. No meu `core-plugins.json`, as entradas habilitadas são estas:

| Grupo | Entradas ligadas |
|---|---|
| Encontrar e abrir arquivos | Explorador de arquivos, busca e seletor rápido. |
| Percorrer relações | Backlinks, links de saída e painel de tags. |
| Consultar metadados | Propriedades e Bases. |
| Criar notas | Templates e criador de notas únicas. |
| Acessar comandos e acompanhar a edição | Paleta de comandos, status do editor e sumário (Outline). |

O criador de notas únicas aponta para `notes`, usa um template padrão e tem o
formato `0.YYYYMMDD.HHmm`. O `app.json` também direciona novas notas para `notes`
e anexos para `assets`.

Minha leitura desse conjunto é que o ambiente privilegia abrir arquivos,
escrever, seguir relações e trabalhar com propriedades. Essa interpretação
descreve a configuração; não é uma medição de produtividade.

## Os nativos que deixo desligados

A lista completa das entradas desabilitadas é:

| Grupo | Entradas desligadas |
|---|---|
| Exploração e organização visual | Grafo, Canvas, favoritos e espaços de trabalho. |
| Captura e rotina | Notas diárias, nota aleatória e gravador de áudio. |
| Apoio à edição e leitura | Painel de notas de rodapé, prévia de página, compositor de notas, comandos com `/` e contador de palavras. |
| Apresentação e navegação web | Slides e visualizador web. |
| Serviços e recuperação | Publish, Sync e recuperação de arquivos. |
| Outra entrada do arquivo | `markdown-importer`. |

As contagens deste post correspondem às entradas salvas no JSON. Mantive o
identificador técnico `markdown-importer` para registrar exatamente o que está
no arquivo.

Notas diárias continuam com atalhos cadastrados, apesar de o recurso estar
desligado. O grafo e o Canvas também permanecem desativados, como no post de
agosto. Ainda assim, há uma ferramenta de desenho habilitada: o Excalidraw.

A recuperação de arquivos merece uma avaliação separada. A
[documentação do recurso](https://obsidian.md/help/plugins/file-recovery) descreve
a recuperação por snapshots periódicos, cópias do conteúdo das notas. Como essa opção está
desligada aqui, ela não deve ser contada como uma proteção ativa deste cofre.
Publish e Sync também estão desabilitados; esse estado não informa quais
processos de publicação ou sincronização existem fora do aplicativo.
