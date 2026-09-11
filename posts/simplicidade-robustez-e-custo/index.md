# Simplicidade, robustez e custo: três critérios para a arquitetura

Published: 2025-08-04
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/simplicidade-robustez-e-custo/
Tags: Arquitetura, Infraestrutura, Custos, Operações

---

Microsserviços, serverless, Big Data e web-scale podem ser escolhas excelentes. O problema começa quando a tecnologia vira pré-requisito para parecer que um sistema é importante.

Antes de escolher uma arquitetura, eu tentaria equilibrar três critérios: simplicidade, robustez e custo. Eles não produzem a mesma resposta para todos os projetos, mas ajudam a tornar a decisão explícita.

## Simplicidade reduz o custo de mudança

Complexidade acidental é aquela que não pertence ao problema original, mas foi criada pela solução. Cada serviço, fila, protocolo e integração adiciona contexto que alguém precisará entender, testar e operar.

Uma arquitetura simples reduz o tempo para uma pessoa nova contribuir, facilita diagnosticar uma falha e diminui a quantidade de lugares que precisam ser alterados para uma mudança pequena.

Antes de adicionar uma tecnologia, a pergunta que eu faria é: “isso torna o sistema fundamentalmente mais simples no longo prazo?”. Se a resposta depende de uma promessa difícil de medir, o custo já merece ser tratado como risco.

## Robustez não é ausência de falhas

Um sistema robusto não é aquele que nunca falha. É aquele em que as falhas são compreendidas, detectadas e contidas.

Quanto mais componentes e conexões existem, mais combinações de falha aparecem. Um monólito bem testado e operado em uma máquina pode ter comportamento mais previsível do que dezenas de serviços distribuídos que a equipe não domina.

Eu observaria:

- como uma dependência indisponível afeta o fluxo;
- se uma operação pode ser repetida sem duplicar efeitos;
- como o sistema retorna a um estado conhecido;
- quem recebe o alerta e sabe agir;
- qual parte continua funcionando durante a falha.

## A infraestrutura também é uma decisão de produto

A nuvem é valiosa quando elasticidade, serviços gerenciados ou variabilidade de uso compensam o preço. Para uma carga estável e intensa, um servidor dedicado pode ser mais previsível. Colocation ou uma arquitetura híbrida também podem ser alternativas.

Não é uma decisão entre “nuvem” e “servidor próprio” para sempre. É uma comparação do custo total, incluindo operação, transferência de dados, disponibilidade, conhecimento da equipe e esforço para mudar de plataforma.

Quando os trade-offs também envolvem domínio, estrutura de times e objetivos de negócio, o trabalho de [Software Strategy da BP STRAT](https://www.bpstrat.com.br/servicos/software-strategy.html) conecta essas decisões à evolução técnica do sistema.

Simplicidade, robustez e custo nem sempre avançam na mesma direção. Redundância
pode aumentar robustez e custo; um serviço gerenciado pode reduzir trabalho
operacional e aumentar preço ou dependência. A arquitetura que eu escolheria é
a que torna esses conflitos explícitos para o contexto real, mesmo quando não é
a opção mais nova.
