# TDD no loop do agente: talvez estejamos ensinando a IA a trabalhar como humanos

Published: 2026-08-11
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/tdd-no-loop-do-agente/
Tags: TDD, Agentes, IA, Testes, Engenharia de software

---

Li **“TDD inside the agent loop — theater or actual value?”**, de Birgitta
Böckeler, e fiquei com uma pergunta: quantas práticas de engenharia continuam
boas quando quem executa o processo inteiro é um agente?

Não se trata de perguntar se testes continuam necessários. A questão é mais
específica: precisamos separar os testes como evidência do TDD como sequência
de trabalho.

Para uma pessoa, escrever um teste que falha, implementar o mínimo para fazê-lo
passar e refatorar reduz o espaço do problema, encurta o feedback e ajuda a
administrar a incerteza. Quando um agente recebe toda a especificação, escreve
o teste e a implementação e observa sozinho o resultado, nem todos esses
benefícios são automaticamente preservados.

## O que o experimento realmente comparou

No [experimento publicado no site de Martin
Fowler](https://martinfowler.com/articles/exploring-gen-ai/tdd-in-the-agent-loop.html),
Böckeler preparou três tarefas greenfield de lógica de negócio, nos tamanhos
pequeno, médio e grande. Em cinco lotes, comparou soluções produzidas duas vezes
com instruções de TDD e duas vezes sem elas. Um dos lotes também incluiu duas
execuções test-first, sem o ciclo incremental completo.

Todas as execuções pediam pelo menos 80% de cobertura. O Claude Sonnet 4.6
gerou as soluções e também foi usado, em uma avaliação separada, para verificar
se as execuções orientadas a TDD haviam seguido o processo. O Claude Opus 4.8
comparou código, design e testes sem saber qual fluxo tinha produzido cada
solução. A autora também examinou cobertura, mutation score, turnos, chamadas de
ferramentas e tokens.

O [repositório do
experimento](https://github.com/birgitta410/tdd-comparisons/) mantém prompts,
resultados, avaliações e código. Essa abertura permite inspecionar o material,
mas não transforma o estudo em um benchmark abrangente: algumas soluções sem
TDD foram reutilizadas nas três rodadas da tarefa média, a amostra é pequena e
parte da noção de qualidade ficou a cargo de uma rubrica criada pelo próprio
modelo avaliador.

## Não apareceu uma vantagem clara para TDD

Nas tarefas pequena e média, as soluções sem TDD ocuparam com frequência as
primeiras posições da avaliação. Depois que o prompt ganhou uma etapa mais
explícita de revisão de design e refatoração, uma solução TDD ficou em primeiro
lugar. Na mesma rodada, outra execução com o mesmo prompt ficou em último.

Na tarefa maior, uma solução sem TDD ficou em primeiro e a outra em último; as
duas soluções TDD ficaram no meio. Considerando todos os lotes, houve resultados
bons e ruins nos dois modos, com desempenho geral ligeiramente pior para TDD na
avaliação do Opus. Os mutation scores também não mostraram uma diferença
consistente a favor do processo.

Isso não demonstra que TDD piora o código produzido por agentes. Demonstra algo
menor e, para mim, suficiente para justificar a pergunta: nesse conjunto de
tarefas, exigir TDD não produziu uma melhoria discernível.

## O resultado mais interessante apareceu no caminho

Depois de avaliar as soluções às cegas, o Opus recebeu os registros das sessões
e tentou explicar as diferenças. Nas execuções sem TDD e test-first, os agentes
tenderam a desenhar tipos, contratos, casos de borda e estrutura antes de
escrever código. Nas execuções TDD, o desenho surgiu de decisões locais e nem
sempre foi revisto. O primeiro teste podia fixar cedo demais a forma da solução.

Essa é uma hipótese gerada a partir dos registros, não uma relação causal
demonstrada. Ainda assim, ela expõe uma possível tensão: a instrução para
implementar apenas o necessário para o próximo teste limita deliberadamente a
visão do problema, enquanto o agente tem acesso à especificação completa desde
o início.

Eu evitaria concluir daí que um modelo consegue manter todo o problema na
“cabeça”. Contexto disponível não é memória confiável. Agentes ignoram
requisitos, perdem relações entre arquivos e fazem suposições com confiança.
Mas essas falhas não são idênticas às limitações humanas que ajudaram a dar
forma ao TDD. Aplicar o mesmo ritual exige verificar novamente se ele combate o
problema certo.

## Test-first não torna o teste independente

Um caso do experimento torna essa diferença concreta. Em uma execução TDD, o
teste [repetiu a lógica usada pela implementação para calcular o valor
esperado](https://github.com/birgitta410/tdd-comparisons/blob/main/tdd-analysis-01-medium-redo/sol-2026-07-10_16-40-51/tdd-analysis-1783694844961.md#potential-issues--observations).
O teste havia sido escrito primeiro, mas continuava sendo autorreferente.

O ciclo podia ficar verde mesmo se o entendimento original estivesse errado.
Quando o mesmo sistema produz implementação, expectativa e confirmação, ele
pode cometer dois erros compatíveis.

O passo vermelho também perde parte do significado sem um ponto de revisão
independente. Ver um teste falhar prova que houve uma falha, mas não que ele
falhou pelo motivo esperado. Um agente pode pular a etapa, antecipar código ou
aceitar uma mensagem de erro que não corresponde ao comportamento que deveria
estar especificando.

Isso não invalida test-first quando uma pessoa escreve o cenário ou revisa o
teste antes da implementação. Nesse arranjo existe separação entre quem define
a expectativa e quem tenta atendê-la. O experimento questiona o TDD inteiramente
dentro do loop autônomo, não todos os usos de TDD em desenvolvimento assistido
por IA.

## O custo aumentou, mas não deve ser lido como uma fatura

O fluxo TDD também produziu sessões maiores. A média de tokens registrada foi
cerca de 8,5 vezes a das execuções sem TDD na tarefa pequena, 2,96 vezes na
tarefa média e 4,89 vezes na grande.

Esses fatores não equivalem ao aumento do custo financeiro. A métrica somou
entrada, saída, leitura e escrita de cache em todos os turnos. Como o contexto
acumulado é relido, o mesmo material entra mais de uma vez na contagem, e
leituras de cache foram somadas sem considerar que custam menos que tokens
novos. A autora também não registrou separadamente os cache hits.

O dado sustenta uma conclusão direcional: o TDD exigiu mais turnos e movimentou
mais contexto. Não sustenta a afirmação de que a conta seria exatamente 2,96,
4,89 ou 8,5 vezes maior. Mesmo com essa limitação, o custo operacional importa
quando a melhoria esperada não aparece nos resultados.

## O que eu mudaria no loop

Minha interpretação não é remover testes nem dar liberdade irrestrita ao
agente. É deslocar a ênfase da reprodução do processo para a independência da
verificação.

Em vez de presumir que o resultado será melhor porque o agente executou
`red → green → refactor`, eu pediria evidências ligadas ao risco da mudança:

- testes de regressão que já existiam antes da implementação;
- cenários de aceitação escritos ou aprovados por uma pessoa;
- testes novos revisados contra a especificação, não apenas contra o código;
- mutation testing para observar se a suíte detecta alterações de comportamento;
- tipos, análise estática e regras arquiteturais executáveis;
- revisão separada de design e dos casos de borda.

O agente ainda pode usar TDD se isso o ajudar. A diferença é que o ritual deixa
de ser aceito como prova. O ambiente avalia o que foi entregue por sinais que
não dependem apenas da narrativa da própria sessão.

Se eu precisasse dar um nome provisório a essa ênfase, seria
**Verification-Driven Development**. Não como uma nova metodologia ou um
manifesto, mas como lembrete: em um fluxo com agentes, a pergunta principal é
quem ou o que consegue contrariar uma solução plausível e errada.

## O que este experimento não responde

As tarefas eram novas, relativamente pequenas e concentradas em lógica de
negócio. O experimento não cobriu uma base legada extensa, concorrência,
sistemas distribuídos, interfaces, requisitos de segurança ou uma equipe
mantendo o código ao longo de meses.

Também não isolou todas as variáveis. O modelo que julgou qualidade é outro
LLM, a rubrica não foi definida integralmente antes das execuções e nenhum dos
agentes seguiu TDD de forma perfeita. Outros modelos, prompts e tarefas podem
produzir resultados diferentes.

Por isso, “TDD morreu” seria uma conclusão que os dados não sustentam. A leitura
mais útil é outra: uma prática criada e refinada para pessoas não deve entrar no
loop de um agente por herança. Se ela adiciona instruções, turnos e custo, sua
contribuição precisa aparecer em avaliações comparáveis.

Talvez estejamos tentando ensinar agentes a trabalhar como humanos quando o
desafio real é construir uma forma melhor de verificar um sistema que não
trabalha como nós. Os testes continuam centrais. O que deixou de ser automático
é a ideia de que o caminho até eles precisa continuar igual.
