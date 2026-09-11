# QA depois do vibe coding: testar não é apenas clicar na tela

Published: 2026-08-27
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/qa-depois-do-vibe-coding-testar-nao-e-clicar/
Tags: Vibe coding, QA, Qualidade, Testes de software, Engenharia de Software, Inteligência Artificial

---

Nos textos anteriores desta sequência, falei sobre
[engenharia](/posts/vibe-coding-nao-elimina-engenharia/),
[segurança](/posts/vibe-coding-seguranca-minima-prototipo-produto/)
e [DevOps](/posts/depois-do-deploy-devops-minimo-app-vibe-coded/)
para pequenos softwares que nasceram de vibe coding.

Falta uma peça importante.

**Qualidade.**

Ou, mais especificamente, QA.

É comum ver alguém terminar uma funcionalidade, abrir a aplicação, clicar em alguns botões e concluir:

> testei. Está funcionando.

Eu faço isso também.

O problema é confundir esse tipo de verificação com um processo de qualidade.

Clicar no caminho que você acabou de construir e confirmar que ele funciona é útil.

Mas é provavelmente o teste mais favorável possível.

Você conhece o sistema.

Sabe o que espera encontrar.

Sabe a ordem correta das ações.

Digita dados razoáveis.

Não tenta deliberadamente fazer besteira.

E, principalmente, está emocionalmente interessado em ver aquilo funcionar.

Isso é quase o oposto de um bom teste.

<figure>
  <img src="/assets/images/vibe-coding-engenharia-inspecao.jpg" alt="Maquete de um edifício de concreto sendo examinada com lupa, paquímetro e nível." width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Clicar no caminho feliz mostra uma parte do sistema; qualidade procura limites, estados intermediários e falhas que a interface não revela.</figcaption>
</figure>

## O desenvolvedor sabe demais

Existe uma diferença curiosa entre usar um software e testá-lo.

Quem desenvolveu pensa:

```text
preencha nome
preencha e-mail
clique em salvar
```

O usuário pensa:

```text
e se eu deixar isso vazio?
```

Ou:

```text
posso colar 30 mil caracteres aqui?
```

Ou:

```text
cliquei duas vezes.
```

Ou simplesmente fecha a aba no meio da operação.

E algumas pessoas possuem um talento quase sobrenatural para fazer exatamente aquilo que você jamais imaginaria que alguém faria.

QA profissional aprende justamente a explorar esse espaço.

Não apenas verificar:

> funciona?

Mas perguntar:

> de quantas maneiras isso pode não funcionar?

## O caminho feliz engana

Imagine uma tela simples de cadastro.

Você digita:

```text
Nome: João Silva
E-mail: joao@example.com
```

Clica em salvar.

A mensagem aparece:

> Cadastro realizado com sucesso.

Ótimo.

Agora tente:

```text
Nome:
E-mail:
```

Depois:

```text
Nome: João
E-mail: joao
```

Depois um e-mail já cadastrado.

Depois espaços no começo e no final.

Depois caracteres especiais.

Depois um nome enorme.

Depois dois cliques rápidos em salvar.

Depois perder a conexão durante a operação.

Depois atualizar a página exatamente quando o request está acontecendo.

Depois abrir duas abas e editar o mesmo registro nas duas.

O sistema continua correto?

Testar é também procurar as bordas.

## Algumas categorias já ajudam muito

Quem está começando não precisa decorar uma enorme taxonomia de testes.

Mas algumas ideias mudam rapidamente a maneira de olhar para o software.

### Teste funcional

A funcionalidade faz aquilo que deveria fazer?

Se eu cadastrar um cliente, ele aparece na lista?

Se eu editar, a alteração é salva?

Se eu excluir, o comportamento é o esperado?

É o nível mais intuitivo.

Mas não deveria ser o único.

### Teste negativo

O que acontece quando faço algo errado?

Senha incorreta.

