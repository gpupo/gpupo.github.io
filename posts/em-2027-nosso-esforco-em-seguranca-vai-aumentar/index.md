# Como revisar o raio de explosão de agentes de IA antes do incidente

Published: 2026-08-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/em-2027-nosso-esforco-em-seguranca-vai-aumentar/
Tags: Segurança, Arquitetura de Software, Inteligência Artificial, SDLC

---

Não sei quantas horas dedicaremos à segurança em 2027. Minha hipótese é que o
esforço vai aumentar, mas esse número isolado dirá pouco.

Podemos gastar mais tempo corrigindo alertas, revendo permissões depois do
deploy e respondendo a incidentes. Também podemos deslocar parte desse trabalho
para o momento em que decidimos quais identidades, dados e ações cada componente
realmente precisa receber.

A diferença apareceu enquanto eu organizava a [Blast Radius
Review](https://www.bpstrat.com.br/docs/arquitetura-engenharia/blast-radius-review.html)
para a BP STRAT. A prática começa com uma hipótese desconfortável: escolha um
componente e considere que ele foi completamente comprometido.

Depois, siga o caminho.

Quais credenciais ficaram disponíveis? Quais dados podem ser lidos ou
alterados? Quais sistemas aceitam conexão? Qual ação irreversível pode ser
executada? Qual é o próximo salto?

Esse exercício não descobre como o ataque começou. Ele mostra o tamanho que o
incidente pode alcançar com as permissões atuais.

## Agentes mudam o que um componente consegue fazer

Uma aplicação tradicional já pode reunir acesso a banco, storage, filas e APIs
internas. Um agente pode acrescentar e-mail, documentos, navegador, memória e
ferramentas capazes de executar ações.

Essas capacidades são o motivo para adotar o agente. Também são parte do risco
que precisa ser modelado.

Se um agente deve consultar pedidos, eu verificaria por que sua ferramenta
também pode cancelá-los. Se precisa preparar um e-mail, questionaria se o envio
deve ocorrer sem aprovação. Se consulta a infraestrutura, tentaria manter fora
de seu alcance os comandos administrativos.

Limites descritos no prompt ajudam a orientar o modelo, mas não substituem
autorização, isolamento e validação fora dele. Quando uma ação não deveria
acontecer, a arquitetura precisa ter uma forma de negá-la.

## Mais controles no final podem ser apenas mais trabalho

Minha preocupação com 2027 não é somente o aumento da superfície de ataque. É a
possibilidade de respondermos a ela acumulando scanners, checklists e aprovações
no final do desenvolvimento.

Esses controles podem ser necessários. Ainda assim, eles não respondem sozinhos
até onde uma credencial compartilhada permite avançar, por que uma aplicação de
leitura usa uma conta com escrita ou se uma automação consegue atravessar a
fronteira entre produção e administração.

Uma revisão durante o design pode encontrar essas decisões antes que virem
dependências operacionais. Isso não torna o trabalho gratuito nem garante que a
falha será contida. Separar identidades, reduzir escopos, segmentar redes e criar
aprovações também custa tempo e pode introduzir atrito.

O critério que eu usaria é concreto: **qual incidente possível este controle
reduz e qual evidência mostrará que a barreira funciona?**

Sem essa resposta, “investir mais em segurança” corre o risco de significar
apenas mais atividade.

## A pergunta para o planejamento de 2027

Se agentes, automações e integrações receberem novas capacidades, é razoável
esperar trabalho adicional para administrá-las. Essa é uma hipótese, não uma
previsão de orçamento ou de incidentes.

Eu não tentaria fazer esse esforço desaparecer. Tentaria escolher onde ele
acontecerá: perto das decisões de arquitetura, com permissões pequenas e
barreiras testáveis, ou depois do deploy, quando revogar um acesso pode quebrar
um fluxo que já se tornou importante.

Antes de aprovar a próxima integração, eu começaria por um componente e faria a
pergunta da Blast Radius Review:

> Se ele deixar de ser confiável hoje, onde o incidente encontra o primeiro
> limite real?

Se a resposta não estiver no diagrama, na política e em um teste, talvez esse
seja o esforço de segurança que já precisamos colocar no plano de 2027.
