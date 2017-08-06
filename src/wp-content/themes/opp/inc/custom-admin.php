<?php

/**
 * Photos gallery
 */

// Columns head
function photos_gallery_columns_head( $columns ) {
	$new_columns = [];
	foreach ($columns as $key => $title) {
		if ( $key == 'date' ) {
			$new_columns['subtitle'] = __( 'Subtitle / Type', 'opp' );
		}
		$new_columns[$key] = $title;
	}
    return $new_columns;
}

// Columns content
function photos_gallery_columns_content( $column_name, $post_ID ) {
    if ( $column_name == 'subtitle' ) {
        $post_subtitle = get_field( 'subtitle', $post_ID );
    	echo $post_subtitle ? $post_subtitle : '-';
    }
}

add_filter( 'manage_photos-gallery_posts_columns', 'photos_gallery_columns_head' );
add_action( 'manage_photos-gallery_posts_custom_column', 'photos_gallery_columns_content', 10, 2 );
