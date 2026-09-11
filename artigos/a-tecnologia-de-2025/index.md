# A Tecnologia de 2025

Published: 2025-06-12
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/a-tecnologia-de-2025/
Tags: Tecnologia, IA, Segurança

---

Em março de 2023, escrevi um texto sobre as tendências tecnológicas que estavam
moldando o mercado naquele momento. Agora, ao revisitar aquelas previsões em
2025, a pergunta é mais útil do que simplesmente contar acertos e erros: quais
ideias mudaram decisões de produto, arquitetura ou segurança, e quais
permaneceram como promessa?

A principal mudança que eu não havia destacado foi a entrada da IA generativa
no centro da tecnologia. Ela alterou a forma de trabalhar com software, dados e
atendimento e também mudou o critério para avaliar as outras tendências: uma
ideia passou a valer mais quando conseguia chegar à operação.

## O que se confirmou

### Privacidade e segurança ganharam peso

Com a expansão da IA generativa, o controle sobre dados, a criptografia e a
conformidade regulatória passaram a receber mais atenção. LGPD e GDPR deixaram
de ser apenas referências jurídicas e entraram nas decisões sobre produtos,
integrações e armazenamento.

Para mim, essa previsão se confirmou porque privacidade e segurança passaram a
afetar diretamente a escolha de fornecedores, a arquitetura das aplicações e o
local onde os dados podem ser processados.

### Interfaces naturais mudaram de formato

A previsão acertou a direção, mas a forma foi diferente da imaginada. Assistentes
de voz e realidade virtual avançaram de maneira mais lenta, enquanto interfaces
conversacionais com IA se espalharam rapidamente.

O uso natural de tecnologia passou a acontecer principalmente por texto e
contexto. Isso deslocou a discussão de gestos e dispositivos para a capacidade
de expressar uma intenção e receber uma resposta útil.

### A automação avançou mais do que a robótica física

Empresas automatizaram tarefas com IA, bots, RPA e modelos generativos. A
robótica física também evoluiu, mas o impacto mais imediato veio da automação
digital e de ferramentas que ajudam as pessoas a analisar, decidir e produzir.

Essa diferença importa porque automação digital costuma exigir menos investimento
inicial e pode ser incorporada aos processos existentes de forma gradual.

### Sustentabilidade entrou nas decisões técnicas

Sustentabilidade e impacto ambiental deixaram de ser assuntos restritos à
comunicação institucional. Cloud, hardware, energia e arquitetura passaram a
ser avaliados também por eficiência e consumo.

O movimento ainda é desigual, mas a eficiência energética dos chips e a forma de
operar data centers já fazem parte da conversa técnica. O critério precisa ser
aplicado ao custo real de executar um serviço, não apenas à sua intenção.

### Computação quântica ainda não chegou à operação ampla

O interesse pela computação quântica continuou alto, mas a adoção prática em
larga escala ainda não aconteceu. Para a maioria das equipes, ela continua
sendo uma área de pesquisa e uma possibilidade de longo prazo, não uma
tecnologia para resolver problemas cotidianos.

### Blockchain fora das criptomoedas não encontrou escala

As aplicações de blockchain em saúde, logística e rastreabilidade não tiveram a
adoção ampla que muitas previsões sugeriam. Houve experimentos e casos
específicos, mas a tecnologia não se tornou uma camada padrão desses setores.

O resultado reforça um critério simples: uma tecnologia precisa resolver melhor
um problema existente do que as alternativas já disponíveis. O uso de uma
estrutura distribuída, por si só, não cria valor.

## A previsão que ficou fora do centro

A chegada massiva da IA generativa foi a mudança mais relevante que não recebeu
destaque suficiente no texto de 2023. A tecnologia saiu do espaço de demonstração
e começou a aparecer em fluxos de trabalho, produtos, atendimento, análise de
dados e desenvolvimento de software.

O impacto não veio somente da capacidade dos modelos. Veio da combinação entre
modelos, dados, ferramentas, interfaces e processos de validação. Essa combinação
também explica por que o mesmo modelo pode produzir resultados muito diferentes
em projetos com contextos e restrições distintos.

## Forças que eu acompanharia em 2025

### IA generativa em produção

