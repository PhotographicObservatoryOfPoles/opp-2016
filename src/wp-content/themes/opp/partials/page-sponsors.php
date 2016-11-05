<?php

// Get page
$pageID = pll_get_post( PAGE_OBSERVATORY_SPONSORS_ID, $locale );
$page = get_post( $pageID );

// Get sponsors
$sponsors = new WP_Query( array(
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
			'terms'    => 'sponsor',
		),
	)
) );
$key = 0;

?>

<?php if ( $sponsors->have_posts() ) : ?>
<div class="container">
	<div class="row">

		<div class="main-title main-title--section clearfix">
			<div class="col-sm-12 col-md-12">
				<h3><?php echo $page->post_title; ?></h3>
			</div>
		</div>

		<div class="content clearfix">
			<div class="col-sm-12 col-md-12 transitions-enabled fluid masonry js-masonry grid">
			<?php while ( $sponsors->have_posts() ) :
					// Post
					$sponsor = get_post( $sponsors->the_post() );
					// Thumbnail
					$thumbnail = get_field( 'photo', $sponsor );
					// Job
					$job = get_field( 'job', $sponsor );
					// Website
					$website = get_field( 'website', $sponsor );
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
				        	<h3><?php echo $sponsor->post_title; ?></h3>
				        	<?php if ( $job ) : ?><h4><?php echo $job; ?></h4><?php endif; ?>
				        	<?php if ( $website ) : ?><a href="<?php echo $website; ?>" target="_blan"><?php echo __( 'Website', 'opp' ); ?></a><?php endif; ?>
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