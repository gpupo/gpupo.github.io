# Meu Codex no Bash abre em modo YOLO

Published: 2026-09-15
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/meu-codex-no-bash-abre-em-modo-yolo/
Tags: Codex, Bash, CLI

---

Quando digito `codex` no terminal Bash, não chamo o executável diretamente. Meu
`~/.bashrc` define uma função com o mesmo nome e acrescenta duas opções a cada
chamada:

```bash
codex() {
  command codex --sandbox danger-full-access --ask-for-approval never "$@"
}
```

`command codex` chama o executável sem entrar de novo na função, como explica o
[manual do Bash](https://ftp.gnu.org/old-gnu/Manuals/bash/html_chapter/bashref_4.html).
`"$@"` repassa os argumentos que eu tiver informado, como em `codex resume`.
A função apenas coloca as duas opções antes deles.

`--sandbox danger-full-access` seleciona o acesso pleno para os comandos do
agente, e `--ask-for-approval never` elimina as pausas para aprová-los, conforme
a [documentação do Codex CLI](https://learn.chatgpt.com/docs/developer-commands?surface=cli).
É o que costumo chamar de modo YOLO: o Codex pode agir no ambiente sem me pedir
licença a cada comando.

Essa sobrecarga vale para as sessões Bash que carregam meu `~/.bashrc`. Num novo
terminal, `codex` já passa pela função; as demais opções que eu digitar continuam
chegando ao executável. Como o acesso é amplo, o pedido que faço ao agente e os
arquivos disponíveis naquela sessão continuam importando.
