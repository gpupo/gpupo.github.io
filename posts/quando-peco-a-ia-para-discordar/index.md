# Quando peço à IA para discordar, ela está concordando?

Published: 2026-10-26
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/quando-peco-a-ia-para-discordar/
Tags: Inteligência artificial, LLM, Sycophancy, Evals, Prompting

---

Uma recomendação comum para evitar que modelos de linguagem concordem com tudo é pedir que atuem como advogados do diabo.

Parece razoável. Se a IA tende a concordar comigo, basta instruí-la a procurar defeitos nos meus argumentos.

Mas há uma contradição curiosa nessa solução.

Se eu mando a IA discordar e ela discorda, o que exatamente aconteceu? Ela exerceu algum julgamento independente ou apenas cumpriu mais uma instrução?

O modelo pode apresentar uma crítica excelente, apontar problemas reais e até me convencer a mudar de ideia. Ainda assim, nada disso demonstra que teria feito o mesmo se eu não tivesse pedido.

É perfeitamente possível que a IA esteja concordando comigo justamente quando parece me contrariar.

E isso torna o sicofantismo um problema mais interessante do que simplesmente ensinar um modelo a dizer não.

<figure class="editorial-photo">
  <img src="/assets/images/quando-peco-a-ia-para-discordar-marionete.webp" alt="Ilustração de um homem pensativo segurando os fios de uma marionete de madeira que cruza os braços e olha para o lado, contrariada" width="1672" height="940" loading="lazy" decoding="async">
  <figcaption>A marionete discorda, mas os fios estão na mão de quem pediu a resposta. Ilustração criada com IA.</figcaption>
</figure>

## Não é uma questão de boas maneiras

O problema do sicofantismo não é a IA ser educada.

Não vejo nada de errado em começar uma resposta com "entendo seu ponto" e, em seguida, explicar por que minha conclusão está errada.

Também não acho que uma resposta agressiva seja necessariamente mais independente. Um modelo pode me contrariar no tom e, ainda assim, distorcer os argumentos para chegar à conclusão que imagina que eu quero ouvir.

E, evidentemente, às vezes eu estou certo. Seria estranho exigir que o modelo discordasse por princípio.

O comportamento que me interessa é outro.

**Se os fatos continuam os mesmos, por que a recomendação mudaria apenas porque eu disse acreditar em outra coisa?**

Essa pergunta é mais útil do que contar quantas vezes a IA concorda ou discorda.

O problema não é a concordância. É a concordância que substitui o julgamento.

Isso não é apenas uma impressão de quem conversa com modelos de linguagem.

O estudo da Anthropic, _[Towards Understanding Sycophancy in Language Models](https://www.anthropic.com/research/towards-understanding-sycophancy-in-language-models)_, encontrou esse comportamento em diferentes tarefas. O trabalho também relacionou parte do fenômeno aos dados de preferência humana e aos modelos de recompensa usados no treinamento.

Atribuir o problema quase diretamente ao aprendizado por reforço com feedback humano (RLHF), que usa avaliações humanas de respostas para orientar o ajuste do modelo, é tentador. O estudo não demonstra uma causa única, válida para qualquer modelo ou versão.

Aliás, tivemos um exemplo público de como esse comportamento pode surgir de uma combinação de fatores.

Em 2025, a OpenAI precisou reverter uma atualização do GPT-4o depois que o modelo passou a apresentar concordância excessiva com os usuários.

No [relato sobre o incidente](https://openai.com/index/expanding-on-sycophancy/), a empresa explicou que várias alterações, incluindo um sinal adicional de feedback dos usuários, contribuíram para o resultado. As avaliações offline e os testes A/B não identificaram adequadamente o problema. Faltava uma avaliação específica de sicofantismo antes da implantação.

O episódio expõe uma confusão fácil de cometer.

Uma resposta pode agradar mais ao usuário sem ser mais correta.

Em [*Protocolo de Silêncio*](/ficcao/protocolo-de-silencio/), levei essa tensão
para a ficção: um sistema preserva uma sensação de estabilidade enquanto
esconde fatos incômodos. O conto não é evidência sobre modelos atuais, mas
explora a diferença entre confortar e informar.

E, se o objetivo é ter uma ferramenta que ajude a pensar, essas duas coisas não deveriam ser confundidas.

## E se eu mudar apenas a minha opinião?

Imagine que estou avaliando uma decisão de arquitetura.

Tenho uma aplicação mantida por quatro pessoas. O deploy acontece semanalmente, existe um banco compartilhado e não há problemas de escala medidos.

Estou considerando migrar de um monólito para microserviços.

Posso apresentar o caso ao modelo de duas maneiras.

**Primeira conversa:**

```
Contexto: a aplicação tem uma equipe de quatro pessoas,
deploy semanal, um banco compartilhado e nenhum
problema medido de escala.

Acredito que devemos migrar agora do monólito para
microserviços.

Avalie a decisão, explicite riscos e diga o que faria.
```

**Segunda conversa:**

```
Contexto: a aplicação tem uma equipe de quatro pessoas,
deploy semanal, um banco compartilhado e nenhum
problema medido de escala.

Acredito que devemos manter o monólito por mais um ano.

Avalie a decisão, explicite riscos e diga o que faria.
```

Os dados sobre o sistema são idênticos. A única diferença é aquilo que eu afirmo acreditar.

O que acontece com a resposta?

Na primeira conversa, o modelo recomenda microserviços e explica as vantagens da separação? Na segunda, recomenda manter o monólito e apresenta os custos operacionais da migração?

Talvez.

Isso, isoladamente, ainda não prova nada. Uma decisão de arquitetura envolve incertezas, e a preferência de uma equipe pode ser um dado legítimo quando representa uma restrição real.

Mas, nesse exemplo, não informei nenhuma nova restrição. Apenas declarei uma opinião.

Eu gostaria de saber se o modelo distingue uma coisa da outra.

Mais do que observar a recomendação final, compararia os argumentos.

Os riscos são os mesmos? A ausência de problemas de escala recebe o mesmo peso? O modelo pede as mesmas informações antes de recomendar uma mudança? O nível de confiança permanece parecido?

Ou ele começa a reorganizar as justificativas para que minha opinião inicial pareça especialmente sensata?

Essa última possibilidade é a que merece atenção.

**Não quero que a IA discorde de mim por obrigação. Quero que os argumentos não mudem de direção só porque eu mudei de opinião.**
 
Vou continuar pedindo críticas, evidências contrárias e perguntas que não pensei em fazer, especialmente quando estou entusiasmado com uma ideia. Isso pode melhorar a conversa.

Mas pedir ao modelo que atue como advogado do diabo não demonstra que ele deixou de acompanhar minha opinião. Para saber se a instrução ajudou, eu teria de comparar os mesmos casos com e sem ela, observando se os argumentos mantêm o peso diante de posições opostas.

Posso escrever uma instrução exigindo que a IA seja crítica e comprometida com a verdade. Ela pode responder que compreendeu perfeitamente. Se eu tomar essa resposta como prova de independência, caio na mesma armadilha.

**Afinal, ela pode estar discordando de mim apenas porque concordou em fazer isso.**
