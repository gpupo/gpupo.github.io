# Etiquetas e documentos fiscais descartados: quais dados ficam expostos

Published: 2023-03-18
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/o-perigo-das-informacoes-expostas-em-notas-fiscais-e-cupons-fiscais/
Tags: Segurança, Privacidade

---

Uma caixa de encomenda descartada na calçada pode exibir nome e endereço do destinatário, remetente, código de rastreamento e outras informações logísticas. Dependendo da operação, ela também pode trazer um documento auxiliar da nota fiscal.

Esses dados merecem cuidado. O risco, porém, precisa ser descrito com precisão: etiqueta de entrega, documento fiscal, comprovante de pagamento e boleto são objetos diferentes. Uma chave de acesso de nota fiscal não é uma “linha digitável para pagamento”, e encontrar um nome e um CPF não significa que alguém conseguirá automaticamente abrir uma conta bancária.

O problema mais plausível é a **agregação**. Informações aparentemente comuns podem ser combinadas com vazamentos anteriores, perfis públicos e técnicas de engenharia social para tornar uma abordagem fraudulenta mais convincente.

## O que pode aparecer em cada documento

### Etiqueta logística

A etiqueta colada na embalagem costuma identificar remetente e destinatário. Pode conter nome, endereço, código postal, identificadores da entrega, telefone abreviado ou código de barras, conforme a transportadora e o serviço.

Esses elementos ajudam a entregar o pacote. Depois da entrega, porém, deixam de ter utilidade para o consumidor e podem revelar uma relação entre pessoa, endereço, loja e momento aproximado da compra.

### DANFE

