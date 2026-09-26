# Código elegante para quem? Qualidade interna precisa apoiar uma decisão

Published: 2023-06-01
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/code-is-poetry,-platao-e-a-abordagem-centrada-no-cliente/
Tags: Produto, Engenharia de Software

---

“Code is Poetry” funciona como elogio ao cuidado com o código. O problema começa
quando a metáfora substitui critérios: uma solução parece elegante para quem a
escreveu, mas é difícil de alterar, operar ou usar.

Poesia não precisa ser mantida por uma equipe durante anos, responder a
incidentes ou preservar compatibilidade com integrações. Software precisa. A
qualidade do código não pode depender apenas da sensação de beleza de seu autor.

Isso não torna a qualidade interna secundária. Ela protege a capacidade de
entregar e operar o produto. O que muda é a pergunta: **qual decisão de design
reduz um custo ou um risco observável neste sistema?**

## “Limpo” e “elegante” não são critérios suficientes

Duas pessoas experientes podem discordar sobre o código mais legível. Uma pode
preferir uma abstração que remove duplicação; outra pode considerar que a
abstração esconde diferenças importantes. Sem o contexto de mudança, ambas
conseguem defender sua preferência.

Eu avaliaria uma decisão de código por perguntas mais concretas:

- um defeito fica confinado ou se propaga pelo sistema?
- uma regra de negócio pode ser encontrada e alterada em um lugar previsível?
- os testes detectam a mudança de comportamento relevante?
- falhas deixam informação suficiente para diagnóstico?
- dados sensíveis e permissões permanecem explícitos?
- a equipe consegue desfazer ou substituir a decisão?
- o custo de entender a abstração é menor que o custo que ela remove?

Esses critérios ainda exigem julgamento. A diferença é que podem ser conectados
a mudanças, incidentes e restrições reais.

