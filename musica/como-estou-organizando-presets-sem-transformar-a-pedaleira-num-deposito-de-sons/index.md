# Como estou organizando presets sem transformar a pedaleira num depósito de sons

Published: 2026-09-06
Author: Gilmar Pupo
Editorial: musica
Content type: essay
Canonical: https://www.gpupo.com/musica/como-estou-organizando-presets-sem-transformar-a-pedaleira-num-deposito-de-sons/
Tags: Música, Ampero One, Pedaleira, Timbres, Guitarra, Baixo

---

Tenho uma Hotone Ampero One e, como acontece com muitas pedaleiras digitais,
ela me oferece possibilidades demais.

Amplificadores, caixas, compressores, drives, modulações, delays, reverbs, IRs,
clones de amplificadores e dezenas de parâmetros.

O problema não é falta de opção. É transformar tudo isso num conjunto de sons
que eu conheça e consiga usar sem pensar muito.

Minha primeira tentativa de organização ainda carregava a lógica mais óbvia dos
presets: um patch limpo, outro com drive, outro para solo. Depois de começar a
montar os sons de verdade, mudei de ideia.

## O banco passou a representar um contexto

Em vez de pensar:

```text
Patch 1 → clean
Patch 2 → drive
Patch 3 → solo
```

passei a pensar:

```text
BANCO → um contexto musical

Patch 1 → AMP/CAB A
Patch 2 → AMP/CAB B
Patch 3 → AMP/CAB C
```

Na minha organização, os primeiros bancos ficaram assim:

```text
P01  Worship Bass
P02  Rock Bass
P03  Pop Bass
P04  Soul Bass

P07  Blues Vintage Guitar
P08  Blues Modern Guitar
P09  Jazz Traditional Guitar
P10  Jazz / Fusion Guitar
```

O [manual do firmware 3.1][manual-ampero-one] organiza os 99 patches de usuário
em 33 bancos de três. Mas os três patches de um banco não precisam representar
três níveis de ganho. Passei a usá-los como três plataformas sonoras para a
mesma função.

No `Worship Bass`, por exemplo, estou comparando estas combinações:

```text
P01-1
Alchemy Pre
Adam 1x15

P01-2
Ampage Flip
Flip Top 1x15

P01-3
Ampage Classic
Ampage 8x10
```

Os três patches continuam sendo `Worship Bass`. O que muda é a combinação de
amplificador e caixa.

Essa pequena mudança reorganizou bastante a maneira como estou trabalhando.

## Primeiro comparo a plataforma

Antes de decidir quanto chorus colocar, qual drive usar ou qual frequência
cortar no equalizador, quero descobrir qual é a base do som.

Então tento manter o restante relativamente estável e alterar principalmente:

```text
AMP
CAB
```

Isso cria um pequeno experimento A/B/C. Não preciso decidir antecipadamente
qual modelo deveria ser melhor. Coloco três candidatos sob o pé e toco.

No baixo, isso ficou especialmente interessante porque encontrei modelos bem
diferentes entre si: pré-amplificação mais limpa, B-15, SVT, Mesa Bass e caixas
1x15, 2x10, 4x10 e 8x10.

Em vez de escolher pela descrição, posso escolher ouvindo.

Ainda não estou procurando a combinação definitiva. Quero perceber o que muda
quando troco apenas a plataforma e o restante do patch permanece parecido.

## Os efeitos vêm depois

Quando uma das combinações começa a fazer sentido, passo a experimentar os
efeitos ao redor dela.

Para um som de gospel/funk, por exemplo, penso nas funções mais ou menos assim:

```text
COMPRESSÃO
↓
DRIVE / PREAMP
↓
AMP
↓
CAB
↓
EQ
```

A ordem e os blocos disponíveis impõem limites, mas esse desenho me ajuda a
perguntar o que cada estágio deveria fazer.

Entre os efeitos voltados para baixo da própria Ampero, encontrei:

