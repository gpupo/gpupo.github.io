# Publicando apps Python no Nomad sem Docker

Published: 2026-08-05
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/publicando-apps-python-no-nomad-sem-docker/
Tags: Python, Nomad, DevOps, Deploy, Homelab

---

Docker resolve muitos problemas. Em um ambiente pequeno, também pode introduzir
problemas que ainda não existem: construir imagens, operar um registry, manter
camadas, distribuir artefatos e descobrir onde uma versão está rodando.

Eu tinha poucas aplicações Python internas para publicar em um homelab com
Nomad, Consul e Traefik. Elas precisavam de uma API, uma URL, TLS, *health
checks* e um caminho previsível para voltar ao ar depois de um `git push`.
Não precisavam de portabilidade entre provedores nem de dezenas de réplicas.

Para esse contexto, minha decisão foi executar o Python diretamente pelo driver
`raw_exec` do Nomad. O ambiente da aplicação fica isolado em `.venv`, criado pelo
`uv`, e o processo de publicação segue este fluxo:

```text
git push
  → Forgejo Actions
  → SSH no host de deploy
  → git pull
  → uv sync
  → nomad job plan
  → nomad job run
  → nomad job restart
  → Consul valida a saúde
  → Traefik passa a rotear
```

Neste ambiente, o caminho completo costuma levar entre 15 e 20 segundos. Esse
número descreve uma aplicação pequena, uma rede local e uma única réplica. Não é
uma promessa de latência para qualquer pipeline.

## O problema não era executar Python

Subir um FastAPI com `uvicorn` é simples. O trabalho começa quando o serviço
precisa continuar operável depois da primeira demonstração.

Eu precisava responder a perguntas básicas:

- Onde ficam os dados que sobrevivem a um deploy?
- Qual usuário pode alterar um job no Nomad?
- Como o proxy descobre a porta da nova instância?
- Como uma alocação deixa de receber tráfego quando a aplicação falha?
- Como garantir que o processo em execução recebeu o código novo?

Uma imagem de container é uma resposta comum para parte dessas questões. Neste
caso, ela criaria outro ciclo operacional: construir, versionar, enviar para um
registry e baixar a imagem no nó escolhido pelo scheduler. Isso é adequado quando
há muitos serviços, múltiplos ambientes ou uma necessidade forte de portabilidade.
Para uma coleção pequena de aplicações internas, eu preferi manter o artefato
implantável como um repositório Git e uma *virtual environment* reproduzível.

## Três fronteiras deixam o deploy mais fácil de operar

Minha organização separa código, dados e identidade operacional.

```text
/home/appuser/minha-aplicacao/
├── current/  ← repositório Git, código, especificações e scripts
└── data/     ← uploads, SQLite, logs e outros dados persistentes
```

`current/` é descartável. Se o diretório for perdido, posso recriá-lo com um
`git clone` e `uv sync`. `data/` não participa desse descarte; precisa de backup,
permissões próprias e uma decisão explícita sobre recuperação.

Essa distinção evita um erro comum em deploys simples: tratar o diretório inteiro
da aplicação como se tivesse o mesmo ciclo de vida. Código deve poder ser
substituído. Dados precisam sobreviver à substituição.

O segundo limite é a identidade. O pipeline usa um usuário dedicado ao deploy,
não uma conta pessoal e nem `root`. No meu caso, esse usuário consegue consultar
o cluster e executar apenas as operações necessárias para planejar, aplicar e
reiniciar jobs.

Essa não é uma fronteira de segurança completa. Em uma infraestrutura mais
sensível, eu substituiria permissões amplas de `sudo` por ACLs do Nomad, policies
por namespace e um gerenciador de segredos. Ainda assim, limitar a conta do
pipeline já reduz bastante o risco de transformar uma chave de CI em acesso
administrativo irrestrito ao host.

## O que o Nomad precisa saber

O job descreve o processo, a porta, os recursos e a forma de verificar se a
aplicação está saudável. Um recorte suficiente para uma API pequena é este:

```hcl
job "minha-aplicacao" {
  datacenters = ["homelab"]
  type        = "service"

  group "api" {
    network {
      port "http" {}
    }

    service {
      name = "minha-aplicacao"
      port = "http"

      check {
        type     = "http"
        path     = "/health"
        interval = "30s"
        timeout  = "3s"
      }
    }

    task "api" {
      driver = "raw_exec"
      user   = "appuser"

      config {
        command = "/home/appuser/minha-aplicacao/current/.venv/bin/uvicorn"
        args = [
          "app.main:app",
          "--app-dir", "/home/appuser/minha-aplicacao/current",
          "--host", "0.0.0.0",
          "--port", "${NOMAD_PORT_http}",
        ]
      }

      resources {
        cpu    = 200
        memory = 256
      }
    }
  }
}
```

O Nomad escolhe a porta. O Consul recebe o registro do serviço e o resultado do
*health check*. O Traefik usa essa informação para encontrar uma alocação
saudável e encaminhar a requisição. A aplicação não precisa conhecer a porta
externa, nem o proxy precisa receber uma configuração manual a cada deploy.

