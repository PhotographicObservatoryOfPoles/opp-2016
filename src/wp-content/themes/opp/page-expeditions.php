<?php
/*
  Template Name: Expeditions
*/

get_header();

// Get expeditions (5 per page)
$expeditions = new WP_Query( array(
	'orderby'        => 'date',
	'order'          => 'DESC',
	'posts_per_page' => POSTS_PER_PAGE,
	'paged' 		 => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
	'post_type' 	 => 'expedition',
	'post_status' 	 => 'publish',
	'post_parent'	 => 0
) );

$index = 0;

// Get current user
$user = AAM::getUser();

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

<!-- Expeditions -->
<?php if ( $expeditions->have_posts() ) : ?>
	<div class="container">
		<section class="row">
			<span class="spinner"></span>

			<div id="filters-result" class="col-sm-12 col-md-12 grid">
			<?php  while ( $expeditions->have_posts() ) : $index++;
					// Post
					$expedition = get_post( $expeditions->the_post() );
					// Get visibility in list
					$isHidden = $user->getObject( 'post', $expedition->ID )->has('frontend.list');
					if ( $isHidden ) {
						continue;
					}
					// Thumbnail
					$thumbnail = get_the_post_thumbnail( $expedition, 'large' );
					// Authors
					$authors = get_authors( $expedition, $locale );
					// Terms (theme & region)
					$terms = get_theme_region_terms( $expedition, true );
					// Description
		        	$description = wp_strip_all_tags( get_post_field( 'post_content', $expedition ) );
		        	$description = strlen( $description ) > 300 ? mb_substr( $description, 0, 300 ) . '...' : $description;
			?>
				<div class="col-sm-6 col-md-6 <?php echo $index % 2 !== 0 ? 'break' : ''; ?> grid-item">
				  	<div class="thumbnail">
				  		<div class="image">
				  			<?php if ( $thumbnail ) : ?>
				  				<?php echo $thumbnail; ?>
				            <?php else: ?>
				                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php echo $expedition->post_title; ?>" />
				            <?php endif; ?>
				      		<button class="read-more-button" role="button">
				       			<span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
				       		</button>
				      	</div>
				      	<div class="caption">
				        	<h3><?php echo $expedition->post_title; ?></h3>
				        	<h4>
								<?php foreach ( $authors['posts'] as $key => $author ) : ?>
									<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
								<?php endforeach; ?>
				        	</h4>
				        	<p><?php echo $description; ?></p>
				        	<a class="read-more-link" href="<?php echo get_permalink( $expedition ); ?>">
				        		<?php echo __( 'See more', 'opp' ); ?>
				        		<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				        	</a>
				      	</div>
				      	<div class="caption tags">
				      		<?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
			       				<a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
			       			<?php endforeach; ?>
			       		</div>
			       		<a class="read-more-link" href="<?php echo get_permalink( $expedition ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
				    </div>
				</div>
			<?php endwhile; ?>
			</div>

			<div class="load-more-manual">
				<nav class="page-nav" role="navigation">
					<?php next_posts_link( __( '<span class="btn btn-default">More expeditions</span>', 'opp' ), $expeditions->max_num_pages ); ?>
				</nav>
			</div>

		</section>
	</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>

<script type="text/javascript">
	$(document).ready(function() {
		// Masonry + Infinite Scroll
		var $container = $('.grid');
		var $nbPages = <?php echo $expeditions->max_num_pages; ?>;

		$container.infinitescroll({
	        navSelector: '.page-nav',
	        nextSelector: '.page-nav a',
	        itemSelector: '.grid-item',
	        loading: {
	            msgText: '',
	            //finishedMsg: 'Nothing to load',
	            img: '<?php bloginfo('template_directory'); ?>' + '/img/spinner.gif'
	        }
	    }, function(newElements, opts) {

	    	if (opts.state.currPage === $nbPages) {
	    		$('.page-nav a').remove();
	    	}

	        var $newElems = $(newElements).css({
	            opacity: 0
	        });

	        $newElems.imagesLoaded(function() {
	            $newElems.animate({
	                opacity: 1
	            });
	            $container.masonry('appended', $newElems, true);
	        });
	    });

		// Pause Infinite Scroll
	    $container.infinitescroll('pause');
		
		// Resume Infinite Scroll
	    jQuery('.page-nav a').click(function() {
	    	$container.infinitescroll('retrieve');
	        return false;
	    });
	});
</script>