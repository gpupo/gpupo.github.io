# Tecnologia não é boa, ruim ou neutra sem contexto

Published: 2023-05-04
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/o-novo-sempre-vem-bom,-neutro-ou-ruim/
Tags: Inovação, Tecnologia

---

Perguntar se uma tecnologia é boa ou ruim parece abrir um debate ético. Na
prática, a pergunta reúne coisas diferentes: o artefato, a finalidade, quem o
controla, as condições de uso e os efeitos sobre pessoas que talvez nem tenham
escolhido participar.

Também não basta dizer que a tecnologia é neutra e que tudo depende do usuário.
Um sistema foi desenhado com capacidades e limites. Ele torna algumas ações mais
fáceis, outras mais caras e algumas impossíveis. Depois, organizações e pessoas
o colocam em contextos que podem reforçar ou contrariar essas escolhas.

Eu substituiria o julgamento abstrato por uma investigação: **que decisão foi
incorporada ao sistema, quem ganha capacidade com ela e quem assume o risco?**

## O artefato, o uso e o sistema não são a mesma coisa

Uma câmera registra imagens. Um sistema de controle de acesso usa imagens para
permitir ou negar entrada. Uma organização decide onde instalar o sistema, qual
erro aceita, por quanto tempo guarda os dados e como alguém contesta uma
decisão.

Avaliar apenas a câmera ignora o mecanismo que produz o efeito. Avaliar apenas a
intenção da organização ignora capacidades e limitações técnicas. A unidade
relevante é o sistema sociotécnico: tecnologia, pessoas, regras, incentivos,
dados e ambiente de operação.

