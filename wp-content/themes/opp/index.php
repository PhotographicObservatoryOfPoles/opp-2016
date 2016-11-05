<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<?php if (is_home() ) : ?>

	<section id="about" class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="main-title main-title--page">
					<h2><?php echo __( 'About', 'opp' );  ?></h2>
				</div>
			</div>
		</div>
		<div class="row content">
			<?php 
				$aboutPage = get_post( PAGE_OBSERVATORY_ABOUT_ID, $locale );
				$about = wp_strip_all_tags( get_post_field( 'post_content', $aboutPage ) );
			?>
			<div class="col-sm-12 col-md-12">
				<p><?php echo mb_substr( $about, 0, 425 ); ?></p>
				<div class="read-more-link">
					<a class="btn btn-default" href="<?php echo get_permalink( PAGE_OBSERVATORY_ID ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>">
						<?php echo __( 'See more', 'opp' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section id="news" class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="main-title main-title--page">
					<h2><?php echo __( 'News', 'opp' );  ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php $news = get_last_posts( 'post', 1 ); ?>
			<?php 
				foreach ( $news as $article ) :
					// Extract
		        	$extract = wp_strip_all_tags( get_post_field( 'post_content', $article ) );
		        	$extract = strlen( $extract ) > 500 ? mb_substr( $extract, 0, 500 ) . '...' : $extract;
		        	// Categories
		        	$categories = wp_get_post_categories( $article->ID );
		        	// Terms
		        	$terms = wp_get_post_terms( $article->ID );
			?>
				<div class="col-sm-12 col-md-12">
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
			<?php endforeach; ?>
		</div>
	</section>

	<section id="discover" class="container mobile-hidden">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="main-title main-title--page">
					<h2><?php echo __( 'Discover', 'opp' ); ?></h2>
				</div>
			</div>
		</div>

		<div class="row">
			<?php 
				$posts = get_random_posts( ['expedition', 'photos-gallery'], 5 );
				$index = 0;

				$randomIndex = rand(0, count($posts) - 1);
				$mainPost = $posts[$randomIndex];
				unset($posts[$randomIndex]);

				// Thumbnail
				$mainPostThumbnail = get_the_post_thumbnail( $mainPost, 'large' );
				// Auhtors
				$mainPostAuthors = get_authors( $mainPost, $locale );
				// Terms (theme & region)
				$mainPostTerms = get_theme_region_terms( $mainPost, true );
				// Description
	        	$mainPostDescription = $mainPost->post_type === 'photos-gallery' ? get_field( 'description', $mainPost, false ) :
                                        wp_strip_all_tags( get_post_field( 'post_content', $mainPost ) );
	        	$mainPostDescription = strlen( $mainPostDescription ) > 370 ? mb_substr( $mainPostDescription, 0, 370 ) . '...' : $mainPostDescription;
			?>
			<div id="main-post" class="col-sm-12 col-md-6">
				<div class="thumbnail thumbnail--big">
			  		<div class="image">
			  			<?php if ( $mainPostThumbnail ) : ?>
			                <?php echo $mainPostThumbnail; ?>
			            <?php else: ?>
			                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="" />
			            <?php endif; ?>
			  			<button class="read-more-button" role="button">
			       			<span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
			       		</button>
			  		</div>
			      	<div class="caption">
			      		<small class="post-type"><?php echo __( $mainPost->post_type, 'opp' ); ?></small>
			        	<h3><?php echo $mainPost->post_title; ?></h3>
			        	<h4>
				        	<?php foreach ( $mainPostAuthors['posts'] as $key => $author ) : ?>
								<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $mainPostAuthors['lastKey'] ? ',' : ''; ?>
							<?php endforeach; ?>
			        	</h4>
			        	<div class="description"><?php echo $mainPostDescription; ?></div>
			        	<a class="read-more-link" href="<?php echo get_permalink( $mainPost ); ?>">
			        		<?php echo __( 'See more', 'opp' ); ?>
			        		<span class="glyphicon glyphicon-menu-right"></span>
			        	</a>
			      	</div>
			      	<div class="caption tags">
			      		<?php foreach ( $mainPostTerms as $key => $termID ) : $term = get_term( $termID ); ?>
		       				<a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
		       			<?php endforeach; ?>
		       		</div>
		       		<a class="read-more-link" href="<?php echo get_permalink( $mainPost ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
		    	</div>

				<div class="col-md-12 all-posts-link">
					<a class="btn btn-default" href="<?php echo get_permalink( PAGE_GALLERIES_ID ); ?>" title="<?php echo __( 'All galleries', 'opp' ); ?>">
						<?php echo __( 'All galleries', 'opp' ); ?>
					</a>
				</div>
			</div>
			<div id="secondary-posts" class="col-sm-12 col-md-6">
				<?php foreach ( $posts as $item ) : $index++;
					// Thumbnail
					$thumbnail = get_the_post_thumbnail( $item, 'medium' );
					// Authors
					$authors = get_authors( $item, $locale );
					// Terms (theme & region)
					$terms = get_theme_region_terms( $item, true );
					// Description
		        	$description = get_field( 'description', $item, false );
		        	$description = strlen( $description ) > 150 ? mb_substr( $description, 0, 150 ) . '...' : $description;
				?>
					<div class="col-sm-6 col-md-6 thumbnail--small-wrapper <?php echo $index % 2 !== 0 ? 'break' : ''; ?>">
						<div class="thumbnail thumbnail--small">
					  		<div class="image">
					  			<?php if ( $thumbnail ) : ?>
					                <?php echo $thumbnail; ?>
					            <?php else: ?>
					                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="" />
					            <?php endif; ?>
					  			<button class="read-more-button" role="button">
					       			<span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
					       		</button>
					  		</div>
					      	<div class="caption">
					      		<small class="post-type"><?php echo __( $item->post_type, 'opp' ); ?></small>
					        	<h3><?php echo $item->post_title; ?></h3>
					        	<h4>
						        	<?php foreach ( $authors['posts'] as $key => $author ) : ?>
										<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
									<?php endforeach; ?>
					        	</h4>
					        	<!--<p><?php echo $description; ?></p>-->
					        	<a class="read-more-link" href="<?php echo get_permalink( $item ); ?>">
					        		<?php echo __( 'See more', 'opp' ); ?>
					        		<span class="glyphicon glyphicon-menu-right"></span>
					        	</a>
					      	</div>
					      	<div class="caption tags">
					      		<?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
				       				<a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
				       			<?php endforeach; ?>
				       		</div>
				       		<a class="read-more-link" href="<?php echo get_permalink( $item ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
				    	</div>
			    	</div>
				<?php endforeach; ?>

				<div class="col-md-12 all-posts-link">
					<a class="btn btn-default" href="<?php echo get_permalink( PAGE_EXPEDITIONS_ID ); ?>" title="<?php echo __( 'All expeditions', 'opp' ); ?>">
						<?php echo __( 'All expeditions', 'opp' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section id="explore" class="mobile-hidden">
		<div class="main-title main-title--page">
			<h2><?php echo __( 'Explore', 'opp' ); ?></h2>
		</div>
		<a id="map-link" class="full-width-link" href="<?php echo get_permalink( PAGE_MAP_ID ); ?>">
			<div class="main-title main-title--page">
				<h2><?php echo __( 'Browse the map', 'opp' ); ?></h2>
			</div>
		</a>
	</section>

	<section id="contributors" class="container mobile-hidden">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="main-title main-title--page">
					<h2><?php echo __( 'Our contributors', 'opp' ); ?></h2>
				</div>
			</div>
		</div>

		<?php
			// Get contributors
			$contributors = new WP_Query( array(
				'orderby'        => 'title',
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
		?>
		<?php if ( $contributors->have_posts() ) : ?>
			<div id="homepage-contributors-carousel" class="row">
				<ul class="slides">
				<?php while ( $contributors->have_posts() ) : $index++;
					// Post
					$contributor = get_post( $contributors->the_post() );
					// Thumbnail
					$thumbnail = get_field( 'photo', $contributor );
		    	?>
		    		<li class="col-sm-4 col-md-4">
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
					      	</div>
				       		<a class="read-more-link" href="<?php echo get_permalink( $contributor ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
				    	</div>
				    </li>
		    	<?php endwhile; ?>
		    	</ul>
			</div>
		<?php endif; ?>
	</section>

<?php endif; ?>

<?php get_footer(); ?>