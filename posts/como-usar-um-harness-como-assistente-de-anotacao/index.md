# Como usar um harness como assistente de anotação

Published: 2026-10-02
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/como-usar-um-harness-como-assistente-de-anotacao/
Tags: Agentes de IA, Gestão do conhecimento, Markdown, Obsidian, AGENTS.md

---

Durante muito tempo, anotar significava escolher onde guardar alguma coisa.

Abrimos um aplicativo, criamos uma nota, pensamos num título, escolhemos uma
pasta, talvez acrescentamos algumas tags, fazemos links com outras notas e
seguimos em frente.

Funciona.

Mas existe um custo escondido: além de ter a ideia, precisamos administrar o
sistema que guarda a ideia.

É justamente nessa parte que um *harness* começa a ficar interessante.

## O modelo sozinho não é o assistente

Neste texto, uso *harness* como nome para o ambiente que coloca o modelo para
trabalhar: instruções, ferramentas, permissões e o fluxo que transforma uma
resposta em ação.

O termo não identifica uma arquitetura única. Dependendo do produto, esse
ambiente pode ter capacidades e limites bastante diferentes.

Quando conversamos com um modelo de linguagem numa janela de chat, ele consegue
escrever, resumir, classificar e sugerir. Isso não significa, por si só, que
consiga cuidar das nossas notas.

Para isso, o sistema precisa oferecer acesso ao lugar onde elas existem e às
operações necessárias para trabalhar ali. Pode incluir ferramentas para:

- ler e escrever arquivos;
- navegar em diretórios;
- executar comandos;
- pesquisar na web;
- consultar serviços externos.

O modelo interpreta o pedido e propõe o que fazer. O harness disponibiliza as
ferramentas, aplica permissões e executa as operações autorizadas.

Essa distinção importa. A capacidade não está apenas no modelo. Depende também
do que o ambiente permite que ele leia, altere e consulte.

## Em vez de abrir o sistema, podemos dizer: anote

Imagine que nossas notas sejam arquivos Markdown dentro de um diretório. Essa
mesma pasta pode ser aberta pelo Obsidian para navegação e edição, mas também
pode ser entregue a um agente por meio de um harness.

A partir daí, em vez de fazer todo o trabalho manual, podemos dizer:

> Anote esta indicação de filme.

Num ambiente configurado para isso, o agente pode criar a nota, registrar a
data e a fonte da indicação e procurar relações com pessoas, diretores ou
assuntos já presentes no arquivo.

Depois podemos perguntar:

> Qual era mesmo aquele filme que registrei algum tempo atrás?

O agente tem onde procurar.

<figure class="editorial-photo">
  <img src="/assets/images/codex-vault-assistente-anotacao.webp" alt="Terminal com o Codex verificando links Markdown e criando um mapa de conteúdo num cofre de notas." width="1361" height="1035" loading="lazy" decoding="async">
  <figcaption>O Codex trabalhando diretamente no meu cofre de notas: criação do mapa de conteúdo dos projetos e conferência dos links Markdown.</figcaption>
</figure>

Isso é diferente de usar um chatbot como bloco de notas. O conhecimento não
fica apenas na conversa. Ele é persistido num sistema que continua disponível
para outras sessões, ferramentas e modelos.

## Arquivos que continuam sendo nossos

Não é necessário começar com um banco de dados criado especialmente para a IA.
Podemos trabalhar com elementos simples:

```text
meu-caderno/
├── AGENTS.md
├── inbox/
├── notes/
├── attachments/
└── templates/
```

As notas podem continuar em Markdown. Imagens, PDFs e outros anexos podem ficar
ao lado delas.

Estar no diretório, porém, não torna todo anexo automaticamente pesquisável. O
harness ainda precisa de ferramentas capazes de extrair texto, ler metadados ou
aplicar OCR quando o conteúdo estiver apenas numa imagem.

Se amanhã trocarmos o agente, o modelo ou o harness, os arquivos continuam ali.
O Obsidian continua abrindo o diretório. Um editor de texto continua abrindo as
notas. O Git continua capaz de versionar as alterações.

