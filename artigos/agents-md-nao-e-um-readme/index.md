# Como o AGENTS.md orienta agentes dentro de um repositório

Published: 2026-08-14
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/agents-md-nao-e-um-readme/
Tags: Documentação para agentes, Agentes de IA, Engenharia de Software, Documentação, Governança, Inteligência Artificial

---

Quanto mais trabalho com agentes de IA escrevendo código, mais percebo que
estamos vendo surgir uma peça nova na arquitetura dos repositórios: o
`AGENTS.md`.

Muita gente ainda olha para esse arquivo como uma espécie de README para
inteligência artificial. Eu prefiro pensar nele de outra forma.

Um `README.md` explica o projeto para uma pessoa.

Um `AGENTS.md` ensina um agente a trabalhar dentro daquele projeto.

A diferença parece pequena, mas muda bastante o papel desse arquivo.

## README explica. AGENTS orienta.

O README continua fazendo bem o que sempre fez:

* explica o propósito do projeto;
* mostra como instalar e executar;
* apresenta a arquitetura;
* ajuda novos contribuidores.

O `AGENTS.md` pode assumir outra responsabilidade. Ele pode responder perguntas
operacionais:

* O que o agente deve ler antes de começar?
* Quais documentos são fontes canônicas?
* Que partes do repositório podem ser modificadas?
* Quais padrões arquiteturais devem ser preservados?
* Que comandos precisam ser executados?
* Como validar a mudança?
* O que precisa ser limpo antes de terminar?
* Quando é necessário pedir aprovação humana?

Nesse papel, o arquivo funciona como um **bootstrap comportamental**: prepara o
agente para operar naquele ambiente antes de começar a modificar o código.

## O agente pode começar cada tarefa da maneira certa

Quando entramos em um projeto desconhecido, normalmente abrimos o README,
exploramos diretórios, lemos alguns arquivos e tentamos descobrir os padrões.

Talvez exista um ADR. Talvez haja uma wiki. Talvez algumas convenções estejam
apenas no código. E talvez alguém precise explicar pessoalmente o que nunca foi
documentado.

Com agentes, podemos tornar esse processo mais explícito:

```text
AGENTS.md
    ↓
Carregar governança
    ↓
Carregar padrões do projeto
    ↓
Carregar arquitetura e fontes canônicas
    ↓
Carregar instruções específicas do domínio
    ↓
Executar ferramentas necessárias
    ↓
Realizar o trabalho
    ↓
Validar
    ↓
Limpar
```

Gosto dessa ideia porque ela transforma contexto em algo que podemos projetar.

Em vez de esperar que o agente descubra sozinho como o projeto funciona,
podemos indicar por onde começar, quais fontes consultar e quais verificações
fazer.

## AGENTS.md não precisa saber tudo

O `AGENTS.md` não precisa virar um arquivo gigantesco contendo todo o
conhecimento do projeto. Na verdade, prefiro exatamente o contrário.

Ele pode funcionar como um pequeno roteador de contexto:

```text
Antes de modificar o projeto:

1. Leia docs/GOVERNANCE.md.
2. Leia docs/ARCHITECTURE.md.
3. Leia docs/ENGINEERING.md.
4. Se estiver trabalhando na API, leia docs/API.md.
5. Se alterar persistência, leia docs/DATA.md.
6. Execute scripts/project-check.sh.
```

O agente não recebe um manual de centenas de páginas para cada tarefa. Ele
aprende onde encontrar o conhecimento necessário.

Isso cria uma espécie de **árvore de contexto**: o agente carrega o que precisa
conforme o trabalho exige.

Além de reduzir contexto desnecessário, essa abordagem preserva
responsabilidades. Arquitetura continua em documentação de arquitetura.
Governança continua em governança. Instruções específicas permanecem próximas
de seus domínios.

O `AGENTS.md` conecta essas partes.

Dois exemplos dessa separação já aparecem em outros textos deste site. O
[`PRD.md` preserva problema, público, escopo e critérios de aceitação](/artigos/prd-md-contexto-produto-agentes-ia/), enquanto o
[`DESIGN.md` registra a memória visual e as decisões de interação](/artigos/design-md-memoria-visual-agentes-ia/).

O `AGENTS.md` não precisa copiar esses documentos. Ele pode determinar quando
cada um deve ser lido, qual deles prevalece em seu domínio e como validar se a
mudança respeitou suas decisões.

