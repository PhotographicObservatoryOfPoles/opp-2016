<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage OPP
 * @since OPP 1.0
 */

get_header(); ?>

<section id="searchform-top" class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<?php get_search_form(); ?>
		</div>
	</div>
</section>

<section class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h2><?php printf( __( 'Search results for: %s', 'opp' ), get_search_query() ); ?></h2>
			<hr />
		</div>
	</div>
</section>

<?php if ( have_posts() ) : ?>
	<section class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<?php 
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'search' );
					endwhile; 
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<?php
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'opp' ),
						'next_text'          => __( 'Next page', 'opp' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'opp' ) . ' </span>',
					) );
				?>
			</div>
		</div>
	</section>
<?php else : ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>