# Uma Skill é muito menos mágica do que parece

Published: 2026-10-01
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/uma-skill-e-muito-menos-magica-do-que-parece/
Tags: Agentes de IA, Skills, Gestão de contexto, Documentação

---

Quando começamos a trabalhar com agentes de IA, rapidamente aparece uma palavra
nova: **Skill**.

Há repositórios, catálogos e pacotes com dezenas delas. A linguagem ao redor do
conceito pode fazer parecer que estamos diante de algum componente muito
sofisticado.

Vale tirar um pouco da fumaça.

Como modelo mental, uma Skill é algo simples:

**uma instrução organizada para poder ser reutilizada.**

Na implementação descrita pela
[documentação oficial da OpenAI](https://developers.openai.com/api/docs/guides/tools-skills),
uma Skill é um diretório ancorado por um arquivo `SKILL.md`. Esse diretório pode
conter apenas instruções, mas também pode incluir referências, scripts e
templates. Portanto, ela pode ser maior do que um prompt, embora continue sendo
menos misteriosa do que o nome sugere.

## Um exemplo simples

Imagine que vários agentes de uma empresa precisam consultar o mesmo CRM.

Todos precisam saber:

- onde procurar;
- quais campos importam;
- como interpretar determinadas informações;
- quais regras devem respeitar;
- o que podem ou não alterar.

Uma opção seria repetir essas instruções dentro de cada `AGENTS.md`:

```text
agente-comercial
    └── instruções para consultar CRM

agente-documentos
    └── instruções para consultar CRM

agente-pos-venda
    └── instruções para consultar CRM
```

Funciona. Mas agora temos três cópias da mesma coisa. Quando a regra mudar,
precisamos lembrar de alterar as três.

É aí que uma Skill começa a fazer sentido:

```text
skills/
└── consultar-crm/
    ├── SKILL.md
    ├── references/
    │   └── campos-do-crm.md
    └── scripts/
        └── consultar-cliente.sh
```

Nem toda Skill precisa dessas pastas adicionais. Se a instrução for suficiente,
o diretório pode conter apenas `SKILL.md`:

```markdown
---
name: consultar-crm
description: Consulte dados comerciais no CRM quando a tarefa depender do histórico de um cliente.
---

Use o identificador do cliente informado na tarefa.

Consulte apenas os campos necessários para responder à solicitação.

Não altere registros sem autorização explícita.

Informe quando um dado não estiver disponível ou estiver desatualizado.
```

Nome e descrição ajudam o agente a reconhecer **o que a capacidade faz e quando
deve considerá-la**. O corpo contém as instruções completas.

Os agentes que precisam dessa capacidade passam a reutilizar a mesma fonte.
Isso é composição.

## Skill não é a ferramenta

No exemplo do CRM, a Skill não cria acesso ao sistema. O agente ainda precisa de
uma ferramenta, API ou conexão que consiga consultar os dados, além das
credenciais e permissões adequadas.

A separação fica assim:

```text
Skill
→ quando e como executar o trabalho

ferramenta ou API
→ consultar ou alterar o sistema

permissões
→ limitar aquilo que pode ser feito
```

Essa distinção importa especialmente para operações de escrita. Uma frase como
“não altere registros sem autorização” ajuda a orientar o agente, mas uma
operação crítica também deveria ser protegida pela própria ferramenta ou por um
fluxo de aprovação. Instrução não substitui controle de acesso.

Uma Skill também não é um agente independente. Ela oferece uma capacidade que
o agente pode usar dentro de um trabalho maior. Essa diferença é discutida com
mais detalhes em
[AI Skills são fluxos reutilizáveis, não agentes](/posts/ai-skills-como-capacidades-configuradas/).

## Skill é uma forma de reaproveitar conhecimento

Podemos ter Skills como:

```text
consultar-crm
gerar-documento
validar-documento
versionar-projeto
fazer-handoff
comparar-propostas
```

Uma capacidade pode ser usada por vários agentes sem que cada um mantenha uma
cópia independente das instruções.

Isso se parece com algo que fazemos há décadas em software: encontramos uma
responsabilidade coerente, damos um nome, definimos sua interface e passamos a
compor coisas maiores a partir dela.

A analogia tem limite. Skills não são necessariamente funções determinísticas.
O modelo ainda interpreta as instruções, e o resultado pode variar. Reutilizar
uma Skill reduz duplicação; não garante, por si só, que todas as execuções serão
iguais.

## Carregar quando necessário

Skills também ajudam a controlar contexto.

Imagine um `AGENTS.md` contendo absolutamente tudo que um agente talvez precise
saber:

- gerar documentos;
- consultar CRM;
- analisar planilhas;
- escrever atas;
- produzir PDFs;
- versionar arquivos;
- verificar contratos;
- fazer pesquisas.

Numa tarefa específica, talvez ele precise apenas consultar o CRM. Colocar todas
as instruções detalhadas no contexto principal aumenta o volume que precisa ser
considerado mesmo quando a maior parte não se aplica.

Na implementação documentada pela OpenAI, o agente vê primeiro o nome, a
descrição e o caminho das Skills disponíveis. Quando escolhe uma delas, lê o
`SKILL.md` e os arquivos de apoio necessários. É uma forma de revelar detalhes
progressivamente:

```text
consultar-crm
→ use quando a tarefa exigir o histórico comercial de um cliente
→ carregue as instruções completas quando a capacidade for necessária
```

Esse mecanismo pode melhorar duas coisas ao mesmo tempo: **reuso e foco**.

Isso não significa que menos contexto seja sempre melhor. Pouco contexto pode
omitir uma regra decisiva. O objetivo é manter no contexto permanente aquilo
que vale para todo o trabalho e carregar detalhes especializados quando eles
passarem a ser relevantes.

## Quando transformar algo em Skill?

Uma boa pergunta é:

> **Estou ensinando isso novamente?**

Se a resposta for sim, talvez exista uma Skill esperando para ser criada.

Eu procuraria também outros sinais:

- existe uma situação reconhecível que deve ativar a capacidade;
- as instruções produzem um resultado identificável;
- há regras, exemplos ou templates que precisam permanecer juntos;
- mais de um agente ou projeto pode reutilizar o procedimento;
- a capacidade muda num ritmo diferente das regras gerais do agente.

Outra situação aparece quando o `AGENTS.md` começa a crescer demais. Há trechos
fundamentais para qualquer tarefa daquele projeto. Esses provavelmente devem
continuar ali. Outros só importam ocasionalmente e podem ser extraídos.

Uma separação possível:

```text
AGENTS.md
→ responsabilidade, limites e regras permanentes do projeto

skills/
→ capacidades específicas usadas quando necessário
```

Essa fronteira não é universal. Se uma regra precisa ser obedecida em toda
tarefa, escondê-la numa Skill opcional aumenta o risco de ela não ser carregada.
Nesse caso, o
[`AGENTS.md`](/artigos/agents-md-nao-e-um-readme/)
continua sendo um lugar mais adequado.

## Skills também podem evoluir

Depois que uma capacidade foi separada, ela deixa de pertencer exclusivamente a
um agente. Pode ser melhorada uma vez e reutilizada em vários lugares.

```text
              consultar-crm
              /     |     \
             /      |      \
       comercial documentos pós-venda
```

O aprendizado deixa de ficar preso ao lugar onde aconteceu e vira uma peça
reutilizável. Essa vantagem também cria uma responsabilidade: uma mudança na
Skill pode afetar vários consumidores.

Por isso, eu versionaria essas mudanças e testaria os fluxos que dependem dela.
Uma alteração centralizada é mais fácil de distribuir, mas também centraliza o
risco de regressão.

## Uma Skill precisa ser revisada

O formato simples não torna uma Skill inofensiva. Suas instruções podem
influenciar planejamento, uso de ferramentas e execução de comandos. Se houver
scripts, eles podem executar código no ambiente quando forem acionados.

A documentação da OpenAI recomenda tratar Skills como instruções privilegiadas
e revisar pacotes de terceiros antes de disponibilizá-los ao agente. Eu
aplicaria o mesmo cuidado usado para uma dependência:

- entender de onde veio;
- ler o `SKILL.md`;
- inspecionar scripts e referências;
- verificar quais ferramentas e dados ela pode alcançar;
- limitar ações destrutivas ou de escrita;
- testar com entradas representativas.

Um catálogo grande não é automaticamente uma vantagem. A procedência e a
qualidade das capacidades importam mais do que a quantidade instalada.

## Não transforme tudo em Skill

Também existe o exagero contrário.

Se criarmos uma Skill para cada pequena instrução, apenas substituímos um
arquivo grande por centenas de diretórios difíceis de entender, descobrir e
manter.

O objetivo não é maximizar o número de Skills. É encontrar capacidades com
**coerência, um gatilho reconhecível e potencial de reutilização**.

Depois dessa separação, ainda resta decidir quanto detalhe colocar nas
instruções. Em
[AI Skills para GPT-5.6 Sol: menos instrução, mais contrato](/artigos/ai-skills-para-gpt-5-6-sol-menos-instrucao-mais-contrato/),
mostro como tenho revisado Skills antigas para preservar restrições e critérios
de conclusão sem microgerenciar cada passo.

## Menos mágica, mais engenharia

A parte interessante das Skills não está em alguma inteligência escondida
dentro delas. Está na organização.

Pegamos uma instrução que funcionou. Damos um nome. Explicamos quando deve ser
usada. Juntamos os recursos necessários. Separamos do restante do contexto. E
passamos a reutilizá-la.

Em vez de imaginar Skills como poderes especiais instalados no agente, prefiro
uma descrição menos emocionante:

> **Skills são conhecimento operacional empacotado para reutilização.**

É justamente quando o conceito parece menos mágico que ele começa a ficar mais
útil.
