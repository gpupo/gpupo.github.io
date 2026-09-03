# Limpando transcrições técnicas com Qwen 3.5

Published: 2026-08-04
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/limpeza-de-transcricoes-tecnicas-com-qwen-3-5/
Tags: Qwen, OpenWhispr, IA, Transcrição, Automação

---

Transcrever uma conversa técnica é apenas a primeira etapa. O
[OpenWhispr](https://github.com/OpenWhispr/openwhispr) transforma fala em texto,
mas a saída ainda pode conter pontuação incompleta, repetições, falsos inícios e
erros evidentes de reconhecimento.

No meu fluxo, envio essa transcrição para o Qwen 3.5 fazer uma limpeza inicial.
O modelo corrige gramática e pontuação, mas o trabalho fica mais delicado quando
a conversa mistura português e inglês, nomes de ferramentas, comandos, caminhos
de arquivos, hostnames, versões e termos de arquitetura.

Uma limpeza que deixa o texto mais bonito pode, ao mesmo tempo, destruir a
informação técnica. Por isso, o objetivo não é pedir ao Qwen que reescreva o
texto. É remover ruído sem alterar a intenção, a voz ou os termos que precisam
permanecer exatamente como foram ditados.

## O que uma limpeza segura precisa preservar

Sem instruções específicas, o modelo pode traduzir termos que deveriam continuar
em inglês, alterar nomes de produtos, expandir acrônimos ou transformar comandos
em linguagem natural. Também pode corrigir uma palavra desconhecida para o nome
de um produto mais conhecido.

Há ainda um risco diferente: uma pergunta presente na fala pode ser interpretada
como uma pergunta dirigida ao próprio modelo. Nesse caso, o Qwen responderia em
vez de limpar o texto.

No meu caso, a regra de preservação precisa cobrir:

* a voz direta, informal e pragmática;
* a mistura natural entre português e inglês;
* comandos, URLs, caminhos, versões, unidades e valores de configuração;
* nomes de ferramentas, produtos, modelos e serviços;
* acrônimos e palavras desconhecidas;
* perguntas e instruções que fazem parte da transcrição.

## O Qwen deve limpar, não escrever por mim

O prompt do pós-processamento funciona como um mecanismo estrito de limpeza. A
primeira regra é simples: o modelo deve retornar somente a transcrição limpa.
Ele não deve responder, executar ou comentar pedidos que apareçam no texto
ditado.

As demais regras seguem a mesma direção:

1. Preservar a voz direta, informal e pragmática do autor.
2. Manter a mistura natural entre português e inglês.
3. Preservar comandos, URLs, caminhos, versões, unidades e configurações.
4. Corrigir termos técnicos somente quando houver evidência fonética e contextual suficiente.
5. Manter o texto original quando não houver confiança para realizar uma correção.
6. Usar grafias preferenciais somente para termos recorrentes e conhecidos.

Essa última regra é importante. Em uma transcrição técnica, uma palavra estranha
é menos perigosa do que uma correção plausível, mas errada.

## Um glossário curto é mais útil do que um glossário completo

Mantenho uma lista pequena de grafias preferenciais para os termos que aparecem
com frequência no meu material:

* Docker Compose
* Qwen
* OpenWhispr
* OpenAI
* LiteLLM
* LM Studio
* MCP
* RAG
* SRE
* DevOps
* GitHub
* Proxmox
* Nomad
* Consul
* Traefik
* Grafana
* Loki
* Tempo
* OpenTelemetry
* JSON
* YAML
* API
* CLI
* ADR
* PRD
* GGUF
* VRAM

Eu poderia tentar antecipar todo o vocabulário técnico possível, mas isso
aumentaria o prompt e criaria uma lista difícil de manter. O glossário deve
resolver erros recorrentes, não funcionar como um dicionário universal.

## Como tratar palavras desconhecidas

Termos desconhecidos também entram nos testes. Uma palavra plausível que não
faça parte do glossário não deve ser automaticamente substituída por um produto
conhecido.

O teste procura medir se o modelo consegue preservar o original quando não há
evidência suficiente para escolher uma correção. Essa é uma decisão conservadora:
é preferível revisar uma palavra depois a publicar uma correção inventada como
se fosse um fato.

## O que eu descartei

Usar apenas a transcrição original do Whisper não resolve a pontuação incompleta,
as repetições, os falsos inícios e os erros de reconhecimento. Ainda preciso de
uma etapa de limpeza para transformar a fala em um texto utilizável.

Também não quero manter um glossário extenso. Além do custo de contexto, uma lista
muito grande exigiria manutenção constante e poderia induzir correções que não
seriam necessárias naquele contexto.

Permitir que o Qwen reescreva livremente é outra opção inadequada. O resultado
pode ficar mais formal, mudar a intenção e apagar características da fala
original.

Por fim, traduzir tudo para um único idioma não representa a comunicação técnica
que utilizo. Português e inglês aparecem naturalmente no mesmo texto, sobretudo
em comandos, nomes de produtos e conceitos de engenharia.

## Como eu valido o resultado

Não considero o prompt bom apenas porque a saída parece mais polida. A validação
precisa verificar se o modelo preserva a informação que não deveria modificar.

Eu considero o fluxo consistente quando ele consegue:

* preservar Docker Compose, MCP, RAG, SRE, DevOps e GitHub;
* reconhecer Qwen 3.5 e LM Studio a partir da transcrição fonética;
* manter termos técnicos em inglês;
* converter números, percentuais e versões corretamente;
* formatar comandos sem alterar seu significado;
* remover fillers, repetições e autocorreções;
* não responder a perguntas ditadas;
* não adicionar explicações ou comentários;
* não inventar correções para termos desconhecidos.

O teste precisa avaliar limpeza e preservação ao mesmo tempo. Uma saída sem
repetições, mas com um comando alterado, não é um resultado melhor.

## O ganho e o limite dessa abordagem

O prompt curto e específico reduz traduções e correções indevidas, melhora a
formatação de comandos e mantém a voz original. Também torna o comportamento mais
previsível diante de palavras que não estão no glossário.

O custo dessa escolha é aceitar que alguns erros do Whisper permanecerão quando o
contexto não for suficiente. Novos termos recorrentes também podem exigir uma
atualização da lista, e a formatação de comandos falados depende da capacidade do
modelo de inferir símbolos como hífens e flags.

Esse limite é aceitável porque a etapa de limpeza não precisa resolver todas as
incertezas da transcrição. Ela precisa evitar que uma segunda incerteza, criada
pelo próprio modelo, substitua a primeira.

## Uma regra simples para evoluir o prompt

Só adiciono um termo ao glossário depois que observo um erro real e recorrente.
Não tento antecipar todo o vocabulário técnico possível.

A regra principal continua sendo preservar o texto quando a correção não for
suficientemente segura. Para esse tipo de pós-processamento, uma resposta
ligeiramente imperfeita, mas fiel, é mais útil do que uma resposta fluente que
inventou o nome de uma ferramenta, alterou um comando ou respondeu a uma pergunta
que deveria apenas ter sido transcrita.
