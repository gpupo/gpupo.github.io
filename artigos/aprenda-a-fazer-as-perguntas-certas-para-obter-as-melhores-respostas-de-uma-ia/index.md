# Como pedir trabalho a uma IA: contexto, critérios e verificação

Published: 2023-03-08
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/aprenda-a-fazer-as-perguntas-certas-para-obter-as-melhores-respostas-de-uma-ia/
Tags: IA, Prompt Engineering

---

Uma pergunta clara ajuda um modelo de linguagem, mas não garante uma resposta correta. O prompt define o trabalho esperado; fontes, ferramentas, testes e revisão determinam quanto podemos confiar no resultado.

Essa diferença importa porque conversar com uma pessoa e instruir um modelo não são a mesma atividade. Uma pessoa pode relatar uma experiência, assumir responsabilidade e explicar uma decisão que tomou. Um modelo gera uma resposta a partir do contexto e dos padrões aprendidos. Quando perguntamos “como você chegou a essa conclusão?”, a explicação também é uma saída gerada, não um registro auditável do processo interno.

Eu trataria prompting como especificação e avaliação, não como a arte de encontrar palavras mágicas.

## Comece pela tarefa, não pela persona

“Você é o melhor especialista do mundo” acrescenta autoridade ao tom, mas não fornece os dados necessários para resolver um problema.

Um pedido operacional começa pelo verbo e pelo objeto:

```text
Compare as duas configurações de deploy fornecidas abaixo.
Identifique diferenças que alterem disponibilidade, custo ou rollback.
```

Depois entram contexto, limites e formato. A [documentação de prompting do Google][1] recomenda instruções claras, contexto relevante, exemplos e definição do formato de saída. Ela também trata prompting como processo iterativo, não como receita estática.

## As partes de um prompt verificável

Para tarefas profissionais, eu procuro deixar seis campos distinguíveis:

```yaml
tarefa: o que precisa ser feito
contexto: dados e documentos disponíveis
restricoes: o que não pode ser assumido ou alterado
saida: formato e nível de detalhe esperados
criterios: como reconhecer uma resposta aceitável
incerteza: o que fazer quando faltar evidência
```

Nem todo prompt precisa usar YAML. A estrutura serve para conferir se uma informação importante ficou implícita.

Compare dois pedidos.

```text
Explique qual configuração é melhor.
```

```text
Compare os arquivos A e B apenas com base no conteúdo fornecido.

Avalie:
- tempo de rollback;
- dependências externas;
- impacto de uma falha parcial;
- esforço operacional.

Para cada conclusão, cite o trecho que a sustenta.
Se os arquivos não permitirem decidir, identifique a informação ausente.
Entregue uma tabela e uma recomendação de até três parágrafos.
```

O segundo prompt não torna o modelo mais inteligente. Ele reduz ambiguidades e cria condições para revisar a resposta.

## Contexto não é sinônimo de volume

Adicionar documentos pode melhorar a base factual, mas contexto excessivo também dificulta localizar o que importa. Eu incluiria o material necessário e indicaria sua função:

```text
<politica_atual>
...
</politica_atual>

<mudanca_proposta>
...
</mudanca_proposta>

Use a política atual como fonte de restrições.
Use a mudança proposta apenas como objeto da revisão.
```

Delimitadores ajudam a separar dados de instruções. Quando o conteúdo vem de usuários ou fontes externas, o agente também precisa ser instruído a tratar comandos encontrados dentro desse conteúdo como dados, não como novas ordens.

## Exemplos definem melhor do que adjetivos

“Seja conciso” permite muitas interpretações. Um exemplo mostra tamanho, estrutura e densidade esperados.

```text
Entrada: serviço sem health check
Saída: alto risco — o orquestrador não consegue distinguir inicialização de falha.

Entrada: segredo incluído na imagem
Saída: alto risco — a credencial permanece no artefato e precisa ser rotacionada.
```

Esses exemplos orientam o formato, mas também podem estreitar demais a resposta. Eu usaria casos variados e manteria um conjunto separado para avaliar se o prompt funciona fora dos exemplos fornecidos.

## Perguntas de acompanhamento ainda ajudam

Uma primeira resposta pode revelar que a tarefa estava mal definida. Perguntas de acompanhamento servem para acrescentar evidência ou ajustar critérios:

* “Qual trecho do documento sustenta essa afirmação?”
* “Quais informações faltam para decidir?”
* “Reavalie considerando que o serviço não pode ficar indisponível.”
* “Transforme as recomendações em testes executáveis.”
* “Compare a saída com estes três critérios de aceitação.”

Perguntar apenas “você tem certeza?” costuma produzir outra formulação, não uma verificação independente. Para verificar, é melhor fornecer uma fonte, executar um teste, consultar uma ferramenta ou pedir uma comparação que possa ser inspecionada.

## Os cinco porquês podem fabricar uma causa

A técnica dos cinco porquês ajuda equipes a explorar relações causais, mas um modelo pode preencher cada resposta com uma narrativa plausível sem acesso ao incidente real.

Considere este começo:

```text
Por que o deploy falhou?
```

Sem logs, configuração e linha do tempo, qualquer sequência causal é hipótese. Um prompt mais responsável seria:

```text
Com base apenas nos logs abaixo, liste até três hipóteses para a falha.
Para cada hipótese, informe:
- evidência favorável;
- evidência contrária;
- próximo teste;
- resultado que descartaria a hipótese.
```

O modelo passa a organizar uma investigação sem fingir que encontrou a causa.

## Fluência não é evidência

O perfil de risco para IA generativa do [NIST][2] usa o termo *confabulation* para conteúdo falso ou incorreto apresentado com confiança. Um prompt detalhado pode reduzir erros em uma tarefa, mas não elimina esse comportamento.

Eu aumentaria a exigência de verificação quando a resposta envolve:

* informação recente;
* números ou cálculos;
* saúde, direito ou finanças;
* segurança e privacidade;
* ações difíceis de reverter;
* afirmações sobre pessoas;
* comandos que alteram produção ou dados.

Nesses casos, a resposta deve apontar fontes, executar ferramentas adequadas ou ser revisada por alguém responsável pelo domínio.

## Avalie o sistema, não o melhor exemplo

Um prompt não está validado porque funcionou uma vez. Para uma tarefa recorrente, eu manteria casos de teste com entradas normais, ambíguas, incompletas e adversariais.

```yaml
caso:
entrada:
resultado_esperado:
criterios_de_avaliacao:
falhas_inaceitaveis:
```

Depois de mudar prompt, modelo ou ferramentas, o conjunto precisa ser executado novamente. A comparação mostra se a alteração melhorou o comportamento desejado ou apenas resolveu o exemplo que estava visível.

## O próximo prompt precisa deixar rastros

Uma boa instrução reduz interpretações, define o formato e diz o que fazer quando a evidência não basta. Uma boa aplicação acrescenta fontes, testes, permissões e revisão proporcional ao risco.

Na próxima tarefa, eu começaria retirando a persona decorativa e escrevendo tarefa, contexto, restrições, critérios e tratamento da incerteza. Se a resposta não puder ser conferida, o problema não se resolve com uma pergunta mais elegante: falta um mecanismo de verificação.

[1]: https://ai.google.dev/gemini-api/docs/prompting-strategies "Prompt design strategies — Google AI for Developers"
[2]: https://doi.org/10.6028/NIST.AI.600-1 "Artificial Intelligence Risk Management Framework: Generative Artificial Intelligence Profile — NIST"
