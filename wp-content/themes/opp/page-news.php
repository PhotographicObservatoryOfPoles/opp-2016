<?php
/*
  Template Name: News
*/

get_header();

// Get news articles
$articles = new WP_Query( array(
	'orderby'        => 'date',
	'order'          => 'DESC',
	'posts_per_page' => POSTS_PER_PAGE,
	'paged' 		 => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
	'post_type'  	 => 'post',
	'post_status'	 => 'publish'
) );

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

<!-- Content -->
<?php if ( $articles->have_posts() ) : ?>
	<section class="content">
		<div class="container">
			<div class="row">
				<div class="transitions-enabled fluid masonry js-masonry grid">
					<?php while ( $articles->have_posts() ) :
						// Article
						$article = get_post( $articles->the_post() );
						// Extract
			        	$extract = wp_strip_all_tags( get_post_field( 'post_content', $article ) );
			        	$extract = strlen( $extract ) > 300 ? mb_substr( $extract, 0, 300 ) . '...' : $extract;
			        	// Categories
			        	$categories = wp_get_post_categories( $article->ID );
			        	// Terms
			        	$terms = wp_get_post_terms( $article->ID );
					?>
						<div class="col-sm-12 col-md-12 grid-item">
							<article class="thumbnail">
								<?php if ( has_post_thumbnail( $article ) ) : ?>
									<div class="image">
										<?php echo get_the_post_thumbnail( $article, 'full' ); ?>
										<button class="read-more-button" role="button">
							       			<span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
							       		</button>
									</div>
								<?php endif; ?>
								<div class="caption">
									<p class="date"><?php echo get_the_date( 'l j F Y', $article->ID ); ?></p>
									<div class="categories">
										<?php foreach ( $categories as $key => $categoryID ) : $category = get_category( $categoryID ); ?>
						       				<a href="<?php echo get_term_link( $categoryID ); ?>" class="label label-primary"><?php echo $category->name; ?></a>
						       			<?php endforeach; ?>
						       		</div>
									<h3><?php echo $article->post_title; ?></h3>
									<p><?php echo $extract; ?></p>
									<a class="read-more-link" href="<?php echo get_permalink( $article ); ?>">
						        		<?php echo __( 'See more', 'opp' ); ?>
						        		<span class="glyphicon glyphicon-menu-right"></span>
						        	</a>
								</div>
								<div class="caption tags">
						      		<?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
					       				<a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
					       			<?php endforeach; ?>
					       		</div>
								<a class="read-more-link" href="<?php echo get_permalink( $article ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
							</article>
						</div>
					<?php endwhile; ?>
				</div>

				<div class="load-more-manual">
					<nav class="page-nav" role="navigation">
						<?php next_posts_link( __( '<span class="btn btn-default">Older posts</span>', 'opp' ), $articles->max_num_pages ); ?>
					</nav>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>

<script type="text/javascript">
	$(document).ready(function() {
		// Masonry + Infinite Scroll
		var $container = $('.grid');
		var $nbPages = <?php echo $articles->max_num_pages; ?>;

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