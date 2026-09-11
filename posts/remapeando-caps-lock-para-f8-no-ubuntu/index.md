# Remapeando o Caps Lock para F8 no Ubuntu com keyd

Published: 2026-08-03
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/remapeando-caps-lock-para-f8-no-ubuntu/
Tags: Ubuntu, Linux, Wayland, keyd, Produtividade

---

O Caps Lock já não tinha uma função relevante no meu fluxo de trabalho e ainda
era acionado acidentalmente de vez em quando. A tecla **F8**, por outro lado,
é útil com bastante frequência. A solução foi simples: fazer com que qualquer
pressionamento físico do Caps Lock seja interpretado pelo sistema como F8.

Este post registra a configuração que apliquei e validei em um **Dell Inspiron
15 3535**, com **Ubuntu 26.04**, **GNOME**, **Wayland** e o pacote
[`keyd`](https://github.com/rvaiya/keyd) `2.5.0-5`.

## Por que usar o keyd?

O remapeamento precisa funcionar em todo o sistema, e não apenas em uma
aplicação ou dentro da sessão gráfica. O `keyd` opera no nível dos dispositivos
de entrada, antes do GNOME, do Wayland e das aplicações. Por isso, a mesma regra
é aplicada em terminais, navegadores, aplicações gráficas e outras sessões.

Soluções tradicionais como o `xmodmap` dependem do X11 e não são adequadas para
uma sessão moderna baseada em Wayland. O GNOME Tweaks e o `gsettings` permitem
desativar ou alterar alguns comportamentos predefinidos do Caps Lock, mas não
oferecem o remapeamento arbitrário para F8 de forma tão direta.

## Instalando o keyd

No Ubuntu, a instalação é feita pelo gerenciador de pacotes:

```bash
sudo apt update
sudo apt install keyd
```

## Criando o remapeamento

O arquivo de configuração usado pelo serviço é
`/etc/keyd/default.conf`:

```bash
sudoedit /etc/keyd/default.conf
```

Seu conteúdo é:

```ini
[ids]
*

[main]
capslock = f8
```

O identificador `*` faz com que a configuração seja aplicada a todos os
teclados reconhecidos pelo serviço. Assim, a regra não fica limitada ao teclado
interno do notebook: ela também vale para teclados externos conectados ao
computador.

## Ativando o serviço

Para habilitar o serviço no boot e iniciá-lo imediatamente:

```bash
sudo systemctl enable --now keyd
```

Há uma particularidade na versão empacotada pelo Ubuntu. O serviço continua
sendo chamado `keyd.service`, mas o executável administrativo é instalado como
`keyd.rvaiya`, e não simplesmente `keyd` como aparece em parte da documentação
do projeto upstream.

Depois de alterar o arquivo, recarrego a configuração com:

```bash
sudo keyd.rvaiya reload
```

## Validando o resultado

O estado do serviço pode ser consultado com:

```bash
systemctl is-active keyd
```

O resultado esperado é:

```text
active
```

Em seguida, basta pressionar a tecla física Caps Lock em uma aplicação que use
F8. No meu caso, o evento produzido passou a ser o da tecla F8, tanto em
aplicações gráficas quanto no terminal.

Quando é necessário investigar o evento de entrada em detalhes, o `keyd` oferece
um monitor:

```bash
sudo keyd.rvaiya monitor
```

Os logs do serviço ficam disponíveis no journal do systemd:

```bash
sudo journalctl -u keyd -n 30 --no-pager
```

## Alternativas consideradas

### `xmodmap`

Não adotei o `xmodmap` porque ele depende do X11. Em uma sessão Wayland, o
remapeamento pode não funcionar ou ficar restrito a componentes específicos.

### GNOME Tweaks e `gsettings`

Essas opções são úteis para desativar o Caps Lock ou modificar comportamentos
predefinidos, mas não são a alternativa mais direta para converter a tecla em
F8.

### Input Remapper

O Input Remapper tem interface gráfica e suporte a Wayland. Ainda assim, para
uma única regra permanente, ele adiciona mais componentes e configuração do que
o necessário. O arquivo declarativo do `keyd` resolve o caso com poucas linhas.

## O que muda no uso diário?

O resultado é uma pequena alteração, mas com efeito global:

- o Caps Lock original deixa de estar disponível;
- qualquer teclado conectado é afetado pela regra;
- o serviço inicia automaticamente durante o boot;
- o remapeamento funciona em Wayland e fora da sessão gráfica;
- a configuração permanece pequena, declarativa e versionável;
- não há dependência de extensões do GNOME ou de scripts de login.

Essa abrangência é justamente a principal vantagem do `keyd`, mas também exige
atenção: se outro teclado precisar manter o comportamento original do Caps
Lock, o identificador `*` deverá ser substituído por regras específicas para os
dispositivos desejados.

## Revertendo a alteração

Para desativar temporariamente o remapeamento e impedir que o serviço inicie
automaticamente:

```bash
sudo systemctl disable --now keyd
```

Para remover apenas a configuração e reiniciar o serviço:

```bash
sudo rm -f /etc/keyd/default.conf
sudo systemctl restart keyd
```

Para remover completamente o pacote:

```bash
sudo systemctl disable --now keyd
sudo apt remove keyd
```

## Resultado

O `keyd` resolveu o problema sem depender do servidor gráfico. Depois da
ativação, a tecla física **Caps Lock** passou a produzir permanentemente o
evento correspondente à tecla **F8** no Ubuntu.

Para esse tipo de ajuste, uma configuração pequena no nível correto da pilha de
entrada acaba sendo mais confiável do que uma solução acoplada ao ambiente de
desktop. E, neste caso, também transformou uma tecla quase inútil em um atalho
que realmente uso.