```text
Basshammer 1
Basshammer 2
Solid Steel
Bass Crusher
Behemoth M
```

[Segundo o manual][manual-ampero-one], os dois Basshammer partem do Aguilar
Tone Hammer e representam o drive desligado ou ligado. O Behemoth M é inspirado
no Darkglass Microtubes B7K. O Solid Steel oferece controle de *blend* entre o
sinal original e o processado.

Para mim, o mais interessante não é descobrir qual desses nomes seria “o
melhor”. É ouvir o que cada peça acrescenta antes de adicionar a próxima.

## Drive não precisa significar outro patch

Esse também foi um ajuste na minha forma de pensar.

Se o patch base já funciona, não preciso necessariamente criar outro apenas
para ter drive. Posso manter algo próximo de:

```text
compressor  ON
preamp      ON
drive       controlável
```

e usar um footswitch para ligar e desligar o drive.

O patch continua sendo o mesmo. O que muda é um estado dentro dele.

Assim, os três patches do banco ficam disponíveis para algo mais estrutural:
comparar diferentes amplificadores e caixas.

Essa organização ainda está em teste. Talvez, em algum contexto, eu volte a
preferir um patch separado para o drive. Por enquanto, poder fazer a comparação
A/B/C tem sido mais útil.

## Reservei espaço de propósito

Também deixei bancos entre os grupos sem uma função fechada.

No baixo:

```text
P01–P04  definidos
P05–P06  reserva
```

Na guitarra:

```text
P07–P10  definidos
P11–P12  reserva
```

Pode parecer desperdício. Para mim, é espaço para a organização crescer sem
precisar ser refeita a cada nova necessidade.

Se aparecer um conjunto específico para fretless, baixo com palheta ou algum
contexto em que ainda não pensei, ele tem onde entrar.

## Então criei um aplicativo para ler a pedaleira

Nesse processo apareceu uma consequência que eu não tinha planejado.

A Ampero permite exportar os presets para um arquivo `.prst`. Resolvi olhar o
arquivo.

Era binário, mas não completamente opaco. Depois de alguma investigação,
consegui identificar a estrutura dos 99 patches de usuário. Queria enxergar,
fora das telas da pedaleira, o nome, o volume e o tempo de cada patch, quais
módulos estavam ligados, que amplificadores e caixas eu havia escolhido e como
a cadeia estava organizada.

Foi daí que nasceu o **Ampero PRST Inspector**, um pequeno aplicativo local que
criei para me ajudar a ler esses exports.

Ele não edita a pedaleira nem altera o `.prst`. Apenas abre uma cópia exportada
e transforma o conteúdo binário num relatório legível. Hoje já identifica os
99 patches, os nove módulos de cada um, os estados ligados ou desligados, os
modelos que conhece, os parâmetros e a ordem da cadeia. Também pode produzir
documentos em formatos que consigo guardar e consultar fora do Ampero Editor.

O primeiro relatório confirmou as três plataformas diferentes que eu havia
montado no `Worship Bass`. Também mostrou que `P02-1`, `P02-2` e `P02-3`, que
ocupavam três posições na pedaleira, ainda eram cópias da mesma combinação de
Basshammer 2, Ampage Classic e Ampage 8x10.

Era exatamente o tipo de coisa que eu não conseguia perceber olhando apenas
para a lista de nomes.

O aplicativo ainda é um protótipo. Foi construído a partir do arquivo que
exportei e conferido contra a lista de efeitos do firmware 3.1. Quando não
reconhece um ID, preserva o número em vez de adivinhar o nome.

Ainda não sei se a mesma estrutura permanecerá em futuros firmwares. Por isso,
não trato o aplicativo como uma especificação do formato, apenas como uma
maneira de inspecionar o meu arquivo atual.

Mesmo com esse limite, a experiência mudou. A pedaleira deixou de ser o único
lugar onde consigo enxergar a configuração.

