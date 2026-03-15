/**
 * Flash News ticker animation
 *
 * @package pasfanc-theme
 */
(function($) {
	'use strict';
	$(function() {
		var $ticker = $('.pasf-flash-news-ticker');
		if (!$ticker.length) return;
		var $track = $ticker.find('.pasf-flash-track');
		if (!$track.length) return;
		var $items = $track.children();
		if ($items.length < 2) return;
		// Clone items for seamless loop
		$items.clone().appendTo($track);
	});
})(jQuery);
