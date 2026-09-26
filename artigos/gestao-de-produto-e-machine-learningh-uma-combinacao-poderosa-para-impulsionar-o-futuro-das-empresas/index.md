# Antes do modelo: como formular um problema de produto para machine learning

Published: 2023-02-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/gestao-de-produto-e-machine-learningh-uma-combinacao-poderosa-para-impulsionar-o-futuro-das-empresas/
Tags: IA, Machine Learning, Produto

---

Machine learning não começa pela escolha de uma plataforma ou de um algoritmo. Começa por uma decisão que precisa ser tomada repetidamente sob incerteza.

“Usar IA para entender clientes” ainda não define um problema. “Ordenar solicitações de suporte pela probabilidade de exigir atendimento urgente, antes da primeira resposta” está mais próximo: existe uma unidade de análise, um momento de decisão, uma ação e um resultado observável.

Para profissionais de produto, a pergunta central não é apenas se um modelo consegue produzir uma previsão. É se essa previsão muda uma decisão de forma útil, segura e mensurável.

## Comece pela decisão, não pelos dados disponíveis

Uma formulação inicial deve registrar:

- **quem decide:** pessoa, serviço ou fluxo automatizado;
- **quando decide:** antes, durante ou depois de determinado evento;
- **quais ações são possíveis:** priorizar, recomendar, bloquear, revisar ou não agir;
- **qual informação existe naquele momento:** sem incluir dados que só aparecem depois;
- **qual resultado importa:** para usuário, negócio e operação;
- **qual é o custo do erro:** falso positivo, falso negativo, atraso ou ausência de resposta;
- **qual alternativa existe:** regra simples, busca, processo manual ou nenhuma intervenção.

