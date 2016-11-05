$(document).ready( function() {

	var post_type = $('#search').data('post-type');
	var filters = [];

	$('.filters a').click( function(e) {
		e.preventDefault();

		$('.spinner').css('opacity', 0.8);
		$(this).toggleClass('selected');

		filters = new Object();
		$('.filters a.selected').each( function() {
			var pathname = $(this)[0].pathname;
				pathname = pathname.substring(1, pathname.length - 1);

			var args = pathname.split('/'),
			 	taxonomy = args[1],
			 	term = args[2];

			if (!(taxonomy in filters)) {
				filters[taxonomy] = [];
			}

			filters[taxonomy].push(term);
		});

		jQuery.post(
		    ajaxurl,
		    {
		        'action': 'filter_posts',
		        'filters': filters,
		        'post_type': post_type
		    },
		    function(response) {
		    	$('#filters-result').html(response).masonry( 'reload' );
		    	$('.spinner').css('opacity', 0);
		    	if ( jQuery.isEmptyObject(filters) ) {
					$('.load-more-manual').removeClass('hidden');
				} else {
					$('.load-more-manual').addClass('hidden');
				}
	        }
		);
	});
});
