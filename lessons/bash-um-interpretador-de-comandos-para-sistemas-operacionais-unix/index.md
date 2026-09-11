# Bash para automação de infraestrutura: fundamentos e limites

Published: 2023-05-16
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/lessons/bash-um-interpretador-de-comandos-para-sistemas-operacionais-unix/
Tags: Gists, Programação, Infraestrutura

---

Gist ID: `06e0ee5372a9253b93e532cdf34b742c`

Bash é uma boa escolha quando o trabalho consiste principalmente em combinar
comandos, arquivos, processos e redirecionamentos disponíveis no sistema. Ele
pode ser uma escolha ruim quando a lógica exige estruturas de dados complexas,
concorrência elaborada ou uma grande quantidade de regras de negócio.

Este material nasceu para aulas de programação aplicada a componentes de
infraestrutura. A revisão corrige algumas simplificações da versão original e
concentra o exemplo em um fluxo que pode ser executado e validado.

## Shell, terminal e Bash são coisas diferentes

O terminal é a interface que recebe entrada e mostra saída. O shell interpreta
comandos. Bash é uma implementação de shell e também uma linguagem de script.

Em uma sessão interativa, o Bash lê o comando, realiza expansões, configura
redirecionamentos e executa programas ou comandos internos. Em um script, as
mesmas regras continuam valendo, mas sem a intervenção constante da pessoa.

