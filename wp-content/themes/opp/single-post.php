<?php
/**
 * The template for displaying all single post and attachments
 */

get_header(); ?>


<?php
// Start the loop.
while ( have_posts() ) : the_post();

	// All posts page
	$allPostsPage = pll_get_post( PAGE_NEWS_ID, $locale );
?>

<!-- Panel button -->
<div class="menu-bar menu-bar--page">
	<a href="<?php echo get_permalink( $allPostsPage ); ?>" title="" class="btn button--w-tooltip">
		<span class="glyphicon glyphicon-th-large"></span>
		<span class="button-tooltip button-tooltip--left"><?php echo __( 'All news', 'opp' ); ?></span>
	</a>
</div>

<!-- Title -->
<section class="main-title clearfix">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2><?php the_title(); ?></h2>
				<!--<p class="author"><?php the_author(); ?></p>-->
				<p class="date"><?php echo __( 'Published on', 'opp' ); ?> <?php the_date(); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Content -->
<section id="article" class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<?php the_content(); ?>
			</div>
		</div>

	</div>
</section>

<!-- Sharing -->
<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
	<section id="sharing" class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 sharing-buttons">
					<span><?php echo __( 'Share', 'opp' ); ?></span>
					<?php ADDTOANY_SHARE_SAVE_KIT(); ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>