# A janela de contexto também é uma variável de custo

Published: 2026-04-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/custo-da-janela-de-contexto/
Tags: LLM, IA, Custos, Desenvolvimento, Observabilidade

---

Durante o trabalho com LLMs em produção, uma coisa ficou evidente: o custo de uma execução não depende apenas do modelo escolhido. O tamanho da janela de contexto também muda a conta.

Uma sessão de desenvolvimento pode acumular arquivos, histórico, instruções, resultados de ferramentas e mensagens. Quando o contexto cresce, cada nova chamada pode carregar uma quantidade maior de entrada, mesmo que a pergunta final seja curta.

## O limite precisa ser visível

Em uma configuração que usei, alguns modelos tinham um salto de preço quando a entrada passava de determinado limiar, próximo de 200 mil tokens. Esse valor não deve ser tratado como regra universal: preços, modelos e formas de cobrança mudam.

O princípio continua válido. Se o sistema não mostra o tamanho real da requisição, a equipe descobre o custo apenas na fatura.

Eu adicionei ao meu agente de codificação um alerta para avisar quando a sessão atravessa um limite configurado. O alerta não interrompe automaticamente o trabalho. Ele permite decidir se vale compactar o histórico, abrir uma nova sessão ou continuar pagando pelo contexto acumulado.

## O que medir

Para controlar o custo, eu acompanharia:

- tokens de entrada por chamada;
- tokens de saída;
- contexto acumulado na sessão;
- custo estimado por tarefa;
- número de compactações e reinícios;
- resultado obtido depois da redução de contexto.

Também separaria contexto necessário de contexto conveniente. Um repositório inteiro pode parecer útil, mas instruções irrelevantes, logs antigos e respostas repetidas aumentam o volume sem melhorar a decisão.

Além do volume, [a capacidade efetiva de um contexto longo](https://www.bpstrat.com.br/post/longer-context/) precisa ser testada na tarefa real: o limite anunciado não garante que o modelo localizará e usará cada informação com a mesma qualidade.

## Compactar sem perder a tarefa

Compactação não deveria ser apenas cortar mensagens antigas. Eu preservaria o objetivo, as restrições, decisões já tomadas, arquivos alterados, testes executados e problemas ainda abertos. O resumo precisa ser um artefato verificável, não uma nova fonte de ambiguidade.

Em tarefas com codebase grande, o custo de contexto precisa entrar no desenho do workflow. Antes de colocar uma automação em produção, eu mediria o tamanho típico das requisições e definiria um orçamento por tarefa.

O modelo é uma parte do custo. O contexto que enviamos a ele também é uma decisão de engenharia.
