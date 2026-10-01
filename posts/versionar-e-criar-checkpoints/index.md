# Versionar é criar checkpoints

Published: 2026-10-01
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/versionar-e-criar-checkpoints/
Tags: Agentes de IA, Git, Versionamento, Documentação

---

Quando comecei a explicar versionamento para uma equipe que está construindo
seus primeiros agentes de IA, usei uma analogia simples: **checkpoint de
videogame**.

Você chegou a um ponto importante, salva e continua. Se algo der errado depois,
existe um estado conhecido para onde voltar.

Versionamento cumpre esse papel. A analogia tem um limite importante: no Git, o
checkpoint não aparece sozinho. Alguém precisa escolher o que será registrado e
criar um commit.

Com agentes de IA, esse hábito ficou ainda mais importante. Um agente
consegue alterar prompts, `AGENTS.md`, templates, scripts e vários outros
arquivos rapidamente. Isso acelera o trabalho, mas também torna fácil perder um
estado que estava funcionando.

A pergunta aparece cedo:

> **Ontem funcionava. O que mudou?**

Sem uma versão anterior registrada, começa uma investigação. Com ela, podemos
comparar o estado atual com um ponto que já havia sido validado.

<figure>
  <img src="/assets/images/versionar-e-criar-checkpoints.png" alt="Esquema desenhado à mão mostra versões dos pacotes A e B compondo um estado conhecido de uma stack." width="802" height="593" loading="lazy" decoding="async">
  <figcaption>Um checkpoint pode registrar quais versões dos componentes formavam um estado conhecido do projeto.</figcaption>
</figure>

## Git registra os checkpoints

A principal ferramenta para isso é o [Git](https://git-scm.com/). Ele é um
sistema de controle de versão que registra
alterações em arquivos. Git não é GitHub: o
[GitHub é uma plataforma baseada em Git](https://docs.github.com/pt/get-started/start-your-journey/what-is-github),
capaz de hospedar repositórios e acrescentar recursos de colaboração. É
possível usar Git localmente sem publicar o projeto no GitHub.

Na analogia, cada **commit** é um checkpoint. Depois de preparar o repositório,
um ciclo mínimo pode ser:

```bash
git status
git add AGENTS.md templates/ scripts/
git commit -m "Preserva primeiro fluxo funcional do agente"
```

O `git status` mostra o que mudou. O `git add` seleciona os arquivos que farão
parte do checkpoint. O `git commit` registra aquele conjunto de mudanças no
histórico.

Assim se forma uma linha do tempo:

```text
checkpoint validado
   ↓
mudanças
   ↓
checkpoint validado
   ↓
mudanças
   ↓
checkpoint validado
```

Se algum resultado piorar, posso inspecionar a diferença e recuperar um estado
anterior. O Git não decide se o checkpoint era bom; ele preserva o que foi
registrado. Por isso, vale anotar no commit o que funcionava e como foi
verificado.

## Não é só para código

Em projetos com agentes, podemos versionar:

- `AGENTS.md`;
- prompts;
- skills;
- templates;
- regras;
- documentação;
- HTML;
- scripts e configurações.

São arquivos que transformam um modelo genérico em um agente adaptado ao
projeto. Quando mudam, o comportamento também pode mudar. Mantê-los no mesmo
histórico ajuda a comparar não apenas o código, mas o contexto que orientou cada
execução.

## Commit e versão não são a mesma coisa

Todo estado que vale preservar pode virar um commit. Isso não significa que
todo commit precise receber um número de versão.

Quando um checkpoint será distribuído, implantado ou usado por outro projeto,
podemos marcá-lo como uma versão. Se existe um contrato de compatibilidade
claro, uma convenção possível é o
[Versionamento Semântico](https://semver.org/lang/pt-BR/):

```text
MAJOR.MINOR.PATCH

2.4.1
```

**PATCH** indica uma correção compatível:

```text
2.4.0 → 2.4.1
```

**MINOR** adiciona uma capacidade mantendo compatibilidade com o contrato
existente:

```text
2.4.1 → 2.5.0
```

**MAJOR** indica uma mudança incompatível nesse contrato:

```text
2.5.0 → 3.0.0
```

Para um agente, esse contrato pode incluir o formato de entrada e saída, os
comandos disponíveis, a estrutura de um template ou um comportamento do qual
outros componentes dependem. Sem definir o que precisa permanecer compatível,
os números comunicam pouco.

Durante o desenvolvimento inicial, o Versionamento Semântico reserva a série
`0.y.z` para uma API ainda instável:

```text
0.1.0
0.2.0
0.2.1
...
1.0.0
```

Nesse sistema, `1.0.0` define a primeira API pública. Não quer dizer que o
projeto ficou livre de erros; quer dizer que existe um contrato que as próximas
versões devem considerar.

## Sessão é temporária, projeto é persistente

Há ainda uma consequência importante para o trabalho com agentes de IA.

A sessão é temporária. Ela termina, pode ser resumida e não deveria ser a única
guardiã de uma decisão importante. Se uma regra precisa orientar o próximo
trabalho, ela precisa sair da conversa e chegar ao projeto.

```text
AGENTS.md
skills/
templates/
docs/
output/
```

Nem todo resultado gerado precisa entrar no Git, e segredos não devem ser
registrados. Mas regras, decisões e saídas que precisam de auditoria podem virar
arquivos e fazer parte do histórico.

A distinção fica simples:

```text
sessão → temporária

projeto versionado → fonte persistente
```

## O primeiro hábito

Não é necessário aprender o Git inteiro para começar. O primeiro hábito já
reduz bastante o risco:

> **Quando eu chegar a um estado que vale a pena preservar, faço um
> checkpoint.**

Um checkpoint fica mais útil quando sua mensagem ajuda a reconhecer o que
funcionava naquele momento e como isso foi verificado.

A IA tornou muito barato mudar as coisas. O Git torna barato comparar essas
mudanças e recuperar um ponto conhecido. O que nunca foi registrado, porém, não
tem checkpoint para onde voltar.
