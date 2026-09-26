# Uma esteira local para filtrar ruído técnico

Published: 2026-06-10
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/curadoria-tecnica-local-com-ia/
Tags: IA, Homelab, Automação, Curadoria, Miniflux

---

Eu não precisava de mais uma fonte de notícias. Precisava gastar menos atenção filtrando conteúdo que não tinha relação com os problemas técnicos que estou tentando resolver.

Construí uma pequena esteira de curadoria para o homelab. O Miniflux coleta artigos de várias fontes, um modelo local analisa cada item e os aprovados são publicados em um canal do Mattermost.

## O fluxo

O processamento segue uma sequência simples:

1. o Miniflux coleta os itens;
2. o modelo resume e traduz o texto para português;
3. uma instrução define se o conteúdo merece atenção;
4. o item é marcado como processado;
5. somente os aprovados seguem para o Mattermost.

Na primeira execução em produção, 23 notícias foram analisadas. Nove foram aprovadas e 14 descartadas. Isso representou uma redução de 60,8% no volume que chegaria à minha caixa de entrada.

O objetivo não era criar uma medida universal de qualidade. Era aplicar meus próprios critérios antes de eu gastar tempo lendo.

## O que foi descartado

O filtro rejeitou hype de IA, opiniões sem profundidade técnica, anúncios corporativos, conteúdo introdutório e tendências sociais sem relação com engenharia.

Ele priorizou temas como kernel Linux, BPF, sistemas operacionais, hardware, engenharia de dados, pipelines e ferramentas voltadas para desenvolvedores.

Essa lista não deveria ser tratada como regra definitiva. Um item fora dos temas favoritos pode ser importante. Por isso, eu manteria uma forma de consultar os descartados e revisaria amostras periodicamente.

## Automação não substitui critério

O modelo não sabe sozinho o que é relevante para mim. O resultado depende da instrução, das fontes, do idioma e da possibilidade de recuperar um item que foi classificado incorretamente.

Eu acompanharia pelo menos três sinais:

- quantidade de itens processados;
- proporção de aprovados;
- falsos negativos encontrados durante uma revisão manual.

Também separaria o trabalho determinístico da interpretação. Coletar, marcar como lido e publicar são tarefas que podem seguir regras. Resumir e julgar relevância são tarefas onde o modelo pode ajudar, mas precisam de observação.

O resultado é mais do que um agregador. É uma camada local de filtragem da atenção. O ganho não está em receber mais conteúdo, mas em decidir onde vale a pena olhar.