A ISO/IEC 25010:2023 define um modelo com nove características de qualidade para
produtos de tecnologia da informação. O modelo serve como referência para
especificar e avaliar qualidade durante o ciclo de vida, não como uma pontuação
automática para código. Sua existência já expõe o limite da metáfora estética:
qualidade é multidimensional e envolve diferentes interessados. ([ISO/IEC
25010:2023](https://www.iso.org/standard/78176.html))

## Qualidade externa e interna se conectam por um mecanismo

Usuários normalmente não veem a estrutura dos módulos. Eles percebem
disponibilidade, correção, tempo de resposta, segurança e facilidade de concluir
uma tarefa. A equipe percebe tempo para implementar mudanças, dificuldade de
testar e custo de recuperar falhas.

A ligação entre esses níveis precisa ser explicada. Por exemplo:

```text
regra duplicada em três serviços
→ mudança aplicada de forma inconsistente
→ resultados diferentes para a mesma operação
→ retrabalho e erro para o usuário
```

Nesse caso, centralizar a regra pode reduzir uma classe de inconsistência. Mas a
decisão também pode criar acoplamento e um ponto único de falha. “Remover
duplicação” não basta; é preciso comparar as consequências.

Outro exemplo:

```text
integração sem limite de tempo
→ requisição fica presa quando o fornecedor falha
→ recursos se acumulam
→ outras solicitações perdem disponibilidade
```

Aqui, timeout, tratamento de erro e observabilidade apoiam um resultado percebido
pelo usuário. Não são adornos de engenharia.

## O cliente não é a única pessoa afetada

“Foco no cliente” pode ocultar operadores, suporte, pessoas responsáveis por
segurança e usuários indiretos. Uma funcionalidade simples na interface pode
exigir uma operação manual insustentável. Uma automação conveniente pode retirar
da pessoa afetada a possibilidade de contestar um erro.

Eu registraria pelo menos quatro perspectivas:

| Perspectiva | Pergunta de qualidade |
| --- | --- |
| Usuário | consegue atingir o resultado com segurança e compreensão? |
| Operação | o serviço pode ser observado, recuperado e mantido? |
| Engenharia | mudanças permanecem localizadas, testáveis e reversíveis? |
| Pessoas afetadas | erros, exclusões e uso de dados podem ser percebidos e contestados? |

A ISO 25065 trata requisitos de usuário como condições para atingir resultados
pretendidos e como critérios de qualidade relacionados ao uso. A norma não
prescreve um método de desenvolvimento, mas reforça que “atender ao usuário”
precisa ser traduzido em requisitos verificáveis. ([ISO 25065:2019 sobre
requisitos de usuário](https://www.iso.org/standard/72189.html))

## Refatoração precisa de hipótese

Refatorar sem alterar o comportamento observável pode melhorar a estrutura
interna. Ainda assim, o investimento compete por capacidade e merece uma razão
mais precisa que “deixar bonito”.

Um registro possível seria:

```yaml
sintoma: alterações de preço exigem editar três módulos
risco: regras divergentes chegam à produção
hipotese: concentrar a política reduz mudanças incompletas
escopo: regra de preço do canal direto
validacao:
  - testes de caracterizacao preservam o comportamento atual
  - uma nova regra exige alteração em um único módulo
contramedidas:
  - dependência criada entre serviços
  - impacto no tempo de resposta
```

O exemplo é ilustrativo; não relata um projeto real. Ele mostra como ligar uma
intervenção interna a um problema e também registrar seus custos.

Martin Fowler chama de hipótese a ideia de que investir em design preserva a
capacidade de alterar software ao longo do tempo. Ele também reconhece que não
há uma medida objetiva simples para qualidade de design ou produtividade. Essa
limitação é importante: a relação faz sentido como modelo de decisão, mas não
autoriza prometer que toda refatoração produzirá velocidade. ([*Design Stamina
Hypothesis*](https://martinfowler.com/bliki/DesignStaminaHypothesis.html))

## XP e DDD não certificam excelência

A versão anterior deste texto aproximava “Code is Poetry”, Platão, Extreme
Programming e Domain-Driven Design. A associação era construída por semelhanças
de linguagem — excelência, clareza, colaboração — e não por uma relação que
ajudasse a escolher uma prática.

Programação em pares, refatoração, integração contínua e linguagem compartilhada
podem ser úteis. Nenhuma delas garante código bom ou produto valioso. Para cada
prática, eu perguntaria:

- qual problema ela tenta resolver;
- que condição precisa existir para funcionar;
- qual custo introduz;
- que evidência mostrará melhora;
- quando deve ser adaptada ou abandonada.

Programação em pares pode reduzir espera por revisão ou disseminar conhecimento;
também pode consumir atenção sem resolver a principal restrição. Uma linguagem
de domínio pode reduzir traduções ambíguas; também pode cristalizar um modelo que
a equipe ainda não compreende. O nome da abordagem não decide o resultado.

## Use a próxima mudança como teste de qualidade

Métricas estáticas, cobertura e complexidade podem localizar pontos para
investigação. Não substituem a observação do trabalho. Uma maneira prática de
avaliar design é acompanhar mudanças reais:

1. quanto tempo foi gasto para localizar a regra?
2. quantos módulos e equipes precisaram mudar?
3. quais testes falharam pelo motivo esperado?
4. quais efeitos colaterais apareceram?
5. o deploy exigiu intervenção excepcional?
6. o incidente, se ocorreu, pôde ser diagnosticado e revertido?

O histórico de mudanças fornece evidência situada. Ele não permite comparar
qualquer repositório com uma escala universal, mas ajuda a equipe a descobrir
onde seu próprio design cobra juros.

Eu ainda posso chamar um trecho de elegante. Só não usaria esse elogio para
encerrar uma decisão. Se o código deve continuar vivo, a justificativa precisa
mostrar quem conseguirá mudar, operar ou usar o sistema com menos custo e risco.
