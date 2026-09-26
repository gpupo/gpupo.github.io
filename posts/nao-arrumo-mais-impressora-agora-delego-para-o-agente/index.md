# Não arrumo mais impressora. Agora delego para o agente

Published: 2026-09-23
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/nao-arrumo-mais-impressora-agora-delego-para-o-agente/
Tags: Agentes de IA, Linux, Automação, CUPS, HPLIP, Supervisão humana

---

Minha HP LaserJet Professional P1102w estava instalada no Linux, aparecia na
rede e aceitava documentos na fila. Só não imprimia.

A interface dizia que o equipamento precisava de um driver proprietário. Era o
tipo de problema que normalmente me faria procurar tutoriais, comparar versões,
testar comandos e interromper várias vezes o que eu estava fazendo.

Desta vez, comecei pela intenção:

> Tenho uma HP LaserJet 1102w instalada, mas ela diz que requer driver
> proprietário. Tente enviar uma página de teste.

O agente investigou a fila, reproduziu o erro, encontrou a incompatibilidade,
instalou o componente necessário depois da minha autorização e submeteu um novo
trabalho. Eu continuei responsável pelas decisões que não deveriam ser
automatizadas: conceder privilégio administrativo, aceitar uma licença e
confirmar fisicamente o resultado.

Essa divisão foi mais interessante do que a impressora. Eu não entreguei uma
sequência de comandos ao agente. Entreguei um resultado verificável e acompanhei
os pontos em que ele precisava parar.

## Uma frase virou um procedimento

