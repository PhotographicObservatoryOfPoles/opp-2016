<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage OPP
 * @since OPP 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
	<?php 
		if ( $post->post_parent ) {
			$parent = get_post( $post->post_parent );
			$title = $parent->post_parent ? get_the_title( $parent->post_parent ) : get_the_title( $post->post_parent );
     		echo $title . ' > ';
     	}
     	wp_title( '|', true, 'right' );
     	bloginfo( 'name' );
    ?>
 	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href="<?php bloginfo( 'template_directory' ); ?>/style.css?ver=1.0" rel="stylesheet">
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico">
	<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>

	<header role="banner" class="fixed">
		<div class="menu-bar">
			<a class="site-branding button--w-tooltip" href="<?php echo pll_home_url( $locale ); ?>" title="<?php echo __( 'Homepage', 'opp' ); ?>">
				<img src="<?php bloginfo('template_directory'); ?>/img/logo.png" alt="<?php echo __( 'Observatory Photographic of Poles' , 'opp'); ?>" />
				<h1 class="button-tooltip button-tooltip--right site-name">
					<?php echo __( 'Observatory <span class="light-blue">Photographic</span> of Poles', 'opp' ); ?>
				</h1>
			</a>

			<div id="button--panel-navigation" class="button--w-tooltip">
				<button class="button--panel-open c-hamburger c-hamburger--htx">
					<span class="c-hamburger-line"></span>
				</button>
				<span class="button-tooltip button-tooltip--left"><?php echo __( 'Menu', 'opp' ); ?></span>
			</div>
		</div>
		<!-- Search -->
		<?php if ( is_home() || !in_array( $post->post_type, $GLOBALS['post_type_subpages'] ) ) : ?>
			<div class="menu-bar menu-bar--page mobile-hidden">
				<button id="button--panel-search" class="button--panel-open button--w-tooltip">
					<span class="glyphicon glyphicon-search"></span>
					<span class="button-tooltip button-tooltip--left"><?php echo __( 'Search', 'opp' ); ?></span>
				</button>
			</div>
		<?php endif; ?>

		<!-- Homepage slider -->
		<?php if ( is_home() ) : $lastPosts = get_home_slider_posts( array('photos-gallery', 'expedition', 'post') ); ?>
			<?php if ( !empty( $lastPosts ) ) : ?>
				<div id="homepage-slider" class="mobile-hidden">
					<ul class="slides">
						<?php foreach ( $lastPosts as $lastPost ) :
							// Slide
							$slide = get_field( 'homepage_slider_image', $lastPost );
							// Authors
							$authors =  $lastPost->post_type !== 'post' ? get_authors( $lastPost, $locale ) : [];
						?>
							<li>
								<?php if ( $slide ) : ?>
					            	<img src="<?php echo $slide['url']; ?>" alt="<?php echo $lastPost->post_title; ?>" />
					            <?php else: ?>
					               	<img src="<?php bloginfo('template_directory'); ?>/img/default/slider_image.jpg" alt="<?php echo $lastPost->post_title; ?>" />
					            <?php endif; ?>
								<div class="flex-caption">
									<span class="post-type"><?php echo __( $lastPost->post_type, 'opp' ); ?></span>
									<?php if ( $lastPost->post_type === 'post' ) : ?>
										<h3 class="date"><?php echo get_the_date( 'l j F Y', $lastPost->ID ); ?></h3>
									<?php endif; ?>
									<h2 class="title"><?php echo $lastPost->post_title; ?></h2>
									<?php if ( $authors ) : ?>
										<h3 class="contributors">
											<?php foreach ( $authors['posts'] as $key => $author ) : ?>
												<?php echo $author->post_title; ?><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
											<?php endforeach; ?>
										</h3>
									<?php endif; ?>
								</div>
								<a class="read-more-link" href="<?php echo get_permalink( $lastPost ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</header>

	<main id="main-content" class="main-wrapper">

		<!-- Search panel -->
		<?php if ( is_home() || !in_array( $post->post_type, $GLOBALS['post_type_subpages'] ) ) : ?>
			<section class="panel panel-horizontal panel-top mobile-hidden" id="search" data-post-type="photos-gallery">
				<div class="container">
					<div class="row">
						<button class="btn button--panel-close">
							<span class="glyphicon glyphicon-remove"></span>
							<?php echo __( 'Close', 'opp' ); ?>
						</button>

						<?php get_search_form(); ?>

						<?php
							// Get theme and region terms
							$theme = array(
								'taxonomy'     => 'theme',
								'hierarchical' => false,
								'title_li'     => '',
								'hide_empty'   => false
							);
							$region = array(
								'taxonomy'     => 'region',
								'hierarchical' => false,
								'title_li'     => '',
								'hide_empty'   => false
							); 
						?>

						<!--<div class="filters">
							<div id="filters-theme" class="col-sm-6 col-md-6">
								<h4><?php echo __( 'Themes', 'opp' ); ?></h4>
								<ul class="clearfix">
									<?php wp_list_categories( $theme ); ?>
								</ul>
							</div>

							<div id="filters-region" class="col-sm-6 col-md-6">
								<h4><?php echo __( 'Regions', 'opp' ); ?></h4>
								<ul class="clearfix">
									<?php wp_list_categories( $region ); ?>
								</ul>
							</div>
						</div>-->
					</div>
				</div>
			</section>
		<?php endif; ?>