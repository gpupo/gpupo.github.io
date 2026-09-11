# LLM local para descrição de produto: gerar texto sem inventar atributos

Published: 2024-05-09
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/lessons/uso-de-um-llm-pequeno-para-melhoria-de-descricao-de-produto/
Tags: Gists, IA, LLMs, Produto

---

Gist ID: 4bf43c9e0ab47b6afc845dcb1312eedd

Em 2024, testei um modelo pequeno executado com Ollama para reescrever a
descrição de um ventilador de refrigeração. O prompt continha nome, duas
características e listas de compatibilidade e incompatibilidade. A resposta
acrescentou afirmações que não estavam na entrada.

O resultado gerado não foi preservado no post original. Portanto, consigo
registrar que observei informações sem suporte, mas não reconstituir quais foram
nem medir a frequência do problema. Este texto revisa o desenho do experimento,
não compara modelos.

## O erro não era falta de contexto

Minha primeira anotação sugeria aplicar RAG como próximo passo. Para este caso,
essa não é a correção inicial: os fatos necessários já estavam no prompt.

[RAG combina geração com recuperação de documentos externos](https://www.bpstrat.com.br/post/rag-md/). A técnica é útil
quando o sistema precisa localizar informações que não cabem ou não foram
fornecidas diretamente na solicitação. O artigo de Lewis e outros,
[*Retrieval-Augmented Generation for Knowledge-Intensive NLP Tasks*](https://papers.neurips.cc/paper/2020/hash/6b493230205f780e1bc26945df7481e5-Abstract.html),
é uma referência primária para essa arquitetura.

Recuperar mais texto não garante que a resposta ficará restrita às fontes. Neste
experimento, o problema imediato era outro: uma saída livre estava sendo tratada
como descrição publicável.

## Separe fatos de texto gerado

Uma abordagem mais segura mantém os dados de produto em uma estrutura controlada
e pede ao modelo apenas uma sugestão de resumo. Compatibilidade,
incompatibilidade e características são renderizadas diretamente da fonte, sem
passar pela reescrita do modelo.

O exemplo abaixo também solicita uma saída estruturada. O Ollama aceita um JSON
Schema no parâmetro `format`, conforme a documentação de
[`Structured Outputs`](https://docs.ollama.com/capabilities/structured-outputs).

```python
from __future__ import annotations

import json
import os
from typing import Any

from ollama import Client


FACTS = {
    "product_name": "Khadas 3705 Cooling Fan",
    "features": {
        "high_airflow": "High Airflow",
        "super_quiet": "Super Quiet",
    },
    "compatible_with": [
        "Edge",
        "Edge-V",
        "VIM3",
        "VIM2 v1.4",
        "Edge Heatsink",
        "New VIM Heatsink",
    ],
    "incompatible_with": [
        "VIM1 (all versions)",
        "VIM2 (v1.2 and earlier)",
        "Original VIM Heatsink",
    ],
}

ALLOWED_FACT_IDS = [
    "product_name",
    *[f"feature.{key}" for key in FACTS["features"]],
]

OUTPUT_SCHEMA = {
    "type": "object",
    "properties": {
        "summary_candidate": {"type": "string"},
        "facts_used": {
            "type": "array",
            "items": {"type": "string", "enum": ALLOWED_FACT_IDS},
            "uniqueItems": True,
        },
    },
    "required": ["summary_candidate", "facts_used"],
    "additionalProperties": False,
}


def generate_candidate(client: Client, model: str) -> dict[str, Any]:
    source = {
        "product_name": FACTS["product_name"],
        "features": FACTS["features"],
    }
    prompt = f"""
Crie uma frase curta em português para apresentar o produto.

Regras:
- use somente os fatos presentes em SOURCE;
- não acrescente benefícios, materiais, desempenho ou casos de uso;
- não mencione compatibilidade: ela será renderizada separadamente;
- liste em facts_used os identificadores que sustentam a frase;
- responda conforme OUTPUT_SCHEMA.

SOURCE:
{json.dumps(source, ensure_ascii=False, indent=2)}

OUTPUT_SCHEMA:
{json.dumps(OUTPUT_SCHEMA, ensure_ascii=False, indent=2)}
""".strip()

    response = client.chat(
        model=model,
        messages=[{"role": "user", "content": prompt}],
        format=OUTPUT_SCHEMA,
        options={"temperature": 0},
    )
    return json.loads(response.message.content)


def validate_candidate(candidate: dict[str, Any]) -> None:
    if set(candidate) != {"summary_candidate", "facts_used"}:
        raise ValueError("A resposta contém campos inesperados")
    if not isinstance(candidate["summary_candidate"], str):
        raise ValueError("summary_candidate deve ser uma string")

    facts_used = candidate["facts_used"]
    if not isinstance(facts_used, list):
        raise ValueError("facts_used deve ser uma lista")
    unknown = set(facts_used) - set(ALLOWED_FACT_IDS)
    if unknown:
        raise ValueError(f"Fatos desconhecidos: {sorted(unknown)}")


def render_verified_fields() -> str:
    features = "\n".join(
        f"- {feature}" for feature in FACTS["features"].values()
    )
    compatible = "\n".join(
        f"- {item}" for item in FACTS["compatible_with"]
    )
    incompatible = "\n".join(
        f"- {item}" for item in FACTS["incompatible_with"]
    )
    return f"""Características:
{features}

Compatível com:
{compatible}

Incompatível com:
{incompatible}"""


def main() -> None:
    model = os.environ.get("OLLAMA_MODEL")
    if not model:
        raise RuntimeError("Defina OLLAMA_MODEL com um modelo já instalado")

    client = Client(
        host=os.environ.get("OLLAMA_HOST", "http://localhost:11434"),
        timeout=30.0,
    )
    candidate = generate_candidate(client, model)
    validate_candidate(candidate)

    print("CANDIDATO — REVISÃO HUMANA OBRIGATÓRIA")
    print(candidate["summary_candidate"])
    print()
    print(render_verified_fields())


if __name__ == "__main__":
    main()
```

Para executar, instale o cliente, escolha um modelo disponível na sua máquina e
inicie o Ollama:

```bash
python -m pip install ollama
export OLLAMA_MODEL='nome-do-modelo-instalado'
python product_description.py
```

O código não fixa um modelo porque nomes disponíveis, versões e requisitos de
hardware mudam. O repositório oficial do
[`ollama-python`](https://github.com/ollama/ollama-python) documenta o cliente e
informa que o Ollama deve estar instalado e em execução.

## O que esta versão controla

Os campos críticos são copiados de `FACTS` para a saída final. O modelo não pode
alterar as listas de compatibilidade e incompatibilidade. O JSON Schema limita o
formato da resposta e `facts_used` torna explícita a alegação de quais fatos
sustentam o resumo.

Isso melhora a rastreabilidade, mas não prova que a frase é fiel. Um modelo pode
produzir JSON válido, citar um identificador permitido e ainda escrever uma
conclusão que o dado não sustenta. Temperatura zero reduz variação; não é uma
garantia de veracidade.

## Validação antes de publicar

Minha recomendação para esse fluxo é:

1. preservar a entrada original e a identificação do modelo;
2. validar a estrutura da resposta;
3. renderizar atributos críticos diretamente da fonte;
4. comparar o resumo com os fatos apresentados;
5. reprovar qualquer benefício ou especificação sem evidência;
6. manter revisão humana antes da publicação;
7. avaliar o sistema com um conjunto de produtos e critérios registrados.

Se os fatos estiverem espalhados em manuais, fichas técnicas e bancos de dados,
uma etapa de recuperação pode ser adicionada. Nesse caso, cada trecho recuperado
precisa conservar sua origem e a avaliação deve medir tanto a recuperação quanto
a fidelidade da geração.

O aprendizado do experimento é limitado, mas útil: um LLM pode sugerir redação;
não deve se tornar, por isso, a fonte dos atributos do produto.
