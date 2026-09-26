# Software agêntico também precisa de quem cuide

Published: 2026-08-29
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/software-agentico-tambem-precisa-de-quem-cuide/
Tags: Agentes de IA, Engenharia de Software, Desenvolvimento agêntico, Qualidade de Software, Inteligência Artificial

---

Estava terminando *O Diário do Meu Pai*, de Jiro Taniguchi, quando parei numa
página sobre a produção de saquê.

Um personagem diz:

> “Preste atenção. O saquê é que nem gente. Não tem como virar um bom saquê se
> não tiver alguém pra criá-lo com dedicação.”

Na página anterior, o saquê já havia sido comparado a um ser vivo. A frase faz
sentido dentro da história, mas continuei pensando nela depois.

E, inevitavelmente, pensei em software. Mais especificamente, nesse novo jeito
de desenvolver com agentes de IA.

<figure>
  <img src="/assets/images/software-agentico-cuidado.jpg" alt="Página de O Diário do Meu Pai com personagens acompanhando grandes tonéis de saquê." width="1024" height="1365" loading="lazy" decoding="async">
  <figcaption>A página que iniciou a associação entre o cuidado na produção do saquê e no desenvolvimento de software.</figcaption>
</figure>

## A velocidade favorece o próximo passo

Estamos ficando muito bons em produzir coisas rapidamente. Você descreve uma
funcionalidade e o agente implementa. Aparece um erro e ele corrige. Falta uma
tela e ele cria. Um teste quebra e ele tenta novamente.

O ritmo é impressionante. Justamente por isso, aparece uma tentação nova:
transformar o desenvolvimento numa sequência de **next, next, next**.

O resultado apareceu, o teste passou, a execução terminou e seguimos adiante.

Só que produzir software nunca foi apenas fazer a próxima coisa aparecer. O
loop pode avançar depressa sem que nenhuma etapa verifique se as mudanças
continuam formando um sistema coerente.

Uma abstração que não precisava existir.

Uma dependência adicionada porque resolveu o problema daquele momento.

Uma pequena duplicação aqui.

Uma exceção ali.

Um teste que confirma a implementação, mas não o comportamento esperado.

Uma decisão arquitetural tomada quase por acidente durante uma sequência de
prompts.

Cada mudança pode parecer aceitável quando vista sozinha. Minha interpretação é
que o risco está no acúmulo: o sistema começa a perder coerência antes que exista
um grande erro capaz de interromper o fluxo.

## A engenharia muda de lugar

Tenho pensado cada vez mais que usar agentes no desenvolvimento não significa
terceirizar a engenharia. Significa deslocar parte dela.

Menos tempo digitando implementação.

Mais tempo observando, avaliando, restringindo, testando, escolhendo e
corrigindo a direção.

Quando o agente produz boa parte do código, alguém ainda precisa avaliar se a
solução ficou mais simples ou mais complicada, se uma decisão combina com as
anteriores e se o comportamento entregue corresponde ao problema original.

Não é necessário mexer em cada linha. É necessário manter responsabilidade
sobre aquilo que entra no sistema.

## Antes do próximo *next*

Em fluxos de desenvolvimento agêntico, eu usaria a pausa entre uma entrega e a
seguinte para verificar quatro coisas:

1. comparar o comportamento entregue com o problema que deveria ser resolvido;
2. revisar abstrações, dependências, duplicações e exceções introduzidas;
3. conferir a decisão com os limites e as convenções já adotados no sistema;
4. confirmar se o conjunto ainda segue na direção planejada, não apenas se a
   última tarefa terminou.

Essa revisão não precisa ter o mesmo peso para toda mudança. Uma alteração
pequena e fácil de reverter admite uma inspeção mais leve. Quanto maior o
impacto e o custo de correção posterior, mais atenção eu colocaria antes de
aceitar o resultado e seguir.

Podemos automatizar cada vez mais a produção. A responsabilidade por coerência,
limites e direção continua com quem decide incorporar a mudança.

Antes de mais um **next**, alguém ainda precisa cuidar.

## Referência

- TANIGUCHI, Jiro. *O Diário do Meu Pai*. Pipoca & Nanquim, 2024.
