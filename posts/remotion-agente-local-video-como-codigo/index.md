# Eu queria fazer um vídeo explicando como a empresa funciona. E queria usar IA.

Published: 2026-10-09
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/remotion-agente-local-video-como-codigo/
Tags: Inteligência artificial, Agentes de IA, Remotion, Vídeo como código, Automação, Codex

---

Recentemente, surgiu uma necessidade bastante comum:

> Eu queria fazer um vídeo explicando como a empresa funciona. Mostrar os
> processos, como as coisas se conectam, quem faz o quê. E queria usar
> inteligência artificial para produzir esse vídeo.

Diante desse pedido, é tentador procurar uma ferramenta de geração de vídeo
por IA: escrever um prompt, descrever algumas cenas e receber um vídeo.

Mas explicar o funcionamento de uma empresa exige representar corretamente
processos, regras, responsabilidades, sistemas e relações. Se a intenção é
mostrar como um pedido entra, por quais áreas passa e como chega ao cliente,
imagens de pessoas trabalhando em um escritório não explicam essas conexões.

É preciso contar uma história que corresponda à realidade.

Minha sugestão foi usar **Remotion combinado com um agente de programação
executado localmente**.  

<figure class="editorial-photo">
  <img src="/assets/images/remotion-agente-local-video-como-codigo.webp" alt="Ilustração em preto e branco de uma pessoa planejando um vídeo sobre o fluxo entre cliente, comercial, operações, financeiro e entrega, usando Remotion e um agente local" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Remotion e um agente local como proposta para representar e revisar um processo da empresa.</figcaption>
</figure>

## Em vez de gerar um vídeo, programar um vídeo