## Podemos tornar princípios de engenharia operacionais

Agentes são muito bons em gerar soluções. Às vezes, até bons demais.

Uma pequena tarefa pode rapidamente virar uma nova abstração, uma interface,
uma factory, três classes e uma proposta de refatoração completa.

Podemos tornar alguns princípios explícitos antes que o trabalho comece:

> Resolva o problema da forma mais simples compatível com a arquitetura
> existente.

> Não crie abstrações para necessidades hipotéticas.

> Prefira reutilizar estruturas existentes.

> Não transforme uma mudança pequena em uma grande refatoração sem necessidade.

Em outras palavras, podemos ensinar KISS ao agente como parte do seu modo de
operação.

O valor aqui não está em registrar um princípio abstrato de engenharia. Está em
fazer com que ele influencie as decisões tomadas durante uma tarefa.

## A higiene do repositório também pode fazer parte do trabalho

Quem usa agentes com frequência provavelmente já encontrou pequenas lembranças
deixadas pelo caminho:

* arquivos temporários;
* logs;
* scripts exploratórios;
* dumps;
* backups;
* documentos intermediários;
* artefatos usados apenas durante uma investigação.

Isoladamente, quase sempre são problemas pequenos. Acumulados ao longo de
centenas de tarefas, viram ruído.

A limpeza pode fazer parte da definição da tarefa:

```text
Antes de considerar a tarefa concluída:

- remova arquivos temporários;
- remova scripts exploratórios desnecessários;
- não deixe logs ou dumps no repositório;
- verifique git status;
- confirme que somente arquivos relacionados à tarefa foram modificados.
```

É quase como ensinar ao agente: **arrume a bancada depois de trabalhar.**

Uma regra simples, mas com efeito acumulado importante.

## Capacidade e autorização são coisas diferentes

À medida que agentes ficam mais capazes, precisamos distinguir duas perguntas:

**O agente consegue fazer isso?**

e

**O agente está autorizado a fazer isso?**

O `AGENTS.md` pode ajudar a tornar essa fronteira explícita:

```text
O agente pode:

- modificar código da aplicação;
- criar e atualizar testes;
- atualizar documentação relacionada.

O agente deve pedir aprovação antes de:

- alterar infraestrutura;
- remover APIs públicas;
- modificar schemas de produção;
- alterar autenticação;
- trocar dependências críticas.
```

Isso cria um espaço claro para autonomia.

Dentro dele, o agente pode trabalhar. Fora dele, precisa escalar a decisão.

Claro que instruções em um arquivo não substituem mecanismos reais de permissão
e segurança. Mas elas podem definir o comportamento esperado antes que esses
mecanismos precisem intervir.

## Também podemos definir o que significa "terminado"

Equipes humanas discutem **Definition of Done** há décadas. Para um agente,
podemos torná-la bastante explícita:

```text
Uma tarefa somente está concluída quando:

1. a implementação estiver terminada;
2. os testes relevantes passarem;
3. lint e análise estática passarem;
4. a alteração estiver consistente com a arquitetura;
5. nenhuma modificação não relacionada permanecer;
6. git status tiver sido revisado;
7. riscos ou limitações forem reportados.
```

Nesse modelo, escrever código é apenas uma parte do trabalho.

Entregar também significa validar, revisar e limpar.

Isso aproxima o comportamento do agente daquilo que normalmente esperamos de
um bom engenheiro.

## Uma nova camada começa a aparecer

Quando juntamos essas responsabilidades, surge uma camada interessante no
processo de desenvolvimento:

```text
Governança humana
      ↓
AGENTS.md
      ↓
Políticas e contexto
      ↓
Agente
      ↓
Código / Infra / Docs
      ↓
Validação automatizada
```

Já temos código governando aplicações, pipelines governando entregas e
políticas governando infraestrutura.

Agora começamos a criar artefatos que orientam os agentes que modificam tudo
isso.

Não vejo isso necessariamente como mais burocracia. Vejo como uma oportunidade
de transformar conhecimento tácito em instruções operacionais.

Aquilo que antes dependia de um desenvolvedor experiente explicar como as
coisas funcionam pode começar a ser registrado de forma reutilizável para
colaboradores humanos e artificiais.

