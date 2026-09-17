# Um número correto ainda pode contar a história errada em tecnologia

Published: 2026-08-13
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/numeros-nao-mentem/
Tags: Métricas, Observabilidade, Engenharia de Software, Inteligência Artificial, Análise de dados

---

Hoje li **“Números não mentem”** na camiseta de uma pessoa na rua.

Continuei andando, mas a frase ficou comigo.

Porque não é bem assim.

Talvez números não mintam sozinhos. Mas **a forma como escolhemos, recortamos, agrupamos e apresentamos números pode contar histórias completamente diferentes**.

Em tecnologia, isso acontece o tempo todo.

“Reduzimos os incidentes em 40%.”

Ótimo. Mas o sistema ficou melhor ou mudamos o que classificamos como incidente?

“A disponibilidade foi de 99,9%.”

Parece excelente. Mas 99,9% de quê? Da API? Da página inicial? Do fluxo que realmente gera receita? Durante qual período?

“A nova versão ficou 30% mais rápida.”

Em qual cenário? Com qual volume de dados? Na média ou no percentil 95? No notebook do desenvolvedor ou em produção?

“Nosso agente de IA acertou 92% dos casos.”

Essa é uma das minhas favoritas atualmente.

92% de qual dataset? Quantos exemplos havia? Os casos difíceis estavam incluídos? O conjunto de avaliação vazou para o treinamento? O que significa “acertar”?

E, principalmente: **o que aconteceu nos outros 8%?**

## O número pode estar correto e a conclusão errada

Esse é o ponto mais perigoso.

Não precisamos falsificar uma métrica para induzir alguém ao erro. Podemos apresentar um número completamente verdadeiro e ainda assim levar a uma conclusão errada.

Imagine duas equipes.

A primeira fecha 100 tickets por semana. A segunda fecha 40.

Se olharmos apenas para a quantidade de tickets, a primeira parece muito mais produtiva.

Até descobrirmos que ela trabalha principalmente com ajustes simples, enquanto a segunda está removendo falhas estruturais que geravam centenas de tickets.

O número estava correto.

A interpretação estava incompleta.

## Métrica vira problema quando se transforma em objetivo

Existe outro fenômeno comum em engenharia.

Criamos uma métrica para representar algo importante. Depois começamos a perseguir a própria métrica.

Cobertura de testes é um exemplo clássico.

“Precisamos chegar a 90% de cobertura.”

De repente aparecem testes que executam linhas de código sem validar comportamentos relevantes.

A cobertura sobe.

A confiança no sistema, não necessariamente.

Quantidade de commits, story points entregues, pull requests, tickets fechados, linhas de código, tempo médio de resolução: todos podem ser indicadores úteis.

E todos podem se tornar métricas ruins quando deixam de ser **instrumentos de observação** e passam a ser **objetivos isolados**.

É a ideia da Lei de Goodhart:

> Quando uma medida vira alvo, ela tende a deixar de ser uma boa medida.

## Dashboards também contam histórias

Quem trabalha com observabilidade aprende isso rapidamente.

Um dashboard não é a realidade. É uma projeção dela.

Escolher média em vez de p95 muda a história.

Escolher uma janela de 24 horas em vez de 30 dias muda a história.

Excluir determinados erros muda a história.

Agrupar regiões muda a história.

Até a escala de um gráfico pode fazer um problema parecer gigantesco ou irrelevante.

Por isso, gosto de pensar que dashboards não são apenas ferramentas de visualização.

**São argumentos.**

Alguém escolheu quais sinais mostrar e como apresentá-los. Outros ficaram de fora, mesmo quando não houve qualquer intenção de manipular.

## Com IA isso ficou ainda mais importante

Estamos em uma fase em que praticamente todo produto de IA vem acompanhado de algum número.

“95% de precisão.”

“10x mais produtividade.”

“80% menos tempo.”

“Modelo 30% melhor.”

O número dá uma aparência de objetividade. Mas, sem contexto, pode dizer muito pouco.

Um benchmark pode indicar que um modelo é melhor em determinada avaliação. Isso não significa que seja melhor para o seu problema.

Um agente pode resolver 95 de 100 tarefas de um conjunto controlado. Mas talvez as cinco que falham sejam justamente aquelas capazes de cancelar uma cobrança, apagar dados ou mandar uma mensagem errada para um cliente.

Nesse caso, 95% pode ser excelente.

Ou completamente inaceitável.

Depende do sistema e, principalmente, do custo dos erros.

## O número mais importante muitas vezes está ao lado

Uma prática que tento aplicar é nunca olhar uma métrica importante sozinha.

Disponibilidade vem acompanhada de impacto.

Latência, de distribuição.

Produtividade, de qualidade.

Velocidade de entrega, de retrabalho.

Acurácia, de falsos positivos e falsos negativos.

Custo, do valor produzido.

Métricas isoladas criam conforto.

Métricas relacionadas criam contexto.

## Então números mentem?

Talvez a frase da camiseta ainda esteja tecnicamente correta.

Números não têm intenção. Eles não mentem.

**Nós podemos mentir com números.**

Às vezes deliberadamente. Na maioria das vezes, nem isso.

Apenas simplificamos demais.

Escolhemos uma métrica porque cabe no dashboard. Colocamos uma porcentagem no slide porque parece objetiva. Comparamos valores que não representam exatamente a mesma coisa.

E, aos poucos, uma aproximação passa a ser tratada como realidade.

Em tecnologia, talvez as duas perguntas mais úteis diante de qualquer número sejam:

**“O que exatamente esse número está medindo?”**

**“O que ele não está mostrando?”**

Sem essas perguntas, 99,9%, 92%, 30% ou 10x podem significar quase qualquer coisa.
