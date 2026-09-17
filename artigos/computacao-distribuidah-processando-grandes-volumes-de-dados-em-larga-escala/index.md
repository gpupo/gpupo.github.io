# Computação distribuída com Spark: do modo local ao cluster

Published: 2023-02-27
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/computacao-distribuidah-processando-grandes-volumes-de-dados-em-larga-escala/
Tags: Dados, Arquitetura, Apache Spark

---

Dividir um processamento entre várias máquinas pode aumentar capacidade, mas também introduz coordenação, transferência de dados e novos modos de falha. Para conjuntos pequenos, um programa local costuma terminar antes que um cluster consiga distribuir o trabalho.

Computação distribuída faz sentido quando a carga ultrapassa de maneira recorrente os recursos de uma máquina, quando o tempo disponível exige paralelismo ou quando os dados já estão armazenados de forma distribuída. Não é sinônimo automático de velocidade, disponibilidade ou processamento em tempo real.

O Apache Spark ajuda a tornar essas diferenças visíveis porque o mesmo programa pode rodar em uma máquina ou usar executores distribuídos em um cluster.

## O que muda quando o trabalho é distribuído

Uma aplicação Spark possui um processo coordenador, o **driver**, e processos que executam tarefas, os **executors**. Em um cluster, um gerenciador como Kubernetes, YARN ou o modo standalone do Spark aloca esses processos. A [documentação de arquitetura][1] descreve como o driver envia código e tarefas aos executores.

```text
                 agenda tarefas
driver ─────────────────────────────────┐
  │                                     │
  │ solicita recursos                   ▼
  ▼                              executors do cluster
cluster manager                 ┌────────┬────────┬────────┐
                                │ part. A│ part. B│ part. C│
                                └────────┴────────┴────────┘
```

O conjunto de dados é dividido em partições. Operações podem ser executadas em paralelo enquanto os dados necessários estiverem disponíveis para cada tarefa.

Esse desenho acrescenta custos:

* iniciar e coordenar processos;
* serializar dados e funções;
* mover dados entre executores;
* gravar checkpoints e resultados;
* repetir tarefas depois de falhas;
* observar capacidade, filas e uso de memória.

Uma arquitetura distribuída precisa justificar esses custos com volume, tempo de processamento, continuidade ou isolamento operacional.

## Um contador de palavras corrigido

Este exemplo usa a API de DataFrames do PySpark:

```python
from pyspark.sql import SparkSession
from pyspark.sql import functions as F


spark = SparkSession.builder.appName("contagem-palavras").getOrCreate()

linhas = spark.read.text("dados/*.txt")

palavras = (
    linhas
    .select(F.explode(F.split(F.col("value"), r"\s+")).alias("palavra"))
    .where(F.col("palavra") != "")
)

contagem = palavras.groupBy("palavra").count().orderBy(F.desc("count"))
contagem.show(20, truncate=False)

spark.stop()
```

A primeira versão deste artigo importava `SparkContex`, nome que não existe, e depois usava `SparkContext`. O exemplo também fixava o master como `local`, apesar de apresentá-lo como demonstração de um cluster.

O código novo deixa a escolha do ambiente para o `spark-submit`.

## Primeiro em modo local

Para validar o programa usando os núcleos da própria máquina:

```bash
spark-submit --master 'local[*]' word_count.py
```

`local[*]` permite paralelismo local, mas continua usando uma única máquina. É útil para desenvolvimento e para cargas que cabem naquele host. Não valida rede, armazenamento compartilhado, permissões do cluster, perda de executores ou dimensionamento.

Esse limite precisa ficar explícito: executar uma biblioteca distribuída em modo local não transforma o teste em experimento de computação distribuída.

## Depois em um cluster

No cluster, o mesmo programa precisa ser submetido ao gerenciador escolhido. Além do endereço do master, entram decisões que o exemplo local não cobre:

* onde o arquivo `dados/*.txt` está armazenado;
* como todos os executores acessam a entrada;
* quantas partições serão criadas;
* quanto de CPU e memória cada executor recebe;
* onde logs e resultados serão persistidos;
* como credenciais são distribuídas;
* o que acontece quando driver ou executor falha.

O [guia de cluster do Spark][1] mostra os gerenciadores suportados e o ciclo de alocação dos executores. O comando exato depende do ambiente. Copiar um `--master` sem explicar armazenamento, rede e credenciais produz uma configuração que parece distribuída, mas pode não ser operável.

## Tolerância a falhas tem condições

Spark consegue recomputar partições perdidas de um RDD a partir das transformações que as originaram, como documenta o [guia de RDDs][2]. Isso não significa que qualquer falha será transparente.

Há situações diferentes:

* uma tarefa pode ser repetida depois da perda de um executor;
* o driver pode encerrar e levar a aplicação junto;
* a fonte pode não permitir releitura;
* uma escrita externa pode produzir efeitos duplicados;
* dados mantidos apenas fora do fluxo reproduzível podem ser perdidos;
* um cluster sem capacidade disponível pode continuar indisponível mesmo com repetição automática.

Garantias dependem da fonte, da operação, do destino e da configuração de recuperação. “Distribuído” descreve onde o trabalho acontece; “tolerante a falhas” descreve como o sistema reage a falhas específicas.

## Streaming não significa tempo real

Structured Streaming permite tratar entradas contínuas com as APIs de DataFrame. Por padrão, o Spark processa esses dados em **micro-batches**. A frequência depende do trigger, do volume, da capacidade do cluster e do tempo de cada lote.

A [documentação de Structured Streaming][3] também distingue fontes que permitem recuperação por offsets daquelas destinadas apenas a testes. O socket source, por exemplo, não oferece garantia de tolerância a falhas de ponta a ponta.

Antes de chamar um pipeline de “tempo real”, eu definiria uma meta observável:

```text
evento disponível na fonte
        → evento processado
        → resultado confirmado no destino
```

Uma necessidade de segundos, minutos ou horas leva a escolhas diferentes. Distribuir o processamento aumenta capacidade potencial, mas não define sozinho a latência.

## Quando eu começaria sem cluster

Eu manteria o processamento local enquanto:

* os dados couberem com margem em uma máquina;
* o tempo de execução atender à janela disponível;
* uma falha puder ser resolvida repetindo o trabalho;
* o custo de operação do cluster superar o custo da carga.

Migraria quando medições mostrarem um limite recorrente e houver uma fronteira clara para particionar os dados. Antes disso, otimizar leitura, formato, filtros e consultas pode resolver o problema com menos componentes.

O próximo passo prático é executar o mesmo job com um conjunto representativo, registrar duração, volume lido, dados movimentados e memória usada. Esses números permitem decidir se a distribuição resolve um limite real ou apenas acrescenta infraestrutura.

[1]: https://spark.apache.org/docs/latest/cluster-overview.html "Cluster Mode Overview — Apache Spark"
[2]: https://spark.apache.org/docs/latest/rdd-programming-guide.html "RDD Programming Guide — Apache Spark"
[3]: https://spark.apache.org/docs/latest/streaming/apis-on-dataframes-and-datasets.html "Structured Streaming Programming Guide — Apache Spark"