O endpoint `/health` merece atenção. Ele não deve depender de uma chamada lenta
ou instável a um serviço externo apenas para provar que o processo existe. Eu
começaria com uma verificação curta da aplicação e adicionaria dependências
críticas somente quando a semântica do serviço justificar isso.

## `nomad job run` não percebe uma mudança de código

Esta foi a lição mais importante do fluxo.

O scheduler compara a especificação do job. Ele não acompanha o conteúdo do
diretório Git usado pelo processo. Se o HCL continua igual e apenas o código
Python mudou, rodar `nomad job run` pode manter a alocação existente. O `uvicorn`
continua executando a versão que já estava na memória.

Por isso, depois de atualizar o repositório e sincronizar as dependências, o
pipeline reinicia o job de forma explícita:

```bash
set -euo pipefail

cd /home/appuser/minha-aplicacao/current
uv sync

sudo nomad job plan deploy/minha-aplicacao.nomad.hcl
sudo nomad job run deploy/minha-aplicacao.nomad.hcl
sudo nomad job restart -on-error=fail minha-aplicacao
```

O `plan` torna visível uma mudança na especificação antes de aplicá-la. O
`restart` reinicia o processo dentro da alocação existente, fazendo com que ele
carregue o conteúdo que acabou de ser baixado pelo Git. O parâmetro
`-on-error=fail` também evita que uma execução sem TTY pare esperando uma
confirmação que o runner não pode responder.

Há um custo: um restart pode causar indisponibilidade breve quando existe uma
única réplica. Para aplicações que não podem aceitar esse intervalo, eu usaria
mais de uma alocação, uma estratégia de atualização compatível com o workload e
uma forma de compartilhar ou externalizar o estado.

## O pipeline deve transportar pouco contexto

O workflow do Forgejo tem uma responsabilidade pequena: autenticar no host,
atualizar o checkout e chamar o script versionado junto da aplicação.

```yaml
on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: linux-amd64
    steps:
      - name: Atualizar e publicar
        run: |
          ssh appuser@deploy-host '
            set -euo pipefail
            git -C /home/appuser/minha-aplicacao/current pull --ff-only
            /home/appuser/minha-aplicacao/current/deploy/deploy.sh
          '
```

As chaves SSH e o endereço do host ficam nos segredos e variáveis do Forgejo. O
script `deploy.sh` fica no repositório. Essa divisão facilita revisar o que é
comportamento da aplicação e o que é configuração do ambiente.

Eu evitaria concentrar todo o deploy em YAML. Quando a lógica operacional cresce,
um script versionado é mais fácil de testar localmente, executar por SSH durante
um diagnóstico e compartilhar com outra pessoa que precise operar o serviço.

## Quando essa escolha funciona

Eu usaria esse modelo quando a aplicação tiver estas características:

- poucas réplicas e baixo volume inicial;
- hosts que a equipe administra diretamente;
- aplicação Python simples, iniciada por um processo conhecido;
- dados separados do checkout e cobertos por backup;
- dependências reproduzíveis por `uv.lock`;
- necessidade de publicar rapidamente sem manter um registry próprio.

Também é um bom ponto de partida para ferramentas internas, protótipos que já
precisam de operação disciplinada e APIs pequenas que serão evoluídas aos poucos.

O modelo deixa de ser confortável quando o serviço precisa escalar
horizontalmente com estado local, atender a requisitos fortes de isolamento ou
ser executado em ambientes que não aceitam processos nativos no host. Nesses
casos, imagem de container, registry, ACLs completas e uma plataforma mais
estruturada passam a compensar a complexidade adicional.

## O que eu melhoraria antes de tratar isso como plataforma

O fluxo já entrega aplicações, mas ainda não é uma plataforma acabada.

Eu colocaria estas evoluções antes de aumentar muito o número de serviços:

1. automatizar rollback para uma versão anterior do job e do checkout;
2. substituir segredos em variáveis de ambiente por uma integração com Vault ou
   mecanismo equivalente;
3. habilitar ACLs e remover permissões genéricas de `sudo`;
4. registrar versão do Git, versão do job e resultado do *health check* em cada
   deploy;
5. definir uma estratégia para dados compartilhados antes de adicionar réplicas.

Esses pontos não invalidam a escolha inicial. Eles indicam onde a simplicidade
começa a cobrar juros. A vantagem de começar pequeno é conseguir ver esse momento
com clareza, em vez de carregar uma plataforma mais complexa antes de precisar
dela.

## Conclusão

Para este homelab, executar Python diretamente no Nomad foi uma decisão de
redução de superfície operacional. O resultado não depende de abandonar
containers como princípio; depende de reconhecer que o ciclo de entrega precisa
ser proporcional ao número de aplicações, à equipe e ao risco.

Se eu fosse aplicar essa ideia em outro ambiente, começaria separando código de
dados, criando um usuário de deploy limitado, adicionando um endpoint de saúde e
deixando explícito o restart que coloca a nova versão em execução. Só depois
decidiria se o custo de um registry e de imagens traz benefício suficiente para o
problema real.
