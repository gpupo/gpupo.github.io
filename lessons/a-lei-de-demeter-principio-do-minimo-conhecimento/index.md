# Lei de Demeter: reduza conhecimento estrutural sem criar intermediários inúteis

Published: 2023-05-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/lessons/a-lei-de-demeter-principio-do-minimo-conhecimento/
Tags: Gists, Engenharia de Software

---

Gist ID: `6385b8d4e27b6fb5a8bf919f44bce296`

Uma linha como `order.customer.address.country.code` revela que o código conhece
várias decisões estruturais. Se `address` mudar, mesmo quem só precisava tomar
uma decisão sobre entrega pode precisar mudar também.

A Lei de Demeter ajuda a localizar esse tipo de acoplamento. Ela não proíbe
pontos, getters ou cadeias em qualquer contexto. Sua pergunta é mais útil:
**este módulo sabe mais sobre a estrutura interna de outro objeto do que precisa
para cumprir sua responsabilidade?**

## O que a lei propõe

A formulação original foi apresentada no projeto Demeter no fim dos anos 1980
como uma regra independente de linguagem para favorecer encapsulamento e
modularidade. Para um método, a versão orientada a objetos limita a comunicação,
em linhas gerais, a:

- o próprio objeto;
- objetos recebidos como parâmetros;
- objetos criados pelo método;
- componentes diretos do próprio objeto.

O trabalho original também discute benefícios esperados, não uma garantia de
que qualquer programa que siga a regra terá bom design. ([artigo original do
projeto Demeter, OOPSLA 1988](https://www2.ccs.neu.edu/research/demeter/papers/law-of-demeter/oopsla88-law-of-demeter.pdf))

A forma curta — “fale apenas com amigos próximos” — é fácil de lembrar. O risco
é transformá-la na “regra de um ponto”.

```javascript
const normalized = input.trim().toLowerCase();
```

Essa linha possui duas chamadas encadeadas, mas opera sobre valores e contratos
estáveis da linguagem. Contar pontos não mede, por si só, o acoplamento que
importa no domínio.

## O problema é conhecer a estrutura e controlar o estado alheio

Considere uma cobrança escrita desta forma:

```javascript
class Collector {
  collect(customer, amount) {
    if (customer.wallet.balance < amount) {
      return false;
    }

    customer.wallet.balance -= amount;
    return true;
  }
}
```

O coletor conhece onde o saldo fica e como alterá-lo. Também consegue produzir
um saldo inválido se outra chamada modificar o estado entre a verificação e a
atribuição. Qualquer mudança em `Customer` ou `Wallet` pode alcançar esse código.

A cadeia `customer.wallet.balance` expõe só parte do problema. A responsabilidade
de validar e retirar dinheiro ficou fora do objeto que precisa preservar esse
estado.

## Refatore em torno do comportamento

Uma alternativa é pedir o pagamento ao cliente e deixar a carteira proteger sua
invariante:

```javascript
const assert = require("node:assert/strict");

class Wallet {
  #balance;

  constructor(initialBalance) {
    if (!Number.isFinite(initialBalance) || initialBalance < 0) {
      throw new TypeError("initialBalance deve ser um número não negativo");
    }

    this.#balance = initialBalance;
  }

  withdraw(amount) {
    if (!Number.isFinite(amount) || amount <= 0) {
      throw new TypeError("amount deve ser um número positivo");
    }

    if (amount > this.#balance) {
      return false;
    }

    this.#balance -= amount;
    return true;
  }
}

class Customer {
  #wallet;

  constructor(wallet) {
    this.#wallet = wallet;
  }

  pay(amount) {
    return this.#wallet.withdraw(amount);
  }
}

class Collector {
  collect(customer, amount) {
    return customer.pay(amount);
  }
}

const customer = new Customer(new Wallet(20));
const collector = new Collector();

assert.equal(collector.collect(customer, 7), true);
assert.equal(collector.collect(customer, 14), false);
assert.throws(() => collector.collect(customer, -1), TypeError);

console.log("Exemplo validado");
```

Agora:

- `Collector` conhece o contrato de `Customer`, não sua composição;
- `Customer` coordena seu componente direto;
- `Wallet` valida e altera o próprio saldo;
- o campo privado impede alteração direta por outros objetos.

O exemplo usa campos privados de classes JavaScript e o módulo de asserção do
Node.js. Ele pode ser executado com uma versão atual do Node:

```bash
node demeter.js
```

O teste cobre três comportamentos, mas não prova que o desenho servirá a um
sistema de pagamentos real. Concorrência, persistência, moeda e idempotência não
estão representadas.

## Encapsular navegação não basta

Mover uma cadeia para outro método pode apenas esconder o mesmo acoplamento:

```javascript
class Order {
  countryCode() {
    return this.customer.address.country.code;
  }
}
```

O chamador conhece menos detalhes, o que pode reduzir o alcance de uma mudança.
Mas `Order` ainda conhece toda a estrutura e talvez tenha recebido uma
responsabilidade que não lhe pertence.

Antes de criar o método, eu perguntaria:

1. qual comportamento o chamador realmente quer executar?
2. qual objeto possui os dados e as invariantes necessários?
3. a nova interface expressa uma decisão do domínio ou apenas repassa acesso?
4. quantos chamadores serão protegidos de uma mudança provável?

Se não há comportamento para encapsular, um objeto de dados explícito pode ser
mais honesto do que uma sequência de métodos intermediários.

## APIs fluentes e estruturas de dados exigem outro julgamento

Builders, consultas e pipelines frequentemente são desenhados para
encadeamento:

```javascript
query.where("active", true).orderBy("created_at").limit(20);
```

Nesse caso, cada método retorna uma interface feita para continuar a composição.
Classificar toda API fluente como infração produziria pouco valor.

O mesmo vale para dados na borda do sistema. Ler um DTO recebido de uma API não
é igual a navegar pelo modelo interno, embora uma cadeia longa ainda possa
indicar fragilidade diante de campos ausentes. Validação de esquema e tradução
na fronteira costumam ser intervenções mais adequadas do que adicionar métodos a
cada nível.

Até a documentação mantida pelo projeto Demeter apresenta a lei como uma
diretriz de design e lista os tipos de objetos com os quais um método deve se
comunicar. Essa formulação é melhor que uma inspeção puramente sintática.
([página do projeto sobre a Lei de
Demeter](https://www2.ccs.neu.edu/research/demeter/demeter-method/LawOfDemeter/LawOfDemeter.htm))

## Quando eu usaria a Lei de Demeter

Eu a usaria como sinal de investigação quando:

- uma mudança estrutural quebra chamadores distantes;
- regras alteram estado interno por caminhos diferentes;
- testes precisam montar grafos grandes para alcançar um comportamento pequeno;
- o código conhece detalhes de bibliotecas que deveriam ficar atrás de um
  adaptador;
- uma cadeia atravessa limites de domínio ou de equipe.

Depois da refatoração, procuraria evidência na próxima mudança: menos módulos
afetados, invariantes protegidas e testes menores. Se o resultado for apenas uma
coleção de métodos que repassam chamadas, o custo de navegação mudou de forma,
mas talvez não tenha diminuído.

A Lei de Demeter é útil porque torna conhecimento estrutural visível. Ela deixa
de ajudar quando vira contagem de pontos ou justificativa automática para mais
camadas.
