# AWS em português claro: o que EC2, IAM, S3 e outros serviços fazem

Published: 2026-08-21
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/amazon-web-services-in-plain-english/
Tags: AWS, Cloud, Infraestrutura, Arquitetura de software, Computação em nuvem

---

Já faz tempo que eu dou risada com um tipo de conteúdo que se repete pela web.

A AWS anuncia um serviço chamado qualquer coisa como **ContainerCache**, **ElastiCast** ou **QR72** e, por alguns segundos, você se pergunta:

> Isso existe mesmo ou alguém acabou de inventar?

Os três nomes acima eu inventei.

O problema é que poderiam perfeitamente existir.

Depois de tantos anos trabalhando com infraestrutura, cloud e arquitetura, resolvi deixar no blog uma versão adaptada daquela velha brincadeira: **como seriam os serviços da AWS se os nomes explicassem o que eles realmente fazem?**

Não é documentação oficial, muito menos um catálogo completo da AWS.

É um tradutor.

De **AWSês** para português.

## Primeiro, o kit básico

Há alguns serviços que aparecem em praticamente qualquer conversa sobre AWS.

### EC2

**Deveria se chamar:** Amazon Virtual Servers

**Para que serve:** rodar máquinas virtuais.

Você escolhe CPU, memória, disco, sistema operacional e sobe aquilo que, antes da nuvem, chamaríamos simplesmente de **servidor**.

**Em português claro:**

> “Preciso de um Linux ligado em algum lugar.”

EC2.

### IAM

**Deveria se chamar:** Amazon Users, Permissions and Keys

IAM é o lugar onde você responde perguntas como:

- quem pode entrar;
- quem pode fazer o quê;
- qual aplicação pode acessar qual serviço;
- quais credenciais existem;
- quais permissões estão sendo concedidas.

**Em português claro:**

> “Quem pode apertar este botão?”

IAM.

E, como quase sempre acontece com segurança, começa simples e pode terminar com uma política JSON que ninguém quer editar na sexta-feira às 17h42.

### S3

**Deveria se chamar:** Amazon Giant File Bucket

Você coloca arquivos lá.

Imagens. Backups. Logs. Artefatos. Exports. Datasets. Documentos. Arquivos estáticos.

E metade da AWS parece, em algum momento, querer colocar alguma coisa no S3 ou buscar alguma coisa de lá.

**Em português claro:**

> “Preciso guardar um arquivo e não quero administrar um filesystem.”

S3.

### VPC

**Deveria se chamar:** Amazon Private Network

É a sua rede virtual dentro da AWS.

Subnets, rotas, gateways, endereços IP, regras e os demais ingredientes necessários para transformar:

> “Tenho algumas máquinas na nuvem.”

em:

> “Tenho uma arquitetura de rede que agora precisa de um diagrama.”

Para quem conhece redes tradicionais, pense em switches, segmentos, roteamento e firewalls, só que definidos por software.

### Lambda

**Deveria se chamar:** Amazon Run This Function For Me

Você entrega uma pequena função. A AWS executa quando alguma coisa acontece.

Um arquivo chegou. Uma API foi chamada. Uma mensagem apareceu. Um evento ocorreu.

**Em português claro:**

> “Quando acontecer X, rode esse código.”

Lambda.

É simples até alguém construir uma aplicação inteira com 137 funções, 46 triggers e ninguém mais lembrar quem chama quem.

## Construindo aplicações web

Agora entramos na parte que normalmente aparece quando alguém decide colocar uma aplicação na AWS.

### API Gateway

**Deveria se chamar:** Amazon API Front Door

Fica na frente da sua API.

Pode receber requisições, definir rotas, autenticação, limites e versões, além de encaminhar chamadas para outros componentes.

**Em português claro:**

> “Tudo que chega na minha API passa primeiro por aqui.”

### RDS

**Deveria se chamar:** Amazon SQL Database

Você quer PostgreSQL, MySQL ou algum outro banco relacional sem precisar administrar cada detalhe da máquina onde ele roda.

RDS.

**Em português claro:**

> “Quero um PostgreSQL, mas prefiro não passar meu domingo atualizando PostgreSQL.”

### Route 53

**Deveria se chamar:** Amazon DNS

É DNS.

Registros. Domínios. Resolução de nomes. Health checks. Roteamento.

