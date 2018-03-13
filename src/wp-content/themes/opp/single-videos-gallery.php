<?php
/**
 * The template for displaying all single gallery posts and attachments
 */

get_header(); ?>

<?php
// Start the loop.
while ( have_posts() ) : the_post();
	// Subtitle
	$subtitle = get_field( 'subtitle' );

	// Authors
	$authors = get_authors( $post, $locale );
	$nbAuthors = count( $authors['posts'] );

	// Description
	$description = get_field( 'description' );

	// Geolocation
	$geolocation = get_field( 'geolocation' );

	// Terms (themes & regions)
	$terms = get_theme_region_terms( $post );

	// Featured galleries
	$featuredGalleries = get_featured_posts( $post, $terms, true, 3 );

	// All galleries page
	$allGalleriesPage = pll_get_post( PAGE_VIDEOS_GALLERIES_ID, $locale );
?>

<!-- Panel button -->
<div class="menu-bar menu-bar--page">
	<a href="<?php echo get_permalink( $allGalleriesPage ); ?>" class="btn button--w-tooltip">
		<span class="glyphicon glyphicon-th-large"></span>
		<span class="button-tooltip button-tooltip--left"><?php echo __( 'All videos', 'opp' ); ?></span>
	</a>
</div>

<!-- Title & authors -->
<section class="main-title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2><?php the_title(); ?></h2>
				<?php if ( $subtitle ) : ?>
					<h5 class="subtitle"><?php echo $subtitle; ?></h5>
				<?php endif; ?>
				<div class="authors">
					<?php foreach ( $authors['posts'] as $key => $author ) : ?>
						<h3>
							<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
						</h3>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Description -->
<section class="content">
	<div class="container">
		<div id="skipping-link" class="row">
			<a href="#videos" class="scroll btn btn-default" data-scroll-offset="-20">
				<span class="glyphicon glyphicon-menu-down"></span>
				<?php echo __( 'Watch', 'opp' ); ?>
			</a>
		</div>
		<div class="row">
			<?php echo $description; ?>
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

<!-- Map -->
<?php if( !empty( $geolocation ) ) : ?>
	<section class="map mobile-hidden">
		<div class="container">
			<div class="row">
				<h3><?php echo __( 'Location', 'opp' ); ?></h3>
				<h4><?php echo $geolocation['address']; ?></h4>
				<div class="acf-map">
					<div class="marker current" data-lat="<?php echo $geolocation['lat']; ?>" data-lng="<?php echo $geolocation['lng']; ?>"></div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- Gallery / Video -->
<section id="videos" class="gallery">
	<div class="content">
		<?php the_content(); ?>
	</div>
	<!-- Sharing -->
	<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
	<div class="sharing-buttons">
		<?php ADDTOANY_SHARE_SAVE_KIT(); ?>
	</div>
	<?php endif; ?>
</section>

<!-- Contributors -->
<section class="contributors">
	<div class="container">
		<div class="row mobile-hidden">
			<?php foreach ( $authors['posts'] as $index => $author ) :
				// Class
				$class = ( $index % 2 === 0 && ($index + 1) > $authors['lastKey']) ? 'col-sm-12 col-md-12' : 'col-sm-6 col-md-6';
				$class .= $index % 2 === 0 ? ' break' : '';
				// Photo
				$photo = get_field( 'photo', $author->ID );
				// Biography
				$biography = strip_tags( get_post_field( 'post_content', $author->ID ) );
				$maxLength = ( $index % 2 === 0 && ($index + 1) > $authors['lastKey'] ) ? 270 : 100;
				$biography = strlen( $biography ) > $maxLength ? mb_substr( $biography, 0, $maxLength ) . '...' : $biography;
			?>
				<div class="<?php echo $class; ?>">
					<?php if ( $photo ) : ?>
						<img src="<?php echo $photo['sizes']['thumbnail']; ?>" alt="<?php echo $author->post_title; ?>" />
					<?php else : ?>
		  				<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="<?php echo $author->post_title; ?>" width="150" />
		  			<?php endif; ?>
					<h3><?php echo $author->post_title; ?></h3>
					<p><?php echo $biography ?></p>
					<a href="<?php echo get_permalink ($author->ID); ?>"><?php echo __( 'See more', 'opp' ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Featured galleries -->
<?php if ( count( $featuredGalleries ) ) : ?>
	<section class="featured-galleries">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<h3 class="title"><?php echo __( 'Here are other videos that should please you', 'opp' ); ?></h3>
				</div>
			</div>
			<div class="row">
				<?php foreach ( $featuredGalleries as $featuredGallery ) :
						// Thumbnail
						$thumbnail = get_the_post_thumbnail( $featuredGallery, 'medium_large' );
						// Auhtors
						$authors = get_authors( $featuredGallery, $locale );
						// Terms (theme & region)
						$terms = get_theme_region_terms( $featuredGallery, true );
						// Description
						$description = get_field( 'description', $featuredGallery, false );
		        $description = strlen( $description ) > 150 ? mb_substr( $description, 0, 150 ) . '...' : $description;
				?>
				<div class="col-sm-4 col-md-4">
				  	<div class="thumbnail">
				  		<div class="image">
				  			<?php if ( $thumbnail ) : ?>
					            <?php echo $thumbnail; ?>
					        <?php else: ?>
					            <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php echo $featuredGallery->post_title; ?>" />
					        <?php endif; ?>
				        	<button class="read-more-button" role="button">
				                <span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
				            </button>
				        </div>
				        <div class="caption">
				            <h3><?php echo $featuredGallery->post_title; ?></h3>
				            <h4>
				                <?php foreach ( $authors['posts'] as $key => $author ) : ?>
				                    <a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo ( $key !== $authors['lastKey'] ) ? ',' : ''; ?>
				                <?php endforeach; ?>
				            </h4>
				            <p><?php echo $description; ?></p>
				            <a class="read-more-link" href="<?php echo get_permalink( $featuredGallery ); ?>">
				                <?php echo __( 'See more', 'opp' ); ?>
				                <span class="glyphicon glyphicon-menu-right"></span>
				            </a>
				        </div>
				        <div class="caption tags">
				            <?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
				                <a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
				            <?php endforeach; ?>
				        </div>
				        <a class="read-more-link" href="<?php echo get_permalink( $featuredGallery ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
				    </div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
// End the loop.
endwhile; ?>

<?php get_footer(); ?>
