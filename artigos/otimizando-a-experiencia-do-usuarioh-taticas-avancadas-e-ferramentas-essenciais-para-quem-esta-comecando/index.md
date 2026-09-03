# Ferramentas de UX não substituem método: escolha pelo que precisa aprender

Published: 2023-03-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/otimizando-a-experiencia-do-usuarioh-taticas-avancadas-e-ferramentas-essenciais-para-quem-esta-comecando/
Tags: Produto, UX, Pesquisa com usuários

---

Uma lista de ferramentas de UX envelhece rápido. Produtos mudam de preço, perdem funcionalidades, são descontinuados ou deixam de atender às regras de segurança de uma empresa. O problema que o time precisa compreender costuma durar mais do que a ferramenta.

Por isso, eu não começaria escolhendo entre Figma, uma plataforma de analytics, gravação de sessões ou testes remotos. Começaria pela decisão que precisa ser tomada e pela evidência que falta.

```text
decisão → pergunta → método → evidência → ferramenta
```

Inverter essa sequência cria pesquisa guiada pelo que o software consegue fazer, não pelo que o produto precisa aprender.

## Descobrir o problema

Quando a equipe ainda não entende como uma tarefa acontece, entrevistas e observação contextual podem revelar etapas, restrições e soluções improvisadas pelas pessoas.

Perguntas úteis nessa fase:

* o que a pessoa está tentando concluir?
* onde a tarefa começa e termina fora da tela?
* quais ferramentas, documentos e pessoas participam?
* o que acontece quando algo falha?
* quais usuários não aparecem nos dados atuais?

O resultado esperado não é uma coleção de opiniões, mas evidência organizada sobre comportamentos e necessidades. Uma planilha e um documento compartilhado podem ser suficientes para começar.

O [Service Manual do GOV.UK][1] recomenda escolher atividades de pesquisa de acordo com a pergunta, a fase do serviço, o tempo, o custo e o acesso a participantes. Para times com pouca experiência, métodos simples e compreensíveis, como entrevistas e testes de usabilidade, tendem a ser um ponto de partida mais operável.

## Testar uma ideia antes do código

Quando o problema está mais claro, um protótipo ajuda a verificar fluxo, conteúdo e hierarquia antes de investir na implementação completa.

A fidelidade deve acompanhar a pergunta:

| Pergunta | Artefato suficiente |
| --- | --- |
| A sequência faz sentido? | Fluxo em papel ou wireframe |
| As pessoas entendem os rótulos? | Protótipo navegável simples |
| A interação funciona com teclado? | Protótipo em código |
| O tempo de resposta altera a tarefa? | Implementação próxima do ambiente real |

Um protótipo visual de alta fidelidade não responde bem a perguntas sobre desempenho, integração, leitor de tela ou comportamento de dados reais. Escolher fidelidade alta cedo demais pode aumentar o custo sem aumentar a evidência.

## Observar pessoas executando tarefas

Em um teste de usabilidade moderado, participantes tentam concluir tarefas enquanto a equipe observa o que fazem e onde encontram dificuldade. O objetivo não é perguntar se gostaram da tela, mas verificar se conseguem usá-la.

O [guia de testes moderados do GOV.UK][2] recomenda definir previamente perguntas de pesquisa, perfis de participantes e partes do serviço que serão avaliadas.

Eu registraria cada sessão de maneira comparável:

```yaml
tarefa:
concluiu: sim | com_ajuda | nao
tempo_aproximado:
erros_observados:
trechos_que_geraram_duvida:
intervencoes_do_moderador:
observacoes:
```

O número de participantes depende do método, da diversidade do público e da confiança necessária. Repetir automaticamente “cinco usuários são suficientes” ignora segmentos, tarefas e riscos diferentes.

## Medir o produto em uso

Analytics ajuda a observar comportamento agregado: início e conclusão de tarefas, erros, retorno, abandono e tempo entre etapas. Gravações de sessão podem oferecer mais detalhe sobre interação, mas também aumentam o risco de capturar dados pessoais ou sensíveis.

