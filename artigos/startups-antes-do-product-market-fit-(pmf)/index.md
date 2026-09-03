# Antes do product-market fit: organize o trabalho para reduzir incerteza

Published: 2023-05-05
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/startups-antes-do-product-market-fit-(pmf)/
Tags: Produto, Startups

---

Antes do product-market fit (PMF), uma startup ainda tenta descobrir se existe
demanda consistente por uma solução e se consegue atendê-la de forma viável.
Mesmo assim, é fácil organizar o trabalho como se o principal desafio já fosse
executar um plano conhecido.

O resultado costuma aparecer em dois extremos. Em um deles, o time cria
roadmaps detalhados, processos e especializações cedo demais. No outro, usa a
incerteza como justificativa para lançar qualquer coisa sem hipótese, medida ou
registro do que aprendeu.

Os dois extremos desperdiçam tempo. Antes do PMF, eu trataria a gestão de
produto como um sistema para **reduzir as incertezas que podem invalidar o
negócio**.

## PMF é uma condição observada, não uma etapa declarada

Não existe uma métrica universal que certifique product-market fit para todo
tipo de produto. Um software por assinatura, um marketplace e um produto de
hardware têm ciclos, receitas e sinais de uso diferentes.

Michael Seibel descreve PMF como uma situação em que a demanda e o uso pressionam
a capacidade da startup. A definição é uma referência prática de um investidor e
fundador, não um teste científico aplicável a qualquer empresa. O ponto útil é o
alerta: captação, tamanho da equipe e quantidade de funcionalidades não provam
que o produto encontrou seu mercado. ([“The Real Product Market Fit”, Y
Combinator](https://www.ycombinator.com/blog/the-real-product-market-fit/))

Eu procuraria um conjunto coerente de sinais:

- pessoas do segmento definido enfrentam o problema com frequência ou
  intensidade relevante;
- elas começam a usar o produto sem depender de explicações excepcionais;
- parte delas volta, renova, paga ou amplia o uso, conforme o modelo;
- a perda de clientes tem causas compreensíveis, e não apenas uma sequência de
  exceções;
- aquisição e atendimento mostram algum caminho repetível;
- o custo para entregar a solução não destrói a viabilidade do negócio.

Esses sinais aumentam a confiança, mas não tornam a conclusão permanente. Um
mercado pode mudar; um canal pode deixar de funcionar; a retenção inicial pode
representar apenas um nicho pequeno. A afirmação “temos PMF” deveria sempre vir
acompanhada de segmento, período e evidências.

## Troque o roadmap de funcionalidades por um mapa de riscos

Antes do PMF, um roadmap longo tende a acumular decisões tomadas com pouca
evidência. Isso não significa que planejar seja inútil ou que três meses sejam
um limite mágico. O horizonte apropriado depende do custo e da reversibilidade
das decisões.

Uma startup de software pode testar uma mudança em dias. Um produto regulado ou
de hardware precisa assumir compromissos mais longos. Em ambos os casos, o plano
deveria mostrar o que ainda precisa ser verdade para o negócio funcionar.

Eu separaria as hipóteses em quatro grupos:

| Risco | Pergunta |
| --- | --- |
| Problema | O segmento realmente enfrenta este problema e o prioriza? |
| Solução | A proposta muda o comportamento ou o resultado esperado? |
| Distribuição | Conseguimos alcançar e converter essas pessoas? |
| Viabilidade | Receita, custo e operação podem formar um negócio sustentável? |

O próximo trabalho deveria atacar uma hipótese de alto impacto com pouca
evidência. A Strategyzer recomenda tornar hipóteses precisas, testáveis e
separadas antes de escolher o experimento. Essa estrutura ajuda, mas não garante
que o teste escolhido produza evidência forte. ([formulação de hipóteses para
testes de negócio](https://www.strategyzer.com/library/mastering-business-testing-formulating-strong-hypotheses))

Um item de trabalho pode ser registrado assim:

```yaml
hipotese: profissionais autônomos abandonam o controle em planilhas por causa da conciliação manual
risco: problema
evidencia_atual: entrevistas com o segmento, ainda sem observação de uso
teste: acompanhar a conciliação real e oferecer um protótipo operado manualmente
sinal_esperado: uso recorrente sem lembretes e solicitação para continuar
prazo_de_revisao: duas semanas após o primeiro uso
decisao: continuar, alterar o segmento ou interromper
```

Os valores acima são um exemplo de estrutura, não dados de um caso real.

## Entregar rápido só ajuda quando encurta o aprendizado

Velocidade de entrega é um meio. Se o time publica dez mudanças sem saber qual
hipótese cada uma testa, produziu atividade, não necessariamente aprendizado.

Uma entrega pequena é útil quando:

- chega às pessoas capazes de produzir a evidência necessária;
- registra o comportamento relevante;
- limita o custo caso a hipótese esteja errada;
- permite uma decisão depois do teste.

Nem toda hipótese exige código. Para investigar um problema, observar o trabalho
ou analisar dados existentes pode ser mais adequado. Para testar disposição de
pagamento, uma conversa de venda ou um compromisso real fornece uma evidência
diferente de uma pesquisa de opinião. Para testar retenção, será necessário
acompanhar uso ao longo do ciclo natural do produto.

O método de Customer Development de Steve Blank diferencia a busca por um
modelo de negócio da execução de um modelo conhecido. É uma distinção útil para
entender por que previsões detalhadas perdem confiabilidade nesse estágio. Ainda
assim, chamar uma empresa de “startup” não elimina a necessidade de orçamento,
segurança ou obrigações regulatórias. ([busca e execução no Customer
Development](https://steveblank.com/2012/03/05/))

## Pesquisa, documentação e qualidade não são os inimigos

Histórias de usuário, épicos, pesquisas e documentos estratégicos foram tratados
na versão anterior deste post como práticas que deveriam ser evitadas. A
generalização não se sustenta.

Um documento é desperdício quando custa mais do que a coordenação e a memória
que oferece. Uma história de usuário é ruim quando oculta o problema ou vira um
contrato de escopo. Uma pesquisa atrasa quando não responde a uma decisão. Mas
qualquer um desses artefatos pode ser útil em uma equipe distribuída, em um
domínio complexo ou quando uma escolha precisa ser auditável.

Eu usaria o menor registro capaz de preservar:

1. a hipótese;
2. a evidência disponível;
3. o responsável pela decisão;
4. o resultado esperado;
5. a data em que a decisão será revista.

Qualidade também precisa ser contextual. Um protótipo descartável não exige a
mesma engenharia de um sistema que processa pagamentos ou dados de saúde.
“Lançar rápido” não autoriza expor usuários a riscos que o experimento poderia
evitar.

## Conversar com usuários não é contar pedidos

Contato frequente com usuários pode revelar linguagem, contexto e alternativas
que a equipe não conhece. Mas a quantidade de conversas não mede, sozinha, a
qualidade da descoberta.

Pedidos de funcionalidades são insumos. A decisão continua sendo do time, que
precisa distinguir:

- o problema observado;
- a solução sugerida pela pessoa;
- a frequência desse problema no segmento;
- o comportamento que confirma ou contradiz o relato;
- o custo de resolver e manter a solução.

Também existe viés de seleção: os usuários mais disponíveis ou vocais podem não
representar o mercado pretendido. Por isso eu combinaria evidência qualitativa
com uso, retenção, conversão, receita ou outra medida adequada ao modelo.

## Uma cadência simples para a fase de busca

Em vez de adotar uma lista universal de coisas a fazer e evitar, eu usaria um
ciclo de decisão:

1. registre as hipóteses que sustentam o negócio;
2. priorize a mais arriscada entre as que ainda têm pouca evidência;
3. escolha o teste de menor custo que gere evidência suficiente;
4. defina o sinal e a decisão antes de executar;
5. colete resultados e também evidências contrárias;
6. atualize a hipótese, o produto ou o segmento;
7. aumente o investimento somente quando a confiança justificar.

Se o time não consegue dizer qual incerteza a próxima entrega reduz, o risco é
estar usando velocidade para evitar a decisão mais difícil. Se consegue, o
roadmap deixa de ser uma promessa distante e passa a registrar a sequência de
aprendizados de que o negócio precisa.
