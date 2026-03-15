/**
 * Initialize GLightbox for Campus Gallery
 * Enables click-to-preview with prev/next navigation and thumbnails
 *
 * @package pasfanc-theme
 */
(function() {
  'use strict';
  if (typeof GLightbox !== 'undefined') {
    GLightbox({
      selector: '[data-glightbox]',
      touchNavigation: true,
      loop: true,
      closeButton: true,
      zoomable: true,
      draggable: true
    });
  }
})();
