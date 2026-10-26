# Todo agente acorda com amnésia

Published: 2026-10-01
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/todo-agente-acorda-com-amnesia/
Tags: Agentes de IA, Gestão de contexto, AGENTS.md, Skills, Documentação

---

Uma maneira útil de pensar em agentes de IA é assumir uma regra simples:

**todo agente acorda com amnésia.**

Essa é uma regra de arquitetura, não uma descrição literal de todas as
plataformas. Há sistemas capazes de preservar o estado de uma sessão e retomá-la
depois. A
[documentação da Agents API da OpenAI](https://developers.openai.com/api/docs/guides/agents-api/overview),
por exemplo, descreve sessões duráveis, retomada e compactação automática do
contexto.

Ainda assim, não quero que a continuidade de um projeto dependa apenas desse
estado. Uma sessão pode ser encerrada, resumida ou substituída. O trabalho
importante precisa continuar compreensível fora dela.

Você pode ter passado horas trabalhando com um agente ontem. Pode ter explicado
regras, corrigido decisões, mostrado exemplos e finalmente chegado a um
resultado excelente.

Hoje, ao iniciar outra sessão, não deveria depender da esperança de que ele
“lembre”.

O que realmente importa precisa estar no projeto.

## Sessão não é projeto

Uma sessão é um espaço de trabalho. Ela acumula contexto, cresce e pode até
continuar disponível por algum tempo. O projeto precisa sobreviver quando essa
sessão não estiver mais acessível ou quando parte de seu conteúdo tiver sido
resumida.

Por isso gosto de imaginar um agente não como uma conversa, mas como um
diretório:

```text
meu-agente/
├── AGENTS.md
├── skills/
├── knowledge/
├── templates/
├── decisions/
└── output/
```

Quando começa a trabalhar, o agente pode reencontrar instruções, conhecimentos,
exemplos, decisões e resultados anteriores.

O modelo fornece a capacidade geral. O projeto fornece continuidade.

## O perigo da memória da conversa

Enquanto uma sessão está funcionando bem, é fácil acreditar que aquele
conhecimento foi incorporado ao agente.

Não necessariamente.

Uma regra importante pode existir apenas em uma mensagem enviada horas atrás.
Uma decisão pode estar escondida no meio de uma conversa extensa. Um detalhe
que fez o resultado funcionar pode desaparecer de vista quando o contexto for
resumido.

Por isso, sempre que algo se torna importante, vale fazer uma pergunta:

> **Isso está apenas na conversa ou já virou parte do projeto?**

Se a resposta for “só está na conversa”, existe uma pendência. A informação
ainda precisa encontrar um lugar durável e coerente com sua função.

## Persistir o que aprendemos

O destino depende do tipo de aprendizado.

Quando descobrimos uma regra estável para trabalhar no repositório, podemos
registrá-la no [`AGENTS.md`](/artigos/agents-md-nao-e-um-readme/).

Quando descobrimos um procedimento recorrente, com entradas e resultado
reconhecíveis, podemos transformá-lo em uma skill.

Quando produzimos um bom exemplo, podemos mantê-lo entre os artefatos de
referência. Quando tomamos uma decisão importante, podemos registrar o contexto,
as alternativas e as consequências em `decisions/` ou na documentação
equivalente do projeto.

Nem todo conteúdo precisa entrar no Git. Segredos não devem ser registrados, e
saídas geradas só precisam ser preservadas quando servirem de entrada futura,
evidência ou objeto de auditoria. O critério não é guardar tudo; é tornar
reencontrável aquilo de que o próximo trabalho depende.

O agente não precisa lembrar do que aconteceu. Ele precisa conseguir
**reencontrar o que importa**.

## Handoff é uma troca de turno

Para trabalhos mais longos, existe uma técnica simples: o handoff.

Antes de encerrar uma sessão, registramos:

- o que foi feito;
- quais decisões foram tomadas;
- onde estão os arquivos;
- quais verificações já foram executadas;
- o que ainda falta;
- quais problemas continuam abertos.

Na próxima sessão, começamos pelo handoff e confirmamos se ele ainda corresponde
ao estado real do projeto.

```text
sessão 1
   ↓
handoff.md
   ↓
sessão 2
   ↓
handoff.md
   ↓
sessão 3
```

O `handoff.md` não precisa acumular toda a história. Ele pode representar o
estado atual: trabalho concluído, próxima ação e riscos conhecidos. O histórico
fica no Git, seguindo a mesma lógica dos
[checkpoints do projeto](/posts/versionar-e-criar-checkpoints/).

Essa separação reduz um risco: um handoff que apenas cresce acaba se tornando
outra conversa longa, difícil de consultar e fácil de contradizer. Para ser
útil, ele precisa ser atualizado quando o estado muda e remover pendências que
já foram resolvidas.

Não é uma memória sofisticada. É justamente o contrário: uma solução simples,
barata e previsível.

## Sessões são descartáveis

Essa mudança de mentalidade altera o que tratamos como patrimônio.

A sessão não é o patrimônio. O patrimônio é:

```text
instruções
conhecimento
skills
artefatos
decisões
histórico
```

Tudo isso deve existir de uma forma que possa ser lida novamente por outra
sessão e, quando for uma exigência do projeto, por outro modelo.

Essa portabilidade não é automática. Uma skill pode depender de uma ferramenta
específica, e diferentes agentes interpretam instruções de maneiras diferentes.
Mesmo assim, arquivos legíveis, formatos abertos, critérios explícitos e testes
reduzem o que fica preso a uma única conversa ou plataforma.

A sessão pode acabar. O projeto continua.

## A pergunta certa

Em vez de perguntar:

> **Como faço para o agente lembrar de tudo?**

talvez seja melhor perguntar:

> **O que ele precisa encontrar quando acordar amanhã?**

A segunda pergunta leva a uma arquitetura mais simples. Ela direciona regras
para instruções, procedimentos para skills, decisões para documentos e estado
corrente para um handoff verificável.

Todo agente pode acordar com amnésia.

O problema começa quando deixamos o conhecimento importante dormir apenas
dentro da sessão.




<section class="editorial-carousel" data-editorial-carousel aria-roledescription="carrossel" aria-labelledby="todo-agente-acorda-com-amnesia-title">
  <h2 id="todo-agente-acorda-com-amnesia-title">O que fica para a próxima sessão</h2>
  <p>Artes em colagem editorial geradas com IA a partir deste ensaio.</p>
  <p class="editorial-carousel__hint">Deslize para acompanhar os quadros. Com o carrossel em foco, use as setas do teclado.</p>
  <div class="editorial-carousel__viewport" id="todo-agente-acorda-com-amnesia-slides" data-carousel-viewport tabindex="0" role="group" aria-label="Quadros do carrossel">
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="1 de 4">
      <a href="/assets/images/carousels/todo-agente-acorda-com-amnesia/01.webp" title="Abrir quadro 1 em tamanho original">
        <img src="/assets/images/carousels/todo-agente-acorda-com-amnesia/01.webp" alt="Todo agente acorda com amnésia. Pense nisso como uma regra de arquitetura: o trabalho importante precisa continuar compreensível fora da conversa. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 1 de 4 · Todo agente acorda com amnésia</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="2 de 4">
      <a href="/assets/images/carousels/todo-agente-acorda-com-amnesia/02.webp" title="Abrir quadro 2 em tamanho original">
        <img src="/assets/images/carousels/todo-agente-acorda-com-amnesia/02.webp" alt="A sessão acaba. O projeto continua.. Uma sessão pode ser encerrada, resumida ou substituída. Regras e decisões precisam de um lugar durável. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 2 de 4 · A sessão acaba. O projeto continua.</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="3 de 4">
      <a href="/assets/images/carousels/todo-agente-acorda-com-amnesia/03.webp" title="Abrir quadro 3 em tamanho original">
        <img src="/assets/images/carousels/todo-agente-acorda-com-amnesia/03.webp" alt="Registre onde faz sentido. Regras no AGENTS.md. Procedimentos em skills. Decisões na documentação.  O agente precisa reencontrar o que importa. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 3 de 4 · Registre onde faz sentido</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="4 de 4">
      <a href="/assets/images/carousels/todo-agente-acorda-com-amnesia/04.webp" title="Abrir quadro 4 em tamanho original">
        <img src="/assets/images/carousels/todo-agente-acorda-com-amnesia/04.webp" alt="O que ele precisa encontrar amanhã?. Um handoff atualizado: o que foi feito, decisões, arquivos, verificações, pendências e próxima ação.  Leia em gpupo.com. Colagem ilustrativa de papel em azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 4 de 4 · O que ele precisa encontrar amanhã?</figcaption>
    </figure>
    
  </div>
  <div class="editorial-carousel__controls" data-carousel-controls hidden>
    <button class="btn" type="button" data-carousel-previous aria-controls="todo-agente-acorda-com-amnesia-slides" aria-label="Quadro anterior" disabled><span aria-hidden="true">←</span> Anterior</button>
    <span class="editorial-carousel__status" data-carousel-status role="status" aria-live="polite" aria-atomic="true">1 de 4</span>
    <button class="btn" type="button" data-carousel-next aria-controls="todo-agente-acorda-com-amnesia-slides" aria-label="Próximo quadro">Próximo <span aria-hidden="true">→</span></button>
  </div>
  <details class="editorial-carousel__transcript">
    <summary>Ler o texto dos quadros</summary>
    <ol>
      <li><p>Todo agente acorda com amnésia<br />
<br />
Pense nisso como uma regra de arquitetura: o trabalho importante precisa continuar compreensível fora da conversa.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>A sessão acaba. O projeto continua.<br />
<br />
Uma sessão pode ser encerrada, resumida ou substituída. Regras e decisões precisam de um lugar durável.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>Registre onde faz sentido<br />
<br />
Regras no AGENTS.md. Procedimentos em skills. Decisões na documentação.<br />
<br />
O agente precisa reencontrar o que importa.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>O que ele precisa encontrar amanhã?<br />
<br />
Um handoff atualizado: o que foi feito, decisões, arquivos, verificações, pendências e próxima ação.<br />
<br />
Leia em gpupo.com.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
    </ol>
  </details>
</section>
<script src="/assets/js/editorial-carousel.js" defer></script>