A documentação oficial o descreve como o shell do projeto GNU e uma linguagem
com variáveis, controle de fluxo, funções e mecanismos de expansão. A edição
atual do manual corresponde ao Bash 5.3; ambientes antigos podem ter
comportamentos ou recursos diferentes. ([GNU Bash Reference
Manual](https://www.gnu.org/software/bash/manual/bash.html))

Antes de depender de uma funcionalidade, verifique o ambiente:

```bash
bash --version
```

## Quando usar Bash

Bash tende a funcionar bem para:

- encadear ferramentas de sistema;
- preparar arquivos e diretórios;
- iniciar ou verificar processos;
- executar tarefas de build e implantação;
- automatizar rotinas pequenas de diagnóstico;
- criar uma camada fina em torno de CLIs existentes.

Eu consideraria outra linguagem quando o script começa a acumular parsing
complexo, modelos de dados, testes difíceis de isolar ou tratamento de erro
distribuído por muitos caminhos. Migrar não é uma punição por tamanho; é uma
decisão sobre o custo de continuar expressando o problema como comandos de
shell.

## Variável de shell não é automaticamente variável de ambiente

Uma atribuição sem espaços cria uma variável no shell atual:

```bash
project_dir="/srv/my app"
printf 'Diretório: %s\n' "$project_dir"
```

O processo filho só recebe a variável quando ela é exportada:

```bash
export LOG_LEVEL="info"
env | grep '^LOG_LEVEL='
```

Também é possível definir a variável apenas para um comando:

```bash
LOG_LEVEL="debug" ./start-service.sh
```

A distinção importa porque segredos, flags e configurações podem vazar para
processos filhos se forem exportados sem necessidade. A seção de ambiente do
manual explica como atribuições anteriores a um comando alteram o ambiente
daquela execução. ([ambiente de execução no manual do
Bash](https://www.gnu.org/software/bash/manual/html_node/Environment.html))

## Expansões precisam de aspas

Na maior parte dos usos, expanda variáveis como `"$variable"`. Sem aspas, o
resultado pode passar por separação em palavras e expansão de nomes de arquivos.
Um caminho com espaços deixa de ser um único argumento.

```bash
input_file="relatórios/maio 2026.csv"

# Um argumento:
wc -l -- "$input_file"
```

O `--` indica o fim das opções para comandos que oferecem essa convenção. Assim,
um nome iniciado por hífen não é interpretado como flag.

Para receber entrada sem tratar barras invertidas como escape, use `read -r`:

```bash
IFS= read -r line
printf '%s\n' "$line"
```

## Funções agrupam comportamento, mas compartilham o shell

Funções recebem parâmetros posicionais e podem declarar variáveis locais:

```bash
log_error() {
  local message=$1
  printf 'erro: %s\n' "$message" >&2
}
```

Sem `local`, uma atribuição dentro da função pode alterar uma variável do escopo
externo. O status do último comando executado também se torna o status da função,
a menos que `return` defina outro valor.

Eu usaria a saída padrão para dados que outro comando pode consumir e a saída de
erro para diagnósticos. Mensagens e códigos de saída previsíveis tornam o script
mais fácil de combinar e testar.

## `source` modifica a sessão atual

Executar `bash settings.sh` cria outro processo. Variáveis e funções definidas
ali deixam de existir quando o processo termina.

Já estes comandos executam o arquivo no shell atual:

```bash
source ./settings.sh
# Forma compatível com o shell Bourne:
. ./settings.sh
```

Isso é útil para carregar funções e configurações, mas também permite que o
arquivo altere diretório, opções, variáveis e funções da sessão. Faça `source`
apenas de conteúdo conhecido e controle caminhos explicitamente. No Bash,
`source` é um sinônimo de `.`. ([comandos internos do
Bash](https://www.gnu.org/software/bash/manual/html_node/Bash-Builtins.html))

## Permissão de execução não substitui autorização

Um arquivo pode ser passado diretamente ao Bash mesmo sem o bit de execução:

```bash
bash ./backup-directory.sh
```

Para executá-lo como programa:

```bash
chmod u+x ./backup-directory.sh
./backup-directory.sh /srv/app /var/backups/app
```

`chmod` controla bits de permissão; `chown` muda proprietário e `chgrp` muda
grupo. Tornar um script executável não garante que suas operações são seguras e
não impede que um usuário autorizado ao arquivo leia ou modifique o conteúdo.

## Exemplo: backup de um diretório

O script abaixo recebe origem e destino, valida os argumentos, cria o arquivo em
um nome temporário e só publica o nome final quando `tar` termina com sucesso.
Ele foi escrito para um ambiente GNU/Linux com Bash, `tar`, `date`, `realpath` e
`mktemp`. Outros sistemas Unix podem exigir ajustes nas ferramentas externas.

```bash
#!/usr/bin/env bash

set -u

usage() {
  printf 'Uso: %s DIRETORIO_ORIGEM DIRETORIO_DESTINO\n' "$0" >&2
}

if (( $# != 2 )); then
  usage
  exit 64
fi

source_dir=$1
destination_dir=$2

if [[ ! -d $source_dir ]]; then
  printf 'erro: origem não é um diretório: %s\n' "$source_dir" >&2
  exit 66
fi

if ! mkdir -p -- "$destination_dir"; then
  printf 'erro: não foi possível preparar o destino: %s\n' "$destination_dir" >&2
  exit 73
fi

if ! source_dir=$(realpath -- "$source_dir") ||
   ! destination_dir=$(realpath -- "$destination_dir"); then
  printf 'erro: não foi possível resolver os caminhos\n' >&2
  exit 66
fi

source_prefix=${source_dir%/}/
destination_prefix=${destination_dir%/}/

if [[ $destination_prefix == "$source_prefix"* ]]; then
  printf 'erro: o destino deve ficar fora da origem\n' >&2
  exit 64
fi

if ! timestamp=$(date -u +'%Y%m%dT%H%M%SZ'); then
  printf 'erro: não foi possível obter o horário atual\n' >&2
  exit 74
fi

source_name=${source_dir%/}
source_name=${source_name##*/}

if [[ -z $source_name ]]; then
  source_name=root
fi

archive_path="${destination_dir%/}/${source_name}-${timestamp}-$$.tar.gz"

if ! temporary_path=$(mktemp "${destination_dir%/}/.backup.XXXXXX"); then
  printf 'erro: não foi possível criar o arquivo temporário\n' >&2
  exit 73
fi

cleanup() {
  rm -f -- "$temporary_path"
}
trap cleanup EXIT

if ! tar -czf "$temporary_path" -C "$source_dir" .; then
  printf 'erro: falha ao criar o arquivo de backup\n' >&2
  exit 74
fi

if ! mv -- "$temporary_path" "$archive_path"; then
  printf 'erro: falha ao publicar o arquivo: %s\n' "$archive_path" >&2
  exit 74
fi

trap - EXIT
printf '%s\n' "$archive_path"
```

O arquivo temporário fica no destino para que a publicação final ocorra no
mesmo sistema de arquivos. O `trap` remove esse temporário se uma etapa falhar.
O sufixo com PID reduz colisões, mas não substitui uma política de retenção ou
uma trava quando várias execuções compartilham o destino.

O exemplo também não implementa criptografia, retenção, verificação do conteúdo
ou cópia para outro domínio de falha. Portanto, ele demonstra criação de um
arquivo; não constitui sozinho uma estratégia de backup.

## Valide sintaxe, comportamento e recuperação

O Bash consegue verificar a sintaxe sem executar o script:

```bash
bash -n ./backup-directory.sh
```

Depois, teste pelo menos:

- origem inexistente;
- destino sem permissão de escrita;
- caminhos contendo espaços;
- arquivo vazio e arquivo grande;
- conteúdo do `tar` produzido;
- interrupção antes da publicação final.

[ShellCheck](https://github.com/koalaman/shellcheck) identifica várias classes de
erro comuns em scripts de shell, mas não conhece todas as regras do seu ambiente
nem prova que o fluxo está correto. Use análise estática junto com testes em um
ambiente descartável.

Quando o script passar a exigir muitos estados, retentativas e formatos de dados,
registre esse aumento de complexidade. O próximo passo pode ser dividi-lo, trocar
a interface dos comandos ou mover a lógica para uma linguagem que represente
melhor o problema.
