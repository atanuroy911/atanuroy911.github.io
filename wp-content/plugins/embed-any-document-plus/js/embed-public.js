jQuery(function($) {
	$('.ead-iframe-wrapper').each(function() {
		var $wrapper = $(this);
		var viewer = $wrapper.parent('.ead-document').data('viewer');
		viewer = typeof viewer !== 'undefined' ? viewer : '';
		if ( viewer !== 'dropbox' ) {
			var $activeIframe = $wrapper.find('.ead-iframe');
			var isNativeViewer = viewer.length > 0 ? viewer : false;
			var lazyLoadSrc = $activeIframe.data('src');
			var lazyLoadAttr = $activeIframe.attr('loading');
			var isLazyLoaded = false;
			if ((typeof lazyLoadSrc !== 'undefined' && lazyLoadSrc.length > 0) || (typeof lazyLoadAttr !== 'undefined' && lazyLoadAttr === 'lazy')) {
				isLazyLoaded = true;
			}
			var $iframe = $activeIframe;
			if (!isLazyLoaded) {
				$iframe = $('<iframe class="ead-iframe"></iframe>');
				$iframe.attr({
					'src': $activeIframe.attr('src'),
					'style': $activeIframe.attr('style'),
					'title': $activeIframe.attr('title')
				});
			}
			if (! isNativeViewer) {
				$iframe.css('visibility', 'visible');
			}
			$iframe.on('load', function() {
				$(this).parents('.ead-document').find('.ead-document-loading').css('display', 'none');
			});

			if (!isLazyLoaded) {
				$wrapper.html($iframe);
			}
		} else {
			var embedCheck = setInterval(function() {
				var $iframe = $wrapper.find('iframe').first();
				if ($iframe.length > 0) {
					$iframe.addClass('ead-iframe');
					$iframe.on('load', function() {
						$(this).parents('.ead-document').find('.ead-document-loading').css('display', 'none');
					});
					clearInterval(embedCheck);
				}
			}, 250);
		}
	});

	$('.ead-document[data-pdf-src]').each(function() {
		var $elem = $(this);
		var $iframe = $elem.find('.ead-iframe');
		var src = $elem.data('pdfSrc');
		var viewer = $elem.data('viewer');
		viewer = typeof viewer !== 'undefined' && src.length > 0 && viewer.length > 0 ? viewer : false;
		var isBuiltInViewer = 'pdfjs' in eadPublic && eadPublic.pdfjs.length > 0 && viewer === 'built-in';
		if (viewer && (viewer === 'browser' || isBuiltInViewer)) {
			if (PDFObject.supportsPDFs || isBuiltInViewer) {
				var options = {};
				if (! isBuiltInViewer) {
					options = {
						width: $iframe.css('width'),
						height: $iframe.css('height')
					}
				} else {
					options = {
						forcePDFJS: true,
						PDFJS_URL: eadPublic.pdfjs
					};
				}

				PDFObject.embed(src, $elem, options);
			} else {
				$iframe.css('visibility', 'visible');
			}
		}
	});

    $(document).on('click', '.ead-reload-btn', function(e) {
        e.preventDefault();
        var $wrapper = $(this).parents('.ead-document');
        var iframeSrc = $wrapper.find('.ead-iframe').attr('src');
        $wrapper.find('.ead-iframe').attr('src', iframeSrc);
    });
});
