<!-- Cover image & title -->
<section class="main-title main-title--chapter">
	<div class="main-cover main-cover--blurry-bg mobile-hidden">just to insert a blurry background image</div>
	<div class="chapter-cover mobile-hidden">
		<?php if ( $cover ) : ?>
            <?php echo $cover; ?>
        <?php else: ?>
            <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php echo get_the_title( $firstPage ); ?>" />
        <?php endif; ?>
		<span class="overlay"></span>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 ">
				<h2><?php echo get_the_title( $firstPage ); ?></h2>
				<h3><?php the_title(); ?></h3>
			</div>
		</div>
	</div>
</section>

<!-- Content -->
<?php if ( $post->post_content ): ?>
	<section class="content">
		<div class="container">
			<div class="row"><?php the_content(); ?></div>
			<!-- Sharing -->
			<?php if ( empty($children) && function_exists( 'ADDTOANY_SHARE_SAVE_KIT' )  ) : ?>
				<div class="row">
					<div class="sharing-buttons">
						<span><?php echo __( 'Share', 'opp' ); ?></span>
						<?php ADDTOANY_SHARE_SAVE_KIT(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<!-- Summary of next pages -->
<?php if (!empty($children)): ?>
	<section class="slides-summary">
		<div class="container">
			<div class="row">
				<h4><?php echo __( 'In this chapter', 'opp' ); ?></h4>
				<ol>
					<?php foreach ( $children as $slide ) : ?>	
						<li><a href="<?php echo get_permalink( $slide->ID ); ?>"><?php echo $slide->post_title; ?></a></li>
					<?php endforeach; ?>
				</ol>
			</div>
			<!-- Sharing -->
			<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
				<div class="row">
					<div class="sharing-buttons">
						<span><?php echo __( 'Share', 'opp' ); ?></span>
						<?php ADDTOANY_SHARE_SAVE_KIT(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<?php
	// Previous/next post navigation.
	foreach ( $allPages as $index => $page ) {
		if ( $page->ID === $post->ID ) {
			$nextPage = $allPages[$index + 1];
			$previousPage = $allPages[$index - 1];
		}
	}

	$previousPage = $previousPage ? $previousPage : get_post( $firstPage );
	$allExpeditionsPageID = pll_get_post( PAGE_EXPEDITIONS_ID, $locale );
	$nextPage = $nextPage ? $nextPage : get_post( $allExpeditionsPageID );
?>
<nav class="previous-next-page">
	<div class="container">
		<div class="row">
		<?php if ( isset( $previousPage ) ) : ?>
			<a class="col-sm-6 col-md-6 btn btn-default btn-lg <?php echo isset( $nextPage ) ? 'previous' : ''; ?>" href="<?php echo get_permalink( $previousPage->ID ); ?>">
				<span class="glyphicon glyphicon-menu-left"></span>
				<?php echo $previousPage->post_title; ?>
			</a>
		<?php endif; ?>

		<?php if ( isset( $nextPage ) ) : ?>
			<a class="col-sm-6 col-md-6 btn btn-default btn-lg <?php echo isset( $previousPage ) ? 'next' : ''; ?>" href="<?php echo get_permalink( $nextPage->ID ); ?>">
				<?php echo $nextPage->post_title; ?>
				<span class="glyphicon glyphicon-menu-right"></span>
			</a>
		<?php endif; ?>
		</div>
	</div>
</nav>