# Como transformei vídeos e podcasts em uma biblioteca pessoal de pesquisa

Published: 2026-08-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/biblioteca-pessoal-videos-podcasts/
Tags: Pesquisa, YouTube, Podcasts, Transcrição, IA local, Obsidian, FastAPI

---

Durante muito tempo, eu salvava vídeos e podcasts interessantes para assistir depois. Quando finalmente assistia a algum deles, o problema apenas mudava de lugar: alguns dias mais tarde eu lembrava da ideia, mas não lembrava em qual conteúdo ela aparecia, em que trecho era discutida ou como se relacionava com o que eu já estava estudando.

O link guardado não registrava esse contexto. Ele só apontava para uma coisa que eu pretendia consumir.

Foi dessa frustração que nasceu o `video-data-product`, um projeto para transformar vídeos do YouTube e episódios de podcast em uma biblioteca pessoal de pesquisa. No início, ele baixava metadados e transcrições. Com o uso, passou a organizar referências, gerar artefatos de leitura e reduzir o esforço para recuperar uma ideia antiga.

## O problema estava na recuperação

Vídeos e podcasts são bons formatos para acompanhar uma conversa, uma demonstração ou uma explicação longa. Eles são menos convenientes quando preciso consultar uma ideia específica.

Um vídeo de uma hora pode conter dois minutos relevantes para uma decisão. Um episódio de podcast pode mencionar uma referência importante no meio de uma conversa que não quero rever inteira. Procurar essa passagem pela memória ou arrastar a timeline exige um custo alto para uma pergunta pequena.

Eu queria responder a três perguntas sem reassistir tudo:

- O conteúdo realmente trata do assunto que estou pesquisando?
- Em qual trecho aparece a ideia relevante?
- Vale a pena transformar esse material em uma referência permanente?

A biblioteca deveria ajudar nessa triagem e preservar o contexto daquilo que merecesse continuar disponível.

## O pipeline de ingestão

O projeto recebe uma URL ou um identificador e executa um processamento assíncrono:

```text
URL ou ID
  → metadados e descrição
  → legendas ou áudio
  → transcrição normalizada
  → resumo e outros artefatos
  → índice, coleções e referências
```

Para o YouTube, uso `yt-dlp` para coletar os metadados e obter as legendas disponíveis. A transcrição é normalizada e armazenada em texto, além de uma versão estruturada por segmentos e timestamps.

Podcasts exigem outro caminho. Quando não existe uma transcrição publicada, o sistema resolve os dados do episódio, baixa o áudio temporariamente, normaliza o arquivo com `ffmpeg` e o envia ao serviço de ASR do meu homelab. Esse serviço usa Whisper por trás de um endpoint LiteLLM compatível com a API da OpenAI. Depois disso, o episódio entra nas mesmas etapas semânticas usadas pelos vídeos.

Essa diferença fica restrita à ingestão. Depois de processados, vídeo e podcast são itens do mesmo catálogo.

<figure>
  <img src="/assets/images/video-data-product-pipeline.svg" alt="Diagrama do pipeline da biblioteca: YouTube passa por yt-dlp, podcasts passam por ffmpeg e Whisper local, as duas origens convergem em uma transcrição estruturada e seguem para análise com Qwen 3.5." loading="lazy">
  <figcaption>Vídeos e podcasts têm ingestões diferentes, mas convergem na mesma transcrição, no mesmo pipeline de IA local e nos mesmos artefatos de pesquisa.</figcaption>
</figure>

## A transcrição é o primeiro artefato, não o último

A transcrição tornou o conteúdo pesquisável, mas uma transcrição completa pode ter dezenas de milhares de palavras. Ela ajuda a encontrar um trecho, mas não responde rapidamente se vale a pena investir tempo naquele item.

Por isso, acrescentei artefatos derivados:

- resumo para uma primeira leitura;
- ideia principal, com uma frase e um parágrafo de contexto;
- ficha bibliográfica para o Obsidian;
- insights que destacam pontos menos óbvios;
- mapa conceitual interativo;
- segmentos com timestamps para voltar à fonte original.

Esses artefatos têm funções diferentes. O resumo serve para triagem. A ficha bibliográfica preserva a referência. Os segmentos permitem auditoria. O mapa ajuda a observar relações entre assuntos.

Eu não trato a análise gerada por modelo como fonte final. Quando uma afirmação parece importante, volto à transcrição e, se necessário, ao vídeo ou episódio original. O modelo reduz o tempo de leitura inicial; a fonte continua responsável pela evidência.

## IA local como parte da arquitetura

