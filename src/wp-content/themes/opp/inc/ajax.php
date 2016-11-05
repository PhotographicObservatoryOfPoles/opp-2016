<?php

/**
 * Filters posts by taxonomies terms (galleries & expeditions by themes & regions)
 */
add_action( 'wp_ajax_filter_posts', 'filter_posts' );
add_action( 'wp_ajax_nopriv_filter_posts', 'filter_posts' );
function filter_posts() {
    // Get params
    $filters = $_POST['filters'];
    $post_type = $_POST['post_type'];
    // Get posts
    $posts = query_posts( array(
        'orderby'        => 'date',
        'order'          => 'DESC',
        'offset'         => 0,
        'posts_per_page' => -1,
        'paged'          => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'post_parent'    => 0
    ) );
    // Get template
    $template = $post_type . '-thumbnail.php';
    $results = array();

    // If filters have been selected
    if ( !empty( $filters ) ) {
        // Get posts matching terms
        foreach ( $filters as $taxonomy => $filter ) {
            foreach ( $filter as $key => $value ) {
                $term = get_term_by( 'slug', $value, $taxonomy );
                foreach ( $posts as $post ) {
                    $terms = get_field( $taxonomy, $post );
                    if ( $terms && in_array( $term->term_id, $terms ) && !in_array( $post, $results ) ) {
                        array_push( $results, $post );
                    }
                }
            }
        } 
    // If no filter has been selected
    } else {
        // Get all posts
        $results = query_posts( array(
            'orderby'        => 'date',
            'order'          => 'DESC',
            'offset'         => 0,
            'posts_per_page' => 5,
            'paged'          => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'post_parent'    => 0
        ) );

    }

    // If posts exist
    if ( !empty( $results ) ) {

        // Display results
        foreach ( $results as $result ) {
            $post = $result;
            // Thumbnail
            $thumbnail = get_the_post_thumbnail( $post, 'large' );
            // Authors
            $authors = get_authors( $post, $locale );
            // Terms (theme & region)
            $terms = get_theme_region_terms( $post, true );
            // Description
            $description = $post_type === 'photos-gallery' ? get_field( 'description', $post, false ) :
                                                        wp_strip_all_tags( get_post_field( 'post_content', $post ) );
            $description = strlen($description) > 300 ? mb_substr( $description, 0, 300 ) . '...' : $description;
            // Partial
            include( locate_template( 'partials/' . $template ) );
        }
    // If no post has been found
    } else {

        // No result partial
        include( locate_template( 'partials/no-result.php' ) );

    }

    die();
}

/**
 * Markers' posts list in map side panel
 */
add_action( 'wp_ajax_map_marker_posts', 'map_marker_posts' );
add_action( 'wp_ajax_nopriv_map_marker_posts', 'map_marker_posts' );
function map_marker_posts() {
    // Get params
    $address = $_POST['address'];
    $posts = $_POST['posts'];

    // Display panel's title
    echo "<h4 class='address'>" . __( $address, 'opp' ) . "</h4>";
    // Display posts
    foreach ($posts as $postType => $postIDs) {
        include( locate_template( 'partials/map-panel.php' ) );
    }

    die();
}
