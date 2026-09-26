# Vibe coding não elimina engenharia

Published: 2026-08-27
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/vibe-coding-nao-elimina-engenharia/
Tags: Vibe coding, Inteligência Artificial, Engenharia de Software, Segurança, Qualidade

---

Tenho visto alguns posts, principalmente no Threads, de devs — ou de gente que começou a desenvolver com ajuda de IA — fazendo uma pergunta bastante razoável:

**“E agora? Como eu sei se o app que eu vibe-codei é seguro?”**

Os comentários costumam ser muito engraçados. Mas, tentando me ater ao problema, acho que existe uma questão importante aí.

Eu penso em engenharia civil.

Com meu parco conhecimento de construção, provavelmente conseguiria montar uma barraca.

Eu olharia a estrutura, faria alguns testes, observaria se ela balança com o vento, jogaria água para ver se entra chuva e, depois de algumas tentativas, provavelmente toparia passar algumas noites dentro dela.

O risco é relativamente fácil de compreender.

Agora imagine que eu resolvesse construir uma casa de três andares.

Sem ser engenheiro civil.

Sem conhecer cálculo estrutural.

Sem entender fundação, carga, resistência dos materiais ou comportamento do solo.

Como eu testaria se aquela casa é segura?

Provavelmente começaria a testar tudo o que consigo enxergar.

Bateria nas paredes.

Mediria rachaduras.

Jogaria peso no piso.

Tentaria verificar cada centímetro cúbico da construção.

E mesmo assim continuaria com medo.

Porque o problema não é simplesmente **testar mais**.

O problema é não saber exatamente **o que deveria ter sido projetado corretamente desde o começo**.

<figure>
  <img src="/assets/images/vibe-coding-engenharia-inspecao.jpg" alt="Maquete de um edifício de concreto sendo examinada com lupa, paquímetro e nível." width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>Uma interface que parece pronta não mostra se as decisões estruturais foram tomadas nem quais margens ainda existem.</figcaption>
</figure>

## Eu já vi algo parecido de perto

Meu irmão tem um moinho de arroz.

Quando foram instalar três silos enormes, lembro da quantidade absurda de concreto, barras de ferro e preparação necessária apenas para fazer as sapatas.

Aquilo que para quem olha de fora parece apenas um grande recipiente metálico começa muito antes.

Solo.

Fundação.

Distribuição de carga.

Concreto.

Armadura.

Margem de segurança.

Depois de instalados e carregados, houve inclusive um pequeno recalque: a estrutura cedeu alguns centímetros.

Só que isso havia sido considerado.

Estava dentro da margem prevista pelo projeto.

A estrutura podia trabalhar daquela forma.

Esse detalhe ficou na minha cabeça.

O engenheiro não projetou uma estrutura que **jamais pudesse se mover um milímetro**.

Ele projetou uma estrutura sabendo quais movimentos eram aceitáveis, quais cargas poderiam aparecer e quais margens eram necessárias para continuar operando com segurança.

É muito diferente de simplesmente construir e depois sair procurando rachaduras.

## Agora volte para o software

Um aplicativo simples feito por vibe coding talvez seja nossa barraca.

Uma página pessoal.

Um pequeno utilitário.

Uma ferramenta interna com poucos usuários e dados sem grande criticidade.

Você experimenta, testa, encontra problemas, corrige e talvez consiga compreender razoavelmente bem os riscos envolvidos.

Mas as coisas escalam rapidamente.

Login.

Recuperação de senha.

Banco de dados.

Upload de arquivos.

Pagamentos.

Dados pessoais.

APIs externas.

Webhooks.

Integrações.

Permissões.

Times diferentes.

Múltiplos clientes.

Jobs assíncronos.

Filas.

Storage.

Backups.

Logs.

Deploy contínuo.

De repente aquela “barraca” virou um SaaS.

E muitos produtos que vejo sendo propostos com vibe coding não estão tentando construir uma casa de três andares.

Já começam imaginando o equivalente a **um prédio de vinte andares**.

Aí surge a pergunta:

> como eu testo para saber se está seguro?

Talvez essa já seja a pergunta errada.

## Segurança não é uma etapa final

