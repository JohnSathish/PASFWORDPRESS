/**
 * Gallery multi-image picker - admin
 *
 * @package pasfanc-college
 */
(function($) {
  'use strict';

  var mediaFrame;

  function updateHiddenInput() {
    var ids = [];
    $('#pasf-gallery-images-preview .pasf-gallery-preview-item').each(function() {
      var id = $(this).data('id');
      if (id) ids.push(id);
    });
    $('#pasf_gallery_images').val(ids.join(','));
  }

  function addImagePreview(attachment) {
    var url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
    var html = '<div class="pasf-gallery-preview-item" data-id="' + attachment.id + '" style="position: relative;">' +
      '<img src="' + url + '" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; display: block;">' +
      '<button type="button" class="pasf-gallery-remove-image" style="position: absolute; top: 2px; right: 2px; width: 20px; height: 20px; padding: 0; border: none; background: #dc3545; color: #fff; border-radius: 50%; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>' +
      '</div>';
    $('#pasf-gallery-images-preview').append(html);
  }

  $('#pasf-gallery-add-images').on('click', function(e) {
    e.preventDefault();
    if (mediaFrame) {
      mediaFrame.open();
      return;
    }
    mediaFrame = wp.media({
      title: 'Select or Upload Gallery Photos',
      button: { text: 'Add to Gallery' },
      multiple: true,
      library: { type: 'image' }
    });
    mediaFrame.on('select', function() {
      var selection = mediaFrame.state().get('selection');
      selection.each(function(attachment) {
        attachment = attachment.toJSON();
        if ($('#pasf-gallery-images-preview .pasf-gallery-preview-item[data-id="' + attachment.id + '"]').length === 0) {
          addImagePreview(attachment);
        }
      });
      updateHiddenInput();
    });
    mediaFrame.open();
  });

  $(document).on('click', '.pasf-gallery-remove-image', function(e) {
    e.preventDefault();
    $(this).closest('.pasf-gallery-preview-item').remove();
    updateHiddenInput();
  });

  // Allow drag to reorder if needed - optional enhancement
  // For now, basic add/remove works
})(jQuery);
