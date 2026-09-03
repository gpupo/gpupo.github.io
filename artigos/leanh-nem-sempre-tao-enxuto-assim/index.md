# Lean pode virar desperdício quando começa pela ferramenta

Published: 2024-04-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/leanh-nem-sempre-tao-enxuto-assim/
Tags: Produto, Lean

---

Uma empresa decide “implantar Lean” e começa por treinamentos, quadros, novos
rituais e uma lista de desperdícios. Meses depois, a operação produz mais
relatórios, mas o tempo de espera do cliente continua igual.

O problema não demonstra que Lean falhou. Ele mostra que a iniciativa adicionou
um sistema de gestão sem provar qual obstáculo deveria remover.

Se a adoção começa pela ferramenta, o esforço para parecer Lean pode se tornar o
próprio desperdício.

## Lean não é um estágio de maturidade

A versão anterior deste texto separava empresas “menos avançadas”, que poderiam
usar comparação e benchmarking, de empresas “avançadas”, que precisariam de um
método dinâmico chamado Lean. Essa classificação não tem base suficiente.

Lean não é reservado a organizações que já esgotaram melhorias simples. O Lean
Enterprise Institute o define como uma forma de pensar e uma prática voltadas a
criar o valor necessário com menos recursos e desperdício, por meio de
experimentação contínua. A definição começa pelo problema do cliente e pelo
trabalho que produz valor. ([definição de Lean do Lean Enterprise
Institute](https://www.lean.org/explore-lean/what-is-lean/))

Isso pode ser útil em operações pouco estruturadas ou maduras, mas a intervenção
precisa respeitar o contexto. Uma equipe sem dados confiáveis talvez precise
primeiro tornar o trabalho visível. Uma operação regulada pode exigir controles
que parecem espera ou redundância, mas reduzem um risco material. Uma atividade
de descoberta não deveria ser otimizada como se a demanda e a solução já fossem
estáveis.

O ponto de partida não é o suposto nível de maturidade. É o problema observável.

## Defina valor antes de eliminar desperdício

Remover etapas sem entender quem recebe o resultado cria eficiência local e
piora o sistema. Um atendimento pode reduzir sua duração transferindo casos
difíceis para outra fila. Uma equipe de software pode aumentar entregas deixando
testes e incidentes para operações. O indicador local melhora; o cliente espera
mais.

Antes de mapear o fluxo, eu registraria:

- quem recebe o produto ou serviço;
- qual necessidade deve ser atendida;
- onde o fluxo começa e termina;
- quais condições de qualidade e segurança são obrigatórias;
- qual problema foi observado;
- qual medida mostrará melhoria e qual evitará efeitos adversos.

O Lean Enterprise Institute descreve cinco princípios: especificar valor,
identificar o fluxo de valor, criar fluxo, permitir que a demanda puxe o trabalho
e perseguir melhoria contínua. Eles orientam o raciocínio, mas não determinam
qual ferramenta usar em cada situação. ([princípios do pensamento
Lean](https://www.lean.org/lexicon-terms/lean-thinking-and-practice/))

## Benchmarking mostra diferença, não explica a causa

Comparar unidades, períodos ou organizações pode revelar uma lacuna. Se uma
equipe resolve solicitações em dois dias e outra leva dez, existe uma diferença
que merece investigação.

Ainda não sabemos por quê.

Volume, complexidade, perfil dos casos, capacidade, regras e qualidade dos dados
podem ser diferentes. Copiar a prática da unidade mais rápida pressupõe que ela
causou o resultado e que o contexto é comparável. O benchmark ajuda a formular
uma pergunta; observação e experimento ajudam a responder.

Eu usaria a comparação desta forma:

1. confirme que as métricas têm a mesma definição;
2. segmente a demanda e a complexidade;
3. observe o trabalho onde ele acontece;
4. localize fila, retrabalho, transferência ou falta de capacidade;
5. formule uma hipótese sobre a causa;
6. teste uma mudança limitada;
7. compare resultado e contramedidas.

Isso é mais lento do que copiar uma “boa prática”, porém reduz o risco de
padronizar a solução errada.

## Observe o fluxo inteiro

Um mapa de fluxo de valor deveria tornar visíveis trabalho, espera, estoque,
informação e retorno por defeito. Ele não precisa começar como um diagrama
complexo. Uma tabela já pode ser suficiente:

| Etapa | Tempo de trabalho | Tempo de espera | Estoque | Erro ou retorno |
| --- | --- | --- | --- | --- |
| Receber | medir | medir | contar | classificar |
| Analisar | medir | medir | contar | classificar |
| Executar | medir | medir | contar | classificar |
| Validar | medir | medir | contar | classificar |

“Medir” não significa inventar precisão. Se os sistemas não registram os tempos,
comece com uma amostra identificada e declare a limitação. O objetivo inicial é
descobrir onde uma investigação melhor produzirá uma decisão, não criar um
dashboard definitivo.

Métricas úteis dependem do processo, mas costumam incluir:

- tempo total entre demanda e entrega;
- tempo efetivamente trabalhado;
- itens em andamento;
- taxa de defeito, retorno ou reabertura;
- variação de demanda e capacidade;
- qualidade ou resultado percebido pelo destinatário.

Otimizar apenas utilização pode aumentar filas. Reduzir estoque pode fragilizar
uma operação exposta a fornecimento instável. Cada medida precisa ser lida junto
com suas consequências.

## Just-in-Time não significa operar sem proteção

O Sistema Toyota de Produção é sustentado por *jidoka* e Just-in-Time. Na
descrição da própria Toyota, *jidoka* envolve detectar anormalidades e interromper
o processo para evitar defeitos; Just-in-Time sincroniza a produção para fazer o
necessário, no momento e na quantidade necessários. A empresa também descreve o
objetivo de facilitar o trabalho das pessoas, reduzir desperdício e encurtar o
lead time. ([Sistema Toyota de Produção, fonte
oficial](https://global.toyota/en/company/vision-and-philosophy/production-system/))

Essa origem industrial não autoriza copiar estoque mínimo, kanban ou andon para
qualquer ambiente. A Toyota descreve um sistema de práticas que funcionam em
conjunto. Retirar capacidade de proteção sem melhorar qualidade, detecção de
falhas e reposição pode apenas tornar a operação mais vulnerável.

Em software, por exemplo, limitar trabalho em andamento pode expor bloqueios.
Mas, se prioridades mudam diariamente e ninguém resolve dependências, o quadro
apenas documenta a fila.

## Um experimento de melhoria precisa de condição de parada

Uma mudança Lean pode ser registrada de forma simples:

```yaml
problema_observado: solicitações aguardam validação por vários dias
hipotese: o lote semanal concentra trabalho e aumenta a espera
mudanca: validar diariamente uma categoria de baixo risco
medida_principal: tempo entre conclusão e validação
contramedidas:
  - erros não detectados
  - interrupções da pessoa validadora
escopo: uma categoria durante um ciclo definido
decisao: ampliar, adaptar ou reverter
```

O exemplo não relata um resultado real. Ele mostra como limitar a mudança e
deixar explícito o que poderia invalidá-la.

Sem prazo de revisão e critério de parada, um piloto pode virar processo
permanente por inércia. Sem contramedidas, a equipe pode deslocar o problema para
outra parte do fluxo.

## Sinais de que a iniciativa está produzindo mais gestão do que melhoria

Eu revisaria a adoção quando:

- o treinamento acontece antes de existir um problema escolhido;
- a conformidade com a ferramenta vale mais que o resultado;
- indicadores locais melhoram enquanto o tempo total piora;
- pessoas escondem anormalidades porque interromper o fluxo é punido;
- “eliminar desperdício” vira sinônimo de cortar capacidade sem redesenhar o
  trabalho;
- rituais continuam mesmo sem apoiar uma decisão;
- a equipe não consegue explicar qual hipótese está testando.

Lean exige disciplina e pode demandar investimento em medição, capacitação,
qualidade e segurança. Portanto, não é automaticamente barato ou simples. A
pergunta útil não é se a empresa está madura o bastante para “implantar Lean”,
mas se existe um problema importante, um fluxo que pode ser observado e
autoridade para mudar o sistema com segurança.

Se essas condições não existem, eu não começaria por um programa. Começaria por
um problema delimitado, acompanharia o trabalho real e testaria a menor mudança
capaz de melhorar o fluxo sem transferir o custo para outra pessoa.
