<?php

// Get page
$pageID = pll_get_post( PAGE_OBSERVATORY_PARTNERS_ID, $locale );
$page = get_post( $pageID );

// Get partners
$partners = new WP_Query( array(
	'orderby'        => 'title',
	'order'          => 'ASC',
	'posts_per_page' => -1,
	'post_type'  	 => 'partner',
	'post_status'	 => 'publish'
) );
$key = 0;

?>

<?php if ( $partners->have_posts() ) : ?>
<div class="container">
	<div class="row">

		<div class="main-title main-title--section clearfix">
			<div class="col-sm-12 col-md-12">
				<h3><?php echo $page->post_title; ?></h3>
			</div>
		</div>

		<div class="content clearfix">
			<div class="col-sm-12 col-md-12 transitions-enabled fluid masonry js-masonry grid">
			<?php while ( $partners->have_posts() ) :
					// Post
					$partner = get_post( $partners->the_post() );
					// Logo
					$logo = get_field( 'logo', $partner );
					// Website
					$website = get_field( 'website', $partner );
		    ?>
				<div class="col-sm-6 col-md-6 <?php echo $key % 2 == 0 ? 'break' : ''; ?>">
				  	<div class="thumbnail">
				  		<?php if ( $logo ) : ?>
					  		<div class="image">
					  			<img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php echo $logo['alt']; ?>" />
					  			<button class="read-more-button" role="button">
					       			<span class="btn btn-default"><?php echo __( 'Go to website', 'opp' ); ?></span>
					       		</button>
					  		</div>
			  			<?php endif; ?>
				      	<div class="caption">
				        	<h3><?php echo $partner->post_title; ?></h3>
				        	<?php echo $partner->post_content; ?>
				      	</div>
				      	<a class="read-more-link" href="<?php echo $website; ?>" title="<?php echo __( 'Go to website', 'opp' ); ?>" target="_blank"></a>
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