## Documentação pode participar do fluxo de trabalho

Durante anos tivemos um problema recorrente.

Escrevemos ADRs. Criamos diagramas. Documentamos convenções. Montamos wikis.

Depois torcemos para que alguém encontre e leia tudo isso antes de implementar
uma mudança.

Com agentes, podemos conectar essas fontes diretamente ao fluxo de trabalho:

```text
ADR
   ↓
AGENTS.md referencia
   ↓
Agente carrega
   ↓
Decisão influencia implementação
   ↓
CI valida parte da decisão
```

A documentação deixa de ser apenas uma referência que alguém pode consultar e
passa a fazer parte do caminho que o agente percorre antes de executar uma
tarefa.

Isso não garante que uma decisão arquitetural será respeitada. Mas cria uma
conexão operacional que antes muitas vezes não existia.

## O repositório está ganhando um novo público

Durante décadas, pensamos em repositórios principalmente para dois
consumidores: máquinas e pessoas.

Código para máquinas.

README, documentação e comentários para pessoas.

Agora temos um terceiro consumidor importante: agentes de IA.

Isso nos obriga a pensar em uma nova interface:

```text
README.md       → humanos
AGENTS.md       → agentes
ADR / docs      → conhecimento canônico
CI/CD           → validação e enforcement
Código          → sistema executável
```

Não precisamos transformar o README em prompt. Também não precisamos colocar
toda a arquitetura dentro do `AGENTS.md`.

Podemos manter responsabilidades claras e criar boas interfaces entre essas
camadas.

## O comportamento esperado também pode ser versionado

Existe ainda uma propriedade importante: `AGENTS.md` é texto.

Pode ficar no Git. Pode passar por pull request. Pode receber code review. Pode
evoluir junto com a arquitetura.

Se uma regra importante mudar, as instruções dadas aos agentes podem mudar no
mesmo commit.

Com isso, começamos a versionar não apenas o software, mas também **a maneira
como esperamos que agentes trabalhem nesse software**.

Para mim, essa é uma das características mais interessantes desse modelo.

## Não é um arquivo mágico

Um `AGENTS.md` sozinho não substitui permissões, segurança, CI/CD ou revisão
humana.

Nem deveria.

Seu papel pode ser bem mais específico: **dar ao agente um bom ponto de partida
e explicitar como esperamos que ele trabalhe.**

As instruções orientam.

As ferramentas validam.

As permissões limitam.

A revisão humana supervisiona.

Essas camadas se complementam.

## Uma nova interface dentro da engenharia de software

Quanto mais trabalho dessa forma, menos vejo `AGENTS.md` como um arquivo
auxiliar.

Estamos começando a estruturar repositórios não apenas para que humanos
entendam o código, mas também para que agentes consigam operar neles de maneira
mais previsível e produtiva.

Podemos tornar princípios explícitos, conectar documentação à execução,
carregar contexto sob demanda, registrar limites de autonomia, automatizar
validações e transformar conhecimento tácito em conhecimento operacional.

Por isso, gosto de resumir assim:

`README.md` explica o projeto.

`AGENTS.md` ensina o agente a trabalhar nele.

Um apresenta o sistema.

O outro prepara o agente para colaborar com ele.

E talvez a parte mais interessante esteja justamente aí: não estamos apenas
ensinando agentes a escrever código. Estamos aprendendo a projetar ambientes em
que humanos e agentes consigam trabalhar melhor juntos.




