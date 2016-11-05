<!-- Title -->
<section class="main-title">
	<div class="container">
		<div class="row">

			<div class="col-sm-12 col-md-12">
				<h2><?php the_title(); ?></h2>
				<span><?php the_date( 'l j F Y' ); ?></span>
			</div>

		</div>
	</div>
</section>

<!-- Content -->
<section class="content">
	<div class="container">
		<div class="row"><?php the_content(); ?></div>
		<!-- Sharing -->
		<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
			<div class="row">
				<div class="sharing-buttons">
					<span><?php echo __( 'Share', 'opp' ); ?></span>
					<?php ADDTOANY_SHARE_SAVE_KIT(); ?>
				</div>
			</div>
		<?php endif; ?>
	<div>
</section>

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