O [Secure Software Development Framework (SSDF) do
NIST](https://csrc.nist.gov/pubs/sp/800/218/final) organiza práticas de
segurança ao longo do ciclo de desenvolvimento. Uso essa referência pelo
critério que ela reforça: reduzir vulnerabilidades exige processo de
desenvolvimento, não apenas inspeção do artefato pronto.

Em software profissional existe uma tentação recorrente de imaginar segurança como uma espécie de inspeção que acontece no final.

Primeiro construímos.

Depois alguém “testa segurança”.

Mas muita coisa importante não funciona assim.

Um pentest pode encontrar vulnerabilidades.

Um scanner pode encontrar dependências conhecidamente vulneráveis.

Um SAST pode apontar padrões perigosos no código.

Um DAST pode atacar a aplicação em execução.

Testes automatizados podem verificar comportamentos.

Tudo isso é útil.

Mas nenhuma dessas ferramentas substitui decisões de engenharia.

Quem pode acessar este recurso?

Onde essa autorização é verificada?

Quais dados realmente precisam ser armazenados?

O que acontece quando um usuário pertence a duas organizações?

Onde ficam os secrets?

Quem pode acessar produção?

Um upload pode executar alguma coisa?

Uma URL enviada pelo usuário pode fazer meu servidor acessar minha própria rede?

Como fazemos recuperação de conta?

O que acontece quando uma integração externa começa a responder de forma inesperada?

Quanto estrago uma credencial comprometida consegue causar?

Se eu perder o banco agora, consigo restaurá-lo?

Qual é minha fronteira de confiança?

Essas perguntas não aparecem automaticamente porque você rodou uma suíte de testes.

Elas fazem parte da arquitetura.

## Então o que fazer com um aplicativo vibe-coded?

Para mim, uma maneira saudável de pensar nisso é simples:

**trate o vibe code como protótipo até que exista evidência suficiente para tratá-lo como produto.**

Isso não significa jogar o código fora.

Muito pelo contrário.

A IA pode ter produzido uma excelente quantidade de trabalho inicial.

Pode ter criado interface, domínio, migrations, APIs, testes e infraestrutura em velocidade impressionante.

Mas velocidade de construção não muda a natureza do trabalho restante.

Alguém ainda precisa fazer engenharia.

Revisar arquitetura.

Entender fluxos de dados.

Modelar ameaças.

Definir fronteiras de confiança.

Revisar autenticação e autorização.

Verificar gestão de secrets.

Revisar dependências.

Eliminar configurações inseguras.

Definir políticas de acesso.

Criar testes relevantes.

Validar entradas.

Pensar em abuso.

Observar comportamento em produção.

Definir backup e recuperação.

Depois entra QA.

Depois segurança.

Depois operação.

Depois monitoramento.

Depois manutenção.

E isso não acontece necessariamente em uma sequência rígida. Em bons times essas disciplinas se misturam durante o desenvolvimento.

O ponto é outro:

**elas continuam existindo.**

## A IA eliminou parte do esforço de construção, não as propriedades do sistema

Esse talvez seja o ponto que às vezes se perde na discussão sobre vibe coding.

Gerar código ficou extraordinariamente barato.

Mas confiabilidade não ficou automaticamente barata.

Segurança não ficou automaticamente barata.

Operação não ficou automaticamente barata.

Compreensão do domínio não ficou automaticamente barata.

Responsabilidade definitivamente não ficou barata.

A IA consegue produzir em alguns minutos uma quantidade de software que antes exigiria dias ou semanas.

Isso é fantástico.

Só que também significa que conseguimos chegar muito mais rapidamente a sistemas cuja complexidade ultrapassa nossa capacidade de compreendê-los.

Esse é um tipo novo de risco.

Antes, muitas vezes nossa dificuldade em construir funcionava como um limitador natural de complexidade.

Agora podemos pedir:

> crie autenticação, multi-tenancy, pagamentos, painel administrativo, upload de documentos, integração com Stripe, envio de e-mails e deploy.

E pouco depois existe algo aparentemente funcionando na tela.

Visualmente, o prédio já está lá.

A pergunta é se alguém calculou as sapatas.

## “Mas está funcionando”

Essa talvez seja uma das frases mais perigosas em software.

Funcionando é uma propriedade importante.

Mas é apenas uma delas.

Uma aplicação também precisa ser:

- correta;
- segura;
- recuperável;
- observável;
- operável;
- compreensível;
- atualizável;
- resistente a uso inesperado.

Uma ponte que suporta dez carros durante o teste não necessariamente suporta dez mil carros durante anos.

Da mesma maneira, um SaaS que funcionou comigo durante uma semana não necessariamente está preparado para usuários reais, ataques automatizados, concorrência, perda de conectividade, falhas externas e dados que precisam existir pelos próximos cinco anos.

## O papel do profissional talvez fique ainda mais importante

Existe uma interpretação de IA para programação que imagina um futuro em que a engenharia desaparece porque qualquer pessoa pode pedir um sistema para um modelo.

Eu vejo quase o contrário.

Quanto mais barato fica gerar software, mais importante fica alguém capaz de olhar para aquele software e perguntar:

**isso deveria ter sido construído dessa maneira?**

Não é apenas revisar sintaxe.

É entender consequências.

É reconhecer padrões de falha antes de eles aparecerem.

É saber onde vale colocar margem.

É distinguir uma barraca de uma casa de três andares.

E perceber quando alguém acabou de pedir para a IA construir um prédio de vinte.

Vibe coding pode ser uma ferramenta extraordinária para explorar ideias, aprender, criar protótipos e até acelerar fortemente a construção de produtos reais.

Mas existe uma diferença enorme entre:

**“a IA conseguiu construir isso”**

e

**“nós sabemos que isso pode operar com segurança.”**

Entre essas duas frases ainda existe engenharia.

E talvez essa seja justamente uma das competências mais valiosas nessa nova fase do desenvolvimento de software.

Leia a seguir: [Vibe coding: segurança mínima antes de tratar protótipo como
produto](/posts/vibe-coding-seguranca-minima-prototipo-produto/).
