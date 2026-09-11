# Empacotamento 3D com BRKGA: o algoritmo depende do decodificador

Published: 2023-03-18
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/packingh-biased-random-key-genetic-algorithm-e-o-problema-de-empacotamento-3d/
Tags: Algoritmos, Otimização, Logística

---

Escolher uma caixa para um conjunto de produtos parece um problema de volume: some o volume dos itens e procure um recipiente maior. Essa conta é necessária, mas não suficiente.

Uma caixa pode ter volume disponível e ainda assim não acomodar um item por causa de uma de suas dimensões. Também é preciso impedir sobreposições, decidir quais rotações são permitidas e, em aplicações reais, considerar peso, estabilidade, fragilidade e distribuição de carga.

O **problema de empacotamento tridimensional**, ou 3D bin packing, reúne essas decisões. Um Biased Random-Key Genetic Algorithm, o BRKGA, pode procurar boas soluções para determinadas formulações desse problema. Ele não transforma, porém, uma lista de dimensões em uma resposta correta por conta própria.

O componente mais importante dessa aplicação é o **decodificador**: a regra que converte números aleatórios em uma disposição geométrica válida.

## Primeiro, defina qual problema precisa ser resolvido

“Empacotamento 3D” descreve uma família de problemas. Antes de escolher o algoritmo, é necessário definir pelo menos:

- se as caixas disponíveis têm dimensões iguais ou diferentes;
- se o objetivo é reduzir o número de caixas, o custo do frete ou o espaço vazio;
- se os itens podem ser rotacionados em todos os eixos;
- se existe limite de peso por caixa;
- se um item pode sustentar outro;
- se há restrições de orientação, fragilidade ou separação;
- se todos os itens precisam ser carregados;
- se a solução precisa ser ótima ou apenas suficientemente boa dentro de um limite de tempo.

Essas variações não são detalhes de implementação. Elas alteram a representação da solução, as restrições e a função objetivo.

