# AI Skills para GPT-5.6 Sol: menos instrução, mais contrato

Published: 2026-08-10
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/ai-skills-para-gpt-5-6-sol-menos-instrucao-mais-contrato/
Tags: Inteligência Artificial, AI Skills, GPT-5.6, Codex, Agentes de IA, Prompt Engineering

---

Durante bastante tempo, escrever uma boa AI Skill significava explicar muita
coisa ao modelo. Era comum encontrar arquivos cheios de instruções como:

```text
First analyze the repository.
Then identify the relevant files.
Make sure you understand the architecture.
Always preserve existing conventions.
Before changing anything...
After completing the task...
```

Modelos anteriores frequentemente precisavam de mais *scaffolding* para manter
o foco, seguir uma sequência de trabalho ou não esquecer uma restrição
importante. Com o GPT-5.6 Sol, comecei a perceber que parte dessas skills
envelheceu.

O problema não é apenas consumir mais tokens. Uma skill excessivamente
detalhada pode diluir a prioridade das poucas regras que realmente importam. Em
vez de orientar, passa a microgerenciar.

A [orientação oficial da OpenAI para o
GPT-5.6](https://developers.openai.com/api/docs/guides/latest-model) aponta na
mesma direção: o modelo consegue inferir melhor a intenção a partir do contexto,
mas ainda precisa receber contexto de domínio, restrições, limites de aprovação e
critérios de sucesso. Em uma amostra interna de avaliações com agentes de
código, prompts de sistema mais enxutos melhoraram a pontuação em cerca de 10%
a 15%, reduziram o total de tokens em 41% a 66% e o custo em 33% a 67%. A
própria documentação trata esses números como direcionais e recomenda validar a
mudança em tarefas representativas.

Isso não demonstra que toda skill longa está errada. Para mim, é um critério
para revisar o que ainda precisa estar explícito.

## Skills antigas tentavam ensinar o agente a trabalhar

Muitas skills foram escritas quase como pequenos programas. Elas descrevem:

- quais arquivos abrir primeiro;
- em qual ordem analisar;
- o que pensar antes de agir;
- o que revisar depois;
- quais perguntas internas fazer;
- como decompor cada etapa.

O resultado costuma ser algo parecido com isto:

```markdown
First inspect the repository structure.

Then read the README.

Then identify architecture files.

Make sure you understand the existing conventions.

Before creating new components, inspect similar existing components.

After implementation, verify that the changes follow the existing architecture.
```

Nada disso está necessariamente errado, mas boa parte já é comportamento
esperado de um agente competente. Com Sol, prefiro não tentar programar cada
passo mental necessário para resolver o problema. Prefiro definir o contrato.

## De procedimento para contrato

Uma skill adequada a esse modelo pode ser menor sem deixar de ser rigorosa. Em
vez de explicar detalhadamente como analisar um design system, posso escrever:

```markdown
# Purpose

Maintain DESIGN.md as the visual memory of the product.

# When to use

Use when creating or materially changing the product UI.

# Requirements

DESIGN.md must capture:

- visual principles
- typography
- colors and tokens
- component conventions
- layout patterns
- interaction patterns
- intentional exceptions

# Behavior

Inspect the current product before modifying DESIGN.md.

Preserve existing decisions unless the implementation clearly supersedes them.

Prefer observed implementation over invented conventions.

# Output

Update DESIGN.md directly.

Keep it concise and useful to another coding agent.
```

A diferença é deixar de prescrever como o agente deve pensar e definir o que
precisa ser verdade quando ele terminar.

## A estrutura que estou usando

Para novas skills, tenho preferido esta hierarquia:

```text
Purpose
↓
When to use
↓
Sources of truth
↓
Requirements
↓
Constraints
↓
Definition of done
```

Workflow entra apenas quando a ordem realmente importa. Uma migração de banco,
por exemplo, pode exigir:

```text
backup → migrate → validate → cleanup
```

Nesse caso, a sequência faz parte da segurança da operação. Para tarefas como
analisar arquitetura, criar um componente ou atualizar documentação, normalmente
não preciso prescrever cada passo.

## O que aconteceu ao revisar 25 skills

Essa ideia deixou de ser apenas uma hipótese de edição. Revisamos
individualmente todas as 25 skills que usávamos com o GPT-5.6 Sol.

Os arquivos principais passaram de 3.830 para 1.366 linhas. É uma redução de
aproximadamente 64% no nosso conjunto de skills, não uma expectativa de redução
para qualquer repositório.

Durante a revisão, removemos repetições, exemplos redundantes, procedimentos
óbvios e instruções que controlavam excessivamente o raciocínio do modelo. Ao
mesmo tempo, preservamos:

- fontes de verdade;
- tecnologias obrigatórias;
- limites de autorização;
- ações destrutivas e regras de segurança;
- definições de pronto.

Mantivemos workflows ordenados apenas quando a sequência é importante. Os casos
que permaneceram incluem deploys no Nomad, commits e tags, treinamento de
modelos e alterações com shadcn.

Também mantivemos referências técnicas detalhadas de Godot, shadcn e PostgreSQL,
porque essas APIs e operações são frágeis o suficiente para justificar a
especificidade. Em contraste, removemos exemplos redundantes da skill do
Obsidian.

A revisão encontrou ainda um problema de segurança: havia credenciais reais nas
skills de Wiki.js e Vaultwarden. Elas foram removidas. Esse achado reforçou o
critério de que uma skill deve ser curta, mas não pode perder restrições ou
informações de segurança para ficar menor.

## O que ainda vale a pena deixar explícito

Reduzir uma skill não significa remover tudo. Algumas instruções carregam
informações que o modelo não tem como inferir com segurança.

### Restrições

```text
Do not modify generated files.
```

### Fonte de verdade

```text
The implementation is the primary source of truth.
```

### Decisões específicas do projeto

```text
Use shadcn/ui components instead of creating equivalent custom components.
```

### Definition of done

```text
The task is complete only when DESIGN.md reflects the implemented UI.
```

Essas regras são mais valiosas do que uma orientação genérica como:

```text
Carefully analyze the project before making changes.
```

Também manteria exemplos que codificam um requisito de produto, corrigem uma
falha recorrente ou evitam uma ambiguidade conhecida. O corte deve atingir
repetição e procedimento genérico, não conhecimento do projeto.

## Uma regra simples

Tenho usado esta heurística:

> Se eu remover essa instrução, um engenheiro competente ainda saberia o que
> fazer?

Se a resposta for sim, testo a skill sem ela. Por exemplo:

```text
Analyze the existing code carefully before making changes.
Make sure you understand the current architecture and conventions.
```

pode virar:

```text
Preserve the repository's existing architecture and conventions.
```

Ou desaparecer, dependendo do contexto. A segunda versão contém uma restrição
objetiva. A primeira descreve um comportamento esperado.

## O risco da instrução demais

Imagine uma skill com 80 regras. Talvez cinco sejam fundamentais para o projeto
e o restante seja formado por recomendações, procedimentos genéricos, exemplos e
explicações. O modelo precisa distinguir o que é essencial do que é apenas
orientação.

Na minha interpretação, uma skill menor pode funcionar melhor porque aumenta a
relação sinal/ruído:

```text
mais instrução ≠ mais controle
```

O limite dessa regra aparece quando a ordem protege dados, uma ação exige
aprovação, uma tecnologia é obrigatória ou uma exceção do projeto contraria o que
o agente inferiria. Nesses casos, brevidade não compensa a perda de segurança ou
de precisão.

## Contexto do projeto também precisa de limite

Pedir apenas:

```text
Analyze the entire repository before starting.
```

pode levar o agente a explorar muito mais do que o necessário. Prefiro uma
instrução com fontes, resultado esperado e critério de parada:

```markdown
Review the current project context before starting implementation work.

Build an accurate mental model of the project using the repository itself as the primary source of truth.

Inspect the relevant project context, including when available:

- README and project documentation
- AGENTS.md, CLAUDE.md, DESIGN.md, PRD.md, SPEC.md, ADRs, and similar context files
- repository structure
- configuration and dependency files
- existing implementation patterns
- tests and validation tooling
- recent changes when they materially help explain the current state

Determine:

- what the project does
- its current architecture
- important conventions and constraints
- the relevant domain model
- existing decisions that should be preserved
- the likely impact area of the requested work

Do not modify files during this review.

Avoid exhaustive repository exploration when the relevant context is already clear.

Treat implemented code and explicit project decisions as stronger evidence than assumptions or generic best practices.

After reviewing the context, proceed with the requested task using the project's existing architecture and conventions.

If you discover a material ambiguity, contradiction, or risk that affects the implementation, surface it before making an irreversible decision.
```

A parte mais importante para mim é:

```text
Avoid exhaustive repository exploration when the relevant context is already clear.
```

Ela cria um critério de parada. "Entenda o projeto" não significa "leia todos os
arquivos do repositório".

## Um prompt para revisar skills antigas

Comecei também a usar o próprio agente para modernizar minhas skills:

```markdown
Review the existing AI skill for use with GPT-5.6 Sol.

Preserve the skill's intent, important constraints, sources of truth, and definition of done.

Identify and remove instructions that are unnecessarily verbose, repetitive, procedural, obvious, or that over-specify how the model should reason or execute the task.

Prefer declarative instructions that define:

- purpose
- when the skill applies
- sources of truth
- required outcomes
- constraints
- definition of done

Keep workflows only when execution order is materially important.

Preserve explicit rules for:

- safety or irreversible actions
- files or areas that must not be modified
- required technologies or conventions
- authoritative project sources
- non-obvious decisions
- output requirements

Consolidate duplicate or overlapping instructions.

Remove examples when the rule is already clear without them. Keep examples only when they prevent a likely ambiguity or recurring failure mode.

Do not add generic best practices unless they are necessary to the skill's specific purpose.

Prefer outcome-oriented instructions over step-by-step prompting.

The revised skill should be shorter, clearer, and easier for the model to prioritize without losing important behavior.

When finished, provide:

1. the revised skill
2. a brief summary of what was removed, consolidated, or preserved
3. any instruction you intentionally kept despite its verbosity, and why
```

Para uma revisão mais agressiva, acrescento:

```text
Assume GPT-5.6 Sol is competent by default.

Instruct only where project-specific behavior, constraints, or outcomes differ from what a capable coding agent would reasonably infer.
```

## Skills como contexto operacional

Tenho pensado cada vez menos em AI Skills como programas para controlar um LLM.
Elas se parecem mais com contexto operacional. Para tarefas gerais, parto do
pressuposto de que o modelo consegue analisar código, identificar padrões, navegar
por um repositório, comparar alternativas e decompor problemas.

A skill deveria acrescentar aquilo que ele não sabe:

```text
como este projeto funciona
quais decisões já foram tomadas
quais restrições existem
qual fonte é autoritativa
o que não deve mudar
como sabemos que o trabalho terminou
```

O princípio que estou adotando é:

> **Skills describe intent, constraints, sources of truth and done-state. The
> model owns the execution strategy.**

Ou, de forma mais curta:

> **Não ensine o agente a pensar quando basta dizer o que precisa ser
> respeitado.**

Minha expectativa é que muitas skills criadas para gerações anteriores possam
ficar entre 30% e 60% menores sem perder capacidade. Essa faixa é uma estimativa
de revisão, não um resultado medido.

Eu começaria por uma skill que já funciona, removeria um grupo de instruções por
vez e repetiria as mesmas tarefas. O critério não é terminar com o menor arquivo.
É preservar o resultado, os limites e a segurança usando menos contexto e menos
microgerenciamento.
