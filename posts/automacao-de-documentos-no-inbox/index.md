# Do INBOX ao arquivo: automatizando a organização de documentos

Published: 2026-06-08
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/automacao-de-documentos-no-inbox/
Tags: Automação, IA, OCR, Documentos, Homelab

---

Uma pasta de entrada cheia de PDFs e imagens transforma tarefas simples em trabalho recorrente: abrir o arquivo, descobrir o que ele é, escolher um nome, decidir o destino e tentar lembrar se aquilo já foi processado.

Montei um pequeno fluxo para automatizar essa rotina. Ele extrai o conteúdo, identifica o tipo de documento, sugere um nome com informações relevantes, encaminha o arquivo e gera uma versão em Markdown para busca e histórico.

## O pipeline

O fluxo pode ser descrito como:

```text
entrada → enriquecimento → classificação → nomeação → destino → histórico
```

Cada etapa tem uma responsabilidade diferente:

- OCR transforma imagem em texto;
- conversores extraem conteúdo de PDFs;
- regras tratam formatos conhecidos e arquivos protegidos por senha;
- um modelo local interpreta o conteúdo e propõe metadados;
- o sistema move o original para o destino;
- Markdown preserva uma cópia pesquisável para auditoria.

PDFs grandes podem ser processados com limite de páginas para reduzir custo e probabilidade de falha. Boletos, comprovantes, faturas, apólices e extratos seguem o mesmo princípio, mas podem ter regras de classificação diferentes.

## Determinismo antes da IA

Eu não entregaria toda a decisão ao modelo. Extensão, tamanho, checksum, padrões conhecidos e estado do processamento são informações que podem ser verificadas por código.

Usaria IA onde existe interpretação: identificar que um documento é uma fatura, extrair uma data ou sugerir um nome compreensível. Mesmo assim, o sistema deveria guardar o texto de origem, a proposta do modelo e a decisão final.

Documentos podem conter dados financeiros, pessoais e informações de contratos. Por isso, usar um modelo local reduz a exposição, mas não elimina a necessidade de controle de acesso, retenção e limpeza de arquivos temporários.

## O humano continua no fluxo

Um nome sugerido não deve ser aplicado silenciosamente quando a confiança é baixa. Eu deixaria os casos ambíguos em uma fila de revisão, com o original, a extração e a sugestão disponíveis no mesmo lugar.

O sucesso da automação não é mover todos os arquivos sem intervenção. É reduzir a quantidade de decisões repetitivas e manter rastreável o que aconteceu com cada documento.
