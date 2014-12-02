(function ($) {
	$.fn.easythumb = function(options) {

		// No links
		if(this.length === 0 || $(this).filter('a').length === 0)
			return this;

		var x = y = 0;

		var settings = $.extend({
			size: '120x90',
			type: 'thumb',
			html: '<div id="img-easythumb"><div class="inner-easythumb"></div></div>',
			 // TODO: Allow positionning thumb
			position: 'bottom'
		}, options);

		var box = $(settings.html).hide();
		box.find('div.inner-easythumb').css('width', settings.size.split('x')[0]).css('height', settings.size.split('x')[1]);

		// Insert div in dom
		box.appendTo('body');

		return this.each(function(e) {
			var lnk = $(this);

			if(lnk.prop('tagName') !== 'A' || lnk.attr('href') === '')
				return;

			var img;

			lnk.hover(function() {
				var offset = lnk.offset();

				x = offset.left;
				y = offset.top + $(this).height();

				box.css({
					left: x,
					top: y
				});

				if(!lnk.data('loaded') || lnk.data('loaded') !== '1')
					box.show().find('div.inner-easythumb').html('');

				img = $('<img src="http://www.easy-thumb.net/min.html?url='+lnk.attr('href')+'&amp;size='+settings.size+'" />').one('load',function() {
					$(this).data('loaded', '1');

					box.show().find('div.inner-easythumb').html(img);
				});
			}, function() {
				img.off('load');

				box.hide();
			});
		});

		function preload(i) {
			$(i).each(function(){
				$('<img/>')[0].src = this;
			});
		}
	};
}(jQuery));