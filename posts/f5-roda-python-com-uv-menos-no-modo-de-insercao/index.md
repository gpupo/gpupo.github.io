# Neovim: o mesmo F5 usa uv em um modo e python3 em outro

Published: 2026-08-25
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/f5-roda-python-com-uv-menos-no-modo-de-insercao/
Tags: Neovim, Python, uv, Floaterm, Automação

---

No meu Neovim, `F5` salva o arquivo Python e abre um terminal flutuante para
executá-lo. É um atalho pequeno para o ciclo editar, rodar, ler a saída e voltar
ao código.

O mapeamento atual, porém, não executa a mesma coisa em todos os modos:

```lua
vim.api.nvim_set_keymap(
  'n',
  '<F5>',
  ':w<CR>:FloatermNew --autoclose=0 uv run %<CR>',
  { noremap = true, silent = true }
)

vim.api.nvim_set_keymap(
  'i',
  '<F5>',
  '<ESC>:w<CR>:FloatermNew --autoclose=0 python3 %<CR>',
  { noremap = true, silent = true }
)
```

No modo normal, roda `uv run %`. No modo de inserção, sai para o modo normal,
salva e roda `python3 %`.

Eu poderia limpar a história e mostrar apenas o primeiro caso. A diferença é
justamente a parte mais útil deste registro.

## O que o atalho resolve

O símbolo `%` é expandido pelo Vim para o arquivo atual. O
[Floaterm](https://github.com/voldikss/vim-floaterm) documenta
`FloatermNew` como o comando que abre uma instância de terminal e aceita um
comando externo. A opção `--autoclose=0` mantém a janela aberta depois que o
processo termina, preservando saída e erros.

O atalho só é criado no evento `FileType` para Python. Para outros tipos de
arquivo, `F5` não recebe esse comportamento por este módulo.

No caminho com uv, a [documentação
oficial](https://docs.astral.sh/uv/guides/scripts/) explica que `uv run
arquivo.py` executa um script num ambiente Python e pode resolver dependências
declaradas no próprio arquivo. Dentro de um projeto, `uv run` usa o ambiente do
projeto e verifica se ele está atualizado antes de executar.

Isso torna o atalho mais interessante do que chamar um interpretador global:
o contexto do projeto ou os metadados do script participam da execução.

## A diferença entre os modos não é cosmética

Se o script depende de pacotes disponíveis apenas no ambiente gerido por uv,
pressionar a mesma tecla pode funcionar no modo normal e falhar no modo de
inserção com `ModuleNotFoundError`. Também pode escolher versões distintas do
Python ou das dependências.

O editor não mostra essa diferença antes da execução. A tecla e a ação visível
são iguais: salvar e rodar. O contrato escondido muda conforme o estado modal
do Neovim.

Não encontrei na fonte uma justificativa para manter `python3` como fallback.
Talvez tenha sido um estágio anterior da configuração. Talvez fosse intencional
para scripts sem projeto. Sem registro, qualquer explicação causal seria
inventada.

## A correção provável é menor que um novo plugin

Se a intenção atual for sempre respeitar uv, os dois mapeamentos podem chamar o
mesmo comando. Uma pequena função evita que futuras mudanças voltem a divergir:

```lua
local function run_python_file()
  vim.cmd.write()
  vim.cmd('FloatermNew --autoclose=0 uv run %')
end

vim.keymap.set('n', '<F5>', run_python_file, { silent = true })
vim.keymap.set('i', '<F5>', function()
  vim.cmd.stopinsert()
  run_python_file()
end, { silent = true })
```

Esse trecho é uma proposta, não a configuração aplicada durante este relato.
Antes de adotá-lo, eu verificaria como `stopinsert()` se comporta na versão do
Neovim usada e se o diretório de trabalho do Floaterm corresponde ao projeto
esperado.

Também há casos em que `uv run %` não deve descobrir o projeto pai. A
documentação oferece `--no-project` para scripts que precisam ser executados
fora daquele ambiente. O atalho atual escolhe descoberta automática, o que é
conveniente para meu fluxo, mas não universal.

Esse F5 não substitui testes, lint, CI nem um comando documentado no projeto. Ele
reduz o atrito de uma execução local e deixa o erro visível num terminal que não
fecha.

É também um bom exemplo de como automações pequenas acumulam contratos. “Rodar
o arquivo” envolve salvar, escolher interpretador, descobrir ambiente, instalar
ou sincronizar dependências, definir diretório e preservar a saída. Duas linhas
quase idênticas conseguiram discordar num desses contratos.

O próximo ajuste não é adicionar mais uma camada ao editor. É decidir se a
diferença entre `uv` e `python3` ainda tem propósito. Se não tiver, a melhor
documentação será fazer os dois modos executarem exatamente a mesma função.