O agente começou observando o estado existente. Usou
[`lpstat`](https://openprinting.github.io/cups/doc/man-lpstat.html) para consultar
o CUPS, enumerou as filas disponíveis e confirmou que o serviço estava ativo:

```bash
lpstat -t
lpstat -e
systemctl is-active cups
```

A fila `HP-LaserJet-Professional-P-1102w-2` existia, estava ativa, aceitava
trabalhos e era o destino padrão. A impressora também era descoberta na rede por
DNS-SD.

Isso eliminou algumas hipóteses, mas não demonstrava que a cadeia completa de
impressão funcionava. Uma fila configurada não é a mesma coisa que uma página
impressa.

O agente então executou o teste que eu havia pedido. O comando
[`lp`](https://openprinting.github.io/cups/doc/man-lp.html) permite enviar um
arquivo a um destino específico e atribuir um título ao trabalho:

```bash
lp -d HP-LaserJet-Professional-P-1102w-2 \
  -t "Pagina de teste HP LaserJet P1102w" \
  /usr/share/cups/data/testprint
```

O CUPS criou o trabalho 4. Ele entrou na fila e não avançou.

Em vez de tratar isso como um erro genérico de impressora, o agente correlacionou
o estado da fila, o modelo configurado e os logs do serviço. Duas informações
apontavam diretamente para o HPLIP:

```text
printer-make-and-model='HP LaserJet Professional p 1102w,
  hpcups 3.24.4, requires proprietary plugin'
printer-state-reasons=hplip.plugin-error
```

O journal completava o diagnóstico:

```text
unable to open /var/lib/hp/hplip.state: No such file or directory
Plugin version is not matching
m_Job initialization failed with error = 48
```

A conexão com a porta 9100 funcionava, o equipamento era identificado e o
Ghostscript conseguia renderizar o documento. A falha estava depois dessa
renderização, na passagem do raster pelo `hpcups`.

O teste cumpriu uma função importante: transformou “não imprime” numa falha
localizada e reproduzível.

## O agente parou onde precisava da minha decisão

A correção exigia o plugin proprietário correspondente à versão 3.24.4 do
HPLIP. A própria HP mantém um
[catálogo de plugins por versão](https://developers.hp.com/hp-linux-imaging-and-printing/plugins),
incluindo o arquivo e a assinatura usados nesse caso.

Instalar esse componente exigia privilégio administrativo e aceite dos termos
da HP. O agente não deveria presumir nenhuma dessas duas decisões.

Depois que autorizei a correção, ele verificou se havia uma sessão `sudo` já
disponível sem nova interação. Não havia. Como eu estava numa sessão gráfica
Wayland, abriu o diálogo de autenticação do próprio sistema.

Digitei a senha nessa janela. Ela não passou pela conversa, pelo terminal nem
pelo histórico de comandos.

Com a elevação autorizada, o agente executou a ferramenta oficial
`hp-plugin -i`. O instalador baixou o plugin compatível com o HPLIP 3.24.4,
importou a chave digital, verificou a integridade do arquivo e apresentou os
termos da HP. A instalação só continuou depois do meu aceite.

Ao final, o estado local registrava:

```ini
[plugin]
installed = 1
eula = 1
version = 3.24.4
```

O agente fez quase todo o trabalho operacional. Ainda assim, senha, licença e
autorização para uma mudança administrativa continuaram comigo.

## Corrigir não bastava; era preciso repetir o teste

O trabalho 4 havia sido criado enquanto o filtro estava quebrado. Apenas
retomá-lo não produziu uma validação confiável: o CUPS preservava a falha
original daquele processamento.

O agente cancelou somente esse trabalho com
[`cancel`](https://openprinting.github.io/cups/doc/man-cancel.html) e enviou uma
nova página:

```bash
cancel HP-LaserJet-Professional-P-1102w-2-4

lp -d HP-LaserJet-Professional-P-1102w-2 \
  -t "Pagina de teste HP apos plugin" \
  /usr/share/cups/data/testprint
```

O trabalho 5 percorreu estados diferentes dos observados na primeira tentativa:

```text
now printing
Rendering completed
Waiting for printer to finish
idle
```

Em cerca de sete segundos, ele deixou a fila pendente e apareceu entre os
trabalhos concluídos. A impressora voltou ao estado ocioso, sem
`hplip.plugin-error` e sem falha do filtro.

<figure class="editorial-photo">
  <img src="/assets/images/hp-laserjet-p1102w-pronta.webp" alt="Tela de configurações do Linux mostra a HP LaserJet Professional P1102w com status Ready e sem trabalhos ativos." width="950" height="634" loading="lazy" decoding="async">
  <figcaption>A HP LaserJet P1102w novamente pronta e sem trabalhos ativos depois da instalação do plugin.</figcaption>
</figure>

Essa evidência tem um limite. O CUPS demonstrou que processou o documento e o
entregou ao equipamento. Ele não consegue olhar a bandeja. A confirmação final
continuava sendo física: verificar se a folha realmente saiu.

## O que eu deleguei de verdade

Visto de fora, parece que deleguei alguns comandos de Linux. O trabalho mais
útil foi outro: manter o ciclo inteiro coerente.

```text
observar
   ↓
reproduzir
   ↓
localizar
   ↓
pedir autorização
   ↓
corrigir
   ↓
validar
```

O agente coletou estado e logs, reduziu hipóteses, acompanhou trabalhos,
encontrou a ferramenta compatível e verificou a mudança. Eu defini o resultado
esperado e mantive as decisões que exigiam identidade, consentimento ou contato
com o mundo físico.

Essa fronteira evita duas simplificações ruins. A primeira é transformar o
agente num chatbot que apenas devolve um tutorial para eu executar. A segunda é
dar a ele liberdade irrestrita e esperar que todas as decisões sejam
reversíveis ou inofensivas.

Nesse caso, a colaboração teve pausas claras:

- antes de obter privilégio administrativo;
- antes de aceitar uma licença;
- depois que o software esgotou o que podia comprovar sozinho.

Entre essas pausas, havia bastante trabalho que não precisava consumir minha
atenção.

## A intenção pode ser a interface

A frase inicial continha pouca implementação e bastante critério: havia uma
impressora específica, um erro conhecido e um teste que permitiria observar o
resultado.

O agente traduziu essa intenção numa investigação técnica. Consultou o estado
antes de alterar qualquer coisa, reproduziu o problema, pediu autorização no
momento certo e repetiu o teste depois da correção.

Eu não terceirizei a responsabilidade pela impressora. Terceirizei a fricção de
operar cada etapa.

Problemas desse tipo são bons candidatos para delegação porque misturam
diagnóstico, comandos repetitivos, logs e um resultado concreto. O agente pode
percorrer esse caminho com energia. Eu continuo decidindo o que pode mudar,
fornecendo credenciais apenas pela interface apropriada e verificando o que só
uma pessoa diante da máquina consegue verificar.

Não deixei de ser responsável pelo resultado. Deixei de ser o operador de cada
comando necessário para chegar até ele.
