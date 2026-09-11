# Bora Radar: o que aprendi publicando 26 edições com Gemini e NotebookLM

Published: 2026-08-05
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/bora-radar-experimento-gemini-notebooklm/
Tags: IA, Automação, Curadoria, Prompt Engineering, Gemini, NotebookLM

---

Gerar um texto com inteligência artificial é fácil. Manter uma publicação
recorrente, com identidade, fontes, datas, links, roteiro, áudio e algum senso
crítico é outra história.

Em 2025, resolvi testar até onde a IA generativa poderia ajudar nesse segundo
problema.

Eu queria acompanhar as principais notícias de tecnologia e inteligência
artificial durante algumas semanas, mas não queria apenas acumular links ou
produzir mais uma newsletter genérica. A ideia era criar uma linha do tempo: um
registro que permitisse observar como as pautas evoluíam e quais assuntos
deixavam de ser novidade para se transformar em questões estruturais.

Ao mesmo tempo, queria experimentar uma forma de produção multimídia que
exigisse pouco esforço operacional. Um mesmo conjunto de fontes deveria servir
para gerar texto, roteiro, podcast e peças para outros canais.

Foi assim que nasceu o [Bora Radar](https://gpupo.substack.com/podcast).

Entre junho e dezembro de 2025, o experimento chegou a 26 edições. O Gemini e o
NotebookLM foram as principais ferramentas utilizadas, mas a experiência
mostrou algo importante: automatizar a produção não significa eliminar a
autoria. Significa mudar o lugar onde o esforço humano é aplicado.

## A proposta do Bora Radar

O Bora Radar foi criado como um formato conciso e curado para profissionais que
acompanham tecnologia, desenvolvimento de software e inteligência artificial.

A missão editorial era simples:

> Informar sobre as transformações nas stacks modernas — sem hype, sem ruído e
> com o contexto que importa.

Cada edição tentava responder a três perguntas:

- O que realmente mudou naquela semana?
- Para quem aquela mudança importava?
- Qual era o impacto prático para quem trabalha com tecnologia?

O objetivo não era competir com portais de notícia ou publicar tudo o que havia
acontecido. Era separar movimento de ruído.

Por isso, os prompts usados na pesquisa delimitavam períodos específicos,
descartavam atualizações menores e pediam equilíbrio geográfico, evitando uma
cobertura limitada apenas aos Estados Unidos.

Essa delimitação foi essencial. Sem ela, a IA tendia a devolver uma coleção
extensa de lançamentos, anúncios e números. Com regras editoriais mais claras,
o resultado começava a se parecer com uma curadoria.

O dashboard do projeto ajuda a enxergar o que uma edição isolada não mostra: a
mudança gradual do foco editorial ao longo do ano.

<figure>
  <img src="/assets/images/bora-radar-evolucao-2025.svg" alt="Infográfico com a evolução das 26 edições do Bora Radar em quatro atos: sinais, agentes, ecossistema e fundamentos." loading="lazy">
  <figcaption>A linha do tempo vai da capacidade dos modelos à confiabilidade dos sistemas ao redor deles.</figcaption>
</figure>

## Como funcionava o processo

O fluxo de produção foi ganhando estrutura a cada edição.

No início, havia apenas fontes, documentos e alguns prompts. Com o tempo, o
experimento passou a funcionar como uma pequena redação aumentada por IA:

```text
fontes da semana
  → pesquisa e síntese no Gemini
  → curadoria e revisão
  → roteiro e vozes no NotebookLM
  → texto, podcast, áudio e vídeo
```

O fluxo abaixo resume a divisão de trabalho. A IA fazia a pesquisa, a síntese e
a adaptação de formato; a curadoria humana decidia o que merecia entrar na
edição e como o assunto deveria ser explicado.

<figure>
  <img src="/assets/images/bora-radar-pipeline-editorial.svg" alt="Diagrama do pipeline editorial do Bora Radar, com cinco etapas: fontes, Gemini, curadoria, NotebookLM e saídas multimídia." loading="lazy">
  <figcaption>Uma fonte canônica permitia derivar texto, podcast e vídeo sem reconstruir o conteúdo a cada vez.</figcaption>
</figure>

### 1. Coleta das fontes

O material bruto vinha de newsletters, Hacker News, GitHub Trending, podcasts,
canais técnicos, artigos e anúncios oficiais.

As fontes eram reunidas dentro de uma janela temporal correspondente à edição.
O objetivo era construir um repertório suficiente para comparar notícias e
identificar temas recorrentes.

### 2. Pesquisa e síntese com Gemini

O Gemini ajudava principalmente na pesquisa, organização e condensação das
informações.

Os prompts definiam o período, os critérios de relevância e o tipo de notícia
procurado. Também pediam para evitar pequenas atualizações de produtos e buscar
acontecimentos com impacto técnico, estratégico ou econômico mais amplo.

Além dos prompts de pesquisa, criei uma espécie de manual editorial para
orientar a escrita. Ele descrevia o tom, a estrutura das edições, os limites e
algumas expressões que deveriam ser evitadas.

A IA não recebia apenas o pedido “escreva uma newsletter”. Ela recebia um
contrato editorial.

### 3. Curadoria e revisão

Depois da síntese vinha a parte mais importante: decidir o que permanecia.

Nem sempre a notícia mais comentada era a mais relevante. Em vários casos, um
lançamento chamativo dividia espaço com uma vulnerabilidade, uma mudança de
arquitetura ou uma decisão regulatória que teria consequências mais duradouras.

Essa seleção continuou sendo humana.

A IA ajudava a condensar e organizar, mas a identidade do Bora Radar vinha do
recorte, da sequência dos assuntos e da tentativa de trazer cada notícia para a
realidade de quem trabalha com tecnologia.

Também era necessário revisar fatos, ajustar afirmações exageradas e verificar
se o texto realmente correspondia às fontes. Por isso, as edições incluíam um
alerta recorrente:

> Este conteúdo foi criado com o apoio de IA generativa e recomendamos sempre
> a validação crítica das informações apresentadas.

Aquilo não era apenas um rodapé burocrático. Era parte do método.

### 4. Roteiro e vozes com NotebookLM

Com o conteúdo consolidado, o NotebookLM ajudava a transformar as fontes em uma
conversa narrada em português brasileiro.

Os prompts definiam a abertura, o fechamento, a pronúncia, o ritmo e algumas
características da apresentação. A intenção era produzir um episódio fluido,
sem excesso de hesitações ou explicações desnecessárias.

Assim, o mesmo conteúdo que originava a edição em texto também servia como base
para o podcast. As vozes eram geradas pelo NotebookLM. A curadoria permanecia
comigo.

### 5. Publicação multimídia

A base editorial podia então ser reaproveitada em diferentes formatos:

- newsletter no Substack;
- episódio de podcast;
- arquivos de áudio;
- vídeos;
- textos de compartilhamento;
- chamadas para redes sociais.

A planilha do projeto acabou se tornando o centro de controle da operação. Nela
ficavam a numeração, as datas, a cobertura, o título, o resumo, os prompts, o
roteiro de abertura, o alerta de validação, o fechamento e os links de
publicação.

Mais do que organizar informações, essa estrutura evitava que cada edição
começasse do zero.

## O que a linha do tempo revelou

O arquivo das 26 edições acabou registrando não apenas notícias isoladas, mas
uma mudança gradual na conversa sobre inteligência artificial.

Nas primeiras edições, o foco estava na capacidade dos modelos e nos riscos
mais imediatos. Apareciam falhas em aplicações geradas por IA, alucinações,
disputas por talentos, direitos autorais e preocupações com a revisão de código
produzido por modelos.

Depois, a IA começou a sair da janela de chat e entrar no fluxo de trabalho.

O Gemini chegou ao terminal. A OpenAI apresentou o ChatGPT Agent. Ferramentas
locais e de código aberto ganharam espaço. Empresas passaram a testar agentes
no atendimento, no desenvolvimento de software e na automação de tarefas.

Nesse momento, a pergunta começou a mudar.

Já não era apenas “o que este modelo consegue responder?”. Passou a ser “o que
este agente consegue fazer com acesso aos meus arquivos, sistemas e
credenciais?”.

Nos meses seguintes, os modelos se transformaram em ecossistemas. Sora, Claude,
Gemini, Copilot e MCP começaram a disputar navegadores, ferramentas de
desenvolvimento, suítes corporativas e interfaces de trabalho.

Ao mesmo tempo, surgiram dúvidas sobre produtividade, retorno do investimento e
infraestrutura. Os modelos avançavam, mas data centers, cadeias de chips, custos
operacionais e integração com sistemas existentes continuavam impondo limites.

No fim do ano, o radar voltou aos fundamentos.

Zero Trust, DevSecOps, microsserviços, npm, VS Code, React, Docker e supply
chain passaram a ocupar o centro das edições. Agentes mais capazes não
reduziram a importância da engenharia tradicional. Pelo contrário: tornaram
limites, permissões, observabilidade e segurança ainda mais necessários.

O arco de 2025 pode ser resumido assim:

> A conversa começou na capacidade dos modelos e terminou na confiabilidade dos
> sistemas ao redor deles.

## O que aprendi sobre automação editorial

### O prompt funciona melhor como contrato

Os melhores resultados não vieram dos prompts mais longos, mas dos que definiam
claramente o papel de cada etapa.

Tom, estrutura, período, critérios de seleção, fontes, limites e formato de
saída precisavam estar explícitos.

Quando essas regras estavam documentadas, a IA deixava de improvisar uma
publicação diferente a cada semana e começava a operar dentro de um sistema
editorial.

### Uma fonte canônica facilita o multimídia

Produzir texto, áudio e vídeo separadamente gera retrabalho e inconsistência.

O processo ficou mais simples quando resumo, roteiro, abertura, links e texto de
compartilhamento passaram a viver juntos. A partir dessa base, os outros
formatos se tornavam derivações do mesmo conteúdo.

Isso também facilita correções. Uma informação revisada na fonte canônica pode
ser atualizada antes de gerar os formatos seguintes.

### Automação reduz operação, não responsabilidade

A IA economizou tempo em tarefas de pesquisa, síntese, estruturação e adaptação
de formato. Mas não resolveu automaticamente problemas de veracidade,
relevância ou julgamento.

Na prática, o esforço apenas mudou de lugar.

Passei menos tempo formatando documentos e mais tempo escolhendo notícias,
comparando versões, corrigindo interpretações e conectando os acontecimentos.

Automatizar não retirou o autor. Tornou mais evidente o que realmente dependia
dele.

### Periodicidade transforma conteúdo em observatório

Uma única edição oferece um retrato da semana. Várias edições em sequência
revelam movimentos que seriam difíceis de perceber de outra maneira.

Temas que pareciam isolados começaram a formar padrões: a expansão dos agentes,
a pressão por retorno financeiro, o crescimento das ferramentas locais, a
disputa pelas interfaces e o aumento dos ataques à cadeia de desenvolvimento.

O arquivo passou a ter um valor diferente do conteúdo individual. Ele se tornou
uma memória do período.

### Arquivar também precisa ser parte da automação

Uma das lições menos óbvias foi perceber que publicar é apenas metade do
trabalho.

Datas, links, IDs, mídias, prompts e fontes precisam ser preservados de maneira
consistente. Pequenos erros de numeração ou períodos divergentes se tornam
difíceis de corrigir quando o histórico cresce.

Se eu começasse novamente, adotaria um formato estruturado desde a primeira
edição e automatizaria a validação de links, datas e números antes da
publicação.

## O que eu faria diferente

Uma próxima versão do Bora Radar teria um pipeline editorial mais explícito:

- cada edição seria armazenada em um formato estruturado e versionado;
- afirmações e fontes ficariam separadas do texto final;
- links e datas seriam validados automaticamente;
- os prompts usados seriam preservados junto com a edição;
- formatos derivados só seriam gerados depois da aprovação editorial;
- o tempo economizado e o número de correções seriam medidos;
- as alterações entre uma edição e outra poderiam ser comparadas.

Também manteria uma distinção clara entre pesquisa, síntese, opinião e fato.
Essa separação facilitaria auditorias e permitiria atualizar uma edição sem
reconstruir todo o conteúdo.

## O experimento terminou, mas o radar ficou

O Bora Radar não foi apenas uma tentativa de automatizar uma newsletter.

Foi um teste sobre como combinar curadoria humana, modelos generativos,
documentos estruturados e produção multimídia em uma rotina sustentável.

O principal aprendizado foi que o valor da IA não estava em gerar mais
conteúdo. Estava em reduzir o atrito entre uma ideia editorial e suas diferentes
formas de publicação.

A tecnologia ajudou a pesquisar, condensar, narrar e distribuir. Mas o
diferencial continuou sendo o mesmo que existia antes da IA: escolher o que
merece atenção, explicar por que aquilo importa e assumir responsabilidade pelo
que é publicado.

Ao final de 26 edições, o radar virou memória.

E talvez esse seja o resultado mais interessante do experimento: uma publicação
criada para acompanhar a velocidade das notícias acabou se tornando uma forma
de olhar para elas com mais distância.

O arquivo público continua disponível nos canais em que foi publicado.
