<?php
/*
  Template Name: Confirmation don
*/

get_header();

$observatoryPageID = pll_get_post( PAGE_OBSERVATORY_ID, $locale );

?>

<!-- Title -->
<section class="main-title main-title--page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2><?php the_title(); ?></h2>
			</div>
		</div>
	</div>
</section>

<!-- Content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<p><?php echo __( 'Your donation has been taken into account. Thank you for your generosity!', 'opp' ); ?></p>
				<?php echo do_shortcode( $post->post_content ); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<a href="<?php echo get_permalink( $observatoryPageID ) ?>" class="btn btn-primary"><?php echo __( 'Back to the Observatory page', 'opp' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>