# A escrita por IA tem padrões mais profundos do que palavras e pontuação

Published: 2026-08-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/a-escrita-por-ia-tem-padroes-mais-profundos-do-que-palavras-e-pontuacao/

---

Quando um texto produzido por inteligência artificial parece artificial, a correção costuma começar pela superfície.

Removemos travessões, reduzimos adjetivos, trocamos expressões genéricas, quebramos parágrafos e pedimos ao modelo para “escrever de forma mais humana”. O resultado pode ficar mais agradável, mas frequentemente continua previsível.

O estudo **StoryScope: Investigating Idiosyncrasies in AI Fiction** ajuda a explicar por quê. Os autores não analisaram apenas vocabulário, sintaxe ou pontuação. Eles observaram as decisões narrativas tomadas pelos modelos: como os conflitos são organizados, quando as informações são reveladas, quanto os temas são explicados, como os personagens agem e de que forma as histórias terminam. ([arXiv][1])

Embora a pesquisa trate de ficção, minha leitura é que ela traz uma implicação importante para quem utiliza agentes na produção de artigos técnicos: um texto pode escapar dos clichês mais visíveis da IA e continuar seguindo a mesma arquitetura previsível de raciocínio.

## O que o StoryScope analisou

Os pesquisadores partiram de 10.272 histórias escritas por humanos. A partir delas, foram reconstruídos prompts com premissas semelhantes, usados para gerar novas histórias com Claude, DeepSeek, Gemini, GPT e Kimi.

O corpus final reuniu 61.608 histórias, com aproximadamente 5 mil palavras cada. Para cada texto, o pipeline extraiu 304 características distribuídas por dez dimensões narrativas, incluindo personagens, enredo, ambiente, perspectiva e estrutura temporal. ([arXiv][1])

O processo tinha quatro etapas principais.

Primeiro, cada história era convertida em uma representação estruturada. Depois, as versões humana e artificiais produzidas a partir de premissas equivalentes eram comparadas. Essas comparações serviam para descobrir características discriminativas, que eram então aplicadas ao corpus completo. Por fim, os vetores resultantes eram usados para treinar classificadores. 

O resultado chama atenção: usando apenas características narrativas, sem depender dos sinais estilísticos mais conhecidos, o modelo conseguiu distinguir histórias humanas das geradas por IA com **93,2% de macro-F1**.

Um conjunto reduzido de apenas 30 características ainda alcançou 84,8%. Quando estilo e narrativa foram combinados, o resultado subiu para 96%. ([arXiv][1])

Isso sugere que os padrões mais persistentes da escrita artificial não estão restritos às palavras escolhidas. Eles aparecem também na maneira como o modelo organiza a experiência.

## A IA tende a explicar demais

Uma das diferenças mais claras está na explicação dos temas.

Em 77% das histórias geradas por IA, o narrador explicava explicitamente o tema ou a lição da história. Entre os textos humanos, isso acontecia em 52% dos casos.

Diálogos usados para debates filosóficos apareceram em 59% das histórias artificiais e em 34% das humanas. As referências culturais dos modelos também eram mais vagas: a IA recorria com maior frequência a alusões genéricas, enquanto os autores humanos nomeavam obras e autores de maneira mais específica. ([arXiv][1])

O modelo parece ter dificuldade para confiar na inferência do leitor. Ele apresenta o conflito, desenvolve a situação e depois explica o que tudo aquilo significa.

Esse padrão também aparece em artigos técnicos.

O texto introduz uma ideia, explica a ideia, transforma a ideia em uma lista, resume a lista e termina repetindo a ideia como uma “lição principal”. Cada parte pode estar correta, mas o conjunto fica maior do que o argumento exige.

Em um agente editorial, a instrução “seja claro” pode agravar esse comportamento. O modelo interpreta clareza como repetição e fechamento completo.

Uma política editorial melhor precisa deixar explícito que clareza não exige explicar novamente algo que já foi demonstrado. A conclusão também não precisa existir quando a última seção já conduz o leitor a uma decisão.

## A IA organiza a experiência melhor do que ela realmente aconteceu