O [Remotion](https://www.remotion.dev/docs/the-fundamentals) permite criar vídeos
programaticamente usando React e JavaScript. As cenas são descritas em código:
um componente recebe o número do quadro atual e define o que deve aparecer
naquele momento.

Textos, gráficos, diagramas, transições e imagens podem ser organizados em
componentes. O avanço dos quadros determina quando cada elemento aparece, se
movimenta ou desaparece.

O resultado continua sendo um vídeo convencional. O projeto pode ser
[renderizado pelo Remotion Studio ou por linha de comando](https://www.remotion.dev/docs/render)
e distribuído em formatos como
[MP4](https://www.remotion.dev/docs/miscellaneous/video-formats). **O que muda é a representação do projeto:
o vídeo passa a ser descrito por código.**

Imagine uma animação explicando um processo da empresa. A primeira cena
apresenta o cliente. A segunda mostra a entrada de um pedido. Depois aparecem
os departamentos envolvidos, os sistemas utilizados e as etapas até a entrega.

Cada departamento pode ser um componente visual. As conexões podem ser
animadas, e as responsabilidades aparecem acompanhando o fluxo. Se uma etapa
mudar, podemos modificar aquela parte da composição, embora ainda seja
necessário renderizar e revisar o resultado.

O Remotion também permite
[parametrizar vídeos com dados](https://www.remotion.dev/docs/parameterized-rendering).
Isso abre a possibilidade de reutilizar uma composição com outros textos,
indicadores ou informações, em vez de manter um projeto separado para cada
variação.

A [documentação do Remotion para agentes](https://www.remotion.dev/docs/ai/coding-agents)
apresenta esse fluxo com ferramentas como Codex e Claude Code. Conforme as
ferramentas e permissões disponíveis, o agente pode ler arquivos, criar
componentes, modificar código e executar comandos no ambiente de
desenvolvimento.

O Remotion também mantém
[Agent Skills](https://www.remotion.dev/docs/ai/skills), com orientações para
composições, animação, áudio, fontes, temporização e renderização. Elas ajudam
a orientar o trabalho, mas não substituem a revisão do código e do resultado
visual. É o papel de instruções reutilizáveis que discuto em
[Uma Skill é muito menos mágica do que parece](/posts/uma-skill-e-muito-menos-magica-do-que-parece/).

Um pedido inicial poderia ser:

> Quero explicar como a empresa funciona em aproximadamente três minutos.
>
> Comece apresentando o cliente e depois mostre como uma solicitação percorre
> as áreas comercial, operacional e financeira.
>
> Utilize diagramas animados, textos curtos e uma linguagem visual simples.
>
> Quero revisar cada cena antes de produzir a versão final.

O agente pode ajudar a transformar essa descrição em componentes e cenas.
Depois, os pedidos de revisão ficam mais específicos:

- “Essa transição está rápida demais.”
- “Quero destacar a passagem entre essas duas áreas.”
- “Essa parte precisa mostrar que existem duas possibilidades.”
- “Vamos substituir esse texto por um diagrama.”

Estamos modificando um projeto. A alteração pode ficar concentrada no código
da cena correspondente, sem pedir uma nova geração de todas as imagens.

**A IA ajuda a construir o vídeo; a animação pode ser executada pelo software
sem uma nova chamada ao modelo para cada renderização.** Isso pressupõe que
os materiais necessários já estejam disponíveis e que o projeto não dependa
de geração externa durante a renderização.

O agente ainda pode produzir código errado ou uma animação inadequada. A
previsibilidade da execução não garante que a cena explique o processo
corretamente.

## Por que um agente local?

Tenho preferência por soluções nas quais os arquivos de trabalho ficam sob
nosso controle. Nesse cenário, o agente trabalha em um diretório do computador,
com o código, as imagens, os textos e os demais materiais da produção.

Podemos versionar o roteiro e o código com Git, comparar alterações e recuperar
uma composição anterior. É a ideia de
[criar checkpoints do projeto](/posts/versionar-e-criar-checkpoints/):
preservar um estado que já foi revisado antes de continuar modificando-o.

Também manteria disponíveis as fontes, imagens, áudios e versões das
dependências necessárias para reproduzir esse estado. Salvar apenas o código
não preserva um arquivo externo que foi substituído ou deixou de existir.

O uso de um agente local permite aproveitar ferramentas de desenvolvimento,
como Node.js, editores de código e scripts de automação. A
[separação entre modelo, ferramentas e permissões](/posts/como-usar-um-harness-como-assistente-de-anotacao/)
continua relevante: o agente só consegue operar o projeto conforme o acesso
que o ambiente oferece.

Executar o agente localmente não significa necessariamente que o modelo de IA
também seja local. Dependendo da ferramenta, solicitações e trechos dos
arquivos podem ser enviados a serviços externos. Eu verificaria esse fluxo
antes de trabalhar com informações internas ou confidenciais.

O ganho que procuro aqui é manter um projeto acessível e revisável, com os
materiais necessários para continuar a produção em outras sessões e
ferramentas.

## O roteiro continua sendo o principal problema

Antes de produzir qualquer animação, precisamos descobrir **o que realmente
queremos explicar**.

O funcionamento de uma empresa pode incluir exceções, caminhos alternativos,
atividades manuais, responsabilidades compartilhadas e processos que ninguém
documentou completamente. Um fluxograma bonito pode ocultar justamente essas
particularidades.

Uma IA não as conhece apenas porque recebeu o nome da empresa. Ela pode ajudar
a organizar as informações, identificar inconsistências no roteiro e propor
visualizações. Alguém precisa fornecer e validar o conhecimento sobre a
operação.

Eu começaria com um documento simples descrevendo um processo importante e as
relações entre suas etapas. Depois, organizaria uma sequência de cenas.

O primeiro vídeo não precisaria mostrar a empresa inteira. Esse recorte
serviria para validar a linguagem visual, o nível de detalhe e o esforço
necessário para produzir novas animações. Quem executa o processo deveria
conferir se o percurso e as responsabilidades estão representados corretamente.

Uma vez estabelecida uma estrutura, outros vídeos poderiam aproveitar os
mesmos componentes. Um treinamento de integração de funcionários, por exemplo,
poderia reutilizar as representações dos departamentos e sistemas de uma
apresentação institucional.

## Nem toda cena precisa ser gerada por IA

Essa abordagem permite escolher como produzir cada parte do material.

Para mostrar a fachada, podemos usar uma fotografia real. Para representar o
fluxo de informações entre dois sistemas, eu começaria por um diagrama animado.
Para apresentar indicadores, usaria gráficos construídos a partir dos dados
que queremos explicar.

Quando fizer sentido, imagens, narração ou outros materiais produzidos com IA
podem entrar na composição. Não existe obrigação de gerar tudo dessa maneira.

Para esse tipo de vídeo, eu reservaria a geração de imagens para cenas em que a
ilustração não precise reproduzir um detalhe operacional. Um diagrama com uma
seta errada ou uma responsabilidade atribuída à área errada pode ensinar um
processo que a empresa não executa.

O critério é fazer alguém compreender o funcionamento apresentado.

## Uma produção que pode continuar evoluindo

O aspecto que mais me interessa nessa combinação é manter o material
audiovisual como um projeto que pode evoluir.

Processos são reorganizados, sistemas são substituídos e departamentos assumem
novas responsabilidades. Quando esses elementos estão em componentes
reutilizáveis, uma alteração pode ser incorporada em um ponto conhecido do
projeto.

Isso não elimina edição, revisão e validação. Uma mudança num componente
compartilhado também pode afetar várias cenas; eu revisaria as composições que
reutilizam esse elemento.

O Remotion exige um ambiente de desenvolvimento e tem sua curva de
aprendizado. Um agente pode reduzir o trabalho de escrever cada componente,
mas ainda será necessário lidar com falhas de execução, ritmo, legibilidade,
áudio e coerência visual.

Também avaliaria as
[condições de licenciamento](https://www.remotion.dev/license) para a utilização
pretendida. A licença prevê situações de uso gratuito e de licença empresarial;
manter os arquivos localmente não determina qual delas se aplica.

Para uma produção pontual, uma ferramenta de edição já conhecida pela equipe
pode exigir menos preparação. Eu consideraria Remotion principalmente quando
revisar processos, reaproveitar componentes e gerar variações forem partes
recorrentes do trabalho.

## A ferramenta não precisa fazer tudo

Essa proposta segue a divisão de responsabilidades que discuto no texto sobre
[Jev, Clef e modelos de decisão em agentes](/posts/modelos-de-decisao/):
examinar o trabalho de cada etapa antes de entregá-la a uma LLM.

Aqui, o agente interpreta instruções e modifica o projeto. O Remotion renderiza
as composições definidas em código. Uma pessoa continua responsável pela
narrativa e pela correção das informações.

Foi por isso que minha sugestão para aquela conversa foi um agente local e o
Remotion. Para um vídeo explicativo que precisa ser preciso, revisável e
reutilizável, eu começaria com um processo, algumas cenas e uma revisão de quem
conhece a operação.

### Referências

- [Remotion — The fundamentals](https://www.remotion.dev/docs/the-fundamentals)
- [Remotion — Render your video](https://www.remotion.dev/docs/render)
- [Remotion — Video formats](https://www.remotion.dev/docs/miscellaneous/video-formats)
- [Remotion — Parameterized videos](https://www.remotion.dev/docs/parameterized-rendering)
- [Remotion — Prompting videos with coding agents](https://www.remotion.dev/docs/ai/coding-agents)
- [Remotion — Agent Skills](https://www.remotion.dev/docs/ai/skills)
- [Remotion — License](https://www.remotion.dev/license)

Fontes consultadas em 9 de outubro de 2026.
