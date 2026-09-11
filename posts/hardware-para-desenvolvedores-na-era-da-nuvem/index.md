# O que desenvolvedores perdem quando o hardware desaparece atrás da nuvem

Published: 2024-04-30
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/hardware-para-desenvolvedores-na-era-da-nuvem/
Tags: Infraestrutura, Nuvem, Hardware, Arquitetura

---

No início da minha experiência com Linux, instalar e configurar uma máquina exigia conhecer o hardware. Era preciso entender memória, discos, controladores e limitações do equipamento para conseguir um sistema eficiente.

Hoje, um servidor pode nascer com um comando ou uma chamada de API. A abstração é valiosa: reduz trabalho operacional e permite testar ideias rapidamente. Mas ela também esconde as decisões que continuam existindo por baixo da interface.

## A nuvem ainda é hardware

Uma nuvem não elimina a infraestrutura física. Ela centraliza recursos e oferece abstrações sobre servidores, rede, armazenamento e virtualização. O usuário troca o trabalho de operar cada componente pela responsabilidade de escolher um serviço, pagar por ele e entender seus limites.

Quando uma aplicação precisa de mais memória, a interface pode oferecer um novo tamanho de máquina. Ainda assim, continuam existindo custo de memória, largura de banda, latência, I/O, compartilhamento de recursos e falhas de hardware.

Ignorar esses fatores costuma ser confortável até a primeira fatura inesperada ou a primeira interrupção causada por um recurso compartilhado.

## Perguntas antes de escolher a plataforma

Antes de colocar um sistema na nuvem, eu tentaria responder:

- a carga é estável ou tem picos imprevisíveis;
- o gargalo está em CPU, memória, rede ou armazenamento;
- quanto custa transferir os dados para fora da plataforma;
- qual latência a aplicação suporta;
- o que acontece se uma zona ou um provedor ficar indisponível;
- como os dados e a aplicação serão retirados do serviço;
- a equipe tem conhecimento para operar a alternativa escolhida.

A resposta não precisa ser nuvem ou data center próprio. Servidores dedicados, colocation, laboratório local e uma arquitetura híbrida podem fazer sentido dependendo do padrão de uso.

## Voltar ao fundamento

Não defendo que todo desenvolvedor precise montar um servidor. Defendo que a abstração não substitua o entendimento dos compromissos. Um teste simples em uma máquina antiga pode ensinar mais sobre memória, disco e rede do que uma sequência de telas em um console.

Conhecer a camada física ajuda a interpretar métricas da camada de aplicação. Também ajuda a questionar uma escolha aparentemente conveniente quando o custo, a latência ou a capacidade de recuperação não combinam com o projeto.

Mesmo quando não controlamos o hardware, vale saber em que plataforma o próximo sistema será executado. A nuvem simplifica o acesso. Não simplifica automaticamente a decisão.
