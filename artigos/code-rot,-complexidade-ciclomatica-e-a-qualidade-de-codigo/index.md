# Code rot e complexidade ciclomática: o que a métrica mostra e o que ela não mostra

Published: 2023-03-14
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/code-rot,-complexidade-ciclomatica-e-a-qualidade-de-codigo/
Tags: Engenharia de Software, Qualidade, Manutenibilidade

---

Um sistema pode continuar funcionando e, ao mesmo tempo, ficar progressivamente mais difícil de alterar. Uma mudança pequena exige leitura de vários módulos. Um teste quebra longe do ponto modificado. A regra de negócio aparece duplicada e ninguém sabe qual implementação prevalece.

“Code rot” é uma metáfora para esse tipo de deterioração. Ela descreve o efeito percebido, mas não identifica sozinha a causa. Dependências desatualizadas, acoplamento, falta de testes, conhecimento perdido, mudanças frequentes e decisões locais incompatíveis podem produzir sintomas semelhantes.

A complexidade ciclomática ajuda a observar uma parte do problema: quantos caminhos independentes existem no fluxo de controle. Ela não mede toda a qualidade do código.

## O que a complexidade ciclomática mede

Thomas McCabe apresentou a métrica no artigo [A Complexity Measure][1], de 1976. Para um grafo de fluxo de controle, a formulação usa a relação entre arestas, nós e componentes conectados. Em código estruturado, uma aproximação comum para uma função é:

```text
complexidade = 1 + número de pontos de decisão
```

O valor inicial representa o caminho básico. Condições e laços acrescentam alternativas ao fluxo. Detalhes variam entre ferramentas e linguagens: expressões booleanas, comprehensions, tratamento de exceções e `match` podem receber contagens específicas.

Por isso, eu usaria sempre a mesma ferramenta para acompanhar a evolução de um projeto, em vez de comparar números produzidos por analisadores diferentes.

## Corrigindo um exemplo simples

Considere esta função em Python:

```python
def classifica_idade(nome, ano_nascimento, ano_atual):
    idade = ano_atual - ano_nascimento

    if idade >= 18:
        return f"{nome} é maior de idade."

    return f"{nome} é menor de idade."
```

Ela possui um ponto de decisão: o `if`. Pela regra usada pelo [Radon][2], a complexidade ciclomática é **2**:

```text
1 caminho básico + 1 decisão = 2
```

O `else` implícito não acrescenta outra decisão. Chamadas de função e instruções sequenciais também não aumentam a contagem.

A primeira versão deste artigo informava complexidade 3 para um exemplo equivalente. O cálculo estava errado.

## Como a métrica ajuda nos testes

Complexidade 2 indica que existem dois caminhos independentes relevantes para o fluxo: condição verdadeira e condição falsa. Isso oferece uma pista para os testes:

```python
def test_maior_de_idade():
    assert classifica_idade("Ana", 2000, 2026) == "Ana é maior de idade."


def test_menor_de_idade():
    assert classifica_idade("Leo", 2012, 2026) == "Leo é menor de idade."
```

Executar dois testes não prova automaticamente que a função está correta. Ainda há limites de domínio: ano futuro, dados ausentes, datas de aniversário e valores inválidos. A métrica descreve o fluxo implementado, não os requisitos que ficaram fora do código.

Esse é o uso que considero mais sólido: a complexidade ajuda a perguntar se os caminhos de decisão foram exercitados. Ela não substitui análise de domínio nem cobertura baseada em risco.

## Um número alto não determina a decisão

Uma função com muitas ramificações merece atenção, mas o número isolado não diz se ela deve ser dividida.

Um parser, uma máquina de estados ou uma regra tributária pode ter fluxo complexo porque o domínio é complexo. Extrair cada condição para uma função diferente talvez reduza a métrica local e aumente o custo de navegar pelo sistema.

Antes de refatorar, eu verificaria:

* com que frequência o trecho muda;
* quantos defeitos aparecem nessa região;
* se os testes deixam claros os caminhos importantes;
* quanto contexto é necessário para revisar uma alteração;
* se as decisões misturam responsabilidades diferentes;
* se a equipe consegue explicar o comportamento esperado.

A combinação de alta complexidade, mudanças frequentes e falhas recorrentes é um sinal mais útil do que um limite universal aplicado a todo método.

## Complexidade de fluxo não é dificuldade de leitura

Duas funções podem ter a mesma complexidade ciclomática e exigir esforços bem diferentes para compreensão. Nomes ruins, estado compartilhado, efeitos colaterais, chamadas remotas e regras espalhadas aumentam a carga cognitiva sem necessariamente criar novos ramos.

A documentação do [SonarQube distingue complexidade ciclomática de complexidade cognitiva][3]: a primeira conta caminhos no fluxo; a segunda tenta representar a dificuldade de acompanhar esse fluxo. Mesmo essa segunda métrica continua sendo um indicador, não uma avaliação completa feita por quem mantém o código.

Linhas por função também não resolvem o problema. A antiga recomendação de limitar código a uma “caixa” de 80 colunas por 24 linhas mistura restrições históricas de tela com qualidade estrutural. Largura e tamanho podem orientar legibilidade, mas não há base para tratar 80/24 como regra geral de manutenção.

## Um processo prático de revisão

Eu usaria as métricas para reduzir o espaço de investigação:

1. Medir a base com uma ferramenta adequada à linguagem.
2. Identificar funções que combinam complexidade alta e mudança frequente.
3. Ler testes, histórico e incidentes relacionados a esses pontos.
4. Escolher uma alteração pequena e reversível.
5. Confirmar se a mudança melhorou leitura, cobertura ou tempo de manutenção.
6. Evitar reduzir o número quando a refatoração apenas desloca a complexidade.

Em Python, o Radon permite começar pela linha de comando:

```bash
radon cc src/ --show-complexity --average
```

O resultado estabelece uma fotografia do código. Para apoiar uma decisão, ainda precisa ser combinado com contexto de mudança, testes e experiência de manutenção.

## O sinal que merece acompanhamento

Code rot não acontece apenas porque uma função ultrapassou determinado número. Ele aparece quando o sistema perde alinhamento com as mudanças que precisa receber e o custo de compreender, testar e operar cresce.

A complexidade ciclomática ajuda a encontrar fluxos que exigem mais caminhos de teste. Se o objetivo é decidir onde investir em refatoração, eu a combinaria com frequência de mudança, defeitos, cobertura e responsabilidade de domínio.

O número deve iniciar uma investigação. Quando vira meta isolada, a equipe aprende a satisfazer a ferramenta sem necessariamente tornar o software mais fácil de manter.

[1]: https://doi.org/10.1109/TSE.1976.233837 "A Complexity Measure — Thomas J. McCabe"
[2]: https://radon.readthedocs.io/en/stable/intro.html#cyclomatic-complexity "Cyclomatic Complexity — Radon"
[3]: https://docs.sonarsource.com/sonarqube-server/user-guide/code-metrics/metrics-definition "Understanding measures and metrics — SonarQube"
