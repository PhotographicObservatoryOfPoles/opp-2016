<?php
/**
 * The template for displaying all single contributor posts and attachments
 */

get_header(); ?>


<?php
// Start the loop.
while ( have_posts() ) : the_post();

	// Cover image
	$cover = get_the_post_thumbnail( $post, 'large' );
	if ($cover) {
		$coverInfos = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		$coverURL = $coverInfos[0];
	}

	// Photo
 	$photo = get_field( 'photo', $post );

 	// Job
 	$job = get_field( 'job', $post );

 	// Website
 	$website = get_field( 'website', $post );

 	// Contributions
 	/* All contributions */
	$contributions = new WP_Query( array(
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => -1,
		'post_type'  	 => array( 'photos-gallery', 'expedition' ),
		'post_status'	 => 'publish',
		'post_parent'	 => 0,
		'meta_query' 	 => array(array(
					            'key' => 'authors',
					            'value' => '"' . $post->ID . '"',
					            'compare' => 'LIKE'
					        ))
		)
	);
	/* Last contributions */
	$strlen = strlen( wp_strip_all_tags( $post->post_content ) );
	$nbLastContributions = 1;
	if ( $strlen > 800 ) {
		$nbLastContributions = 2;
	}
	if ( $strlen > 1500 ) {
		$nbLastContributions = 3;
	}
	$lastContributions = array_slice( $contributions->posts, 0, $nbLastContributions );

	// All contributors page
	$allContributorsPage = pll_get_post( PAGE_CONTRIBUTORS_ID, $locale );
?>

<!-- Panel button -->
<div class="menu-bar menu-bar--page">
	<a href="<?php echo get_permalink( $allContributorsPage ); ?>" class="btn button--w-tooltip">
		<span class="glyphicon glyphicon-th-large"></span>
		<span class="button-tooltip button-tooltip--left"><?php echo __( 'All contributors', 'opp' ); ?></span>
	</a>
</div>
	
<!-- Cover image -->
<div class="main-cover main-cover--blurry-bg mobile-hidden"><!-- just to insert a blurry background image --></div>
<div class="main-cover mobile-hidden">
	<a href="#biography" class="scroll" data-scroll-offset="10">
		<?php if ( $cover ) : ?>
			<?php echo $cover; ?>
		<?php else : ?>
			<img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php the_title(); ?>" />
		<?php endif; ?>
	</a>
</div>

<!-- Name and job -->
<section class="intro">
	<div class="container">

		<div class="photo">
			<?php if ( $photo ) : ?>
				<img src="<?php echo $photo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" />
			<?php else : ?>
				<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="<?php the_title(); ?>" />
			<?php endif; ?>
		</div>

		<div class="row">
			<div class="col-sm-7 col-md-7">
				<h2><?php the_title(); ?></h2>
				<?php if ( $job ) : ?>
					<h3 class="job"><?php echo $job; ?></h3>
				<?php endif; ?>
				<?php if ( $website ) : ?>
					<h3 class="website">
						<a href="<?php echo $website; ?>" target="_blank" title="<?php echo str_replace('http://www.', '', $website); ?>">
							<span class="glyphicon glyphicon-globe"></span>
							<?php echo __( 'Website', 'opp' ); ?>
						</a>
					</h3>
			<?php endif; ?>
			</div>
		</div>

	</div>
</section>