Modelos de linguagem passaram a ser incorporados a fluxos de trabalho, produtos
e sistemas internos. O desafio deixou de ser demonstrar que um modelo consegue
gerar uma resposta e passou a ser definir onde ele pode atuar, como sua saída
será validada e qual custo a operação aceita.

Eu começaria por uma tarefa delimitada, com resultado mensurável e possibilidade
de revisão humana. Aumentaria o escopo somente depois de observar qualidade,
latência, custo e taxa de falha.

### IA privada e focada

Modelos menores, execução local e treinamento com dados internos fazem sentido
quando privacidade, latência ou custo são mais importantes do que a capacidade
geral do maior modelo disponível.

Gateways privados, modelos especializados e ajustes internos podem reduzir a
dependência de APIs públicas. Essa escolha exige medir a qualidade obtida e o
custo de manter a infraestrutura, não apenas assumir que o controle adicional
será vantajoso.

### Observabilidade como rastreabilidade

Logs, métricas e tracing continuam necessários, mas não explicam sozinhos por
que um sistema baseado em IA tomou determinada decisão. Em aplicações desse tipo,
eu também registraria o contexto utilizado, as ferramentas chamadas, a versão
do modelo, a latência, o custo e as ações executadas.

OpenTelemetry, Jaeger e Grafana podem fazer parte dessa estrutura. O ponto
central é conseguir reconstruir uma execução e identificar se o problema veio do
modelo, dos dados, da integração ou da própria aplicação.

### Arquiteturas orientadas a eventos e componíveis

Plataformas modulares, comunicação por eventos e serviços componíveis ajudam a
separar responsabilidades e substituir partes do sistema. Kafka, NATS, Prefect
e Airflow são exemplos de ferramentas que podem apoiar essa abordagem, dependendo
do tipo de fluxo e da capacidade operacional da equipe.

O ganho de flexibilidade vem acompanhado de mais pontos de falha. Contratos,
versionamento, idempotência, observabilidade e tratamento de erros precisam ser
definidos antes que o desacoplamento vire apenas complexidade distribuída.

### Tecnologia com responsabilidade

Sustentabilidade, impacto social e ética digital precisam entrar na arquitetura
desde o início. Em sistemas de IA, isso inclui avaliar consumo de energia,
qualidade e origem dos dados, possibilidade de auditoria e efeitos sobre as
pessoas afetadas pelas decisões do sistema.

Esses critérios não substituem desempenho e custo. Eles ampliam a avaliação para
que uma solução tecnicamente eficiente também seja operável e defensável no
contexto em que será utilizada.

### Segurança por padrão

Zero Trust, MFA, criptografia e proteção de dados sensíveis continuam sendo
fundamentos. A diferença é que sistemas com IA também introduzem identidades não
humanas capazes de consultar bancos de dados, abrir arquivos, chamar APIs e
alterar registros.

Eu trataria cada agente como uma identidade própria, com credenciais específicas,
privilégios mínimos, limites de ação, registro das atividades e supervisão nos
pontos críticos. Uma falha de configuração ou autorização precisa ser reversível
antes de chegar à operação inteira.

### Interfaces invisíveis

Interfaces conversacionais e contextuais podem desaparecer dentro dos produtos
quando o usuário consegue expressar uma intenção sem navegar por muitas telas.
Esse modelo funciona melhor quando as ações são previsíveis, o resultado pode ser
confirmado e existe uma alternativa clara para corrigir um erro.

Por isso, a interface invisível não elimina a interface visual. Em operações de
maior risco, a aplicação ainda precisa mostrar o que será alterado, pedir
confirmação e permitir auditoria posterior.

## O que eu levaria para as decisões

As previsões de 2023 foram úteis quando ajudaram a identificar problemas concretos
e orientar escolhas. Para avaliar uma tecnologia em 2025, eu começaria por cinco
perguntas:

- qual restrição do produto ou da operação ela reduz;
- como o resultado será medido;
- quais dados e permissões serão necessários;
- qual custo de operação e de manutenção a equipe consegue absorver;
- como interromper ou reverter o comportamento quando algo der errado.

Essa abordagem mantém a curiosidade sobre novas tecnologias, mas impede que o
interesse pela novidade substitua a avaliação da utilidade. Para mim, uma
tecnologia entra no roadmap quando reduz uma restrição observável, cabe na
capacidade de operação da equipe e permite revisar a decisão com evidências.
