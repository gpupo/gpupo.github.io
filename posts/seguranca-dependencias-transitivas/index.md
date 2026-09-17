# A vulnerabilidade pode estar na dependência que você não declarou

Published: 2026-06-11
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/seguranca-dependencias-transitivas/
Tags: Segurança, Python, Dependências, DevOps, CI/CD

---

Segurança de software não termina no código que escrevemos. Muitas vezes, o risco está em uma dependência transitiva: um pacote que não aparece no arquivo principal, mas entra na aplicação por meio de outra biblioteca.

Em uma auditoria de rotina com `uv audit`, encontrei vulnerabilidades no ecossistema Python. Elas estavam presentes no ambiente de produção, embora não tivessem sido adicionadas diretamente ao `pyproject.toml`.

## A correção não exigiu código novo

O primeiro impulso poderia ser alterar a aplicação. Não era necessário. O ajuste foi atualizar, de forma controlada, as versões resolvidas no lockfile, sincronizar o ambiente e executar novamente as verificações.

O fluxo foi:

1. executar a auditoria e identificar a cadeia afetada;
2. atualizar as dependências transitivas no lockfile;
3. sincronizar o ambiente a partir desse lockfile;
4. executar a auditoria novamente;
5. rodar a suíte de testes;
6. observar o comportamento da aplicação antes de promover a mudança.

Na execução que registrei, 53 pacotes foram analisados, a auditoria terminou sem vulnerabilidades ativas e 199 testes automatizados passaram. Esses números descrevem aquele projeto e aquela execução, não uma garantia para qualquer aplicação Python.

## O lockfile é parte da operação

Um lockfile não é apenas um detalhe de reprodutibilidade. Ele registra a árvore que será instalada e permite revisar a mudança antes de colocá-la em produção. Se cada ambiente resolve dependências de maneira diferente, o resultado da auditoria também fica difícil de interpretar.

Eu trataria a cadeia como um componente do sistema:

- auditoria periódica e também em mudanças relevantes;
- atualização controlada, com diff revisável;
- testes de regressão depois da atualização;
- geração de artefatos reproduzíveis;
- pipeline que impeça promover uma vulnerabilidade conhecida sem uma decisão explícita.

Também vale observar o contexto do alerta. Uma vulnerabilidade em uma biblioteca pode exigir uma configuração específica para ser explorável, mas isso não é motivo para ignorar a atualização. É motivo para documentar o risco e decidir com evidência.

Dependências transitivas não são invisíveis para o sistema. Elas só ficam invisíveis para quem olha apenas os arquivos escritos diretamente pela equipe. Segurança contínua exige olhar para a árvore inteira, automatizar a verificação e validar a aplicação depois da correção.
