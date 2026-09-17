# Um favorito para pedir o TL;DR de qualquer página ao ChatGPT

Published: 2026-08-11
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/bookmarklet-tldr-chatgpt/
Tags: ChatGPT, JavaScript, Bookmarklet, Jekyll, Automação

---

Eu mantenho nos meus sites um link que oferece ao leitor a opção de começar por
um resumo do texto. O arquivo HTML que deu origem a este post contém uma
variação portátil dessa ideia: em vez de funcionar apenas nos meus artigos, ela
usa a página que estiver aberta no navegador.

É um bookmarklet, um favorito cujo endereço começa com `javascript:`. Quando
acionado, ele pega `location.href`, coloca a URL em um prompt e o abre em uma
nova aba do ChatGPT.

O código não copia o conteúdo da página e não chama a API da OpenAI. Ele envia
ao ChatGPT o endereço público e o pedido de leitura. Essa diferença importa: o
resultado ainda depende de o ChatGPT conseguir acessar a página.

## Arraste este link para a barra de favoritos

Em um navegador desktop, mostre a barra de favoritos e arraste o botão abaixo
para ela:

<p>
  <a class="btn btn-primary" aria-label="TL;DR no ChatGPT; arraste para a barra de favoritos" title="Arraste para a barra de favoritos" href="javascript:(()=&gt;{const u=location.href;const p=`Por favor, abra esta URL com busca na web e leia o artigo completo:

${u}

Depois de ler o conteúdo real do artigo:
1) Resuma os cinco pontos mais importantes e a conclusão.
2) Explique quais detalhes, dados e insights eu perco por não ler o artigo completo.
3) Sugira uma boa pergunta de follow-up para continuar a conversa sobre o artigo.`;window.open(&#x27;https://chatgpt.com/?q=&#x27;+encodeURIComponent(p),&#x27;_blank&#x27;,&#x27;noopener&#x27;)})()">TL;DR → ChatGPT</a>
</p>

Depois:

1. abra o artigo que pretende resumir;
2. clique em **TL;DR → ChatGPT** nos favoritos;
3. revise o prompt aberto no ChatGPT;
4. envie a mensagem.

Se o navegador não aceitar o arrasto, crie um favorito comum, edite-o e cole o
código da próxima seção no campo destinado à URL. Clicar no botão nesta própria
página também funciona como exemplo: a página atual será a URL incluída no
prompt.

## O endereço completo do favorito

Este é o bookmarklet em uma única linha, no formato que precisa ser salvo como
URL:

```javascript
javascript:(()=>{const u=location.href;const p=`Por favor, abra esta URL com busca na web e leia o artigo completo:\n\n${u}\n\nDepois de ler o conteúdo real do artigo:\n1) Resuma os cinco pontos mais importantes e a conclusão.\n2) Explique quais detalhes, dados e insights eu perco por não ler o artigo completo.\n3) Sugira uma boa pergunta de follow-up para continuar a conversa sobre o artigo.`;window.open('https://chatgpt.com/?q='+encodeURIComponent(p),'_blank','noopener')})()
```

Uma versão HTML arrastável usa exatamente esse endereço no atributo `href`:

```html
<a href="javascript:(()=>{const u=location.href;const p=`Por favor, abra esta URL com busca na web e leia o artigo completo:\n\n${u}\n\nDepois de ler o conteúdo real do artigo:\n1) Resuma os cinco pontos mais importantes e a conclusão.\n2) Explique quais detalhes, dados e insights eu perco por não ler o artigo completo.\n3) Sugira uma boa pergunta de follow-up para continuar a conversa sobre o artigo.`;window.open('https://chatgpt.com/?q='+encodeURIComponent(p),'_blank','noopener')})()">TL;DR → ChatGPT</a>
```

Uma URL `javascript:` executa código no contexto da página atual. A
[documentação da MDN](https://developer.mozilla.org/en-US/docs/Web/URI/Reference/Schemes/javascript)
recomenda não usar esse esquema para navegação comum e observa que políticas de
segurança podem bloqueá-lo. Aqui ele tem uma finalidade deliberadamente
restrita: ser instalado pelo próprio usuário como favorito. Eu não instalaria
um bookmarklet sem antes ler seu código.

## O que acontece quando clico

A versão expandida é mais fácil de inspecionar:

```javascript
const articleUrl = window.location.href;

const prompt = `Por favor, abra esta URL com busca na web e leia o artigo completo:

${articleUrl}

Depois de ler o conteúdo real do artigo:
1) Resuma os cinco pontos mais importantes e a conclusão.
2) Explique quais detalhes, dados e insights eu perco por não ler o artigo completo.
3) Sugira uma boa pergunta de follow-up para continuar a conversa sobre o artigo.`;

const chatgptUrl =
  `https://chatgpt.com/?q=${encodeURIComponent(prompt)}`;

