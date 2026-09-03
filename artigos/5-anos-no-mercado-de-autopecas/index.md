# Cinco anos em autopeças: o catálogo era parte do produto

Published: 2023-03-09
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/5-anos-no-mercado-de-autopecas/
Tags: Empreendedorismo, Varejo

---

Cinco anos antes da publicação deste texto, Ricardo Cabianca e eu fundamos a
NVPC. A empresa começou com a proposta de aplicar inteligência, gestão e
tecnologia ao varejo on-line do segmento automotivo, inicialmente em
autopeças.

Entramos nesse mercado com pouca experiência no domínio. Por isso, antes de
pensar em uma plataforma, tivemos de responder a uma pergunta básica: **o que
precisávamos saber sobre uma peça para representá-la corretamente?**

Essa pergunta mudou o foco do trabalho. Uma autopeça não é apenas um nome, uma
foto e um preço. Sua identidade depende de atributos técnicos, códigos,
fabricante, aplicação em veículos, relações com peças equivalentes e condições
comerciais. Se esses dados forem imprecisos, uma interface bem construída apenas
apresentará o erro com mais eficiência.

## O que aprendemos sobre o objeto

No trabalho de exploração do domínio, algumas dimensões apareceram de forma
recorrente:

- **identidade:** código da peça, marca, fabricante e referências equivalentes;
- **classificação:** categoria e posição na hierarquia do catálogo;
- **aplicação:** veículos, versões, motores, anos e eventuais restrições;
- **especificação:** medidas, materiais e demais atributos técnicos;
- **comercialização:** preço, disponibilidade, embalagem e garantia;
- **logística:** peso, dimensões e condições de transporte;
- **proveniência:** origem de cada dado e momento da última atualização.

Essa lista é uma síntese do problema, não um modelo universal. Categorias
diferentes exigem atributos diferentes, e o significado de uma aplicação
precisa ser validado com quem conhece a peça e o veículo.

## Compatibilidade e descrição são problemas distintos

Uma das distinções mais úteis é separar a descrição do produto de sua aplicação.

A descrição responde perguntas como “qual é a marca?”, “quais são as medidas?”
e “o que acompanha a embalagem?”. A aplicação responde “em quais veículos e
configurações esta peça pode ser usada?”. Misturar as duas coisas em um campo de
texto dificulta busca, comparação, atualização e validação.

Existem referências de mercado que tornam essa separação explícita. A Auto Care
Association mantém o [PIES](https://www.autocare.org/pies) para comunicação de
informações de produto e o [ACES](https://www.autocare.org/aces) para dados de
aplicação. São padrões do mercado de reposição automotiva com origem e adoção
predominante na América do Norte; portanto, devem ser avaliados antes de qualquer
uso no contexto brasileiro. A menção aqui serve como exemplo externo de
modelagem, não como registro de que os adotamos na NVPC.

## Schema.org não é um catálogo interno

O texto original indicava `AutomotiveBusiness`, do Schema.org, como referência
para compreender uma peça. Essa indicação era imprecisa: o tipo
[`AutomotiveBusiness`](https://schema.org/AutomotiveBusiness) descreve um
negócio automotivo, não uma autopeça.

O tipo [`Product`](https://schema.org/Product) é uma referência mais adequada
para publicar dados estruturados de produto na web. Ainda assim, ele não
substitui o modelo interno de um catálogo automotivo. A aplicação em veículos,
as regras de equivalência, o histórico das fontes e as validações do negócio
continuam exigindo estruturas próprias ou padrões especializados.

## O catálogo precisa registrar incerteza

No início, é tentador tratar todo dado recebido como verdadeiro. Na prática,
fontes podem divergir, códigos podem ser reutilizados e descrições podem chegar
incompletas. Um catálogo precisa permitir que o time responda:

1. De onde veio este atributo?
2. Quando ele foi atualizado?
3. Quem o validou?
4. Há outra fonte em conflito?
5. Qual decisão deve ser revista se o dado mudar?

Essa rastreabilidade é tão importante quanto o valor do atributo. Sem ela, a
correção de um erro vira investigação manual em planilhas, integrações e
mensagens antigas.

## Uma forma prática de começar

Minha recomendação para quem entra em um domínio técnico é começar com poucos
casos reais e acompanhar o dado de ponta a ponta:

1. selecione uma categoria de peças;
2. reúna amostras de fontes diferentes;
3. identifique os atributos necessários para distinguir os itens;
4. modele separadamente produto, aplicação e oferta;
5. registre a origem de cada informação;
6. valide o modelo com especialistas do domínio;
7. só então amplie a cobertura do catálogo.

Essa sequência reduz uma classe comum de erro: criar primeiro uma taxonomia
elegante e descobrir depois que ela não representa as decisões reais de compra,
venda e compatibilidade.

## Limites deste relato

Este é um registro retrospectivo do aprendizado descrito no texto publicado em
2023. O material original não apresenta métricas de catálogo, conversão,
devolução ou economia para clientes. Por isso, não uso esses resultados como
evidência de sucesso e não tento atribuir ao trabalho um impacto que não foi
documentado.

A conclusão que consigo sustentar é mais restrita: entrar no mercado de
autopeças exigiu aprender primeiro a representar a peça. A plataforma vinha
depois. Em produtos orientados por dados, compreender o objeto do domínio não é
uma etapa preparatória; é parte da construção do próprio produto.
