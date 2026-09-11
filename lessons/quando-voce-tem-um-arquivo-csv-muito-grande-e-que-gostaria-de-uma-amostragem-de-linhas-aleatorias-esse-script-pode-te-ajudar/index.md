# Como obter uma amostra aleatória de um CSV grande sem carregá-lo na memória

Published: 2023-06-14
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/lessons/quando-voce-tem-um-arquivo-csv-muito-grande-e-que-gostaria-de-uma-amostragem-de-linhas-aleatorias-esse-script-pode-te-ajudar/
Tags: Gists, Dados, Python

---

Gist ID: `33b266be0830f76cd3200866788404df`

O script original começava dizendo que ajudaria com um CSV “muito grande” e, em
seguida, convertia o arquivo inteiro em uma lista. Ele escolhia linhas
aleatórias corretamente em muitos casos, mas a estratégia contradizia o
problema: o consumo de memória crescia com o arquivo completo.

Quando não conhecemos antecipadamente o número de registros, podemos selecionar
uma amostra uniforme sem reposição em uma única passagem. Para isso, usamos
**reservoir sampling**.

## O que o algoritmo mantém na memória

Para uma amostra de tamanho `k`, o algoritmo:

1. coloca os primeiros `k` registros em um reservatório;
2. para cada registro seguinte, sorteia uma posição entre o início e a posição
   atual;
3. substitui um item do reservatório quando a posição sorteada está dentro dos
   `k` lugares;
4. continua até o fim do arquivo.

O tempo cresce com o número total de registros porque todos precisam ser lidos.
A memória usada para os dados cresce com `k`, não com o total do CSV. Registros
individuais muito grandes ainda podem consumir memória relevante.