window.open(chatgptUrl, '_blank', 'noopener');
```

O `encodeURIComponent()` impede que espaços, acentos, quebras de linha e
caracteres como `&` sejam interpretados como partes separadas da URL. A
[referência da função](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent)
descreve justamente seu uso para codificar um valor que será colocado em uma
query string.

O terceiro argumento de `window.open()` usa `noopener`, impedindo que a nova aba
receba uma referência para a janela de origem. A opção faz parte dos
[recursos documentados de `window.open()`](https://developer.mozilla.org/en-US/docs/Web/API/Window/open).

O prompt pede três resultados. Além dos cinco pontos e da conclusão, ele
solicita os detalhes perdidos pela leitura abreviada e uma pergunta para
continuar a conversa. Esse segundo item evita fingir que um TL;DR equivale ao
artigo inteiro.

## Um exemplo com URL fixa

Dentro de um site, a URL do artigo já é conhecida. Não é necessário capturar a
aba atual. Este link abre o mesmo prompt para
“Publicando apps Python no Nomad sem Docker”:

<p>
  <a class="btn" href="https://chatgpt.com/?q=Por+favor%2C+abra+esta+URL+com+busca+na+web+e+leia+o+artigo+completo%3A%0A%0Ahttps%3A%2F%2Fwww.gpupo.com%2Fartigos%2Fpublicando-apps-python-no-nomad-sem-docker%2F%0A%0ADepois+de+ler+o+conte%C3%BAdo+real+do+artigo%3A%0A1%29+Resuma+os+cinco+pontos+mais+importantes+e+a+conclus%C3%A3o.%0A2%29+Explique+quais+detalhes%2C+dados+e+insights+eu+perco+por+n%C3%A3o+ler+o+artigo+completo.%0A3%29+Sugira+uma+boa+pergunta+de+follow-up+para+continuar+a+conversa+sobre+o+artigo." target="_blank" rel="noopener noreferrer">Abrir o exemplo no ChatGPT ↗</a>
</p>

O destino é formado por duas partes:

```text
https://chatgpt.com/?q=[PROMPT CODIFICADO]
```

O exemplo não chama um endpoint de API e não executa processamento no
gpupo.com. O navegador apenas abre uma URL do ChatGPT contendo o prompt.

## Como isso está implementado nos meus sites

O gpupo.com e o site da BP Strat usam o mesmo desenho para oferecer um TL;DR em
todas as páginas de determinados layouts. No gpupo.com, o leitor pode escolher
entre ChatGPT e Claude. Os dois links partem do mesmo prompt e mudam apenas a
URL de destino. Na BP Strat, a implementação continua apontando para o Claude.

No gpupo.com, o código está diretamente em `_layouts/post.html`. Todo conteúdo
com `layout: post` recebe o link. Na BP Strat, a lógica foi extraída para
`_includes/tldr-claude.html`; os layouts de posts e documentos reutilizam o
include e informam se o conteúdo é um “artigo” ou um “documento”.

Nos dois casos, Liquid monta o prompt durante o build do Jekyll. No gpupo.com,
o componente com as duas opções pode ser escrito assim:


```liquid
{% assign canonical_url = page.url | absolute_url %}
{% capture tldr_prompt %}
Por favor, abra esta URL com busca na web e leia o artigo completo:
{{ canonical_url }}

Depois de ler o conteúdo real do artigo:
1) Resuma os cinco pontos mais importantes e a conclusão.
2) Explique quais detalhes, dados e insights o leitor perde por não ler o artigo completo.
3) Sugira uma boa pergunta de follow-up para continuar a conversa sobre o artigo.
{% endcapture %}

{% assign encoded_prompt = tldr_prompt | strip | url_encode %}
{% assign chatgpt_tldr_url =
  'https://chatgpt.com/?q=' | append: encoded_prompt %}
{% assign claude_tldr_url =
  'https://claude.ai/new?q=' | append: encoded_prompt %}

Se preferir começar por um resumo, peça um TL;DR ao
<a href="{{ chatgpt_tldr_url }}" target="_blank" rel="noopener noreferrer">ChatGPT</a>
ou ao
<a href="{{ claude_tldr_url }}" target="_blank" rel="noopener noreferrer">Claude</a>.
```


O filtro `absolute_url` combina a URL e o `baseurl` configurados no site com
o caminho da página. O `url_encode` faz no build o trabalho que
`encodeURIComponent()` faz no navegador. Esses filtros estão descritos na
[documentação do Jekyll](https://jekyllrb.com/docs/liquid/filters/).

Esse desenho tem um componente global e não exige JavaScript para o link de
cada artigo. Se o prompt mudar, a alteração fica no layout ou no include, não
em todos os posts. O bookmarklet continua separado porque precisa descobrir em
tempo de execução qual página o usuário abriu, inclusive fora dos meus sites.

## O limite que deixei explícito

O protótipo que originou este post usa o parâmetro `?q=` como conveniência de
interface. Em uma consulta feita em 11 de agosto de 2026, a
[documentação oficial da OpenAI](https://developers.openai.com/) não apresentou
um contrato público que o defina como API estável.

Por isso eu o trataria como uma integração descartável. Se o formato mudar, o
favorito e o componente dos sites precisarão ser ajustados. Para uma integração
controlada por contrato, autenticação, erros e respostas estruturadas, o caminho
é a API oficial, não uma URL da interface do ChatGPT.

Também não usaria o favorito com páginas privadas. A URL e o prompt são enviados
ao ChatGPT. Páginas que exigem autenticação, bloqueiam acesso automatizado ou não
estão publicadas podem não ser lidas. Se a resposta não demonstrar contato com o
conteúdo real, resta copiar o trecho relevante ou fornecer o arquivo diretamente
em uma conversa.
