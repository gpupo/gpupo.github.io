# DESIGN.md: como dar memória visual aos agentes de IA

Published: 2026-08-06
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/design-md-memoria-visual-agentes-ia/
Tags: Documentação para agentes, Design, Design systems, Agentes de IA, Interfaces, Inteligência Artificial

---

Ferramentas de IA já conseguem gerar interfaces e código de front-end a partir de uma descrição em linguagem natural. O problema aparece depois da primeira tela.

Você pede uma página inicial. Depois solicita um dashboard. Em seguida, adiciona um formulário, uma área administrativa e uma nova jornada de cadastro.

Pouco a pouco, o produto perde coerência. O botão principal muda de cor. Os cards ganham sombras diferentes. O espaçamento varia entre as páginas. Algumas telas parecem minimalistas; outras ficam carregadas de elementos decorativos.

Isso não significa necessariamente que o modelo falhou. Sem uma referência persistente, o agente volta a tomar decisões visuais a cada interação.

O `DESIGN.md` é uma forma de registrar essa referência dentro do projeto.

## O que é o DESIGN.md

O `DESIGN.md` é um arquivo Markdown com as regras visuais e os princípios de interface de um produto. Ele funciona como memória de design para agentes de IA, desde que as instruções do projeto determinem que o arquivo seja consultado.

Em vez de repetir em cada prompt quais cores, fontes, espaçamentos e componentes devem ser usados, o time registra essas decisões no repositório.

O arquivo pode reunir:

* paleta de cores;
* tipografia;
* escala de espaçamento;
* raios de borda;
* comportamento de botões;
* organização dos cards;
* princípios de layout;
* regras de responsividade;
* estados dos componentes;
* práticas visuais que devem ser evitadas.

O ecossistema do Google Stitch oferece um exemplo público desse fluxo. Um [codelab oficial do Google][1] orienta o agente a buscar um projeto pelo MCP do Stitch, extrair paleta e tipografia e gerar um `DESIGN.md` na raiz do projeto. Isso demonstra um uso possível do arquivo, não a existência de uma especificação universal para seu formato.

## Definir cores não basta

Uma primeira versão de um `DESIGN.md` poderia ser parecida com esta:

```md
---
colors:
  primary: "#F97316"
  background: "#FFFFFF"
  surface: "#F8FAFC"
  text: "#172033"

rounded:
  sm: 4px
  md: 8px
---
```

Isso já reduz algumas escolhas, mas ainda deixa uma dúvida importante: quando cada valor deve ser usado?

O agente conhece a cor primária, porém pode aplicá-la em botões, títulos, ícones, bordas, gráficos e fundos ao mesmo tempo. Tecnicamente, ele respeitou a paleta. Visualmente, pode ter destruído a hierarquia.

Por isso, um `DESIGN.md` útil combina valores objetivos com critérios de uso.

A primeira camada registra códigos de cores, tamanhos de fonte, pesos tipográficos, espaçamentos, larguras, bordas e breakpoints. A segunda explica o significado dessas decisões:

> Use a cor primária apenas em ações principais, estados ativos e elementos que precisam direcionar a atenção.

> Cards operacionais devem priorizar densidade e legibilidade, evitando grandes áreas vazias.

> Não use mais de uma ação primária por seção.

> Evite gradientes decorativos e sombras exageradas.

Essa segunda camada transforma tokens em orientação de design.

## Tokens dizem o valor; o DESIGN.md explica a decisão

Design tokens mantêm valores consistentes no código:

```css
--color-primary: #f97316;
--space-md: 16px;
--radius-md: 8px;
```

Eles não explicam sozinhos como a interface deve se comportar. O `DESIGN.md` pode registrar que a cor primária deve ser usada com moderação, que dashboards precisam de mais densidade do que páginas institucionais e que informações secundárias devem perder contraste visual sem prejudicar a leitura.

O código controla o que será renderizado. O `DESIGN.md` orienta parte das decisões tomadas antes de o código ser escrito.

Essa separação também evita colocar no Markdown uma responsabilidade que pertence à implementação. O arquivo pode dizer que um botão precisa de estados de foco, carregamento e desabilitado. O componente continua sendo a fonte do comportamento real.

## Um exemplo mais completo

Um arquivo inicial para um produto B2B poderia ter esta estrutura:

```md
---
name: BP Stack

colors:
  primary: "#F97316"
  background: "#FFFFFF"
  surface: "#F8FAFC"
  text: "#172033"
  muted: "#64748B"
  border: "#E2E8F0"

typography:
  fontFamily: "Inter, sans-serif"

rounded:
  sm: 4px
  md: 8px
  lg: 12px

spacing:
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
---

# Identidade visual

A interface deve parecer técnica, clara e operacional.

O produto deve transmitir confiabilidade sem parecer excessivamente
corporativo ou burocrático.

## Cores

Use laranja somente para:

- ações principais;
- estados ativos;
- indicadores que exigem atenção.

Não use a cor primária como decoração.

## Layout

Dashboards devem priorizar leitura rápida e boa densidade de informação.

Evite grandes áreas vazias em telas operacionais. Use largura máxima em
páginas de conteúdo; dashboards devem aproveitar melhor a área disponível.

## Cards

Cards devem ter bordas discretas e pouco relevo.

Use sombras somente quando forem necessárias para indicar sobreposição
ou hierarquia.

## Botões

Cada seção deve ter no máximo uma ação primária.

Ações secundárias devem usar menor contraste visual.

## Evitar

- gradientes decorativos;
- excesso de sombras;
- múltiplas cores de destaque;
- textos longos dentro de botões;
- cards dentro de cards sem necessidade;
- ícones meramente decorativos.
```

