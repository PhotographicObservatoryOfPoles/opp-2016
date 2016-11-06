<!-- Cover image -->
<div class="main-cover main-cover--blurry-bg mobile-hidden">just to insert a blurry background image</div>
<div class="main-cover">
	<a href="#intro" class="scroll" data-scroll-offset="70">
		<?php if ( $cover ) : ?>
            <?php echo $cover; ?>
        <?php else: ?>
            <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="" />
        <?php endif; ?>
		<span class="glyphicon glyphicon-menu-down mobile-hidden"></span>
	</a>
</div>

<!-- Title & authors -->
<section id="intro" class="main-title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2><?php the_title(); ?></h2>
				<div class="authors">
					<?php foreach ( $authors['posts'] as $key => $author ) : ?>
						<h3>
							<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a>
						</h3>
					<?php endforeach; ?>
				</div>
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
	</div>
</section>

<!-- Map -->
<section class="map mobile-hidden">
	<div class="container">
		<div class="row">
			<h3><?php echo __( 'Expedition map', 'opp' ); ?></h3>
			<div class="acf-map">
				<?php foreach ( $locations as $location ) : ?>
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
						<p class="marker-infos"><?php echo $location['address']; ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- Next page -->
<?php if ( isset($allPages[0]) ) : $nextPage = $allPages[0]; ?>
	<nav class="previous-next-page">
		<div class="container">
			<a class="btn btn-default btn-xlg" href="<?php echo get_permalink( $nextPage->ID ); ?>">
				<?php echo __('Discover the expedition', 'opp'); ?>
				<span class="glyphicon glyphicon-menu-right"></span>
			</a>
		</div>
	</nav>
<?php endif; ?>