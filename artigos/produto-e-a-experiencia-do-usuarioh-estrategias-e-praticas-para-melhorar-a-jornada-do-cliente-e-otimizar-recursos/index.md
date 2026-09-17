# Melhorar a experiência do usuário exige problema, hipótese e medida

Published: 2023-03-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/produto-e-a-experiencia-do-usuarioh-estrategias-e-praticas-para-melhorar-a-jornada-do-cliente-e-otimizar-recursos/
Tags: Produto, UX, Métricas

---

Uma proposta de interface pode parecer evidentemente melhor e ainda assim não resolver o problema que motivou o trabalho. O botão ficou mais visível, a página parece mais moderna e o fluxo ganhou uma etapa explicativa. Falta saber se as pessoas concluem a tarefa com menos erro, menor esforço ou mais confiança.

Antes de discutir a solução, eu pediria uma descrição verificável do problema.

```yaml
usuario:
tarefa:
problema_observado:
evidencia:
impacto:
hipotese_de_melhoria:
metrica_principal:
limites_e_guardrails:
custo_estimado:
```

Esse registro não transforma UX em uma conta exata. Ele impede que preferência, hipótese e resultado sejam tratados como a mesma coisa.

## Comece pelo comportamento observado

“O checkout está ruim” é uma avaliação. “Pessoas abandonam o fluxo depois de receber uma mensagem genérica ao cadastrar o cartão” descreve um ponto que pode ser investigado.

A evidência pode vir de fontes diferentes:

* sessões de pesquisa com usuários;
* chamados de suporte;
* erros registrados pela aplicação;
* taxa de conclusão por etapa;
* tempo para executar uma tarefa;
* desistências ou retornos;
* reclamações e avaliações;
* observação de atendimento presencial ou telefônico.

Nenhuma fonte precisa responder tudo. Analytics mostra onde algo acontece, mas pode não explicar por quê. Uma sessão de usabilidade oferece contexto, mas não estima sozinha quantas pessoas enfrentam o mesmo problema.

O [Service Manual do GOV.UK][1] recomenda combinar métricas de desempenho com métodos de pesquisa, como testes de usabilidade, para avaliar transações e jornadas.

## Transforme a solução em hipótese

Uma proposta deveria ligar mecanismo e resultado esperado:

```text
Se tornarmos o erro de pagamento específico e preservarmos os campos válidos,
esperamos que mais pessoas consigam corrigir a tentativa,
porque saberão qual dado precisa mudar sem preencher o formulário novamente.
```

Essa formulação ainda pode estar errada. Talvez o problema real seja indisponibilidade do provedor, medo de fraude ou ausência do meio de pagamento desejado. A hipótese serve para orientar o teste e deixar claro o que a equipe acredita que acontecerá.

Sem mecanismo, frases como “melhorar a jornada” e “aumentar engajamento” não ajudam a escolher uma implementação.

## O exemplo do checkout sem resultado inventado

Imagine que os dados mostrem concentração de abandono na etapa de pagamento e que sessões de pesquisa revelem dificuldade para interpretar os erros.

A equipe considera três mudanças:

1. mostrar a mensagem ao lado do campo correspondente;
2. preservar os demais dados depois de uma falha;
3. explicar quais meios de pagamento são aceitos antes do envio.

Antes de implementar, eu registraria:

```yaml
metrica_principal: conclusão do pagamento após primeira falha
metricas_de_diagnostico:
  - erros por campo
  - tentativas por sessão
  - tempo entre falha e nova tentativa
guardrails:
  - taxa de pagamentos duplicados
  - falhas do provedor
  - acessibilidade das mensagens
  - exposição de dados sensíveis
```

A primeira versão deste artigo dizia que um exemplo hipotético havia aumentado vendas em 15%. Não havia experimento ou fonte para esse número. O resultado foi removido.

O caso agora termina onde a evidência termina: existe uma hipótese testável. O efeito só pode ser relatado depois da implementação e da medição.

## Escolha métricas a partir do objetivo

O framework [HEART][2], publicado por pesquisadores do Google, propõe categorias como satisfação, engajamento, adoção, retenção e sucesso da tarefa. A parte mais útil não é preencher todas as categorias, mas ligar objetivo, sinal e métrica.

