<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage OPP
 * @since OPP 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" class="thumbnail">

	<div class="caption">
		<span class="label label-primary">
		<?php
			if ( get_post_type() == 'post' ) :
				echo __( 'post', 'opp' );
			elseif ( get_post_type() == 'contributor' ) :
				echo __( 'contributor', 'opp' );
			else :
				echo __( get_post_type(), 'opp' );
			endif;
		?>
		</span>
		<h2><?php the_title(); ?></h2>
		<?php if ( get_post_type() == 'post' ) : ?>
			<p class="date"><?php echo get_the_date(); ?></p>
		<?php endif; ?>
		<?php the_excerpt(); ?>
		<a class="read-more-link" href="<?php echo get_permalink(); ?>">
    		<?php echo __( 'See more', 'opp' ); ?>
    		<span class="glyphicon glyphicon-menu-right"></span>
    	</a>
	</div>

	<a class="read-more-link" href="<?php echo get_permalink(); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>

</article>
