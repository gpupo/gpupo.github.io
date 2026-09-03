# Distância de Levenshtein para sugerir correspondências entre categorias

Published: 2023-06-17
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/lessons/uso-de-distancia-de-levenshtein-para-calcular-a-similaridade-entre-as-categorias-entre-dois-arquivos-csv/
Tags: Gists, Dados

---

Gist ID: 15d7634f81ced00d26423841bac9efc3

Quando dois catálogos usam nomes diferentes para categorias parecidas, a
distância de Levenshtein pode ajudar a ordenar possíveis correspondências. Ela
mede quantas inserções, remoções e substituições são necessárias para
transformar uma sequência em outra.

Isso produz uma **similaridade textual**, não uma confirmação de equivalência.
“Óleo de motor” e “filtro de óleo” compartilham caracteres, mas representam
categorias diferentes. O resultado deste exemplo deve entrar em uma fila de
revisão, nunca ser aplicado automaticamente ao catálogo.

## O problema do primeiro script

A versão anterior escolhia sempre a categoria com a maior pontuação e gravava
seu identificador como resultado. Ela não registrava a pontuação, não comparava
a primeira opção com a segunda e não previa um estado inconclusivo. Assim, até
uma correspondência ruim era apresentada como resposta.

Também havia pressupostos implícitos sobre a posição das colunas nos arquivos
CSV. A revisão abaixo usa nomes de colunas, normaliza apenas diferenças
tipográficas simples e conserva evidências suficientes para revisão.

## Uma versão que gera candidatos

O script usa apenas a biblioteca padrão do Python. Os limites mínimos de
pontuação e de diferença para a segunda opção são parâmetros obrigatórios:
devem ser calibrados com exemplos já classificados no catálogo, não escolhidos
por conveniência.

```python
from __future__ import annotations

import argparse
import csv
import unicodedata
from dataclasses import dataclass
from pathlib import Path


@dataclass(frozen=True)
class Category:
    identifier: str
    breadcrumb: str
    normalized: str


def normalize(value: str) -> str:
    """Normaliza Unicode, caixa e espaços sem remover palavras."""
    value = unicodedata.normalize("NFKC", value).casefold()
    return " ".join(value.split())


def levenshtein_distance(left: str, right: str) -> int:
    """Calcula a distância com memória proporcional à menor string."""
    if len(left) < len(right):
        left, right = right, left

    previous = list(range(len(right) + 1))
    for left_index, left_character in enumerate(left, start=1):
        current = [left_index]
        for right_index, right_character in enumerate(right, start=1):
            insertion = current[right_index - 1] + 1
            deletion = previous[right_index] + 1
            substitution = previous[right_index - 1] + (
                left_character != right_character
            )
            current.append(min(insertion, deletion, substitution))
        previous = current

    return previous[-1]


def similarity(left: str, right: str) -> float:
    """Converte a distância em uma escala de 0 a 1."""
    maximum_length = max(len(left), len(right))
    if maximum_length == 0:
        return 1.0
    return 1 - levenshtein_distance(left, right) / maximum_length


def require_columns(reader: csv.DictReader, columns: set[str]) -> None:
    available = set(reader.fieldnames or [])
    missing = columns - available
    if missing:
        raise ValueError(f"Colunas ausentes: {', '.join(sorted(missing))}")


def load_categories(
    path: Path,
    id_column: str,
    breadcrumb_column: str,
) -> list[Category]:
    with path.open(encoding="utf-8", newline="") as source:
        reader = csv.DictReader(source)
        require_columns(reader, {id_column, breadcrumb_column})

        categories = []
        for line_number, row in enumerate(reader, start=2):
            breadcrumb = row[breadcrumb_column].strip()
            if not breadcrumb:
                raise ValueError(f"Breadcrumb vazio na linha {line_number}")
            categories.append(
                Category(
                    identifier=row[id_column].strip(),
                    breadcrumb=breadcrumb,
                    normalized=normalize(breadcrumb),
                )
            )

    if not categories:
        raise ValueError("O catálogo de referência está vazio")
    return categories


def rank_candidates(
    source_name: str,
    categories: list[Category],
) -> list[tuple[float, Category]]:
    normalized_source = normalize(source_name)
    ranked = [
        (similarity(normalized_source, category.normalized), category)
        for category in categories
    ]
    return sorted(ranked, key=lambda item: item[0], reverse=True)


def process(args: argparse.Namespace) -> None:
    categories = load_categories(
        args.reference,
        args.reference_id_column,
        args.reference_name_column,
    )

    with args.source.open(encoding="utf-8", newline="") as source_file:
        reader = csv.DictReader(source_file)
        require_columns(reader, {args.source_name_column})
        source_fields = list(reader.fieldnames or [])
        extra_fields = [
            "candidate_id",
            "candidate_breadcrumb",
            "candidate_score",
            "runner_up_score",
            "score_margin",
            "status",
        ]
        collisions = set(source_fields) & set(extra_fields)
        if collisions:
            raise ValueError(
                f"A origem já contém colunas de saída: {sorted(collisions)}"
            )

        # O modo "x" evita sobrescrever uma revisão anterior.
        with args.output.open("x", encoding="utf-8", newline="") as output_file:
            writer = csv.DictWriter(
                output_file,
                fieldnames=source_fields + extra_fields,
            )
            writer.writeheader()

            for row in reader:
                source_name = row[args.source_name_column].strip()
                if not source_name:
                    writer.writerow(
                        row
                        | {
                            "candidate_id": "",
                            "candidate_breadcrumb": "",
                            "candidate_score": "",
                            "runner_up_score": "",
                            "score_margin": "",
                            "status": "empty_source",
                        }
                    )
                    continue

                ranked = rank_candidates(source_name, categories)
                best_score, best_category = ranked[0]
                runner_up_score = ranked[1][0] if len(ranked) > 1 else 0.0
                margin = best_score - runner_up_score

                status = "candidate"
                if (
                    best_score < args.minimum_score
                    or margin < args.minimum_margin
                ):
                    status = "review"

                writer.writerow(
                    row
                    | {
                        "candidate_id": best_category.identifier,
                        "candidate_breadcrumb": best_category.breadcrumb,
                        "candidate_score": f"{best_score:.4f}",
                        "runner_up_score": f"{runner_up_score:.4f}",
                        "score_margin": f"{margin:.4f}",
                        "status": status,
                    }
                )


def unit_interval(value: str) -> float:
    number = float(value)
    if not 0 <= number <= 1:
        raise argparse.ArgumentTypeError("use um valor entre 0 e 1")
    return number


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(
        description="Gera candidatos de categorias para revisão humana."
    )
    parser.add_argument("source", type=Path)
    parser.add_argument("reference", type=Path)
    parser.add_argument("output", type=Path)
    parser.add_argument("--source-name-column", required=True)
    parser.add_argument("--reference-id-column", required=True)
    parser.add_argument("--reference-name-column", required=True)
    parser.add_argument("--minimum-score", type=unit_interval, required=True)
    parser.add_argument("--minimum-margin", type=unit_interval, required=True)
    return parser.parse_args()


if __name__ == "__main__":
    process(parse_args())
```

