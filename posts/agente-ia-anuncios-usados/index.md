# Coloquei um agente de IA para cuidar dos meus anúncios de usados

Published: 2026-10-09
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/agente-ia-anuncios-usados/
Tags: Inteligência artificial, Agentes de IA, Codex, Obsidian, Markdown, Automação, Marketplace

---

Vender um pedal usado envolve uma sequência de tarefas pequenas: encontrar as fotos, conferir o modelo, definir o preço, escrever o anúncio, preparar uma imagem e lembrar onde aquilo foi publicado. Quando são vários equipamentos, essas tarefas começam a disputar espaço com a própria negociação.

Eu já tinha as fichas dos meus equipamentos musicais no Obsidian. Nesse aplicativo, o *vault* é a pasta que reúne minhas notas e anexos. Em 8 de outubro de 2026, usei esse material para montar um assistente de anúncios com IA. Queria apontar para uma nota existente e receber um anúncio organizado, com texto curto, imagens e histórico.

O resultado foi anúncios cadastrados,  artes salvas, um catálogo com nomes, preços e imagens.

As fichas dos equipamentos já continham marca, modelo, informações técnicas e dados de inventário. Durante a preparação da venda, elas receberam os preços atuais e as fotografias dos exemplares.

O agente usado nesse trabalho foi o Codex, com acesso aos arquivos locais e à ferramenta integrada de geração de imagens. Para orientar sua atuação, mantive um arquivo `AGENTS.md` no projeto Assistente Marketplace.

A missão definida no documento é ajudar um vendedor particular a preparar e organizar anúncios de equipamentos musicais. Eu continuo responsável pelos preços, pela avaliação de propostas, pela publicação e pelo fechamento dos negócios.

Algumas instruções tiveram efeito direto no resultado:

- cada anúncio deve ter uma nota canônica, com identificador único;
- os preços precisam ser números nos metadados, com valores separados para troca e Pix;
- informações desconhecidas ficam pendentes;
- fotografias e artes têm campos distintos;
- publicações, reservas e vendas dependem de confirmação;
- alterações relevantes entram no histórico;
- negociações e contratos têm registros próprios.

O `AGENTS.md` também passou a guardar minha preferência de redação. Editei o primeiro anúncio, informei que queria seguir aquele formato e o padrão foi incorporado às instruções para os próximos itens.

Isso tornou uma correção pontual reutilizável. Nos pedidos seguintes, bastou indicar os equipamentos e confirmar o estado de conservação.

As instruções ajudam a orientar o comportamento, mas continuam exigindo conferência. Elas não são uma garantia técnica de que toda saída estará correta.

## Usei Markdown com propriedades como base de dados

