# Handoff: uma memória simples para agentes que não precisam lembrar de tudo

Published: 2026-10-01
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/handoff-memoria-simples-para-agentes/
Tags: Agentes de IA, Gestão de contexto, Handoff, Documentação, AGENTS.md

---

Existe uma tentação comum quando começamos a trabalhar com agentes de IA:
tentar fazer com que eles **lembrem de tudo**.

A conversa inteira. Todas as decisões. Todos os detalhes. Tudo o que aconteceu
ontem.

Na maior parte dos trabalhos, não preciso reconstruir cada passo. Preciso saber
qual era o objetivo, onde o trabalho parou e o que fazer em seguida.

É aí que entra o **handoff**.

## Passar o bastão

Handoff é a passagem de um trabalho entre turnos. Uma pessoa termina sua parte
e outra assume. Antes de sair, ela deixa registrado:

- o que foi feito;
- o que ficou pendente;
- quais decisões foram tomadas;
- onde estão os arquivos;
- quais verificações já foram executadas;
- qual deve ser o próximo passo.

Com agentes, funciona da mesma forma.

Em vez de depender indefinidamente de uma sessão extensa, encerramos num ponto
coerente e criamos um documento curto de passagem.

```text
sessão 1
   ↓
handoff.md
   ↓
sessão 2
```

A próxima sessão não precisa reconstruir toda a história. Precisa de contexto
suficiente para continuar e de referências que permitam verificar esse
contexto no projeto.

## Sessões crescem

Enquanto trabalhamos com um agente, a sessão acumula prompts, respostas,
arquivos, decisões, tentativas e correções. Esse contexto tem custo e limites.

Alguns sistemas conseguem compactá-lo. Na Responses API da OpenAI, por exemplo,
a [compactação](https://developers.openai.com/api/docs/guides/compaction)
carrega para a próxima janela um estado reduzido com informações dos turnos
anteriores. A própria documentação diz que esse estado é opaco e não foi feito
para leitura humana.

Isso ajuda a manter uma interação longa, mas resolve um problema diferente. A
compactação preserva contexto para o sistema continuar. O handoff registra, de
forma legível e deliberada, o que a próxima pessoa ou sessão precisa conferir.

Foi por isso que passei a preferir uma prática explícita:

> **Quando chego a um ponto de equilíbrio, faço o handoff.**

Registro o estado atual e posso começar outra sessão sem tratar a conversa
anterior como a única fonte de continuidade.

## Um handoff pode ser simples

Não é necessária uma plataforma especial. Um arquivo Markdown já resolve
bastante:

```markdown
# Handoff

Atualizado em: 2026-10-01

## Objetivo
Gerar a nova versão da proposta comercial.

## O que foi feito
- dados técnicos consolidados;
- template escolhido;
- primeira versão do HTML gerada.

## Decisões
- usar o template B;
- manter valores na moeda original;
- não incluir opcionais ainda.

## Verificações
- HTML aberto e revisado no navegador;
- valores comparados com dados/equalizacao.md.

## Pendências
- validar prazo;
- revisar condições comerciais;
- gerar PDF.

## Próximo passo
Confirmar o prazo com a área comercial antes de gerar o PDF.

## Arquivos
- output/proposta-v03.html
- dados/equalizacao.md
```

No dia seguinte, outra sessão lê esse arquivo, confere se os caminhos ainda
existem e continua.

Uma data de atualização ajuda a detectar um handoff antigo. Em projetos com
mudanças paralelas, também pode ser útil registrar a branch ou o commit usado
como referência. O documento continua curto, mas deixa de depender de um estado
implícito do repositório.

## Handoff não é memória completa

Essa distinção é importante. O handoff não tenta guardar tudo. Ele preserva **o
necessário para continuidade**.

É a diferença entre entregar para alguém centenas de páginas de conversa ou
dizer:

> Cheguei até aqui.<br>
> Estas decisões já foram tomadas.<br>
> Estes são os arquivos.<br>
> Falta fazer isto.

Para muitos trabalhos, isso é suficiente. Não é suficiente quando precisamos
reconstruir toda a sequência de mudanças, demonstrar uma aprovação formal ou
auditar cada ação. Nesses casos, o handoff deve apontar para o histórico do Git,
para registros de decisão, chamados, logs ou outros artefatos apropriados.

O `handoff.md` descreve o estado presente. O
[versionamento preserva os checkpoints](/posts/versionar-e-criar-checkpoints/)
que nos trouxeram até ele.

## O conhecimento permanente fica em outro lugar

O handoff também não substitui a base do agente.

Se durante o trabalho descobrimos uma regra permanente, ela provavelmente
deveria ir para o
[`AGENTS.md`](/artigos/agents-md-nao-e-um-readme/). Se
descobrimos um procedimento reutilizável, talvez deva virar uma skill. Se
produzimos um bom exemplo, ele pode permanecer entre os artefatos de referência.

Uma separação útil é:

```text
AGENTS.md
→ como trabalhar

skills/
→ como executar capacidades específicas

knowledge/
→ o que precisa ser conhecido

handoff.md
→ onde paramos
```

O handoff registra o estado do trabalho, não todo o conhecimento do agente. Se
uma regra continuar válida depois que a tarefa terminar, escondê-la no handoff
torna essa regra difícil de reencontrar.

## Manter o handoff confiável

Um handoff pode falhar mesmo estando bem escrito. Isso acontece quando ele fica
desatualizado, menciona arquivos que não existem mais ou declara como concluída
uma verificação que nunca foi executada.

Antes de encerrar a sessão, eu conferiria quatro coisas:

1. os caminhos citados existem;
2. decisões estão separadas de sugestões ainda não aprovadas;
3. verificações executadas estão separadas das que ainda faltam;
4. o próximo passo pode ser iniciado sem reler a conversa inteira.

Também não transformaria o `handoff.md` em um diário acumulativo. Quando uma
pendência for resolvida, o estado deve ser atualizado. Se o histórico for
importante, ele já tem lugares melhores para viver.

## Isso permite descartar sessões

Quando existe um handoff confiável, a sessão deixa de ser um ativo precioso.

Podemos encerrá-la, abrir outra, trocar de modelo, retomar o trabalho amanhã ou
passar a tarefa para outra pessoa. Essa portabilidade tem limites: modelos e
ferramentas diferentes podem interpretar instruções de maneiras diferentes.
Ainda assim, um estado legível e verificável reduz a dependência de uma conversa
específica.

Essa prática complementa a ideia de que
[todo agente acorda com amnésia](/posts/todo-agente-acorda-com-amnesia/).
Não precisamos impedir a amnésia. Precisamos deixar o projeto preparado para
continuar apesar dela.

## Uma memória pequena pode ser melhor

Existem projetos que exigem mecanismos de memória mais sofisticados. Um agente
que acompanha relacionamentos durante meses, atende muitas pessoas ou precisa
recuperar milhares de fatos não deveria depender apenas de um arquivo Markdown.

Para trabalhos com começo, estado atual e próximo passo reconhecíveis, eu
começaria pela solução mais simples:

**persistir o que importa e passar o bastão.**

O objetivo não é fazer o agente lembrar de tudo. É garantir que ele saiba
**onde estamos e para onde devemos ir**.

Às vezes, uma boa memória não é aquela que guarda tudo. É aquela que registra o
necessário e deixa claro o que pode ser esquecido.
