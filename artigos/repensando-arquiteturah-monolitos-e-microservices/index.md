# Monólito ou microsserviços: decida pelo limite que precisa mudar

Published: 2023-05-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/repensando-arquiteturah-monolitos-e-microservices/
Tags: Arquitetura, Engenharia de Software, Sistemas Distribuídos

---

A escolha entre monólito e microsserviços costuma ser apresentada como uma decisão de identidade: sistemas modernos usariam serviços pequenos; sistemas antigos permaneceriam monolíticos. Essa oposição esconde a pergunta útil.

**Que limite do sistema precisa mudar de forma independente — e qual custo estamos dispostos a assumir para isso?**

Separar um componente em outro processo pode permitir implantação e escala independentes. Também introduz chamadas de rede, observabilidade distribuída, compatibilidade entre contratos, tratamento de falhas parciais e novas responsabilidades operacionais.

Unir componentes reduz parte desse custo. Isso não garante um código simples: um único processo pode continuar mal dividido, com dependências circulares e alterações arriscadas.

Arquitetura é uma troca entre propriedades, não uma votação entre dois formatos.

## O caso do Prime Video foi menor do que a manchete

Em 2023, um relato da equipe de Video Quality Analysis do Prime Video circulou como prova de que “a Amazon abandonou microsserviços e voltou ao monólito”. O caso original tinha um escopo mais específico.

A equipe mantinha um serviço para analisar a qualidade de fluxos de áudio e vídeo. A primeira versão usava AWS Step Functions, AWS Lambda e armazenamento intermediário no Amazon S3 para coordenar componentes distribuídos. Ao ampliar o número de transmissões monitoradas, a arquitetura atingiu limites e apresentou custo elevado para aquela carga.

O redesenho reuniu etapas do fluxo em um único processo executado em tarefas do Amazon ECS sobre instâncias EC2. Segundo o [relato original arquivado](https://web.archive.org/web/20230504060528/https://www.primevideotech.com/video-streaming/scaling-up-the-prime-video-audio-video-monitoring-service-and-reducing-costs-by-90), a mudança reduziu em 90% o custo operacional do serviço de monitoramento.

Isso é evidência sobre um subsistema, uma carga e uma arquitetura inicial. Não demonstra que:

- todo o Prime Video migrou para um monólito;
- microsserviços são sempre mais caros;
- funções serverless não funcionam em escala;
- reunir componentes produzirá a mesma economia em outro sistema.

A interpretação mais útil é local: quando componentes são acionados juntos, escalam juntos e transferem grande volume de dados entre si, separá-los pode criar custo sem oferecer independência relevante.

## Três conceitos que não são equivalentes

### Monólito

Uma aplicação monolítica é implantada como uma unidade. Isso descreve seu limite de implantação, não a qualidade de sua estrutura interna.

Um **monólito modular** mantém módulos e contratos claros dentro dessa unidade. Ele pode ter testes por módulo, regras de dependência e separação de domínio sem transformar cada parte em um serviço de rede.

### Microsserviços

Microsserviços são unidades que podem ser implantadas e operadas de maneira independente, normalmente alinhadas a capacidades de negócio. A independência traz valor quando equipes precisam alterar, escalar ou proteger partes do sistema sem coordenar toda a aplicação.

Esse modelo exige recursos operacionais. O texto [Microservice Prerequisites](https://martinfowler.com/bliki/MicroservicePrerequisites.html), de Martin Fowler, destaca provisionamento rápido, monitoramento técnico, implantação automatizada e colaboração entre desenvolvimento e operações como condições importantes.

### Serverless

Serverless descreve um modelo de execução e operação de infraestrutura. Uma função pode participar de um sistema distribuído; vários componentes também podem formar uma única capacidade coesa. Usar Lambda, containers ou máquinas virtuais não define sozinho o limite do domínio.

Misturar essas dimensões leva a conclusões ruins. O caso do Prime Video não foi apenas “microsserviços contra monólito”: envolveu granularidade, coordenação, transferência de dados, modelo de cobrança e padrão de escala.

## Quando a separação pode pagar seu custo

Extrair um serviço tende a fazer mais sentido quando existe uma necessidade observável de independência, como:

- implantação frequente de uma capacidade sem coordenar as demais;
- perfil de escala muito diferente do restante da aplicação;
- requisito específico de disponibilidade, segurança ou isolamento;
- domínio com fronteira e responsabilidade estáveis;
- equipe capaz de desenvolver e operar o serviço durante todo o ciclo de vida;
- tecnologia especializada que justifica uma unidade operacional própria.

Mesmo nesses casos, a separação não precisa resultar em dezenas de serviços. Uma fronteira maior pode preservar a independência necessária com menos comunicação distribuída.

## Quando manter junto pode ser melhor

Um monólito modular costuma ser uma opção razoável quando:

- o domínio ainda está sendo descoberto;
- a equipe é pequena e trabalha no mesmo ciclo de entrega;
- os componentes mudam e escalam juntos;
- transações locais simplificam regras que exigiriam coordenação distribuída;
- a infraestrutura de observabilidade e operação ainda não sustenta vários serviços;
- não existe evidência de que a separação resolva o gargalo atual.

Começar com uma unidade de implantação não significa desistir de modularidade. Ao contrário: limites internos explícitos tornam uma futura extração menos arriscada. A estratégia conhecida como [Monolith First](https://martinfowler.com/bliki/MonolithFirst.html) parte da dificuldade de acertar fronteiras de serviço quando o domínio ainda é pouco conhecido.

## Um roteiro para tomar a decisão

### 1. Descreva o problema atual

Evite “precisamos modernizar”. Registre sintomas observáveis:

- uma alteração simples exige coordenar quatro equipes;
- o componente de imagens consome a maior parte da capacidade;
- uma falha no faturamento interrompe o catálogo;
- o tempo de implantação cresceu;
- uma exigência regulatória pede isolamento de dados.

### 2. Identifique o limite candidato

Mapeie dados, chamadas, responsabilidades e mudanças que atravessam a fronteira. Se duas partes precisam ser alteradas juntas na maioria das vezes, a separação pode apenas substituir dependência de código por dependência de rede.

### 3. Compare opções menores

Antes de extrair um serviço, verifique se o problema pode ser resolvido com:

- modularização interna;
- fila assíncrona em um ponto específico;
- réplica de leitura ou cache;
- separação de uma tarefa intensiva;
- melhoria do pipeline de implantação;
- isolamento de recurso sem separação completa do domínio.

### 4. Defina como medir

Escolha métricas relacionadas ao problema: custo por unidade de trabalho, tempo de implantação, frequência de mudança conjunta, incidentes, latência ou tempo de recuperação. Inclua custos de migração e operação, não apenas consumo de infraestrutura.

### 5. Mude de forma reversível

Uma extração gradual permite testar a fronteira com tráfego limitado. A orientação sobre [decomposição de monólitos](https://martinfowler.com/articles/break-monolith-into-microservices.html) recomenda que cada etapa produza uma melhoria arquitetural e priorize capacidades de negócio, não apenas conjuntos de classes.

## A arquitetura certa é contextual e temporária

Monólitos podem concentrar acoplamento; microsserviços podem distribuí-lo sem eliminá-lo. O critério não é quantidade de processos, mas a relação entre limites do domínio, autonomia de mudança e capacidade operacional.

O caso do Prime Video é valioso justamente porque a equipe revisou uma decisão diante de novas condições de escala e custo. A lição não é copiar a arquitetura final. É medir o comportamento do sistema, delimitar o problema e aceitar que uma escolha adequada no protótipo pode deixar de ser adequada em produção.
