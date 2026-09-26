# OKR e Obsidian: um mapa pessoal para decidir o que estudar

Published: 2026-08-27
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/okr-obsidian-mapa-pessoal-decidir-o-que-estudar/
Tags: Personal Competency Graph, Obsidian, OKR, Zettelkasten, Aprendizado, Gestão do conhecimento

---

Outro dia, numa conversa com um amigo, resumi o que estou tentando fazer assim:

> Estou tentando juntar OKR e Zettelkasten.

A resposta dele foi mais ou menos: parece uma boa aventura. Como está se
saindo?

Minha resposta também foi simples:

**Meio perdido, mas sem pressa.**

A frase descreve bem o estágio atual. Não estou tentando construir uma
metodologia definitiva de aprendizado pessoal. Estou encaixando ferramentas que
já uso e testando onde cada uma ajuda enquanto continuo estudando de verdade.

É fácil passar meses aperfeiçoando um sistema para aprender e esquecer de
aprender alguma coisa durante o processo.

Este texto descreve o modelo do Personal Competency Graph (PCG) consolidado no
PRD 1.4.1, cujo status é uma visão de produto e um baseline conceitual para o
piloto. Há decisões apoiadas por material real do meu vault, mas a ponte com o
Obsidian e parte dos quatro casos de validação ainda estão planejadas. Portanto,
este é um registro de direção e hipóteses de produto, não um relato de resultados
já medidos.

## O ponto de partida é o meu vault

Uso o Obsidian há tempo suficiente para que ele tenha deixado de ser apenas um
aplicativo de notas.

Meu vault guarda aulas, referências, ADRs, leituras, ideias, notas pequenas,
MOCs, Bases, áreas de interesse e uma quantidade considerável de conhecimento
acumulado. Ele funciona bem como memória externa.

Uma biblioteca pessoal responde a perguntas como:

- Onde anotei isso?
- O que tenho relacionado a esse assunto?
- Que referências já encontrei?
- Que decisões tomei?

Mas responde pior a outra:

> **O que vale a pena estudar agora?**

Ter muito material disponível não produz direção automaticamente. Foi desse
problema que nasceu o Personal Competency Graph.

## O grafo é o modelo; o Caminho é o produto

No começo, a tentação era tratar o grafo como a interface principal.

Domínios, grupos de competências, competências, dependências, níveis e
evidências. Tudo conectado.

O modelo é interessante para organizar relações. Para decidir o que estudar
numa terça-feira, cinquenta nós na tela podem acrescentar mais trabalho que
direção.

A ideia ficou mais clara quando passei a usar esta regra:

> **O grafo é o modelo; o Caminho é o produto.**

No modelo atual, o PCG combina:

- **Autoavaliação:** onde acredito estar;
- **Objetivo:** onde quero chegar;
- **relações entre competências:** o que depende de quê e quais lacunas importam
  para aquele objetivo.

A saída deveria ser simples:

```text
já no nível necessário → merece atenção agora → vem depois
```

Isso é o Caminho pessoal.

Não quero abrir uma tela para admirar meu mapa de competências. Quero perceber,
em poucos segundos:

> Estou indo para cá. Neste momento, estas poucas coisas merecem mais atenção.

E voltar a estudar.

## Música expôs a primeira armadilha

Um dos primeiros casos usa algo que já estou fazendo: retomar a guitarra com
foco em blues e jazz.

Uma aula real no vault contém elementos concretos como pentatônicas, metrônomo,
blues de 12 compassos, Jazz Blues, turnarounds e orientação harmônica. A nota
continua sendo um recurso de estudo dentro do Obsidian.

A ponte mínima planejada não reorganiza essa nota nem a transforma num artefato
do PCG. Ela preserva identidade, caminho e links e acrescenta referências
opcionais a competências canônicas. No piloto, a ideia é testar algo desta
forma:

```yaml
id: 3.20260821.aula-guitarra
pcg_skills:
  - MUSIC-001
  - MUSIC-006
  - MUSIC-016
```

O objetivo musical ficou assim:

> **Recuperar fluência na guitarra para blues e jazz, chegando a tocar por cerca
> de 50 minutos com conforto, tempo e clareza.**

Isso descreve o destino. Minha estratégia cotidiana pode continuar sendo uma
prática sustentável de aproximadamente vinte minutos.

Numa versão anterior do desenho, comecei a transformar essa prática numa
`Mission`:

- iniciar prática;
- executar quatro blocos de cinco minutos;
- concluir;
- registrar fadiga;
- enviar para revisão;
- gerar Evidência.

Foi quando percebi que estava construindo o produto errado. Não quero outro
gerenciador de tarefas nem um aplicativo cobrando a prática diária de guitarra.

A prática acontece fora do PCG. O produto precisa conseguir dizer algo como:

> Seu foco atual está em estabilidade de tempo, conhecimento das notas no braço
> e resistência de execução.

E talvez sugerir:

> Um ciclo curto com pentatônica, metrônomo, blues e turnaround trabalha essas
> competências.

Essa descoberta virou uma regra de produto:

> **O PCG orienta a prática; não administra a prática.**

Agenda, lista de tarefas, rastreador de hábitos, cronômetro, streak e diário
detalhado de sessões ficaram explicitamente fora do escopo atual.

## O vault não precisa virar um Zettelkasten puro

Foi aí que percebi que talvez eu não estivesse realmente tentando juntar OKR e
Zettelkasten.

Meu vault não é um Zettelkasten puro. Ele mistura notas atômicas com áreas,
MOCs, Bases, aulas, ADRs e outros artefatos. O termo mais preciso para o que
existe hoje é **vault pessoal de conhecimento**.

O Obsidian continua responsável pelo conhecimento:

- uma nota sobre pentatônicas continua sendo uma nota sobre pentatônicas;
- uma aula de inglês continua sendo uma aula de inglês;
- um ADR continua sendo um ADR.

O PCG não precisa importar tudo nem criar uma segunda organização. Ele precisa
saber que alguns recursos já existentes estão relacionados às competências do
Foco atual:

```text
Objetivo
   ↓
Caminho
   ↓
Foco atual
   ↓
Competências
   ↓
recursos relevantes que já existem no vault
```

Backlinks respondem:

> O que está conectado com esta nota?

O PCG tenta responder outra pergunta:

> **Entre tudo que já acumulei, o que é relevante para onde estou tentando
> chegar agora?**

A diferença é pequena na descrição, mas muda o critério de seleção do material.

## Inglês trouxe OKR para a conversa

Outro caso real é meu inglês. O objetivo é:

> **Avançar de B1 para B2 funcional.**

