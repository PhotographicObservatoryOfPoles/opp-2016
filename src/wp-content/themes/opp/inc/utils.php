<?php

/**
 * @todo precise params in doc
 * Sort items hierarchically
 * @param $a
 * @param $b
 * @return int
 */
function sort_hierarchically( $a, $b ) {
    if ( $a->menu_order == $b->menu_order ) {
        return 0;
    }
    return ( $a->menu_order < $b->menu_order ) ? -1 : 1;
}

/**
 * Get authors (with last author key)
 * @param int|WP_Post $post
 * @param string $locale
 * @return array
 */
function get_authors( $post, $locale ) {
	$authorsIDs = get_field( 'authors',  $post );

	$authors = array(
		'posts' => array(),
		'lastKey' => 0
	);
	foreach ( $authorsIDs as $authorID ) {
		$authors['posts'][] = get_post( pll_get_post( $authorID, $locale ) );
	}

	$keys = array_keys( $authors['posts'] );
	$authors['lastKey'] = end( $keys );

	return $authors;
}

/**
 * Get linked contributors (with last contributor key)
 * @param int|WP_Post $post
 * @param string $locale
 * @return array
 */
function get_linked_contributors( $post, $locale ) {
	$hasLinkedContributors = get_field( 'has_linked_contributors', $post );

	$contributors = array(
		'posts' => array(),
		'lastKey' => 0
	);

	if ( !$hasLinkedContributors ) {
		return $contributors;
	}

	$contributorsID = get_field( 'linked_contributors', $post );
	
	foreach ( $contributorsID as $contributorID ) {
		$contributors['posts'][] = get_post( pll_get_post( $contributorID, $locale ) );
	}

	$keys = array_keys( $contributors['posts'] );
	$contributors['lastKey'] = end( $keys );

	return $contributors;
}

/**
 * Get terms (theme & region)
 * @param int|WP_Post $post
 * @param bool $merged (optional, default false)
 * @return array
 */
function get_theme_region_terms( $post, $merged = false ) {
	$themes = get_field( 'theme', $post );
	$regions = get_field( 'region', $post );

	if ( $merged ) {
		return array_merge( $themes, $regions );
	}

	return array(
		'theme' => $themes,
		'region' => $regions
	);
}

/**
 * Get featured posts
 * @param int|WP_Post $post
 * @param array $terms
 * @param bool $random (optional, default false)
 * @param int $nbPosts (optional, default null)
 * @return array
 */
function get_featured_posts( $post, $terms, $random = false, $nbPosts = null ) {
	$otherPosts = get_posts( array(
        'posts_per_page'   => -1,
        'offset'           => 0,
        'post_type'        => $post->post_type,
        'post_status'      => 'publish',
        'exclude'		   => array( $post->ID )
	) );

	$featuredPosts = array();
	foreach ( $otherPosts as $otherPost ) {
		$otherPostTerms = get_theme_region_terms( $otherPost );

		if ( !empty( array_intersect( $terms['theme'], $otherPostTerms['theme'] ) ) ||			
			 !empty( array_intersect( $terms['region'], $otherPostTerms['region'] ) ) )
		{
			$featuredPosts[] = $otherPost;
		}
	}

	if ( $random && $nbPosts ) {
		$randomFeaturedPosts = array();
		$randomIndexes = array_rand( $featuredPosts, $nbPosts );
		foreach ( $randomIndexes as $randomIndex ) {
			$randomFeaturedPosts[] = $featuredPosts[$randomIndex];
		}
		return $randomFeaturedPosts;				
	}

	return $featuredPosts;
}

/**
 * Get formatted (with html tags) post content
 * @param int|WP_Post $post
 * @return string
 */
function get_formatted_post_content( $post ) {
	$post_content = $post->post_content;
	$post_content = apply_filters('the_content', $post_content);
	$post_content = str_replace(']]>', ']]&gt;', $post_content);
	return $post_content;
}

/**
 * Get posts data of home slider (last gallery, last expedition, last news)
 * get_posts() is used instead of WP_Query() because this function is called in header.php (outside main render loop) 
 * @param array $postTypes
 * @return array
 */
function get_home_slider_posts( $postTypes ) {
	$posts = array();

	foreach ( $postTypes as $postType ) {
		$post = get_posts( array(
			'orderby'          => 'date',
			'order'            => 'DESC',
	        'posts_per_page'   => 1,
	        'offset'           => 0,
	        'post_type'        => $postType,
	        'post_parent'	   => 0,
	        'post_status'      => 'publish'
		) );

		$posts = array_merge( $posts, $post );
	}

	return $posts;
}

/**
 * Get random posts
 * @param array $postTypes
 * @param int $nbPosts
 * @return array
 */
function get_random_posts( $postTypes, $nbPosts ) {
	$posts = get_posts( array(
		'orderby'          => 'rand',
        'posts_per_page'   => $nbPosts,
        'offset'           => 0,
        'post_type'        => $postTypes,
        'post_parent'	   => 0,
        'post_status'      => 'publish'
	) );

	return $posts;
}

/**
 * Get last published post(s)
 * @param string $postType
 * @param int $nbPosts
 * @return array
 */
function get_last_posts( $postType, $nbPosts ) {
	$post = wp_get_recent_posts( array(
			'numberposts' => $nbPosts,
			'offset' => 0,
			'category' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'include' => '',
			'exclude' => '',
			'meta_key' => '',
			'meta_value' =>'',
			'post_type' => $postType,
			'post_status' => 'publish',
			'suppress_filters' => true
		), OBJECT
	);

	return $post;
}

/**
 * @todo
 */
// Get excerpt (biography, description thumbnail) ?
// Get previous_next_page (expedition) ?