As histórias artificiais apresentaram cadeias causais mais contínuas, menos subtramas e maior participação direta do protagonista na resolução.

Em 69% das histórias de IA, a resolução dependia de uma escolha do protagonista, contra 46% das histórias humanas. Em 79% dos textos artificiais não havia subtramas, enquanto essa ausência ocorria em 57% dos textos humanos. Os modelos também preferiam finais baseados em entendimento ou aceitação interna. ([arXiv][1])

Os autores humanos, por outro lado, usavam mais saltos temporais, flashbacks, revelações atrasadas e cadeias causais menos lineares. Também deixavam mais conflitos parcialmente abertos. 

Essa diferença é especialmente relevante para textos baseados em experiências técnicas.

Projetos reais raramente acontecem na sequência limpa que aparece no artigo final. Uma configuração falha. Uma hipótese parece correta e depois é descartada. O time muda de direção. Uma limitação descoberta tarde altera o significado dos resultados.

Quando recebe notas fragmentadas, o modelo tende a reconstruir tudo como uma trajetória coerente:

```text
problema → análise → decisão → implementação → sucesso
```

O artigo fica fácil de acompanhar, mas pode deixar de representar o que aconteceu.

Uma boa revisão editorial não deve remover automaticamente tentativas frustradas, mudanças de opinião, decisões provisórias ou resultados contraditórios. Em muitos casos, esses elementos explicam melhor a decisão do que a solução final.

Não se trata de tornar o texto confuso de propósito. O objetivo é não fabricar uma linearidade que a evidência não sustenta.

## O modelo também performa profundidade

Outro padrão encontrado pelo StoryScope foi a representação corporal das emoções.

As histórias artificiais expressavam emoções por sensações físicas ou metáforas corporais em 81% dos casos, contra 38% nos textos humanos. Os modelos também recorriam mais a descrições olfativas e ao ambiente como reflexo do estado psicológico dos personagens. ([arXiv][1])

Esse recurso funciona bem quando usado com propósito. O problema aparece na repetição. Aquilo que parece sofisticado em uma história torna-se uma assinatura quando utilizado sistematicamente por milhares de textos.

Na escrita técnica, há um equivalente: a linguagem que performa importância.

O agente adiciona frases sobre transformação, impacto estratégico, mudança de paradigma, vantagem competitiva e futuro das organizações. O vocabulário sugere profundidade, mas não acrescenta informação à decisão apresentada.

Um artigo fica mais sólido quando substitui esse tipo de abstração por detalhes verificáveis:

> A nova GPU aumentou a geração de aproximadamente 33 para 60 tokens por segundo.

é mais útil do que:

> A atualização elevou significativamente a capacidade de inovação da infraestrutura de IA.

A primeira frase permite discutir custo, contexto, capacidade e limitações. A segunda apenas declara que algo importante aconteceu.

## Humanos ocupam um espaço narrativo mais disperso

Ao representar cada história como um vetor de decisões narrativas, os pesquisadores encontraram os cinco modelos de IA agrupados em uma região relativamente próxima. Os textos humanos ocupavam uma região mais distinta e dispersa.

A raridade média das combinações narrativas humanas foi de 0,71, contra 0,49 para as histórias artificiais. O estudo também encontrou mais referências nomeadas, complexidade temporal, subtramas e protagonistas moralmente ambivalentes nos textos humanos. ([arXiv][1])

Isso não significa que todo texto humano seja original, nem que um texto mais complicado seja automaticamente melhor. A medida utilizada pelo estudo descreve diferenças estatísticas no corpus, não uma escala universal de qualidade.

O resultado mostra, porém, que os modelos convergem para um conjunto relativamente estreito de decisões seguras.

Na produção editorial, essa convergência aparece quando vários artigos adotam a mesma forma:

* uma abertura com uma dor conhecida;
* uma sequência organizada de princípios;
* um framework;
* uma conclusão que transforma o argumento em recomendação.

Cada artigo pode estar correto isoladamente. Depois de algumas publicações, a repetição torna-se visível.

