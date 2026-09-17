# O trabalho com agentes de IA está migrando da execução para o projeto de sistemas?

Published: 2026-08-17
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/e-se-o-trabalho-estiver-subindo-de-nivel-de-abstracao/
Tags: Agentes de IA, Engenharia de Software, Inteligência Artificial, Automação, Governança

---

Tenho lido afirmações muito diferentes sobre o futuro do trabalho com IA.

De um lado:

**“A IA vai eliminar uma quantidade enorme de empregos.”**

Do outro:

**“A IA não vai substituir pessoas; pessoas usando IA substituirão pessoas que
não usam.”**

Também existe uma terceira versão:

**“Vamos continuar trabalhando, só que muito mais produtivos.”**

E ainda outra:

**“Novas funções aparecerão para compensar as que desaparecerem.”**

Todas parecem plausíveis.

Todas provavelmente estão simplificando demais alguma coisa.

E acho que esse é um bom ponto de partida para discutir o assunto:

**nós ainda não sabemos exatamente o que vai acontecer.**

Estamos tentando interpretar uma transformação enquanto ela acontece.

<figure>
  <img src="/assets/images/trabalho-nivel-abstracao-agentes.png" alt="Profissional transforma documentos, código e ferramentas dispersos em um sistema organizado ao redor de um agente de IA" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Uma hipótese para observar a mudança: parte do trabalho sai da execução de cada etapa e vai para o desenho do sistema.</figcaption>
</figure>

## O que consigo observar no meu próprio trabalho

Nos últimos meses tenho percebido uma mudança interessante na maneira como
trabalho com software.

No começo, IA parecia principalmente uma ferramenta para fazer mais rápido
aquilo que eu já fazia.

Escrever código.

Criar testes.

Documentar uma API.

Investigar um erro.

Montar uma configuração.

Gerar uma consulta SQL.

Era fácil interpretar isso apenas como produtividade.

**Uma tarefa que demorava uma hora pode, em determinadas situações, levar
quinze minutos.**

Mas quanto mais trabalho com agentes, menos tenho certeza de que produtividade
seja a única transformação relevante.

Porque algumas tarefas começam a mudar de natureza.

Em vez de eu executar cada passo, começo a definir o contexto, as regras e os
critérios para que um sistema execute parte deles.

Isso me faz pensar que talvez estejamos subindo mais um nível de abstração.

## Já fizemos isso antes

Gosto de olhar para parte da história da computação dessa maneira.

Já trabalhamos muito mais próximos do hardware.

Depois vieram linguagens de mais alto nível.

Bibliotecas.

Frameworks.

Cloud.

Infrastructure as Code.

Plataformas.

Nenhuma dessas transições simplesmente eliminou todo o conhecimento anterior.

Também não preservou intacta a forma de trabalhar anterior.

Elas mudaram **onde estava o trabalho humano**.

Talvez agentes de IA estejam produzindo algo semelhante.

Talvez não.

Ainda é cedo para saber a dimensão dessa mudança.

Mas é uma hipótese que considero cada vez mais interessante.

## De executar para especificar?

Imagine uma tarefa relativamente comum de manutenção.

Podemos representar o fluxo tradicional assim:

```text
ticket
↓
investigar
↓
alterar código
↓
criar testes
↓
abrir PR
↓
revisar
↓
merge
```

Agora começo a experimentar fluxos diferentes:

```text
problema
↓
coletar contexto
↓
propor diagnóstico
↓
implementar
↓
testar
↓
avaliar
↓
revisão humana
```

A diferença importante não é simplesmente colocar “IA” no segundo desenho.

É perceber onde o humano começa a atuar.

Alguém precisa decidir:

- qual contexto está disponível;
- quais ferramentas podem ser usadas;
- quais arquivos podem ser modificados;
- quais testes precisam passar;
- quais políticas precisam ser respeitadas;
- quais ações exigem aprovação;
- como avaliar o resultado;
- quando interromper a execução;
- como recuperar uma operação problemática.

Talvez parte do trabalho esteja migrando de **executar tarefas** para **projetar
sistemas que executam tarefas**.

Ainda não sei até onde essa mudança vai.

Mas já consigo vê-la em pequena escala.

## Isso não significa que escrever código deixou de importar

Essa é outra conclusão fácil demais.

Se agentes escrevem código, alguém pode concluir que aprender programação
perdeu importância.

Não vejo assim.

Quanto mais delego execução, mais percebo o valor de entender aquilo que estou
delegando.

Se um agente produz uma alteração arquitetural ruim, alguém precisa
reconhecê-la.

Se escreve um teste inútil, alguém precisa perceber.

Se cria uma vulnerabilidade, alguém precisa compreender o risco.

Se encontra uma solução elegante para o problema errado, alguém precisa
identificar isso.

Talvez escrever cada linha seja menos importante em alguns contextos.

