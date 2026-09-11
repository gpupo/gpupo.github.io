# MCP conecta agentes a ferramentas, mas não resolve a segurança sozinho

Published: 2025-06-18
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/mcp/
Tags: IA, Agentes, MCP

---

Um agente precisa consultar dados ou executar ações em outros sistemas. Sem uma
interface comum, cada integração exige um conector próprio, com formatos,
autenticação e tratamento de erros diferentes.

O Model Context Protocol (MCP) tenta padronizar parte desse caminho. Ele define
como uma aplicação pode descobrir recursos e ferramentas oferecidos por um
servidor e trocar mensagens com ele.

Essa definição precisa de um limite claro: **MCP é um protocolo de troca de
contexto. Ele não é o agente, não decide quando uma ação deve ser executada e não
torna uma integração segura por si só.** A própria
[visão geral da arquitetura](https://modelcontextprotocol.io/docs/learn/architecture)
afirma que o protocolo não determina como a aplicação usa o modelo nem como
administra o contexto recebido.

## Host, cliente e servidor têm responsabilidades diferentes

A arquitetura possui três participantes:

- **host MCP:** a aplicação de IA que coordena as conexões, apresenta as
  ferramentas ao modelo e aplica as regras do produto;
- **cliente MCP:** o componente criado pelo host para manter a comunicação com
  um servidor específico;
- **servidor MCP:** o programa que oferece dados ou operações por meio das
  primitivas do protocolo.

Um host pode manter vários clientes, normalmente um para cada servidor. Um
servidor pode executar na mesma máquina ou em um serviço remoto.

```text
Pessoa
  │
  ▼
Aplicação de IA — host MCP
  │
  ├── cliente MCP ── servidor de arquivos
  ├── cliente MCP ── servidor de observabilidade
  └── cliente MCP ── servidor de CRM
```

Essa separação importa porque o modelo não deveria receber acesso irrestrito ao
sistema operacional ou a uma API. O host escolhe quais servidores conectar,
quais primitivas expor ao modelo, quais chamadas permitir e quando solicitar
confirmação humana.

## O que um servidor pode oferecer

Na documentação vigente em agosto de 2026, as três primitivas centrais
oferecidas por servidores são:

- **tools:** funções executáveis, como consultar uma API, criar um registro ou
  operar um arquivo;
- **resources:** fontes de contexto, como o conteúdo de um documento, um esquema
  de banco de dados ou uma resposta de API;
- **prompts:** templates reutilizáveis para estruturar uma interação.

O cliente consegue descobrir quais primitivas estão disponíveis antes de
usá-las. Uma ferramenta declara nome, descrição e esquema de entrada; isso ajuda
o host a validar o formato e a apresentá-la ao modelo.

O esquema reduz ambiguidades de integração, mas não prova que a chamada é
correta. Uma requisição pode estar bem formada e ainda assim tentar excluir o
registro errado, consultar dados que a pessoa não deveria acessar ou repetir uma
operação não idempotente.

## O fluxo de uma chamada

Considere um pedido para reagendar uma reunião:

1. o host recebe a solicitação;
2. o modelo identifica que precisa consultar a agenda;
3. o host associa a intenção a uma ferramenta disponível;
4. o cliente envia a chamada ao servidor MCP;
5. o servidor valida os argumentos e executa a operação autorizada;
6. o resultado volta ao host e entra no contexto da conversa.

Uma política do produto pode interromper o fluxo antes do quinto passo e pedir
confirmação. Eu faria isso quando houver efeito externo relevante: enviar uma
mensagem, modificar uma agenda, mover dinheiro, excluir dados ou alterar uma
configuração de produção.

O protocolo organiza a descoberta e a chamada. A decisão sobre confirmação,
reversibilidade e impacto pertence à aplicação.

## MCP não significa apenas HTTP

O texto anterior dizia que a comunicação acontecia por JSON-RPC sobre HTTP. A
descrição estava incompleta.

A [especificação de transportes](https://modelcontextprotocol.io/specification/2026-07-28/basic/transports)
publicada em 28 de julho de 2026 define dois transportes padronizados:

- **stdio:** mensagens delimitadas por linha nos fluxos padrão de um processo
  iniciado pelo cliente, comum em servidores locais;
- **Streamable HTTP:** cada mensagem é enviada a um endpoint HTTP, com resposta
  em JSON ou em um fluxo SSE associado à requisição.

Transportes personalizados também são possíveis. JSON-RPC define a codificação
e a estrutura das mensagens; o transporte define como elas são entregues. Nem
JSON-RPC nem HTTP, isoladamente, são uma propriedade de segurança.

## Onde a segurança realmente entra

O post original chamava MCP de “ponte segura”. Essa formulação escondia decisões
que a implementação ainda precisa tomar.

A [especificação de autorização](https://modelcontextprotocol.io/specification/2026-07-28/basic/authorization)
define um fluxo baseado em padrões OAuth para transportes HTTP, mas a adoção de
autorização é opcional no protocolo. Para `stdio`, a própria especificação
orienta que credenciais sejam obtidas do ambiente, fora daquele fluxo OAuth.

Na prática, eu avaliaria pelo menos:

1. **Identidade:** qual pessoa, aplicação ou processo originou a solicitação?
2. **Autorização:** essa identidade pode executar esta ferramenta sobre este
   recurso?
3. **Escopo:** o token permite somente as operações necessárias?
4. **Validação:** o servidor confere esquema, valores e regras do domínio?
5. **Confirmação:** quais efeitos exigem decisão humana antes da execução?
6. **Auditoria:** entrada, identidade, ferramenta e resultado ficam registrados?
7. **Contenção:** existem limites de tempo, quantidade, custo e repetição?
8. **Recuperação:** a ação pode ser revertida ou compensada?

Para servidores remotos, também entram TLS, validação de origem, proteção de
tokens e restrições de rede. Para servidores locais, permissões do processo,
diretórios acessíveis e variáveis de ambiente delimitam o impacto possível. O
guia oficial de
[práticas de segurança](https://modelcontextprotocol.io/docs/2026-07-28/tutorials/security/security_best_practices)
detalha riscos como roubo de tokens, *confused deputy* e encaminhamento indevido
de credenciais.

## Quando eu usaria MCP

MCP tende a fazer sentido quando:

- a aplicação precisa conectar ferramentas de origens diferentes;
- mais de um host deve reutilizar as mesmas integrações;
- descoberta de capacidades em tempo de execução é útil;
- a equipe quer separar a interface oferecida ao agente da implementação do
  sistema externo.

Eu não adotaria o protocolo automaticamente para uma aplicação que chama uma
única API estável. Nesse caso, um cliente direto pode ser mais simples de testar,
operar e proteger. Adicionar um servidor MCP cria outro processo ou serviço,
mais uma fronteira de autorização e uma dependência de compatibilidade.

Também não transformaria todo endpoint existente em uma ferramenta. O conjunto
exposto ao agente deve ser menor do que a superfície total da API. Ferramentas
com propósito específico, argumentos restritos e efeitos claros são mais fáceis
de revisar do que uma operação genérica capaz de executar qualquer requisição.

## Uma decisão de arquitetura, não um selo

O ganho do MCP está em tornar descoberta, descrição e chamada de capacidades
mais interoperáveis. Ele reduz trabalho repetido de integração quando vários
clientes e servidores precisam colaborar.

O protocolo não elimina o restante da arquitetura. O host ainda precisa decidir
o que o modelo pode ver, que ações pode propor, quais chamadas são autorizadas e
como uma falha será contida.

Minha recomendação é começar com uma ferramenta de leitura, escopo limitado e
resultado verificável. Depois de observar autenticação, logs, erros e
comportamento do host, uma operação reversível pode ser adicionada. A autonomia
deve crescer depois dos controles, não antes deles.

> Nota de versão: este texto foi revisado em 7 de agosto de 2026 com base na
> documentação do protocolo `2026-07-28`. MCP continua evoluindo; antes de
> implementar, confira a versão suportada pelo host, pelo SDK e pelo servidor.
