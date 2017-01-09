<?php

if ( !is_admin() ) add_action( 'wp_enqueue_scripts', 'opp_scripts', 11 );

/**
 * Include JS scripts
 */
function opp_scripts() {
    // jQuery
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri().'/node_modules/jquery/dist/jquery.min.js', false, null );
    wp_enqueue_script( 'jquery' );

    // Flexslider
    wp_enqueue_script( 'fexslider', get_template_directory_uri().'/node_modules/flexslider/jquery.flexslider-min.js', 'jquery', '2.0', true );

    // Scrollbar
    wp_enqueue_script( 'scrollbar', get_template_directory_uri().'/node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js', 'jquery', '2.0', true );

    // ScrollTop
    wp_enqueue_script( 'smooth-scroll', get_template_directory_uri().'/js/smooth-scroll.min.js', 'jquery', '2.0', true );

    // Panels
    wp_enqueue_script( 'panel', get_template_directory_uri().'/js/panel.min.js', 'jquery', '2.0', true );

    // Filters
    wp_enqueue_script( 'ajax-filter', get_template_directory_uri().'/js/ajax-filter.min.js', 'jquery', '2.0', true );
    wp_localize_script('ajax-filter', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

    // Masonry
    wp_enqueue_script( 'jquery-masonry' );

    // Infinite scroll
    wp_register_script( 'infinite-scroll', get_template_directory_uri().'/js/vendor/jquery-infinitescroll.min.js', 'jquery', '2.0', true );
    wp_enqueue_script( 'infinite-scroll' );

    // Map
    wp_enqueue_script( 'google-map-api', 'https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_API_KEY );
    wp_enqueue_script( 'map-icons', get_template_directory_uri().'/fonts/map-icons/map-icons.min.js' );
    wp_enqueue_script( 'acf-map', get_template_directory_uri().'/js/acf-map.min.js', 'jquery', '2.0', true );
}