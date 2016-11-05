<?php
/*
  Template Name: Contributors
*/

get_header(); 

// Get contributors
$contributors = new WP_Query( array(
	'orderby'        => 'title',
	'order'          => 'ASC',
	'posts_per_page' => -1,
	//'paged' 		 => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
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

<!-- Contributors -->
<?php if ( $contributors->have_posts() ) : ?>
	<div class="container">
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
				  				<img src="<?php echo $thumbnail['sizes']['medium']; ?>" alt="<?php echo $thumbnail['alt']; ?>" />
				  			<?php else : ?>
				  				<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="" />
				  			<?php endif; ?>
				  			<button class="read-more-button" role="button">
				       			<span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
				       		</button>
				  		</div>
				      	<div class="caption">
				        	<h3><?php echo $contributor->post_title; ?></h3>
				        	<!--<?php if ($job) : ?><h4><?php echo $job; ?></h4><?php endif; ?>-->
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