A geração desses artefatos acontece com IA local. A aplicação não chama diretamente uma API pública de modelos: ela envia as requisições por HTTP para o LiteLLM que mantenho no homelab, usando uma interface compatível com a API da OpenAI. Na configuração registrada em agosto de 2026, os cinco passos de análise são executados com o modelo `qwen/qwen3.5-9b`.

O modelo não está acoplado ao backend FastAPI. O LiteLLM funciona como gateway entre a aplicação e a infraestrutura de inferência, então posso trocar o modelo ou ajustar o roteamento sem reescrever o pipeline. Cada tarefa também possui um prompt próprio, versionado junto com o código: resumir, extrair a ideia principal, produzir a ficha bibliográfica, encontrar insights e criar o mapa conceitual.

Esse desenho mantém transcrições e análises dentro da minha infraestrutura e torna viável reprocessar o acervo sem transformar cada experimento em consumo de uma API comercial. O custo não desaparece; ele muda para capacidade de inferência, energia, tempo de fila e operação do homelab. Em troca, ganho controle sobre os modelos, os prompts e o destino dos dados.

O mesmo princípio vale para podcasts sem transcrição publicada. O Whisper é oferecido como outro serviço atrás do gateway local. Para a aplicação, análise de texto e ASR usam contratos conhecidos; para mim, continuam sendo componentes que posso observar, atualizar e substituir de forma independente.

<figure>
  <img src="/assets/images/video-data-product-ia-local.svg" alt="Diagrama da arquitetura local: FastAPI e o worker enviam texto e áudio ao LiteLLM no homelab, que roteia as requisições para Qwen 3.5 e Whisper antes de devolver os resultados para armazenamento e consulta." loading="lazy">
  <figcaption>O LiteLLM desacopla a aplicação dos modelos: Qwen 3.5 cuida dos artefatos semânticos e Whisper da transcrição, ambos dentro do homelab.</figcaption>
</figure>

## A interface virou uma ferramenta de triagem

Hoje uso a aplicação como uma combinação de caixa de entrada, catálogo e ferramenta de pesquisa. Envio um conteúdo sem decidir naquele instante se ele merece uma hora da minha atenção. Depois do processamento, encontro thumbnail, status, descrição, resumo e transcrição em um só lugar.

Minha primeira leitura é o resumo. Ele responde à decisão mais prática: continuar investigando ou deixar o item arquivado?

### Avaliação por estrelas

Uso estrelas como um filtro simples. Nem todo item precisa virar referência permanente. Alguns servem para uma pesquisa pontual; outros merecem ser revisitados e relacionados a notas existentes.

Uma avaliação curta permite separar esses casos sem criar um processo de catalogação pesado.

### Coleções temáticas

As coleções reúnem itens por problema ou linha de pesquisa, e não apenas por canal, data ou título. Um mesmo vídeo pode participar de uma coleção sobre agentes de IA e de outra sobre observabilidade, porque os assuntos não respeitam uma única categoria.

### Busca na transcrição

Quando lembro de um termo, tecnologia ou exemplo, procuro diretamente no texto e vejo os timestamps associados. A mesma busca também serve antes de assistir: consigo confirmar se o assunto foi realmente discutido ou se aparece apenas no título e na descrição.

## A ficha bibliográfica encurta o caminho até as notas

A ficha bibliográfica foi desenhada para entrar no meu sistema de notas. Ela contém frontmatter, dados bibliográficos, referência em formato ABNT, temas, citações e links wiki.

O ganho não está somente em economizar alguns minutos de formatação. É reduzir a distância entre encontrar uma fonte e relacioná-la com uma decisão arquitetural, uma nota antiga ou outra referência da biblioteca.

Quando essa distância é grande, o material interessante volta a ser apenas um link salvo. Quando o caminho é curto, a fonte passa a fazer parte do contexto que consigo consultar.

## O que fica em cada camada

Tratei o projeto como um produto de dados porque cada tipo de informação tem um ciclo de vida diferente:

| Camada | Responsabilidade |
| --- | --- |
| Armazenamento compatível com S3 | Arquivos originais e artefatos derivados |
| PostgreSQL | Índice, status, avaliações, coleções e associações |
| Filesystem local | Cache e arquivos temporários do processamento |
| FastAPI | API e coordenação das operações |
| SvelteKit | Interface da biblioteca |
| CLI | Reprocessamento, reconciliação e diagnóstico |

Transcrições permanecem disponíveis como texto e JSON. As análises são arquivos Markdown. O mapa conceitual é um HTML autônomo. Formatos simples tornam possível consultar o material fora da interface atual e reduzem o risco de prender o acervo a uma única aplicação.

