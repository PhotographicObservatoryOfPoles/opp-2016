<?php

// Get page
$pageID = pll_get_post( PAGE_OBSERVATORY_TEAM_ID, $locale );
$page = get_post( $pageID );

// Get contributor N. Mingasson (id = 45)
$founderID = pll_get_post( 45, $locale );
$founder = get_post( $founderID );
// Thumbnail
$founderThumbnail = get_field( 'photo', $founder );
// Role
$founderRole = get_field( 'team_role', $founder );
// Job
$founderJob = get_field( 'job', $founder );
// Bio
$founderBio = wp_strip_all_tags( get_post_field( 'post_content', $founder ) );
$founderBio = strlen( $founderBio ) > 100 ? mb_substr( $founderBio, 0, 100 ) . '...' : $founderBio;

// Get contributors
$contributors = new WP_Query( array(
	'orderby'        => 'meta_value',
	'meta_key'   	 => 'last_name',
	'order'          => 'ASC',
	'posts_per_page' => -1,
	'post_type'  	 => 'contributor',
	'post_status'	 => 'publish',
	'tax_query' 	 => array(
		array(
			'taxonomy' => 'contributor-type',
			'field'    => 'slug',
			'terms'    => 'team-member',
		),
	),
	'post__not_in' 	   => array( $founderID )
) );
$key = 0;

?>

<?php if ( $contributors->have_posts() ) : ?>
<div class="container">
	<div class="row">

		<div class="main-title main-title--section clearfix">
			<div class="col-sm-12 col-md-12">
				<h3><?php echo $page->post_title; ?></h3>
			</div>
		</div>

		<div class="content clearfix">
			<div class="col-sm-12 col-md-12 founder">
				<div class="thumbnail thumbnail-horizontal clearfix">
			  		<div class="image">
			  			<?php if ( $founderThumbnail ) : ?>
			  				<img src="<?php echo $founderThumbnail['sizes']['medium']; ?>" alt="<?php echo $founderThumbnail['alt']; ?>" />
			  			<?php else : ?>
			  				<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="" />
			  			<?php endif; ?>
			  		</div>
			      	<div class="caption">
			        	<h3><?php echo $founder->post_title; ?></h3>
			        	<?php if ( $founderJob ) : ?><h4><?php echo $founderJob; ?></h4><?php endif; ?>
			        	<?php if ( $founderRole ) : ?><h4><?php echo $founderRole; ?></h4><?php endif; ?>
			        	<p><?php echo $founderBio; ?></p>
			        	<a class="read-more-link mobile-hidden" href="<?php echo get_permalink( $founderID ); ?>">
			        		<?php echo __( 'See more', 'opp' ); ?>
			        		<span class="glyphicon glyphicon-menu-right"></span>
			        	</a>
			      	</div>
			      	<a class="read-more-link mobile-hidden" href="<?php echo get_permalink( $founderID ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
			    </div>
			</div>

			<div class="col-sm-12 col-md-12">
			<?php while ( $contributors->have_posts() ) :
					// Post
					$contributor = get_post( $contributors->the_post() );
					// Thumbnail
					$thumbnail = get_field( 'photo', $contributor );
					// Role
					$role = get_field( 'team_role', $contributor );
					// Job
					if (!$role) {
						$role = get_field( 'job', $contributor );
					}
		    ?>
				<div class="col-sm-6 col-md-6 <?php echo $key % 2 == 0 ? 'break' : ''; ?>">
				  	<div class="thumbnail thumbnail-horizontal clearfix">
				  		<div class="image">
				  			<?php if ( $thumbnail ) : ?>
				  				<img src="<?php echo $thumbnail['sizes']['medium']; ?>" alt="<?php echo $thumbnail['alt']; ?>" />
				  			<?php else : ?>
				  				<img src="<?php bloginfo('template_directory'); ?>/img/default/photo.png" alt="" />
				  			<?php endif; ?>
				  		</div>
				      	<div class="caption">
				        	<h3><?php echo $contributor->post_title; ?></h3>
				        	<?php if ( $role ) : ?><h4><?php echo $role; ?></h4><?php endif; ?>
				      	</div>
				    </div>
				</div>
				<?php $key++; ?>
			<?php endwhile; ?>
			</div>
		</div>
	</div>

</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>