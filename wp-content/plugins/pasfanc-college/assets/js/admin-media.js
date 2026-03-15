/**
 * Admin media uploader for Flash News and Downloads (file & image picker)
 *
 * @package pasfanc-college
 */
(function($) {
	'use strict';

	$(document).on('click', '.pasf-upload-file', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var targetId = $btn.data('target');
		if (!targetId) return;
		var $input = $('#' + targetId);
		var $nameSpan = $btn.siblings('.pasf-file-name');
		if (!$input.length) return;

		var mediaFrame = wp.media({
			title: 'Select File',
			button: { text: 'Use This File' },
			multiple: false,
			library: { type: '' }
		});

		mediaFrame.on('select', function() {
			var attachment = mediaFrame.state().get('selection').first().toJSON();
			$input.val(attachment.id);
			if ($nameSpan.length) {
				$nameSpan.text(attachment.filename || attachment.title || 'Selected');
			}
		});

		mediaFrame.open();
	});

	$(document).on('click', '.pasf-upload-image', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var targetId = $btn.data('target');
		if (!targetId) return;
		var $input = $('#' + targetId);
		var $preview = $btn.siblings('.pasf-image-preview');
		if (!$input.length) return;

		var mediaFrame = wp.media({
			title: 'Select Image',
			button: { text: 'Use This Image' },
			multiple: false,
			library: { type: 'image' }
		});

		mediaFrame.on('select', function() {
			var attachment = mediaFrame.state().get('selection').first().toJSON();
			$input.val(attachment.id);
			if ($preview.length && attachment.sizes && attachment.sizes.thumbnail) {
				$preview.html('<img src="' + attachment.sizes.thumbnail.url + '" alt="" style="max-width:80px;height:auto;">').show();
			} else if ($preview.length && attachment.url) {
				$preview.html('<img src="' + attachment.url + '" alt="" style="max-width:80px;height:auto;">').show();
			}
		});

		mediaFrame.open();
	});
})(jQuery);
