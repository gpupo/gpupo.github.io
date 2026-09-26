# Depois do deploy: DevOps mínimo para manter um app operável

Published: 2026-08-27
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/depois-do-deploy-devops-minimo-app-vibe-coded/
Tags: Vibe coding, DevOps, SRE, Engenharia de Software, Inteligência Artificial

---

Nos dois textos anteriores, apresentei a [tese de que vibe coding não elimina
engenharia](/posts/vibe-coding-nao-elimina-engenharia/)
e um [caminho mínimo de
segurança](/posts/vibe-coding-seguranca-minima-prototipo-produto/).
Aqui tento separar três coisas que muita gente acaba colocando no mesmo pacote:

**fazer o software funcionar, tornar o software confiável e operar o software de verdade.**

A terceira parte costuma aparecer tarde.

O app está funcionando localmente.

Alguém conecta um banco.

Coloca no GitHub.

Escolhe algum serviço de hospedagem.

Clica em deploy.

A URL abre.

E pronto:

> está em produção.

Tecnicamente, talvez esteja.

Mas produção não é apenas um lugar onde seu código está rodando.

Produção é um sistema que precisa continuar funcionando quando alguma coisa sair diferente do esperado.

É aí que começamos a entrar no território de DevOps, infraestrutura, operação e confiabilidade.

E aqui vale a mesma ressalva dos posts anteriores:

**o objetivo deste texto não é transformar alguém em profissional de DevOps em quinze minutos.**

Muito menos sugerir que uma checklist substitui experiência.

É justamente o contrário.

Quero mostrar algumas coisas que quem colocou um pequeno software no ar deveria pelo menos conhecer — inclusive para perceber quando chegou a hora de procurar alguém que realmente saiba fazer esse trabalho.

<figure>
  <img src="/assets/images/vibe-coding-confiabilidade-camadas.jpg" alt="Edifício em corte com fundações, infraestrutura e verificações de segurança, desempenho, dados, compatibilidade e qualidade." width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Deploy é uma etapa do ciclo; operar exige caminho de volta, proteção, observabilidade, recuperação e manutenção.</figcaption>
</figure>

## “Subiu” não significa “está operável”

O caminho mais simples de um projeto vibe-coded costuma ser algo assim:

```text
meu computador
     ↓
GitHub
     ↓
plataforma de hospedagem
     ↓
internet
```

Para um protótipo, isso pode ser suficiente.

O problema começa quando aparecem usuários reais.

A partir daí surgem perguntas diferentes:

- se o processo cair, ele volta?
- se o deploy novo quebrar, consigo voltar para a versão anterior?
- se o banco desaparecer, consigo restaurar?
- se alguém roubar uma credencial, até onde consegue chegar?
- se a aplicação ficar lenta, como descubro por quê?
- se o disco encher?
- se uma API externa parar?
- se uma dependência crítica apresentar vulnerabilidade?
- se eu precisar trocar de servidor?
- se eu estiver viajando quando o sistema parar?

Essas perguntas não são mais sobre desenvolver uma feature.

São sobre **operar um sistema**.

## Tenha ambientes minimamente separados

Uma das primeiras tentações de um projeto pequeno é trabalhar diretamente onde os usuários estão.

Você altera.

Faz deploy.

Abre a tela.

Vê se funcionou.

Quando não funciona, corrige correndo.

É um modelo extremamente eficiente até o dia em que deixa de ser.

Mesmo num projeto pequeno, eu tentaria separar pelo menos:

```text
desenvolvimento
      ↓
teste / homologação
      ↓
produção
```

Nem sempre isso precisa significar três infraestruturas caras.

Pode ser algo bem simples.

Mas produção deveria ser tratada de forma diferente.

É onde estão os dados reais.

É onde erros têm consequência.

## Não faça deploy copiando arquivo na mão

Funciona?

Funciona.

Também funciona entrar num servidor via SSH, abrir um arquivo com editor de texto e corrigir uma linha diretamente em produção.

O problema aparece alguns meses depois:

> qual versão está rodando?

> essa alteração está no Git?

> quem mudou isso?

> como reproduzo esse servidor?

O ideal é que exista um caminho previsível.

Algo como:

```text
Git
 ↓
testes
 ↓
build
 ↓
deploy
```

E que você consiga responder facilmente:

**qual commit está em produção agora?**