<!-- Biography -->
<section id="biography" class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-md-8 about">
				<h3><?php echo __( 'About', 'opp' ); ?></h3>
				<?php the_content(); ?>
				<!-- Sharing -->
				<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
					<div class="sharing-buttons">
						<span><?php echo __( 'Share', 'opp' ); ?></span>
						<?php ADDTOANY_SHARE_SAVE_KIT(); ?>
					</div>
				<?php endif; ?>
			</div>

		<?php if ( !empty( $lastContributions ) ) : ?>
			<div class="col-sm-4 col-md-4 last-contributions mobile-hidden">
				<h3><?php echo count( $lastContributions ) > 1 ? __( 'Last contributions', 'opp' ) : __( 'Last contribution', 'opp' ); ?></h3>
				<?php foreach ( $lastContributions as $lastContribution ) :
					// Post
					$contribution = get_post( $lastContribution );
					// Thumbnail
					$thumbnail = get_the_post_thumbnail( $contribution, 'large' );
					// Authors
					$authors = get_authors( $contribution, $locale );
					// Terms (theme & region)
					$terms = get_theme_region_terms( $contribution, true );
				?>
				  	<div class="thumbnail">
				        <div class="image">
				            <?php echo $thumbnail;  ?>
				            <button class="read-more-button" role="button">
				                <span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
				            </button>
				        </div>
				        <div class="caption post-type">
				        	<span class="label label-primary"><?php echo __( $contribution->post_type, 'opp' ); ?></span>
				        </div>
				        <div class="caption">
				            <h3><?php echo $contribution->post_title; ?></h3>
				            <h4>
				                <?php foreach ( $authors['posts'] as $key => $author ) : ?>
				                    <a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
				                <?php endforeach; ?>
				            </h4>
				           	<a class="read-more-link" href="<?php echo get_permalink( $contribution ); ?>">
				                <?php echo __( 'See more', 'opp' ); ?>
				                <span class="glyphicon glyphicon-menu-right"></span>
				            </a>
				        </div>
				        <div class="caption tags">
				            <?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
				                <a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
				            <?php endforeach; ?>
				        </div>
				        <a class="read-more-link" href="<?php echo get_permalink( $contribution ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
				    </div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

		</div>
	</div>
</section>

<!-- Contributions -->
<?php if ( count($contributions->posts) > count($lastContributions) ) : ?>
	<section class="contributions mobile-hidden">
		<div class="container">
			<div class="row">
				<h3><?php echo __( 'All contributions', 'opp' ); ?></h3>
				<div class="transitions-enabled fluid masonry js-masonry grid">
					<?php while ( $contributions->have_posts() ) :
						// Post
						$contribution = get_post( $contributions->the_post() );
						// Thumbnail
						$thumbnail = get_the_post_thumbnail( $contribution, 'large' );
						// Authors
						$authors = get_authors( $contribution, $locale );
						// Terms (theme & region)
						$terms = get_theme_region_terms( $contribution, true );
						// Description
			        	$description = get_field( 'description', $contribution, false );
			        	$description = strlen( $description ) > 100 ? mb_substr( $description, 0, 100 ) . '...' : $description;
					?>
						<div class="col-sm-4 col-sm-4 grid-item">
							<div class="thumbnail">
						        <div class="image">
						            <?php echo $thumbnail; ?>
						            <button class="read-more-button" role="button">
						                <span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
						            </button>
						        </div>
						        <div class="caption post-type">
						        	<span class="label label-primary"><?php echo __( $contribution->post_type, 'opp' ); ?></span>
						        </div>
						        <div class="caption">
						            <h3><?php echo $contribution->post_title; ?></h3>
						            <h4>
						                <?php foreach ( $authors['posts'] as $key => $author ) : ?>
						                    <a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
						                <?php endforeach; ?>
						            </h4>
						            <p><?php echo $description; ?></p>
						            <a class="read-more-link" href="<?php echo get_permalink( $contribution ); ?>">
						                <?php echo __( 'See more', 'opp' ); ?>
						                <span class="glyphicon glyphicon-menu-right"></span>
						            </a>
						        </div>
						        <div class="caption tags">
						            <?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
						                <a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
						            <?php endforeach; ?>
						        </div>
						        <a class="read-more-link" href="<?php echo get_permalink( $contribution ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
						    </div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>

<style type="text/css">
	.main-cover--blurry-bg {
		background: #181818 url("<?php echo $cover ? $coverURL : bloginfo('template_directory') . '/img/default/cover_image.jpg'; ?>") repeat center;
	}
</style>