Melvin Kranzberg formulou essa dificuldade ao argumentar que tecnologia não é
simplesmente boa, ruim ou neutra, porque seus efeitos surgem da interação com o
contexto social e podem variar entre situações. Isso é uma tese de história da
tecnologia, não uma fórmula que resolve cada caso. Ela ajuda a evitar a ideia de
que o artefato carrega sozinho um destino moral. ([trabalho de Kranzberg sobre
tecnologia e contexto](https://opg.optica.org/abstract.cfm?uri=OFC-1986-MA1))

Langdon Winner propôs outra questão: artefatos e sistemas técnicos podem
incorporar formas de poder e autoridade. O argumento é mais forte do que dizer
que toda tecnologia tem consequências políticas idênticas. Ele pede atenção ao
modo como desenho e infraestrutura abrem ou fecham possibilidades para grupos
diferentes. ([“Do Artifacts Have Politics?”, artigo original de
1980](https://www.jstor.org/stable/20024652))

As duas perspectivas apontam para níveis complementares: escolhas no desenho
importam, e os efeitos também dependem de implantação, instituições e uso.

## Intenção positiva não demonstra benefício

Uma equipe pode criar uma ferramenta para reduzir espera e acabar aumentando a
carga de quem opera exceções. Pode automatizar uma classificação e tornar mais
difícil contestar erros. Pode ampliar acesso para um grupo e excluir pessoas que
não possuem o dispositivo ou os dados exigidos.

Isso não significa que toda consequência seja previsível. Significa que “nossa
intenção era ajudar” não encerra a avaliação.

Antes da adoção, eu separaria:

```yaml
finalidade_declarada:
decisao_que_o_sistema_apoia_ou_executa:
usuarios_diretos:
pessoas_indiretamente_afetadas:
beneficios_esperados:
danos_plausiveis:
quem_controla_a_configuracao:
quem_pode_contestar:
alternativa_sem_a_tecnologia:
condicao_para_interromper_o_uso:
```

O preenchimento não torna a decisão ética por si só. Ele expõe lacunas que uma
demonstração técnica costuma esconder.

## Benefícios e riscos não são distribuídos igualmente

Uma média positiva pode ocultar grupos que recebem o custo. Para cada benefício,
vale perguntar:

- quem o recebe e em qual prazo;
- quem paga pela implantação e pela operação;
- quem executa o trabalho que permanece manual;
- quem absorve falsos positivos, indisponibilidade ou perda de privacidade;
- quem consegue recusar ou recorrer;
- quem não aparece nos dados usados para avaliar o sistema.

Considere um exemplo hipotético: um roteador de atendimentos reduz o tempo médio
ao enviar casos raros para uma fila especializada. A média geral melhora, mas
clientes com casos raros passam a esperar mais. O sistema não é integralmente
“bom” porque um indicador subiu nem integralmente “ruim” porque existe uma
exceção. A decisão exige tornar a distribuição visível e estabelecer qual atraso
é aceitável para cada grupo.

Quando a pessoa afetada não é a compradora ou usuária direta, esse exame é ainda
mais importante. Ela pode não ter participado da escolha e, mesmo assim,
suportar seus efeitos.

## Compare com alternativas reais

Debates sobre tecnologia frequentemente comparam uma proposta concreta com um
passado idealizado. O processo atual, porém, também contém erros, filas,
desigualdades e custos.

Eu compararia pelo menos quatro opções:

1. manter o processo atual;
2. corrigir o processo sem introduzir a nova tecnologia;
3. usar a tecnologia apenas como apoio à decisão;
4. automatizar a decisão dentro de limites definidos.

Cada opção deve usar critérios equivalentes: resultado, custo, tempo, segurança,
privacidade, acessibilidade, possibilidade de contestação e capacidade de
recuperação. Se apenas a opção nova recebe escrutínio, a análise favorece a
inércia. Se apenas o processo atual tem seus defeitos expostos, favorece a
adoção.

## Quanto maior o impacto, maior deve ser a possibilidade de revisão

Uma ferramenta reversível usada por uma pessoa para organizar notas não exige a
mesma governança de um sistema que participa de decisões sobre emprego, crédito
ou acesso a serviços.

O NIST trata sistemas de IA como sociotécnicos e recomenda mapear finalidade,
contexto, pessoas afetadas, benefícios e impactos negativos. O framework é
voluntário e voltado a IA; não deve ser apresentado como regra universal para
toda tecnologia. Ainda assim, sua função de mapeamento oferece perguntas úteis
para sistemas que afetam terceiros. ([função *Map* do NIST AI Risk Management
Framework](https://airc.nist.gov/airmf-resources/playbook/map/))

Eu aumentaria o rigor quando houver:

- dano difícil de reparar;
- decisão tomada em grande escala;
- pouca possibilidade de recusa;
- assimetria de poder entre operador e pessoa afetada;
- dados sensíveis;
- incerteza alta sobre desempenho no contexto real;
- dependência que dificulta abandonar o sistema.

Nesses casos, um piloto precisa de linha de base, grupos afetados representados,
registro de incidentes, canal de contestação e autoridade para interromper o uso.

## Monitorar faz parte da decisão

Uma avaliação anterior à implantação trabalha com hipóteses. Depois do uso real,
algumas se confirmam, outras falham e novos efeitos aparecem. Portanto, a
aprovação deveria registrar:

- medidas de benefício e de dano;
- frequência de revisão;
- responsável por acompanhar cada medida;
- limite que exige intervenção;
- plano de reversão ou substituição;
- data para reavaliar a necessidade do sistema.

Nem todo impacto será mensurável, e nem toda divergência poderá ser resolvida por
uma métrica. Nesses casos, a limitação deve permanecer explícita e a decisão
precisa assumir o conflito, em vez de escondê-lo sob a palavra “inovação”.

Aceitar ou rejeitar “a tecnologia” em bloco produz pouco conhecimento. Uma
decisão melhor identifica a capacidade específica, o contexto de uso, as
pessoas afetadas e as condições para continuar. O novo não chega pronto como
benefício ou ameaça; ele chega acompanhado de escolhas que alguém precisa
explicar e revisar.