Esse arquivo não elimina ambiguidades. Ele reduz o espaço de interpretação e oferece critérios para revisar o resultado.

## Um AGENTS.md para a camada visual

Um [`AGENTS.md`](/artigos/agents-md-nao-e-um-readme/)
informa ao agente como trabalhar no repositório: organização dos arquivos,
comandos de validação, padrões de código e limites da alteração.

O `DESIGN.md` cumpre um papel semelhante na camada visual. Ele informa qual linguagem seguir, como priorizar elementos, quais componentes reutilizar e que decisões não devem ser reinventadas.

Os dois arquivos também precisam se conectar. A instrução do repositório pode determinar que qualquer mudança de interface consulte o `DESIGN.md`, reutilize os tokens e componentes existentes e atualize o documento quando uma decisão visual mudar de forma intencional.

Sem essa instrução, o arquivo pode existir e continuar ignorado pelo agente.

## Onde o arquivo entra no fluxo de trabalho

Um fluxo simples pode seguir esta sequência:

1. O time identifica ou extrai os padrões visuais já usados no produto.
2. Registra princípios, restrições e fontes técnicas no `DESIGN.md`.
3. Versiona o arquivo junto com o código.
4. Instrui os agentes a consultá-lo antes de alterar interfaces.
5. Revisa mudanças na linguagem visual junto com a implementação.
6. Atualiza o documento quando uma nova decisão passa a valer para o produto.

O ganho operacional é tirar essas decisões de prompts isolados e do conhecimento informal do time. Uma mudança visual passa a aparecer no histórico do repositório e pode ser discutida no mesmo pull request que altera a interface.

Esse fluxo, porém, só funciona quando o documento descreve o estado real do produto. Uma regra desatualizada pode orientar o agente com a mesma confiança de uma regra correta.

## O que o DESIGN.md não substitui

O `DESIGN.md` não substitui um design system implementado. Ele também não substitui:

* componentes;
* variáveis CSS;
* configuração do Tailwind;
* bibliotecas de interface;
* Storybook;
* arquivos do Figma;
* testes de regressão visual;
* revisão de design;
* validação com usuários.

Um botão documentado em Markdown não garante que todos os botões renderizados serão idênticos. A consistência ainda depende da implementação e da validação.

O papel do arquivo é orientar o agente a encontrar e reutilizar decisões existentes antes de propor outra solução.

## Comece pelos conflitos recorrentes

Tentar documentar todo o design system antes de usar o arquivo tende a produzir um documento longo e difícil de manter. Eu começaria pelos pontos que mais causam inconsistência:

* paleta e uso semântico das cores;
* tipografia;
* espaçamento;
* botões e hierarquia de ações;
* cards;
* layout das páginas;
* responsividade e estados de interação;
* componentes que já devem ser reutilizados;
* práticas proibidas.

Depois, o documento pode evoluir a partir de problemas observados. Se o agente cria sombras demais, registre o critério para usar sombras. Se cada dashboard aparece com uma densidade diferente, documente o princípio de densidade. Se várias ações competem pela atenção, explicite a hierarquia.

Restrições concretas costumam ser mais úteis do que adjetivos. “Interface moderna e limpa” aceita interpretações demais. “Não usar gradientes, não criar um componente quando já existe um equivalente e não colocar mais de uma ação primária no mesmo bloco” elimina decisões incompatíveis com o produto.

## O risco de criar outra fonte de verdade

O projeto pode acabar com versões diferentes da mesma decisão no Figma, no `DESIGN.md`, nos tokens, no Tailwind, nos componentes e nos prompts dos agentes.

Nesse cenário, o arquivo deixa de reduzir inconsistência e cria outra camada de divergência.

Uma divisão possível é:

| Artefato | Responsabilidade |
| --- | --- |
| Figma | Exploração e referência visual |
| Tokens | Valores reutilizáveis |
| Componentes | Aparência e comportamento implementados |
| `DESIGN.md` | Princípios, critérios e instruções para agentes |
| Testes visuais | Verificação do resultado renderizado |

Essa divisão não precisa ser universal. O importante é definir qual artefato prevalece em caso de conflito e fazer o `DESIGN.md` apontar para as fontes técnicas existentes, em vez de copiá-las sem necessidade.

## A memória precisa permanecer verificável

À medida que agentes participam mais da construção de interfaces, gerar código correto deixa de ser o único critério. Eles também precisam reconhecer o produto em que estão trabalhando.

Arquivos como `AGENTS.md`, ADRs e `DESIGN.md` tornam parte desse contexto legível dentro do repositório. O efeito prático não é dar memória permanente ao modelo, mas fornecer uma referência que pode ser consultada e revisada a cada tarefa.

Eu começaria com um arquivo curto, ligado aos tokens e componentes reais, e uma instrução explícita para que o agente o leia antes de modificar a interface. A primeira revisão deve procurar contradições entre documento e código.

Sem essa manutenção, o `DESIGN.md` envelhece como qualquer documentação. Com responsabilidades claras, ele se torna um contrato versionável entre design, produto, engenharia e os agentes que passam a alterar a interface.

[1]: https://codelabs.developers.google.com/design-to-code-with-antigravity-stitch?hl=pt_br "Design para código com Antigravity e Stitch MCP"