Cada anúncio ganhou um arquivo Markdown com um bloco YAML no início. Nesse bloco, chamado de *frontmatter*, o Obsidian guarda as [propriedades da nota](https://help.obsidian.md/properties). Usei essas propriedades para registrar preços, estado do anúncio e referências à mídia.

Este é um trecho simplificado do registro real do Ditto Looper, após a confirmação da publicação em 8 de outubro. O estado da arte aparece separado do estado do anúncio:

```yaml
---
tipo: anuncio
id: AN-2026-0004
produto: TC Electronic Ditto Looper
categoria: pedal
condicao: usado
conservacao: excelente condição
status: ativo
arquivado: false
preco_troca: 1400
preco_pix: 900
moeda: BRL
publicado_em: 2026-10-08
ficha_tecnica: "[[notes/3.20260905.tc-eletronic-ditto-looper]]"
foto_principal: "[[assets/98fa8f7dd9323d413471400f68fec848_MD5.jpeg]]"
arte: "[[Marketplace/Midia/Artes/AN-2026-0004 - TC Electronic Ditto Looper - v1.png]]"
arte_status: rascunho
canais:
  - WhatsApp - Grupo de Compra e Venda
---
```

O nome do produto e os preços são dados. A ficha técnica, a fotografia e a arte são referências a outros arquivos. O corpo da nota reúne o texto público, as imagens, observações internas e o histórico.

Essa separação facilita uma tarefa comum: conferir o anúncio sem precisar reler toda a documentação técnica do equipamento. A ficha completa continua no inventário e recebe um link; suas especificações não precisam ser repetidas no texto de venda.

A organização efetiva ficou distribuída assim:

```text
obsidian-main-vault/
├── Assistente-Marketplace/
│   ├── AGENTS.md
│   ├── README.md
│   ├── Modelos/                 # contratos em Markdown e HTML
│   └── Contratos/Referencias/   # exemplos fornecidos
└── obsidian/
    ├── notes/                  # fichas dos equipamentos
    ├── assets/                 # fotografias já usadas no Vault
    └── Marketplace/
        ├── Anuncios/           # registros canônicos
        ├── Midia/Artes/        # peças gráficas separadas
        └── Painel.base         # consultas e catálogo
```

Preservei as fotos em `assets/`, onde elas já estavam, e salvei as artes em uma pasta própria. Assim, cada imagem continua com uma procedência identificável, sem duplicar as fotografias só para encaixar uma estrutura nova.

## O anúncio público ficou curto

Uma ficha de equipamento pode ter páginas de especificações. Para anunciar no celular, escolhi uma estrutura que cabe em poucas linhas:

```text
Pedal TC Electronic Ditto Looper

Usado, Excelente condição

Troca: R$ 1.400,00
À vista / Pix: R$ 900,00

Somente negociação presencial em Curitiba
```

Esse texto foi produzido a partir dos dados do anúncio e da condição comercial que defini. Informações técnicas detalhadas continuam disponíveis na ficha para quando alguém perguntar.

## As artes exigiram direção visual e revisão

Pedi uma identidade inspirada em anúncios de revistas de guitarra dos anos 1990: composição vertical próxima de 4:5, tipografia forte, fotografia grande, textura discreta e dois blocos de preço bem visíveis.

As peças foram geradas com ImageGen a partir das fotos fornecidas. Cada uma recebeu os textos e valores do respectivo registro. Os arquivos de trabalho ficaram em PNG, com 1122 × 1402 pixels, e os prompts foram guardados nas notas dos anúncios. As artes continuavam marcadas como rascunho ou com atualização pendente; publicação do anúncio e aprovação da imagem são etapas distintas.

Este é um exemplo do resultado para o Ditto, ainda registrado como rascunho para revisão:

<figure class="editorial-photo editorial-photo--reference">
  <img src="/assets/images/agente-ia-anuncios-usados-ditto-arte.webp" alt="Arte de referência do anúncio do TC Electronic Ditto Looper, com fotografia do pedal, estilo de revista de guitarra dos anos 1990 e preços de R$ 1.400 para troca e R$ 900 no Pix" width="1122" height="1402" loading="lazy" decoding="async">
  <figcaption>Arte v1 do Ditto, criada com ImageGen a partir da foto do exemplar e mantida como rascunho. Os valores registram o experimento de 8 de outubro de 2026.</figcaption>
</figure>

A fotografia original permanece disponível separadamente:

<figure class="editorial-photo">
  <img src="/assets/images/agente-ia-anuncios-usados-ditto-foto.webp" alt="Fotografia original do pedal TC Electronic Ditto Looper sobre uma mesa de madeira, com o controle de volume, o footswitch e o conector lateral visíveis" width="1200" height="1600" loading="lazy" decoding="async">
  <figcaption>Fotografia do exemplar usada como entrada para a composição. O original permanece preservado no inventário.</figcaption>
</figure>

## O catálogo veio dos mesmos registros

Depois das primeiras artes, pedi uma lista com nomes, preços e fotos. Para isso, foi criado um `Painel.base`, que consulta as propriedades das notas no Obsidian.

O [Obsidian Bases](https://help.obsidian.md/bases) permite criar vistas em tabelas e cartões a partir dos arquivos e de suas propriedades. O [formato `.base`](https://help.obsidian.md/bases/syntax) descreve essas vistas, filtros e fórmulas.

No meu painel, o catálogo usa o campo `arte` quando há uma peça gráfica vinculada. Enquanto esse campo está vazio, mostra `foto_principal`. A lógica está registrada na própria Base:

```yaml
formulas:
  imagem_anuncio: if(arte, arte, foto_principal)
  imagem_lista: if(formula.imagem_anuncio, image(formula.imagem_anuncio), "")
```

Existem vistas de catálogo e lista com fotos, além de filtros para ativos, rascunhos, pausados, reservados, vendidos, arquivados e negociações.

Um anúncio aparece na vista Ativos quando satisfaz três condições:

```text
tipo = anuncio
status = ativo
arquivado = false
```

A vista Catálogo inclui ativos e rascunhos, mostrando o status. Isso permite ver o que está preparado e o que já teve publicação confirmada.

O benefício prático é que a lista lê as notas existentes. Quando o registro muda, a consulta reflete os dados; não preciso manter uma segunda relação manual dos mesmos itens.

Essa atualização vale para o painel local. O texto copiado para o WhatsApp, uma postagem no Facebook ou um PNG enviado anteriormente precisa ser atualizado no respectivo canal quando houver mudança.

## A publicação continuou comigo

O fluxo de criação começou com `status: rascunho`. Preparar o anúncio e gerar uma arte não comprovam publicação.

Eu publiquei os itens e depois informei ao agente:

> anunciei todos no grupo wpp

Com essa confirmação, ele atualizou os sete registros para `ativo`, anotou o canal, a data de publicação e uma entrada no histórico. 

O agente fez o trabalho local de preparação e organização. A ação externa de publicar foi minha. Não houve integração para enviar mensagens ao grupo ou operar o marketplace.

O histórico guarda a sequência de eventos. Uma entrada antiga pode dizer que o anúncio era rascunho; uma entrada posterior registra sua ativação. Isso permite entender como o estado atual foi alcançado.

## Deixei regras para propostas e modelos para contratos

Além dos anúncios, documentei como o assistente deve lidar com negociações. Cada item tem um preço de troca e outro para pagamento integral via Pix, definido como meu melhor preço à vista.

Para uma proposta com equipamento mais dinheiro, a regra registrada aplica ao saldo a proporção entre esses dois preços:

```text
complemento_pix = preco_pix × (preco_troca - valor_aceito) / preco_troca
```

Por exemplo, em uma simulação com os valores do Ditto, o preço de troca é R$ 1.400 e o de Pix é R$ 900. Se eu aceitasse um equipamento por R$ 350, o complemento calculado seria:

```text
saldo de troca = 1.400 - 350 = R$ 1.050
complemento Pix = 900 × (1.050 / 1.400) = R$ 675
```

Esse cenário é ilustrativo, sem proposta recebida ou aceite registrado. A fórmula representa a regra comercial que defini para esse projeto. O valor declarado pelo interessado precisa ser separado do valor que eu aceito. O cálculo ajuda a conferir uma negociação; minha decisão comercial continua necessária.

Se o valor aceito superar o preço de troca, as instruções exigem uma decisão minha, em vez de gerar complemento negativo ou troco automático.

Também forneci três contratos anteriores como referência. Os PDFs foram preservados, transcritos para Markdown e HTML, e usados para preparar dois modelos reutilizáveis: permuta e pagamento misto com recibo.

O Markdown fica como versão editável; o HTML independente é destinado à impressão em A4. Os modelos não reaproveitam automaticamente dados pessoais dos exemplos, e um recibo depende da confirmação de recebimento.

Hoje consigo pedir a preparação de um anúncio apontando para sua ficha e confirmar os dados que faltam. O agente transforma essas informações em arquivos que posso ler, revisar e manter. Eu continuo fotografando os equipamentos, decidindo as condições e conversando com os interessados.