**Entender sistemas provavelmente não será.**

## E talvez o produto do engenheiro também mude

Tenho experimentado outra ideia.

Talvez parte do trabalho de engenharia passe a produzir menos código
diretamente e mais **ambientes nos quais código possa ser produzido com
segurança**.

Isso inclui coisas como:

```text
AGENTS.md
PRD.md
DESIGN.md
ADRs
testes
políticas
datasets
evals
observabilidade
guardrails
pipelines
```

Nada disso elimina código.

Na verdade, pode tornar a disciplina de engenharia ainda mais necessária.

Porque gerar código ficou muito barato.

Gerar **software confiável** continua sendo outra história.

## Aqui começam as contradições

É justamente neste ponto que acho perigoso fazer previsões muito confiantes.

Podemos imaginar pelo menos dois futuros.

No primeiro, cada profissional se torna muito mais produtivo.

Uma equipe de dez pessoas passa a produzir aquilo que antes exigia cinquenta.

Nesse cenário, empresas podem precisar de menos pessoas.

Mas existe outro futuro possível.

Se o custo de construir software cair bastante, passamos a construir coisas que
anteriormente não eram economicamente viáveis.

Uma empresa que antes mantinha dez sistemas talvez passe a manter cem.

Nesse cenário, a produtividade cresce, mas a demanda por trabalho também pode
crescer.

As duas coisas podem inclusive acontecer ao mesmo tempo.

Em setores diferentes.

Em empresas diferentes.

Em momentos diferentes.

É por isso que tenho dificuldade com previsões como:

> “Vai acontecer o maior layoff da história.”

Pode acontecer.

Mas também pode não acontecer dessa maneira.

O que parece mais seguro afirmar é que **a composição do trabalho provavelmente
mudará bastante**.

## Algumas atividades podem desaparecer

Também não acho útil fingir que toda transformação tecnológica é indolor.

Se uma atividade puder ser executada por software de maneira suficientemente
barata, rápida e confiável, é razoável imaginar que haverá pressão para
automatizá-la.

Algumas funções podem encolher.

Outras podem mudar.

Novas podem aparecer.

Mas não há garantia de que a pessoa cuja atividade desapareceu será
automaticamente aquela que ocupará a nova função.

Essa transição talvez seja uma das partes mais difíceis da mudança.

## Ao mesmo tempo, aparecem novos problemas

Quanto mais autonomia damos a esses sistemas, mais perguntas surgem.

Quem define a arquitetura dos agentes?

Quem constrói avaliações?

Quem decide os limites de autonomia?

Quem controla custos?

Quem investiga comportamentos inesperados?

Quem observa esses sistemas em produção?

Quem decide quando um humano precisa entrar no loop?

Quem responde por uma decisão errada?

Nada disso prova que essas serão as grandes profissões do futuro.

Mas são problemas que já começo a encontrar no presente.

E isso é suficiente para orientar onde estou colocando parte da minha atenção.

## Então como se preparar para um futuro que não conhecemos?

Essa talvez seja a pergunta mais útil.

Não acredito que seja possível adivinhar exatamente quais ferramentas
utilizaremos daqui a cinco anos.

Talvez nem daqui a dois.

Minha aposta, portanto, não está em uma ferramenta específica.

Está em competências que parecem úteis em vários futuros possíveis.

Entender sistemas.

Definir problemas.

Especificar resultados.

Construir bons critérios de avaliação.

Compreender arquitetura.

Observar comportamento.

Entender riscos.

Projetar limites.

Saber quando confiar na automação e quando exigir intervenção humana.

Se a IA acabar funcionando principalmente como um grande multiplicador de
produtividade, essas competências continuam úteis.

Se eliminar uma parcela significativa da execução manual, tornam-se ainda mais
importantes.

Se criarmos muito mais software porque ficou barato produzi-lo, também
precisaremos delas.

## Não sei qual será o futuro do trabalho

E talvez essa seja justamente a posição mais sensata neste momento.

Não sei se teremos muito menos engenheiros.

Não sei se teremos muito mais software.

Não sei se pequenos times substituirão organizações inteiras.

Não sei se novas categorias profissionais crescerão rápido o suficiente para
absorver as antigas.

Tenho hipóteses.

Tenho sinais.

Tenho experiências práticas.

Mas não tenho como transformar isso em certeza.

O que consigo observar é uma mudança menor e mais concreta:

**cada vez mais consigo escolher entre executar uma tarefa e projetar um sistema
para executá-la.**

E essa escolha muda a maneira como penso sobre meu próprio trabalho.

Talvez estejamos apenas ficando mais produtivos.

Talvez estejamos começando uma transformação muito maior.

Provavelmente descobriremos no caminho.

Enquanto isso, prefiro aprender a operar nos dois mundos:

**entender profundamente o trabalho e, ao mesmo tempo, aprender a construir
sistemas capazes de realizá-lo.**
