# Em projetos com agentes, a spec é o artefato que fica

Published: 2026-01-19
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/spec-artefato-duravel-projetos-agentes/
Tags: IA, Agentes, Desenvolvimento, Especificação, Engenharia de Software

---

Um agente consegue abrir um repositório, propor uma arquitetura, alterar dezenas de arquivos e executar testes em pouco tempo. O problema aparece na próxima sessão: alguém pergunta por que uma decisão foi tomada, qual comportamento era esperado ou se uma mudança posterior ainda respeita o objetivo inicial.

O histórico da conversa raramente responde bem. Ele é longo, fragmentado e não participa naturalmente da revisão de código. Uma lista de tarefas ajuda durante a implementação, mas envelhece rápido. O código mostra o que foi entregue, não necessariamente o que deveria ter sido entregue.

Por isso, em projetos com agentes, eu trataria a especificação como o artefato durável da funcionalidade.

Ela não é um prompt grande guardado em Markdown. É um registro versionado do problema, do comportamento esperado, dos limites e dos critérios que permitem dizer se o resultado está correto. Planos e tarefas podem ser refeitos à medida que aprendemos. A spec precisa continuar explicando a intenção.

## O agente acelera a execução e expõe a falta de contexto

Antes dos agentes, uma requisição vaga também criava retrabalho. Mas a velocidade era limitada pelo tempo de implementação. Agora uma instrução ambígua pode se transformar rapidamente em uma mudança grande, plausível e difícil de revisar.

Considere um pedido como este:

> Adicione exportação de dados para o cliente.

Ele deixa perguntas importantes sem resposta:

* quais dados podem ser exportados?
* quem pode solicitar a exportação?
* o arquivo é imediato ou assíncrono?
* qual formato é necessário?
* existem dados pessoais que devem ser excluídos?
* como o usuário sabe que a operação terminou?
* o que caracteriza uma exportação correta?

Uma pessoa experiente talvez descubra essas lacunas conversando com o time. Um agente também pode perguntar, mas pode igualmente assumir respostas e seguir em frente. Quanto mais autonomia ele tem para editar, executar comandos e abrir pull requests, maior é o valor de tornar essas decisões explícitas antes da implementação.

## A spec registra intenção; os outros artefatos têm funções diferentes

Eu separaria quatro coisas que frequentemente acabam misturadas em um documento único.

| Artefato | Pergunta que responde | Quanto tempo deve durar |
| --- | --- | --- |
| Regras do repositório | Como trabalhar com segurança neste projeto? | Enquanto o projeto existir |
| Spec da funcionalidade | O que precisa mudar e como saber se deu certo? | Enquanto a funcionalidade existir |
| Plano técnico | Qual abordagem atende à spec neste momento? | Até a abordagem mudar |
| Tarefas | Qual é a sequência atual de execução? | Até a implementação terminar |

As regras do repositório podem ficar em `AGENTS.md`, `CONTRIBUTING.md` ou documento equivalente. Ali entram comandos de build e teste, organização de diretórios, convenções, limites operacionais e regras de segurança.

A spec é específica de uma funcionalidade. Ela descreve o problema, quem é afetado, os fluxos, os critérios de aceitação, o que ficou fora do escopo e as decisões que ainda precisam ser tomadas.

O plano é técnico e deliberadamente revisável. Pode comparar duas abordagens, listar arquivos que provavelmente mudarão e explicar uma migração. A lista de tarefas transforma o plano em unidades pequenas e verificáveis.

Essa separação evita dois extremos: usar uma spec abstrata demais para orientar o trabalho ou transformar a própria spec em um diário de implementação impossível de manter.

## Uma spec pequena precisa remover ambiguidade, não palavras

“Minimal” não significa “curta a qualquer custo”. Uma spec de uma página pode ser suficiente para uma alteração localizada. Uma integração de pagamento ou uma migração de dados pode exigir mais detalhes.

O tamanho correto depende da quantidade de decisões que não podem ser delegadas ao acaso.

Para começar, eu usaria esta estrutura:

