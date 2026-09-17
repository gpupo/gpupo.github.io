# Usar um agente para ajustar observabilidade com Ansible

Published: 2026-05-20
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/observabilidade-com-agente-e-ansible/
Tags: Observabilidade, IA, Ansible, Grafana, Operações

---

Configurar observabilidade costuma exigir um ciclo cansativo: alterar uma configuração, publicar, acessar a máquina, observar o resultado e repetir. Encontrei um workflow mais rápido ao dar ao agente de IA o Ansible e o projeto, permitindo que ele ajustasse os logs enquanto eu acompanhava o output via SSH.

O agente podia trabalhar na configuração do Alloy, nos dashboards do Grafana e no setup dos aplicativos. A vantagem não estava em permitir qualquer alteração. Estava em reduzir o tempo entre uma hipótese e a evidência no ambiente.

## O ciclo de feedback

Eu organizaria o trabalho assim:

1. descrever o sintoma e o sinal que preciso observar;
2. pedir ao agente uma mudança pequena;
3. executar o playbook em um alvo controlado;
4. acompanhar logs e métricas via SSH;
5. comparar o resultado com a hipótese;
6. manter ou reverter a alteração.

O Ansible é importante porque transforma a mudança em algo repetível. O agente pode propor a alteração, mas a aplicação deveria acontecer por uma definição versionada, com diff e possibilidade de rollback.

## Limites que eu manteria

Dar acesso operacional a um agente sem restrições é uma forma rápida de criar um incidente. Eu começaria com permissões de leitura e coleta. Para alterações, exigiria:

- ambiente de teste ou alvo explicitamente selecionado;
- credenciais com menor privilégio;
- diff antes da execução;
- validação de sintaxe e testes do playbook;
- registro das ações;
- confirmação humana para mudanças de rede, dados ou disponibilidade.

Também separaria o agente que investiga do agente ou operador que aplica. Essa separação reduz a chance de uma interpretação errada virar uma mudança permanente.

## Onde está o ganho

O ganho de tempo aparece no troubleshooting repetitivo: ajustar uma consulta, incluir um campo, corrigir um label ou melhorar um dashboard. O agente consegue fazer várias iterações enquanto o operador observa o efeito.

Isso não substitui conhecimento de observabilidade. Ainda é preciso saber qual sinal representa o comportamento do sistema, distinguir ausência de dados de ausência de problema e evitar dashboards que apenas acumulam gráficos.

Um bom workflow torna a operação mais rápida sem torná-la opaca. Agente para explorar, Ansible para repetir, observabilidade para verificar e uma pessoa para decidir quando a mudança deve ficar.
