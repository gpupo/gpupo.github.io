# Postgres-only, até deixar de ser

Published: 2026-10-26
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/postgresql-primeiro-outro-servico-quando-houver-um-motivo/
Tags: PostgreSQL, Arquitetura, Banco de dados, Homelab, Engenharia de software

---

No meu homelab, cada serviço novo traz uma conta: configuração, credenciais, atualizações, armazenamento, backup, monitoramento e alguma coisa para investigar quando deixa de funcionar.

E o departamento de operações tem exatamente uma pessoa.

Por isso, antes de instalar Elasticsearch, Pinecone, Redis, MongoDB, Kafka ou outro serviço especializado, pergunto se o PostgreSQL que já opero resolve o problema.

É tentador chamar essa regra de `Postgres-only`. O nome é bom, mas promete demais.

PostgreSQL oferece busca textual, documentos JSON, vetores, particionamento e comunicação entre processos. Isso não o torna substituto direto de todo produto com uma capacidade parecida. Conseguir fazer algo e conseguir fazê-lo bem, nas condições da aplicação, são perguntas diferentes.

Minha regra é menos ambiciosa: **PostgreSQL é o primeiro lugar onde procuro uma solução. Não necessariamente o último.**

Três decisões do homelab mostram onde isso funcionou e onde precisei acrescentar componentes.

<figure class="editorial-photo">
  <img src="/assets/images/postgres-only-arquitetura-modular-editorial.webp" alt="Ilustração de uma estrutura modular sobre uma planta de projeto, com módulos ligados por setas azuis e um cilindro central iluminado" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Uma estrutura central e outros componentes: cada peça acrescentada precisa ter uma função.</figcaption>
</figure>

## Uma tabela resolveu o problema do RSS

Em junho de 2026, eu estava trabalhando numa automação que lê notícias do Miniflux e produz resumos com IA.

Precisava guardar duas informações associadas a cada notícia: o resumo no idioma original e sua tradução.

Não havia nada especialmente complicado nisso. Mas mesmo um requisito pequeno oferece oportunidades para aumentar a arquitetura.

Eu poderia criar outro banco para os resumos. Poderia colocar os textos diretamente no HTML original da notícia. Poderia inventar algum armazenamento específico para os resultados da automação.

Só que a notícia já estava no PostgreSQL do Miniflux.

Por que não começar por aí?

Criei uma tabela associativa no mesmo banco, sem modificar as tabelas mantidas pela aplicação:

```sql
CREATE TABLE entries_summaries (
    entry_id bigint PRIMARY KEY
        REFERENCES entries(id) ON DELETE CASCADE,
    summary_original text,
    summary_translation text,
    created_at timestamptz DEFAULT now()
);
```

A solução tem uma característica de que gosto bastante: ela quase não precisa de explicação.

Cada resumo pertence a uma notícia. Quando o Miniflux exclui a notícia, o PostgreSQL exclui também o resumo correspondente. A automação grava os textos e a aplicação que monta o boletim recupera tudo com uma junção SQL.

Não precisei criar uma rotina para reconciliar identificadores entre sistemas. Nem pensar em como recuperar separadamente um segundo banco.

O relacionamento que eu precisava já tinha nome: chave estrangeira.

Isso não transforma a decisão em uma recomendação universal. Acrescentei uma tabela ao banco de uma aplicação de terceiros. Embora não tenha alterado as tabelas do Miniflux, preciso verificar se essa integração continua funcionando depois das atualizações. Não existe uma promessa de compatibilidade do produto para minha extensão.

É uma responsabilidade que aceitei.

A alternativa também teria responsabilidades, possivelmente maiores. Naquele momento, achei mais razoável assumir uma dependência conhecida do que colocar outro serviço na operação.

## O banco de vídeos não precisava guardar os vídeos

Outra experiência veio do Video Data Product, meu projeto para organizar e processar informações sobre vídeos.

Nesse caso, seria fácil cair no extremo oposto: já que PostgreSQL aceita JSON e textos extensos, por que não guardar absolutamente tudo nele?

Preferi separar as coisas.

O PostgreSQL ficou responsável pelo catálogo, pelas coleções, pelas avaliações, pelo estado dos processamentos e pelas informações necessárias para localizar os vídeos.

A tabela principal mistura colunas relacionais com dois campos `jsonb`, usados para metadados e estados que variam conforme o processamento.

Também precisava pesquisar vídeos por título, canal e identificador.

Antes de pensar em um mecanismo de busca separado, experimentei os recursos de busca textual do próprio PostgreSQL:

