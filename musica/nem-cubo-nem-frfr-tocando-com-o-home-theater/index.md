# Nem cubo nem FRFR: tocando com o home theater

Published: 2026-09-07
Author: Gilmar Pupo
Editorial: musica
Content type: essay
Canonical: https://www.gpupo.com/musica/nem-cubo-nem-frfr-tocando-com-o-home-theater/
Tags: Música, Ampero One, FRFR, Home theater, Guitarra, Baixo

---

Quando comecei a organizar meus presets para guitarra e contrabaixo na Hotone
Ampero One, apareceu uma questão bastante prática: onde exatamente vou ouvir
isso em casa?

A resposta mais óbvia seria comprar um amplificador.

A segunda, talvez mais coerente com uma pedaleira digital, seria comprar uma
caixa FRFR — *Full Range Flat Response*.

Decidi começar por uma terceira opção:

**o home theater da sala.**

Não porque ele seja melhor que uma FRFR. Não espero que seja. Mas talvez eu não
precise comprar outro equipamento para resolver um problema que já consigo
resolver com o que tenho.

Este ainda é um experimento em montagem. O home theater já está na sala, mas o
wireless que quero usar para atravessá-la ainda não chegou. Por enquanto, tenho
uma decisão e algumas hipóteses para testar, não um resultado definitivo.

## O amplificador já está dentro da pedaleira

Uma pedaleira como a Ampero não entrega apenas efeitos. O
[manual do firmware 3.1][manual-ampero-one] documenta blocos para amplificador,
gabinete ou IR, equalização, compressão, delay, reverb e outros tipos de
processamento.

Boa parte do caminho que tradicionalmente construía o som entre o instrumento
e os nossos ouvidos pode estar sendo simulada digitalmente.

Quando ligo tudo isso num cubo convencional, acrescento ao final da cadeia mais
um amplificador e mais um gabinete, ambos com sua própria coloração.

Isso pode funcionar muito bem. Mas não é necessariamente o que quero enquanto
estou construindo e comparando presets.

Nesse momento, faz sentido experimentar um sistema de resposta mais ampla,
deixando a Ampero definir a simulação de amplificador, caixa e microfone. É essa
a proposta das caixas FRFR voltadas para modeladores.

## Então por que não comprar uma FRFR?

Comecei a pesquisar.

Encontrei desde caixas pequenas para estudo até a
[Valeton VFR-110][valeton-vfr-110], com woofer de 10", tweeter de 1", 325 W
nominais e SPL máximo declarado de 124 dB. É uma caixa projetada também para
trabalhar como monitor ou sistema ativo em situações que vão além da sala de
casa.

Depois aparecem opções ainda maiores e mais caras.

Só que meu problema imediato era outro:

**tocar no apartamento.**

Eu não precisava de 124 dB. Na verdade, 124 dB seria exatamente o contrário do
que eu precisava.

Passei então a olhar soluções compactas, como a
[HeadRush FRFR-GO][headrush-frfr-go], com dois falantes de 3", e a
[NUX PA-50][nux-pa-50], com woofer de 6,5" e tweeter de 1".

Até perceber o óbvio.

Já existe na sala um sistema projetado para reproduzir áudio de faixa ampla, em
estéreo, com caixas distribuídas e subwoofer:

**um home theater 7.1.**

## Não é uma FRFR

Vale fazer essa distinção.

Um home theater não vira uma caixa FRFR para instrumentos simplesmente porque
liguei uma pedaleira nele.

Uma FRFR dedicada foi projetada pensando em modeladores, monitoração, dinâmica
de instrumento, robustez e níveis de uso que um equipamento doméstico não
precisa suportar. O home theater também tem a resposta e o processamento
próprios do conjunto formado pelo receiver, pelas caixas, pelo subwoofer e pela
sala.

Mas, no apartamento, essas diferenças mudam de peso.

Não estou tentando competir com uma bateria. Não estou tentando preencher uma
igreja. Não pretendo colocar o contrabaixo em volume de palco durante duas
horas.

Quero estudar guitarra e baixo, criar presets e ouvir com qualidade em volume
baixo. Nesse cenário, o equipamento que já tenho começa a ficar interessante.

## A ligação é simples

A cadeia que quero testar fica assim:

```text
Guitarra / Baixo
       ↓
Hotone Ampero One
       ↓
   saída L/R
       ↓
 AUX / LINE IN
       ↓
Home theater
```

Na Ampero, deixo ativos a simulação de amplificador, o gabinete ou IR, os
efeitos e o processamento estéreo.

No receiver, quero começar pelo caminho contrário: processar o mínimo possível.
Em vez de Dolby, surround virtual ou algum modo “cinema”, começo em estéreo ou
2.1.

A Ampero cria o ambiente. O home theater tenta reproduzi-lo.

