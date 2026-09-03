# O novo scaffolding dos LLMs é feito de restrições

Published: 2026-04-16
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/scaffolding-de-restricoes-para-llms/
Tags: LLM, IA, Desenvolvimento, Engenharia, Qualidade

---

No desenvolvimento tradicional, scaffolding costuma significar criar a estrutura inicial de uma aplicação. Nos workflows com LLMs, a estrutura que mais importa pode ser outra: limitar o espaço de solução para que o modelo não invente além do necessário.

Essa mudança nasceu de um problema prático. A mesma capacidade que permite ao modelo encontrar uma abordagem nova também pode produzir uma alteração inesperada, uma dependência desnecessária ou uma afirmação sem base.

## Restrição não é falta de capacidade

Um workflow confiável explicita:

- quais arquivos podem ser alterados;
- quais ferramentas estão disponíveis;
- qual formato a saída precisa ter;
- quais padrões de arquitetura devem ser preservados;
- quais comandos validam a conclusão;
- quando o agente deve parar e pedir ajuda.

Templates, `AGENTS.md`, schemas, testes e comandos de validação formam uma espécie de trilho. O modelo continua podendo raciocinar, mas não precisa redescobrir a estrutura inteira do projeto a cada tarefa.

## O risco de restringir demais

Previsibilidade tem valor, especialmente em ambiente corporativo. Mas uma organização que transforma toda tarefa em uma sequência rígida pode perder a possibilidade de encontrar uma solução melhor.

Eu separaria dois modos de trabalho. No modo exploratório, o agente pode propor alternativas e expor incertezas. No modo de execução, a solução precisa respeitar contratos, permissões e testes. Misturar os dois faz a equipe exigir criatividade quando precisa de consistência, ou bloquear descoberta quando ainda não conhece o problema.

Também existe um risco de longo prazo: se o time aceitar todas as sugestões filtradas por templates sem entender o motivo das restrições, perde repertório para reconhecer uma exceção importante. A automação ajuda a padronizar, mas não substitui a formação técnica.

## Um ciclo que eu usaria

1. explorar possibilidades com limites claros;
2. escolher uma abordagem e registrar as premissas;
3. transformar a decisão em template, teste ou regra;
4. executar com ferramentas limitadas;
5. revisar os casos em que o padrão não foi suficiente.

O objetivo não é remover toda novidade. É decidir onde ela é desejada e onde
representa risco. Para esse tipo de fluxo, restrições bem desenhadas podem
reduzir retrabalho, enquanto um espaço exploratório permite questionar o padrão
quando o problema ainda não está bem definido.
