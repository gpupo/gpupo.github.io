# Ctrl+s para sessões e Ctrl+g para ferramentas no tmux

Published: 2026-08-29
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/duas-tabelas-de-teclas-no-tmux/
Tags: tmux, Terminal, Atalhos, Configuração

---

Minha configuração do tmux tem dois prefixos próprios além de `Ctrl+b`:

```text
Ctrl+s → sessões
Ctrl+g → ferramentas
```

Depois de `Ctrl+s`, `f` procura uma sessão, `l` mostra a árvore, `k` encerra a
sessão atual e algumas letras aplicam layouts. Depois de `Ctrl+g`, `g` abre o
LazyGit, `n` abre o Neovim, `f` abre o Yazi e `?` mostra a ajuda.

Não são atalhos globais independentes como `Ctrl+Shift+Alt+alguma-coisa`. São
tabelas temporárias de teclas do próprio tmux.

## O vocabulário muda por uma tecla

A [documentação oficial do
tmux](https://github.com/tmux/tmux/wiki/Getting-Started) explica que cada
binding pertence a uma tabela nomeada. A tabela `root` recebe teclas sem
prefixo; `prefix` recebe as teclas depois do prefixo padrão; outras tabelas
podem ser criadas para modos específicos.

A entrada do meu modo de sessões é:

```tmux
bind -n C-s \
  display-message "SESSIONS" \; \
  switch-client -T session-key-table
```

Os comandos seguintes pertencem a `session-key-table`:

```tmux
bind -T session-key-table f display-popup -E -w 80% -h 80% \
  "tms 2>/dev/null || $HOME/.config/tmux/bin/sessionize"

bind -T session-key-table l choose-tree -Zs
bind -T session-key-table k run-shell "$HOME/.config/tmux/bin/kill-session"
```

O modo de ferramentas repete a estrutura com `tools-key-table`. A primeira
tecla escolhe o domínio; a segunda escolhe a ação.

## Uma tecla pode conservar seu significado original

`Ctrl+s` e `Ctrl+g` já podem ter significado para o programa dentro do painel.
Por isso, pressionar a mesma combinação duas vezes envia a tecla para a
aplicação:

```tmux
bind -T session-key-table C-s send-keys C-s
bind -T tools-key-table   C-g send-keys C-g
```

É um escape explícito. Ainda assim, ele muda o hábito: para entregar `Ctrl+s`
ao programa, preciso digitar `Ctrl+s Ctrl+s` quando o tmux intercepta a primeira
ocorrência.

Há outra borda histórica. Em alguns terminais, `Ctrl+s` participa do controle
de fluxo XON/XOFF e pode pausar a saída antes de o tmux recebê-lo. A
configuração não documenta uma defesa para todos os ambientes. O atalho só é
portátil quando terminal, shell e tmux entregam a sequência como esperado.

## Ferramentas ganham janelas reutilizáveis

O modo `Ctrl+g` chama um script com nome da janela, comando e diretório do painel
atual:

```tmux
tool-window.sh LazyGit lazygit "#{pane_current_path}"
tool-window.sh Nvim    nvim    "#{pane_current_path}"
tool-window.sh Yazi    yazi    "#{pane_current_path}"
```

O script procura uma janela com aquele nome na sessão. Se encontrar, seleciona;
se não, cria no diretório recebido. Assim, repetir `Ctrl+g g` tende a voltar ao
LazyGit já aberto, em vez de criar outra instância.

Essa identidade pelo nome tem uma consequência. Uma sessão só comporta uma
janela chamada `LazyGit` sob esse contrato, mesmo que eu queira ferramentas em
dois diretórios diferentes. O agrupamento favorece reuso, não multiplicidade.

## O custo é adicionar estado

Duas tabelas reduzem a quantidade de combinações que preciso memorizar, mas a
próxima tecla passa a depender da anterior. `f` pode ser texto no shell,
sessionizer depois de `Ctrl+s` ou Yazi depois de `Ctrl+g`.

A configuração mostra “SESSIONS” ou “TOOLS” na linha de mensagem por dois
segundos ao entrar em cada tabela. Há também um arquivo de ajuda acessível pelo
próprio modo de ferramentas. Essas pistas são importantes porque o agrupamento
não remove complexidade; ele a organiza em estados temporários.

Não medi erros ou velocidade antes e depois dessa mudança. O que posso afirmar
é que a configuração expressa duas categorias estáveis e evita ocupar uma
combinação global para cada ação. O desenho faz sentido enquanto as categorias
continuarem pequenas e distintas.

Se começarem a surgir submodos, exceções e teclas com três significados, o
ganho se perde. Nesse ponto eu preferiria retirar ações pouco usadas ou deixá-las
na paleta de comandos do tmux. Uma tabela de teclas é útil como vocabulário
curto; vira um idioma particular quando tenta abrigar tudo.
