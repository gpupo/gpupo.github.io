# Frente e verso manual na HP LaserJet P1102w no Ubuntu

Published: 2026-10-26
Author: Gilmar Pupo
Editorial: tecnologia
Content type: article
Canonical: https://www.gpupo.com/posts/frente-e-verso-manual-hp-laserjet-p1102w-ubuntu/
Tags: Ubuntu, Linux, Impressão, PDF, Automação

---

A impressora HP LaserJet P1102w que uso imprime em apenas um lado por vez. Para imprimir
um PDF frente e verso, eu precisava virar as folhas manualmente, mas a fila
instalada no meu Ubuntu não oferecia uma opção que conduzisse essa sequência.

Criei um script para isso e o registrei no menu **Abrir com** como **Frente e
verso manual (HP1102)**. Ele envia as páginas da frente, para e mostra como
recolocar a pilha. Depois da minha confirmação, envia os versos. Se o PDF tiver
um número ímpar de páginas, a última é impressa separadamente.

<figure class="editorial-photo">
  <img src="/assets/images/frente-e-verso-manual-hp-laserjet-p1102w.webp" alt="Ilustração de uma impressora HP LaserJet P1102w preta com papel na bandeja de entrada e uma folha na saída" width="1536" height="1024" loading="lazy" decoding="async">
  <figcaption>A HP LaserJet P1102w na tarefa que ainda exige recolocar o papel manualmente.</figcaption>
</figure>

O trecho abaixo mostra como o script monta a ordem das páginas. `pair_pages`
desconsidera a última página quando ela não tem par:

```bash
pair_pages=$(( pages - pages % 2 ))

fronts=()
for (( i=1; i<=pair_pages; i+=2 )); do
  fronts+=("$tmpdir/p-$i.pdf")
done

backs=()
for (( i=pair_pages; i>=2; i-=2 )); do
  backs+=("$tmpdir/p-$i.pdf")
done
```

O script separa o PDF em páginas, reúne as frentes em ordem crescente e os
versos em ordem decrescente, e envia cada grupo para a fila com `lp`. Uma
janela do `zenity` faz a pausa entre os dois envios. Esse é apenas o trecho que
monta as listas de páginas; ele depende do restante do script.

Para usar, abro o PDF com **Frente e verso manual (HP1102)** e espero todas as
frentes terminarem. Retiro o papel em branco da bandeja e recoloco a pilha
impressa **sem mudar a ordem**, com o **lado impresso para baixo** e a **borda
superior entrando primeiro**. Então confirmo a impressão dos versos.

A impressora continua exigindo que alguém vire o papel, mas o script cuida da sequência e
mostra a instrução na hora de recolocar a pilha.