Essa diferença entre “cria” e “tenta reproduzir” importa. Se eu corrigir demais
o preset para compensar a sala ou o receiver, posso acabar construindo um som
que só funciona ali.

## E o baixo?

Essa talvez seja a parte mais curiosa.

Quando comecei a olhar caixas pequenas para o apartamento, apareceu uma
limitação física inevitável. Não espero que dois falantes de 3", por exemplo,
reproduzam os graves do baixo da mesma maneira que um sistema com falantes
maiores ou um subwoofer.

O home theater já tem justamente aquilo que essas caixas pequenas normalmente
não têm:

**subwoofer.**

Isso não transforma o sistema num amplificador de baixo. Também não significa
que seja uma boa ideia enviar muito subgrave, em volume alto e continuamente,
para um equipamento doméstico.

Quero começar com os volumes baixos, observar se há distorção e descobrir
quanto preciso reduzir o subwoofer. Em apartamento, o desafio talvez seja menos
produzir grave e mais impedir que um exercício de escala vire comunicação
sísmica com o vizinho.

## Ainda havia um cabo atravessando a sala

Resolvida a ideia de amplificação, apareceu um problema muito menos filosófico.

O receiver fica de um lado. Eu quero tocar do outro.

Um cabo de áudio atravessando a sala resolve tecnicamente, mas cria aquela
instalação temporária que começa organizada e termina virando parte permanente
da decoração.

Resolvi testar outra solução. Comprei um [M-VAVE WP-9][m-vave-wp-9], um sistema
wireless digital originalmente apresentado pelo fabricante para monitoração
in-ear, mas que aceita sinal estéreo.

A cadeia passa a ser:

```text
Guitarra / Baixo
       ↓
     Ampero
       ↓
 M-VAVE WP-9
       )))
    wireless
       )))
 Home theater
```

Paguei cerca de **R$ 234**, uma fração do valor de uma caixa nova. Mais
importante para esse teste: consigo manter o sinal estéreo da pedaleira.

Isso deve permitir que eu ouça como chegam ao receiver coisas como ping-pong
delay, chorus estéreo, reverbs, modulações e a espacialização entre esquerda e
direita.

O fabricante declara latência de 10,8 ms em estéreo e 4,5 ms em mono. Esses
números são uma referência, não o resultado do meu uso. Quero avaliar o que
realmente interessa quando o WP-9 chegar: a latência percebida na cadeia
completa, o ruído, a estabilidade da conexão e possíveis interferências na
faixa de 2,4 GHz.

## Talvez a melhor compra seja adiar a compra

Ainda gosto da ideia de ter uma FRFR.

Uma Valeton VFR-110 faria mais sentido para ensaio, igreja ou situações em que
eu precisasse levar meu próprio sistema de monitoração. Uma caixa menor também
poderia acabar sendo conveniente.

Mas agora existe uma pergunta anterior:

**eu realmente preciso dela?**

É fácil transformar um novo equipamento numa resposta antes de entender
direito o problema. Neste caso, resolvi inverter a sequência.

Primeiro vou usar o instrumento, a Ampero, o wireless e o equipamento que já
tenho. Depois descubro a limitação.

Se ela aparecer, compro alguma coisa especificamente para resolvê-la. Se não
aparecer, melhor ainda.

## O experimento

Quando o WP-9 chegar, quero testar pelo menos quatro coisas:

1. guitarra limpa e com drive;
2. efeitos estéreo;
3. contrabaixo com e sem subwoofer;
4. diferença perceptível entre cabo e wireless.

Também quero montar alguns presets pensando nesse ambiente.

Não porque o preset do home theater deva necessariamente ser diferente daquele
usado numa FRFR, mas porque isso pode me ajudar a perceber até onde estou
compensando características da sala e até onde estou realmente construindo o
timbre.

Talvez, no final, eu compre uma FRFR. Talvez compre um pequeno monitor. Talvez
descubra que, para tocar no apartamento, não preciso comprar nada disso.

Por enquanto, meu amplificador de guitarra tem sete caixas, um subwoofer e
costumava servir para assistir filmes.

[headrush-frfr-go]: https://www.headrushfx.com/products/frfr-go/index.html "HeadRush FRFR-GO"
[m-vave-wp-9]: https://www.m-vave.com/product?id=wp-9 "M-VAVE WP-9"
[manual-ampero-one]: https://res.hotoneaudio.com/prod/support/Ampero%20One_Online%C2%A0Manual_EN_Firmware%20V3.1.1773037044207.pdf "Manual da Hotone Ampero One para o firmware 3.1"
[nux-pa-50]: https://nuxaudio.com/product/pa50/ "NUX PA-50"
[valeton-vfr-110]: https://shop.valeton.net/products/vfr-110 "Valeton VFR-110"