```sql
search_vector tsvector GENERATED ALWAYS AS (
    setweight(to_tsvector('simple', coalesce(video_id, '')), 'A')
    || setweight(to_tsvector('simple', coalesce(title, '')), 'A')
    || setweight(to_tsvector('simple', coalesce(channel, '')), 'B')
) STORED
```

Com um índice GIN sobre essa coluna, passei a ter uma estrutura de busca dentro do banco que já armazenava o catálogo.

O [`jsonb`](https://www.postgresql.org/docs/current/datatype-json.html) e a [busca textual](https://www.postgresql.org/docs/current/textsearch-controls.html) são capacidades bastante maduras do PostgreSQL. Para o tipo de informação e as consultas que eu precisava naquele projeto, foram suficientes.

Mas havia outro tipo de dado no sistema.

Descrições, transcrições e artefatos semânticos podem crescer bastante. São conteúdos que frequentemente preciso recuperar como objetos completos, não consultar como registros relacionais.

Esses foram para um armazenamento compatível com S3. O cache local ficou descartável.

A divisão acabou sendo simples de entender: PostgreSQL conhece os vídeos, seus relacionamentos e o estado do processamento. O armazenamento de objetos guarda os artefatos duráveis.

Não é uma arquitetura sem custos. Preciso coordenar os backups dos dois lados, e uma leitura fria pode depender do download de um objeto.

Mas a separação tem uma razão.

Minha preferência é **não multiplicar componentes sem necessidade e dar a cada componente uma responsabilidade que eu consiga explicar**.

Parece uma diferença pequena. Para quem depois precisa operar o sistema, não é.

## PostgreSQL faz muita coisa. E daí?

Existe uma espécie de diversão técnica em descobrir que um software conhecido consegue fazer algo que normalmente associamos a outro produto.

PostgreSQL é especialmente generoso nesse assunto.

Precisa armazenar documentos semiestruturados? Tem `jsonb`.

Busca textual? `tsvector`, `tsquery` e índices GIN.

Similaridade vetorial? Existe o [pgvector](https://github.com/pgvector/pgvector).

Tabelas muito grandes? [Particionamento declarativo](https://www.postgresql.org/docs/current/ddl-partitioning.html).

Tudo isso merece entrar na avaliação de uma arquitetura. O erro começa quando a existência de uma funcionalidade vira argumento suficiente para dispensar uma ferramenta especializada.

O pgvector, por exemplo, faz busca exata por padrão e oferece índices aproximados HNSW e IVFFlat. Existe uma negociação entre velocidade, memória, tempo de construção do índice e qualidade dos resultados. HNSW geralmente exige mais memória e mais tempo de construção que IVFFlat.

Não basta dizer que PostgreSQL tem busca vetorial. É preciso verificar volume, filtros, latência e recall exigidos pela aplicação.

O mesmo acontece com particionamento. Ele pode fazer uma diferença importante em tabelas muito grandes, mas criar partições antecipadamente, sem um padrão de acesso que justifique a decisão, também é uma maneira bastante eficiente de produzir trabalho para o futuro.

Há comparações ainda mais perigosas.

Uma tabela `UNLOGGED` reduz parte do custo de escrita, mas [não oferece as mesmas garantias de recuperação e replicação](https://www.postgresql.org/about/featurematrix/detail/unlogged-tables/) de uma tabela convencional. Isso não a transforma em substituta de Redis ou Valkey.

`LISTEN` e `NOTIFY` permitem [comunicação entre processos](https://www.postgresql.org/docs/current/sql-notify.html), mas não entregam, sozinhos, o contrato de um broker durável com retenção, replay e consumidores independentes.

Se eu precisar dessas propriedades, terei que implementá-las, por exemplo, com uma tabela de eventos e mecanismos de consumo apropriados, ou adotar uma tecnologia que já as ofereça.

E aí aparece uma pergunta que considero mais interessante do que saber quantas funcionalidades cabem no PostgreSQL:

**Quanto custa reproduzir o comportamento de outro produto usando o banco que eu já tenho?**

Porque uma coisa é evitar a operação de outro serviço. Outra, bem diferente, é transferir toda a complexidade desse serviço para o código da aplicação.

A segunda opção nem sempre é mais simples. Às vezes, apenas esconde melhor a complexidade.

## A vez em que precisei instalar mais coisas

Até aqui, os exemplos favorecem o PostgreSQL. Mas houve uma situação recente em que minha preferência pessoal não fez muita diferença.

Eu precisava atualizar o Langfuse.

Na versão 2, os traces eram armazenados no PostgreSQL. A partir da versão 3, a arquitetura self-hosted passou a utilizar ClickHouse para os eventos analíticos, Redis para filas e cache e armazenamento compatível com S3 para objetos, além do PostgreSQL.

Não era uma sugestão de otimização que eu poderia deixar para depois. Era a arquitetura suportada da nova versão.

Meu ambiente, que antes precisava de menos componentes, passou a ter um job com aplicação web, worker, ClickHouse e Redis. PostgreSQL e Garage continuaram fora dele.

Vieram junto novos volumes, credenciais, verificações de saúde, políticas de persistência e uma migração que precisava respeitar uma sequência.

Exatamente o tipo de aumento de trabalho operacional que eu tentava evitar.

Mas havia uma diferença importante.

Segundo o [guia de migração do Langfuse](https://langfuse.com/self-hosting/upgrade/upgrade-guides/upgrade-v2-to-v3), a arquitetura anterior apresentava gargalos de ingestão e consulta quando as tabelas chegavam a milhões de traces. A mudança para ClickHouse respondia a limitações reais observadas pelos mantenedores.

A equipe chegou a considerar um adaptador que permitiria continuar usando PostgreSQL em instalações menores. Descartou a ideia pelo custo de manter duas arquiteturas.

Eu não tinha milhões de traces no homelab. Também não fiz um benchmark entre PostgreSQL e ClickHouse para descobrir se a mudança traria benefícios mensuráveis no meu hardware.

Minha situação era bem mais prosaica: queria continuar usando uma versão atualizada do Langfuse, dentro da arquitetura que o projeto suporta.

Para isso, precisava aceitar seus novos componentes.

Eu poderia permanecer na versão antiga, assumindo as consequências dessa escolha. O que não podia era fingir que minha preferência por PostgreSQL mudava os requisitos da versão nova.

O ClickHouse não entrou porque eu estava procurando algo novo para experimentar. Entrou porque havia uma razão identificável para sua presença.

O Redis e o armazenamento de objetos vieram pela mesma razão: faziam parte do contrato operacional daquela arquitetura.

Não fiquei particularmente feliz com o aumento de serviços. Mas também não faria sentido transformar uma preferência por simplicidade em resistência a qualquer mudança.

## Menos serviços não significa menos problemas

Uma consequência dessa história é que comecei a desconfiar de outra conclusão fácil: a de que concentrar tudo em PostgreSQL necessariamente produz uma arquitetura mais simples.

Do ponto de vista operacional, muitas vezes produz mesmo.

Eu conheço o banco, já mantenho backups, acompanho seu funcionamento e sei onde procurar quando alguma coisa dá errado. Adicionar mais uma base de dados costuma ser mais barato do que aprender, provisionar e manter outro produto inteiro.

Mas concentração também tem preço.

Se várias aplicações dependem da mesma instância, uma falha, saturação ou manutenção nessa instância pode afetar todas elas. Separar bancos e usuários ajuda na organização e no isolamento de permissões, mas não elimina esse domínio de falha compartilhado.

Também existe um limite para quanto trabalho diferente faz sentido colocar no mesmo servidor.

No meu ambiente, com cargas relativamente pequenas e uma única pessoa responsável pela operação, o equilíbrio costuma favorecer menos componentes.

Em outro contexto, talvez não.

São decisões tomadas com cargas pequenas e recursos limitados; não demonstram superioridade universal do PostgreSQL. Para escolher o próximo componente do homelab, os requisitos concretos valem mais do que uma lista de funcionalidades.

## PostgreSQL primeiro, quando couber

Quando aparece uma necessidade nova, começo perguntando se o PostgreSQL que já opero consegue representar os dados, executar as consultas e oferecer as garantias necessárias.

Se parece que sim, prefiro começar por ali.

Depois observo volume, concorrência, latência, crescimento e recuperação. Se algum requisito ultrapassa o que consigo atender de maneira razoável, volto a avaliar as alternativas.

Não há nenhum mérito especial em usar PostgreSQL para tudo. Também não há mérito em ter cinco serviços quando dois resolveriam o problema.

A questão nunca foi colecionar menos logotipos no diagrama de arquitetura.

É conseguir explicar por que cada componente está ali e aceitar o trabalho que ele traz consigo.

`Postgres-only` é um nome mais divertido. `Postgres-first` descreve melhor o que faço: começo pelo que já conheço, procuro entender o problema e só acrescento outra tecnologia quando encontro uma razão concreta para isso.

**Uma tecnologia nova precisa resolver um problema que eu tenha. Não apenas um problema que ela sabe nomear.**
