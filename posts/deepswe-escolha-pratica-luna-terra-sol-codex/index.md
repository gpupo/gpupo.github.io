# DeepSWE e a escolha prática entre Luna, Terra e Sol no Codex

Published: 2026-08-03
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/deepswe-escolha-pratica-luna-terra-sol-codex/
Tags: IA, Codex, DeepSWE, Agentes, Desenvolvimento, Benchmarks

---

Escolher um modelo de IA para desenvolvimento de software não deveria depender
apenas do marketing, do tamanho do modelo ou da sensação depois de uma boa
resposta. No trabalho cotidiano, três fatores pesam mais:

- capacidade de concluir tarefas reais;
- custo por execução;
- complexidade e risco do projeto.

O [DeepSWE](https://deepswe.datacurve.ai/) fornece um sinal externo de capacidade
para agentes de engenharia de software. O [artigo do benchmark](https://arxiv.org/abs/2607.07946)
e o [painel de resultados](https://deepswe.datacurve.ai/) ajudam a combinar esse
sinal com o contexto de cada projeto para escolher entre os perfis Luna, Terra e
Sol que utilizo no Codex.

A pergunta prática não é qual perfil vence em qualquer situação. É quando a
capacidade adicional de um perfil mais caro compensa o investimento.

## O que o DeepSWE mede

O DeepSWE avalia agentes em tarefas mais próximas do desenvolvimento cotidiano:
entender repositórios existentes, modificar vários arquivos, corrigir
comportamentos e implementar funcionalidades que precisam passar por
verificações automatizadas.

O [artigo do benchmark](https://arxiv.org/abs/2607.07946) descreve 113 tarefas
originais, distribuídas por 91 repositórios ativos e cinco linguagens: TypeScript,
Go, Python, JavaScript e Rust. As soluções de referência modificam, em média,
sete arquivos e adicionam aproximadamente 668 linhas de código.

As tarefas e os verificadores estão disponíveis no
[repositório do DeepSWE](https://github.com/datacurve-ai/deep-swe). Essa
estrutura torna o benchmark mais informativo do que exercícios isolados de
implementação. O agente precisa navegar pela base de código, entender
dependências, decidir onde alterar o sistema e concluir a tarefa sem quebrar o
comportamento existente.

O resultado ainda é uma medida de benchmark. Ele não substitui testes no nosso
próprio repositório, mas ajuda a evitar uma escolha baseada somente em impressão
subjetiva.

## Resultados observados nos perfis do Codex

Estes são os resultados que estou usando para comparar os perfis no Codex:

| Perfil | Resultado no DeepSWE | Custo médio por tarefa |
| --- | ---: | ---: |
| Sol, `gpt-5.6-sol[max]` | 73% | US$ 8,39 |
| Terra, `gpt-5.6-terra[max]` | 70% | US$ 3,96 |
| Luna, `gpt-5.6-luna[max]` | 67% | US$ 0,61 |

Os custos são médias da execução utilizada nesta comparação. Eles não devem ser
interpretados como preço universal do modelo, porque esforço de raciocínio,
harness, provedor e configuração podem alterar o valor final.

Todos os resultados da tabela usam esforço `max`. Eles comparam os modelos sob
essa configuração, não a experiência padrão do Codex. A
[orientação oficial](https://learn.chatgpt.com/docs/models.md) recomenda começar
com Sol quando houver dúvida e usar o menor esforço que produza o resultado
necessário. Portanto, o benchmark não determina sozinho qual deve ser o modelo
inicial no trabalho cotidiano.

A diferença de desempenho é relativamente pequena: seis pontos percentuais
separam Luna e Sol. O custo muda muito mais. Sol custa mais de 13 vezes o valor
médio de Luna, enquanto Terra custa menos da metade de Sol e fica apenas três
pontos percentuais atrás no resultado.

Esse intervalo sugere uma política de roteamento. O perfil mais caro deve entrar
quando a tarefa exigir sua capacidade, e não por padrão.

![Pontuação do DeepSWE em relação ao custo médio por tarefa.](/assets/images/deepswe-score-vs-cost.png){: .rounded }

![Pontuação do DeepSWE em relação à média de etapas do agente por tarefa.](/assets/images/deepswe-score-vs-agent-steps.png){: .rounded }

## Como eu usaria cada perfil

### Luna: velocidade, volume e exploração

Luna é o perfil de menor custo. Um resultado de 67% mostra que ele consegue
resolver uma parcela relevante das tarefas do benchmark, mesmo custando US$ 0,61
por execução nesta comparação.

Eu começaria por Luna em atividades como:

- explorar uma base de código;
- gerar documentação;
- criar testes iniciais;
- executar alterações repetitivas;
- investigar alternativas;
- preparar uma primeira implementação.

Esse perfil também faz sentido em projetos experimentais ou em tarefas de baixo
risco, nas quais várias tentativas ajudam a encontrar a solução.

Luna não precisa ser o melhor perfil absoluto. Precisa ser suficiente para
concluir o trabalho quando custo, velocidade e volume de execuções importarem
mais do que a maior taxa possível de sucesso em uma única tentativa.

### Terra: ponto de partida orientado por custo

Terra é o perfil mais equilibrado nesta comparação. Ele alcança 70% no DeepSWE,
três pontos abaixo de Sol, com custo médio de US$ 3,96 por tarefa.

Eu o usaria como ponto de partida para:

- implementar funcionalidades;
- corrigir bugs;
- criar integrações;
- modificar vários arquivos;
- trabalhar em bases existentes;
- realizar refatorações de complexidade moderada.

Terra ocupa o espaço entre economia e capacidade. Ele tende a ser uma escolha
mais adequada para a frequência alta do desenvolvimento diário, quando pagar o
maior custo em toda execução não produz retorno proporcional.

Um perfil padrão não precisa vencer todos os benchmarks. Precisa oferecer uma
relação consistente entre resultado, custo e quantidade de uso.

### Sol: capacidade máxima para tarefas críticas

Sol lidera esta comparação com 73%, mas custa US$ 8,39 por tarefa. Eu o acionaria
deliberadamente em situações como:

- bugs difíceis de reproduzir;
- alterações arquiteturais;
- grandes refatorações;
- migrações;
- mudanças em componentes críticos;
- tarefas com alto custo de falha;
- problemas que não avançaram com perfis menores.

Uma diferença pequena na taxa de conclusão pode justificar o custo quando uma
implementação incorreta exige horas de revisão, interrompe uma operação ou
introduz um problema difícil de detectar.

O risco está em transformar essa exceção em padrão. Usar Sol em toda alteração
simples aumenta o custo sem necessariamente melhorar o resultado.

## O benchmark não conta toda a história

O DeepSWE utiliza um harness comum, o `mini-swe-agent`, com tarefas e condições
padronizadas. Os agentes trabalham principalmente com acesso a Bash, o que
permite comparar os resultados em uma base comum.

Essa padronização é uma vantagem para o benchmark, mas deixa de fora parte do
contexto de um projeto real. No meu uso do Codex, um agente pode receber:

- arquivos `AGENTS.md`;
- skills específicas;
- instruções por repositório;
- ferramentas auxiliares;
- convenções de arquitetura;
- comandos de validação;
- documentação do domínio;
- diferentes níveis de raciocínio.

Esses elementos podem mudar bastante o resultado. Um perfil menor, com contexto
bem estruturado e validações disponíveis, pode superar um perfil maior que
trabalha sem orientação suficiente. Da mesma forma, um perfil avançado não
corrige sozinho um projeto sem testes, documentação ou critérios claros de
conclusão.

O benchmark mede a capacidade relativa sob uma configuração controlada. A
configuração do projeto determina quanto dessa capacidade será aproveitada.

## Uma política simples de escolha

Minha regra de partida, orientada pelo custo observado nesta comparação, é:

> Luna para explorar. Terra para executar. Sol para destravar.

Uma tarefa pode começar em Luna. Se a implementação não avançar, ela pode migrar
para Terra. Se o problema persistir ou envolver uma decisão crítica, Sol passa a
ser uma alternativa justificável.

Esse escalonamento evita pagar pelo maior perfil antes de entender o problema.
Também cria um sinal operacional: a frequência com que uma tarefa precisa subir
de perfil mostra onde o projeto pode estar mal documentado, sem testes ou com
uma complexidade maior do que a estimada.

Essa é uma política minha, não o padrão universal do Codex. Eu a trataria como
hipótese até comparar os modelos e os níveis de esforço em tarefas reais do
próprio repositório.

## Transformando a escolha em uma decisão de engenharia

Antes de iniciar uma tarefa, eu faria estas perguntas:

1. O trabalho é exploratório ou vai diretamente para produção?
2. A tarefa envolve arquitetura, migração ou múltiplos componentes?
3. O repositório possui testes confiáveis e comandos claros de validação?
4. Qual é o custo de uma implementação incorreta?
5. A tarefa será executada muitas vezes ou apenas uma vez?
6. O agente precisará modificar poucos arquivos ou uma parte extensa do sistema?

As respostas orientam o ponto de partida:

| Situação | Perfil inicial | Motivo |
| --- | --- | --- |
| Exploração, documentação e tarefas repetitivas | Luna | Mais tentativas com baixo custo |
| Funcionalidades, bugs e manutenção cotidiana | Terra | Equilíbrio entre capacidade e custo |
| Arquitetura, migração e alto risco | Sol | Maior chance de concluir uma tarefa crítica |

Essa política não precisa ser fixa. Eu registraria perfil utilizado, custo,
resultado da validação e necessidade de revisão. Depois de algumas tarefas, esses
dados permitem ajustar os limites com base no próprio projeto.

## Conclusão

O DeepSWE não responde sozinho qual perfil devemos usar. Ele oferece uma
referência externa para comparar capacidade e custo, enquanto o contexto do
projeto define quanto dessa capacidade é necessária.

Com os resultados observados, Terra é minha hipótese inicial para o trabalho
cotidiano quando o custo pesa na decisão. Luna pode fazer mais sentido para
exploração, volume e tarefas de baixo risco. Sol continua disponível para
complexidade, bloqueios e consequências que justifiquem o custo adicional.

Se eu estivesse iniciando um projeto hoje com essa política de custo, testaria
Terra como ponto de partida, encaminharia tarefas exploratórias para Luna e
escalaria para Sol quando os testes, o risco ou a complexidade mostrassem essa
necessidade. Outra equipe pode começar por Sol e reduzir modelo ou esforço
depois. O próximo passo seria medir custo e resultado no próprio repositório,
porque é essa evidência que transforma o benchmark em uma decisão útil.
