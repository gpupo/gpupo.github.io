(function () {
  'use strict';

  document.querySelectorAll('[data-editorial-carousel]').forEach(function (carousel) {
    if (carousel.dataset.carouselReady) return;
    var viewport = carousel.querySelector('[data-carousel-viewport]');
    var slides = carousel.querySelectorAll('.editorial-carousel__slide');
    var controls = carousel.querySelector('[data-carousel-controls]');
    var previous = carousel.querySelector('[data-carousel-previous]');
    var next = carousel.querySelector('[data-carousel-next]');
    var status = carousel.querySelector('[data-carousel-status]');
    if (!viewport || slides.length < 2 || !controls || !previous || !next || !status) return;

    carousel.dataset.carouselReady = 'true';
    var current = 0;
    var scheduled = false;

    function update() {
      if (viewport.clientWidth) {
        current = Math.max(0, Math.min(slides.length - 1, Math.round(viewport.scrollLeft / viewport.clientWidth)));
        previous.disabled = current === 0;
        next.disabled = current === slides.length - 1;
        var label = (current + 1) + ' de ' + slides.length;
        if (status.textContent !== label) status.textContent = label;
      }
      scheduled = false;
    }

    function goTo(index) {
      if (!viewport.clientWidth) return;
      index = Math.max(0, Math.min(slides.length - 1, index));
      viewport.scrollTo({ left: index * viewport.clientWidth, behavior: 'instant' });
      update();
    }

    previous.addEventListener('click', function () { goTo(current - 1); });
    next.addEventListener('click', function () { goTo(current + 1); });
    viewport.addEventListener('keydown', function (event) {
      if (event.altKey || event.ctrlKey || event.metaKey || event.shiftKey) return;
      var target;
      if (event.key === 'ArrowLeft') target = current - 1;
      else if (event.key === 'ArrowRight') target = current + 1;
      else if (event.key === 'Home') target = 0;
      else if (event.key === 'End') target = slides.length - 1;
      else return;
      event.preventDefault();
      goTo(target);
    });
    viewport.addEventListener('scroll', function () {
      if (!scheduled) {
        scheduled = true;
        window.requestAnimationFrame(update);
      }
    }, { passive: true });
    window.addEventListener('resize', function () { goTo(current); });
    controls.hidden = false;
    update();
  });
}());