B1 e B2 vêm do [Common European Framework of Reference for Languages
(CEFR)](https://www.coe.int/en/web/common-european-framework-reference-languages/table-1-cefr-3.3-common-reference-levels-global-scale).
O PCG não deve converter essa referência automaticamente para sua escala interna
de competências.

Quero continuar usando estratégias que já fazem parte do meu estudo:

- aula semanal de conversação;
- exercícios de gramática;
- leitura de literatura em `en-US`.

Essas atividades não são resultados. Posso fazer aulas durante meses sem chegar
ao nível funcional pretendido. Posso resolver muitos exercícios de gramática
sem melhorar a conversação na mesma proporção.

Isso me levou de volta ao OKR. O Objetivo pode ser avançar de B1 para B2
funcional. Os critérios de sucesso ainda precisam ser operacionalizados, mas
podem incluir:

- uma verificação externa compatível com B2;
- uma avaliação do professor sobre minha conversação;
- conseguir ler e discutir uma obra em inglês com a autonomia definida para o
  objetivo.

Já “fazer aula toda semana” e “ler literatura” continuam sendo estratégias de
aprendizagem, não Key Results.

O modelo que estou testando preserva essa diferença:

```yaml
goal:
  intent: avancar de B1 para B2 funcional

  success_criteria:
    - verificacao externa compativel com B2
    - avaliacao do professor sobre conversacao
    - leitura e discussao autonoma de uma obra

  learning_strategies:
    - aula semanal de conversacao
    - exercicios de gramatica
    - literatura em en-US
```

Quando essa visualização for útil:

```text
intent            → Objective
success_criteria  → Key Results
```

OKR permanece uma visualização opcional do Objetivo. Ele não cria um módulo
paralelo, pontuação corporativa, check-in semanal ou tarefas derivadas de KRs.

Essa fronteira evita transformar um sistema pessoal de aprendizado numa
imitação de software corporativo de gestão de metas.

## Evidência é uma camada secundária

Outro risco era criar burocracia para aprender.

Uma gravação pode sustentar uma avaliação musical. Um projeto real pode mostrar
uma competência de arquitetura. Uma avaliação externa pode ajudar a observar o
inglês. Mas isso não significa que cada sessão, leitura ou exercício precise
produzir Evidência.

O modelo mantém duas informações separadas:

```text
Autoavaliação                  Evidência aceita
onde acredito estar           o que um resultado sustenta
```

Primeiro, registro onde acredito estar e aonde quero chegar. A partir disso, o
PCG pode projetar um Caminho inicial. Quando surge um resultado significativo,
posso promovê-lo explicitamente a Evidência.

Exemplos possíveis:

- uma gravação que valha ser avaliada;
- uma apresentação;
- um parecer do professor;
- um projeto real;
- um ADR importante.

O requisito P0 é deliberado: o Caminho deve funcionar com zero Evidência
registrada. A ausência dessa camada não pode bloquear o Foco atual nem as
Sugestões de estudo.

## Quatro casos para testar o modelo em 2026

Para não continuar refinando conceitos sem confronto com a prática, escolhi
quatro casos de validação.

### Música

Testa competências práticas, pré-requisitos, progresso não linear e a ponte com
uma aula real do vault. É o primeiro piloto planejado.

### Inglês B1 → B2

Testa uma referência externa de proficiência, um Objetivo multidimensional,
estratégias recorrentes e a visualização opcional como OKR.

### Matemática

É um caso futuro. A hipótese é que dependências e ordem de aprendizagem terão
mais peso. Não quero criar o catálogo antes de existir um objetivo matemático
real e material para orientar o recorte.

### Distribuição e descoberta do conteúdo

Também é um caso futuro, mas já possui material de partida no vault. O resultado
desejado não é uma competência isolada. Quero observar distribuição,
descoberta, audiência incremental, visitas qualificadas, respostas, salvamentos
e relacionamentos, sem usar “alcance” como sinônimo automático de sucesso.

Nesse caso, a cadeia começa pelo resultado externo:

```text
resultado que quero
        ↓
critérios de sucesso
        ↓
competências que podem influenciá-lo
        ↓
Caminho
```

OKR talvez seja mais natural nesse quarto caso. Isso ainda precisa ser testado.

## Cada ferramenta fica com uma responsabilidade

A interpretação que faz mais sentido neste estágio é:

- o vault preserva a memória e os recursos;
- o catálogo de competências descreve o território;
- a Autoavaliação marca onde acredito estar;
- o Objetivo marca onde quero chegar;
- o PCG projeta o Caminho;
- o Foco atual mostra o trecho que merece atenção;
- os recursos do vault ajudam a estudar esse trecho;
- OKR pode tornar alguns Objetivos e critérios de sucesso mais legíveis;
- Evidência aumenta a confiança quando existe algo significativo para avaliar.

Não preciso fundir tudo numa metodologia única. A integração pode estar em
manter as responsabilidades separadas e construir uma ponte pequena entre elas.

O próximo incremento é concreto: ligar uma nota real da aula de guitarra a
competências canônicas e verificar se ela reaparece como recurso útil quando
essas competências entram no Foco atual. Se essa ponte não ajudar a decidir o
que estudar e voltar rapidamente à prática, o modelo falhou no teste que mais
importa.

Música, inglês, matemática e distribuição já fornecem variação suficiente para
o restante de 2026.

Ainda estou encaixando conceitos e mudando nomes. Continuo meio perdido, mas sem
pressa — desde que o sistema não tome o lugar do estudo que deveria orientar.