O exemplo de [bin packing do Google OR-Tools](https://developers.google.com/optimization/pack/bin_packing) trata uma formulação unidimensional: itens possuem pesos e recipientes possuem capacidade. No caso tridimensional, a soma dos volumes não substitui as restrições geométricas de posição e não sobreposição.

## O que o BRKGA faz

Um BRKGA representa cada indivíduo da população como um vetor de números reais, normalmente no intervalo entre 0 e 1. Essas são as *random keys*.

O algoritmo mantém uma parcela das melhores soluções, introduz indivíduos aleatórios e produz descendentes combinando um indivíduo do grupo de elite com outro indivíduo. Durante o cruzamento, cada chave tem probabilidade maior de vir do pai de elite; daí o termo *biased*.

As chaves, isoladamente, não dizem onde uma caixa deve ser colocada. O decodificador precisa transformá-las em uma solução do problema. Em uma aplicação de empacotamento, ele pode usar parte das chaves para ordenar os itens e outra parte para escolher orientação ou estratégia de posicionamento.

O processo pode ser resumido assim:

```text
gerar população de vetores aleatórios

enquanto o critério de parada não for atingido:
    decodificar cada vetor como uma solução de empacotamento
    verificar as restrições
    calcular o custo de cada solução
    preservar a elite
    gerar mutantes aleatórios
    cruzar indivíduos de elite e não elite com viés para a elite
    formar a próxima população

retornar a melhor solução válida encontrada
```

No trabalho de José Fernando Gonçalves e Mauricio Resende sobre [BRKGA para bin packing 2D e 3D](https://doi.org/10.1016/j.ijpe.2013.04.019), o método combina o algoritmo genético com uma representação de espaços máximos livres e heurísticas específicas de posicionamento. O BRKGA evolui a ordem dos itens e parâmetros usados por essas heurísticas. Portanto, reproduzir apenas seleção, cruzamento e mutação não reproduz o método apresentado no artigo.

## O decodificador precisa construir soluções válidas

Considere um cromossomo com duas chaves por item:

```text
[ordem_1, ordem_2, ..., ordem_n, orientação_1, ..., orientação_n]
```

Uma possibilidade de decodificação seria:

1. ordenar os itens pelas primeiras `n` chaves;
2. converter as outras `n` chaves em orientações permitidas;
3. para cada item, procurar posições candidatas nos espaços ainda livres;
4. rejeitar posições que ultrapassem a caixa ou causem sobreposição;
5. abrir uma nova caixa quando nenhuma posição válida for encontrada;
6. calcular o custo da solução resultante.

Essa é apenas uma estrutura possível. O resultado depende da heurística de posicionamento, da forma como os espaços livres são atualizados e dos critérios usados para desempate.

Uma função de aptidão pode priorizar, nesta ordem:

1. violações de restrições;
2. número ou custo das caixas utilizadas;
3. volume vazio;
4. estabilidade ou distribuição de peso.

Misturar todos esses objetivos em uma soma sem justificar os pesos pode esconder soluções ruins. Uma alternativa é comparar os critérios de forma lexicográfica: uma solução inválida nunca supera uma válida; entre as válidas, compara-se primeiro o objetivo principal e depois os critérios de desempate.

## Volume é um limite, não uma prova de encaixe

Para os itens do exemplo original:

```python
products = [
    {"name": "Alpha", "quantity": 10, "dimensions": (10, 10, 10)},
    {"name": "Bravo", "quantity": 1, "dimensions": (150, 200, 140)},
    {"name": "Charlie", "quantity": 3, "dimensions": (15, 20, 14)},
]
```

o volume total é `4.222.600` unidades cúbicas. Esse valor fornece um limite inferior para a capacidade necessária, mas não demonstra que determinada caixa comporta os itens.

Antes mesmo de executar uma heurística, é possível rejeitar recipientes nos quais algum item não caiba em nenhuma rotação permitida:

```python
from itertools import permutations
from math import prod


def orientations(dimensions):
    return set(permutations(dimensions))


def item_fits(item_dimensions, bin_dimensions):
    return any(
        all(item_axis <= bin_axis for item_axis, bin_axis in zip(option, bin_dimensions))
        for option in orientations(item_dimensions)
    )


def precheck(products, bin_dimensions):
    total_volume = sum(
        product["quantity"] * prod(product["dimensions"])
        for product in products
    )
    bin_volume = prod(bin_dimensions)

    dimensions_fit = all(
        item_fits(product["dimensions"], bin_dimensions)
        for product in products
    )

    return {
        "volume_is_sufficient": total_volume <= bin_volume,
        "each_item_fits": dimensions_fit,
    }
```

Esse código executa somente duas verificações necessárias. Ele não posiciona os itens e, portanto, não prova que o conjunto inteiro cabe na caixa. A distinção é importante: somar largura, profundidade e altura de todos os itens também não calcula uma “caixa ideal”; apenas descreve uma disposição possível em colunas independentes, que talvez nem corresponda a um empacotamento válido.

## Como avaliar a resposta da heurística

Uma solução retornada pelo BRKGA deve incluir mais do que o nome da caixa. Para ser verificável, ela precisa informar, para cada item:

- a caixa escolhida;
- a posição `(x, y, z)`;
- a orientação;
- as dimensões após a rotação.

Com esses dados, um validador independente pode conferir limites, sobreposições, peso e demais restrições. Essa validação não deve depender da mesma função que construiu a solução, porque um erro compartilhado entre construção e verificação pode aceitar um arranjo inválido.

Também é necessário registrar:

- valor da função objetivo;
- tempo de execução;
- semente aleatória;
- parâmetros do algoritmo;
- melhor limite inferior ou solução de referência disponível;
- número de execuções realizadas.

Como o BRKGA é estocástico, uma única execução não caracteriza seu desempenho. Comparações devem usar várias sementes e a mesma condição de parada. Se não houver prova de otimalidade, o resultado deve ser descrito como **a melhor solução encontrada**, não como a menor caixa possível.

## Quando usar BRKGA

BRKGA faz sentido quando o problema possui uma forma eficiente de decodificar chaves em soluções válidas, quando métodos exatos não atendem ao tempo disponível ou quando as restrições específicas tornam heurísticas mais práticas.

Para instâncias pequenas ou decisões de alto custo, vale comparar a heurística com um modelo exato ou com limites inferiores. Para produção, também é necessário testar casos-limite: itens maiores do que todos os recipientes, dimensões iguais, rotações proibidas, peso excedido e ausência de solução.

O algoritmo genético é apenas o mecanismo de busca. A qualidade da resposta continua dependendo da formulação, do decodificador, da validação independente e da forma como o experimento é medido.
