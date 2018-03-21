<?php

add_theme_support( 'post-thumbnails' );

/**
 * Custom post types definition
 *      - contributor
 *      - partner
 *      - photos-gallery
 *      - videos-gallery
 *      - expedition
 */
function custom_post_type() {
	  // Contributor
    $labels = array(
        'name'                => __( 'Contributors', 'opp' ),
        'singular_name'       => __( 'Contributor', 'opp' ),
        'all_items'           => __( 'All contributors', 'opp' ),
        'view_item'           => __( 'View', 'opp' ),
        'add_new_item'        => __( 'Add a contributor', 'opp' ),
        'add_new'             => __( 'Add', 'opp' ),
        'edit_item'           => __( 'Edit', 'opp' ),
        'update_item'         => __( 'Update', 'opp' ),
        'search_items'        => __( 'Search', 'opp' ),
        'not_found'           => __( 'Not found', 'opp' ),
        'not_found_in_trash'  => __( 'Not found in trash', 'opp' )
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-admin-users',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        //'capability_type'     => 'page',
        'hierarchical'        => false,
        'rewrite'			  => array( 'slug' => 'contributor' ),
        // roles and capabilities
        'capability_type'     => array( 'contributor', 'contributors' ),
        'map_meta_cap'        => true
    );
    register_post_type( 'contributor', $args );

    // Partner
    $labels = array(
        'name'                => __( 'Partners', 'opp' ),
        'singular_name'       => __( 'Partner', 'opp' ),
        'all_items'           => __( 'All partners', 'opp' ),
        'view_item'           => __( 'View', 'opp' ),
        'add_new_item'        => __( 'Add a partner', 'opp' ),
        'add_new'             => __( 'Add', 'opp' ),
        'edit_item'           => __( 'Edit', 'opp' ),
        'update_item'         => __( 'Update', 'opp' ),
        'search_items'        => __( 'Search', 'opp' ),
        'not_found'           => __( 'Not found', 'opp' ),
        'not_found_in_trash'  => __( 'Not found in trash', 'opp' )
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-groups',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        //'capability_type'     => 'page',
        'hierarchical'        => false,
        'rewrite'             => array( 'slug' => 'partner' ),
        // roles and capabilities
        'capability_type'     => array( 'partner', 'partners' ),
        'map_meta_cap'        => true
    );
    register_post_type( 'partner', $args );

    // Photo gallery
    $labels = array(
        'name'                => __( 'Photos galleries', 'opp' ),
        'singular_name'       => __( 'Photos gallery', 'opp' ),
        'all_items'           => __( 'All galleries', 'opp' ),
        'view_item'           => __( 'View', 'opp' ),
        'add_new_item'        => __( 'Add a gallery', 'opp' ),
        'add_new'             => __( 'Add', 'opp' ),
        'edit_item'           => __( 'Edit', 'opp' ),
        'update_item'         => __( 'Update', 'opp' ),
        'search_items'        => __( 'Search', 'opp' ),
        'not_found'           => __( 'Not found', 'opp' ),
        'not_found_in_trash'  => __( 'Not found in trash', 'opp' )
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-images-alt2',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        //'capability_type'     => 'page',
        'hierarchical'        => false,
        'rewrite'             => array( 'slug' => 'photos-gallery' ),
        // roles and capabilities
        'capability_type'     => array( 'photos-gallery', 'photos-galleries' ),
        'map_meta_cap'        => true
    );
    register_post_type( 'photos-gallery', $args );

    // Video gallery
    $labels = array(
        'name'                => __( 'Videos', 'opp' ),
        'singular_name'       => __( 'Video', 'opp' ),
        'all_items'           => __( 'All videos', 'opp' ),
        'view_item'           => __( 'View', 'opp' ),
        'add_new_item'        => __( 'Add a video', 'opp' ),
        'add_new'             => __( 'Add', 'opp' ),
        'edit_item'           => __( 'Edit', 'opp' ),
        'update_item'         => __( 'Update', 'opp' ),
        'search_items'        => __( 'Search', 'opp' ),
        'not_found'           => __( 'Not found', 'opp' ),
        'not_found_in_trash'  => __( 'Not found in trash', 'opp' )
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 27,
        'menu_icon'           => 'dashicons-format-video',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        //'capability_type'     => 'page',
        'hierarchical'        => false,
        'rewrite'             => array( 'slug' => 'videos-gallery' ),
        // roles and capabilities
        'capability_type'     => array( 'videos-gallery', 'videos-galleries' ),
        'map_meta_cap'        => true
    );
    register_post_type( 'videos-gallery', $args );

    // Expedition
    $labels = array(
        'name'                => __( 'Expeditions', 'opp' ),
        'singular_name'       => __( 'Expedition', 'opp' ),
        'all_items'           => __( 'All expeditions', 'opp' ),
        'view_item'           => __( 'View', 'opp' ),
        'add_new_item'        => __( 'Add an expedition', 'opp' ),
        'add_new'             => __( 'Add', 'opp' ),
        'edit_item'           => __( 'Edit', 'opp' ),
        'update_item'         => __( 'Update','opp' ),
        'search_items'        => __( 'Search', 'opp' ),
        'not_found'           => __( 'Not found', 'opp' ),
        'not_found_in_trash'  => __( 'Not found in trash', 'opp' )
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 28,
        'menu_icon'           => 'dashicons-images-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        //'capability_type'     => 'page',
        'hierarchical'        => true,
        'rewrite'             => array( 'slug' => 'expedition' ),
        // roles and capabilities
        'capability_type'     => array( 'expedition', 'expeditions' ),
        'map_meta_cap'        => true
    );
    register_post_type( 'expedition', $args );
}
add_action( 'init', 'custom_post_type', 0 );


/**
 * Custom taxonomies definition
 *      - contributor-type
 *      - theme
 *      - region
 */
function custom_taxonomy() {
    // Contibutor type
    register_taxonomy(
        'contributor-type',
        'contributor',
        array(
            'label' => __( 'Contributor types', 'opp' ),
            'rewrite' => array( 'slug' => 'contributor-type' ),
            'hierarchical' => true
        )
    );

    // Category
    register_taxonomy(
        'theme',
        array( 'photos-gallery', 'videos-gallery', 'expedition' ),
        array(
            'label' => __( 'Themes', 'opp' ),
            'rewrite' => array( 'slug' => 'theme' ),
            'hierarchical' => true
        )
    );

    // Region
    register_taxonomy(
        'region',
        array( 'photos-gallery', 'videos-gallery', 'expedition' ),
        array(
            'label' => __( 'Regions', 'opp' ),
            'rewrite' => array( 'slug' => 'region' ),
            'hierarchical' => true
        )
    );
}
add_action( 'init', 'custom_taxonomy', 0 );
