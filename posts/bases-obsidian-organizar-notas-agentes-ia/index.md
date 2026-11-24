# Bases do Obsidian para organizar notas e trabalhar com agentes de IA

Published: 2026-11-24
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/bases-obsidian-organizar-notas-agentes-ia/
Tags: Obsidian, Gestão do conhecimento, Inteligência Artificial

---

Tenho uma coleção de softwares de música que fui adquirindo ao longo dos anos. Alguns vieram com equipamentos, outros foram oferecidos sem custo, mas exigiam registrar a aquisição para obter a licença.

Eu guardava essas informações em uma planilha. Com o tempo, minha dificuldade passou a ser lembrar para que servia cada software. O nome sozinho nem sempre ajudava.

Depois que comecei a trabalhar com agentes de IA, pedi que organizassem esse acervo em fichas individuais. Cada software passou a ter sua própria nota. As Bases do Obsidian me deram uma maneira de consultar o conjunto: visualizar os registros, filtrar categorias e abrir a ficha quando preciso dos detalhes.

Esse arranjo me interessa porque combina uma visão organizada do acervo com arquivos que posso ler, revisar e entregar a um agente.

## Uma linha na tabela e uma nota completa

[Bases é um recurso nativo do Obsidian](https://obsidian.md/help/bases) que permite criar visualizações sobre os arquivos e suas propriedades. Em uma visualização de tabela, cada linha representa um arquivo e as colunas mostram propriedades.

Posso olhar para uma lista de softwares, encontrar o que procuro e abrir a nota correspondente. Na ficha, tenho espaço para descrição, referências e observações que ficariam desconfortáveis em uma célula.

No meu acervo, pedi também miniaturas para ajudar na identificação visual. Organizei colunas de categorias e mostrei, durante uma aula, como poderia procurar os softwares de reverb.

A tabela resolve a consulta ao conjunto. A nota permite aprofundar um registro específico.

## Onde ficam os dados

Os dados das notas continuam nos arquivos Markdown e em suas propriedades. A [configuração da Base](https://obsidian.md/help/bases/syntax) — como visualizações, filtros e fórmulas — pode ficar em um arquivo com extensão `.base`.

Essa separação é importante para entender o funcionamento. A Base define como apresentar e consultar os registros; cada ficha preserva seu conteúdo.

Uma nota de software poderia começar assim, em um exemplo fictício:

```markdown
---
tipo: software
fabricante: Fabricante Exemplo
categoria:
  - reverb
situacao: adquirido
---

# Reverb Exemplo

## Para que serve

Reverberação para uso em produção musical.

## Referências

Links para documentação e informações de instalação.

## Observações

Anotações de uso e avaliação.
```

As propriedades do cabeçalho permitem organizar a consulta. O corpo da nota comporta explicações e observações mais extensas.

Se quero filtrar pela categoria, preciso registrá-la como propriedade. Escrever “este software é um reverb” em algum parágrafo não equivale a preencher o campo usado pelo filtro.

## Os mesmos registros podem responder a perguntas diferentes

Uma Base pode ter [várias visualizações](https://obsidian.md/help/bases/views), cada uma com sua configuração de exibição, ordenação e filtros.

Para um catálogo de softwares, eu poderia organizar consultas como estas:

| Visualização | Pergunta que quero responder |
| - | - |
| Todos os softwares | O que tenho registrado? |
| Reverberação | Quais registros estão classificados como reverb? |
| Por fabricante | Quais softwares tenho de determinado fabricante? |
| Cadastro incompleto | Quais fichas ainda estão sem categoria? |

Essas visualizações consultam os mesmos registros. Não preciso manter uma cópia da ficha para cada forma de navegar pelo acervo.

A escolha das propriedades começa pelas perguntas que pretendo fazer. Se uma informação precisa servir de filtro, vale definir como será preenchida.

## O agente organiza os arquivos e eu reviso o conjunto

Um agente com acesso autorizado aos arquivos pode ajudar a criar fichas, preencher propriedades e organizar conteúdo disperso. Para isso funcionar bem, preciso definir o padrão dos registros.

Na aula, usamos um cadastro fictício de membros de uma célula da igreja. Primeiro, pedi uma ficha para cada pessoa. Depois, solicitei uma Base para consultar o conjunto.

O exemplo tornou visível uma possibilidade prática: receber informações em um texto e distribuí-las entre os registros correspondentes. O agente poderia auxiliar nesse preenchimento, enquanto eu usaria o Obsidian para conferir o resultado.

Há uma diferença entre explicar como preencher um cadastro e efetivamente atualizar seus arquivos. Esse fluxo permite que o agente execute a atualização e deixe uma entrega que consigo inspecionar.

Para começar um catálogo de softwares, uma orientação poderia ser:

> Crie uma nota Markdown para cada software a partir do material fornecido. Use as propriedades tipo, fabricante, categoria e situacao. Preserve as referências e registre informações incertas como pendências. Não invente dados ausentes. Crie uma Base com uma tabela dos registros e uma visualização para fichas sem categoria.

Depois, eu abriria a Base para revisar a organização e consultaria as notas para conferir os detalhes.

## A consistência precisa entrar na instrução

Se cada ficha usa um nome diferente para a mesma propriedade, a consulta fica difícil de manter. `categoria`, `categorias` e `tipo_de_efeito` podem acabar representando a mesma coisa em registros diferentes.

Por isso, procuro definir poucos campos, com nomes estáveis e exemplos de preenchimento.

Também preciso separar ausência de informação de uma conclusão. Um campo vazio pode indicar que ainda não pesquisei aquele dado. O agente não deve preencher uma categoria apenas para deixar a tabela completa.

A visualização ajuda a localizar lacunas. A verificação depende de voltar à ficha e às fontes.

No caso de cadastros de pessoas, também considero quais informações são necessárias e quem terá acesso aos arquivos. A facilidade de criar campos não é motivo para acumular dados pessoais.

## A ficha também serve de contexto para outro trabalho

Uma das possibilidades que comentei na aula foi usar uma nota já organizada como ponto de partida para uma conversa com um agente especializado.

Se quero estudar um software, posso fornecer sua ficha, indicar as referências e pedir ajuda para uma tarefa específica. O registro reúne informações que eu teria de procurar novamente.

Isso conecta a organização do acervo ao uso da IA: o agente ajuda a estruturar as fichas, eu reviso, e as fichas passam a apoiar trabalhos posteriores.

Ainda preciso indicar quais arquivos consultar. A existência da nota no cofre não garante que seu conteúdo esteja disponível ao agente naquela sessão. Essa diferença aparece na [analogia entre a janela de contexto e a mesa de trabalho](/posts/janela-de-contexto-e-a-superficie-da-mesa-de-trabalho/). Para retomar o projeto em outra sessão, também preciso [preservar decisões e preparar a continuidade](/posts/o-trabalho-do-agente-precisa-sobreviver-a-conversa/).

## Começar por uma consulta que faça falta

Para experimentar Bases, eu começaria com um conjunto pequeno de registros e uma pergunta concreta.

No meu caso, era entender para que serviam os softwares que eu já tinha. Em outros projetos, pode ser localizar componentes de máquinas, consultar um catálogo de produtos ou acompanhar oportunidades comerciais.

A partir dessa pergunta, defino as propriedades necessárias, organizo algumas fichas e monto a primeira visualização. Depois observo o que realmente ajuda na consulta.

O que me atrai nessa combinação é conseguir trabalhar em duas escalas: percorrer o conjunto pela Base e abrir cada nota para entender seus detalhes. Com os arquivos organizados, também tenho material mais claro para orientar o próximo trabalho do agente.

## Referências

- [Introdução às Bases — documentação do Obsidian](https://obsidian.md/help/bases)

- [Visualizações — documentação do Obsidian](https://obsidian.md/help/bases/views)

- [Sintaxe das Bases — documentação do Obsidian](https://obsidian.md/help/bases/syntax)