Uma execução possível, depois de calibrar os limites, seria:

```bash
python match_categories.py \
  categorias.csv \
  categorias_referencia.csv \
  resultado.csv \
  --source-name-column categoria \
  --reference-id-column id \
  --reference-name-column breadcrumb \
  --minimum-score 0.80 \
  --minimum-margin 0.10
```

Os valores `0.80` e `0.10` são apenas exemplos de uso da interface. Eles não
constituem limites recomendados para qualquer catálogo.

## Como interpretar a saída

`candidate_score` é a similaridade calculada por esta implementação, não uma
probabilidade de acerto. `runner_up_score` mostra a força da segunda opção e
`score_margin`, a separação entre as duas primeiras. Uma margem pequena indica
ambiguidade mesmo quando a maior pontuação parece alta.

O estado `candidate` significa apenas que o registro ultrapassou os limites
configurados. A aprovação continua sendo uma decisão de catálogo. Para medir a
qualidade do processo, separe um conjunto de pares previamente revisados e
calcule quantas sugestões corretas e incorretas cada configuração produz.

## Limitações

A comparação considera a grafia, não o significado das categorias. Sinônimos
podem receber pontuação baixa; categorias semanticamente distintas podem ter
grafia parecida. Além disso, comparar cada origem com todas as categorias de
referência fica caro à medida que os arquivos crescem. Catálogos grandes pedem
uma etapa anterior de bloqueio por idioma, ramo da taxonomia ou outros atributos.

O módulo [`csv`](https://docs.python.org/3/library/csv.html) documenta as classes
`DictReader` e `DictWriter` usadas no exemplo. A definição histórica da distância
pode ser consultada no artigo de Vladimir Levenshtein,
[*Binary Codes Capable of Correcting Deletions, Insertions and Reversals*](https://www.mathnet.ru/eng/dan31411).
