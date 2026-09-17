# Flashcards e repetição espaçada no Obsidian: perguntas, lacunas e baralhos no meu vault

Published: 2026-09-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/usando-flashcards-e-repeticao-espacada-no-obsidian/
Tags: Obsidian, Flashcards, Repetição espaçada, Aprendizado, Inglês

---

Guardo no Obsidian parte do material que uso para estudar inglês. As notas são
úteis para registrar e consultar explicações, exemplos e referências, mas não
me fazem necessariamente praticar a recuperação do conteúdo. Eu queria usar
parte desse material de outra forma: tentar responder antes de reler a
explicação.

Foi para criar essa segunda experiência dentro do mesmo vault que experimentei
o plugin
[Spaced Repetition](https://github.com/st3v3nmw/obsidian-spaced-repetition).
Meu objetivo não é transformar todas as anotações em cartões. Uma ficha de
livro, um registro de aula ou uma explicação continuam úteis como texto. Crio
um flashcard quando há algo suficientemente específico que quero conseguir
lembrar sem reler a nota inteira.

Uma nota sobre substantivos contáveis e incontáveis mostra essa diferença. Ela
registra objetivos, regras e exemplos: *book* é contável, *money* não é; por
isso uso *how many* no primeiro caso e *how much* no segundo.

Ao lado dela, criei outra nota com perguntas como estas:

```text
Is "book" a countable or uncountable noun?::Countable.

Is "money" a countable or uncountable noun?::Uncountable.
```

A primeira nota serve para compreender e consultar. A segunda exige que eu
tente recuperar uma resposta. Os exemplos e a interface descritos aqui
correspondem à versão 1.13.8 que ficou preservada no vault, não a um inventário
de tudo o que versões posteriores oferecem.

## A explicação e o cartão cumprem papéis diferentes

Na nota sobre quantificadores, a explicação compara *a few* com *few* e *a
little* com *little*. O conteúdo precisa de contexto porque a presença de uma
única palavra muda o sentido. Nos cartões, essa diferença aparece como uma
decisão:

```text
"There is ___ sugar left." (positive meaning)
?
A little.

"There is ___ sugar left." (negative meaning)::Little.
```

O primeiro é um cartão de várias linhas. O segundo cabe numa linha. A
[documentação do plugin](https://stephenmwangi.com/obsidian-spaced-repetition/flashcards/q-and-a-cards/)
documenta `::` como separador entre pergunta e resposta e `?` como separador
para o formato de várias linhas. Há também versões bidirecionais com `:::` e
`??`, mas elas não aparecem nos exemplos que encontrei no meu vault.

Essa separação entre explicação e recuperação evita que o cartão precise
carregar uma aula inteira. Se eu errar ou perceber que não entendi a regra,
volto à nota de origem, que por sua vez aponta para *English Grammar in Use*,
de Raymond Murphy, e para o contexto da aula.

Nem sempre mantenho os cartões num arquivo separado. A nota sobre a contração
`I'd`, por exemplo, contém primeiro a explicação e depois dois cartões:

```text
I'd like to do it. (Would/Had)::I’d = would

I'd seen it before. (Would/Had)::I’d = had
```

Os dois arranjos aparecem no vault. Separar é útil quando o conjunto de cartões
cresce ou pode ser revisado independentemente. Manter junto preserva
proximidade quando a explicação é pequena. Não encontrei motivo para impor uma
única forma a todas as notas.

## Lacunas preservam a frase que deu sentido à palavra

Para vocabulário, meu padrão mais recorrente usa uma frase completa e oculta
somente a palavra ou expressão que preciso recuperar:


```text
The manager is {{nudging}} the team to adopt more collaborative habits during
their weekly meetings. (Dar um empurrãozinho / incentivar)
```


Minha configuração do plugin reconhece o texto entre chaves como uma lacuna,
ou *cloze*. Na revisão, a expressão é escondida e a frase permanece como
contexto. A pista em português reduz a ambiguidade sobre o que estou tentando
lembrar.

Esse formato veio acompanhado de três regras registradas no vault:

- um flashcard por verbete;
- exemplos completos em vez de definições abstratas, quando possível;
- pontuação consistente.

As regras importam mais do que a escolha das chaves. O plugin também
[documenta lacunas](https://stephenmwangi.com/obsidian-spaced-repetition/flashcards/cloze-cards/)
com realce `==assim==` e permite padrões personalizados. No meu caso, as
chaves se encaixaram no material que eu já estava produzindo e também
podem facilitar uma conversão posterior para outro aplicativo.

Há um risco nesse tipo de cartão: a frase pode oferecer pistas demais. Eu
posso reconhecer a expressão pelo restante da sentença sem conseguir usá-la
em outro contexto. Quando isso acontece, eu revisaria primeiro o cartão, não
o intervalo de revisão. Posso mudar o exemplo, reduzir as pistas ou trocar a
lacuna por uma pergunta direta.

## Tags transformam notas em baralhos

O plugin precisa saber quais notas contêm cartões. No meu material, isso é
feito com tags hierárquicas:

```text
#flashcards/grammar
#flashcards/vocabulary
#flashcards/grammar2026
#flashcards/vocabulary2026
```

A raiz `#flashcards` está configurada no plugin. O trecho posterior à barra
forma um sub-baralho. Assim consigo revisar gramática sem misturá-la com todo
o vocabulário, mas continuo usando tags normais do Obsidian, dentro dos
próprios arquivos Markdown. A
[documentação sobre baralhos](https://stephenmwangi.com/obsidian-spaced-repetition/flashcards/decks/)
também permite usar a estrutura de pastas, porém essa opção está desativada na
configuração que examinei.

Isso combina com a organização atual do meu vault. A pasta informa onde a nota
vive; o link informa de onde ela veio e com quais assuntos se relaciona; a tag
de flashcards informa em qual fila de revisão aquele conteúdo deve aparecer.
Não preciso mover as notas de inglês para uma árvore de pastas criada apenas
para o plugin.

## O agendamento aparece no próprio Markdown

Depois de uma revisão, o plugin acrescenta um comentário como este:

```html
<!--SR:!2026-01-31,1,230-->
```

Segundo a
[documentação de armazenamento](https://stephenmwangi.com/obsidian-spaced-repetition/data-storage/),
esse comentário registra a próxima data, o intervalo e o fator de facilidade
do cartão. Como é um comentário HTML, ele não aparece na leitura normal da
nota, mas continua visível no arquivo e no histórico do Git.

Esse detalhe tem duas consequências. A primeira é portabilidade: o texto do
cartão e seu estado de revisão permanecem em arquivos locais. A segunda é
operacional: revisar cartões altera notas, portanto pode produzir diffs mesmo
quando eu não editei o conteúdo conceitual. Não trato essas alterações como
erro, mas preciso reconhecê-las ao revisar um commit.

Na interface dessa versão, a revisão mostra a pergunta, espera que eu tente
responder e depois permite classificar a lembrança como difícil, boa ou fácil.
O plugin usa essas respostas para calcular quando o cartão volta. O modo de
revisão mostra cartões novos e vencidos; o modo *cram* ignora o agendamento e
apresenta todos. Para estudo contínuo, eu começaria pela fila agendada. O
*cram* faz mais sentido para uma necessidade pontual e não comprova que o
conteúdo foi retido por mais tempo.


## Um começo pequeno e verificável

Para testar o fluxo sem reorganizar um vault inteiro, eu começaria com uma nota
curta e um assunto que já precisa ser estudado:

1. Instalar e habilitar o **Spaced Repetition** nos plugins comunitários do
   Obsidian.
2. Conferir nas configurações a tag dos baralhos e os separadores de perguntas
   e lacunas; as chaves usadas no meu vault não são o padrão documentado.
3. Acrescentar `#flashcards/assunto` à nota escolhida.
4. Escrever algumas perguntas com `::`, ou frases com lacunas, sem apagar a
   explicação que lhes dá origem.
5. Abrir a revisão pela paleta de comandos e tentar responder antes de revelar
   o verso.
6. Classificar a lembrança honestamente e deixar o plugin registrar a próxima
   revisão.
7. Reescrever cartões que continuam ambíguos, fáceis por pistas acidentais ou
   grandes demais para uma resposta clara.

O plugin também oferece revisão de notas inteiras com a tag `#review`. Essa
possibilidade está documentada oficialmente, mas não encontrei evidência de
uso dela nas minhas notas. Para o meu material observado, a distinção mais
útil continua sendo esta: a nota preserva a explicação e suas relações; o
flashcard seleciona uma pequena parte que vale tentar recuperar no futuro.
