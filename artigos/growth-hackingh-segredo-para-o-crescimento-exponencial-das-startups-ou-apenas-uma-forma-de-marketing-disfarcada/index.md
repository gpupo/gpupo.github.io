# Growth hacking: experimentos de crescimento com limites claros

Published: 2023-03-08
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/growth-hackingh-segredo-para-o-crescimento-exponencial-das-startups-ou-apenas-uma-forma-de-marketing-disfarcada/
Tags: Produto, Startups, Marketing

---

Uma equipe muda o texto da página, cria um programa de indicação, reduz etapas do cadastro e compra uma nova fonte de tráfego. Todas as ações são chamadas de growth hacking, embora respondam a problemas diferentes e quase nunca compartilhem uma hipótese.

O termo ficou amplo demais para orientar uma decisão. Para torná-lo útil, eu o trataria como um processo de experimentação sobre aquisição, ativação, retenção, receita ou indicação, com métricas e limites definidos antes da execução.

## De onde veio o termo

Sean Ellis publicou em julho de 2010 o texto [Find a Growth Hacker for Your Startup][1]. O problema apresentado era específico: startups prontas para escalar contratavam perfis tradicionais de marketing sem priorizar a responsabilidade por crescimento.

O texto parte de condições importantes. Ellis se refere a empresas que já demonstraram *product-market fit* e um processo eficiente de conversão e monetização. A ideia não era aplicar truques para compensar um produto que ainda não resolvia um problema.

Essa origem é mais restrita do que o uso posterior da expressão. Ela também não prova que toda empresa precise de um cargo chamado growth hacker. O trabalho pode estar distribuído entre produto, marketing, engenharia, dados e operações, desde que responsabilidade e critérios estejam claros.

## O experimento começa pela restrição

“Aumentar usuários” não informa qual comportamento precisa mudar nem qual custo é aceitável. Antes de propor uma tática, eu registraria:

```yaml
objetivo:
etapa_da_jornada:
problema_observado:
hipotese:
mecanismo_esperado:
publico_afetado:
metrica_principal:
metricas_de_diagnostico:
guardrails:
custo:
duracao:
criterio_de_decisao:
```

Esse formato torna a ação discutível antes que o resultado seja conhecido. Também reduz a tentação de escolher retrospectivamente a métrica que melhorou.

## Uma indicação não é crescimento por definição

Imagine um produto usado semanalmente por pequenas equipes. Entrevistas mostram que administradores convidariam colegas, mas não encontram o fluxo de convite depois da configuração inicial.

Uma hipótese possível seria:

```text
Se colocarmos o convite no final da primeira configuração,
mais administradores adicionarão a equipe na mesma sessão,
porque a próxima etapa necessária estará visível no momento adequado.
```

O experimento poderia acompanhar:

```yaml
metrica_principal: administradores que enviam ao menos um convite
diagnostico:
  - convites enviados
  - convites aceitos
  - equipes ativas depois de quatro semanas
guardrails:
  - convites denunciados
  - cancelamentos
  - mensagens enviadas sem confirmação
```

Se os convites aumentarem e as equipes não se tornarem ativas, a intervenção moveu uma etapa intermediária sem demonstrar valor duradouro. Se denúncias aumentarem, o custo pode superar o ganho.

O exemplo não contém resultado porque nenhum experimento real foi fornecido. Ele mostra como formular a decisão sem fabricar sucesso.

## Aquisição pode ampliar um problema de retenção

Quando pessoas entram e abandonam o produto rapidamente, comprar mais tráfego aumenta o volume que atravessa um fluxo defeituoso.

Antes de investir em aquisição, eu procuraria entender:

* qual ação indica que o usuário encontrou valor;
* quanto tempo leva para chegar a essa ação;
* onde e por que as pessoas desistem;
* quais grupos permanecem e quais saem;
* se suporte e operação conseguem absorver o crescimento;
* se a receita adicional cobre aquisição e atendimento.

Essas perguntas não produzem uma regra universal de *product-market fit*. Elas expõem a hipótese que precisa ser verdadeira para escalar.

