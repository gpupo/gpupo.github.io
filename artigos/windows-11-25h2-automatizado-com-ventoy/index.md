# Como automatizei duas instalações do Windows 11 25H2 com Ventoy

Published: 2026-08-05
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/artigos/windows-11-25h2-automatizado-com-ventoy/
Tags: Windows, Ventoy, Automação, Hardware, Instalação

---

Eu precisava preparar duas instalações do Windows 11 25H2 para o mesmo pendrive: uma em português do Brasil, com teclado ABNT2, e outra em inglês dos Estados Unidos, com teclado US.

Também queria reduzir as decisões feitas durante a instalação. O computador deveria criar somente um usuário local, aplicar idioma e região corretos, configurar o teclado e evitar a etapa obrigatória de criação de uma conta Microsoft. A meta não era criar uma ISO personalizada para distribuição. Era tornar repetível uma instalação que eu provavelmente teria de refazer.

A solução final usou as imagens oficiais intactas, o Ventoy e dois arquivos `autounattend.xml` selecionados automaticamente de acordo com a ISO escolhida.

## O problema não era apenas gravar uma ISO

Gravar uma imagem no pendrive é simples. O trabalho começa quando existem duas variantes e cada uma precisa de uma configuração diferente.

Eu queria que a escolha da ISO determinasse também:

- o idioma da instalação;
- o layout do teclado;
- a região do sistema;
- o usuário local criado no primeiro início;
- as etapas automáticas do instalador.

Fazer isso manualmente a cada instalação aumentaria a chance de escolher o XML errado ou esquecer uma etapa. Embutir o XML diretamente em cada ISO parecia uma forma de deixar o artefato completo, mas criava outro problema: eu teria de reconstruir e validar uma mídia de instalação que já funcionava.

## A tentativa com `xorriso` não preservou a imagem

Minha primeira tentativa foi criar novas ISOs com o arquivo de instalação automatizada embutido usando `xorriso`.

O processo falhou porque as imagens oficiais do Windows 11 25H2 usam estruturas de boot El Torito que não foram preservadas corretamente na reconstrução. A ISO resultante deixava de ser um artefato confiável para inicialização.

Esse erro mudou a decisão. Em vez de insistir em modificar a ISO, passei a separar a mídia original da configuração que a acompanha.

## A decisão: manter a ISO oficial e mover a automação para o Ventoy

O Ventoy já era responsável pelo menu de inicialização do pendrive. O plugin `auto_install` permitia associar cada ISO a um arquivo de resposta sem alterar o conteúdo original da imagem.

A configuração ficou dividida em três partes:

1. as ISOs oficiais, mantidas sem alterações;
2. um `ventoy.json`, que faz a associação entre imagem e template;
3. dois arquivos `autounattend.xml`, um para cada idioma e teclado.

Essa separação tornou o experimento mais fácil de entender e de reverter. Se uma configuração estivesse errada, eu poderia corrigir o XML sem reconstruir a ISO.

## A estrutura do pendrive

A estrutura final ficou assim:

```text
Ventoy/
├── ISO/
│   └── Windows/
│       ├── Win11_25H2_BrazilianPortuguese_x64_v2.iso
│       └── Win11_25H2_English_x64_v2.iso
└── ventoy/
    ├── ventoy.json
    └── scripts/
        ├── autounattend-25H2-en-US-Admin.xml
        └── autounattend-25H2-pt-BR-Admin.xml
```

O mapeamento era explícito:

| Imagem selecionada | Arquivo de resposta |
| --- | --- |
| Windows 11 25H2 em português | `autounattend-25H2-pt-BR-Admin.xml` |
| Windows 11 25H2 em inglês | `autounattend-25H2-en-US-Admin.xml` |

