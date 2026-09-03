# Whisper.cpp local: uma API de transcrição sem depender da nuvem

Published: 2026-05-22
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/whisper-cpp-api-local-transcricao-compativel/
Tags: IA, Whisper, Speech-to-Text, Homelab, Infraestrutura

---

Eu queria usar transcrição de voz no meu fluxo diário sem transformar cada áudio em uma chamada para um serviço externo. O requisito, porém, não era apenas rodar um modelo localmente. O cliente já trabalhava com o contrato de uma API de transcrição. Trocar o motor de inferência não deveria obrigar a trocar a interface, reescrever integrações ou ensinar um novo fluxo para quem já grava áudio.

Foi por isso que montei um serviço local com [whisper.cpp](https://github.com/ggml-org/whisper.cpp) que responde em `/audio/transcriptions`.

O resultado é uma separação simples:

```text
Cliente de voz
    → API local de transcrição
        → conversão do áudio quando necessária
            → modelo Whisper executado localmente
```

O cliente envia o áudio. O serviço normaliza o formato quando preciso e devolve a transcrição. Para o cliente, o contrato continua sendo o mesmo; por trás dele, posso trocar o modelo, ajustar o número de threads ou mover o serviço de máquina sem alterar a integração.

Essa escolha fez sentido para um uso pessoal e interno, com volume previsível e um servidor que já estava disponível. Ela não é uma recomendação universal para todo produto que recebe áudio.

## O problema não era instalar o Whisper

Executar o Whisper localmente é relativamente direto. O problema operacional aparece depois: o áudio gravado por navegadores e clientes de voz raramente chega no formato mais conveniente para a inferência.

Um teste local costuma começar com um WAV conhecido. Em produção, o serviço pode receber WEBM com Opus, MP3, M4A ou arquivos com metadados estranhos. Se o processo de transcrição aceita apenas um formato, a integração funciona no teste e falha quando alguém grava uma nota de voz real.

Eu precisava atender a quatro condições:

* manter o áudio dentro da rede local;
* aceitar os formatos que o cliente já produz;
* não depender de GPU, Ollama ou uma conta de API;
* preservar o endpoint que o cliente esperava.

O [whisper.cpp](https://github.com/ggml-org/whisper.cpp) atende bem ao último ponto porque inclui um servidor HTTP. Com `--inference-path /audio/transcriptions`, ele pode expor uma rota compatível com a interface de transcrição que muitas aplicações já conhecem.

## A compatibilidade é mais valiosa do que parece

Uma API estável cria uma fronteira entre o produto e a infraestrutura de IA.

No cliente, o envio permanece parecido com isto:

```bash
curl -X POST http://stt.interno:8080/audio/transcriptions \
  -F file="@nota-de-voz.webm" \
  -F language="pt" \
  -F response_format="json"
```

Não importa se, no servidor, a implementação usa um binário em C++, uma GPU, um serviço em nuvem ou uma versão menor do modelo. O cliente precisa conhecer apenas o formato de entrada e a resposta esperada.

Essa separação é útil em três situações:

* quando a equipe quer começar localmente e manter aberta a opção de usar outro backend depois;
* quando o mesmo cliente precisa funcionar em ambientes com políticas de dados diferentes;
* quando a parte cara ou mais experimental da infraestrutura muda mais rápido que o aplicativo.

No meu caso, ela também reduziu a fricção para usar o OpenWhispr. Em vez de adaptar o aplicativo a uma ferramenta específica de inferência, adaptei o serviço local ao contrato que o aplicativo já falava.

## O detalhe que costuma quebrar a primeira versão: formatos de áudio

O `whisper.cpp` pode usar o FFmpeg para converter o áudio recebido antes da transcrição. Essa não é uma otimização opcional quando o cliente envia WEBM/Opus: é a diferença entre aceitar uma gravação do navegador e retornar um erro de decodificação.

Na compilação, habilitei o suporte ao FFmpeg:

```bash
sudo apt update
sudo apt install -y \
  git build-essential cmake ffmpeg \
  libavcodec-dev libavformat-dev libavutil-dev libswresample-dev pkg-config

git clone https://github.com/ggml-org/whisper.cpp.git
cd whisper.cpp
cmake -B build -DWHISPER_FFMPEG=ON
cmake --build build -j
```

Antes de seguir, eu verificaria se a configuração realmente encontrou o FFmpeg:

```bash
rg 'WHISPER_FFMPEG' build/CMakeCache.txt
```

O resultado esperado é a opção habilitada. Compilar sem esse recurso e ativar `--convert` depois só desloca o problema para a primeira requisição real.

Também vale observar que as opções do servidor evoluem entre versões. Eu trataria o `--help` do binário instalado como a referência final para os parâmetros disponíveis, especialmente antes de automatizar a unidade do systemd.

## Escolher o modelo é escolher um orçamento de latência e memória

Para esse serviço, usei o `ggml-large-v3-turbo-q8_0.bin`. O repositório de modelos convertidos para `whisper.cpp` o disponibiliza com cerca de 834 MiB, enquanto a variante não quantizada ocupa aproximadamente 1,5 GiB. [A lista oficial de modelos](https://huggingface.co/ggerganov/whisper.cpp) mostra tamanhos e hashes para conferir o arquivo baixado.

```bash
mkdir -p models
curl -L \
  -o models/ggml-large-v3-turbo-q8_0.bin \
  https://huggingface.co/ggerganov/whisper.cpp/resolve/main/ggml-large-v3-turbo-q8_0.bin

echo "01bf15bedffe9f39d65c1b6ff9b687ea91f59e0e  models/ggml-large-v3-turbo-q8_0.bin" \
  | sha1sum --check
```

Não escolhi esse arquivo porque ele seria “o melhor modelo”. Escolhi porque, para o áudio que eu transcrevia e a CPU disponível, ele oferecia qualidade suficiente sem exigir uma GPU dedicada.

Esse equilíbrio precisa ser medido no ambiente real. Eu começaria respondendo a estas perguntas:

* Quanto tempo de áudio chega por requisição?
* O usuário espera uma resposta interativa ou pode aguardar uma fila?
* Quantas transcrições podem acontecer ao mesmo tempo?
* Há memória suficiente para o modelo e para a conversão temporária dos arquivos?
* O ganho de qualidade justifica aumentar a latência?

Um modelo maior pode melhorar casos difíceis. Mas, se uma máquina de CPU passa a acumular áudios, a experiência piora mesmo que a transcrição individual seja melhor. Para uso concorrente, eu avaliaria fila, limite de tamanho do upload, uma segunda instância ou aceleração por GPU antes de simplesmente aumentar o número de threads.

## Um servidor pequeno, com responsabilidades explícitas

O comando de teste ficou próximo deste:

```bash
./build/bin/whisper-server \
  -m ./models/ggml-large-v3-turbo-q8_0.bin \
  --host 127.0.0.1 \
  --port 8080 \
  --convert \
  -ng \
  -l pt \
  --inference-path /audio/transcriptions \
  -t 4
```

Há algumas decisões embutidas aqui.

`--convert` delega ao FFmpeg o tratamento dos formatos que chegam do cliente. `-ng` desabilita GPU, coerente com a decisão de executar o serviço em CPU. `-t 4` limita o trabalho a quatro threads; eu ajustaria esse número observando CPU, memória e a concorrência do host, não pela quantidade máxima de núcleos.

O endereço também merece atenção. Para um serviço publicado por um proxy reverso no mesmo host, eu prefiro `127.0.0.1`. Assim, a API não fica exposta diretamente na rede. Quando o cliente precisa acessá-la de outra máquina, a alternativa não deveria ser apenas trocar para `0.0.0.0`: é necessário definir firewall, autenticação e o ponto de entrada apropriado.

## Transformar o comando em serviço

Depois que o teste manual funciona, o próximo passo é deixar o processo reiniciar sozinho e voltar depois de um reboot. Para um único serviço em um host pequeno, systemd é suficiente.

Eu criaria um usuário de serviço sem login e manteria binário, modelo e arquivos temporários em diretórios próprios. O exemplo abaixo usa caminhos genéricos justamente para evitar que o serviço dependa do diretório pessoal de alguém.

```ini
# /etc/systemd/system/whisper-server.service
[Unit]
Description=whisper.cpp local transcription API
After=network.target

[Service]
Type=simple
User=stt
Group=stt
WorkingDirectory=/opt/whisper.cpp
ExecStart=/opt/whisper.cpp/build/bin/whisper-server \
  -m /var/lib/whisper/models/ggml-large-v3-turbo-q8_0.bin \
  --host 127.0.0.1 \
  --port 8080 \
  --convert \
  -ng \
  -l pt \
  --inference-path /audio/transcriptions \
  -t 4
Restart=on-failure
RestartSec=5
Environment=OMP_NUM_THREADS=4

[Install]
WantedBy=multi-user.target
```

Em seguida:

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now whisper-server
sudo systemctl status whisper-server
```

O ponto importante não é copiar a unidade literalmente. É tornar explícitos o usuário, o diretório de trabalho, o modelo carregado, a porta e o comportamento de reinício. Quando algum deles fica implícito, o serviço costuma funcionar até a próxima manutenção.

## O teste que valida a integração

Eu não consideraria o serviço pronto apenas porque a porta responde. O teste precisa enviar um arquivo no mesmo formato que o cliente usa e verificar o formato de resposta que ele espera.

```bash
curl --fail-with-body -X POST http://127.0.0.1:8080/audio/transcriptions \
  -F file="@nota-de-voz.webm" \
  -F language="pt" \
  -F response_format="json"
```

Eu validaria pelo menos quatro coisas:

* o servidor aceita WEBM/Opus, além de um WAV de laboratório;
* a resposta contém o campo que o cliente lê;
* uma gravação em português não está presa à configuração de inglês;
* falhas de conversão aparecem nos logs com informação suficiente para diagnóstico.

Se o log disser que não foi possível decodificar o áudio, eu revisaria primeiro a compilação com FFmpeg e a disponibilidade do binário `ffmpeg` para o usuário do serviço. Esse foi o ponto de integração mais sensível da configuração.

## Privacidade local não elimina responsabilidade operacional

Manter a inferência local evita enviar o áudio a um fornecedor externo, mas não torna o serviço automaticamente seguro.

Ainda existem arquivos temporários, logs, backups, permissões de diretório e uma porta HTTP para administrar. Se o áudio contiver informação sensível, eu decidiria conscientemente:

* por quanto tempo arquivos temporários podem existir;
* quem pode chamar o endpoint;
* se o proxy precisa autenticar o cliente;
* quais dados podem aparecer nos logs;
* como os modelos e binários serão atualizados e verificados.

Em um ambiente compartilhado, eu evitaria expor a rota sem autenticação apenas porque ela está dentro da rede privada. Rede privada reduz a superfície; não substitui uma política de acesso.

## Quando eu escolheria outra arquitetura

Essa abordagem é adequada para uma instância pequena, uso interno e carga que cabe no host. Ela começa a perder vantagem quando o requisito muda.

Eu procuraria outra solução quando fosse necessário:

* processar muitos áudios simultâneos com latência previsível;
* usar GPU para reduzir o tempo de transcrição;
* escalar horizontalmente e distribuir filas;
* manter alta disponibilidade entre máquinas;
* oferecer o serviço como produto público com controle de consumo;
* aplicar diarização, pós-processamento ou retenção de artefatos mais complexa.

Nessas situações, o endpoint compatível continua útil. A implementação atrás dele pode migrar para uma fila, um pool de workers ou outro backend sem obrigar os clientes a reaprender o contrato.

## Conclusão

O ganho principal dessa configuração não foi apenas transcrever áudio sem uma API externa. Foi manter a transcrição como uma capacidade local com uma interface estável.

Para um cenário de baixo a médio volume, eu começaria com uma única instância de `whisper.cpp`, conversão via FFmpeg e uma rota compatível com `/audio/transcriptions`. Mediria qualidade, tempo de resposta e uso de CPU com áudios reais. Só então decidiria se vale investir em GPU, fila ou múltiplos workers.

O cliente continua falando com uma API de transcrição. A infraestrutura por trás dela pode evoluir no ritmo que o ambiente permitir.
