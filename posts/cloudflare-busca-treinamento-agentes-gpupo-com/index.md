# Cloudflare separou busca, treinamento e agentes: a política do gpupo.com

Published: 2026-09-16
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/cloudflare-busca-treinamento-agentes-gpupo-com/
Tags: Cloudflare, Agentes de IA, Crawlers, robots.txt, Arquitetura Web

---

Tenho preparado o `gpupo.com` para ser lido não apenas em um navegador, mas
também por mecanismos de busca e agentes. O site oferece conteúdo estático,
sitemap, RSS, um [`llms.txt`](https://www.gpupo.com/llms.txt) e representações
Markdown das páginas editoriais. Em outro experimento,
[usei o site inteiro como corpus para iniciar conversas com o ChatGPT](/posts/pergunte-aos-meus-textos-usando-o-site-inteiro-como-contexto-para-o-chatgpt/).

Esse trabalho trouxe uma questão de política: eu quero que o conteúdo seja
encontrado e consultado por um agente em nome de uma pessoa, mas não trato sua
publicação como autorização genérica para treinamento de modelos. Busca,
treinamento e acesso por agentes são atividades diferentes para o site.

Por isso, eu não queria escolher entre bloquear todos os crawlers de
inteligência artificial e liberar qualquer uso do conteúdo.

A Cloudflare já separava o tráfego nas categorias **Search**, **Training** e
**Agent** [desde julho](https://blog.cloudflare.com/bot-preference-sync/). Em
15 de setembro de 2026, a empresa
[anunciou uma mudança nesses controles](https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/):
o antigo **Block AI Bots** será descontinuado e a opção **Disallow AI
Training** passou a permitir uma política mais específica para crawlers que
combinam busca e treinamento.

No painel, escolhi esta configuração:

```text
Search   → Allow
Training → Disallow AI Training
Agent    → Allow
```

Ela representa o que eu quero para o site. A verificação posterior, porém,
mostrou que selecionar a política no painel não bastou para aplicá-la ao host
canônico do `gpupo.com`.

## Search: quero que o conteúdo seja encontrado

A Cloudflare define **Search** como a atividade de rastrear páginas para
construir um índice de busca. Não vejo motivo para impedir esse acesso no meu
site.

Quero que um texto publicado possa ser descoberto por mecanismos de busca e
leve o leitor à fonte original. Por isso mantive:

```text
Search → Allow
```

Essa escolha também evita bloquear por completo crawlers de uso misto, como
Applebot, Bingbot e Googlebot, que podem participar tanto de busca quanto de
usos relacionados a IA. A distinção entre os usos precisa acontecer na política
de treinamento, não pela remoção do site dos índices.

## Training: recusar não significa apenas publicar um pedido

Publicar um texto na Web e permitir sua indexação não significa, para mim,
oferecer uma autorização genérica para treinamento de modelos. Foi por isso que
escolhi:

```text
Training → Disallow AI Training
```

O nome pode sugerir que essa opção apenas escreve uma diretiva no `robots.txt`,
mas o comportamento descrito pela Cloudflare tem duas partes:

- o [**Bot Preference Sync**](https://blog.cloudflare.com/bot-preference-sync/)
  publica a preferência de não treinamento para crawlers de uso misto
  considerados *Accountable*, que continuam liberados para busca;
- outros crawlers de treinamento são bloqueados pela rede, inclusive crawlers
  dedicados a treinamento que não precisam ser mantidos para preservar a
  descoberta em busca.

A própria Cloudflare explica que uma diretiva em `robots.txt`, isoladamente,
não identifica a finalidade de uma requisição nem impede um crawler que decide
ignorá-la. A combinação entre preferência publicada, classificação de bots e
bloqueio na borda tenta cobrir esses casos diferentes.

Ainda assim, não trato **Disallow AI Training** como garantia universal. A
classificação depende de o crawler ser identificado, e o suporte dos operadores
não é uniforme. No anúncio de 15 de setembro, por exemplo, a Cloudflare informa
que o Bing ainda não recebe automaticamente essa preferência por `robots.txt`;
a Microsoft planeja oferecer esse mecanismo no início de 2027.

Mesmo quando aplicada ao tráfego que passa pela Cloudflare, minha decisão é uma
política e uma barreira parcial, não uma prova de que nenhum conteúdo será usado
para treinamento.

## Agent: quero permitir a consulta em nome de uma pessoa

Na classificação da Cloudflare, **Agent** abrange agentes direcionados por uma
pessoa, como bots que buscam uma página para um chat e agentes que usam um
navegador. Esse é um uso que quero permitir:

```text
Agent → Allow
```

Se alguém perguntar a um assistente como organizo minhas notas pessoais, quero
que o agente possa localizar os textos relevantes, consultar o material e
atribuir a resposta ao corpus. Isso é diferente de incorporar o conjunto dos
meus textos aos pesos de um modelo.

Bloquear agentes seria contraditório com o trabalho que fiz para tornar o site
legível por software. Liberá-los, por outro lado, não exige que eu trate
treinamento como o mesmo tipo de acesso.