```yaml
objetivo: permitir correção do pagamento sem reiniciar o checkout
sinal: pessoas identificam o erro e tentam novamente
metrica: proporção de sessões com falha seguida de tentativa válida
```

Uma métrica precisa apoiar uma decisão. Se a equipe não sabe o que faria diante de aumento, queda ou estabilidade, talvez esteja coletando um número sem uso operacional.

Também evitaria escolher apenas a métrica mais próxima da receita. Conclusão de tarefa, erros, chamadas ao suporte, acessibilidade, confiança e tempo operacional podem explicar melhor o valor da mudança.

## Custo não é apenas desenvolvimento

Uma alteração pequena na tela pode exigir mudanças em eventos de analytics, textos, suporte, tradução, documentação, testes, monitoramento e componentes compartilhados.

Eu consideraria:

* tempo de pesquisa e design;
* implementação e migração;
* instrumentação;
* testes automatizados e manuais;
* impacto em suporte e operação;
* dependências externas;
* possibilidade de reversão;
* custo de manter duas variantes durante um experimento.

O custo de não fazer também entra na decisão. Um problema de acessibilidade ou uma falha que impede a tarefa pode justificar trabalho mesmo sem projeção direta de receita. As [WCAG 2.2][3] oferecem critérios verificáveis para acessibilidade web; conformidade não deveria depender apenas de retorno financeiro imediato.

## Mudança visual também pode ter objetivo

Nem todo redesign é desperdício. Consistência visual pode reduzir dúvidas, facilitar manutenção e tornar estados do sistema reconhecíveis. Uma identidade inadequada pode prejudicar compreensão ou confiança.

O problema é aprovar uma mudança pelo adjetivo “moderna” sem definir o que precisa melhorar.

Para uma atualização visual, eu procuraria sinais como:

* componentes equivalentes se comportam de maneiras diferentes;
* contraste e foco não atendem aos critérios de acessibilidade;
* pessoas não distinguem ações primárias e secundárias;
* cada nova tela exige decisões que deveriam ser compartilhadas;
* a manutenção duplica estilos e variantes.

Esses problemas sustentam uma decisão melhor do que a preferência por uma nova paleta.

## Quando um teste A/B não basta

Um experimento controlado pode comparar variantes quando há volume suficiente, instrumentação confiável e uma métrica sensível à mudança. Ele não explica necessariamente por que uma variante venceu nem revela todos os efeitos sobre grupos menores.

Antes de executar, eu verificaria:

* qual hipótese está sendo testada;
* qual é a unidade de randomização;
* por quanto tempo o experimento precisa rodar;
* quais eventos invalidam a leitura;
* quais segmentos podem responder de forma diferente;
* quais guardrails interrompem o teste;
* se manter duas experiências cria risco operacional ou ético.

Em produtos com pouco tráfego, testes moderados de usabilidade, análise de tarefas e implantação gradual podem produzir evidência mais útil do que um A/B sem poder estatístico.

## A decisão pode ser não construir ainda

Depois de organizar problema, evidência, hipótese, custo e medida, a equipe pode:

* implementar diretamente um ajuste pequeno e reversível;
* testar um protótipo antes do código;
* instrumentar o fluxo para confirmar o problema;
* conduzir pesquisa adicional;
* executar um experimento;
* rejeitar a proposta por falta de impacto ou custo desproporcional.

Não construir ainda também é uma decisão, desde que registre a lacuna que impediu o avanço.

Para a próxima proposta de UX, eu começaria exigindo uma frase sobre o comportamento observado e outra sobre o mecanismo esperado da mudança. Se essas duas frases não forem sustentáveis, discutir componentes e telas provavelmente está antecipando a solução.

[1]: https://www.gov.uk/service-manual/measuring-success/measuring-the-success-of-your-service "Measuring the success of your service — GOV.UK"
[2]: https://research.google/pubs/measuring-the-user-experience-on-a-large-scale-user-centered-metrics-for-web-applications/ "Measuring the User Experience on a Large Scale — Google Research"
[3]: https://www.w3.org/TR/WCAG22/ "Web Content Accessibility Guidelines 2.2 — W3C"
