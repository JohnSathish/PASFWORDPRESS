/**
 * PASF College Theme - Main JavaScript
 */
(function() {
  'use strict';

  // Mobile menu toggle
  var menuToggle = document.querySelector('.menu-toggle');
  var navigation = document.querySelector('.main-navigation');
  if (menuToggle && navigation) {
    menuToggle.addEventListener('click', function() {
      navigation.classList.toggle('toggled');
      var expanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', !expanded);
    });
  }

  // Smooth scroll for anchor links (skip bare '#' - not a valid selector)
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      var href = (this.getAttribute('href') || '').trim();
      if (!href || href === '#') return;
      try {
        var target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      } catch (err) {
        // Invalid selector (e.g. '#') - allow default link behavior
      }
    });
  });

  // Typewriter effect for welcome banner - loops continuously
  var typewriterEl = document.querySelector('.typewriter-text');
  if (typewriterEl) {
    var text = typewriterEl.getAttribute('data-text') || '';
    var cursor = typewriterEl.parentElement.querySelector('.typewriter-cursor');
    var i = 0;
    var speed = 80;
    var pauseBeforeRestart = 2500;
    function type() {
      if (i < text.length) {
        typewriterEl.textContent += text.charAt(i);
        i++;
        setTimeout(type, speed);
      } else {
        setTimeout(function() {
          typewriterEl.textContent = '';
          i = 0;
          if (cursor) cursor.style.visibility = 'visible';
          setTimeout(type, 400);
        }, pauseBeforeRestart);
      }
    }
    setTimeout(type, 400);
  }

  // Gallery lightbox - open preview with prev/next when clicking photos
  if ( typeof GLightbox !== 'undefined' ) {
    var galleryLinks = document.querySelectorAll( '.gallery-item-link[data-glightbox]' );
    if ( galleryLinks.length ) {
      new GLightbox({
        elements: galleryLinks,
        selector: '.gallery-item-link[data-glightbox]',
        touchNavigation: true,
        loop: true,
        closeButton: true,
        openEffect: 'zoom',
        closeEffect: 'fade'
      });
    }
  }

  // Gallery lightbox - when GLightbox is loaded, init on gallery links
  if (typeof GLightbox !== 'undefined') {
    var galleryLinks = document.querySelectorAll('.gallery-item-link[data-glightbox], .gallery-grid .gallery-item-link');
    if (galleryLinks.length) {
      new GLightbox({
        selector: '.gallery-item-link',
        touchNavigation: true,
        loop: true,
        closeButton: true,
        zoomable: true,
        draggable: true,
        openEffect: 'zoom',
        closeEffect: 'zoom',
        cssEffects: {
          fade: { in: 'fadeIn', out: 'fadeOut' },
          zoom: { in: 'zoomIn', out: 'zoomOut' }
        }
      });
    }
  }

  // Gallery filter (homepage) - filter by category without page reload
  var galleryFilters = document.querySelector('.gallery-section .gallery-filters');
  var galleryItems = document.querySelectorAll('.gallery-section .gallery-item');
  if (galleryFilters && galleryItems.length) {
    galleryFilters.querySelectorAll('.gallery-filter-btn').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var filter = this.getAttribute('data-filter');
        galleryFilters.querySelectorAll('.gallery-filter-btn').forEach(function(b) {
          b.classList.remove('active');
          b.setAttribute('aria-pressed', 'false');
        });
        this.classList.add('active');
        this.setAttribute('aria-pressed', 'true');
        galleryItems.forEach(function(item) {
          var cats = (item.getAttribute('data-categories') || '').split(/\s+/).filter(Boolean);
          var show = filter === 'all' || cats.indexOf(filter) !== -1;
          item.style.display = show ? '' : 'none';
          if (show) item.style.animation = 'gallery-fade-in 0.4s ease forwards';
        });
      });
    });
  }

  // Back to top - show/hide on scroll, smooth scroll on click
  var backToTop = document.getElementById('back-to-top');
  if (backToTop) {
    function toggleBackToTop() {
      if (window.pageYOffset > 400) {
        backToTop.classList.add('visible');
      } else {
        backToTop.classList.remove('visible');
      }
    }
    window.addEventListener('scroll', toggleBackToTop, { passive: true });
    toggleBackToTop();
    backToTop.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Scroll-triggered section animations (Intersection Observer)
  var sectionAnimate = document.querySelectorAll('.section-animate');
  if (sectionAnimate.length && 'IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) entry.target.classList.add('animated');
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    sectionAnimate.forEach(function(el) { observer.observe(el); });
  }

  // Quick Facts count-up animation
  var quickFactValues = document.querySelectorAll('.quick-fact-value[data-target]');
  if (quickFactValues.length && 'IntersectionObserver' in window) {
    var factObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var target = el.getAttribute('data-target');
        if (!target) return;
        factObserver.unobserve(el);
        var val = target.replace(/\D/g, '');
        var suffix = (target.match(/\D+$/) || [])[0] || '';
        var num = parseInt(val, 10) || 0;
        var dur = 1500;
        var start = 0;
        var startTime = null;
        function step(timestamp) {
          if (!startTime) startTime = timestamp;
          var progress = Math.min((timestamp - startTime) / dur, 1);
          var eased = 1 - Math.pow(1 - progress, 2);
          el.textContent = Math.floor(start + (num - start) * eased) + suffix;
          if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      });
    }, { threshold: 0.5 });
    quickFactValues.forEach(function(el) { factObserver.observe(el); });
  }
})();
