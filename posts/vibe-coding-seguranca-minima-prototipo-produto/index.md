# Vibe coding: segurança mínima antes de tratar protótipo como produto

Published: 2026-08-27
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/vibe-coding-seguranca-minima-prototipo-produto/
Tags: Vibe coding, Segurança, Engenharia de Software, Inteligência Artificial, Qualidade

---

No [post anterior](/posts/vibe-coding-nao-elimina-engenharia/), fiz uma comparação entre vibe coding e engenharia civil.

Uma barraca feita com pouco conhecimento pode ser testada empiricamente. Você monta, puxa daqui, empurra dali, joga água por cima e, depois de algum tempo, decide se topa dormir dentro.

Um prédio de vinte andares é outra conversa.

O problema é que software tem uma característica curiosa: **uma barraca pode virar prédio muito rápido**.

Você começa com:

> quero uma página onde eu possa cadastrar meus clientes.

Depois acrescenta login.

Depois usuários diferentes.

Depois upload de documentos.

Depois cobrança.

Depois uma API.

Depois integra com algum serviço externo.

Quando percebe, aquilo que nasceu em uma tarde de vibe coding já armazena dados reais de outras pessoas e está exposto na internet.

Então vem a pergunta inevitável:

**o que um pequeno software vibe-coded pode fazer para começar a caminhar na direção de um produto confiável?**

Não acho que a resposta seja transformar todo pequeno projeto em uma operação de segurança de banco.

Também não acho que a resposta seja rodar um scanner, receber uma tela verde e considerar o assunto encerrado.

Para projetos pequenos, eu começaria buscando algumas propriedades básicas.

<figure>
  <img src="/assets/images/vibe-coding-confiabilidade-camadas.jpg" alt="Edifício em corte com fundações, infraestrutura e verificações de segurança, desempenho, dados, compatibilidade e qualidade." width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Confiabilidade surge da combinação de arquitetura, segurança, testes, operação e observação; nenhum selo isolado cobre o sistema inteiro.</figcaption>
</figure>

## Primeiro: saiba o que você construiu

Parece óbvio, mas talvez seja a etapa mais importante.

Antes de tentar descobrir se o software é seguro, tente conseguir explicar seu funcionamento.

Algo simples:

```text
Browser
   |
   v
Aplicação
   |
   +--> Banco de dados
   |
   +--> Serviço de e-mail
   |
   +--> API externa
```

Depois responda:

- onde ficam os dados?
- quais dados são armazenados?
- quem consegue acessá-los?
- existe autenticação?
- existe autorização?
- quais serviços externos recebem informações?
- onde ficam as credenciais?
- o que está exposto diretamente à internet?

Se você não consegue desenhar esse mapa, provavelmente também terá dificuldade para avaliar o risco.

Isso não precisa começar com um documento de arquitetura de cinquenta páginas.

Um desenho com seis caixas já ajuda muito.

## Depois: descubra o que realmente precisa proteger

Nem todo software tem o mesmo risco.

Uma calculadora de frete sem login é uma coisa.

Um aplicativo que armazena documentos pessoais é outra.

Uma pergunta simples ajuda:

> se alguém explorar esse sistema amanhã, qual é o pior resultado plausível?

Pode ser:

- apagar dados;
- visualizar dados de outros usuários;
- assumir uma conta;
- obter uma chave de API;
- gerar custos em serviços externos;
- enviar spam usando sua infraestrutura;
- modificar informações;
- derrubar o serviço.

Essa pequena lista já é uma forma rudimentar de **threat modeling**.

Não precisa começar sofisticado.

Você está apenas tentando pensar antes do atacante.