## Assíncrono desde o começo

Baixar conteúdo, converter áudio, transcrever e chamar modelos são operações demoradas. O processamento assíncrono permite que a interface continue útil enquanto o item avança pela fila.

O sistema mantém estados explícitos de pendência, processamento, sucesso e erro. Durante a inicialização, ele reconcilia trabalhos incompletos para que uma reinicialização não transforme a fila em um estado desconhecido.

Essa decisão só se tornou evidente quando o projeto deixou de processar um item ocasionalmente. Um script síncrono era suficiente para o primeiro teste. Uma biblioteca que recebe itens continuamente precisa informar o que aconteceu com cada trabalho e oferecer uma forma de reprocessá-lo.

## Observabilidade e publicação

O projeto possui instrumentação com OpenTelemetry para acompanhar a fila, as etapas de ingestão, as chamadas de análise, os erros e os tempos de processamento. Evito incluir transcrições, títulos ou URLs nos atributos de telemetria; esses dados pertencem ao catálogo, não aos traces.

No deploy, backend e frontend são publicados em imagens separadas com a mesma revisão e executados no Nomad. O fluxo aplica migrations, reconcilia o catálogo e valida a aplicação antes de concluir a publicação.

Essas decisões seriam exageradas para o script inicial. Tornaram-se úteis quando o sistema passou a guardar uma parte real da minha pesquisa e um erro de processamento deixou de ser apenas um inconveniente local.

## Limites que considero parte do produto

Há quatro limites que eu não esconderia de quem tentar construir algo parecido.

Primeiro, a transcrição depende da qualidade das legendas ou do áudio. Nomes próprios, termos técnicos e falas sobrepostas podem gerar erros. Timestamps ajudam a revisar, mas não eliminam a necessidade de conferir a fonte.

Segundo, análises semânticas têm custo e variabilidade, mesmo quando o modelo roda localmente. O resumo pode ser útil para triagem e ainda assim omitir uma nuance importante. A saída precisa ser tratada como um índice de leitura, não como uma edição autorizada do conteúdo.

Terceiro, local não significa sem fronteiras. O backend envia áudio e texto para serviços separados dentro do homelab, por isso mantenho esses componentes em rede controlada e evito registrar transcrições, prompts ou respostas na telemetria. Se o gateway fosse configurado para usar um provedor externo, eu precisaria reavaliar retenção, termos de uso e adequação do conteúdo antes de enviar material sensível.

Quarto, baixar e armazenar mídia não resolve direitos autorais. A biblioteca é para pesquisa pessoal, deve preservar a origem e precisa respeitar os termos da plataforma e as regras aplicáveis ao uso do conteúdo.

## O que mudou no meu processo

Antes, eu acumulava links. Agora acumulo artefatos que consigo consultar.

Essa diferença alterou a forma como consumo conteúdo. Nem todo vídeo precisa ser visto do início ao fim. Às vezes o resumo resolve a triagem. Às vezes a busca encontra um trecho específico. Em outros casos, a análise indica que vale a pena assistir com atenção, registrar uma nota e relacionar a fonte com outras ideias.

O projeto não foi criado para aumentar o volume de consumo. Ele reduz o custo de selecionar, recuperar e preservar o que continua relevante.

## Próximas medições

O próximo passo é substituir impressões por medidas simples:

- tempo entre o envio de uma URL e a transcrição pesquisável;
- taxa de sucesso e de reprocessamento por origem;
- amostragem de erros de transcrição em termos técnicos;
- tempo para encontrar um trecho usando a busca, comparado à navegação manual;
- quantidade de itens que viram referências permanentes depois da triagem.

Essas medidas ajudam a decidir onde investir. Se a ingestão falha, preciso melhorar a fila e os adaptadores. Se a transcrição está correta, mas ninguém volta aos itens, o problema provavelmente está na interface ou nos artefatos de triagem.

## Conclusão

O `video-data-product` começou como uma API para extrair metadados e transcrições. Hoje ele me ajuda a preservar o contexto das fontes que encontro e a decidir quais merecem atenção continuada.

O princípio que ficou é simples: uma biblioteca de pesquisa precisa registrar mais do que o endereço de uma mídia. Ela deve preservar o conteúdo consultável, a referência, os sinais de relevância e o caminho de volta à fonte original.

Para quem quiser construir algo semelhante, eu começaria com uma única origem, uma transcrição pesquisável e um fluxo explícito de reprocessamento. Só depois adicionaria análises semânticas, coleções e mapas conceituais. A biblioteca fica mais útil quando cada camada resolve um problema observado no uso, e não quando a interface apenas acumula funções.