Isso parece detalhe até a primeira emergência.

O capítulo de [release engineering do livro de SRE do
Google](https://sre.google/sre-book/release-engineering/) descreve builds
reproduzíveis, artefatos identificáveis, testes e trilha de auditoria como
partes do processo de release. A escala ali é muito maior, mas a propriedade
que interessa ao pequeno projeto é a mesma: conseguir ligar o que está em
produção ao código e ao processo que o produziu.

## Saiba voltar atrás

Deploy não deveria ser uma porta que só abre para frente.

Antes de colocar uma versão nova em produção, vale responder:

> se der errado, como volto?

Pode ser simplesmente selecionar o deploy anterior na plataforma.

Pode ser usar uma imagem anterior.

Pode ser fazer rollback de uma release.

A tecnologia específica importa menos que a propriedade:

**o caminho de volta precisa existir e precisa ser conhecido.**

Rollback descoberto durante o incidente costuma ser um processo bem mais emocionante do que deveria.

## Banco de dados merece cuidado especial

Código costuma ser relativamente fácil de recuperar.

O Git está ali.

Você pode reconstruir containers.

Pode subir outro servidor.

Dados são outra história.

Quando sua aplicação começa a armazenar informações reais, o banco provavelmente passa a ser uma das partes mais valiosas do sistema.

Então algumas perguntas deveriam aparecer rapidamente:

- existe backup?
- com qual frequência?
- onde ele fica?
- está separado do ambiente principal?
- é criptografado?
- quanto tempo de dados posso perder?
- quanto tempo demoraria para recuperar?
- alguém já testou a restauração?

Esse último ponto merece repetição:

**backup sem teste de restore é apenas uma promessa.**

Uma prática simples é montar ocasionalmente um banco novo usando o backup.

Se ele não sobe, você descobre num dia tranquilo.

Não durante o desastre.

## Não coloque tudo na internet

Uma aplicação precisa estar acessível pela internet.

Isso não significa que todos os seus componentes precisam estar.

Imagine:

```text
Internet
   |
   v
Proxy / Load Balancer
   |
   v
Aplicação
   |
   +---- Banco
   |
   +---- Cache
   |
   +---- Storage
```

Talvez apenas a primeira camada precise aceitar conexões externas.

O banco provavelmente não.

O Redis provavelmente não.

Uma interface administrativa talvez não.

Um dashboard interno talvez não.

Um princípio útil aqui é:

> se algo não precisa estar exposto, não exponha.

Parece banal.

Mas muita segurança nasce justamente de configurações banais feitas corretamente.

## Credenciais precisam de fronteiras

No começo é comum existir uma única chave mágica.

Ela faz tudo.

A aplicação usa.

O desenvolvedor usa.

O CI usa.

Talvez esteja até no `.env` de algumas máquinas.

Isso aumenta muito o impacto de um vazamento.

Uma prática melhor é separar credenciais por finalidade.

Por exemplo:

```text
aplicação produção
      ↓
credencial própria

CI/CD
      ↓
credencial própria

desenvolvimento
      ↓
credencial própria
```

E conceder apenas as permissões necessárias.

Se uma aplicação apenas lê determinado recurso, talvez ela não precise ter permissão para apagá-lo.

Isso é o princípio do **menor privilégio**.

É uma ideia simples, mas muito poderosa.

## Atualizar também faz parte de operar

Seu software não fica congelado no instante do deploy.

Enquanto ele está funcionando:

- sistemas operacionais recebem atualizações;
- imagens base mudam;
- bibliotecas recebem correções;
- vulnerabilidades são descobertas;
- certificados expiram;
- APIs externas mudam;
- provedores descontinuam versões.

Por isso alguém precisa ter responsabilidade sobre manutenção.

Pode ser uma rotina semanal.

Pode ser mensal.

Depende do sistema.

Mas precisa existir.

Um software colocado na internet e esquecido não permanece igual.

Ele envelhece enquanto o ambiente ao redor muda.

## Coloque algum tipo de monitoramento

Talvez você não precise começar com uma enorme plataforma de observabilidade.

Mas deveria conseguir responder pelo menos:

> meu sistema está funcionando?

> está lento?

> está retornando muitos erros?

> o banco está saudável?

> o disco está enchendo?

> os jobs estão rodando?

> existem falhas repetidas?

Um monitoramento simples já muda muita coisa.

Porque existe uma diferença importante entre:

**o usuário descobrir que seu sistema caiu**

e:

**você descobrir antes do usuário.**

Para projetos pequenos, poucas métricas bem escolhidas podem ser mais úteis do que cinquenta dashboards.

O capítulo [Monitoring Distributed
Systems](https://sre.google/sre-book/monitoring-distributed-systems/) separa
monitoramento para tendências, comparação, alertas, dashboards e investigação.
Essa distinção ajuda a escolher poucas medidas pelo uso que terão, em vez de
colecionar gráficos sem uma decisão associada.

## Logs precisam existir antes do problema

Uma das experiências clássicas de produção é descobrir um bug que aconteceu três horas atrás.

Você abre o sistema.

Agora está funcionando.

E alguém pergunta:

> o que aconteceu?

Sem logs, a investigação rapidamente vira arqueologia.

Vale registrar coisas como:

- erros da aplicação;
- falhas em integrações;
- início e fim de jobs importantes;
- mudanças administrativas;
- erros de autenticação;
- eventos de negócio relevantes.

Mas existe uma armadilha.

**logar tudo também pode ser perigoso.**

Senha não deve aparecer em log.

Token não deveria.

Dados sensíveis talvez não devam.

Headers completos podem conter credenciais.

Observabilidade também precisa de critérios.

## Pense em alertas, não apenas dashboards

Dashboard depende de alguém olhando para ele.

E você provavelmente não estará olhando às 3h17 da manhã.

Algumas condições deveriam gerar alerta.

Por exemplo:

```text
aplicação indisponível
        ↓
      alerta
```

ou:

```text
taxa de erros
      ↑
    limite
      ↓
    alerta
```

ou:

```text
backup falhou
      ↓
    alerta
```

Um bom alerta é aquele que provavelmente exige alguma ação.

Se tudo gera alerta, depois de algum tempo ninguém presta atenção em nenhum.

## Tenha uma ideia de capacidade

Outro fenômeno interessante do pequeno SaaS é que ele pode permanecer meses com quinze usuários.

Até que algum post viralize.

Ou um cliente importe cem mil registros.

Ou um crawler descubra sua API.

Você não precisa projetar um sistema para atender cem milhões de pessoas.

Mas deveria saber aproximadamente onde estão os limites.

Por exemplo:

- quantas requisições a aplicação suporta?
- existe limite de upload?
- existe rate limiting?
- quanto o banco pode crescer?
- o que acontece quando uma fila acumula?
- existe alguma API cujo custo cresce por chamada?

Essa última pergunta ganhou importância especial com sistemas que chamam modelos de IA.

Um endpoint mal protegido pode deixar de ser apenas uma vulnerabilidade técnica.

Pode virar uma fatura.

## Infraestrutura reproduzível ajuda muito

Existe uma fase clássica de pequenos projetos em que o servidor é praticamente artesanal.

Você lembra mais ou menos:

> acho que instalei isso.

> depois alterei aquele arquivo.

> rodei esse comando.

> acho que reiniciei aquele serviço.

Até o dia em que precisa reconstruir tudo.

Por isso gosto muito da ideia de infraestrutura como código, mesmo em escala pequena.

Docker Compose.

Terraform.

Ansible.

Arquivos declarativos da própria plataforma.

Não importa tanto a ferramenta.

Importa conseguir responder:

> se esse servidor desaparecer hoje, consigo reconstruí-lo?

Quanto mais da resposta estiver versionada no Git, melhor.

## Documente as cinco coisas que você só sabe de cabeça

Existe uma documentação de operação extremamente simples que já ajuda bastante.

Imagine um arquivo:

```text
OPERATIONS.md
```

E dentro dele:

```text
Como fazer deploy

Como fazer rollback

Como acessar os logs

Como restaurar backup

Como trocar uma credencial comprometida
```

É pouco.

Mas já transforma conhecimento implícito em conhecimento explícito.

Depois você acrescenta:

```text
Principais serviços externos

Onde ficam os backups

Quem recebe alertas

Como renovar certificados

Como interromper o sistema em emergência
```

Pouco a pouco você deixa de operar baseado apenas em memória.

## E então aparece uma coisa chamada responsabilidade

Até aqui eu descrevi várias práticas relativamente acessíveis.

Boa parte delas inclusive pode ser montada hoje com ajuda de IA.

Você pode pedir:

> crie meu pipeline.

> escreva um Dockerfile.

> configure health checks.

> monte um dashboard.

> faça o script de backup.

> escreva um playbook Ansible.

> revise minhas permissões.

Tudo isso pode acelerar enormemente o trabalho.

Mas aqui existe uma distinção que considero fundamental.

**gerar uma configuração DevOps não significa entender as consequências daquela configuração.**

Um agente consegue produzir vinte arquivos YAML em segundos.

O fato de eles parecerem profissionais não significa que a arquitetura seja boa.

Nem que o isolamento esteja correto.

Nem que os backups estejam protegidos.

Nem que o ambiente consiga se recuperar de uma falha.

Nem que o custo vá se comportar como esperado.

## Existe um momento de chamar alguém que sabe fazer isso

Voltando à analogia da engenharia civil:

se você está construindo uma barraca, talvez não precise contratar um engenheiro estrutural.

Se está construindo um prédio, precisa.

Com software eu faria uma distinção parecida.

Um pequeno projeto pessoal, sem usuários, sem dados importantes e sem impacto financeiro pode aceitar bastante improvisação.

Um protótipo também.

Mas conforme surgem coisas como:

- clientes pagando;
- dados pessoais;
- informações confidenciais;
- pagamentos;
- múltiplas organizações;
- integrações importantes;
- requisitos de disponibilidade;
- obrigações contratuais;
- requisitos regulatórios;
- equipe crescendo;
- impacto financeiro relevante;

o custo de errar começa a subir muito.

E nesse momento eu procuraria profissionais.

DevOps.

SRE.

Segurança.

Arquitetura.

Dependendo do problema, talvez todos eles.

Não necessariamente para criar uma enorme estrutura corporativa.

Às vezes algumas horas de revisão de alguém experiente encontram riscos que você sequer sabia que deveria procurar.

Esse é exatamente o problema do prédio.

Não é que você seja incapaz de testar a parede.

É que o engenheiro conhece modos de falha que você ainda não conhece.

## DevOps não é instalar Docker

Também acho importante fazer essa distinção.

Docker é ferramenta.

Kubernetes é ferramenta.

Terraform é ferramenta.

GitHub Actions é ferramenta.

AWS é plataforma.

Cloudflare é plataforma.

DevOps não é uma coleção dessas tecnologias.

Para um pequeno produto, eu pensaria muito mais em propriedades:

```text
consigo reproduzir?
consigo observar?
consigo recuperar?
consigo atualizar?
consigo voltar atrás?
consigo limitar acesso?
consigo entender uma falha?
```

Se a resposta estiver melhorando, sua operação está amadurecendo.

Você pode fazer tudo isso com uma VM e Docker Compose.

Ou com Kubernetes.

A complexidade da solução deve acompanhar a complexidade do problema.

Adicionar Kubernetes a um sistema que você ainda não sabe restaurar do backup talvez apenas produza um sistema mais sofisticado que você continua sem saber restaurar.

## O objetivo não é parecer profissional

Talvez essa seja a principal mensagem desta sequência.

Não precisamos transformar um pequeno software em uma imitação de uma big tech.

Precisamos entender progressivamente **qual engenharia o risco daquele sistema exige**.

Um vibe-coded app pode começar pequeno.

Pode ganhar testes.

Depois controles de segurança.

Depois um pipeline.

Depois backup.

Depois monitoramento.

Depois procedimentos de recuperação.

E pode continuar crescendo dessa maneira.

Mas existe uma linha importante.

Quando outras pessoas começam a depender seriamente daquele software, não basta mais fazer perguntas para a IA até sentir confiança.

Em algum momento você precisa colocar experiência profissional no processo.

Não porque a IA seja ruim.

Nem porque vibe coding seja irresponsável.

Mas porque **responsabilidade cresce junto com aquilo que construímos**.

A IA tornou extremamente fácil levantar o prédio.

Ainda precisamos saber se as sapatas estão dimensionadas.

E quando não sabemos fazer essa conta, a decisão profissional não é testar mais alguns centímetros de concreto.

É chamar o engenheiro.

Leia a seguir: [QA depois do vibe coding: testar não é apenas clicar na
tela](/posts/qa-depois-do-vibe-coding-testar-nao-e-clicar/).
