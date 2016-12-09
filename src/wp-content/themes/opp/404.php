<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage OPP
 * @since OPP 1.0
 */

get_header(); ?>

<!-- Title -->
<section class="main-title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2><?php echo __( '404', 'opp' ); ?></h2>
			</div>
		</div>
	</div>
</section>

<!-- Content -->
<section class="container content">
	<div class="row">

		<div class="col-sm-12 col-md-12">
			<h2 class="page-title"><?php echo __( 'Oops! That page can&rsquo;t be found.', 'opp' ); ?></h2>

			<div class="page-content">
				<p><?php echo __( 'It looks like nothing was found at this location. Maybe try a search?', 'opp' ); ?></p>

				<div class="mobile-hidden"><?php get_search_form(); ?></div>

				<a class="btn btn-primary" href="<?php echo pll_home_url( $locale ); ?>">
					<?php echo __( 'Back to homepage', 'opp' ); ?>
				</a>
			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>
