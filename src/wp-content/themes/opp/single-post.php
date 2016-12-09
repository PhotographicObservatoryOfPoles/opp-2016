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

	// Linked contributors
	$linkedContributors = get_linked_contributors( $post, $locale );
	$nbLinkedContributors = count( $linkedContributors['posts'] );
?>

<!-- Panel button -->
<div class="menu-bar menu-bar--page">
	<a href="<?php echo get_permalink( $allPostsPage ); ?>" class="btn button--w-tooltip">
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

<!-- Linked contributors -->
<?php if ( $nbLinkedContributors ) : ?>
	<section id="linked-contributors" class="contributors mobile-hidden">
		<div class="container">
			<div class="row">
				<?php foreach ( $linkedContributors['posts'] as $index => $contributor ) :
					// Class
					$class = ( $index % 2 === 0 && ($index + 1) > $linkedContributors['lastKey']) ? 'col-sm-12 col-md-12' : 'col-sm-6 col-md-6';
					$class .= $index % 2 === 0 ? ' break' : '';
					// Photo
					$photo = get_field( 'photo', $contributor->ID );
					// Biography
					$biography = strip_tags( get_post_field( 'post_content', $contributor->ID ) );
					$maxLength = ( $index % 2 === 0 && ($index + 1) > $contributors['lastKey'] ) ? 250 : 100;
					$biography = strlen( $biography ) > $maxLength ? mb_substr( $biography, 0, $maxLength ) . '...' : $biography;
				?>
					<div class="<?php echo $class; ?>">
						<?php if ( $photo ) : ?>
							<img src="<?php echo $photo['sizes']['thumbnail']; ?>" alt="<?php echo $contributor->post_title; ?>" />
						<?php else : ?>
							<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="<?php echo $contributor->post_title; ?>" width="150" />
						<?php endif; ?>
						<h3><?php echo $contributor->post_title; ?></h3>
						<p><?php echo $biography ?></p>
						<a href="<?php echo get_permalink ($contributor->ID); ?>"><?php echo __( 'See more', 'opp' ); ?></a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>