Quando esse mapa inicial precisar virar critérios verificáveis, o [OWASP
Application Security Verification Standard
(ASVS)](https://owasp.org/www-project-application-security-verification-standard/)
oferece uma lista pública de requisitos para desenvolvimento e verificação de
segurança em aplicações web. Não é uma certificação automática; é uma base
mais concreta para decidir o que revisar.

## Reduza o que existe para atacar

Uma das melhores ferramentas de segurança continua sendo uma ferramenta pouco glamourosa:

**menos coisas.**

Se o aplicativo não precisa de upload de arquivos, não implemente upload.

Se não precisa de login social, não adicione cinco provedores OAuth.

Se não precisa expor uma API pública, não exponha.

Se uma chave só precisa ler dados, não dê permissão de escrita.

Se o banco pode ficar inacessível pela internet pública, deixe-o inacessível.

Cada funcionalidade nova cria código, configuração, dependências e caminhos possíveis de ataque.

Segurança também é administrar superfície.

Para software pequeno, simplicidade arquitetural é uma excelente estratégia defensiva.

## Secrets não pertencem ao código

Esse deveria ser um dos primeiros testes.

Procure por:

```text
API_KEY=
SECRET=
PASSWORD=
TOKEN=
PRIVATE_KEY=
```

Chaves de API, senhas, tokens e credenciais não deveriam estar hardcoded no código nem versionados no Git.

Use variáveis de ambiente ou algum mecanismo adequado de gerenciamento de secrets.

E trate um secret que foi publicado como comprometido.

Não basta apagá-lo do arquivo.

Ele pode continuar no histórico do Git, em logs, builds ou caches.

Rotacione a credencial.

A [orientação da OWASP sobre gestão de
secrets](https://cheatsheetseries.owasp.org/cheatsheets/Secrets_Management_Cheat_Sheet.html)
também trata exposição como motivo para revogação ou rotação. Apagar o valor do
arquivo não encerra o incidente porque outras cópias podem continuar válidas.

## Dependências também são parte do seu software

Quando a IA gera uma aplicação moderna, frequentemente instala dezenas — às vezes centenas — de dependências.

Você talvez tenha escrito mil linhas.

Mas está executando muito mais código do que isso.

Então vale verificar:

- quais dependências estão instaladas;
- quais possuem vulnerabilidades conhecidas;
- quais não são realmente necessárias;
- quais estão abandonadas;
- quais versões estão fixadas.

Ferramentas automáticas ajudam bastante aqui.

Não porque elas garantem segurança.

Mas porque encontram problemas conhecidos por um custo muito baixo.

Esse é exatamente o tipo de trabalho que vale automatizar.

## Coloque análise estática no caminho

Outro passo relativamente barato é adicionar análise estática.

Ela pode procurar padrões como:

- uso inseguro de funções;
- construção perigosa de queries;
- execução arbitrária;
- credenciais expostas;
- validações ausentes;
- bibliotecas vulneráveis.

Um pequeno projeto pode começar rodando isso antes de cada merge ou deploy.

Não precisa haver uma equipe de AppSec olhando cada commit.

O importante é criar uma barreira automática para erros conhecidos.

Eu gosto da ideia de pensar nessas ferramentas como detectores de fumaça.

Um detector de fumaça não garante que sua casa nunca pegará fogo.

Mesmo assim, eu prefiro uma casa com detector.

## Teste autorização, não apenas login

Um erro comum é verificar que o usuário consegue entrar e assumir que a parte de segurança está resolvida.

Autenticação responde:

> quem é você?

Autorização responde:

> o que você pode fazer?

Essa segunda pergunta costuma ser muito mais interessante.

Imagine uma URL:

```text
/invoices/123
```

Se eu estiver autenticado e trocar para:

```text
/invoices/124
```

consigo visualizar a fatura de outro cliente?

Esse tipo de teste é extremamente importante.

Faça testes explicitamente tentando:

- acessar registros de outro usuário;
- editar registros de outro usuário;
- acessar telas administrativas;
- chamar endpoints diretamente;
- modificar IDs enviados pelo navegador;
- executar ações sem a permissão correta.

Não teste apenas o caminho feliz.

Tente quebrar suas próprias regras.

## Desconfie de tudo que vem de fora

Campos de formulário.

Query strings.

Headers.

Uploads.

JSON recebido por APIs.

Webhooks.

URLs.

Tudo isso é entrada não confiável.

Uma regra razoável para pequenos projetos é:

**valide entrada na fronteira do sistema.**

Tipo.

Formato.

Tamanho.

Valores permitidos.

Isso reduz uma quantidade surpreendente de problemas.

E, sempre que possível, use bibliotecas e frameworks que já resolvem classes conhecidas de vulnerabilidade em vez de inventar soluções próprias.

Principalmente para autenticação, criptografia e sessões.

Essas não são áreas muito interessantes para reinventar.

## Faça um teste simples como atacante

Depois que o sistema estiver funcionando, tente utilizá-lo de maneiras que você não projetou.

Por exemplo:

1. abra duas contas;
2. crie dados diferentes em cada uma;
3. tente acessar os dados da conta A usando a conta B;
4. modifique parâmetros nas requests;
5. tente enviar campos inesperados;
6. envie entradas muito grandes;
7. tente endpoints sem autenticação;
8. observe quais informações aparecem nos erros.

É quase um pequeno pentest artesanal.

Não substitui um pentest profissional quando o risco justificar.

Mas para uma aplicação pequena é infinitamente melhor do que testar apenas:

> cliquei no botão e funcionou.

## Os erros também vazam informação

Um software em desenvolvimento costuma dizer coisas demais.

Stack traces.

Queries SQL.

Diretórios internos.

Variáveis.

Nomes de serviços.

Mensagens detalhadas da infraestrutura.

Tudo isso é ótimo para desenvolvimento.

Nem sempre é ótimo para produção.

Para o usuário, prefira algo como:

```text
Não foi possível concluir a operação.
```

Para você, preserve o erro detalhado nos logs.

São públicos diferentes.

## Logs são parte da segurança

Existe outra pergunta importante:

> se alguma coisa estranha acontecer, eu vou perceber?

Um pequeno sistema não precisa começar com um SOC operando 24 horas por dia.

Mas deveria registrar alguns eventos importantes.

Por exemplo:

- tentativas repetidas de login;
- falhas de autenticação;
- alterações de permissão;
- ações administrativas;
- erros inesperados;
- falhas em integrações;
- criação ou exclusão de recursos importantes.

A ideia não é registrar tudo indiscriminadamente.

Também não queremos colocar senhas, tokens ou dados sensíveis nos logs.

Queremos capacidade de reconstruir acontecimentos.

## Backup só existe depois do restore

“Tenho backup” é uma afirmação incompleta.

A pergunta correta é:

> eu consigo restaurar?

Você pode começar pequeno.

Faça um backup.

Apague um ambiente de teste.

Restaure o banco.

Suba a aplicação.

Veja se funciona.

Um backup nunca testado é apenas esperança armazenada em outro disco.

## Atualizações também fazem parte do produto

O aplicativo não termina quando entra em produção.

As dependências envelhecem.

Vulnerabilidades aparecem.

APIs externas mudam.

Frameworks deixam de receber suporte.

Então vale criar uma rotina simples:

```text
periodicamente:

dependências
    ↓
vulnerabilidades conhecidas
    ↓
atualizações
    ↓
testes
    ↓
deploy
```

Não precisa atualizar tudo no mesmo dia em que uma nova versão aparece.

Mas precisa existir algum processo.

Software abandonado conectado à internet tende a envelhecer mal.

## Coloque algumas barreiras automáticas

Se eu estivesse montando hoje um pequeno produto vindo de vibe coding, tentaria chegar rapidamente a algo parecido com:

```text
commit
   ↓
testes
   ↓
lint
   ↓
análise estática
   ↓
scan de dependências
   ↓
scan de secrets
   ↓
build
   ↓
deploy
```

Não porque esse pipeline torne o produto seguro.

Mas porque transforma várias verificações que dependiam de memória em verificações sistemáticas.

Esse é um princípio importante de engenharia:

**quando uma regra precisa ser lembrada toda vez, tente transformá-la em mecanismo.**

## E use a própria IA contra o código que ela produziu

Existe aqui uma oportunidade interessante.

Se usamos IA para produzir software, também podemos usá-la como mais uma camada de revisão.

Por exemplo:

> analise esta aplicação procurando problemas de autorização entre usuários.

Ou:

> identifique todas as fronteiras onde dados externos entram no sistema.

Ou:

> produza um modelo de ameaças para esta arquitetura.

Ou:

> procure caminhos em que um usuário comum poderia executar operações administrativas.

Eu faria isso inclusive em sessões diferentes, fornecendo contexto diferente e pedindo abordagens distintas.

Mas existe uma diferença importante.

Eu trataria essa revisão como **mais um detector**, não como certificação.

A mesma classe de sistema que gerou o código não deveria ser considerada autoridade final sobre a segurança daquele código.

## Um pequeno nível de maturidade já muda bastante

Não acho que todo pequeno SaaS precise começar com processos corporativos enormes.

Mas existe uma diferença considerável entre:

```text
prompt
↓
código
↓
deploy
```

e:

```text
prompt
↓
código
↓
entendimento da arquitetura
↓
revisão
↓
testes
↓
security checks
↓
deploy
↓
observabilidade
↓
manutenção
```

O segundo caminho continua podendo ser extremamente rápido.

Especialmente com IA.

Mas existe engenharia ao redor da geração.

## Talvez o primeiro objetivo não seja “ser seguro”

Existe ainda uma mudança de linguagem que considero útil.

Em segurança, dizer que um sistema **é seguro** costuma ser uma afirmação grande demais.

Prefiro perguntas menores.

Sabemos quais dados temos?

Conhecemos nossas fronteiras?

Testamos isolamento entre usuários?

As dependências estão sendo verificadas?

Os secrets estão protegidos?

Conseguimos restaurar o sistema?

Conseguimos detectar comportamento estranho?

Temos alguém capaz de entender a arquitetura?

Cada “sim” reduz uma parte da incerteza.

É parecido com as sapatas daqueles silos que mencionei no post anterior.

A estrutura não precisava ser magicamente imóvel.

Precisava ter sido projetada para as cargas esperadas, trabalhar dentro de determinados limites e continuar oferecendo margem.

## Vibe coding pode continuar sendo vibe coding

Nada disso exige abandonar a parte divertida.

Continue conversando com o agente.

Continue dizendo:

> faça essa tela.

> implemente esse endpoint.

> escreva esses testes.

> configure esse pipeline.

> analise esta dependência.

> tente atacar essa API.

> explique por que essa autorização está correta.

Aliás, provavelmente vamos usar agentes cada vez mais para fazer boa parte dessas tarefas.

A mudança está menos em **quem digita o código** e mais em **quem assume responsabilidade sobre o sistema**.

Talvez essa seja a evolução natural do vibe coding.

Primeiro:

> faça funcionar.

Depois:

> me ajude a entender o que construímos.

Depois:

> vamos tentar quebrar.

Depois:

> vamos colocar mecanismos para impedir que algumas coisas quebrem.

E finalmente:

> quais riscos ainda decidimos aceitar?

Nesse ponto já não estamos apenas vibe-codando.

Estamos fazendo engenharia.

Só que com ferramentas muito melhores.

Leia a seguir: [Depois do deploy: DevOps mínimo para manter um app
operável](/posts/depois-do-deploy-devops-minimo-app-vibe-coded/).
