/**
 * PASF Hero Slider - Admin media upload
 */
(function($) {
  'use strict';

  $(function() {
    var frame;
    var $imageId = $('#pasf_hero_image_id');
    var $preview = $('#pasf_hero_image_preview');
    var $removeBtn = $('#pasf_hero_remove_btn');

    $('#pasf_hero_upload_btn').on('click', function(e) {
      e.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        title: 'Select Slide Image',
        button: { text: 'Use Image' },
        library: { type: 'image' },
        multiple: false
      });
      frame.on('select', function() {
        var attachment = frame.state().get('selection').first().toJSON();
        $imageId.val(attachment.id);
        $preview.html('<img src="' + attachment.sizes.medium_large ? attachment.sizes.medium_large.url : attachment.url + '" alt="" style="max-width: 100%; max-height: 300px; display: block;" />');
        $removeBtn.show();
      });
      frame.open();
    });

    $removeBtn.on('click', function(e) {
      e.preventDefault();
      $imageId.val('');
      $preview.html('');
      $removeBtn.hide();
    });
  });
})(jQuery);