O DANFE é o Documento Auxiliar da Nota Fiscal Eletrônica. Ele acompanha a mercadoria e representa informações da NF-e, mas não substitui o arquivo fiscal eletrônico. Essa distinção está no [Manual de Integração do Portal Nacional da NF-e](https://www.nfe.fazenda.gov.br/portal/exibirArquivo.aspx?conteudo=4Cx1qSAOGKA%3D).

O documento contém uma chave de acesso com 44 dígitos. Essa chave é usada na [consulta da NF-e no portal oficial](https://www.nfe.fazenda.gov.br/portal/consultaRecaptcha.aspx), não para realizar um pagamento.

Dependendo do tipo de documento e de como a operação foi emitida, podem aparecer dados do emitente, destinatário, endereço de entrega, produtos e valores. Não se deve presumir que todo DANFE contenha os mesmos campos nem que apresente dados completos de cartão.

### Cupom ou documento auxiliar da NFC-e

O documento entregue ao consumidor no varejo possui regras e formato diferentes dos usados em uma remessa. A identificação do consumidor pode variar conforme a operação e a legislação aplicável.

Antes de descartar, a pergunta prática continua a mesma: o papel permite associar uma pessoa identificável a uma compra, estabelecimento, endereço ou outro dado que ela não gostaria de expor?

### Boleto e comprovante de pagamento

Boletos possuem código de barras ou linha digitável destinados ao pagamento. Comprovantes podem apresentar instituição, valores e partes da transação. Eles exigem atenção própria e não devem ser confundidos com a chave de acesso de uma NF-e.

## O que a exposição permite inferir

Não existe uma relação automática entre encontrar uma etiqueta e executar uma fraude. A informação pode, no entanto, reduzir o trabalho necessário para personalizar um golpe.

Alguns exemplos de inferência são:

- confirmar que uma pessoa mora ou recebe encomendas em determinado endereço;
- identificar uma compra ou uma relação recente com determinada empresa;
- usar remetente, produto ou data para produzir uma mensagem falsa mais crível;
- combinar nome, CPF ou telefone com dados obtidos em outra fonte;
- tentar se passar por loja, transportadora ou instituição financeira.

A [Cartilha de Segurança para Internet do CERT.br](https://cartilha.cert.br/) descreve engenharia social como o uso de persuasão para levar a vítima a fornecer informações ou realizar uma ação. Nesse contexto, o documento descartado pode funcionar como uma peça de contexto, não necessariamente como a credencial que conclui a fraude.

Essa distinção evita dois extremos: ignorar a exposição porque o dado não é uma senha ou afirmar que qualquer etiqueta produz roubo de identidade por si só.

## Como descartar com menos exposição

Para uma pessoa ou família, medidas simples costumam ser suficientes:

1. **Remova a etiqueta da embalagem.** Se não for possível, recorte a área que identifica remetente, destinatário e códigos associados à entrega.
2. **Torne os dados ilegíveis.** Rasgue ou fragmente o papel em mais de um sentido. Apenas riscar um código com caneta pode não ocultá-lo.
3. **Separe informação de material reciclável.** A caixa pode seguir para reciclagem depois que as áreas identificáveis forem removidas.
4. **Verifique os dois lados e os envelopes internos.** Notas, declarações, etiquetas de devolução e comprovantes podem estar dentro da embalagem.
5. **Não publique a etiqueta ao reclamar da entrega.** Antes de enviar uma fotografia para redes sociais ou avaliações públicas, cubra dados pessoais e códigos de rastreamento.
6. **Mantenha somente o necessário.** Se o documento precisar ser guardado para garantia, contabilidade ou obrigação fiscal, armazene-o em local protegido em vez de descartá-lo.

Destruir o papel reduz uma forma de exposição, mas não apaga cópias digitais mantidas por loja, transportadora ou administração tributária.

## O que empresas precisam observar

Para empresas, o problema não se limita ao descarte doméstico. O princípio da necessidade da LGPD orienta que o tratamento seja limitado ao mínimo necessário para a finalidade. Os princípios de segurança e prevenção exigem medidas contra acesso não autorizado e danos. As definições estão reunidas no [Glossário da ANPD](https://www.gov.br/anpd/pt-br/documentos-e-publicacoes/glossario-anpd).

Isso leva a perguntas operacionais:

- todos os campos impressos são necessários para entregar ou identificar a mercadoria?
- um CPF precisa aparecer integralmente ou pode ser mascarado conforme a regra aplicável?
- quem acessa documentos antes do descarte?
- qual é o procedimento para mídias e papéis com dados pessoais?
- fornecedores de logística seguem o mesmo padrão?
- fotografias de pacotes usadas em suporte ocultam dados do cliente?

As respostas dependem das obrigações fiscais, contratuais e logísticas da operação. Este texto não substitui uma análise jurídica ou tributária.

## Se houver indício de fraude

Receber uma mensagem que conhece sua compra não prova que a loja ou transportadora entrou em contato. Confirme a solicitação por um canal oficial obtido de forma independente e não informe senhas ou códigos de verificação.

Se suspeitar de uso indevido de identidade no sistema financeiro, o Banco Central oferece o Registrato para consultar relacionamentos e o [BC PROTEGE+](https://www.bcb.gov.br/meubc), uma camada adicional para impedir novas aberturas ou inclusões em contas enquanto a proteção estiver ativa. O próprio Banco Central ressalta que essa proteção não substitui a verificação de identidade pelas instituições.

Em caso de fraude, registre as evidências, avise rapidamente a instituição envolvida e siga as orientações oficiais. O [CERT.br reúne materiais específicos](https://cartilha.cert.br/fasciculos/) sobre prevenção e resposta a golpes.

## O cuidado deve ser proporcional ao dado

Não é preciso tratar toda caixa como se ela carregasse uma senha bancária. Também não faz sentido deixar nome, endereço, CPF ou informações de compra expostos quando removê-los custa poucos minutos.

A prática mais defensável é identificar o que está visível, distinguir cada tipo de documento e reduzir os dados antes do descarte. O objetivo não é prometer proteção total, mas evitar que uma fonte desnecessária de contexto fique disponível para quem encontrar a embalagem.
