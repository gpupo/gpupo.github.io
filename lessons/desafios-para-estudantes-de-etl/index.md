# Exercício de ETL: converter coleções de um JSON em arquivos CSV

Published: 2023-06-26
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/lessons/desafios-para-estudantes-de-etl/
Tags: Gists, Dados

---

Gist ID: 7e934be8ddfbe7642a9ce43182f34684

Este exercício introdutório parte de um arquivo JSON com duas coleções e gera
um CSV para cada uma. O objetivo não é apenas converter formatos, mas tornar
explícitas as três decisões de um pequeno processo de ETL:

- **extração:** como o JSON será lido;
- **transformação:** quais estruturas são aceitas e como as colunas serão
  definidas;
- **carga:** onde os CSVs serão gravados e como evitar sobrescritas.

Use este conteúdo em `dados.json`:

```json
{
  "pessoas": [
    {
      "nome": "João",
      "idade": 25,
      "cidade": "São Paulo"
    },
    {
      "nome": "Maria",
      "idade": 30,
      "cidade": "Rio de Janeiro"
    },
    {
      "nome": "Carlos",
      "idade": 35,
      "cidade": "Belo Horizonte"
    }
  ],
  "veiculos": [
    {
      "marca": "Toyota",
      "modelo": "Corolla",
      "ano": 2018
    },
    {
      "marca": "Honda",
      "modelo": "Civic",
      "ano": 2020
    },
    {
      "marca": "Volkswagen",
      "modelo": "Golf",
      "ano": 2017
    }
  ]
}
```

## Antes de programar

Defina o contrato do exercício. Neste caso:

1. a raiz do JSON deve ser um objeto;
2. cada chave da raiz identifica uma coleção;
3. cada coleção deve ser uma lista de objetos;
4. os valores de cada registro devem ser escalares ou nulos;
5. uma coleção vazia gera um arquivo vazio, pois não há colunas a inferir;
6. um arquivo existente não deve ser substituído silenciosamente.

Essas regras são escolhas desta implementação. Outro pipeline poderia receber
um esquema separado, serializar objetos aninhados ou permitir sobrescrita.

## Implementação

```python
from __future__ import annotations

import argparse
import csv
import json
import re
from pathlib import Path
from typing import Any


SAFE_DATASET_NAME = re.compile(r"^[A-Za-z0-9_-]+$")
SCALAR_TYPES = (str, int, float, bool, type(None))


def extract(path: Path) -> dict[str, Any]:
    with path.open(encoding="utf-8") as source:
        data = json.load(source)

    if not isinstance(data, dict):
        raise ValueError("A raiz do JSON deve ser um objeto")
    return data


def validate_records(dataset_name: str, value: Any) -> list[dict[str, Any]]:
    if not SAFE_DATASET_NAME.fullmatch(dataset_name):
        raise ValueError(f"Nome de coleção inválido: {dataset_name!r}")
    if not isinstance(value, list):
        raise ValueError(f"{dataset_name!r} deve conter uma lista")

    records: list[dict[str, Any]] = []
    for index, record in enumerate(value):
        if not isinstance(record, dict):
            raise ValueError(
                f"{dataset_name}[{index}] deve ser um objeto"
            )
        for field, field_value in record.items():
            if not isinstance(field, str):
                raise ValueError("Todo nome de campo deve ser uma string")
            if not isinstance(field_value, SCALAR_TYPES):
                raise ValueError(
                    f"{dataset_name}[{index}].{field} contém um valor aninhado"
                )
        records.append(record)
    return records


def collect_headers(records: list[dict[str, Any]]) -> list[str]:
    """Preserva a ordem da primeira ocorrência de cada campo."""
    headers: list[str] = []
    seen: set[str] = set()
    for record in records:
        for field in record:
            if field not in seen:
                seen.add(field)
                headers.append(field)
    return headers


def load_csv(
    output_path: Path,
    records: list[dict[str, Any]],
) -> None:
    headers = collect_headers(records)

    # O modo "x" interrompe a execução se o arquivo já existir.
    with output_path.open("x", encoding="utf-8", newline="") as target:
        if not headers:
            return
        writer = csv.DictWriter(
            target,
            fieldnames=headers,
            extrasaction="raise",
        )
        writer.writeheader()
        writer.writerows(records)


def run(input_path: Path, output_directory: Path) -> None:
    data = extract(input_path)
    output_directory.mkdir(parents=True, exist_ok=True)

    for dataset_name, value in data.items():
        records = validate_records(dataset_name, value)
        output_path = output_directory / f"{dataset_name}.csv"
        load_csv(output_path, records)
        print(f"{output_path}: {len(records)} registro(s)")


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(
        description="Converte coleções de um JSON em arquivos CSV."
    )
    parser.add_argument("input", type=Path)
    parser.add_argument("output_directory", type=Path)
    return parser.parse_args()


if __name__ == "__main__":
    arguments = parse_args()
    run(arguments.input, arguments.output_directory)
```

Salve o código como `json_to_csv.py` e execute:

```bash
python json_to_csv.py dados.json saida
```

O diretório `saida` receberá `pessoas.csv` e `veiculos.csv`.

## Por que usar `DictWriter`

O primeiro exemplo deste exercício obtinha o cabeçalho com as chaves do primeiro
registro e depois gravava `item.values()`. Isso pressupunha que todos os objetos
tinham exatamente os mesmos campos, na mesma ordem. Um campo ausente, adicional
ou reordenado podia deslocar valores para a coluna errada.

`csv.DictWriter` associa cada valor ao nome do campo. A função
`collect_headers` percorre todos os registros para incluir campos que só
aparecem depois do primeiro. Quando um registro não contém uma dessas chaves, o
módulo grava uma célula vazia.

## Casos que o exercício deve testar

Depois do exemplo principal, experimente deliberadamente:

- trocar a ordem dos campos em um registro;
- remover `cidade` de uma pessoa;
- acrescentar um campo apenas ao último veículo;
- inserir uma lista no lugar de um valor escalar;
- deixar uma coleção vazia;
- executar o programa duas vezes no mesmo diretório.

Os três primeiros casos verificam a transformação das colunas. Os demais
verificam se o contrato falha de forma visível ou preserva a decisão definida.

## Limitações

CSV é tabular; JSON pode representar árvores. Este exemplo rejeita listas e
objetos dentro dos registros para não decidir silenciosamente como achatá-los.
Em um pipeline real, o esquema de saída, os tipos, a codificação de datas, o
tratamento de erros e a política de reprocessamento deveriam ser definidos antes
da carga.

As APIs utilizadas estão documentadas nos módulos
[`json`](https://docs.python.org/3/library/json.html) e
[`csv`](https://docs.python.org/3/library/csv.html) do Python.