Posso documentar o que montei, colocar dois relatórios lado a lado e perceber
quais bancos realmente terminei e quais apenas comecei.

## Presets começaram a parecer configuração

Essa é talvez a parte mais familiar para mim, porque já trabalho assim com
software.

Tenho uma configuração. Faço uma alteração. Testo. Comparo. Mantenho uma versão
anterior. Quando algo funciona, aquilo se torna uma nova referência.

Com os presets, comecei a fazer praticamente a mesma coisa: construir, exportar,
abrir no aplicativo, tocar, comparar, ajustar e exportar novamente.

Não quero transformar isso numa infraestrutura complicada. Um arquivo `.prst`
e um leitor local já resolvem boa parte do que preciso agora.

## E ainda apareceram os Sound Clones

No firmware 3.1 que estou usando, a função [Sound Clone][manual-ampero-one]
permite importar, pelo Ampero Editor, modelos externos nos formatos:

```text
.nam
.tone
.clo
```

Isso faz a biblioteca de amplificadores deixar de terminar nos modelos internos
da pedaleira. Posso carregar, por exemplo, uma captura NAM e colocá-la ao lado
das outras opções do banco.

Foi aí que o mesmo problema reapareceu fora da pedaleira. Se eu apenas baixar
modelos, a pasta no computador pode virar outro depósito de sons.

## Uma biblioteca antes da pedaleira

Para evitar isso, comecei a montar a **My Library Sound Clone**, uma biblioteca
pessoal de tones baixados do [TONE3000](https://www.tone3000.com/) para o
[Neural Amp Modeler](https://www.neuralampmodeler.com/).

Cada tone fica numa pasta própria com os arquivos `.nam` e uma pequena ficha:
descrição, autoria, cadeia de sinal e link para a publicação original. O que
ainda não foi catalogado fica separado numa entrada provisória, em vez de se
misturar imediatamente à biblioteca.

Quando fiz o primeiro inventário, havia dois tones de baixo com dez modelos NAM
e quatro de guitarra com 87. Um único conjunto inspirado no Dumble ODS #102
respondia por 83 desses modelos de guitarra.

O número me ajudou a enxergar a diferença entre um tone e uma variação. Eu
tinha seis conjuntos para estudar, mas 97 arquivos que poderia carregar. Se
tratasse cada arquivo como um novo som indispensável, recriaria no computador o
mesmo excesso que estava tentando resolver na pedaleira.

A biblioteca não funciona como uma fila de importação. Ela me permite preservar
os modelos, saber de onde vieram e ouvi-los antes de decidir quais merecem
ocupar uma posição na Ampero. Também mantenho autoria, fonte e licença junto de
cada conjunto. Como os arquivos permanecem sujeitos às condições indicadas por
quem os publicou, essa biblioteca é pessoal e privada.

A ideia continua a mesma: não quero carregar centenas de modelos. Quero
encontrar alguns que mereçam fazer parte da minha linguagem de timbres.

## Menos presets, mais referências

Cada vez mais vejo a pedaleira não como uma coleção de sons, mas como uma
pequena biblioteca de referências.

Quero conseguir responder rapidamente:

```text
qual é meu som de worship no baixo?

qual plataforma funciona melhor para blues?

qual amp/cab estou usando aqui?

o que mudou desta versão para a anterior?
```

Não preciso de cem respostas. Preciso conhecer bem algumas.

A organização que estou montando não tenta aproveitar todos os recursos da
pedaleira. Ela tenta reduzir o espaço de possibilidades até que os sons
escolhidos se tornem familiares.

A pedaleira deixa de ser um depósito de presets e começa a virar um instrumento
que estou aprendendo a conhecer.

[manual-ampero-one]: https://res.hotoneaudio.com/prod/support/Ampero%20One_Online%C2%A0Manual_EN_Firmware%20V3.1.1773037044207.pdf "Manual da Hotone Ampero One para o firmware 3.1"