O [`ventoy.json`](https://www.ventoy.net/en/plugin_autoinstall.html) continha as
duas associações:

```json
{
  "auto_install": [
    {
      "image": "/ISO/Windows/Win11_25H2_BrazilianPortuguese_x64_v2.iso",
      "template": "/ventoy/scripts/autounattend-25H2-pt-BR-Admin.xml",
      "autosel": 1
    },
    {
      "image": "/ISO/Windows/Win11_25H2_English_x64_v2.iso",
      "template": "/ventoy/scripts/autounattend-25H2-en-US-Admin.xml",
      "autosel": 1
    }
  ]
}
```

Ao selecionar uma imagem no menu do Ventoy, o arquivo correspondente era aplicado pelo instalador.

## O que ficou automatizado

Os arquivos `autounattend.xml` foram ajustados para o contexto dessa máquina:

- criar somente o usuário local `Admin`;
- remover o usuário que vinha na configuração anterior;
- fazer o primeiro login automaticamente;
- aplicar idioma e região;
- escolher ABNT2 para a instalação em português;
- escolher teclado US para a instalação em inglês;
- evitar a criação obrigatória de uma conta Microsoft durante esse fluxo.

O objetivo era automatizar o caminho inicial, não transformar o XML em uma política universal para qualquer computador. Nome de usuário, idioma, drivers e etapas do instalador dependem da máquina e da versão da mídia.

> [!warning] Configuração de laboratório
> A instalação usava uma credencial inicial simples para permitir o primeiro acesso. Em uma máquina de uso real, eu substituiria essa credencial imediatamente, removeria o login automático e evitaria deixar uma senha reutilizável dentro do XML ou do pendrive.

## O que eu validei antes de remover o pendrive

A validação foi feita em duas etapas.

Primeiro, conferi se o Ventoy mostrava as duas imagens e se cada seleção apontava para o XML esperado. Depois, executei as instalações e confirmei idioma, teclado, usuário local e primeiro login.

Antes de remover o pendrive, executei:

```bash
sync
```

O comando força a gravação dos dados ainda mantidos em cache. Em uma mídia usada para reinstalar sistemas, essa última etapa é pequena, mas evita remover o dispositivo antes de o sistema terminar de escrever os arquivos.

## O que essa experiência ensinou

A primeira lição foi evitar editar artefatos complexos quando existe uma camada de configuração externa. A ISO oficial já carregava uma estrutura de boot válida. Modificá-la aumentou o risco sem resolver um problema que o Ventoy conseguia tratar por fora.

A segunda foi separar conteúdo de comportamento:

- a ISO contém o instalador;
- o Ventoy escolhe a imagem;
- o `ventoy.json` define a associação;
- o `autounattend.xml` descreve as decisões da instalação.

Essa divisão também facilita o diagnóstico. Se o boot falha, olho para a ISO ou para o Ventoy. Se o instalador escolhe idioma ou teclado errado, olho para o XML. Se o arquivo aplicado não é o esperado, olho para o mapeamento.

Por fim, automação de instalação não elimina decisões de segurança. Ela apenas as torna mais fáceis de repetir. Uma conta local, login automático e credencial inicial podem ser úteis em um ambiente de teste, mas precisam ser removidos ou substituídos antes de entregar a máquina para uso cotidiano.

## O que eu faria em uma próxima versão

Eu adicionaria três verificações ao processo:

1. calcular e registrar o hash das ISOs antes de copiá-las;
2. manter uma cópia versionada dos XMLs e do `ventoy.json` fora do pendrive;
3. testar cada combinação de idioma, teclado e hardware em uma máquina limpa antes de usar a mídia em produção.

Também documentaria quais etapas são específicas do Windows 11 25H2. Arquivos de resposta dependem da versão da mídia e podem exigir revisão quando o instalador mudar.

## Conclusão

O resultado foi um pendrive com duas instalações automatizadas do Windows 11 25H2, sem reconstruir as ISOs oficiais. A parte mais importante não foi o comando do Ventoy, mas a decisão de manter cada responsabilidade no lugar certo.

Quando a mídia original já funciona, eu começaria procurando uma forma de acoplar a automação ao processo de boot. Só modificaria a ISO depois de confirmar que a camada externa não atende ao caso.
