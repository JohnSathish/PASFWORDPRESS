/**
 * PASF Hero Slider - Front-end
 */
(function() {
  'use strict';

  function initSlider() {
    var slider = document.querySelector('.pasf-hero-slider');
    if (!slider) return;

    var slides = slider.querySelectorAll('.pasf-hero-slide');
    if (slides.length <= 1) return;

    var prevBtn = slider.querySelector('.pasf-hero-prev');
    var nextBtn = slider.querySelector('.pasf-hero-next');
    var dots = slider.querySelectorAll('.pasf-hero-dot');
    var autoplay = slider.dataset.autoplay === 'true';
    var delay = parseInt(slider.dataset.delay, 10) || 5000;
    var current = 0;
    var timer;

    function goTo(index) {
      slides.forEach(function(s) { s.classList.remove('active'); });
      dots.forEach(function(d) { d.classList.remove('active'); });
      current = (index + slides.length) % slides.length;
      slides[current].classList.add('active');
      if (dots[current]) dots[current].classList.add('active');
    }

    function next() {
      goTo(current + 1);
    }

    function prev() {
      goTo(current - 1);
    }

    function startAutoplay() {
      if (!autoplay) return;
      timer = setInterval(next, delay);
    }

    function stopAutoplay() {
      clearInterval(timer);
    }

    if (prevBtn) prevBtn.addEventListener('click', function() { stopAutoplay(); prev(); startAutoplay(); });
    if (nextBtn) nextBtn.addEventListener('click', function() { stopAutoplay(); next(); startAutoplay(); });
    dots.forEach(function(dot, i) {
      dot.addEventListener('click', function() {
        stopAutoplay();
        goTo(i);
        startAutoplay();
      });
    });

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);
    startAutoplay();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSlider);
  } else {
    initSlider();
  }
})();
