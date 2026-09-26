# Ensinar um agente é ser o sênior enquanto ele é o júnior com muita energia

Published: 2026-09-20
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/ensinar-um-agente-e-ser-o-senior-enquanto-ele-e-o-junior-com-muita-energia/
Tags: Agentes de IA, Supervisão humana, Documentação, MuseScore, Automação, Música

---

Um agente de IA pode produzir em minutos algo que eu levaria uma tarde para
montar. Ele lê arquivos, organiza pastas, escreve documentação, gera uma
partitura e ainda executa verificações. Essa energia é útil. Mas velocidade não
é a mesma coisa que critério.

Tenho organizado uma biblioteca pessoal de partituras e materiais de estudo.
Parte do trabalho é técnica: preservar os arquivos originais, registrar a
origem de cada PDF, identificar versões repetidas e deixar claro quais imagens
servirão apenas como referência para uma transcrição futura. Parte é musical:
decidir como aquela informação deve aparecer para quem vai tocar.

Já escrevi sobre [como uso o Codex para cuidar das minhas
tablaturas](/musica/usando-o-codex-para-cuidar-das-minhas-tablaturas/). Ao
continuar esse trabalho, percebi que a relação com o agente se parecia cada vez
mais com uma dinâmica conhecida: eu ocupava a posição do sênior, enquanto ele
trabalhava como um júnior com muita energia.

Não porque o agente seja uma pessoa em início de carreira. A comparação diz
respeito à divisão do trabalho: ele consegue executar muito, mas ainda depende
de alguém que explicite o objetivo, as convenções e o critério de aprovação.

## Eu estava ensinando as convenções da biblioteca

Ao longo do processo, fui dando instruções que um colega experiente daria a
alguém chegando ao projeto.

Avisei que havia atualizado o ambiente para o MuseScore 4. Mostrei a
continuação de uma partitura numa fotografia. Pedi que materiais que não eram
partituras editáveis também fossem guardados, mas sem forçá-los para dentro da
mesma categoria. Apostilas e referências para transcrições futuras precisavam
continuar na biblioteca, com origem e finalidade documentadas, sem fingir que
eram obras prontas para edição.

Também estabeleci regras para preservar os arquivos recebidos, separar fontes
de derivados e registrar o que ainda precisava de revisão. Essas decisões
foram parar nas instruções do repositório e na documentação de cada obra.

Não era apenas uma lista de tarefas. Eu estava tornando explícitas as
convenções da biblioteca.

## Uma escolha plausível não era a escolha certa

Então pedi:

> Crie um arquivo MuseScore com a melodia de *Blue Monk*, mas aplicada ao
> contrabaixo.

O agente fez bastante coisa certa. Usou a partitura que eu havia fornecido como
referência, escreveu os 12 compassos, colocou a melodia no registro sonoro do
baixo, criou uma tablatura para quatro cordas e vinculou pauta e TAB no mesmo
arquivo.

Também registrou as escolhas editoriais e testou o resultado. A documentação
da obra contabiliza 65 notas em cada pauta e 65 correspondências editáveis
entre notação tradicional e tablatura. Depois de salvar no MuseScore, uma
comparação do MusicXML confirmou que alturas de concerto, ritmos, ligaduras e
posições de corda e casa permaneciam iguais.

Mas o agente tomou uma decisão que eu não teria tomado. Escolheu clave de sol
com indicação de oitava abaixo porque a melodia ficava visualmente mais limpa.
Havia uma justificativa técnica: o registro alto exigiria menos linhas
suplementares.

Faltava uma convenção importante do meu contexto. Na minha biblioteca, uma
partitura para contrabaixo deve usar clave de fá, inclusive quando o registro
da melodia torna a leitura visualmente menos compacta.

Minha revisão coube em uma frase.

O agente refez a pauta em clave de fá com indicação de oitava abaixo e repetiu
as verificações. A mudança de representação não alterou a melodia, os ritmos,
as ligaduras nem as posições da tablatura.

## Ensinar não é reescrever o modelo

Quando digo que estou ensinando um agente, não quero dizer que uma correção
reescreveu permanentemente o modelo ou garantiu que ele repetirá aquela escolha
em qualquer conversa futura.

Estou fazendo algo mais concreto: retirando um critério da minha cabeça e
colocando-o no ambiente de trabalho.

Esse critério pode aparecer nas instruções do repositório, no README da obra,
num template, numa validação automatizada ou no histórico do Git. Assim, a
próxima tarefa não depende apenas da memória da conversa. O projeto passa a
carregar parte do contexto necessário para orientar e revisar o trabalho.

No caso da clave, a correção resolveu a obra atual. Para virar uma convenção
reutilizável, ela precisa ser registrada no lugar em que o próximo agente — ou
eu mesmo no futuro — procurará as regras da biblioteca.

Ensinar, nesse sentido, é transformar conhecimento tácito em critério
consultável.

## O sênior continua responsável pelo resultado

Um colega júnior não precisa que o sênior dite cada clique. Precisa entender o
objetivo, conhecer as convenções do projeto e receber uma revisão clara quando
uma escolha plausível não é a escolha certa.

O sênior, por sua vez, não precisa refazer tudo. Precisa reconhecer o detalhe
que importa, explicar por que ele importa e assumir a aprovação do resultado.

Com agentes, tento manter uma divisão parecida:

```text
agente
→ investigar e executar
→ organizar e documentar
→ comparar e verificar
→ tornar pendências visíveis

minha parte
→ definir intenção e convenções
→ avaliar escolhas plausíveis
→ revisar o que exige conhecimento do contexto
→ responder pelo resultado
```

A analogia termina aí. Um profissional júnior aprende dentro de uma trajetória,
desenvolve julgamento próprio e compartilha responsabilidades humanas que um
agente não possui. Uso a comparação apenas para pensar melhor sobre orientação,
execução e revisão.

A melhor colaboração não é a que dispensa revisão humana. É a que torna a
revisão pequena, específica e eficaz.

O agente entrou com energia para montar, documentar e verificar a partitura. Eu
entrei com o conhecimento do instrumento, das minhas preferências e do padrão
que quero manter. Uma frase foi suficiente para corrigir a direção porque o
trabalho estava legível — e porque eu consegui reconhecer o critério que ainda
estava apenas na minha cabeça.