O nome vem de uma referência à porta 53 usada pelo DNS, porque naturalmente essa é a primeira coisa que todo desenvolvedor pensa quando precisa configurar um domínio.

**Em português claro:**

> “Quero que api.exemplo.com aponte para alguma coisa.”

Route 53.

### SES

**Deveria se chamar:** Amazon Send Email

Serve para enviar e-mails por aplicações.

Confirmação de cadastro. Recuperação de senha. Alertas. Notificações. Campanhas, dependendo de como você construir a solução.

**Em português claro:**

> “Minha aplicação precisa mandar e-mail.”

SES.

### CloudFront

**Deveria se chamar:** Amazon CDN

Distribui conteúdo por diversos pontos da infraestrutura da AWS para entregá-lo mais perto do usuário.

**Em português claro:**

> “Quero que este arquivo chegue mais rápido para alguém do outro lado do planeta.”

CloudFront.

### ElastiCache

**Deveria se chamar:** Amazon Managed Cache

Redis, Valkey, Memcached e coisas dessa família.

A ideia é evitar ir ao banco toda vez que alguém pergunta a mesma coisa.

**Em português claro:**

> “Já calculei isso uma vez. Posso guardar o resultado por alguns minutos?”

ElastiCache.

### DynamoDB

**Deveria se chamar:** Amazon Very Fast NoSQL Database

Banco distribuído, gerenciado e projetado para trabalhar em grande escala sem você precisar administrar servidores de banco.

**Em português claro:**

> “Preciso guardar e buscar dados muito rapidamente e meu problema não exige necessariamente SQL.”

DynamoDB.

## Mensagens e integração

Aplicações distribuídas eventualmente descobrem uma verdade universal:

**às vezes é melhor deixar um recado do que ficar esperando o outro sistema responder.**

É aí que começam filas, eventos e mensageria.

### SQS

**Deveria se chamar:** Amazon Queue

É uma fila.

Alguém coloca uma mensagem. Outro componente pega depois.

**Em português claro:**

> “Faça isso quando puder.”

SQS.

É uma das ideias mais simples e úteis de arquitetura distribuída.

E não: “message” aqui não significa WhatsApp, SMS ou e-mail. É apenas uma unidade de trabalho esperando alguém processá-la.

### SNS

**Deveria se chamar:** Amazon Publish This Everywhere

Você publica uma mensagem e vários interessados podem recebê-la.

**Em português claro:**

> “Aconteceu uma coisa. Avisem quem estiver interessado.”

SNS.

### EventBridge

**Deveria se chamar:** Amazon Something Happened

Um evento aconteceu.

Pedido criado. Arquivo processado. Deploy concluído. Pagamento confirmado.

Alguma coisa muda e outros sistemas podem reagir.

**Em português claro:**

> “Quando acontecer X, quem quiser pode fazer Y.”

## Containers

Naturalmente, a AWS também precisava de várias respostas diferentes para:

> “Onde eu rodo meu container?”

### ECS

**Deveria se chamar:** Amazon Run My Containers

Você tem containers. A AWS coordena onde e como eles vão rodar.

**Em português claro:**

> “Tenho Docker. Quero executar isso na AWS sem necessariamente adotar Kubernetes.”

ECS.

### EKS

**Deveria se chamar:** Amazon Kubernetes

É Kubernetes administrado pela AWS.

**Em português claro:**

> “Quero Kubernetes.”

EKS.

Naturalmente, isso não significa:

> “Quero simplicidade.”

São frases diferentes.

### Fargate

**Deveria se chamar:** Amazon Containers Without Thinking About Servers

Você quer executar containers, mas não quer ficar escolhendo e administrando os servidores que estarão por trás deles.

**Em português claro:**

> “Só roda meu container.”

Fargate.

## Deploy e infraestrutura

Em algum momento, alguém percebeu que clicar cinquenta vezes no console não é exatamente uma estratégia operacional.

### CloudFormation

**Deveria se chamar:** Amazon Infrastructure Definition File

Você descreve sua infraestrutura. A AWS tenta construir aquilo para você.

Servidor. Rede. Banco. Load balancer. Permissões. Outros serviços.

**Em português claro:**

> “Em vez de clicar tudo novamente, quero declarar como minha infraestrutura deve ser.”

CloudFormation.