## Testar rápido não significa testar sem desenho

Alterar muitas coisas ao mesmo tempo torna difícil atribuir o resultado. Encerrar cedo quando a métrica sobe favorece leituras otimistas. Escolher apenas segmentos positivos depois de ver os dados transforma exploração em conclusão.

Para um experimento que sustente decisão, eu definiria antes:

1. unidade de análise e população;
2. evento que determina exposição;
3. métrica principal e guardrails;
4. duração ou tamanho necessário;
5. falhas de instrumentação que invalidam o teste;
6. tratamento de segmentos;
7. decisão para resultado positivo, neutro ou negativo.

Nem toda mudança precisa de teste A/B. Alterações pequenas e reversíveis podem ser publicadas gradualmente e avaliadas com métricas e pesquisa. Produtos com pouco volume talvez aprendam mais com entrevistas, suporte e testes de usabilidade do que com um experimento sem capacidade para distinguir sinal de ruído.

## O limite entre persuasão e manipulação

O crescimento se torna problemático quando a métrica melhora porque a interface esconde informação, dificulta uma escolha ou explora um erro do usuário.

A [Federal Trade Commission][2] descreve padrões manipulativos como custos ocultos, assinaturas difíceis de cancelar, anúncios disfarçados e hierarquia visual que direciona pessoas para uma opção diferente da intenção declarada.

Uma equipe pode observar aumento de conversão e ainda prejudicar o produto. Por isso, eu acrescentaria guardrails relacionados a:

* cancelamento e reembolso;
* reclamações e contatos de suporte;
* consentimento e uso de dados;
* cobranças contestadas;
* exclusão de conta;
* acessibilidade;
* compreensão dos termos;
* confiança e retenção depois da conversão.

Não basta perguntar se a tática é permitida. A equipe precisa verificar se a pessoa entende a decisão e consegue recusá-la ou revertê-la sem obstáculos artificiais.

## Produto, marketing e engenharia compartilham o sistema

Uma mudança de crescimento pode atravessar anúncio, página, cadastro, cobrança, notificações e comportamento do produto. Separar rigidamente as funções pode deixar cada equipe responsável apenas por sua métrica local.

Eu definiria uma pessoa responsável pelo experimento e envolveria as competências necessárias:

* produto esclarece problema e prioridade;
* pesquisa ajuda a entender comportamento e efeitos;
* design torna escolhas compreensíveis;
* engenharia implementa exposição, reversão e instrumentação;
* dados avalia qualidade da medição;
* marketing conecta mensagem, canal e público;
* jurídico e privacidade participam quando a intervenção afeta direitos ou dados.

Essa distribuição varia com o tamanho do time. O critério é conseguir reconstruir quem decidiu, qual hipótese foi testada e quais limites foram aplicados.

## Encerrar também faz parte do experimento

Uma fila de testes que nunca remove funcionalidades acumula complexidade. Ao final, a equipe deveria escolher entre incorporar, iterar, reverter ou abandonar.

Eu manteria um registro curto:

```yaml
resultado_observado:
limitacoes:
decisao:
motivo:
efeitos_colaterais:
proxima_pergunta:
```

Um resultado neutro não é fracasso editorial a ser escondido. Ele pode mostrar que o mecanismo estava errado, que a métrica não respondia à mudança ou que o efeito era menor do que o necessário para justificar manutenção.

Growth hacking é um nome dispensável quando o time já sabe formular hipóteses, medir efeitos e interromper caminhos ruins. O que precisa permanecer é a disciplina: nenhum ganho local deve ser apresentado como crescimento sustentável sem evidência de retenção, custo e impacto sobre as pessoas.

[1]: https://www.startup-marketing.com/where-are-all-the-growth-hackers/ "Find a Growth Hacker for Your Startup — Sean Ellis"
[2]: https://www.ftc.gov/system/files/ftc_gov/pdf/P214800%20Dark%20Patterns%20Report%209.14.2022%20-%20FINAL.pdf "Bringing Dark Patterns to Light — Federal Trade Commission"
