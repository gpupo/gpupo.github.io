# Uma ferramenta menor que a conta

Published: 2026-09-20
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/uma-ferramenta-menor-que-a-conta/
Tags: Agentes de IA, Thunderbird, CLI, SQLite, Automação, Privacidade

---

## O que tenho amanhã?

Eu queria poder fazer essa pergunta ao meu agente. Também queria perguntar
quais reuniões estavam na minha agenda em determinado mês. O calendário já
estava sincronizado no Thunderbird, mas o agente não tinha uma forma confiável
de consultá-lo.

Dar acesso direto à minha conta Google resolveria a pergunta e criaria outra
integração para manter, com credenciais e permissões além do necessário. Era
uma solução desproporcional: entregar uma conta inteira para responder a uma
consulta temporal.

Escolhi uma operação menor. Transformei o cache local do Thunderbird numa
ferramenta de linha de comando. O agente informa um intervalo; o comando
devolve eventos normalizados em JSON. O Thunderbird continua responsável pela
sincronização.

```text
Google Calendar
      ↕
 Thunderbird
      ↓
 cache local
      ↓
 tb-calendar
      ↓
    JSON
      ↓
   agente
```

O agente não precisava necessariamente de uma integração com o sistema.
Precisava de uma operação suficientemente estreita para responder à pergunta.

## O cache era a API que eu precisava

O calendário já chegava ao Thunderbird por CalDAV. Eu não precisava reproduzir
essa sincronização, administrar OAuth ou fazer o agente conhecer a conta
remota. Precisava encontrar no computador uma representação que já estivesse
disponível.

O primeiro candidato foi `local.sqlite`. Parecia o lugar óbvio para começar.
Antes de escrever o parser, consultei o schema e contei os registros por
calendário. O banco tinha as tabelas esperadas, mas nenhum evento. Os dados do
calendário sincronizado estavam em outro arquivo: `cache.sqlite`.

Essa contagem evitou que eu construísse a ferramenta sobre uma suposição. O
nome do arquivo e a presença das tabelas não eram evidência de que os eventos
estavam ali.

## O WAL fazia parte da agenda

O segundo problema apareceu quando comparei duas leituras. O arquivo principal
de `cache.sqlite` mostrava 511 eventos do calendário escolhido. A leitura que
incluía o WAL mostrava 579. Parte do estado mais recente estava no
*write-ahead log*, separado do arquivo principal.

Consultar apenas o SQLite principal deixaria 68 registros de fora. Com o
Thunderbird aberto, porém, a conexão usual em modo somente leitura retornava
`database is locked`. Uma abertura com `immutable=1` lia o arquivo principal,
mas não refletia os dados do WAL.

A solução foi copiar `cache.sqlite` e seu WAL como arquivos comuns para um
diretório temporário privado. O `tb-calendar` confere se as origens mudaram
durante a cópia e tenta novamente quando isso acontece. Depois abre a cópia com
SQLite em `mode=ro` e `query_only=ON`. O diretório temporário desaparece ao fim
da consulta; o banco original não recebe comandos SQL.

Ler as linhas também não bastava. O cache armazenava horários e timezones
separadamente, representava eventos de dia inteiro de forma própria e
distribuía recorrências, exclusões e ocorrências alteradas por estruturas
diferentes. O CLI precisou reconstruir uma agenda, não apenas executar um
`SELECT`.

Usei Python e `python-dateutil` para fazer essa tradução. Testei uma série
semanal, uma data excluída, uma ocorrência movida e um evento de dia inteiro.
Num intervalo amplo do cache real, as 36 exceções existentes apareceram uma
vez cada. Os testes automatizados usam dados fictícios e também verificam WAL,
somente leitura e janelas livres.

## Da agenda para uma interface de agente

O resultado é um comando com consultas para hoje, amanhã, semana, intervalos
arbitrários e horários livres. Para agosto de 2026, por exemplo, o agente pode
executar:

```bash
tb-calendar query \
  --from 2026-08-01T00:00:00-03:00 \
  --to 2026-09-01T00:00:00-03:00 \
  --json
```

O fim do intervalo é exclusivo. A saída apresenta os horários em
`America/Sao_Paulo` e contém campos como `title`, `start`, `end`, `all_day`,
`location`, `busy` e `recurrence_id`. Descrição, convidados, credenciais e
propriedades internas não fazem parte da resposta.

Um trecho simplificado, com dados fictícios, fica assim:

```json
{
  "events": [{
    "title": "Reunião de planejamento",
    "start": "2026-08-11T10:00:00-03:00",
    "end": "2026-08-11T10:30:00-03:00",
    "all_day": false,
    "location": null
  }]
}
```

Esta é a interface do agente. Não o SQLite, não o Thunderbird e não a conta
Google.

## O que a ferramenta pode — e não pode — afirmar

Depois usei a mesma interface para produzir retrospectivas mensais no
[meu vault do Obsidian](/posts/como-eu-lido-com-minhas-notas-pessoais-em-2026q3/).
Em junho, por exemplo, 36 registros permitiram detectar uma duplicação
aparente, dois compromissos no mesmo horário e títulos genéricos demais para
recuperar o assunto apenas pelo calendário.

Essa experiência expôs um limite que não pertence ao parser. O calendário
registra intenção de tempo, não presença ou realização. Um espaço vazio não
prova descanso. Um evento não prova comparecimento. A ferramenta torna a fonte
consultável; o agente ainda precisa interpretar o que ela pode sustentar.

O `tb-calendar` consulta apenas um calendário autorizado e somente o que o
Thunderbird já sincronizou para o cache local. Se a sincronização estiver
atrasada, a resposta também estará. A ferramenta não cria, edita ou exclui
eventos. Timezones personalizados e recorrências de dia inteiro ainda precisam
de mais exemplos reais para validação.

## Exponha a operação, não o sistema

O CLI funciona para mim e para o agente. Posso executar
`tb-calendar tomorrow` no terminal; um assistente pode chamar o mesmo comando
com `--json`. Um `AGENTS.md` registra o caminho do executável, um exemplo de
intervalo e a instrução de usar a ferramenta em vez de abrir o perfil do
Thunderbird.

Não precisei criar um servidor, um daemon ou um servidor MCP. Para um agente na
mesma máquina, parâmetros previsíveis e JSON estável foram suficientes. O
calendário é apenas um caso de um padrão que posso repetir com outras fontes.

Se consigo consultar legitimamente uma informação por uma API, um banco local,
um arquivo ou um comando, provavelmente consigo construir uma ferramenta para
o assistente fazer uma consulta equivalente. Isso depende das permissões, do
formato e da possibilidade de automatizar o acesso sem contornar controles.
Ter acesso não significa automaticamente ter autorização para delegá-lo.

Antes de oferecer uma nova ferramenta a um agente, eu verificaria:

1. Tenho autorização para delegar esse acesso?
2. Qual é a menor operação capaz de responder à pergunta?
3. Ela pode ser somente de leitura?
4. Quais dados podem ficar fora da resposta?
5. Como a ferramenta informa origem, intervalo e limitações?
6. Consigo testar a saída sem alterar a fonte?

```text
sistema inteiro  ✗

operação autorizada
       ↓
  dados mínimos
       ↓
interface estável
       ↓
     agente
```

O Thunderbird cuida da sincronização.
A ferramenta cuida da tradução.
O agente cuida da pergunta.