```markdown
# Exportação mensal de dados

## Problema
Administradores precisam obter os registros de um período sem acesso direto ao banco.

## Resultado esperado
Um administrador autenticado solicita uma exportação mensal e recebe um arquivo CSV
com os campos permitidos para seu perfil.

## Fora do escopo
- Não criar relatórios com filtros arbitrários.
- Não alterar os dados de origem.

## Cenários de aceitação
1. Um administrador escolhe um mês concluído e inicia a exportação.
2. O arquivo contém apenas registros pertencentes à sua organização.
3. Campos sensíveis definidos pela política não aparecem no arquivo.
4. Uma solicitação sem permissão recebe erro de autorização.
5. Falhas geram um status compreensível e não deixam arquivo parcial disponível.

## Limites
- Sempre: registrar a solicitação e executar os testes relevantes.
- Perguntar antes: adicionar dependência ou mudar o esquema do banco.
- Nunca: incluir segredos, dados de outra organização ou arquivos gerados no Git.
```

Esse exemplo não escolhe fila, framework, biblioteca de CSV ou serviço de armazenamento. Essas são decisões de plano. A spec fixa o comportamento que a implementação precisa preservar, mesmo que a tecnologia mude depois.

## Critérios de aceitação são uma interface de revisão

O ponto mais útil da spec são os critérios de aceitação. Eles fazem a ponte entre uma intenção de produto e uma verificação objetiva.

Para cada critério, eu tentaria identificar uma evidência:

| Critério | Evidência esperada |
| --- | --- |
| Usuário autorizado exporta seus dados | teste de integração ou teste manual documentado |
| Dados de outra organização não aparecem | teste de isolamento de dados |
| Campos proibidos não são exportados | asserção sobre colunas e conteúdo |
| Erro de autorização é tratado | teste de permissão e resposta esperada |
| Falha não deixa resultado incompleto | teste do fluxo de erro e limpeza |

O agente pode gerar parte dos testes, mas a equipe ainda precisa decidir se as evidências realmente representam o risco. Um teste que apenas confirma que a rota retornou HTTP 200 não prova que a exportação respeita isolamento entre organizações.

Essa é uma diferença importante entre “o código executa” e “a funcionalidade atende ao que foi pedido”.

## As regras do repositório evitam que toda tarefa recomece do zero

Uma spec não deve carregar todos os comandos, convenções e riscos do projeto. Se fizer isso, cada feature duplica contexto e aumenta a chance de ficar desatualizada.

Eu manteria regras estáveis perto do código. Um `AGENTS.md` enxuto pode informar ao agente:

```markdown
## Comandos
- Teste rápido: `uv run pytest tests/unit -q`
- Teste completo: `uv run pytest`
- Verificação de estilo: `uv run ruff check .`

## Estrutura
- Código da aplicação: `src/`
- Testes: `tests/`
- Migrações: `migrations/`

## Limites
- Nunca ler ou editar arquivos `.env`.
- Perguntar antes de criar uma migração.
- Não modificar configurações de produção.
```

Os exemplos precisam ser reais. Um comando inventado ou uma regra genérica demais só produz uma aparência de governança.

