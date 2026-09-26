# Como publicar parte do meu Vault do Obsidian sem expor o conteúdo privado

Published: 2026-03-10
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/publicar-parte-do-vault-obsidian/
Tags: Obsidian, Markdown, Git, Bash, Automação

---

O Obsidian trabalha diretamente com arquivos Markdown. Isso facilita versionar, processar e publicar as notas, mas também torna perigoso tratar o Vault inteiro como conteúdo público.

Eu queria manter o Vault privado como fonte principal e, ao mesmo tempo, compartilhar um subconjunto de notas. A solução foi separar a decisão de publicação do armazenamento: a nota continua no Vault privado, e um script copia apenas os arquivos explicitamente marcados para um repositório público.

## A fonte de verdade continua privada

O fluxo pode ser resumido assim:

1. O Vault privado contém todas as notas.
2. Uma nota recebe metadados que autorizam a publicação.
3. Um script percorre o diretório escolhido.
4. Apenas as notas autorizadas são copiadas para outro diretório.
5. O diretório público é versionado e publicado separadamente.

Um frontmatter possível seria:

```yaml
---
public: true
publish: true
---
```

Os nomes dos campos não são importantes. O importante é que o critério seja explícito, fácil de revisar e aplicado pelo script de forma previsível.

## O espelho filtrado

Um script inicial pode ser pequeno:

```bash
find "$VAULT/notes" -name '*.md' -print0 |
while IFS= read -r -d '' note; do
  if rg -q '^public: true$' "$note" && rg -q '^publish: true$' "$note"; then
    cp "$note" "$PUBLIC_VAULT/notes/"
  fi
done
```

Em um fluxo real, eu acrescentaria remoção de arquivos que deixaram de ser públicos, preservação de subdiretórios, cópia de anexos autorizados e uma etapa de validação antes do commit.

O repositório público precisa ser tratado como uma saída derivada. Ele não deve virar um segundo lugar para editar a nota, porque isso criaria duas fontes de verdade e divergências difíceis de resolver.

## O que revisar antes de copiar

O filtro de frontmatter não protege contra tudo. Eu também verificaria:

- links para notas privadas;
- anexos e imagens com informação sensível;
- nomes de pessoas, hosts e caminhos locais;
- histórico do Git;
- metadados que revelam mais contexto do que o corpo da nota;
- referências que só fazem sentido dentro do Vault original.

Depois da cópia, vale executar uma busca por padrões que não deveriam sair do ambiente privado e revisar o diff antes de publicar.

Esse modelo funciona porque combina uma autorização explícita com ferramentas simples. Markdown mantém a portabilidade, Bash automatiza a seleção e Git fornece histórico. O resultado é publicação seletiva sem transformar o Vault privado em uma coleção de pastas que precisam ser mantidas manualmente.