Ou, para quem já foi longe demais:

> “O YAML agora administra meu datacenter.”

### CodePipeline

**Deveria se chamar:** Amazon CI/CD Pipeline

Organiza etapas de build, teste e deploy.

**Em português claro:**

> “Quando alguém fizer commit, quero que uma sequência de coisas aconteça.”

### CodeDeploy

**Deveria se chamar:** Amazon Put This Version Into Production

Ajuda a distribuir novas versões de aplicações para ambientes de execução.

**Em português claro:**

> “A versão nova está pronta. Coloque-a nos servidores sem transformar isso num ritual.”

### Elastic Beanstalk

**Deveria se chamar:** Amazon Please Deploy My App

Você entrega sua aplicação. O serviço configura boa parte da infraestrutura necessária para executá-la.

**Em português claro:**

> “Eu tenho uma aplicação. Não quero começar desenhando subnets.”

Beanstalk tenta ajudar.

## Dados

Quando você acumula dados suficientes, a AWS naturalmente oferece outra coleção inteira de serviços.

### Kinesis

**Deveria se chamar:** Amazon Firehose of Events

Serve para receber grandes fluxos de dados continuamente.

Telemetria. Eventos. Logs. Clicks. Sensores. Transações.

**Em português claro:**

> “Tem uma quantidade enorme de dados chegando sem parar.”

Kinesis.

### Redshift

**Deveria se chamar:** Amazon Data Warehouse

Serve para armazenar e consultar grandes volumes de dados analíticos.

**Em português claro:**

> “Temos muitos dados e agora alguém quer um dashboard.”

Redshift.

### Glue

**Deveria se chamar:** Amazon Data Plumbing

Ajuda a descobrir, preparar, catalogar e transformar dados.

**Em português claro:**

> “Os dados estão espalhados por todo lado e precisamos transformar isso em alguma coisa utilizável.”

Glue.

O nome, curiosamente, é um dos poucos que até faz sentido.

É cola.

### Athena

**Deveria se chamar:** Amazon SQL Over Files

Você tem arquivos no S3 e quer executar SQL sobre eles.

Athena.

**Em português claro:**

> “Será que eu consigo consultar esse monte de CSV e Parquet sem subir um banco?”

Sim.

## Backup e arquivos que você talvez nunca mais queira ver

### Glacier

**Deveria se chamar:** Amazon Put This Somewhere Cheap

Serve para arquivamento de longo prazo.

**Em português claro:**

> “Preciso guardar isso durante anos, mas provavelmente ninguém vai abrir amanhã.”

Perfeito para o arquivo:

`backup_final_final_agora-vai_2019.zip`

## Redes corporativas

Para empresas que ainda possuem datacenters, isto é, praticamente qualquer empresa suficientemente grande, existem serviços específicos.

### Direct Connect

**Deveria se chamar:** Amazon Private Cable To AWS

Cria conectividade dedicada entre sua infraestrutura e a AWS.

**Em português claro:**

> “Não quero depender somente da internet pública para ligar meu datacenter à AWS.”

### Storage Gateway

**Deveria se chamar:** Amazon Cloud Storage Pretending To Be Local Storage

Faz a ponte entre ambientes locais e armazenamento AWS.

**Em português claro:**

> “Tenho sistemas antigos esperando encontrar armazenamento aqui, mas quero colocar os dados lá.”

### WorkSpaces

**Deveria se chamar:** Amazon Remote Desktop

Desktop virtual hospedado na AWS.

**Em português claro:**

> “Preciso entregar um computador corporativo para alguém sem entregar fisicamente um computador.”

## Segurança

Naturalmente, depois que você construiu tudo isso, surge outra pequena pergunta:

> Está seguro?

A AWS também vende algumas respostas.

### WAF

**Deveria se chamar:** Amazon Web Request Bouncer

Analisa requisições HTTP e pode bloquear padrões indesejados.

Bots. Ataques. Tentativas repetidas. Requests suspeitas.

**Em português claro:**

> “Antes dessa requisição chegar na minha aplicação, veja se parece uma péssima ideia.”

WAF.

### Inspector

**Deveria se chamar:** Amazon Security Inspector

Aqui os responsáveis pelos nomes quase acertaram.

Procura vulnerabilidades e problemas de segurança em workloads.

**Em português claro:**