Essa portabilidade, porém, não acontece automaticamente. Ela depende de manter
os dados em formatos legíveis, documentar as convenções e evitar que uma parte
essencial do sistema exista apenas dentro de um serviço proprietário.

Arquivos simples também não resolvem todos os cenários. Se o volume crescer
muito, várias pessoas precisarem editar ao mesmo tempo ou as consultas exigirem
estrutura rígida, um índice ou banco de dados pode se tornar necessário. O
ponto é que não precisamos começar por ele para experimentar o fluxo.

A inteligência pode mudar. A base de conhecimento não precisa mudar com ela.

## O `AGENTS.md` funciona como manual de trabalho

Se o agente vai alterar nossas notas, precisa saber como queremos que isso seja
feito.

É aí que um arquivo como `AGENTS.md` se torna útil. Ele pode explicar:

- que aquele diretório é um cofre de notas;
- como nomear os arquivos;
- quando criar uma nota e quando atualizar uma existente;
- como representar pessoas, empresas, obras e decisões;
- como guardar fontes e datas de consulta;
- como relacionar assuntos;
- quais informações não podem ser alteradas;
- quais mudanças exigem revisão humana.

Essa convenção não pertence a todos os harnesses. No Codex, especificamente, a
[documentação oficial sobre `AGENTS.md`](https://learn.chatgpt.com/docs/agent-configuration/agents-md)
explica que os arquivos são lidos no início da execução e combinados do escopo
global até o diretório de trabalho. Instruções mais próximas do arquivo em que
o agente trabalha podem especializar as regras mais gerais.

Isso reduz a necessidade de repetir o mesmo contexto em toda sessão. Uma regra
como esta pode ficar no próprio ambiente:

```markdown
Quando uma nova nota mencionar uma pessoa, livro ou empresa já existente,
adicione o link correspondente.

Não invente relações apenas porque duas notas usam palavras parecidas.

Registre a origem e a data de consulta de toda informação trazida da web.
```

O agente não precisa lembrar da conversa anterior. Precisa conseguir reler as
instruções e reencontrar os arquivos.

## A estrutura pode crescer com o uso

Também não é necessário desenhar toda a taxonomia antes de começar.

Há um risco em criar uma grande árvore de diretórios quando ainda não existe
material suficiente para mostrar quais divisões serão úteis. Podemos começar
com uma caixa de entrada e algumas notas:

```text
um livro
uma reunião
um produto em avaliação
uma ideia
uma decisão
uma empresa
```

Conforme o material aparece, padrões começam a surgir. Talvez faça sentido
separar empresas. Talvez apareçam projetos, equipamentos, livros, decisões ou
pesquisas.

O sistema pode ganhar estrutura em resposta ao uso real. O harness diminui o
trabalho mecânico de renomear, mover e atualizar links, mas não deveria
reorganizar tudo silenciosamente. Mudanças amplas precisam ser revisáveis e,
quando possível, versionadas.

## Um exemplo: estou pensando em comprar alguma coisa

Estamos navegando pela web e encontramos um equipamento interessante. Copiamos
o endereço e dizemos:

> Estou considerando comprar isto. Anote.

O agente pode registrar o produto, a URL, o preço encontrado e o motivo do
interesse. Como preços mudam, vale preservar também a moeda, a loja e a data da
consulta:

```markdown
# Interface de áudio — modelo X

- Estado: considerando
- Fonte: https://exemplo.com/produto
- Preço observado: R$ 999
- Consultado em: 2026-10-02
- Motivo: usar nas gravações em casa
```

Alguns dias depois encontramos um concorrente:

> Compare com aquele que eu estava considerando e registre.

Agora pode existir uma relação entre os dois. Depois compramos um deles:

> Comprei este.

O agente pode atualizar o estado ou criar o registro da compra e ligá-lo à
pesquisa anterior.

Meses depois, aquela pequena sequência conta uma história:

```text
pesquisa → comparação → decisão → compra
```

Não foi necessário projetar um banco de dados completo antes de começar. A
estrutura apareceu durante o uso.

## Outro exemplo: uma leitura

Durante a leitura de um livro surge uma ideia:

> Anote esta ideia e relacione com o livro.

Mais tarde aparece outra reflexão sobre o mesmo assunto. O agente pode sugerir
uma ligação com a primeira nota. Depois encontramos outro livro que trata do
tema e o sistema começa a formar uma pequena rede de conhecimento.

Meses depois, ao pesquisar o assunto, podemos reencontrar ideias que já haviam
saído da memória.

É a mesma possibilidade que me interessa na história do
[Zettelkasten](/posts/zettelkasten-longa-historia-pensar-com-pedacos-de-papel/):
o valor não está apenas nas notas individuais, mas nos caminhos que conseguimos
percorrer entre elas.

O agente pode ajudar a encontrar candidatos a conexão. A decisão de que duas
ideias realmente têm uma relação continua merecendo julgamento. Coincidência
de palavras não é o mesmo que relação de significado.

## O agente também pode pesquisar

Um harness pode oferecer ferramentas além do sistema de arquivos. Se houver
acesso à web, podemos pedir ao agente que consulte o site de uma empresa,
recupere a ficha técnica de um equipamento ou busque dados bibliográficos de um
livro.

Nesse ponto, ele deixa de ser apenas um arquivista e passa a ajudar na pesquisa
do próprio arquivo.

Mas informações externas precisam entrar com procedência. Eu manteria pelo
menos três distinções visíveis:

```text
o que eu escrevi
o que veio de uma fonte
o que o agente inferiu
```

Sem essa separação, uma síntese produzida pelo modelo pode parecer uma anotação
pessoal antiga, e uma inferência pode reaparecer meses depois como se fosse um
fato confirmado.

Também evitaria permitir que uma pesquisa na web sobrescrevesse silenciosamente
o conteúdo original. É mais seguro acrescentar a fonte, a data e o resultado
em uma seção identificada ou propor uma alteração para revisão.

## Local não significa automaticamente privado

Não precisamos transformar esse sistema imediatamente em servidor, aplicativo
ou serviço acessível pelo celular.

Se o agente tem acesso a notas pessoais, arquivos e outras ferramentas do
computador, expô-lo na internet aumenta a superfície de risco. Em muitos
cenários, faz sentido manter o harness restrito à máquina e conceder apenas as
permissões necessárias para o trabalho.

Ainda assim, “local” não garante que todos os dados permaneçam no computador.
Isso depende do modelo utilizado, dos serviços conectados, das ferramentas e
da configuração de rede. Um agente executado localmente pode enviar conteúdo a
uma API remota.

Antes de apontá-lo para um cofre pessoal, eu verificaria:

- quais diretórios ele consegue ler e escrever;
- para quais serviços o conteúdo pode ser enviado;
- quais operações exigem aprovação;
- como revisar e reverter alterações;
- onde ficam logs, backups e histórico;
- quais notas contêm dados que não deveriam ser expostos.

Durante o dia, uma alternativa simples é anotar no papel ou numa caixa de
entrada limitada. Depois transferimos aquilo que vale a pena para o sistema.
Essa etapa parece menos conveniente, mas funciona também como triagem: nem tudo
precisa entrar no arquivo permanente.

## Anotar deixa de ser administrar arquivos

Com um assistente trabalhando sobre o sistema, a preocupação muda.

Antes perguntávamos:

> Onde devo guardar isso?

Agora podemos perguntar:

> Vale a pena guardar isso?

A primeira pergunta é sobre administração de arquivos. A segunda é sobre
conhecimento.

Se decidirmos registrar algo, podemos delegar parte do trabalho mecânico:
criar, nomear, estruturar, relacionar e, quando autorizado, enriquecer a nota.

Isso não significa registrar automaticamente tudo o que acontece. Um sistema
que captura tudo pode produzir apenas um grande depósito de ruído.

A escolha humana continua essencial:

```text
isto foi interessante
isto foi uma decisão
quero lembrar desta conversa
esta ideia talvez volte a ser útil
esta informação merece sobreviver ao momento
```

O agente não precisa decidir sozinho tudo o que importa. Ele precisa tornar
mais barato preservar, encontrar e revisar aquilo que decidimos guardar.

Continuamos fazendo o que fazemos há séculos: anotando para não depender
exclusivamente da memória.

Só que agora o caderno pode ter um assistente.
