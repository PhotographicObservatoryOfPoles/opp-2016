<?php
/*
  Template Name: Observatory
*/

get_header(); 

// Get contributors
$contributors = new WP_Query( array(
	'orderby'        => 'title',
	'order'          => 'ASC',
	'posts_per_page' => -1,
	'post_type'  	 => 'contributor',
	'post_status'	 => 'publish',
	'tax_query' => array(
		array(
			'taxonomy' => 'contributor-type',
			'field'    => 'slug',
			'terms'    => 'team-member',
		),
	),
) );

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

<section id="about" class="content">
	<?php include( locate_template( 'partials/page-about.php' ) ); ?>
</section>

<?php $uploadsDir = wp_get_upload_dir(); ?>
<a id="brochure-link" class="full-width-link" href="<?php echo $uploadsDir['baseurl']; ?>/Plaquette-OPP.pdf" target="_blank">
	<span><?php echo __( 'Download the information brochure', 'opp' ); ?></span>
</a>

<section id="team" class="content bg-gray">
	<?php include( locate_template( 'partials/page-team.php' ) ); ?>
</section>

<section id="sponsors" class="content">
	<?php include( locate_template( 'partials/page-sponsors.php' ) ); ?>
</section>

<a id="donation-link" class="full-width-link" href="<?php echo get_permalink( pll_get_post( PAGE_DONATION_ID, $locale ) ); ?>">
	<span><?php echo __( 'Support us', 'opp' ); ?></span>
</a>

<section id="partners" class="content bg-gray">
	<?php include( locate_template( 'partials/page-partners.php' ) ); ?>
</section>

<?php get_footer(); ?>
