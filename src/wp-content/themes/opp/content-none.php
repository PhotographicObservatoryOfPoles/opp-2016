<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage OPP
 * @since OPP 1.0
 */
?>

<section class="container">
	<div class="row">
		<div class="col-sm-12 col-ms-12">
			<h3><?php echo __( 'Nothing Found', 'opp' ); ?></h3>
		</div>
	</div>
</section>

<section class="container">
	<div class="row">
		<div class="col-sm-12 col-ms-12">
			<?php if ( is_search() ) : ?>

				<p><?php echo __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'opp' ); ?></p>
				<?php get_search_form(); ?>

			<?php else : ?>

				<p><?php echo __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'opp' ); ?></p>
				<?php get_search_form(); ?>

			<?php endif; ?>
		</div>
	</div>
</section>
