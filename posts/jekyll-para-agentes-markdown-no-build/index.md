# Jekyll para agentes: Markdown no build, sem transformar o blog em aplicação

Published: 2026-08-26
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/jekyll-para-agentes-markdown-no-build/
Tags: Jekyll, Agentes de IA, Markdown, GitHub Pages, Cloudflare, Arquitetura web

---

Em agosto de 2026, olhei para o `gpupo.com` como uma fonte que agentes de IA
precisam conseguir descobrir, acessar e interpretar.

O ponto de partida foi uma auditoria automatizada de *agent readiness*. A
primeira nota foi:

**2/100.**

A ferramenta sugeria OpenAPI, respostas JSON, negociação de conteúdo,
documentação para desenvolvedores e outras capacidades comuns em produtos com
API. Meu site, porém, é um blog em Jekyll publicado como arquivos estáticos no
GitHub Pages. A própria [documentação do GitHub descreve o Jekyll como um
gerador de sites estáticos](https://docs.github.com/en/pages/setting-up-a-github-pages-site-with-jekyll/about-github-pages-and-jekyll).

O score não é um padrão universal de qualidade. Este relato também não registra
uma rubrica que permita comparar a nota com outros sites. Uso os números apenas
para comparar execuções da mesma auditoria durante o trabalho.

A pergunta útil não era como chegar a 100. Era quais falhas impediam o acesso
ao conteúdo e quais sugestões apenas empurrariam o blog para uma arquitetura de
que ele não precisava.

## A primeira falha estava antes do Jekyll

A auditoria dizia que a página inicial não funcionava sem JavaScript e que
vários agentes estavam bloqueados. Isso não combinava com a arquitetura: o HTML
já nasce no build e chega pronto ao navegador.

O bloqueio estava no Cloudflare. Eu mantinha uma regra de segurança que impedia
acessos internacionais. Para visitantes brasileiros, o site funcionava. Para a
auditoria executada fora do Brasil, o caminho terminava num challenge antes do
conteúdo:

```text
agente
  ↓
Cloudflare
  ↓
challenge
  ✕
site
```

A ferramenta não recebia o HTML e interpretava o resultado como falta de
conteúdo utilizável.

Removi o bloqueio e executei a mesma auditoria outra vez. A nota passou de:

**2 → 55**

Nenhuma linha do Jekyll havia mudado. A primeira melhoria de *agent readiness*
foi tornar o conteúdo alcançável para o consumidor que tentava avaliá-lo.

Isso também expôs uma limitação do score: a nota inicial misturava
acessibilidade de rede e organização do conteúdo numa única medida.

## O redirect descartava o caminho

O domínio canônico é:

```text
https://www.gpupo.com
```

O domínio sem `www` existe para redirecionar até ele. A regra anterior se
comportava assim:

```text
gpupo.com/*
→
https://www.gpupo.com
```

Ela capturava o caminho original, mas não o reutilizava no destino. Por isso:

```text
https://gpupo.com/posts/algum-artigo/
```

terminava em:

```text
https://www.gpupo.com/
```

Uma URL inexistente também acabava na página inicial com HTTP `200`. Isso
impedia o consumidor de distinguir um artigo movido de um recurso inexistente.

A [documentação do Google sobre mudanças de
URL](https://developers.google.com/search/docs/crawling-indexing/site-move-with-url-changes)
alerta que redirecionar muitas URLs para uma página irrelevante, como a home,
pode ser tratado como *soft 404*. O problema não era exclusivo de agentes; o
comportamento HTTP estava errado para qualquer cliente.

Corrigi a regra para preservar caminho e query string:

```text
https://gpupo.com/posts/foo/
→
https://www.gpupo.com/posts/foo/
```

Agora um caminho inexistente continua inexistente no domínio canônico e recebe
HTTP `404`.

## Robots e sitemap já resolviam parte da descoberta

O `robots.txt` já permitia acesso geral e apontava para o sitemap:

```text
User-agent: *
Allow: /

Sitemap: https://www.gpupo.com/sitemap.xml
```

O sitemap também já existia. Não precisei criar uma camada paralela de
descoberta para descartar mecanismos que a web já oferece.

Minha interpretação é que buscadores e agentes compartilham parte das mesmas
necessidades num site editorial:

- URLs estáveis;
- redirects que preservam o recurso;
- status HTTP coerentes;
- conteúdo acessível sem execução obrigatória de JavaScript;
- sitemap, feed e metadados;
- uma URL canônica identificável.

Isso não torna SEO e acesso por agentes equivalentes. Apenas evita reconstruir
como novidade uma infraestrutura de descoberta que já funciona.

## A auditoria pediu negociação de conteúdo

Um dos checks esperava esta requisição:

```http
GET /posts/meu-artigo/
Accept: text/markdown
```

O cabeçalho `Accept` permite que um cliente informe quais tipos de mídia prefere
receber. Esse mecanismo faz parte da negociação de conteúdo definida pela [RFC
9110](https://www.rfc-editor.org/rfc/rfc9110.html#section-12.5.1).

Para atender ao check na mesma URL, eu precisaria colocar uma camada capaz de
inspecionar a requisição e escolher entre HTML e Markdown:

```text
cliente
  ↓
proxy ou worker
  ↓
GitHub Pages
```

Não queria introduzir runtime apenas para satisfazer a auditoria. Escolhi gerar
uma representação Markdown dedicada durante o build.

O HTML continua canônico:

```text
/posts/meu-artigo/
```

e o mesmo build também publica:

```text
/posts/meu-artigo/index.md
```

A estrutura resultante é estática:

```text
/posts/foo/
    ├── index.html
    └── index.md
```

Uma única fonte editorial gera as duas representações. Não existe um
`artigo-para-agentes.md` mantido manualmente ao lado do artigo original.

## O Markdown publicado não é uma cópia do arquivo-fonte

O arquivo usado pelo Jekyll contém detalhes do processo editorial, como front
matter, comentários internos e expressões Liquid. Eles não deveriam aparecer
sem tratamento na representação pública.

O plugin executado no build captura o conteúdo, resolve Liquid, remove
comentários internos e acrescenta metadados públicos. O resultado segue esta
forma:

```markdown
# Título do artigo

Published: 2026-08-26
Author: Gilmar Pupo
Canonical: https://www.gpupo.com/posts/exemplo/
Tags: Jekyll, Agentes de IA

---

Conteúdo...
```

Campos internos como `layout`, `published` e `permalink` não são copiados. O
HTML continua sendo a URL para citação, compartilhamento e indexação; o Markdown
é uma representação alternativa para leitura.

Essa separação mantém explícitos dois contratos:

- o arquivo-fonte pertence ao processo editorial;
- o `index.md` pertence ao produto publicado.

## O HTML anuncia a alternativa

Nas páginas que possuem representação Markdown, o `<head>` inclui:

```html
<link
  rel="alternate"
  type="text/markdown"
  href="/posts/foo/index.md">
```

O cliente não precisa adivinhar a convenção apenas pelo nome do arquivo. O HTML
aponta para a representação alternativa e preserva seu próprio `canonical`.

Também publiquei:

```text
https://www.gpupo.com/llms.txt
```

Uso esse arquivo como uma porta de entrada editorial. Ele apresenta autoria,
escopo, áreas principais, sitemap, feed e a convenção HTML/Markdown. Também diz
explicitamente que o site não oferece API pública, OAuth, MCP ou webhooks.

Não trato o `llms.txt` como substituto de `robots.txt`, sitemap, feed ou HTML.
Ele documenta como consumir este site específico.

## A convenção chegou às páginas

Depois dos artigos, estendi a geração a páginas editoriais selecionadas. O
resultado segue uma transformação previsível:

```text
/                    → HTML
/index.md            → Markdown

/about/              → HTML
/about/index.md      → Markdown

/posts/foo/          → HTML
/posts/foo/index.md  → Markdown
```

A previsibilidade reduz a descoberta a uma regra de caminho. Ela também evita
exceções diferentes para a home, páginas institucionais e posts.

## O build verifica os dois lados

A implementação ganhou uma validação própria. Depois de gerar o site, o teste
confere, entre outros pontos:

- se cada post publicado possui uma representação Markdown;
- se o `rel="alternate"` aponta para um arquivo existente;
- se o HTML preserva exatamente um `canonical`;
- se front matter e Liquid não resolvido não vazaram para o documento público;
- se rascunhos, posts futuros e conteúdos excluídos não foram publicados;
- se URLs HTML e Markdown existentes respondem no teste local;
- se caminhos inexistentes continuam retornando `404`.

Esses testes não demonstram que todo agente interpretará corretamente o
conteúdo. Eles verificam propriedades sob controle do build: existência,
ligação entre representações, isolamento editorial e comportamento básico das
rotas.

## A nota chegou a 80

Depois das mudanças, a mesma auditoria atribuiu:

**80/100.**

Os números intermediários ficaram assim:

```text
2  → acesso bloqueado antes do conteúdo
55 → acesso liberado
80 → redirects, descoberta e Markdown estático revisados
```

Essa leitura é uma interpretação do processo, não a decomposição oficial do
algoritmo da ferramenta.

Alguns problemas indicados pela auditoria eram materiais para o blog:

- agentes não conseguiam chegar ao site;
- redirects descartavam o caminho;
- recursos inexistentes acabavam na home;
- não havia uma representação Markdown explícita;
- a descoberta específica para agentes era limitada.

Outros checks pertenciam a outro tipo de produto:

- OpenAPI;
- OAuth;
- MCP;
- webhooks;
- documentação de API;
- recursos para desenvolvedores integrarem um serviço.

O blog não oferece uma API pública. Criar um `/openapi.json` sem operações úteis
melhoraria a presença de um artefato esperado pelo check, mas não a capacidade
de ler os artigos.

## `Accept: text/markdown` continua sem implementação

A URL canônica ainda devolve HTML, independentemente deste cabeçalho:

```http
Accept: text/markdown
```

O Markdown fica numa URL estática própria. Essa foi uma decisão consciente.

Se a mesma URL selecionasse a representação com base em `Accept`, eu também
precisaria tratar o cache como parte do contrato. A [seção sobre
`Vary`](https://www.rfc-editor.org/rfc/rfc9110.html#section-12.5.5) da RFC 9110
explica como esse cabeçalho informa quais campos da requisição influenciaram a
resposta e amplia a chave usada para reutilização em caches.

É possível implementar essa negociação num proxy ou worker. No estado atual,
o custo seria uma nova camada operacional para oferecer algo que as URLs
dedicadas já resolvem de maneira suficiente para o meu caso.

O check correspondente continua falhando. A limitação está documentada em vez
de escondida por uma implementação parcial.

## Agent readiness não transforma todo produto em API

Para uma aplicação bancária ou um SaaS com integrações, API, OAuth, MCP e
webhooks podem fazer parte do problema real. Para este site editorial, minha
necessidade ficou mais estreita:

```text
descobrir
   ↓
acessar
   ↓
ler
   ↓
navegar
   ↓
citar
```

A arquitetura permanece:

```text
Jekyll
  ↓
build
  ↓
arquivos estáticos
  ↓
GitHub Pages
```

Sem banco, backend ou API criada para aumentar o score.

A mudança estrutural cabe no build:

```text
uma fonte editorial
       │
       ├── HTML canônico
       └── Markdown alternativo
```

A auditoria foi de 2 para 80, mas o critério de decisão não foi maximizar a
nota. Corrigi as falhas que impediam acesso e descoberta, mantive explícito o
que o site não oferece e recusei infraestrutura que não correspondia ao produto.
