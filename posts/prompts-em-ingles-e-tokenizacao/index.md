# Prompts em inglês são sempre mais baratos?

Published: 2026-04-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/prompts-em-ingles-e-tokenizacao/
Tags: IA, LLM, Custos, Prompt Engineering

---

O número de tokens de um prompt não é uma propriedade do idioma isoladamente.
Ele depende do texto, do vocabulário e do algoritmo de tokenização usado pelo
modelo. Duas instruções com significado próximo, uma em inglês e outra em
português, podem produzir contagens diferentes. A direção e o tamanho dessa
diferença precisam ser medidos no modelo escolhido.

A documentação da Hugging Face sobre
[algoritmos de tokenização](https://huggingface.co/docs/transformers/main/en/tokenizer_summary)
mostra por que a mesma palavra pode ser dividida de maneiras diferentes conforme
o vocabulário e o algoritmo. BPE, Unigram e WordPiece, por exemplo, não aplicam
as mesmas regras de segmentação.

## Quando isso importa

Em uma chamada isolada, reduzir alguns tokens pode não alterar nenhuma decisão.
Em um fluxo de grande volume, uma diferença recorrente pode afetar o orçamento.
O impacto precisa ser calculado com o número real de requisições e a tabela de
preços vigente.

O cálculo precisa considerar mais do que a língua do prompt:

- número de chamadas;
- quantidade de contexto enviado;
- tokens de entrada e saída;
- preço do modelo;
- custo de tradução ou revisão;
- impacto sobre a qualidade da resposta.

Traduzir tudo para inglês também pode alterar termos do domínio. Um nome de
produto, uma regra jurídica ou uma instrução operacional pode perder precisão
quando é reescrito apenas para economizar tokens. Por isso, contagem e qualidade
precisam fazer parte do mesmo teste.

## Como eu mediria

Antes de mudar a língua dos prompts, eu criaria um conjunto de exemplos reais e compararia as duas versões no mesmo modelo. O teste deveria medir:

1. tokens de entrada;
2. latência;
3. custo estimado;
4. taxa de respostas corretas;
5. necessidade de revisão humana.

Um tokenizer pode ser usado para estimar o tamanho, mas o preço final deve ser calculado conforme a política do provedor e a configuração real do serviço.

Também vale testar prompts mistos. Termos técnicos, nomes de APIs e comandos
podem permanecer no idioma usado pela documentação, enquanto a explicação e a
saída ficam em português. Essa opção precisa passar pelos mesmos critérios de
qualidade e custo.

O ponto não é declarar um idioma vencedor. Tokens são uma unidade de custo, mas
o idioma só deve ser alterado depois que a comparação mostrar economia sem perda
relevante de qualidade.
