# Por que ainda uso Thunderbird em 2026 — e por que o instalei sem Snap

Published: 2026-08-12
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/thunderbird-sem-snap-ubuntu-2026/
Tags: Thunderbird, Ubuntu, Linux, E-mail, Software Livre

---

Quando publiquei a captura do e-mail do Marvin sobre um upgrade do meu
homelab, meu amigo Eduardo não comentou o Langfuse, o Nomad ou o backup
restaurado. Ele reparou no programa em que a mensagem estava aberta e me
perguntou, com ironia, por que eu ainda estava usando Thunderbird em 2026.

Para ele, um cliente de e-mail instalado no computador já estava fora do dia a
dia. Para mim, a pergunta produziu uma lembrança imediata: em 1999, eu ajudava
pessoas a configurar contas no Outlook Express. Servidor de entrada, servidor
de saída, nome de usuário, senha e, quando alguma coisa não funcionava, a
certeza de que o problema podia estar em qualquer uma dessas etapas.

![E-mail do Marvin aberto no Thunderbird](/assets/images/langfuse-upgrade-4-4-0-email.png){: .rounded }

Foi essa captura que chamou a atenção do Eduardo. A interface pode sugerir um
hábito antigo, mas o meu uso é atual: hoje mantenho **cinco contas de e-mail**
no Thunderbird, incluindo uma ligada ao homelab. Elas funcionam bem e ficam no
mesmo ambiente, sem me obrigar a tratar cada provedor como um aplicativo ou uma
aba diferente.

O que mudou desde 1999 não foi apenas o programa. Naquela época, configurar um
cliente era quase uma condição para usar e-mail. Em 2026, é uma escolha. Eu
continuo fazendo essa escolha porque ela resolve melhor o conjunto de contas
que realmente tenho.

## Um cliente de e-mail parece antigo até aparecer a quinta conta

Para quem trabalha com uma única conta dentro de um ecossistema bem integrado,
o webmail pode ser suficiente. Essa é uma situação diferente da minha.

As cinco contas representam contextos distintos. A conta do homelab, por
exemplo, recebe comunicações operacionais como o relatório do Marvin. Outras
contas atendem relações pessoais e profissionais. O Thunderbird não elimina
essa separação, mas permite atravessá-la sem trocar de aplicação, sessão ou
modelo de navegação.

Esse benefício é uma observação do meu fluxo, não uma conclusão universal
sobre produtividade. Eu não medi quantos minutos economizo nem comparei meu
uso com cinco webmails abertos. O que consigo afirmar é mais limitado: as
cinco contas estão configuradas, são usadas no cotidiano e não me dão um motivo
prático para abandonar o cliente.

Há também uma inversão curiosa na pergunta do Eduardo. O Thunderbird parece
fora de época porque mantém visível a ideia de que e-mail é um protocolo que
pode ser acessado por um cliente escolhido pelo usuário. Muitos serviços atuais
tentam fazer o aplicativo parecer inseparável da conta. No meu caso, a
possibilidade de reunir provedores diferentes continua sendo uma vantagem.

## “Sem Snap” é uma decisão de instalação, não uma cruzada

