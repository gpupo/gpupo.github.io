# Tocando em linha com a Ampero One: quando usar AMP e CAB/IR?

Published: 2026-10-21
Author: Gilmar Pupo
Editorial: equipamento
Content type: essay
Canonical: https://www.gpupo.com/equipamento-musical/tocando-em-linha-amp-cab-ir-ou-modelagem-pura/
Tags: guitarra, contrabaixo, ampero-one, modelagem, som-ao-vivo

---

Tenho uma Hotone Ampero One e uma dúvida para tocar em linha na igreja: preciso simular amplificador e caixa ou posso usar compressor, EQ e outros efeitos e mandar o som para a mesa?

A resposta muda conforme o instrumento e o timbre que procuro. Para começar, precisei separar o papel do amplificador do papel da caixa.

## O que muda ao desligar a caixa

**AMP e CAB também fazem parte da modelagem**. Por isso, a distinção que me ajuda aqui é entre usar ou dispensar a caixa simulada. Desligar CAB retira uma etapa que colore o som; o amplificador modelado e os efeitos podem continuar na cadeia.

As duas possibilidades ficam assim:

- **Com caixa simulada:** efeitos, amplificador modelado e CAB/IR.
- **Sem caixa simulada:** efeitos e, se fizer sentido, amplificador ou pré modelado, com CAB desligado.

Compressor, EQ, chorus e redução de ruído podem entrar nas duas cadeias.

AMP simula o amplificador ou pré. CAB simula a caixa e seus alto-falantes, geralmente com a coloração de uma microfonação. Um IR de caixa é outra forma de representar essa resposta: ele pode trazer a coloração da caixa e da microfonação, mas, sozinho, não reproduz a saturação do amplificador.

<figure>
  <img src="/assets/images/equipamento-musical/tocando-em-linha/ampero-editor.webp" alt="Ampero Editor com a cadeia de efeitos no alto e os controles de um compressor abaixo" width="591" height="338" loading="lazy">
  <figcaption>Ampero Editor 1.2.9: os blocos AMP, IR e CAB aparecem separados na cadeia de efeitos.</figcaption>
</figure>

## No baixo, consigo partir do som direto

No contrabaixo, posso partir de um sinal direto para a mesa, sem simular uma caixa. Posso trabalhar dinâmica e equalização sem tentar reproduzir uma caixa microfonada. A [documentação da Radial](https://www.radialeng.com/product/prodi) descreve esse uso da DI para levar o baixo ao PA.

A simulação de caixa entra quando quero aquela coloração como parte do instrumento: outra distribuição dos médios, outra textura no ataque e outra resposta nos extremos de frequência. Pode ajudar a chegar a um som de amplificador, inclusive quando há drive.

A [Origin Effects](https://origineffects.com/2023/06/15/tech-tips-three-pedals-two-approaches-one-very-compact-bass-board/) demonstra as duas propostas em um mesmo pedalboard: um timbre de console e um timbre de Ampeg SVT com caixa 8×10 simulada. São duas escolhas de som.

Um detalhe me chamou a atenção: **usar DI não significa estar sem simulação de caixa**. No [SansAmp Bass Driver](https://www.tech21nyc.com/products/sansamp-2/bass-driver-30/), por exemplo, a simulação de alto-falante faz parte do circuito analógico. Não é preciso carregar um IR para ter essa coloração.

Para o meu baixo na igreja, meu ponto de partida foi uma cadeia com compressor, EQ e um pré ou AMP com pouco ganho, com CAB desligado.

## Na guitarra, a caixa pesa mais na decisão

Na guitarra elétrica, a caixa é uma parte central do timbre que costumo associar a um amplificador. Ela colore os médios e limita agudos. A microfonação acrescenta outra camada.

Ao mandar apenas o AMP modelado para o PA — o sistema de som que atende ao público —, essa filtragem pode faltar. Com distorção, os agudos podem ficar especialmente ásperos. Mesmo no som limpo, a caixa ajuda a construir a identidade daquele conjunto.

Para buscar um timbre de amplificador direto na mesa, eu começaria com **AMP + CAB/IR**. A [BOSS documenta essa combinação ao ligar a ME-90 ao PA](https://articles.boss.info/five-ways-to-connect-the-boss-me-90/). Também posso explorar um som sem caixa, se for essa a sonoridade que procuro.

Na Ampero, começaria com uma cadeia simples:

**Guitarra → compressor/drive → AMP → CAB/IR → delay/reverb → mesa.**

Se a saída alimentar uma caixa física de guitarra, a situação muda: os alto-falantes já fazem essa filtragem, e eu normalmente desligaria CAB/IR. Se entrar pela entrada comum de um amplificador, também preciso considerar o pré dele ao decidir se mantenho AMP ligado na pedaleira.

## E as capturas?

A [atualização 3.1 da Ampero One](https://www.hotone.jp/announcements/ampero-sound-clone-release) permite importar arquivos Sound Clone. Por enquanto, tenho preferido deixar as capturas de lado e me concentrar nos modelos de amplificador e nos efeitos que já uso.

Para continuar no assunto, recomendo este vídeo:

<iframe src="https://www.youtube-nocookie.com/embed/F1FilUC5i4w" title="Vídeo recomendado para continuar o assunto sobre modelagem e capturas" width="560" height="315" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

[Abrir o vídeo no YouTube](https://www.youtube.com/watch?v=F1FilUC5i4w).

## Referências

- [Hotone — Ampero One: modelagem e suporte a IRs](https://www.hotone.com/products/multi-effects/ampero-one).
- [Hotone Japan — atualização Sound Clone, incluindo Ampero One 3.1](https://www.hotone.jp/announcements/ampero-sound-clone-release).
- [Radial — ProDI e ligação do baixo ao PA](https://www.radialeng.com/product/prodi).
- [Origin Effects — duas abordagens de timbre para baixo em linha](https://origineffects.com/2023/06/15/tech-tips-three-pedals-two-approaches-one-very-compact-bass-board/).
- [Tech 21 — Bass Driver DI e simulação de alto-falante integrada](https://www.tech21nyc.com/products/sansamp-2/bass-driver-30/).
- [BOSS — conexão de modelagem de amplificador e caixa ao PA](https://articles.boss.info/five-ways-to-connect-the-boss-me-90/).