Jeffrey Vitter descreveu e analisou algoritmos de amostragem com reservatório
para populações cujo tamanho não é conhecido antecipadamente. O artigo inclui
algoritmos mais eficientes que a forma simples usada aqui; este exemplo prioriza
legibilidade e percorre cada registro. ([artigo original “Random Sampling with a
Reservoir”](https://doi.org/10.1145/3147.3165))

## Script completo

O programa abaixo:

- trata a primeira linha como cabeçalho por padrão;
- mantém no máximo `k` registros no reservatório;
- preserva a ordem original dos registros selecionados;
- permite informar delimitador e codificação;
- aceita uma semente para repetir o sorteio no mesmo ambiente;
- não sobrescreve um arquivo de saída existente.

```python
#!/usr/bin/env python3

from __future__ import annotations

import argparse
import csv
import random
from collections.abc import Iterable
from pathlib import Path

Row = list[str]


def non_negative_integer(value: str) -> int:
    number = int(value)
    if number < 0:
        raise argparse.ArgumentTypeError("o tamanho deve ser não negativo")
    return number


def reservoir_sample(
    rows: Iterable[Row],
    sample_size: int,
    rng: random.Random,
) -> tuple[list[Row], int]:
    reservoir: list[tuple[int, Row]] = []
    total = 0

    for index, row in enumerate(rows):
        total = index + 1

        if index < sample_size:
            reservoir.append((index, row))
            continue

        selected = rng.randrange(index + 1)
        if selected < sample_size:
            reservoir[selected] = (index, row)

    if total < sample_size:
        raise ValueError(
            f"amostra solicitada ({sample_size}) excede os registros ({total})"
        )

    reservoir.sort(key=lambda item: item[0])
    return [row for _, row in reservoir], total


def create_sample(
    input_path: Path,
    output_path: Path,
    sample_size: int,
    *,
    delimiter: str,
    encoding: str,
    seed: int | None,
    has_header: bool,
) -> int:
    if len(delimiter) != 1:
        raise ValueError("o delimitador deve ter exatamente um caractere")

    if input_path.resolve() == output_path.resolve():
        raise ValueError("origem e destino devem ser arquivos diferentes")

    rng = random.Random(seed)

    with input_path.open("r", encoding=encoding, newline="") as source:
        reader = csv.reader(source, delimiter=delimiter, strict=True)
        header = next(reader, None) if has_header else None

        if has_header and header is None:
            raise ValueError("o CSV está vazio e não contém cabeçalho")

        sample, total = reservoir_sample(reader, sample_size, rng)

    with output_path.open("x", encoding=encoding, newline="") as destination:
        writer = csv.writer(destination, delimiter=delimiter)
        if header is not None:
            writer.writerow(header)
        writer.writerows(sample)

    return total


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(
        description="Seleciona registros de um CSV com reservoir sampling."
    )
    parser.add_argument("input", type=Path, help="CSV de origem")
    parser.add_argument("output", type=Path, help="novo CSV de saída")
    parser.add_argument("sample_size", type=non_negative_integer)
    parser.add_argument("--delimiter", default=",")
    parser.add_argument("--encoding", default="utf-8")
    parser.add_argument("--seed", type=int)
    parser.add_argument(
        "--no-header",
        action="store_true",
        help="trata o primeiro registro como dado, não como cabeçalho",
    )
    return parser


def main() -> None:
    parser = build_parser()
    args = parser.parse_args()

    try:
        total = create_sample(
            args.input,
            args.output,
            args.sample_size,
            delimiter=args.delimiter,
            encoding=args.encoding,
            seed=args.seed,
            has_header=not args.no_header,
        )
    except (OSError, UnicodeError, csv.Error, ValueError) as error:
        parser.exit(1, f"erro: {error}\n")

    print(
        f"Amostra com {args.sample_size} de {total} registros "
        f"gravada em {args.output}"
    )


if __name__ == "__main__":
    main()
```

O código usa anotações disponíveis a partir do Python 3.10. Para versões
anteriores, o tipo `int | None` precisa ser adaptado.

## Como executar

Para selecionar 1.000 registros de um CSV com cabeçalho:

```bash
python3 sample_csv.py source.csv sample.csv 1000
```

Para um arquivo separado por ponto e vírgula e um sorteio reproduzível:

```bash
python3 sample_csv.py source.csv sample.csv 1000 \
  --delimiter ';' \
  --seed 2026
```

A semente é útil para depuração e comparação de experimentos. Como a
implementação do gerador e de suas operações pode variar entre versões,
registre também a versão do Python quando a reprodução exata for um requisito.
A documentação do módulo `random` descreve o gerador como pseudoaleatório e
alerta que ele não serve para finalidades criptográficas. ([documentação de
`random`](https://docs.python.org/3/library/random.html))

## Por que abrir com `newline=""`

Um registro CSV pode conter uma quebra de linha dentro de um campo entre aspas.
Contar linhas físicas com `wc -l` ou ler o arquivo como texto simples não produz
necessariamente o número de registros.

O módulo `csv` recomenda abrir arquivos com `newline=""` para que ele próprio
trate as quebras de linha. O exemplo também define codificação e delimitador de
forma explícita. ([documentação oficial de
`csv`](https://docs.python.org/3/library/csv.html))

O programa não tenta detectar automaticamente o dialeto. Detecção é uma
heurística e pode errar; quando o formato é conhecido, prefiro recebê-lo como
configuração.

## O que “aleatório” significa neste exemplo

Cada posição de registro tem a mesma probabilidade de participar de uma amostra
de tamanho `k`, desde que o gerador se comporte como esperado. Isso é amostragem
de registros, não de entidades únicas.

Se o CSV contém dez linhas da mesma pessoa, as dez participam separadamente do
sorteio. Se os dados estão ordenados por tempo, a uniformidade por registro não
garante representação suficiente de períodos raros, regiões ou classes
minoritárias. Nesses casos, pode ser necessário estratificar a população ou
agrupar por entidade antes de amostrar.

Também existe viés anterior ao algoritmo: o arquivo pode já excluir eventos,
conter duplicatas ou representar apenas uma parte do processo. Reservoir
sampling não corrige a origem dos dados.

## Validações mínimas

Antes de usar a amostra em uma análise, eu verificaria:

1. o arquivo de saída tem o cabeçalho esperado;
2. contém exatamente `k` registros de dados;
3. campos com delimitador, aspas e quebras de linha continuam válidos;
4. `k` maior que a população encerra com erro;
5. origem e destino iguais são rejeitados;
6. duas execuções com a mesma semente e versão produzem a mesma seleção;
7. a unidade sorteada — registro, pessoa, pedido ou evento — corresponde à
   pergunta da análise.

O ganho desta versão é limitado e verificável: o arquivo é percorrido uma vez e
somente a amostra permanece em memória. Isso permite trabalhar com entradas
maiores, mas não transforma uma amostra aleatória simples em evidência
representativa para qualquer decisão.
