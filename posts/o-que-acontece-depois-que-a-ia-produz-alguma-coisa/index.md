# Gerar Architecture as Code com IA é apenas o começo

Published: 2026-08-14
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/o-que-acontece-depois-que-a-ia-produz-alguma-coisa/
Tags: Architecture as Code, Arquitetura, Governança, Inteligência Artificial, CI/CD, C4

---

Esta semana escrevi sobre [uma pergunta que surgiu em um almoço com CEOs e
CTOs](/posts/em-que-estagio-estao-os-projetos-de-ia-da-sua-empresa/):

**Em que estágio estão os projetos de inteligência artificial da sua empresa?**

As respostas mostravam empresas em situações muito diferentes. Algumas ainda
procuravam casos de uso. Outras estavam experimentando. Algumas já colocavam
fluxos em produção. Poucas tratavam IA como parte estrutural do produto ou da
operação.

Depois fiquei pensando que existe outra forma de observar essa maturidade.

Em vez de olhar apenas para **o que a empresa está fazendo com IA**, podemos
observar **o que acontece quando aquilo que a IA produz precisa entrar na
operação real**.

Architecture as Code é um bom exemplo.

<figure>
  <img src="/assets/images/architecture-as-code-ia-governanca.png" alt="Fluxo de Architecture as Code no qual a IA interpreta código e configurações, um arquiteto revisa o modelo e o pipeline aplica políticas antes do deploy" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>IA para interpretar, software para verificar e pessoas para decidir.</figcaption>
</figure>

## O experimento é a parte fácil

Imagine um fluxo relativamente simples.

Um modelo analisa:

- código-fonte;
- arquivos de Infrastructure as Code;
- especificações OpenAPI;
- configurações de deployment;
- dependências entre serviços.

A partir disso, produz uma primeira versão da arquitetura usando C4 e
Structurizr DSL.

Isso já é perfeitamente plausível e bastante útil.

Tenho usado variações desse processo há algum tempo, mas com uma regra
importante:

**o que a IA produz é um bom primeiro rascunho, não necessariamente a verdade
arquitetural.**

O modelo encontra serviços, dependências e relações que seriam trabalhosos de
mapear manualmente.

Mas também interpreta. E, ao interpretar, pode errar.

Pode inferir uma dependência inexistente, não perceber uma integração indireta,
atribuir responsabilidade demais a um componente ou simplesmente não ter
contexto suficiente.

Enquanto estamos desenhando um diagrama, isso é administrável.

O problema fica mais interessante quando esse modelo deixa de servir apenas
como documentação e começa a participar da governança.

## Quando o desenho entra no pipeline

Suponha que a arquitetura esteja armazenada em Git.

A partir daí, podemos começar a verificar automaticamente coisas como:

> Este serviço pode acessar diretamente este banco?

> Esse componente pode depender daquele domínio?

> Um sistema classificado como interno pode ser exposto publicamente?

> Uma aplicação pode adicionar uma dependência externa sem revisão?

> Algum componente crítico está sendo alterado sem atualizar sua documentação
> arquitetural?

O que antes era um diagrama passa a ter uma função executável.

O pull request altera código. O pipeline analisa a mudança. A arquitetura é
atualizada. As políticas são verificadas.

Algumas mudanças passam automaticamente. Outras pedem revisão. Em casos
realmente importantes, o pipeline pode impedir o deploy.

Nesse ponto, Architecture as Code entra no mesmo ciclo operacional de código,
infraestrutura, segurança e testes.

E isso cria uma conexão interessante com maturidade em IA.

## A maturidade começa quando a IA deixa de trabalhar sozinha

Uma empresa em estágio experimental pode usar IA para gerar o diagrama.

Uma empresa mais avançada pode usá-la para comparar o diagrama com o sistema
real ou explicar uma violação arquitetural.

Mas eu seria bastante cuidadoso antes de deixar um LLM decidir sozinho se um
deployment deve acontecer.

Para mim, existe uma separação importante.

A IA pode ser excelente para:

- descobrir;
- resumir;
- classificar;
- sugerir;
- explicar;
- gerar um primeiro modelo;
- encontrar possíveis inconsistências.

Já a decisão operacional deveria, sempre que possível, terminar em algo mais
determinístico:

- AST;
- regras estruturais;
- dependências reais;
- consultas ao modelo arquitetural;
- políticas explicitamente definidas;
- testes;
- schemas.