<section class="editorial-carousel" data-editorial-carousel aria-roledescription="carrossel" aria-labelledby="agents-md-nao-e-um-readme-title">
  <h2 id="agents-md-nao-e-um-readme-title">Como o AGENTS.md orienta o trabalho</h2>
  <p>Artes em colagem editorial geradas com IA a partir deste artigo.</p>
  <p class="editorial-carousel__hint">Deslize para acompanhar os quadros. Com o carrossel em foco, use as setas do teclado.</p>
  <div class="editorial-carousel__viewport" id="agents-md-nao-e-um-readme-slides" data-carousel-viewport tabindex="0" role="group" aria-label="Quadros do carrossel">
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="1 de 5">
      <a href="/assets/images/carousels/agents-md-nao-e-um-readme/01.webp" title="Abrir quadro 1 em tamanho original">
        <img src="/assets/images/carousels/agents-md-nao-e-um-readme/01.webp" alt="README explica. AGENTS orienta.. O README apresenta o projeto. O AGENTS.md orienta como o agente deve trabalhar nele. Ilustração em colagem editorial de papel azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 1 de 5 · README explica. AGENTS orienta.</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="2 de 5">
      <a href="/assets/images/carousels/agents-md-nao-e-um-readme/02.webp" title="Abrir quadro 2 em tamanho original">
        <img src="/assets/images/carousels/agents-md-nao-e-um-readme/02.webp" alt="Um roteador de contexto. O AGENTS.md pode indicar o que ler e quando. Arquitetura, governança e regras de domínio continuam nas suas fontes. Ilustração em colagem editorial de papel azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 2 de 5 · Um roteador de contexto</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="3 de 5">
      <a href="/assets/images/carousels/agents-md-nao-e-um-readme/03.webp" title="Abrir quadro 3 em tamanho original">
        <img src="/assets/images/carousels/agents-md-nao-e-um-readme/03.webp" alt="Autonomia com limites. Defina o que o agente pode modificar e quando precisa pedir aprovação. Instruções não substituem permissões reais. Ilustração em colagem editorial de papel azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 3 de 5 · Autonomia com limites</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="4 de 5">
      <a href="/assets/images/carousels/agents-md-nao-e-um-readme/04.webp" title="Abrir quadro 4 em tamanho original">
        <img src="/assets/images/carousels/agents-md-nao-e-um-readme/04.webp" alt="O que significa terminado?. Implementar, validar, revisar e limpar. Testes relevantes, arquitetura respeitada e riscos reportados fazem parte da entrega. Ilustração em colagem editorial de papel azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 4 de 5 · O que significa terminado?</figcaption>
    </figure>
    
    <figure class="editorial-carousel__slide" role="group" aria-roledescription="quadro" aria-label="5 de 5">
      <a href="/assets/images/carousels/agents-md-nao-e-um-readme/05.webp" title="Abrir quadro 5 em tamanho original">
        <img src="/assets/images/carousels/agents-md-nao-e-um-readme/05.webp" alt="Cada camada tem seu papel. As instruções orientam. As ferramentas validam. As permissões limitam. A revisão humana supervisiona. Ilustração em colagem editorial de papel azul, verde e ocre." width="1080" height="1350" loading="lazy" decoding="async">
      </a>
      <figcaption>Quadro 5 de 5 · Cada camada tem seu papel</figcaption>
    </figure>
    
  </div>
  <div class="editorial-carousel__controls" data-carousel-controls hidden>
    <button class="btn" type="button" data-carousel-previous aria-controls="agents-md-nao-e-um-readme-slides" aria-label="Quadro anterior" disabled><span aria-hidden="true">←</span> Anterior</button>
    <span class="editorial-carousel__status" data-carousel-status role="status" aria-live="polite" aria-atomic="true">1 de 5</span>
    <button class="btn" type="button" data-carousel-next aria-controls="agents-md-nao-e-um-readme-slides" aria-label="Próximo quadro">Próximo <span aria-hidden="true">→</span></button>
  </div>
  <details class="editorial-carousel__transcript">
    <summary>Ler o texto dos quadros</summary>
    <ol>
      <li><p>README explica. AGENTS orienta.<br />
<br />
O README apresenta o projeto.<br />
O AGENTS.md orienta como o agente deve trabalhar nele.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>Um roteador de contexto<br />
<br />
O AGENTS.md pode indicar o que ler e quando.<br />
Arquitetura, governança e regras de domínio continuam nas suas fontes.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>Autonomia com limites<br />
<br />
Defina o que o agente pode modificar e quando precisa pedir aprovação.<br />
Instruções não substituem permissões reais.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>O que significa terminado?<br />
<br />
Implementar, validar, revisar e limpar.<br />
Testes relevantes, arquitetura respeitada e riscos reportados fazem parte da entrega.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
      <li><p>Cada camada tem seu papel<br />
<br />
As instruções orientam.<br />
As ferramentas validam.<br />
As permissões limitam.<br />
A revisão humana supervisiona.<br />
<br />
Gilmar Pupo · gpupo.com</p></li>
    </ol>
  </details>
</section>
<script src="/assets/js/editorial-carousel.js" defer></script>