Meu Ubuntu oferece o Thunderbird pelo caminho do Snap. Mais precisamente, no
Ubuntu 26.04 o pacote `thunderbird` disponível pelo APT é um pacote de transição
que instala o Snap, como mostra o
[catálogo oficial de pacotes do Ubuntu](https://packages.ubuntu.com/search?keywords=thunderbird&searchon=names&suite=resolute).

Eu queria outra fronteira para essa instalação:

- usar a versão oficial do Thunderbird;
- manter os arquivos do aplicativo dentro do meu diretório de usuário;
- não adicionar uma instalação global em `/opt` ou `/usr`;
- não introduzir outro formato de pacote nesse caso;
- usar a interface em inglês americano;
- conseguir remover ou substituir o programa sem alterar pacotes do sistema.

Esses requisitos me levaram ao arquivo oficial distribuído pela Mozilla e a
uma instalação local em `~/.local`. Não cheguei a essa escolha por ter
demonstrado que o Snap é mais lento, inseguro ou inadequado. Eu não executei
esses testes e não faço essas afirmações.

A própria Mozilla documenta mais de um caminho para Linux. Em Debian e Ubuntu,
a recomendação atual é usar o repositório DEB mantido pela Mozilla. A
documentação também descreve a instalação manual dentro da conta do usuário,
inclusive para quem prefere manter o programa fora dos diretórios globais. Essa
segunda alternativa corresponde melhor aos limites que estabeleci para esta
máquina. As opções e os procedimentos atuais estão no guia oficial
[Install Thunderbird on Linux](https://support.mozilla.org/en-US/kb/installing-thunderbird-linux).

As alternativas não são equivalentes; cada uma transfere responsabilidades
para um lugar diferente:

| Método | O que simplifica | O que exige de mim |
| --- | --- | --- |
| Snap do Ubuntu | integração e atualização pelo ecossistema Snap | aceitar o runtime e o modelo de empacotamento Snap |
| Repositório DEB da Mozilla | instalação e atualização pelo APT | adicionar e confiar em um repositório externo ao Ubuntu |
| Flatpak | distribuição independente da versão do Ubuntu | manter também o runtime e as permissões do Flatpak |
| Arquivo oficial no usuário | controle do local, canal e idioma | integrar o aplicativo e acompanhar suas atualizações |

Para a maioria das pessoas, uma opção gerenciada pelo sistema de pacotes tende
a exigir menos manutenção. A instalação local não é um atalho para fugir de
responsabilidade; ela desloca essa responsabilidade para mim.

## A instalação que uso

Registrei essa decisão em 29 de julho de 2026. O programa fica em:

```text
~/.local/opt/thunderbird
```

O comando disponível no meu `PATH` é um link simbólico:

```text
~/.local/bin/thunderbird
  → ~/.local/opt/thunderbird/thunderbird
```

Antes da instalação, fechei o Thunderbird. Para repetir o procedimento, é
prudente manter também um backup atual do perfil: os comandos abaixo substituem
o aplicativo, não protegem os dados das contas. Em seguida, baixei a versão
Linux de 64 bits, em inglês americano, pelo redirecionador oficial da Mozilla:

```bash
download_dir="$(mktemp -d)"
thunderbird_archive="$download_dir/thunderbird.tar.xz"

curl --fail --location \
  "https://download.mozilla.org/?product=thunderbird-latest-SSL&os=linux64&lang=en-US" \
  --output "$thunderbird_archive"

tar --extract \
  --file "$thunderbird_archive" \
  --directory "$download_dir"

mkdir -p \
  "$HOME/.local/opt" \
  "$HOME/.local/bin" \
  "$HOME/.local/share/applications"
```

Como já havia uma instalação no destino, movi o diretório anterior em vez de
apagá-lo imediatamente. O sufixo com data permite confirmar a nova versão antes
de descartar a anterior:

```bash
previous_install="$HOME/.local/opt/thunderbird.previous-$(date +%Y%m%d-%H%M%S)"

if [ -e "$HOME/.local/opt/thunderbird" ]; then
  mv "$HOME/.local/opt/thunderbird" "$previous_install"
fi

mv "$download_dir/thunderbird" "$HOME/.local/opt/thunderbird"

ln -sfn \
  "$HOME/.local/opt/thunderbird/thunderbird" \
  "$HOME/.local/bin/thunderbird"
```

Essa precaução protege apenas os arquivos da instalação anterior. Ela não
substitui um backup do perfil.

## Integrando ao desktop

Uma pasta extraída não cria sozinha a integração esperada no GNOME. Para que o
Thunderbird apareça no menu e possa tratar links `mailto:`, criei
`~/.local/share/applications/thunderbird-local.desktop`:

```bash
cat > "$HOME/.local/share/applications/thunderbird-local.desktop" <<EOF
[Desktop Entry]
Name=Thunderbird
Comment=Email and calendar client
Exec=$HOME/.local/opt/thunderbird/thunderbird %u
Icon=$HOME/.local/opt/thunderbird/chrome/icons/default/default128.png
Terminal=false
Type=Application
Categories=Network;Email;
MimeType=x-scheme-handler/mailto;
StartupNotify=true
StartupWMClass=thunderbird
EOF

update-desktop-database \
  "$HOME/.local/share/applications" 2>/dev/null || true
```

Depois disso, confirmei o lançamento pelo menu do sistema e o funcionamento das
cinco contas. O resultado observado foi uma instalação restrita ao usuário,
com a versão oficial e a interface `en-US`, sem depender do Snap.

Na revisão deste artigo, em 10 de agosto de 2026, o arquivo `application.ini`
da instalação registrava o Thunderbird `153.0.1`, com build
`20260728090639`. Esses números identificam o resultado observado; não são uma
recomendação para fixar essa versão depois que houver uma atualização.

## Programa e perfil não são a mesma coisa

O Thunderbird mantém os dados do usuário em um perfil separado dos arquivos do
aplicativo. A Mozilla usa essa separação também em seu procedimento para mover
dados entre computadores: o programa pode ser reinstalado enquanto mensagens,
configurações e outros dados permanecem no diretório do perfil. O procedimento
e suas condições estão documentados em
[Move Thunderbird data to a new computer](https://support.mozilla.org/en-US/kb/moving-thunderbird-data-to-a-new-computer).

Essa arquitetura torna a instalação em `~/.local/opt` mais simples de substituir,
mas não torna os dados invulneráveis. Uma mudança de versão pode converter
estruturas do perfil, extensões podem perder compatibilidade e um erro de cópia
continua sendo um erro de cópia. Antes de trocar de canal, migrar a instalação
ou fazer uma atualização importante, o perfil ainda precisa de backup.

## E as atualizações?

Esse é o principal custo da minha escolha. O Ubuntu não gerencia essa cópia e
um `apt upgrade` não a substitui.

Segundo a documentação do Thunderbird, instalações manuais verificam
atualizações por padrão e podem aplicá-las pelo próprio programa. A recomendação
do projeto é manter esse mecanismo habilitado para receber correções de
segurança. A configuração fica em **Settings → General → Thunderbird Updates**,
como descreve o guia
[Managing Thunderbird Updates](https://support.mozilla.org/en-US/kb/managing-thunderbird-updates).

Se a atualização interna falhar, o procedimento de contingência é baixar uma
nova cópia e substituir o diretório do aplicativo, preservando uma versão
anterior até a validação. Esse caminho é mais trabalhoso do que deixar tudo a
cargo de um gerenciador de pacotes. Aceitei esse custo quando escolhi manter a
instalação dentro da minha conta.

## O que esta experiência não demonstra

O resultado foi positivo para o meu ambiente, mas tem limites claros:

- não comparei tempo de inicialização entre Snap, DEB, Flatpak e arquivo local;
- não medi consumo de memória ou espaço de cada alternativa;
- não fiz uma auditoria de segurança dos formatos de distribuição;
- não testei a configuração para múltiplos usuários da mesma máquina;
- não concluo que uma instalação manual seja melhor para quem quer o menor
  trabalho possível de manutenção.

O que a experiência demonstra é mais específico: consigo usar cinco contas no
Thunderbird e manter uma instalação oficial, local e reversível sem o Snap. É o
resultado que eu precisava, dentro das condições que escolhi.

## De Outlook Express ao e-mail do Marvin

Em 1999, ajudar alguém com Outlook Express significava tornar o e-mail
acessível em um computador. Em 2026, ninguém precisa instalar o Thunderbird
para abrir uma caixa de entrada. Webmail e aplicativos móveis resolveram isso
há muito tempo.

Ainda assim, ter opções continua valioso. Eduardo estranhou o Thunderbird
porque ele já não faz parte do cotidiano dele. Eu continuo usando porque faz
parte do meu: são cinco contas, provedores e contextos diferentes reunidos em
um cliente que funciona bem.

A captura do e-mail do Marvin acabou mostrando duas histórias. A mais óbvia era
sobre como opero meu homelab. A outra estava na moldura da mensagem: depois de
mais de duas décadas, ainda prefiro que minhas contas de e-mail se adaptem ao
cliente que escolhi, e não o contrário.
