# PRD.md: como dar contexto de produto aos agentes de IA

Published: 2026-08-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/prd-md-contexto-produto-agentes-ia/
Tags: Documentação para agentes, Produto, Agentes de IA, Inteligência Artificial, Desenvolvimento, Documentação

---

Um agente pode escrever código correto e ainda construir o produto errado.

Isso acontece quando ele recebe uma tarefa como “adicionar uma tela para exportar relatórios”, mas não conhece as decisões que produziram essa tarefa. Quem precisa exportar? Para qual uso? Quais dados podem sair do sistema? O que está fora do escopo? Como verificar se a mudança resolveu o problema?

Sem essas respostas, o agente precisa preencher as lacunas. Pode incluir PDF quando bastava CSV, criar agendamento sem necessidade ou ignorar os filtros ativos. Cada escolha pode ser tecnicamente defensável e, ao mesmo tempo, incompatível com o produto.

Um `PRD.md` mantido próximo do código é uma forma de tornar esse contexto consultável durante a implementação. Neste artigo, uso o nome para um documento de requisitos de produto em Markdown. O formato não é uma especificação universal: o que importa é registrar a intenção e os limites da mudança antes de pedir ao agente que a execute.

## A tarefa mostra a saída; o PRD explica a decisão

Compare estas duas instruções:

> Implementar autenticação por e-mail.

e:

> Precisamos reduzir a fricção de acesso para usuários ocasionais. Não queremos administrar senhas. O login deve usar um link temporário enviado por e-mail e expirar após o período definido pelo produto.

A primeira permite cadastro com senha, recuperação de senha, autenticação social e outras decisões adjacentes. A segunda restringe o espaço de solução: informa o problema, o público e uma escolha de produto que a implementação precisa preservar.

O `PRD.md` cumpre esse papel quando responde, pelo menos, a estas perguntas:

* que situação precisa mudar;
* quem é afetado por ela;
* qual resultado se espera;
* quais comportamentos são obrigatórios;
* o que não será feito agora;
* quais restrições alteram a solução;
* como o trabalho será aceito;
* quais decisões continuam em aberto.

Ele não precisa antecipar cada detalhe técnico. Precisa reduzir as decisões de produto que o agente teria de inventar.

## Um PRD mínimo para uma mudança pequena

O tamanho do documento deve acompanhar o risco, a ambiguidade e o impacto da mudança. Uma exportação de tabela pode começar com algo assim:

```md
# Exportação CSV

## Problema

Usuários copiam manualmente os dados da tabela para planilhas antes
das reuniões semanais. A cópia perde os filtros aplicados na tela.

## Objetivo

Permitir que o usuário exporte os mesmos dados que está visualizando,
sem reconstruir os filtros na planilha.

## Requisitos

- Exportar todas as linhas que correspondam aos filtros ativos.
- Gerar o arquivo em CSV com codificação UTF-8.
- Preservar a ordem visível das colunas.
- Usar o fuso horário atual na representação de datas.

## Fora do escopo

- Exportações agendadas.
- Seleção personalizada de colunas.
- Envio do arquivo por e-mail.
- Exportação em PDF.

## Critérios de aceitação

- O arquivo baixado corresponde aos filtros ativos.
- Caracteres acentuados abrem corretamente nos aplicativos de
  planilha adotados pelo time.
- Uma consulta sem resultados gera um arquivo apenas com o cabeçalho.

## Questões em aberto

- Registros arquivados devem aparecer quando o filtro não os exclui?
```

O exemplo ainda deixa uma decisão aberta. Isso é preferível a escondê-la e permitir que o agente escolha sem perceber que está tomando uma decisão de produto.

Também não há uma seção de métricas de sucesso. Para uma mudança pequena, talvez os critérios de aceitação sejam suficientes. Se o objetivo inclui reduzir tempo operacional, aumentar adoção ou diminuir erros, a métrica precisa aparecer com sua forma de medição. Caso contrário, basta não inventá-la para completar o template.

## O que cada seção impede o agente de presumir

Um PRD maior pode incluir mais detalhes, mas cada seção deve responder a uma necessidade concreta.

| Seção | Decisão que torna explícita |
| --- | --- |
| Contexto | Onde a funcionalidade se encaixa e em quais condições será usada |
| Problema | O que ocorre hoje e por que vale mudar |
| Usuários | Quem executa a ação e quem é afetado por ela |
| Objetivo | Qual mudança de comportamento ou resultado se espera |
| Fora do escopo | Quais recursos relacionados não pertencem à entrega |
| Requisitos funcionais | Quais comportamentos podem ser observados |
| Requisitos não funcionais | Quais limites de segurança, privacidade, acessibilidade, desempenho ou operação importam |
| Fluxo principal | Como as ações se conectam do início ao resultado |
| Casos de erro | Quais falhas precisam de comportamento definido |
| Critérios de aceitação | Como implementação, testes e revisão verificarão a entrega |
| Métricas de sucesso | Como o time avaliará se a mudança foi útil depois de entregue |
| Questões em aberto | Onde ainda é necessária uma decisão humana |

Nem toda funcionalidade precisa de todas essas seções. Preencher um campo com linguagem genérica apenas para manter o documento completo cria volume, não contexto.

“Interface intuitiva”, “alta performance” e “solução escalável”, por exemplo, não oferecem um critério verificável. Se o tempo de resposta altera o uso do produto, registre o limite e as condições de medição. Se não há um limite decidido, deixe a questão visível em vez de escolher um número arbitrário.