Antes de instalar uma ferramenta, eu definiria:

* quais eventos respondem à pergunta do produto;
* quais campos não devem ser coletados;
* como consentimento e transparência serão tratados;
* quem acessará os dados;
* por quanto tempo serão mantidos;
* como ambientes internos e robôs serão excluídos;
* como a instrumentação será testada.

Um dashboard cheio não compensa eventos ambíguos. “Clique no botão” informa pouco se a equipe não consegue ligar o evento a uma tarefa, estado ou resultado.

## Avaliar acessibilidade desde o início

Validadores automáticos encontram parte dos problemas, como atributos ausentes ou algumas combinações de contraste. Eles não conseguem determinar sozinhos se um serviço é acessível.

A [W3C Web Accessibility Initiative][3] recomenda combinar ferramentas com avaliação humana qualificada. Testes com teclado, leitores de tela, ampliação, diferentes dispositivos e pessoas com deficiência acrescentam evidências que uma varredura automática não produz.

Acessibilidade também altera a escolha da ferramenta de prototipação e pesquisa. Se o protótipo não funciona com a tecnologia assistiva usada pelo participante, o teste está avaliando o limite do protótipo, não necessariamente a solução proposta.

## Escolher a ferramenta depois do método

Com a pergunta e o método definidos, eu compararia ferramentas por critérios operacionais:

| Critério | Pergunta de decisão |
| --- | --- |
| Acesso | Participantes e equipe conseguem usar sem barreiras? |
| Privacidade | Que dados a ferramenta coleta, processa e retém? |
| Integração | Ela funciona com os artefatos e ambientes existentes? |
| Exportação | Os dados podem ser retirados em formato utilizável? |
| Permissões | É possível separar quem pesquisa, observa e administra? |
| Custo total | Licença, recrutamento, treinamento e operação cabem no projeto? |
| Acessibilidade | A ferramenta permite incluir pessoas e tecnologias assistivas relevantes? |
| Continuidade | O time consegue migrar se o produto mudar ou for encerrado? |

Esse quadro explica por que não existe uma ferramenta “essencial” para todo time. Uma plataforma completa pode ser adequada para pesquisa contínua em vários países e excessiva para validar o fluxo de um produto interno.

## Um fluxo pequeno para começar

Para uma equipe que ainda não tem prática de UX, eu começaria com um ciclo curto:

1. Escolher uma dúvida que bloqueia uma decisão de produto.
2. Identificar quais pessoas vivem aquela situação.
3. Selecionar o método mais simples capaz de produzir evidência.
4. Preparar roteiro, tarefa ou protótipo.
5. Registrar consentimento e proteger os dados coletados.
6. Executar a pesquisa e separar observação de interpretação.
7. Decidir o que muda e qual pergunta continua aberta.

O artefato final pode ser uma decisão de não construir, uma mudança de conteúdo, um novo evento de analytics ou outra rodada de pesquisa. Produzir muitas telas não é medida de avanço.

## O que saiu da versão anterior

A primeira versão deste artigo listava vinte ferramentas e atribuía o sucesso de Spotify, Netflix, Slack, Airbnb e Nubank a práticas de UX sem apresentar fontes ou isolar outros fatores. Esses exemplos foram removidos.

Casos empresariais podem ser úteis quando apresentam contexto, decisão, métrica e limitação. Nomes conhecidos, sozinhos, apenas emprestam autoridade ao argumento.

Para a próxima dúvida de UX, eu escreveria primeiro a decisão e a evidência ausente. Se uma ferramenta não melhora a capacidade de responder essa pergunta, ela não é essencial para aquele trabalho.

[1]: https://www.gov.uk/service-manual/user-research/plan-user-research-for-your-service "Plan user research for your service — GOV.UK"
[2]: https://www.gov.uk/service-manual/user-research/using-moderated-usability-testing "Using moderated usability testing — GOV.UK"
[3]: https://www.w3.org/WAI/test-evaluate/ "Evaluating Web Accessibility — W3C"