Em outras palavras:

**LLM para interpretar. Software para verificar.**

Essa distinção parece pequena, mas muda a confiabilidade do sistema.

## Governança não pode significar bloquear tudo

Uma reação comum quando falamos em colocar arquitetura no CI/CD é:

> “Então agora o arquiteto vai aprovar todos os pull requests?”

Espero que não.

Se Architecture as Code criar mais uma fila de aprovação manual, provavelmente
automatizamos a parte errada.

Uma boa guardrail deveria distinguir pelo menos três situações.

Há mudanças claramente permitidas, que passam automaticamente.

Há mudanças claramente proibidas, que falham com uma explicação objetiva.

E há mudanças ambíguas ou com impacto arquitetural relevante, que merecem
revisão humana.

Isso muda o papel do arquiteto.

Em vez de verificar repetidamente se cada equipe está obedecendo às mesmas
regras, ele pode concentrar seu trabalho na definição dessas regras e nas
exceções que realmente importam.

A arquitetura passa a depender menos de vigilância humana, sem eliminar o
julgamento humano onde ele é necessário.

## E o diagrama?

Talvez essa seja uma das mudanças mais interessantes.

Durante muito tempo tratamos o diagrama como o produto final do trabalho
arquitetural.

Alguém abre uma ferramenta, desenha caixas e setas, publica em uma wiki. Alguns
meses depois, o sistema mudou e o desenho ficou para trás.

Quando a arquitetura passa a nascer de código, configuração, telemetria e
modelos versionados, o diagrama muda de função.

Ele vira uma **view**: uma projeção de um modelo maior.

Podemos gerar uma visão para desenvolvimento, outra para segurança, outra para
operação e outra para um executivo tentando entender quais sistemas suportam
determinada capacidade do negócio.

Isso também ajuda em outro problema da adoção de Architecture as Code: nem todo
mundo quer — ou deveria precisar — ler DSL.

O fato de a fonte da arquitetura ser código não significa que sua interface
também precise ser.

## A empresa provavelmente estará em vários estágios ao mesmo tempo

Aqui volto ao almoço.

Uma empresa pode usar copilots em praticamente todo o desenvolvimento enquanto
seus agentes internos ainda estão em POC.

Sua arquitetura pode continuar em diagramas manuais. O atendimento pode ter
automações de IA em produção. E talvez nenhuma dessas iniciativas esteja ligada
à governança técnica.

Então, qual é o estágio dessa empresa?

É difícil responder com um único número.

Architecture as Code expõe bem esse problema porque cruza várias dimensões de
maturidade.

**IA**, porque podemos usar modelos para descobrir e interpretar o sistema.

**Engenharia**, porque a arquitetura passa a fazer parte do ciclo de
desenvolvimento.

**Governança**, porque decisões arquiteturais podem virar políticas
verificáveis.

**Operação**, porque o modelo precisa representar aquilo que realmente está
rodando.

**Cultura**, porque arquitetos, desenvolvedores, segurança, produto e negócio
precisam compartilhar representações do mesmo sistema.

Uma empresa pode estar avançada em uma dessas dimensões e bastante imatura em
outra.

## Talvez a pergunta seja outra

Em vez de perguntar apenas:

**“Vocês já usam IA?”**

ou:

**“Em que estágio estão os projetos de IA?”**

talvez valha perguntar:

**O que acontece depois que a IA produz alguma coisa?**

Quem valida? Contra qual fonte de verdade?

Existe uma política? Observabilidade? Rollback?

Quem é responsável pela decisão?

O resultado entra em produção automaticamente ou continua sendo apenas uma
sugestão?

Essas perguntas dizem bastante sobre a maturidade real de uma iniciativa.

Gerar um diagrama de arquitetura com IA é interessante.

Manter um modelo arquitetural vivo é melhor. Confrontá-lo automaticamente com
o sistema real aumenta seu valor. Transformar algumas decisões arquiteturais em
guardrails executáveis fecha o ciclo.

Mas o salto mais importante não acontece quando colocamos mais IA no processo.

Acontece quando conseguimos combinar **IA para lidar com ambiguidade, software
para verificar fatos e pessoas para assumir responsabilidade pelas decisões**.

Talvez seja essa combinação que separa um experimento interessante de uma
capacidade operacional de verdade.
