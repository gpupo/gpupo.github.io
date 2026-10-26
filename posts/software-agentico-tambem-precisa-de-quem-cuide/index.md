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




<section class="editorial-carousel" data-editorial-carousel aria-roledescription="carrossel" aria-labelledby="software-agentico-cuidado-title">
  <h2 id="software-agentico-cuidado-title">Antes do próximo next, em quatro quadros</h2>
  <p>Artes em colagem editorial geradas com IA a partir deste ensaio.</p>
  <p class="editorial-carousel__hint">Deslize para acompanhar os quadros. Com o carrossel em foco, use as setas do teclado.</p>
  <div class="editorial-carousel__viewport" id="software-agentico-cuidado-slides" data-carousel-viewport tabindex="0" role="group" aria-label="Quadros do carrossel">
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="1 de 4">
      <a href="/assets/images/carousels/software-agentico-cuidado/01.webp" title="Abrir quadro 1 em tamanho original">
        <img src="/assets/images/carousels/software-agentico-cuidado/01.webp" alt="Software agêntico também precisa de quem cuide. Agentes aceleram a produção de código. Coerência, complexidade e direção ainda pedem atenção. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 1 de 4 · Software agêntico também precisa de quem cuide</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="2 de 4">
      <a href="/assets/images/carousels/software-agentico-cuidado/02.webp" title="Abrir quadro 2 em tamanho original">
        <img src="/assets/images/carousels/software-agentico-cuidado/02.webp" alt="O próximo passo pode esconder o acúmulo. Uma dependência aqui. Uma duplicação ali. Cada mudança parece aceitável, mas o conjunto pode perder coerência. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 2 de 4 · O próximo passo pode esconder o acúmulo</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="3 de 4">
      <a href="/assets/images/carousels/software-agentico-cuidado/03.webp" title="Abrir quadro 3 em tamanho original">
        <img src="/assets/images/carousels/software-agentico-cuidado/03.webp" alt="A engenharia muda de lugar. Menos tempo digitando implementação. Mais tempo avaliando, testando e corrigindo a direção. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 3 de 4 · A engenharia muda de lugar</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="4 de 4">
      <a href="/assets/images/carousels/software-agentico-cuidado/04.webp" title="Abrir quadro 4 em tamanho original">
        <img src="/assets/images/carousels/software-agentico-cuidado/04.webp" alt="Antes do próximo next. Confira o comportamento, a complexidade, os limites e a direção.  Alguém ainda precisa cuidar.  Leia em gpupo.com. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 4 de 4 · Antes do próximo next</figcaption>
    </figure>
    
  </div>
  <div class="editorial-carousel__controls" data-carousel-controls hidden>
    <button class="btn" type="button" data-carousel-previous aria-controls="software-agentico-cuidado-slides" aria-label="Quadro anterior" disabled><span aria-hidden="true">←</span> Anterior</button>
    <span class="editorial-carousel__status" data-carousel-status role="status" aria-live="polite" aria-atomic="true">1 de 4</span>
    <button class="btn" type="button" data-carousel-next aria-controls="software-agentico-cuidado-slides" aria-label="Próximo quadro">Próximo <span aria-hidden="true">→</span></button>
  </div>
  <details class="editorial-carousel__transcript">
    <summary>Ler o texto dos quadros</summary>
    <ol>
      <li><p>Software agêntico também precisa de quem cuide<br />
<br />
Agentes aceleram a produção de código. Coerência, complexidade e direção ainda pedem atenção.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>O próximo passo pode esconder o acúmulo<br />
<br />
Uma dependência aqui. Uma duplicação ali. Cada mudança parece aceitável, mas o conjunto pode perder coerência.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>A engenharia muda de lugar<br />
<br />
Menos tempo digitando implementação. Mais tempo avaliando, testando e corrigindo a direção.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>Antes do próximo next<br />
<br />
Confira o comportamento, a complexidade, os limites e a direção.<br />
<br />
Alguém ainda precisa cuidar.<br />
<br />
Leia em gpupo.com.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
    </ol>
  </details>
</section>
<script src="/assets/js/editorial-carousel.js" defer></script>
