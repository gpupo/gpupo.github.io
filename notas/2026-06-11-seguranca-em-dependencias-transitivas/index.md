# Segurança em dependências transitivas

Published: 2026-06-11
Author: Gilmar Pupo
Canonical: https://www.gpupo.com/notas/2026-06-11-seguranca-em-dependencias-transitivas/

---

Segurança não é só o código que a gente escreve. Numa auditoria de rotina (`uv audit`), achamos vulnerabilidades críticas em dependências transitivas (como `idna` e `starlette`). Nenhuma estava declarada diretamente no projeto, mas iam pra produção. A correção? Atualização controlada no lockfile, sincronização e re-teste. Segurança também é disciplina operacional.
