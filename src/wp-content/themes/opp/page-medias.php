<?php
/*
  Template Name: Medias
*/

get_header();

?>

<?php while ( have_posts() ) : the_post(); ?>
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
	<section class="container content">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
<?php endwhile; ?>

<?php get_footer(); ?>