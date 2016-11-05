(function($) {

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el, $panel ) {
	
	// vars
	var $markers = $el.find('.marker');
	
	// args
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng( 71.491368, 22.180832 ),
		mapTypeId	: google.maps.MapTypeId.ROADMAP,
		scrollwheel : $el.hasClass('scrollable'),
		styles: [
			{stylers: [{ visibility: 'simplified' }]},
			{elementType: 'labels', stylers: [{ visibility: 'off' }]}
		]
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function() {
    	add_marker( $(this), map, $panel );	
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map, $panel) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
	var color = $marker.hasClass('current') ? '#57025b' : '#7a7979';

	// create marker
	var marker = new Marker({ // google.maps.Marker
		position	: latlng,
		map			: map,
		//animation 	: google.maps.Animation.DROP,
		icon: {
			path: MAP_PIN, // SQUARE_PIN, ROUTE, MAP_PIN, SQUARE_ROUNDED, SQUARE, SHIELD
			fillColor: color,
			fillOpacity: 0.9,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-compass"></span>',
	});

	// get posts to display in panel
	if ( $panel ) {
		marker.address = $marker.attr('data-address');
		marker.posts = jQuery.parseJSON( $marker.attr('data-posts') );
	}

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if ( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

			// if panel, show it if there is more than one item to display
			if ( $panel ) {
				$panel.close();
				var nbGalleries = marker.posts.gallery.length,
					nbExpeditions = marker.posts.expedition.length,
					nbPosts = nbGalleries + nbExpeditions;
				
				if ( nbPosts > 1) {
					$('.spinner').css('opacity', 0.8);

					jQuery.post(
					    ajaxurl,
					    {
					        'action': 'map_marker_posts',
					        'posts': marker.posts,
					        'address': marker.address
					    },
					    function(response) {
					    	$('#map-side-panel .posts').html(response);
					    	$panel.open();
					    	$('.spinner').css('opacity', 0);
				        }
					);
				}
			}
			
		});

		// show info directly if its current marker
		if ($marker.hasClass('current')) {

			infowindow.open( map, marker );

		}
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{

		// set center of map
	    //map.setCenter( bounds.getCenter() );
	    map.setZoom( 2 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/

// global var
var map = null;
var panel = null;

$(document).ready(function() {

	// Map page
	if ( $('body').hasClass('page-template-page-map') ) {
		// Panel (slide left)
		panel = new Panel({
			panel: '#map-side-panel',
			type: 'slide-left',
			maskId: false
		});
	}

	$('.acf-map').each(function() {

		// create map
		map = new_map( $(this), panel );
	
	});

});

})(jQuery);