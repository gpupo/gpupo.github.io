# Qwen 3.5 em uma RTX 5060 Ti: de minutos para 7,48 segundos

Published: 2026-08-02
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/qwen-3-5-rtx-5060-ti-7-48-segundos/
Tags: LLMs, IA local, Benchmarks, Hardware, IA

---

Eu queria descobrir se o Qwen 3.5 9B poderia deixar de ser apenas um experimento
e se tornar utilizável para interação local. Nas rodadas anteriores da minha
suíte `standard`, cada execução levava entre 376 e 1.119 segundos. Na rodada
mais recente, com uma RTX 5060 Ti, o modelo terminou em **7,48 segundos** e
passou nos três testes com validação automática.

A rodada mais recente usou o modelo `qwen/qwen3.5-9b` em um serviço compatível
com a API da OpenAI, identificado no benchmark como **qwen3.5 RTX 5060ti**.

Minha suíte `standard` possui cinco tarefas:

- conhecimento geral;
- cumprimento de instruções;
- raciocínio lógico;
- geração de código;
- resumo técnico.

Três tarefas possuem critério automático. As outras duas ficam registradas para
avaliação qualitativa. Neste texto, comparo esse resultado com as rodadas
anteriores e com outros modelos, sem tratá-lo como uma comparação controlada de
GPUs.

## A rodada de 7,48 segundos

O modelo processou 271 tokens de entrada e produziu 354 tokens de resposta.

| Métrica | Resultado |
|---|---:|
| Tempo total | **7,48 s** |
| Testes com critério aprovados | **3 de 3** |
| Testes com critério reprovados | **0** |
| Tokens de prompt | 271 |
| Tokens de resposta | 354 |

As respostas continuaram objetivas. O modelo respondeu `SIM` no teste de
cumprimento estrito de instruções, resolveu corretamente o problema lógico e
produziu uma implementação funcional da sequência de Fibonacci.

Nos dois testes sem validação automática, as respostas sobre Alan Turing e
Kubernetes foram curtas e coerentes. Isso não transforma avaliação qualitativa
em aprovação automática, mas ajuda a entender o comportamento observado na
rodada.

## De vários minutos para poucos segundos

O primeiro benchmark `standard` que registrei para o Qwen 3.5 9B levou **687,92
segundos**, com duas aprovações e uma reprovação. Depois, aumentando o timeout,
o modelo passou nos três critérios, mas ainda levou entre **376 e 1.119
segundos** e produziu milhares de tokens.

Desabilitar o modo de raciocínio (`thinking`) foi o primeiro grande salto:
**20,73 segundos**, mantendo as três aprovações. A execução na RTX 5060 Ti
derrubou o tempo novamente, agora para **7,48 segundos**.

| Configuração | Tempo | Aprovados/reprovados | Tokens de resposta |
|---|---:|:---:|---:|
| Qwen 3.5 9B — primeira rodada | 687,92 s | 2/1 | 2.325 |
| Qwen 3.5 9B — melhor rodada anterior com timeout | 376,08 s | 3/0 | 12.293 |
| Qwen 3.5 9B — sem `thinking` | 20,73 s | 3/0 | 442 |
| **Qwen 3.5 9B — RTX 5060 Ti** | **7,48 s** | **3/0** | **354** |

Comparada à melhor rodada anterior do Qwen 9B com timeout, a nova execução foi
aproximadamente **50 vezes mais rápida**. Mesmo contra a configuração sem
`thinking`, que já era muito mais eficiente, foi cerca de **2,8 vezes mais
rápida** e produziu aproximadamente 20% menos tokens de resposta.

## Comparando com os outros modelos

Esse também foi o menor tempo entre as rodadas `standard` com três aprovações
registradas no repositório do benchmark.

| Modelo ou configuração | Tempo | Aprovados/reprovados | Tokens de resposta |
|---|---:|:---:|---:|
| **Qwen 3.5 9B — RTX 5060 Ti** | **7,48 s** | **3/0** | **354** |
| MiMo v2.5 otimizado | 19,62 s | 3/0 | 734 |
| Qwen 3.5 9B sem `thinking` | 20,73 s | 3/0 | 442 |
| Gemma 4 12B — melhor rodada | 158,21 s | 3/0 | 3.096 |
| Qwen 3.5 4B — melhor rodada | 190,65 s | 3/0 | 10.005 |

Nesse recorte, o Qwen na RTX 5060 Ti foi cerca de **2,6 vezes mais rápido** que
o MiMo v2.5 otimizado e **21 vezes mais rápido** que a melhor rodada registrada
do Gemma 4 12B. Estou comparando somente execuções da mesma suíte que passaram
nos três critérios automáticos.

## O ganho veio do sistema de inferência completo

Os números refletem o sistema completo de inferência, e não apenas o modelo. A
redução simultânea no tempo e na quantidade de tokens reforça algo
que tenho observado nos testes: configuração de geração, template de chat,
modo de raciocínio e servidor de inferência podem ser tão importantes
quanto o hardware.

Aumentar o timeout resolveu a conclusão das primeiras rodadas, mas não resolveu
a eficiência. O modelo chegava à resposta correta enquanto produzia cadeias
muito longas. O salto posterior veio de respostas mais controladas e de uma
infraestrutura capaz de entregá-las com baixa latência.

## O que este teste não prova

Este não é um benchmark controlado de GPUs. As rodadas aconteceram em datas,
serviços e configurações diferentes. A identificação da execução registra a
RTX 5060 Ti, mas o benchmark ainda não coleta automaticamente:

- driver e backend de inferência;
- quantização;
- consumo de VRAM;
- tokens por segundo;
- latência do primeiro token;
- potência elétrica;
- estado do cache.

O total de tokens de prompt também varia entre algumas rodadas, indicando
diferenças de template ou tokenização. Posso comparar a experiência observada
em cada configuração, mas não atribuir todo o ganho exclusivamente à GPU.

Uma comparação rigorosa de hardware precisa repetir cada rodada com o mesmo
modelo, quantização, servidor, template, parâmetros de geração e estado de
cache. Também precisa registrar throughput, latência do primeiro token, memória
e consumo de energia.

## O que fica deste experimento

Para o meu uso, completar a suíte em **7,48 segundos**, passando nos três testes
com critério, torna o Qwen 3.5 9B viável para tarefas locais e interativas.

Antes de comparar GPUs, eu repetiria a suíte mantendo constantes o modelo, a
quantização, o servidor, o template, os parâmetros de geração e o estado do
cache. Também registraria tokens por segundo, latência do primeiro token,
memória e consumo de energia.

Por enquanto, trato os **7,48 segundos** como um resultado operacional: ele
mostra que esta configuração tornou o Qwen 3.5 9B adequado para interação local,
mas não prova que a RTX 5060 Ti explique sozinha todo o ganho.