Campo obrigatório vazio.

Arquivo inválido.

ID inexistente.

Quantidade negativa.

Data impossível.

Acesso sem permissão.

Software real passa uma quantidade enorme de tempo lidando com situações que não estavam no roteiro ideal.

### Teste de limite

Todo sistema possui limites.

Talvez você simplesmente ainda não tenha encontrado os seus.

Se o campo aceita 100 caracteres, teste:

```text
99
100
101
```

Se o upload aceita 10 MB:

```text
9,9 MB
10 MB
10,1 MB
```

Se uma regra permite no máximo dez itens, teste nove, dez e onze.

Problemas adoram viver nas fronteiras.

Para testes de segurança web, o [OWASP Web Security Testing
Guide](https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/)
organiza áreas como autenticação, autorização, sessões, validação de entrada,
tratamento de erros, lógica de negócio e APIs. A lista é útil para ampliar as
perguntas; o contexto do produto continua decidindo quais riscos importam.

## Teste o fluxo inteiro

Outro erro comum é testar componentes isolados e assumir que o processo completo funcionará.

Imagine:

```text
cadastro
   ↓
pagamento
   ↓
confirmação
   ↓
e-mail
   ↓
ativação
```

Cada parte pode funcionar individualmente.

Ainda assim, o fluxo pode quebrar.

O pagamento pode ser aprovado e a ativação falhar.

A ativação pode funcionar e o e-mail não ser enviado.

O usuário pode atualizar a página durante o pagamento.

O webhook pode chegar duas vezes.

Uma integração externa pode responder lentamente.

Por isso alguns dos testes mais valiosos são os de ponta a ponta.

O famoso **end-to-end**.

Não porque tudo precise virar E2E automatizado.

Mas porque alguém precisa verificar se a jornada real continua funcionando.

## Tente repetir as coisas

Software distribuído produz situações interessantes.

Um botão parece não ter respondido.

O usuário clica novamente.

O navegador repete uma requisição.

Uma fila entrega uma mensagem duas vezes.

Um provedor envia novamente um webhook.

Então vale perguntar:

> essa operação pode acontecer duas vezes?

Imagine uma cobrança.

Uma criação de pedido.

Um envio de e-mail.

Uma transferência.

Criar dois registros porque alguém clicou duas vezes pode ser apenas inconveniente.

Cobrar duas vezes é um problema um pouco mais sério.

Esse é um exemplo de como QA começa a encostar em engenharia.

O teste revela um comportamento.

Mas talvez a solução precise estar no desenho do sistema.

## Teste interrupções

Aplicações costumam ser desenvolvidas como se cada operação começasse e terminasse perfeitamente.

Na prática, coisas param no meio.

Tente imaginar:

```text
começou
   ↓
alguma coisa aconteceu
   ↓
falhou
```

O sistema ficou consistente?

O usuário consegue tentar novamente?

Existe informação suficiente para saber o que aconteceu?

Se metade de uma operação foi executada, a outra metade pode continuar depois?

Essas situações são especialmente importantes quando existe integração com:

- pagamentos;
- e-mail;
- armazenamento;
- APIs externas;
- processamento assíncrono;
- filas;
- inteligência artificial.

## Não teste somente interface

Uma aplicação bonita pode esconder comportamentos terríveis.

Clique na interface, claro.

Mas também vale olhar:

- API;
- banco;
- logs;
- jobs;
- integrações;
- permissões;
- estados intermediários.

Às vezes a tela diz:

> operação concluída.

Enquanto o servidor escreveu três erros no log e deixou metade dos dados inconsistentes.

A experiência visual é parte da qualidade.

Não é toda a qualidade.

## Testes automatizados são muito úteis

Este é um ponto em que IA pode ajudar bastante.

Você pode pedir para o agente:

> escreva testes unitários para esta regra.

Depois:

> escreva testes para os casos de erro.

Depois:

> encontre casos de borda que ainda não testamos.

Depois:

> crie testes de integração para esta API.

Isso permite construir rapidamente uma boa base de regressão.

A palavra importante aqui é **regressão**.

Você corrigiu um bug hoje.

Três meses depois alguém altera outra parte do sistema e aquele bug volta.

Um teste automatizado pode impedir que isso passe despercebido.

Por isso uma correção interessante geralmente deveria terminar com:

```text
bug encontrado
      ↓
teste que reproduz o bug
      ↓
correção
      ↓
teste continua existindo
```

O bug vira conhecimento executável.

## Mas quantidade de testes pode enganar

Existe outro número que costuma dar conforto:

> temos 95% de cobertura.

Ótimo.

Mas cobertura responde principalmente:

> este código foi executado durante os testes?

Ela não responde necessariamente:

> este comportamento foi testado corretamente?

Você pode executar uma função inteira e nunca verificar se o resultado faz sentido.

Pode testar vários componentes isoladamente e deixar de testar justamente o fluxo crítico.

Pode ter centenas de testes e não perceber que um usuário consegue perder seu trabalho.

Métrica ajuda.

Não substitui pensamento.

## Teste o que realmente importa para o negócio

Imagine um SaaS com cinquenta telas.

Talvez apenas cinco fluxos sejam absolutamente críticos.

Por exemplo:

```text
usuário cria conta
```

```text
cliente compra
```

```text
pagamento é reconhecido
```

```text
produto é entregue
```

```text
cliente consegue acessar novamente depois
```

Esses caminhos merecem uma atenção diferente daquela destinada a uma configuração pouco utilizada.

Uma pergunta útil é:

> quais falhas fariam eu interromper imediatamente um deploy?

Isso começa a criar prioridade.

Porque qualidade também é gerenciamento de risco.

## Crie alguns critérios antes de desenvolver

Existe um hábito simples que ajuda muito, inclusive quando estamos trabalhando com agentes.

Antes de pedir:

> implemente esta feature.

escreva alguns exemplos do comportamento esperado.

Algo como:

```text
Dado que tenho uma conta ativa
Quando altero meu nome
Então o novo nome deve aparecer no perfil
```

E também:

```text
Dado que não estou autenticado
Quando tento alterar um perfil
Então a operação deve ser rejeitada
```

Você acabou de tornar parte da expectativa explícita.

Pode chamar isso de critério de aceitação.

Pode usar BDD.

Pode colocar no ticket.

Pode simplesmente escrever no PRD.

O nome importa menos do que o princípio:

**definir o que significa “pronto” antes de descobrir isso depois do deploy.**

## Use produção com cuidado

Existe uma frase recorrente:

> produção é o verdadeiro ambiente de teste.

Existe um fundo de verdade.

Nenhum ambiente simula perfeitamente usuários reais, volume real, navegadores estranhos, redes ruins e combinações imprevisíveis.

Mas isso não significa usar clientes como equipe de QA.

Produção deve gerar aprendizado.

Logs.

Métricas.

Erros.

Feedback.

Mas quanto mais crítico for o sistema, mais problemas deveriam ser encontrados antes de chegar lá.

## Erros precisam ser reproduzíveis

Quando alguém diz:

> não está funcionando.

A investigação começa.

O que estava fazendo?

Qual usuário?

Qual horário?

Qual navegador?

Qual dispositivo?

Qual dado?

Qual mensagem apareceu?

Acontece sempre?

Isso parece burocracia até você tentar corrigir um problema que não consegue reproduzir.

Uma boa descrição de bug pode ser extremamente simples:

```text
Contexto
Passos
Resultado esperado
Resultado encontrado
Evidência
```

Por exemplo:

```text
1. Entre como usuário comum.
2. Abra Pedidos.
3. Edite o pedido 123.
4. Clique duas vezes em Salvar.

Esperado:
um pedido atualizado.

Encontrado:
dois registros de cobrança foram criados.
```

