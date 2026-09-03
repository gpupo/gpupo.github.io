# Limites de Contexto e Custos

Published: 2026-04-25
Author: Gilmar Pupo
Canonical: https://www.gpupo.com/notas/2026-04-25-limites-de-contexto-e-custos/

---

Trabalhando com LLMs em produção esse trimestre, algo ficou muito claro: modelos como Opus e Gemini 2.5 Pro têm um "cliff" de preço após ~200K tokens de input, onde o custo pode dobrar. Desenvolvi uma extensão pro meu Pi Coding Agent que alerta quando a sessão cruza esse limiar. Ter visibilidade em tempo real do tamanho do contexto ajuda a decidir quando compactar ou reiniciar a sessão. #LLM #CloudCost