> “Dê uma olhada nisso e diga onde estou potencialmente encrencado.”

### Secrets Manager

**Deveria se chamar:** Amazon Please Don't Put Passwords In Git

Guarda senhas, tokens e outras credenciais.

**Em português claro:**

> “Onde colocamos aquela senha que definitivamente não deveria estar no `.env.production` enviado por Slack?”

Aqui.

## E finalmente: os serviços necessários para administrar os serviços

Essa talvez seja minha categoria favorita.

A AWS ficou poderosa o suficiente para ser complexa.

Depois criou serviços para ajudar você a administrar a complexidade dos serviços que ela própria criou.

É quase uma categoria filosófica.

### CloudWatch

**Deveria se chamar:** Amazon Metrics, Logs and Alarms

Você observa aplicações e infraestrutura.

Métricas. Logs. Alarmes. Dashboards.

**Em português claro:**

> “Quero descobrir que alguma coisa quebrou antes do cliente me ligar.”

CloudWatch.

### CloudTrail

**Deveria se chamar:** Amazon Who Did That?

Registra atividades realizadas na sua conta AWS.

Quem chamou determinada API? Quem mudou uma configuração? Quando?

**Em português claro:**

> “Quem mexeu nisso?”

CloudTrail.

Talvez um dos serviços mais úteis depois de alguém dizer:

> “Eu não alterei nada.”

### AWS Config

**Deveria se chamar:** Amazon What Changed?

Mantém histórico e avalia configurações dos seus recursos.

**Em português claro:**

> “Ontem funcionava. O que mudou?”

### Trusted Advisor

**Deveria se chamar:** Amazon You Are Wasting Money Here

Analisa seu ambiente e oferece recomendações relacionadas a custo, desempenho, segurança e outros aspectos.

**Em português claro:**

> “Tem alguma coisa ligada que ninguém usa?”

Frequentemente, sim.

## O verdadeiro problema não são os nomes

A piada funciona porque os nomes da AWS são peculiares.

EC2. S3. SQS. SNS. ECS. EKS. SES. RDS. IAM. VPC.

Você pode participar de uma reunião perfeitamente séria dizendo:

> “Coloca o ALB na frente do ECS dentro da VPC, usa IAM para acessar S3, manda eventos pelo SNS para SQS e observa tudo no CloudWatch.”

E ninguém chama a polícia.

Depois de alguns anos, isso parece completamente normal.

Mas existe um problema mais interessante por trás da piada.

**Cloud computing criou uma abstração para praticamente cada problema operacional que encontramos.**

Servidor virou serviço.

Disco virou serviço.

Fila virou serviço.

DNS virou serviço.

Banco virou serviço.

Cache virou serviço.

Load balancer virou serviço.

Logs viraram serviço.

Segredos viraram serviço.

Eventos viraram serviço.

Permissões viraram serviço.

Até administrar os serviços virou serviço.

Isso é extraordinariamente poderoso.

E também explica por que arquiteturas cloud conseguem ficar extraordinariamente complicadas.

## Minha regra continua sendo a mesma

Quando estou avaliando uma arquitetura AWS, tento ignorar os nomes dos produtos por alguns minutos.

Em vez de perguntar:

> “Vamos usar EventBridge, SNS ou SQS?”

Primeiro pergunto:

> “Qual problema estamos tentando resolver?”

Precisamos de uma fila?

Precisamos publicar um evento?

Precisamos que vários consumidores sejam avisados?

Precisamos desacoplar dois sistemas?

Precisamos executar alguma coisa depois?

Só então volto aos nomes dos serviços.

Porque arquitetura deveria começar pelo problema.

Não pelo catálogo do fornecedor.

Talvez essa seja a versão mais útil de **Amazon Web Services in Plain English**:

**EC2 é um servidor.**

**S3 guarda arquivos.**

**RDS é banco de dados.**

**SQS é uma fila.**

**SNS distribui mensagens.**

**Lambda executa funções.**

**CloudFront é CDN.**

**Route 53 é DNS.**

**IAM controla quem pode fazer o quê.**

**CloudWatch ajuda a descobrir o que está acontecendo.**

E AWS?

Bem.

AWS deveria talvez ter sido chamada simplesmente de:

**Amazon Datacenter as an API.**

Mas provavelmente alguém do marketing teria achado simples demais.