Agora temos algo que pode ser investigado.

## IA é ótima para gerar casos que você esqueceu

Aqui novamente existe uma oportunidade interessante.

Você pode entregar uma funcionalidade para outro agente e dizer:

> não implemente nada. Atue como QA e tente encontrar formas de quebrar esta funcionalidade.

Ou:

> liste casos de borda.

Ou:

> crie uma matriz combinando estados, permissões e entradas inválidas.

Ou:

> critique meus critérios de aceitação.

Eu gosto particularmente de separar os papéis.

O agente que implementou tenta fazer funcionar.

Outro agente tenta provar que não funciona.

Isso não garante independência real, mas cria uma dinâmica muito mais interessante do que simplesmente perguntar:

> meu código está bom?

## Existe também qualidade que não aparece em botão nenhum

Performance é qualidade.

Acessibilidade é qualidade.

Compatibilidade é qualidade.

Usabilidade é qualidade.

Resiliência é qualidade.

Imagine uma operação que funciona perfeitamente, mas demora 45 segundos sem dar qualquer feedback.

Tecnicamente funcionou.

Para o usuário, talvez esteja quebrada.

Ou uma interface que funciona no seu notebook, mas não num celular pequeno.

Ou um formulário impossível de navegar com teclado.

Nesse caso, “funciona com teclado” não é apenas preferência: a [WCAG
2.2](https://www.w3.org/TR/WCAG22/) define critérios verificáveis de operação
por interface de teclado e ausência de armadilhas de foco.

Ou uma aplicação cujo consumo de memória cresce até cair depois de algumas horas.

Qualidade é uma propriedade bem maior do que ausência de bugs visíveis.

## Então monte uma pequena rotina

Para um software pequeno, eu começaria com algo simples.

Antes de liberar uma mudança:

```text
requisitos entendidos?
        ↓
casos principais testados?
        ↓
casos de erro testados?
        ↓
permissões verificadas?
        ↓
testes automatizados passam?
        ↓
fluxo crítico funciona?
        ↓
rollback possível?
        ↓
deploy
```

Depois do deploy:

```text
smoke test
    ↓
logs
    ↓
métricas
    ↓
feedback
```

Um **smoke test** pode ser quase ridiculamente pequeno.

Entrar.

Abrir a principal tela.

Criar alguma coisa.

Confirmar que o fluxo essencial continua vivo.

É melhor ter cinco verificações importantes executadas sempre do que uma checklist com oitenta itens que ninguém usa.

## E agora vem a mesma ressalva dos outros textos

Tudo isso é orientação para começar.

Não é formação profissional em QA.

Existe uma diferença enorme entre saber que testes de limite existem e ser uma pessoa experiente em qualidade.

Um bom profissional de QA desenvolve uma forma diferente de olhar para o produto.

Ele questiona premissas.

Encontra combinações improváveis.

Entende risco.

Investiga comportamento.

Explora estados.

Pensa no usuário.

Pensa no negócio.

Pensa em regressão.

Pensa no que ninguém escreveu na especificação.

E talvez principalmente:

**faz perguntas que quem construiu o sistema não pensou em fazer.**

## Quanto mais sério o produto, mais importante essa independência

Se estamos falando de um pequeno utilitário pessoal, tudo bem você mesmo testar.

Se estamos falando de um protótipo descartável, também.

Mas conforme entram:

- clientes;
- dinheiro;
- dados importantes;
- contratos;
- integrações críticas;
- diferentes perfis de usuário;
- regras de negócio complexas;
- requisitos regulatórios;
- impacto financeiro;
- reputação;

eu procuraria alguém que trabalhe profissionalmente com qualidade.

Isso não significa contratar uma equipe de vinte QAs para um SaaS pequeno.

Pode ser uma revisão.

Uma estratégia de testes.

Algumas sessões exploratórias.

Uma análise dos fluxos críticos.

Ajuda para montar automação.

O importante é introduzir **olhos independentes e experientes**.

Porque existe uma categoria de problemas que você não encontra simplesmente perguntando à aplicação se ela faz aquilo que você pediu para ela fazer.

## QA não é a pessoa que encontra bug no final

Essa imagem também precisa mudar.

Se QA entra apenas depois que tudo foi desenvolvido para clicar nas telas, estamos desperdiçando boa parte do valor dessa disciplina.

Qualidade começa antes.

Na pergunta mal definida.

Na regra ambígua.

No comportamento que ninguém decidiu.

No fluxo impossível de testar.

Na dependência externa sem estratégia de falha.

No requisito que diz:

> deve ser rápido.

Quanto é rápido?

> deve suportar muitos usuários.

Quantos?

> usuários não podem ver dados de outros usuários.

Em quais endpoints isso precisa ser garantido?

Um bom trabalho de qualidade transforma frases vagas em condições verificáveis.

Isso melhora o software antes mesmo de existir código.

## Talvez o QA seja quem pergunta “e se?”

O desenvolvedor pergunta:

> como faço isso funcionar?

O produto pergunta:

> isso resolve o problema certo?

Segurança pergunta:

> como isso pode ser abusado?

DevOps pergunta:

> como mantenho isso funcionando?

QA frequentemente pergunta:

> e se?

E se o usuário clicar duas vezes?

E se a API estiver lenta?

E se esse campo estiver vazio?

E se houver dois usuários editando?

E se o navegador voltar uma página?

E se o pagamento for aprovado mas o webhook atrasar?

E se esse dado tiver um formato que ninguém imaginou?

Esses “e se” parecem pequenos.

Até um deles acontecer em produção.

## A IA pode construir e testar

Isso muda bastante nossa capacidade de produzir software.

Podemos pedir para agentes:

```text
implemente
```

depois:

```text
gere testes
```

depois:

```text
critique os testes
```

depois:

```text
tente quebrar o sistema
```

depois:

```text
automatize os cenários encontrados
```

Isso é excelente.

Provavelmente veremos times pequenos alcançando níveis de cobertura e automação que antes exigiam muito mais esforço.

Mas novamente aparece a mesma distinção desta série:

**ferramenta não substitui responsabilidade profissional.**

O agente pode produzir testes.

Alguém ainda precisa decidir se estamos testando as coisas certas.

## Voltando ao nosso prédio

No primeiro texto desta série, falei daquela estrutura de um silo que cedeu alguns centímetros e continuou perfeitamente dentro da margem prevista.

Imagine agora que, depois de construir a estrutura, alguém precise verificar se tudo corresponde ao que foi especificado.

Dimensões.

Materiais.

Comportamento.

Tolerâncias.

Situações previstas.

Não basta olhar para o prédio e dizer:

> parece firme.

Também não basta balançar uma parede e concluir:

> testado.

Software não é diferente.

Quando seu aplicativo é pequeno, você pode aprender bastante fazendo seus próprios testes.

Deve fazer.

Pode usar IA.

Deve usar.

Pode automatizar muita coisa.

Deve automatizar.

Mas quando aquele software começa a sustentar alguma coisa importante, procure um profissional de qualidade.

Porque existe uma diferença enorme entre:

**“eu usei e não encontrei problemas”**

e

**“nós temos evidências razoáveis de que isso se comporta como deveria.”**

Entre essas duas frases existe QA.

E, assim como segurança, DevOps e arquitetura, QA não desapareceu porque ficou mais fácil escrever código.

Talvez tenha ficado ainda mais importante.

Afinal, agora conseguimos produzir muito mais software.

Precisamos também ficar melhores em descobrir quando ele está errado.

Leia a série desde o início: [Vibe coding não elimina
engenharia](/posts/vibe-coding-nao-elimina-engenharia/).
