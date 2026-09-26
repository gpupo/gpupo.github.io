# Prazo, orçamento e valor: projetos precisam dos três

Published: 2024-04-10
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/hendrix-e-o-foco-no-valor-ao-inves-de-prazos-e-orcamentos/
Tags: Produto, Estratégia

---

Um projeto pode terminar no prazo, respeitar o orçamento e não melhorar o
resultado que justificou o investimento. O inverso também importa: uma promessa
de valor não torna aceitáveis custos sem limite, atrasos permanentes ou riscos
ignorados.

A oposição entre “gestão tradicional” e “gestão orientada a valor” simplifica o
problema. Prazo e orçamento respondem se a organização consegue entregar dentro
das restrições assumidas. Medidas de resultado respondem se a mudança produziu
o benefício esperado. São perguntas diferentes, e uma não substitui a outra.

## Separe entrega, resultado e benefício

Considere um projeto para reduzir o tempo de atendimento ao cliente.

- **Entrega:** novo sistema de triagem implantado.
- **Resultado operacional:** chamados chegam à equipe correta com menos
  transferências.
- **Benefício:** redução do tempo de resolução sem piora da qualidade ou aumento
  desproporcional de custo.

O sistema pode ser entregue sem ser adotado. Pode ser adotado e não reduzir
transferências. Pode reduzir transferências e criar outro gargalo. Declarar
sucesso no momento da implantação interrompe a análise cedo demais.

O guia de realização de benefícios do PMI conecta estratégia, entregas e
medição de sucesso ao longo de um ciclo de benefícios. A contribuição útil aqui
é considerar o que acontece depois da entrega, não abandonar a disciplina de
projeto. ([guia de realização de benefícios do
PMI](https://www.pmi.org/standards/benefits-realization))

## “Valor” precisa de destinatário e medida

Valor é uma palavra vazia quando não indica quem recebe o benefício e qual
mudança será observada. Reduzir custo para uma área pode aumentar tempo de espera
para clientes. Aumentar conversão pode elevar fraude ou cancelamentos. Automatizar
uma tarefa pode transferir trabalho para outra equipe.

Antes de aprovar a iniciativa, eu registraria:

```yaml
problema: chamados passam por várias equipes antes da resolução
publico_afetado: clientes e equipes de atendimento
entrega: mecanismo de classificação e novo fluxo de encaminhamento
resultado_esperado: menos transferencias por chamado
beneficio_esperado: menor tempo de resolucao com qualidade preservada
contramedidas:
  - reabertura de chamados
  - satisfacao do cliente
  - custo operacional
responsavel_pelo_beneficio: lider da operacao de atendimento
prazo_de_avaliacao: definido conforme o ciclo real do atendimento
```

Esse exemplo mostra a estrutura, não resultados de um projeto real. As medidas e
o prazo precisam ser definidos a partir de uma linha de base e do processo em
questão.

## O caso de negócio contém hipóteses

Entre a entrega e o benefício existe uma cadeia de suposições:

```text
entrega disponível
→ pessoas adotam a mudança
→ comportamento operacional muda
→ indicador intermediário responde
→ benefício aparece
```

Cada seta pode falhar. Por isso, o caso de negócio deveria tornar explícitos:

- a linha de base;
- o mecanismo que conecta a entrega ao resultado;
- as dependências fora do controle do projeto;
- os custos de implantação e operação;
- o tempo necessário para observar o efeito;
- os efeitos adversos que precisam ser monitorados;
- a condição para rever ou interromper o investimento.

O *Green Book* do governo britânico trata a avaliação como comparação de custos,
benefícios e riscos entre opções para atingir objetivos. Embora tenha sido
criado para decisões públicas no Reino Unido, o princípio é aplicável: defender
uma iniciativa exige compará-la com alternativas, inclusive manter a situação
atual. ([coleção oficial do *Green
Book*](https://www.gov.uk/government/collections/the-green-book-and-accompanying-guidance-and-documents))

Benefícios projetados ainda são hipóteses. O business case não os transforma em
fatos; ele documenta por que o investimento parece justificável e o que deverá
ser medido.

## Prazo e orçamento continuam sendo sinais de controle

Planejamento de custo e cronograma permite avaliar capacidade, dependências e
exposição ao risco. Uma estimativa não precisa fingir certeza para ser útil. Ela
pode trabalhar com intervalos, premissas e cenários.

O guia de estimativas do U.S. Government Accountability Office recomenda tornar
explícitos escopo, base técnica, premissas, dados, sensibilidade e risco, além de
atualizar estimativas com custos reais. O guia foi elaborado para programas
públicos e grandes aquisições; aplicar todo o processo a uma pequena mudança de
software seria desproporcional. O princípio relevante é manter a estimativa
rastreável e atualizável. ([guia de estimativas de custo do
GAO](https://www.gao.gov/products/gao-20-195g))

Eu acompanharia quatro perguntas separadamente:

| Pergunta | Exemplo de medida |
| --- | --- |
| Estamos entregando o combinado? | escopo aceito e qualidade técnica |
| A previsão ainda é confiável? | custo e data estimados com premissas atuais |
| A mudança está sendo adotada? | uso correto no processo alvo |
| O benefício está aparecendo? | resultado e contramedidas versus linha de base |

Uma iniciativa pode estar verde na primeira linha e vermelha na última. Esse é
um sinal para revisar o investimento, não para esconder o custo sob uma
definição abstrata de valor.

## A realização costuma continuar depois do projeto

Muitos benefícios dependem da operação: treinamento, mudança de processo,
qualidade dos dados, adesão de gestores ou atendimento a exceções. A equipe do
projeto pode entregar uma capacidade, mas não controla sozinha o comportamento
que vem depois.

Por isso é necessário nomear um responsável pelo benefício na área que receberá
a mudança. O guia britânico de gestão de benefícios atribui responsabilidades a
papéis do projeto e da operação e reconhece que a realização atravessa o ciclo
de entrega. A estrutura é voltada a grandes projetos, mas evita um problema
comum em qualquer escala: deixar a métrica sem dono após a implantação.
([guia para gestão de benefícios em grandes
projetos](https://www.gov.uk/government/publications/guide-for-effective-benefits-management-in-major-projects))

Esse responsável não deveria ser responsabilizado por um benefício impossível.
Ele precisa participar da definição da linha de base, validar as dependências e
ter autoridade para mudar o processo.

## Revise o investimento em marcos de decisão

Um projeto orientado a valor não recebe liberdade ilimitada. Ele cria momentos
explícitos para decidir:

1. o problema e a linha de base ainda são válidos?
2. a opção escolhida continua melhor que as alternativas?
3. custo, prazo e riscos mudaram de forma material?
4. há evidência de adoção e resultado intermediário?
5. devemos continuar, alterar, reduzir ou encerrar?

Projetos irreversíveis ou regulados exigem validações mais formais. Mudanças
pequenas e reversíveis podem usar ciclos curtos. O mecanismo é o mesmo: atualizar
a decisão com evidências, sem reescrever a história para fazer a previsão
original parecer correta.

Se o benefício ainda não pode ser observado, reporte-o como esperado. Se há um
resultado intermediário, identifique-o como tal. E, se prazo ou orçamento foram
ultrapassados, registre a variação e a nova decisão. Valor não é uma licença para
perder controle; é o motivo pelo qual vale a pena controlar o investimento.