O GitHub recomenda que orientações para agentes cubram comandos, testes, estrutura do projeto, estilo de código, fluxo Git e limites. Esse conjunto é útil porque responde às dúvidas operacionais mais frequentes sem exigir que cada prompt repita a história do repositório. [O levantamento do GitHub sobre arquivos `AGENTS.md`](https://github.blog/ai-and-ml/github-copilot/how-to-write-a-great-agents-md-lessons-from-over-2500-repositories/) detalha esses elementos.

## Planejar em modo de leitura evita mudanças prematuras

Depois de aprovar a spec, eu pediria ao agente para explorar o repositório sem alterar arquivos e produzir um plano técnico.

Um plano útil deveria indicar:

* quais módulos provavelmente precisam mudar;
* quais contratos de API, tabelas ou eventos são afetados;
* quais dependências e riscos existem;
* como os critérios de aceitação serão testados;
* quais decisões ainda exigem aprovação humana;
* como reverter a alteração se for necessário.

Essa etapa é especialmente importante em bases de código existentes. O agente pode descobrir que a exportação já tem um mecanismo de autorização reutilizável, que há uma fila padrão para operações longas ou que o modelo de dados não permite distinguir organizações como a spec pressupunha.

É melhor corrigir a spec ou o plano nesse ponto do que aceitar um diff grande e descobrir, na revisão, que a implementação resolveu um problema diferente.

Ferramentas de desenvolvimento orientado a especificação costumam organizar o fluxo em `spec → plan → tasks → implement`, com etapas adicionais de esclarecimento e análise quando a funcionalidade tem ambiguidade relevante. [A documentação do GitHub Spec Kit](https://github.github.com/spec-kit/) descreve esse modelo e os artefatos que alimentam cada fase.

## Tarefas devem ser descartáveis, mas rastreáveis

Uma lista de tarefas serve para transformar um plano em trabalho revisável. Ela não precisa ser a fonte histórica da funcionalidade.

Uma boa tarefa tem escopo limitado, dependências claras e uma forma de validação. Em vez de:

```text
Implementar exportação de dados
```

Eu preferiria algo como:

```text
1. Adicionar política que autoriza exportação por organização.
2. Criar serviço que seleciona apenas campos permitidos.
3. Expor requisição assíncrona e estado da exportação.
4. Cobrir isolamento entre organizações com teste de integração.
5. Cobrir falha de geração sem deixar arquivo disponível.
```

Isso ajuda a distribuir trabalho entre agentes ou pessoas sem perder a ordem das dependências. Também permite interromper a execução depois de uma etapa e revisar antes de aumentar a superfície da mudança.

Quando o plano muda, eu regeneraria as tarefas. Tentar manter uma lista antiga apenas para preservar histórico costuma criar instruções que descrevem uma implementação que já não existe.

## O ciclo termina com reconciliação, não com o último teste verde

Depois de implementar, eu faria uma revisão em duas direções.

Primeiro: o código, os testes e a observabilidade atendem aos critérios da spec?

Segundo: a spec ainda descreve o comportamento que ficou no repositório?

Às vezes a implementação revela uma limitação legítima. Talvez a exportação precise ser assíncrona porque o volume de dados é maior que o previsto. Talvez o formato CSV não seja suficiente. Se a decisão mudou, a spec deve ser atualizada antes do merge ou a implementação deve ser ajustada para voltar ao combinado.

O que eu evitaria é deixar os dois divergirem silenciosamente. Na próxima mudança, o agente terá acesso a uma spec errada e poderá reconstruir um comportamento que a equipe já abandonou.

Uma revisão simples pode usar esta tabela:

| Pergunta | Resultado esperado |
| --- | --- |
| Cada critério de aceitação tem evidência? | links para testes, logs ou validação manual |
| Algum comportamento entregue não estava na spec? | remover, justificar ou atualizar a spec |
| Algum requisito da spec ficou sem implementação? | corrigir antes do merge ou registrar decisão explícita |
| Os limites foram respeitados? | nenhuma alteração proibida ou segredo incluído |
| A próxima pessoa entende por que a mudança existe? | spec e decisão técnica acessíveis no repositório |

## Onde esse processo costuma falhar

O primeiro erro é substituir a spec por um prompt gigantesco. Contexto demais não equivale a contexto útil. O agente precisa receber as partes relevantes para a tarefa atual, com uma hierarquia clara entre regras permanentes, requisitos e plano.

O segundo é escrever uma spec que define apenas a tecnologia: “usar fila X, banco Y e framework Z”. Ela pode orientar a implementação, mas não explica qual problema o usuário resolve nem como avaliar o resultado. A tecnologia pertence principalmente ao plano; o comportamento e os limites pertencem à spec.

O terceiro é ignorar a spec depois do primeiro merge. Se o documento não acompanha as decisões reais, ele vira uma fonte de erros mais perigosa que a ausência de documentação.

O quarto é aplicar o processo completo a mudanças triviais. Renomear um campo interno ou corrigir um texto não exige a mesma cerimônia de uma alteração de permissão, pagamento ou dados. O processo precisa ser proporcional ao risco e à reversibilidade da mudança.

## Um ponto de partida para a próxima feature

Eu começaria com uma única funcionalidade que envolva alguma ambiguidade real. Antes de pedir implementação, responderia por escrito:

1. Qual problema será resolvido e para quem?
2. O que o usuário consegue fazer quando a feature estiver pronta?
3. Quais casos não fazem parte desta entrega?
4. Como será demonstrado que o comportamento está correto?
5. Quais mudanças exigem aprovação antes de acontecer?
6. Quais arquivos, dados ou ambientes o agente nunca pode tocar?

Esse ciclo de requisitos, design, especificação, testes e validação também estrutura o [treinamento em Spec-Driven Development da BP STRAT](https://www.bpstrat.com.br/servicos/treinamentos/sdd.html).

Depois disso, o agente pode transformar a spec em plano e tarefas. A equipe revisa os pontos que exigem decisão. A implementação deixa de depender da memória da conversa e passa a depender de um artefato que permanece no repositório.
