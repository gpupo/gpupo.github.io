# A tecnologia de 2026 Q2

Published: 2026-08-02
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/a-tecnologia-de-2026q2/
Tags: Tecnologia, IA, Agentes, Segurança, Arquitetura, Observabilidade

---

O problema do segundo trimestre de 2026 não é mais decidir se um modelo consegue
responder. É decidir quando um sistema pode agir: consultar dados, chamar
ferramentas e alterar o estado de uma operação sem se tornar impossível de
explicar ou reverter.

No [meu balanço de 2025](/artigos/a-tecnologia-de-2025/),
escrevi que a inteligência artificial estava saindo do hype para entrar na
operação das empresas. Minha leitura é que esse movimento continuou no segundo
trimestre de 2026, mas o centro da discussão mudou. Antes, o foco estava nas pessoas usando modelos como
copilotos, chats e geradores de conteúdo. Agora, sistemas recebem objetivos,
acessam contexto, executam etapas e coordenam processos.

A mudança central é a passagem de **IA que responde** para **IA que age**.

Minha leitura para este trimestre é que os agentes avançaram, mas a vantagem
não está em dar autonomia máxima a um modelo. Está em combinar modelos,
ferramentas, permissões, avaliação e supervisão em um fluxo que a equipe consiga
operar.

## A mudança central: de respostas para ações

Um agente não é uma entidade mágica. É um sistema que recebe um objetivo,
consulta contexto, escolhe entre ferramentas e executa uma sequência de passos.
Isso o aproxima mais da engenharia de sistemas distribuídos do que da simples
criação de prompts.

Quando o sistema pode ler um banco de dados, abrir um arquivo, chamar uma API ou
alterar um registro, a pergunta relevante deixa de ser apenas “qual modelo usar?”
Ela passa a ser:

> Quais ações esse sistema pode executar, com quais dados, permissões e limites?

Essa é uma decisão de arquitetura. A interface continua importante, mas o risco
e o valor estão no que acontece depois que o usuário expressa a intenção.

## O que se confirmou

### IA entrou em produção, mas com escopo definido

Modelos já aparecem em produtos, fluxos internos e ferramentas de
desenvolvimento. A integração, porém, precisa começar por tarefas que tenham
limites claros.

Nos casos em que a autonomia foi mais útil, encontrei características parecidas:

- tarefa reversível;
- ferramentas bem definidas;
- permissões reduzidas;
- dados controlados;
- validação humana nos pontos críticos.

Para um projeto novo, eu começaria com uma etapa específica do processo, e não
com a promessa de que um agente irá administrar a operação inteira. Essa escolha
reduz o custo de aprender e torna os erros observáveis.

### Modelos menores e portfólios ganharam espaço

