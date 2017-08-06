<ul class="list-<?php echo $postType; ?>">
	<?php foreach ( $postIDs as $postID ) :
			$post = get_post( pll_get_post( $postID, $locale ) );

			// Ancestors
			$parent = null;
			$grandParent = null;

			// Description
			$description = $post->post_type === 'photos-gallery' ? get_field( 'description', $post, false ) :
                            wp_strip_all_tags( get_post_field( 'post_content', $post ) );
			$description = strlen($description) > 200 ? mb_substr( $description, 0, 200 ) . '...' : $description;

			// Terms (themes & regions)
			$themes = get_field( 'theme', $post );
        	$regions = get_field( 'region', $post );
        	$terms = array_merge($themes, $regions);

        	// Gallery
			if ($post->post_type === 'photos-gallery') {
				// Subtitle
				$subtitle = get_field( 'subtitle', $post );
				// Authors
				$authors = get_authors( $post, $locale );
				// Thumbnail
				$thumbnail = get_the_post_thumbnail( $post, 'medium' );
				// Terms (themes & regions)
				$themes = get_field( 'theme', $post );
	        	$regions = get_field( 'region', $post );
	        	$terms = array_merge($themes, $regions);
			}

			// Expedition
			if ($post->post_type === 'expedition') {
				// Ancestors
				$parent = get_post( $post->post_parent );
				$grandParent = $parent && $parent->post_parent !== 0 ? get_post( $parent->post_parent ) : false;
				// Authors
				$authors = get_field( 'authors', $parent ) ? 
					get_authors( $parent, $locale ) : get_authors( $grandParent, $locale );
				// Thumbnail
				$thumbnail = get_the_post_thumbnail( $parent, 'medium' ) ? 
					get_the_post_thumbnail( $parent, 'medium' ) : get_the_post_thumbnail( $grandParent, 'medium' );
				// Terms (themes & regions)
				$themes = get_field( 'theme', $parent ) ? get_field( 'theme', $parent ) : get_field( 'theme', $grandParent );
	        	$regions = get_field( 'region', $parent ) ? get_field( 'region', $parent ) : get_field( 'region', $grandParent );
	        	$terms = array_merge($themes, $regions);
			}
	?>
		<li class="marker-infos">

			<!-- Title(s) -->
			<div class="main-title main-title--marker">
				<small class="post-type"><?php echo $post->post_type === 'photos-gallery' ? __( 'photos-gallery', 'opp' ) : __( 'expedition', 'opp' ); ?></small>
				<?php if ( $grandParent || $parent ) : ?>
					<h4 class="parent-title">
						<?php if ($grandParent) { echo $grandParent->post_title; } ?>
						<?php if ($grandParent && $parent) { echo '&middot;'; } ?>
						<?php if ($parent) { echo $parent->post_title; } ?>
					</h4>
				<?php endif; ?>
				<h3><?php echo $post->post_title; ?></h3>
				<?php if ( $subtitle ) : ?><h5 class="subtitle"><?php echo $subtitle; ?></h5><?php endif; ?>
				
				<!-- Author(s) -->
				<div class="authors">
					<?php foreach ( $authors['posts'] as $key => $author ) : ?>
						<h4>
							<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a>
						</h4>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Description -->
			<div class="description clearfix">
				<!-- Thumbnail -->
				<?php if ( $thumbnail ) : ?>
					<?php echo $thumbnail; ?>
	            <?php else: ?>
	                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php echo $post->post_title; ?>" />
	            <?php endif; ?>
			 	<p><?php echo $description; ?></p>
			</div>
			<!-- See more -->
			<a href="<?php echo get_permalink( $post ); ?>" class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></a>
			
			<!-- Terms -->
			<div class="tags">
				<?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
	   				<a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
	   			<?php endforeach; ?>
	   		</div>

		</li>
	<?php endforeach; ?>
</ul>
