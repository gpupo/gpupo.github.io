# Quando o shell-init do Lowfat colide com um alias de grep no Zsh

Published: 2026-08-13
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/lowfat-alias-grep-zsh/
Tags: Lowfat, Zsh, Shell, macOS, Agentes de IA

---

Em 7 de junho de 2026, eu estava testando uma forma de usar o Lowfat em todo o
meu ambiente de shell. A ideia era fazer comandos comuns passarem pelo programa
antes que suas saídas chegassem aos agentes de IA com os quais trabalho.

O [Lowfat](https://github.com/zdk/lowfat) é uma ferramenta de linha de comando
que filtra saídas como as de `git`, `docker`, `grep`, `find`, `ls` e `tree`. O
objetivo é reduzir o volume de texto enviado ao contexto de um agente. Eu já
conseguia chamá-lo diretamente:

```bash
lowfat git status
lowfat docker ps
lowfat grep termo arquivo.txt
```

O que eu experimentava naquele dia era a integração automática com o Zsh. O
comando documentado pelo projeto gera funções para os comandos suportados e
entrega o resultado ao `eval`:

```bash
eval "$(lowfat shell-init zsh)"
```

Coloquei essa inicialização no ambiente e abri uma nova sessão. Em vez dos
comandos interceptados, recebi isto:

```text
defining function based on alias `grep'
parse error near `()'
```

Já existia um alias chamado `grep` no meu Zsh. Naquele ambiente, o script
gerado tentou criar uma função com o mesmo nome e a inicialização parou no
conflito.

Não investiguei uma correção no código do Lowfat e não removi todos os aliases
para adaptar o shell ao inicializador. Eu queria continuar usando os filtros,
então troquei a forma de ativá-los.

Criei `~/work/gpupo-skills/scripts/lowfat-init.sh`. A primeira parte do arquivo
verifica se o binário existe e define uma função que o chama explicitamente:

```bash
if command -v lowfat >/dev/null 2>&1; then

  lowfat() {
    command lowfat "$@"
  }

fi
```

No mesmo arquivo, declarei os comandos que queria encaminhar:

```bash
alias ls='lowfat ls'
alias ll='lowfat ls'
alias tree='lowfat tree'

alias grep='lowfat grep'
alias find='lowfat find'
```

O `.zshrc` passou a carregar esse script. A lista deixou de ser descoberta pelo
`shell-init`: se eu quisesse incluir outro comando, teria de alterar o arquivo.
Foi a configuração que mantive.

Também considerei integrar o Lowfat por hooks específicos de cada agente. Isso
teria separado a configuração do Claude Code, do Codex e de outras ferramentas.
Naquele momento, eu queria que os mesmos comandos funcionassem no shell sem
depender de qual agente havia iniciado a sessão, então não segui por esse
caminho.

O episódio ficou registrado em uma ADR com o erro, as alternativas e a decisão.
Ela não registra medições de economia de tokens, diferenças de desempenho ou
uma comparação controlada entre as integrações. O teste tratou somente da
inicialização do meu Zsh e do conflito que apareceu ali.

Dois meses depois, a configuração continua em uso. Em 11 de agosto, o binário
instalado respondia como `lowfat 0.8.0`, e o script havia recebido mais dois
aliases:

```bash
alias git='lowfat git'
alias docker='lowfat docker'
```

A documentação atual do projeto ainda apresenta o `shell-init` com `eval` como
uma das opções, ao lado de hooks, plugins e uso direto. Meu resultado não mostra
que essa integração falha em qualquer instalação. Mostra apenas o que aconteceu
quando o script gerado encontrou um alias `grep` que já existia no meu Zsh.

Hoje o arquivo contém uma função, sete aliases e a verificação do binário. Abro
o shell, os comandos passam pelo Lowfat e o erro de parsing não reaparece. É o
estado que ficou depois daquele teste.