Essa descrição permite perguntar se machine learning é necessário. As [Rules of Machine Learning do Google](https://developers.google.com/machine-learning/guides/rules-of-ml) recomendam começar com métricas, manter o primeiro modelo simples e estabelecer uma linha de base. Uma heurística compreensível pode resolver o problema ou fornecer a comparação mínima para justificar a complexidade seguinte.

## Previsão não responde automaticamente a uma pergunta causal

Um modelo supervisionado pode aprender relações úteis para prever um resultado observado nos dados. Isso não significa que ele estimou o efeito de mudar uma variável.

Considere duas perguntas:

1. **Quais clientes têm maior probabilidade de cancelar?**
2. **Quanto o cancelamento mudaria se oferecêssemos um desconto?**

A primeira é uma pergunta preditiva. A segunda compara um resultado observado com um cenário contrafactual — o que teria ocorrido com a mesma população sem a intervenção. Responder à segunda exige desenho causal, como um experimento adequado ou uma estratégia de identificação justificável; não basta incluir “desconto” entre as variáveis de um modelo preditivo.

O mesmo cuidado vale para “qual é o impacto do preço na compra?”. Dados históricos podem mostrar que preços e conversão variam juntos, mas promoções, estoque, segmento, canal e sazonalidade também podem mudar. Um modelo pode prever conversão sem identificar o efeito causal do preço.

Machine learning pode participar de métodos causais. A distinção continua necessária porque objetivo, dados e avaliação são diferentes.

## Transforme o problema em uma tarefa avaliável

Depois de definir a decisão, descreva o que o modelo produzirá.

Exemplos:

- **classificação:** a transação requer revisão?
- **ranking:** qual item deve aparecer primeiro?
- **regressão:** qual demanda é esperada para o período?
- **detecção:** este comportamento se afasta do padrão conhecido?
- **recomendação:** quais opções são mais relevantes neste contexto?

A categoria não determina sozinha a métrica. Em uma triagem, errar um caso urgente pode custar mais do que encaminhar um caso comum para revisão. Acurácia média pode esconder essa diferença.

O plano precisa explicitar:

- população e período avaliados;
- definição do rótulo;
- horizonte da previsão;
- segmentos relevantes;
- custo dos tipos de erro;
- desempenho da alternativa atual;
- limiar que justificaria uma mudança no produto.

Se o rótulo for uma aproximação imperfeita do objetivo, documente a distância. Cliques não são satisfação; tempo de tela não é valor; uma decisão anterior de um analista não é necessariamente a verdade objetiva.

## Avaliação offline não é resultado de produto

Separar dados de treino e teste permite estimar o comportamento do modelo em exemplos não usados no treinamento. Em problemas temporais, o teste deve respeitar o tempo: treinar no passado e avaliar em dados posteriores costuma representar melhor a implantação do que distribuir registros aleatoriamente.

Ainda assim, melhorar uma métrica offline não demonstra melhora no produto. Em produção, a previsão altera o que usuários e operadores veem, cria ciclos de feedback e pode mudar os próprios dados usados em treinamentos futuros.

Uma recomendação mais clicada pode reduzir diversidade. Um filtro mais agressivo pode diminuir fraude e bloquear clientes legítimos. Uma priorização pode reduzir o tempo médio enquanto aumenta a espera de um segmento.

Por isso, separe:

- **métricas do modelo:** precisão, revocação, calibração ou erro, conforme a tarefa;
- **métricas do produto:** conclusão da jornada, satisfação, retenção ou resultado operacional;
- **contramétricas:** dano, desigualdade entre grupos, reclamações, custo e carga de revisão;
- **métricas do sistema:** latência, disponibilidade, custo e atualização dos dados.

## Desenhe a experiência para incerteza e erro

Modelos não precisam decidir sozinhos. O produto pode usar a previsão para ordenar trabalho, sugerir opções ou encaminhar casos ambíguos a uma pessoa.

O [People + AI Guidebook](https://pair.withgoogle.com/guidebook-v2/) organiza práticas de design para aplicações de IA, incluindo definição de valor, coleta de feedback, explicação e tratamento de falhas.

Algumas decisões de interface precisam ser tomadas antes da implantação:

- o usuário sabe que está interagindo com uma previsão?
- consegue corrigir uma recomendação inadequada?
- existe uma alternativa quando o modelo ou os dados não estão disponíveis?
- uma pessoa revisora possui contexto, tempo e autoridade para intervir?
- o produto explica o suficiente para a decisão, sem inventar certeza?
- feedback negativo produz investigação ou apenas vira novo dado de treino?

“Ter uma pessoa no processo” não resolve automaticamente os riscos. Se a revisão apenas confirma a sugestão por falta de informação ou tempo, ela pode ser uma etapa decorativa.

## Dados criam limites antes de criar vantagem

Um conjunto de dados representa decisões e condições anteriores. Antes de usá-lo, investigue:

- como e por que os registros foram coletados;
- quem está ausente ou sub-representado;
- se o rótulo depende de julgamento humano;
- se atributos estarão disponíveis no momento da previsão;
- se há autorização e finalidade para o tratamento;
- quanto tempo o dado permanece relevante;
- como exclusões, correções e retenção serão administradas.

Usar uma variável disponível não significa que seu uso seja necessário, legítimo ou desejável. Em decisões de maior impacto, análise jurídica, de segurança e de domínio precisa participar do desenho.

O [AI Risk Management Framework do NIST](https://www.nist.gov/publications/artificial-intelligence-risk-management-framework-ai-rmf-10) estrutura a gestão de risco em governar, mapear, medir e gerenciar. O framework não certifica um produto nem prescreve uma lista universal; ele ajuda a manter contexto, responsáveis, riscos e respostas explícitos ao longo do ciclo de vida.

## Produção faz parte do produto de ML

O modelo lançado começa a envelhecer. Fontes mudam, comportamentos se adaptam, integrações quebram e diferenças entre treinamento e execução podem degradar resultados.

O plano operacional deve responder:

- o que será monitorado e com qual frequência;
- como detectar dados ausentes, atraso e mudança de distribuição;
- quem recebe o alerta;
- quando recalibrar ou treinar novamente;
- qual versão de dados e modelo produziu uma decisão;
- como reverter a implantação;
- quando suspender o sistema.

Monitorar apenas uma média global pode ocultar falhas concentradas. Segmentos definidos pelo contexto e pelo risco precisam ser avaliados desde que isso possa ser feito de forma legítima e estatisticamente responsável.

## Um checklist para a descoberta

Antes de aprovar a construção, a equipe deveria conseguir preencher:

```text
Decisão:
Pessoa ou sistema responsável:
Momento da decisão:
Ação apoiada pela previsão:
Resultado desejado:
Custo de falso positivo e falso negativo:
Alternativa sem ML:
Dados disponíveis naquele momento:
Métrica offline:
Métrica de produto:
Contramétricas:
Plano de revisão e contestação:
Plano de monitoramento e reversão:
```

Campos sem resposta não impedem todo experimento, mas mostram onde ainda existe uma hipótese ou um risco não tratado.

Uma [hipótese de machine learning para fraude em seguros de saúde](https://www.bpstrat.com.br/post/ia-no-combate-fraude-uma-oportunidade-pouco-explorada/) aplica parte desse raciocínio ao priorizar casos para revisão humana, definir uma linha de base e tornar visível o custo dos falsos positivos.

## O modelo é uma parte da intervenção

Produto e machine learning se encontram na decisão, não no catálogo de ferramentas. Um modelo tecnicamente melhor pode ser desnecessário, impossível de operar ou inadequado para a experiência. Uma regra simples pode produzir mais valor porque é rápida, auditável e suficiente.

A escolha só pode ser avaliada em comparação com uma linha de base e dentro do sistema completo: dados, interface, pessoas, operação e efeitos posteriores. O objetivo não é “usar IA”. É melhorar uma decisão sem esconder seus custos e limitações.