Por isso, variar palavras não resolve o problema. O agente precisa variar a estrutura quando o material pedir outra estrutura.

Um experimento pode ser apresentado como pergunta, configuração, observações e limitações. Um incidente pode seguir os sintomas, a investigação, as hipóteses descartadas e a resposta adotada. Uma decisão arquitetural pode apresentar contexto, restrições, alternativas e consequências.

O formato deve vir do problema, não do template preferido pelo modelo.

## O que muda em um guia editorial para agentes

Um guia tradicional descreve voz, tom e linguagem. Isso continua sendo necessário, mas é insuficiente para controlar os padrões identificados pelo estudo.

Em 2026, considero mais útil tratar o guia editorial como uma política operacional.

Antes de escrever, o agente deveria identificar:

```yaml
problema:
evidencias_observadas:
fatos_externos:
interpretacoes:
decisoes:
alternativas:
restricoes:
resultados:
limitacoes:
tentativas_que_falharam:
questoes_em_aberto:
```

Esses campos não servem para deixar o processo mais burocrático. Eles impedem que o modelo preencha lacunas com uma narrativa convincente.

Também é importante separar os tipos de afirmação.

Uma observação precisa estar no material fornecido. Um fato externo precisa de fonte. Uma interpretação deve aparecer como interpretação. Uma recomendação precisa indicar onde se aplica, quais critérios a sustentam e em que condições outra escolha pode fazer mais sentido.

Essa separação reduz dois problemas frequentes: transformar correlação em causalidade e apresentar uma experiência localizada como regra universal.

## O agente escritor não deveria revisar sozinho

O StoryScope utiliza uma representação estruturada para transformar características subjetivas em variáveis comparáveis. Essa ideia pode ser aplicada à revisão editorial.

Em vez de perguntar apenas “o texto está bom?”, um segundo agente pode avaliar dimensões específicas:

```json
{
  "clareza_do_problema": 0.0,
  "preservacao_da_intencao": 0.0,
  "densidade_de_evidencias": 0.0,
  "aplicabilidade": 0.0,
  "contexto_e_limitacoes": 0.0,
  "fidelidade_de_voz": 0.0,
  "risco_de_afirmacoes_sem_base": 0.0,
  "risco_de_explicacao_excessiva": 0.0,
  "risco_de_fechamento_artificial": 0.0,
  "risco_de_repeticao_estrutural": 0.0
}
```

O revisor não precisa reescrever tudo. Ele deve indicar a seção problemática e o motivo.

Se a introdução repete o título, revise a introdução. Se uma recomendação não apresenta os critérios, revise aquela recomendação. Se a conclusão cria uma certeza que não existia nas evidências, remova ou reduza a conclusão.

Revisões localizadas preservam melhor a voz e evitam que cada nova passagem pelo modelo torne o artigo mais genérico.

## Os limites da comparação

O estudo analisa ficção longa, não artigos técnicos, documentação ou posts de LinkedIn. A aplicação desses resultados à escrita profissional é uma inferência, não uma conclusão testada diretamente pelos autores.

O desenho do corpus também importa. Os prompts foram reconstruídos a partir de histórias humanas e usados para produzir versões artificiais comparáveis. As histórias tinham milhares de palavras, permitindo analisar estruturas que talvez não apareçam da mesma maneira em textos curtos. ([arXiv][1])

Os autores fizeram controles adicionais, incluindo uma avaliação com textos de comprimentos equivalentes. O classificador baseado em narrativa manteve 93,2% de macro-F1 depois desse ajuste, indicando que o resultado principal não era explicado apenas pela diferença de tamanho entre histórias humanas e artificiais. ([arXiv][1])

Ainda assim, o paper não oferece uma receita para “humanizar” conteúdo. Tentar adicionar ambiguidades, referências culturais, falhas ou mudanças temporais de forma aleatória apenas criaria outro padrão artificial.

A aplicação mais útil está na direção oposta: preservar as irregularidades que já existem no material e impedir que o agente as remova para produzir uma história mais limpa.

[1]: https://arxiv.org/pdf/2604.03136 "StoryScope: Investigating idiosyncrasies in AI fiction"
