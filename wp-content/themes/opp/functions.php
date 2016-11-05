<?php

// Global
global $locale;
/* Post types subpages */
global $post_type_subpages;
$post_type_subpages = [ 'photos-gallery', 'expedition', 'contributor', 'post' ];

/* ID pages (fr_FR) */
const PAGE_GALLERIES_ID        	   	  = 83;
const PAGE_EXPEDITIONS_ID     	   	  = 944;
const PAGE_MAP_ID              	   	  = 77;
const PAGE_CONTRIBUTORS_ID     	   	  = 1078;
const PAGE_OBSERVATORY_ID 		   	  = 1122;
const PAGE_OBSERVATORY_ABOUT_ID 	  = 1126;
const PAGE_OBSERVATORY_TEAM_ID    	  = 1128;
const PAGE_OBSERVATORY_SPONSORS_ID 	  = 1149;
const PAGE_OBSERVATORY_PARTNERS_ID	  = 1151;
const PAGE_DONATION_ID 	 			  = 1132;
const PAGE_CONTACT_ID 	 			  = 1212;
const CONTACT_FORM_ID 	 			  = 1218;
const PAGE_NEWS_ID	 	 			  = 1252;
const PAGE_MEDIAS_ID	 	 		  = 1289;
const PAGE_LEGAL_NOTICE_ID	 	  	  = 1292;

/* Pagination */
const POSTS_PER_PAGE = 6;

/* Mobile hidden pages */
global $mobile_hidden_pages;
$mobile_hidden_pages = [ 
	pll_get_post( PAGE_GALLERIES_ID, $locale ),
	pll_get_post( PAGE_EXPEDITIONS_ID, $locale ),
	pll_get_post( PAGE_MAP_ID, $locale ),
	pll_get_post( PAGE_CONTRIBUTORS_ID, $locale )
];


/* Page slug body class */
add_filter( 'body_class', 'add_slug_body_class' );
function add_slug_body_class( $classes ) {
    $classes[] = 'panel-push';
    return $classes;
}

/* Global search */
add_filter( 'pre_get_posts','filter_global_search' );
function filter_global_search( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', array('photos-gallery', 'expedition', 'contributor', 'post') );
	}
	return $query;
}

// Includes
/* Custom Post Types */
require 'inc/custom-post-types.php';
/* Languages */
require 'inc/languages.php';
/* Scripts */
require 'inc/scripts.php';
/* Utils */
require 'inc/utils.php';
/* Ajax */
require 'inc/ajax.php';


