# Human in the Loop: quando a revisão humana reduz risco — e quando é só uma etapa

Published: 2023-03-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/human-in-the-looph-aprimorando-a-inteligencia-artificial-atraves-da-colaboracao-humano-maquina/
Tags: IA, Human in the Loop, Governança

---

Adicionar uma aprovação humana depois da resposta de um modelo parece uma solução simples para reduzir erros. Em muitos fluxos, porém, a pessoa recebe centenas de decisões, pouco contexto e nenhum poder real para interromper o processo.

Existe um humano no diagrama, mas não existe supervisão efetiva.

Human in the Loop (HITL) descreve configurações em que pessoas participam do treinamento, da avaliação, da decisão ou da operação de um sistema automatizado. O termo não define sozinho qual pessoa participa, o que ela precisa verificar ou o que acontece quando discorda do modelo.

## Existem humanos diferentes no loop

Uma implementação de HITL pode incluir papéis distintos:

* **anotador:** classifica exemplos usados em treinamento ou avaliação;
* **especialista de domínio:** interpreta casos que exigem conhecimento específico;
* **revisor:** verifica uma saída antes que ela produza efeito;
* **decisor:** usa a recomendação do sistema como uma entrada para sua própria decisão;
* **operador:** acompanha o sistema e responde a exceções;
* **pessoa afetada:** contesta ou pede revisão de uma decisão.

Misturar esses papéis cria uma falsa sensação de controle. Quem rotula dados nem sempre tem autoridade para impedir uma decisão. Quem aprova uma saída pode não conhecer os critérios usados no treinamento. Quem é afetado pelo resultado pode nem saber que havia um sistema automatizado no processo.

O [AI Risk Management Framework do NIST][1] recomenda definir e diferenciar responsabilidades nas configurações humano–IA. Essa definição precisa acontecer antes de escolher onde colocar um botão de aprovação.

## O humano também pode errar

A revisão humana não remove viés automaticamente. Pessoas podem confirmar a recomendação da máquina sem análise suficiente, aplicar critérios diferentes entre casos, trabalhar sob pressão ou não receber informação adequada para contestar o resultado.

O próprio [NIST observa][2] que vieses humanos e sistêmicos podem entrar em diferentes etapas do ciclo de vida e que, em certas condições, a interação entre pessoa e IA pode ampliar vieses em vez de reduzi-los.

Por isso, “revisado por uma pessoa” não é uma métrica de qualidade. Para avaliar o controle, eu perguntaria:

* o revisor conhece a finalidade e os limites do sistema?
* consegue acessar os dados necessários para decidir?
* tem tempo compatível com a complexidade do caso?
* pode discordar sem sofrer pressão operacional?
* consegue interromper ou devolver a decisão?
* a divergência fica registrada?
* casos difíceis são encaminhados a alguém com outra competência?

Sem essas condições, a pessoa pode funcionar apenas como confirmação formal da saída automática.

## Nem todo caso precisa da mesma revisão

Revisar manualmente todas as saídas pode ser inviável e até piorar o controle quando o volume torna a análise superficial. Uma estratégia por risco costuma ser mais operável.

```text
baixo risco e alta confiança
    → processamento automático + amostragem

risco moderado ou baixa confiança
    → revisão antes da execução

alto impacto, ambiguidade ou conflito
    → especialista + justificativa registrada

falha fora do comportamento esperado
    → interromper o fluxo e investigar
```

Essa distribuição é uma recomendação geral, não uma regra universal. Os critérios de risco e confiança precisam ser definidos para o domínio. Uma pontuação do modelo pode ajudar a ordenar casos, mas precisa ser calibrada e comparada com erros observados; não deve ser tratada automaticamente como probabilidade correta.

## Um exemplo com classificação de dados pessoais

Imagine um sistema que procura dados pessoais em documentos para apoiar inventário e controle de acesso. O modelo sugere uma categoria e destaca o trecho encontrado.

Uma configuração de revisão poderia registrar:

```yaml
documento: contrato-042
trecho_detectado: "..."
categoria_sugerida: dado_pessoal
regra_aplicada: identificador_direto
confiança_modelo: 0.71
decisão_revisor: corrigir_categoria
justificativa: "o trecho contém dado pessoal sensível"
encaminhamento: encarregado_de_dados
```

Esse registro cria rastreabilidade para avaliar onde o modelo e os revisores divergem. Ainda não garante que todos os dados foram encontrados, que a categoria está correta ou que o tratamento atende à Lei Geral de Proteção de Dados.

Conformidade depende de finalidade, base legal, necessidade, segurança, direitos dos titulares e outras obrigações. HITL pode apoiar o processo; não substitui análise jurídica e governança de dados.

## Revisão de decisões automatizadas na LGPD

O artigo 20 da [LGPD][3] assegura ao titular o direito de solicitar revisão de decisões tomadas unicamente com base em tratamento automatizado de dados pessoais que afetem seus interesses. O texto também prevê acesso a informações claras e adequadas sobre critérios e procedimentos, observados os segredos comercial e industrial.

Isso não significa que adicionar qualquer intervenção humana torna o sistema automaticamente conforme. Também não permite concluir, sem analisar o caso, que todo fluxo automatizado está sujeito às mesmas exigências.

Para um produto que toma decisões com efeito sobre pessoas, eu documentaria:

* quais decisões são totalmente automatizadas;
* quais dados pessoais participam delas;
* qual efeito podem produzir;
* como o titular recebe informação;
* como solicita revisão ou contesta o resultado;
* quem analisa a solicitação;
* quais registros permitem reconstruir a decisão.

A interpretação aplicável deve ser validada com profissionais responsáveis por proteção de dados e pelo contexto jurídico do produto.

## O que medir depois da implantação

Um loop precisa produzir evidência de que funciona. Algumas medidas possíveis são:

* taxa de concordância entre modelo e revisores;
* frequência e tipo das correções;
* tempo disponível e tempo usado por revisão;
* diferença de decisão entre revisores;
* quantidade de casos escalados;
* erros descobertos depois da aprovação;
* grupos ou situações com maior concentração de divergências;
* decisões contestadas por pessoas afetadas.

Uma taxa alta de concordância pode significar bom desempenho ou revisão automática demais. Uma taxa baixa pode indicar modelo inadequado, critérios ambíguos ou treinamento insuficiente dos revisores. A métrica precisa ser interpretada junto com amostras de casos.

## A pergunta é quem consegue mudar o resultado

HITL é útil quando a pessoa acrescenta contexto, assume uma responsabilidade definida e consegue alterar o curso da decisão. O controle enfraquece quando o revisor apenas confirma uma fila produzida por outro sistema.

Eu começaria desenhando papéis, critérios de escalonamento e autoridade de interrupção. Depois, registraria divergências e erros para verificar se a intervenção humana reduz o risco que motivou sua criação.

Colocar alguém no fluxo é fácil. Demonstrar que essa pessoa tem condições de revisar é o trabalho de governança.

[1]: https://airc.nist.gov/airmf-resources/airmf/5-sec-core/ "AI RMF Core — NIST"
[2]: https://airc.nist.gov/airmf-resources/airmf/appendices/app-c-ai-risk-management-and-human-ai-interaction/ "AI Risk Management and Human-AI Interaction — NIST"
[3]: https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm "Lei nº 13.709/2018 — LGPD"
