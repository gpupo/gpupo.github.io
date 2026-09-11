# Pentaho como plataforma de BI: avalie a arquitetura, não só a licença

Published: 2015-08-07
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/sobre-o-uso-da-suite-pentaho-nas-organizacoes-como-solucao-de-bi/
Tags: Dados, BI

---

Escolher uma plataforma de BI porque existe uma edição Community pode reduzir o
custo de aquisição e, ao mesmo tempo, criar um custo operacional que o projeto
não consegue sustentar.

Esse risco ficou pouco visível na primeira versão deste texto, publicada em
2015. Ela descrevia o Pentaho como uma suíte integrada e tratava a ausência de
licença comercial como uma vantagem central. A descrição dos componentes era
útil naquele contexto, mas não bastava para uma decisão de arquitetura. Também
misturava produto, projetos de código aberto e modelo comercial como se fossem
uma coisa só.

Hoje eu começaria por outra pergunta: **qual parte do problema de dados precisa
ser resolvida e quem será responsável por operá-la?**

## Pentaho não é uma decisão única

O nome Pentaho pode se referir a componentes e capacidades diferentes. Entre
eles estão o Pentaho Data Integration (PDI, também conhecido como Kettle), o
servidor, ferramentas de análise e relatórios e o mecanismo OLAP Mondrian.

A documentação da versão 11 apresenta instalação, servidor, ferramentas de
design, modelagem relacional e multidimensional. Ela também informa que o
Pentaho Analyzer e o Report Designer usam o Mondrian para modelos
multidimensionais. Isso confirma a composição técnica da plataforma, mas não
significa que todos os componentes tenham a mesma licença, o mesmo ciclo de
entrega ou o mesmo suporte. A própria documentação de produção trata ativação e
licenças como parte da instalação. ([documentação de instalação do Pentaho
11](https://docs.pentaho.com/install))

Ao mesmo tempo, o repositório público do PDI continua contendo o código e as
instruções para gerar um pacote de cliente Community Edition. Esse é um fato
sobre o componente e seu processo de build, não uma garantia de equivalência
com a distribuição comercial completa. ([repositório oficial do Pentaho Data
Integration](https://github.com/pentaho/pentaho-kettle))

Antes de comparar “Community” e “Enterprise”, portanto, eu registraria:

- o componente e a versão exatos;
- a origem do pacote que será instalado;
- a licença de cada componente e plugin;
- quais funções dependem do servidor comercial;
- onde serão obtidas correções e atualizações;
- qual configuração foi efetivamente testada.

Sem essa lista, a comparação corre o risco de usar a arquitetura de 2015 para
decidir uma implantação atual.

## Comece pelo fluxo que precisa funcionar

Uma plataforma de dados só produz valor quando o fluxo inteiro funciona. Um
caso típico envolve:

1. extrair dados de bancos, arquivos ou APIs;
2. validar e transformar esses dados;
3. gravá-los em uma camada analítica;
4. aplicar regras de acesso;
5. publicar relatórios ou conjuntos de dados;
6. monitorar execução, atraso e falhas;
7. corrigir o fluxo sem perder rastreabilidade.

O PDI pode atender à parte de integração e transformação. O Mondrian pode fazer
parte de uma solução de análise multidimensional. O servidor e as ferramentas
de relatório cobrem outras etapas. Mas a presença dessas peças não demonstra
que a solução completa atende ao seu ambiente.

Por exemplo, a documentação atual prevê conexões por JDBC e JNDI e explica que
o uso de JNDI centraliza a configuração no servidor de aplicação. Essa escolha
parece pequena até ser necessário trocar uma credencial usada por dezenas de
fluxos. ([configuração de conexões no
Pentaho](https://docs.pentaho.com/install/pentaho-configuration))

O teste deveria reproduzir uma carga realista e responder, pelo menos:

- os conectores necessários funcionam com as versões dos bancos em produção?
- uma execução interrompida pode ser retomada com segurança?
- credenciais ficam fora dos arquivos de transformação?
- logs permitem localizar a etapa e o registro que falharam?
- há controle de acesso suficiente para dados sensíveis?
- a equipe consegue promover mudanças entre ambientes?
- backup e recuperação do repositório foram testados?

Uma demonstração bem-sucedida responde se a ferramenta consegue executar um
fluxo. Essas perguntas mostram se a organização consegue mantê-lo.

## Código aberto não significa operação sem custo

Quando um componente pode ser obtido sem pagamento de licença, o custo inicial
pode cair. A conclusão deve parar aí.

Ainda existem custos de infraestrutura, implantação, atualização, segurança,
observabilidade, treinamento e atendimento de incidentes. Também existe o custo
de integrar componentes que uma distribuição comercial pode entregar de outra
forma. A comparação correta é de **custo total para manter o serviço no nível
exigido**, não apenas de preço do instalador.

Eu separaria os custos em quatro grupos:

| Grupo | O que estimar |
| --- | --- |
| Aquisição | licenças, assinaturas, plugins e ambientes não produtivos |
| Implantação | arquitetura, migração, conectores, segurança e automação |
| Operação | infraestrutura, monitoramento, suporte e recuperação |
| Mudança | upgrades, compatibilidade, capacitação e substituição futura |

Esses valores dependem do contrato e da versão. Não é seguro repetir a antiga
afirmação de que a edição comercial é licenciada “por processador” sem consultar
a proposta vigente. A documentação atual mostra que existem recursos sujeitos
a licença e orienta a instalação de um servidor de licenças, mas o preço e a
métrica comercial precisam ser confirmados com o fornecedor. ([início do
cliente PDI](https://docs.pentaho.com/pdia-data-integration/start-the-pdi-client))

## Três cenários produzem decisões diferentes

### Integração de dados operada por uma equipe técnica

Se o problema principal é construir transformações e a equipe aceita manter o
runtime, o PDI Community pode merecer uma prova de conceito. O critério não é
ser gratuito: é atender conectores, execução, observabilidade e recuperação com
um custo operacional aceitável.

### BI entregue diretamente a usuários de negócio

Se usuários precisam criar análises, administrar permissões e obter suporte com
prazo definido, a avaliação deve incluir servidor, experiência de uso,
governança e contrato. Testar apenas o cliente de integração não representa esse
cenário.

### Plataforma de dados nova

Se o projeto começa sem dependência anterior de Pentaho, eu compararia a
plataforma com alternativas menores e especializadas. Uma suíte reduz algumas
integrações, mas amplia a superfície de atualização. Um conjunto de ferramentas
independentes faz o inverso. A escolha depende da capacidade da equipe e dos
requisitos de operação; não existe vantagem automática em ter mais componentes.

## Faça uma prova de operação, não uma demonstração

Antes da adoção, eu usaria um fluxo pequeno, porém incômodo o bastante para
expor os riscos:

1. escolha uma fonte real e uma regra de transformação relevante;
2. defina volume, frequência e tempo máximo de recuperação;
3. implemente desenvolvimento, homologação e produção;
4. provoque falha de conexão e entrada inválida;
5. atualize uma credencial e uma dependência;
6. restaure o ambiente a partir de backup;
7. registre horas de implantação e de operação.

O resultado não precisa provar que Pentaho é “bom” ou “ruim”. Ele precisa mostrar
se aquela combinação de versão, componentes e responsabilidades cabe no
ambiente avaliado.

A principal correção em relação ao texto de 2015 é esta: a comunidade e o
código disponível são sinais relevantes, mas não encerram a análise. A decisão
deve registrar exatamente o que será usado, quem mantém cada parte e quanto
custa recuperar o serviço quando algo falha.