## Não objetivos funcionam como limite de execução

Agentes são capazes de implementar recursos adjacentes porque eles parecem coerentes com a tarefa. Em uma funcionalidade de diagnóstico de incidentes, registrar a causa e a próxima ação pode sugerir um fluxo completo de post-mortem, execução automática de correções e publicação de relatórios para clientes.

Esses recursos podem ser úteis em outro momento. Se não fazem parte da decisão atual, devem aparecer como não objetivos:

```md
## Fora do escopo

- Substituir a plataforma atual de tickets.
- Criar um fluxo completo de post-mortem.
- Executar ações de correção automaticamente.
- Publicar relatórios de incidente para clientes.
```

Essa lista não serve apenas para planejar prazo. Ela ajuda o agente e o revisor a reconhecer crescimento involuntário de escopo.

## O PRD precisa entrar no fluxo do agente

Antes do PRD, a [análise de oportunidades do Canal do Produto com IA](https://www.bpstrat.com.br/servicos/canal-do-produto-ia.html) cobre uma etapa anterior: mapear onde a IA pode assumir trabalho no produto e quais riscos, métricas e controles precisam entrar no desenho.

Deixar o arquivo no repositório não garante que ele será consultado. A
instrução operacional pode ficar no [`AGENTS.md`](/artigos/agents-md-nao-e-um-readme/):

```md
Antes de implementar ou modificar o comportamento do produto:

1. Leia o PRD relacionado à mudança.
2. Identifique o objetivo, os não objetivos e os critérios de aceitação.
3. Verifique se a solicitação está dentro do escopo aprovado.
4. Não adicione recursos adjacentes sem um requisito explícito.
5. Informe conflitos entre a tarefa, o produto atual e o PRD.
6. Preserve as regras de negócio que o PRD não altera.
7. Atualize os testes de acordo com os critérios de aceitação.
```

Com essa instrução, o documento deixa de ser apenas uma referência para leitura humana. Ele passa a participar da implementação e da revisão.

Na revisão de código, a pergunta também muda. Além de verificar qualidade técnica, o revisor pode conferir se a implementação respeita o problema, os limites, os casos de erro e os critérios definidos. Um recurso fora do escopo deixa de parecer uma melhoria gratuita e passa a ser uma divergência que precisa de decisão.

## PRD não é especificação técnica

O PRD deve preservar a intenção do produto sem impedir que a engenharia escolha a implementação adequada.

Esta frase determina uma solução:

```md
Crie uma tabela PostgreSQL chamada `incident_diagnosis`, com chave
primária UUID, e exponha os dados por um endpoint REST.
```

Uma formulação de produto descreve o comportamento necessário:

```md
O sistema deve preservar cada diagnóstico enviado como um registro de
auditoria imutável, associado ao incidente e ao autor.
```

Banco, esquema e protocolo podem pertencer a uma especificação técnica. Se uma dessas escolhas já for uma restrição aprovada do produto, ela pode ser referenciada no PRD, com o motivo. A separação não precisa ser rígida; precisa impedir que uma preferência de implementação seja confundida com a necessidade do usuário.

Uma divisão de responsabilidades possível é:

| Artefato | Pergunta principal |
| --- | --- |
| `README.md` | O que é o projeto e como executá-lo? |
| `AGENTS.md` | Como o agente deve trabalhar neste repositório? |
| `PRD.md` | Que problema o produto resolve, para quem e dentro de quais limites? |
| `DESIGN.md` | Quais decisões visuais e de interação devem ser preservadas? |
| Especificação técnica | Como o sistema será alterado? |
| ADR | Por que uma decisão arquitetural relevante foi tomada? |
| Runbook | Como operar e recuperar o sistema? |

Essa divisão é uma recomendação de organização, não uma taxonomia obrigatória. Um produto pequeno pode manter um único `PRD.md` na raiz. Um projeto maior pode ter uma visão geral e documentos por funcionalidade em `docs/product/`. O critério é permitir que o agente encontre o contexto relevante sem atravessar documentos contraditórios.

## Documentação desatualizada também produz decisões erradas

O principal limite desse fluxo é a divergência entre documento e produto. O PRD perde valor quando o escopo muda em uma reunião, uma regra aparece apenas no ticket ou a implementação altera o comportamento sem atualizar a decisão registrada.

Por isso, o documento precisa de uma política de mudança. Uma regra inicial pode determinar sua atualização quando houver alteração em:

* problema ou público atendido;
* escopo aprovado;
* regra de negócio;
* critério de aceitação;
* requisito de privacidade ou permissão;
* definição de sucesso.

Detalhes de implementação que não alteram o comportamento do produto não exigem uma revisão do PRD.

A IA pode ajudar a organizar entrevistas, tickets, regras existentes e decisões anteriores em uma primeira versão. Ela também pode apontar lacunas. Prioridade, escopo e critérios de sucesso, porém, continuam sendo decisões pelas quais o time precisa assumir responsabilidade. Gerar um documento bem estruturado não valida automaticamente o conteúdo dele.

Para começar, escolha uma funcionalidade com ambiguidade recorrente e registre apenas problema, objetivo, fora do escopo e critérios de aceitação. Depois, instrua o agente a ler esse arquivo antes da próxima alteração e observe quais decisões ainda precisaram ser tomadas durante a implementação. Essas lacunas indicam o que vale acrescentar ao PRD; não a existência de um template maior.