Nem toda tarefa precisa do maior modelo disponível. Um [levantamento acadêmico
publicado em 2025](https://arxiv.org/abs/2501.05465), baseado em aproximadamente
160 trabalhos, analisou modelos entre 1 e 8 bilhões de parâmetros e encontrou
casos em que especialização, qualidade dos dados e eficiência compensam o
tamanho. Isso não torna modelos pequenos melhores para qualquer problema. Torna
a escolha do modelo uma decisão de arquitetura.

É o que também venho observando nos meus testes locais. O
[Qwen 3.5 9B na RTX 5060 Ti](/posts/qwen-3-5-rtx-5060-ti-7-48-segundos/)
completou minha suíte padrão em 7,48 segundos e passou nos três critérios
automáticos. Esse resultado vale para aquela configuração; não é uma comparação
controlada de GPUs.

Em vez de escolher um único modelo, eu avaliaria um portfólio com funções
distintas:

- modelos locais para dados sensíveis;
- modelos pequenos para tarefas previsíveis;
- modelos maiores para problemas complexos;
- gateways para controlar acesso e custo;
- roteamento conforme risco, latência e qualidade.

O modelo pode ser substituído quando muda o custo, a qualidade ou a restrição de
privacidade. O produto precisa continuar funcionando mesmo quando essa troca
acontece.

### Observabilidade virou rastreabilidade

Logs e métricas continuam necessários, mas não explicam sozinhos por que um
agente tomou determinada decisão. Para reconstruir uma execução, eu também
registraria:

- prompt e contexto utilizados;
- ferramentas chamadas e seus argumentos;
- decisões intermediárias relevantes;
- consumo de tokens, custo e latência;
- qualidade da resposta;
- falhas, recusas e ações realizadas.

Na [pesquisa anual da CNCF publicada em janeiro de 2026](https://www.cncf.io/wp-content/uploads/2026/01/CNCF_Annual_Survey_Report_final.pdf),
o OpenTelemetry aparece em produção em 49% das organizações participantes e
26% estavam avaliando sua adoção. O mesmo relatório mostra a distância entre a
ambição em IA e a infraestrutura necessária para operá-la: 47% das organizações
implantavam modelos apenas ocasionalmente e somente 7% faziam implantações
diárias.

Esses números ajudam a separar demonstração de operação. Um sistema que não
permite reconstruir suas decisões ainda não está pronto para receber mais
autonomia.

### Protocolos abertos ajudam, mas não eliminam a arquitetura

Eventos, APIs e componentes desacoplados continuam importantes. A mudança está
também na padronização da comunicação entre modelos, ferramentas e agentes.

O [MCP](/artigos/mcp/) conecta modelos a ferramentas e
fontes de dados. O A2A trata da comunicação e da coordenação entre agentes. Em
abril de 2026, a [Linux Foundation informou](https://www.linuxfoundation.org/press/a2a-protocol-surpasses-150-organizations-lands-in-major-cloud-platforms-and-sees-enterprise-production-use-in-first-year)
que mais de 150 organizações apoiavam o A2A, com implantações em produção e
SDKs prontos para produção em cinco linguagens.

Esses protocolos reduzem o trabalho de integração, mas não resolvem contratos,
permissões, versionamento, tratamento de falhas ou observabilidade. A
interoperabilidade é útil quando esses limites também são definidos.

### Energia e eficiência passaram a afetar a arquitetura

Privacidade, sustentabilidade e custo sempre fizeram parte de algumas decisões
de tecnologia. Agora, o consumo de energia também começa a limitar diretamente
onde e como a inferência pode acontecer.

Segundo a [Agência Internacional de Energia](https://www.iea.org/reports/key-questions-on-energy-and-ai/executive-summary),
o consumo de eletricidade dos data centers cresceu 17% em 2025, enquanto o dos
data centers focados em IA cresceu 50%. Na projeção central da agência, o
consumo global dos data centers passa de aproximadamente 485 TWh em 2025 para
950 TWh em 2030.

Na prática, eu colocaria estes fatores na avaliação de uma solução:

- eficiência por tarefa;
- quantidade de parâmetros;
- quantização;
- localização da inferência;
- utilização real das GPUs;
- custo energético por resultado produzido.

O modelo mais capaz nem sempre é o modelo adequado. A escolha precisa considerar
qualidade, custo, latência, privacidade e energia no mesmo cenário de uso.

### Segurança passou a incluir identidades não humanas

Zero Trust, MFA, criptografia e proteção de dados continuam essenciais. A
diferença é que agora existem novos participantes dentro da infraestrutura: os
agentes.

Um agente pode consultar bancos de dados, abrir arquivos, chamar APIs, enviar
mensagens ou modificar sistemas. Uma falha de prompt, configuração ou
autorização pode virar uma falha operacional.

Em maio de 2026, CISA, NSA e agências de outros quatro países publicaram em
conjunto o guia [Careful adoption of agentic AI services](https://www.cyber.gov.au/sites/default/files/2026-05/careful_adoption_of_agentic_ai_services.pdf).
O documento recomenda adoção gradual, tarefas de baixo risco, privilégios
restritos, monitoramento contínuo, supervisão humana e planejamento para falhas.

Eu trataria cada agente como uma identidade não humana, com:

- credenciais próprias;
- permissões mínimas;
- acessos temporários;
- ferramentas autorizadas;
- limites de execução;
- auditoria de cada ação;
- possibilidade de interrupção e reversão.

Não basta proteger o modelo. É necessário proteger tudo o que ele pode fazer.

### As interfaces passaram a representar intenção

O usuário pode informar uma intenção, como investigar um incidente, preparar uma
alteração, organizar informações ou executar um processo. O sistema então sugere
ou executa as etapas necessárias.

Isso não elimina telas, formulários e dashboards. Eles continuam úteis para
mostrar contexto, pedir aprovação e revisar o resultado. A interface deixa de
representar cada passo da operação, mas precisa deixar claro o que o agente
pretende fazer, o que já fez e o que ainda depende de autorização.

Uma interface que esconde as ações do sistema reduz a capacidade de supervisão.
Uma interface que apresenta intenção, progresso, permissões e resultado pode
reduzir trabalho sem esconder o risco.

## O que não se confirmou

### Autonomia sem limites

Os agentes evoluíram, mas continuam sujeitos a erros, interpretações incorretas
e comportamentos inesperados. A autonomia útil aparece primeiro em ambientes
limitados. O agente que administra sozinho uma empresa inteira continua sendo
uma demonstração, não uma política operacional que eu adotaria.

### Um único modelo para tudo

O mercado procurou um modelo universal. A operação mostrou que custo,
privacidade, latência, contexto, idioma, especialização e execução local pesam
tanto quanto os rankings gerais.

Em muitos contextos, uma arquitetura multimodelo é mais flexível. Isso não
significa distribuir tarefas sem critério: o roteamento precisa ser medido e
revisado quando a qualidade ou o custo mudarem.

### A IA substituiria os sistemas existentes

A IA não eliminou bancos de dados, APIs, mensageria, observabilidade, controle
de acesso ou engenharia de software. Ao contrário: quanto mais IA entra nos
sistemas, mais importante se torna a infraestrutura previsível ao redor dela.

O papel da IA é adicionar uma camada de decisão e execução. Ela não substitui os
contratos e os mecanismos que mantêm a operação controlável.

## Como eu avaliaria um projeto de IA hoje

Para transformar essa leitura em decisão, eu usaria uma sequência simples.

### 1. Definir uma tarefa reversível

Escolha uma etapa em que um erro possa ser corrigido sem comprometer clientes,
dados ou o funcionamento do sistema. Defina também o que o agente não pode
fazer.

### 2. Escolher o modelo pelo contexto

Compare qualidade, latência, custo, privacidade e disponibilidade de execução
local. Um teste pequeno com dados representativos vale mais do que um ranking
genérico.

### 3. Formalizar ferramentas e permissões

Cada ferramenta deve ter contrato, argumentos validados, identidade própria e
permissões mínimas. A aprovação humana precisa ocorrer antes das ações que não
sejam reversíveis.

### 4. Criar avaliação antes de ampliar o uso

Monte um conjunto de casos reais, testes de regressão e critérios de qualidade.
Mudanças no prompt, nos dados, nas ferramentas ou no provedor podem alterar o
comportamento do sistema.

### 5. Medir a execução em produção

Registre a cadeia de chamadas, o contexto utilizado, a latência, o custo, as
falhas e a qualidade percebida. Sem esse histórico, a equipe não consegue saber
se uma melhoria realmente reduziu trabalho ou apenas mudou o tipo de erro.

### 6. Incluir eficiência e governança desde o desenho

Inventário de modelos, origem dos dados, registros de execução, avaliação de
riscos e supervisão humana precisam entrar na arquitetura quando o contexto
exigir.

No segundo trimestre de 2026, a União Europeia avançou em duas frentes. Em maio,
chegou a um [acordo político para ajustar o calendário das regras de alto risco](https://digital-strategy.ec.europa.eu/en/news/eu-agrees-simplify-ai-rules-boost-innovation-and-ban-nudification-apps-protect-citizens)
e abriu uma [consulta sobre as diretrizes de classificação desses sistemas](https://digital-strategy.ec.europa.eu/en/consultations/targeted-consultation-draft-guidelines-classification-high-risk-artificial-intelligence-systems).
As regras para sistemas autônomos de alto risco ficaram previstas para dezembro
de 2027; as integradas a produtos, para agosto de 2028.

Isso não significa que toda aplicação de IA seja de alto risco. Significa que
inventário, rastreabilidade e análise de riscos não devem ser deixados para o
final do projeto.

## Conclusão

O ponto central de 2026 não é encontrar o modelo mais impressionante. É definir
o que um sistema pode fazer, sob quais condições e com qual evidência de que seu
comportamento continua seguro, útil e economicamente viável.

Se eu começasse hoje um projeto com agentes, escolheria uma tarefa pequena e
reversível, estabeleceria as permissões, criaria uma avaliação com casos reais e
mediria qualidade, custo e latência antes de ampliar o escopo. Esse caminho
permite aprender com a operação sem transformar cada experimento em uma mudança
irreversível.
