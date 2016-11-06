$(document).ready(function() {

	// Back to top
	$("#back-top").hide();
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 800) {
				$('#back-top').fadeIn('fast');
			} else {
				$('#back-top').fadeOut('fast');
			}
		});

		$('#back-top a').click(function () {
			$('body, html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

	// Smooth scroll anchors
	var hashTagActive = '';
	var offset = 10;
    $('.scroll').click(function (event) {
        event.preventDefault();
        var dest = 0;
        if (typeof $(this).data('scroll-offset') !== 'undefined') {
        	offset = parseInt($(this).data('scroll-offset'));
        }
        if ($(this.hash).offset().top > $(document).height() - $(window).height()) {
            dest = $(document).height() - $(window).height();
        } else {
            dest = $(this.hash).offset().top;
        }
        $('html,body').animate({scrollTop: dest - offset}, 900, 'swing');
        hashTagActive = this.hash;
    });

});