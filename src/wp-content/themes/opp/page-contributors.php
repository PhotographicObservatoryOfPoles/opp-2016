<?php
/*
  Template Name: Contributors
*/

get_header(); 

// Get contributors
$contributors = new WP_Query( array(
	'orderby'   	 => 'meta_value',
	'meta_key'  	 => 'last_name',
	'order'          => 'ASC',
	'posts_per_page' => -1,
	'post_type'  	 => 'contributor',
	'post_status'	 => 'publish',
	'tax_query' => array(
		array(
			'taxonomy' => 'contributor-type',
			'field'    => 'slug',
			'terms'    => 'photography-contributor',
		),
	),
) );

$index = 0;

// Get super-contributors linked to last news
$lastNews = get_last_posts( 'post', 1 );
$lastNews = $lastNews[0];
$superContributors = get_linked_contributors( $lastNews, $locale );

?>

<!-- Title -->
<section class="main-title main-title--page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h2><?php the_title(); ?></h2>
			</div>
		</div>
	</div>
</section>

<!-- Super-contributors -->
<?php if ( count($superContributors['posts']) ) : ?>
	<section class="container mobile-hidden">
		<div class="row">
			<div id="contributors-slider" class="col-sm-12 col-md-12">
				<ul class="slides">
					<?php
						$superContributorsBanner = get_field( 'linked_contributors_banner', $lastNews );
						$extract = wp_strip_all_tags( get_post_field( 'post_content', $lastNews ) );
			        	$extract = strlen( $extract ) > 200 ? mb_substr( $extract, 0, 200 ) . '...' : $lastNews;
					?>
					<li>
						<?php if ( $superContributorsBanner ) : ?>
			            	<img src="<?php echo $superContributorsBanner['url']; ?>" alt="<?php echo $lastNews->post_title; ?>" />
			            <?php else: ?>
			               	<img src="<?php bloginfo('template_directory'); ?>/img/default/slider_image.jpg" alt="<?php echo $lastNews->post_title; ?>" />
			            <?php endif; ?>
						<div class="flex-caption">
							<h2 class="title <?php if (count($superContributors['posts']) > 1) { echo 'title-small'; } ?>">
								<?php foreach ( $superContributors['posts'] as $key => $superContributorID ) : $superContributor = get_post( $superContributorID, $locale ); ?>
									<?php echo $superContributor->post_title; ?><?php echo $key !== $superContributors['lastKey'] ? $key === $superContributors['lastKey'] - 1 ? ' ' . __( 'and', 'opp' ) . ' ' : ',' : ''; ?>
								<?php endforeach; ?>
							</h2>
							<h3 class="subtitle"><?php echo $lastNews->post_title; ?></h2>
							<p><?php echo $extract; ?></p>
			        		<a class="read-more-link" href="<?php echo get_permalink( $lastNews ); ?>">
				        		<?php echo __( 'Read the news', 'opp' ); ?>
				        		<span class="glyphicon glyphicon-menu-right"></span>
				        	</a>
						</div>
						<a class="read-more-link" href="<?php echo get_permalink( $lastNews ); ?>" title="<?php echo __( 'Read the news', 'opp' ); ?>"></a>
					</li>
				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- Contributors -->
<?php if ( $contributors->have_posts() ) : ?>
	<div class="container">
		<?php if ( count($superContributors['posts']) ) : ?>
			<section class="row mobile-hidden">
				<div class="main-title main-title--section clearfix">
					<div class="col-sm-12 col-md-12">
						<h3><?php echo __( 'All contributors', 'opp' ); ?></h3>
					</div>
				</div>
			</section>
		<?php endif; ?>
		<section class="row">
			<span class="spinner"></span>

			<div id="filters-result" class="col-sm-12 col-md-12 transitions-enabled fluid masonry js-masonry grid">
			<?php while ( $contributors->have_posts() ) : $index++;
					// Post
					$contributor = get_post( $contributors->the_post() );
					// Thumbnail
					$thumbnail = get_field( 'photo', $contributor );
					// Job
					$job = get_field( 'job', $contributor );
		    ?>
				<div class="col-sm-3 col-md-3 <?php echo $index % 2 !== 0 ? 'break' : ''; ?> grid-item">
				  	<div class="thumbnail thumbnail-square">
				  		<div class="image">
				  			<?php if ( $thumbnail ) : ?>
				  				<img src="<?php echo $thumbnail['sizes']['medium']; ?>" alt="<?php echo $contributor->post_title; ?>" />
				  			<?php else : ?>
				  				<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="<?php echo $contributor->post_title; ?>" />
				  			<?php endif; ?>
				  			<button class="read-more-button" role="button">
				       			<span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
				       		</button>
				  		</div>
				      	<div class="caption">
				        	<h3><?php echo $contributor->post_title; ?></h3>
				      	</div>
			       		<a class="read-more-link" href="<?php echo get_permalink( $contributor ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
				    </div>
				</div>
			<?php endwhile; ?>
			
			</div>

		</section>
	</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>