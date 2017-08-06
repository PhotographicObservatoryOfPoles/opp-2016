<?php
/*
  Template Name: Map
*/

get_header(); 

// Get all geolocation: gallery + expedition's slides
$galleries = get_posts( array(
	'posts_per_page' => -1,
	'post_type'  	 => 'photos-gallery',
	'post_status'	 => 'publish',
	'meta_query' 	 => array(
		'relation' => 'OR',
		array(
            'key' => 'hidden_in_page_list',
            'value' => '0',
            'compare' => '='
        ),
		array(
            'key' => 'hidden_in_page_list',
            'compare' => 'NOT EXISTS'
        )
    )
) );
$expeditions = get_posts( array(
	'posts_per_page'   => -1,
	'orderby'          => 'date',
	'order'            => 'ASC',
	'post_type'        => 'expedition',
	'post_status'      => 'publish'
) );

$posts = array_merge( $galleries, $expeditions );

$markers = array();
foreach ( $posts as $key => $item ) {
	$geolocation = get_field( 'geolocation', $item->ID );
	if ( !empty( $geolocation ) ) {

		if ( !isset( $markers[$geolocation['address']] ) ) {
			$markers[$geolocation['address']] = array(
				'location' => $geolocation,
				'posts' => array(
					'gallery' => array(),
					'expedition' => array()
				)
			);
		}

		$markers[$geolocation['address']]['posts'][str_replace('photos-', '', $item->post_type)][] = $item->ID;
	}
}

?>

<!-- Side panel -->
<aside class="panel panel-vertical panel-left" id="map-side-panel">
	<button class="btn button--panel-close">
		<span class="glyphicon glyphicon-remove"></span>
	</button>
	<div class="posts"></div>
</aside>

<span class="spinner"></span>

<div class="acf-map scrollable loading">
	<?php foreach ( $markers as $marker ) : ?>
		<div class="marker"
			data-lat="<?php echo $marker['location']['lat']; ?>"
			data-lng="<?php echo $marker['location']['lng']; ?>"
			data-address="<?php echo $marker['location']['address']; ?>"
			data-posts=<?php echo json_encode($marker['posts']); ?>
		>
			<div class="marker-infos">
				<h4 class="address"><?php echo __( $marker['location']['address'], 'opp' ); ?></h4>

				<?php if ( (count($marker['posts']['gallery']) + count($marker['posts']['expedition'])) == 1 ) : ?>

				<?php foreach ( $marker['posts'] as $postType => $posts ) : 
						foreach ( $posts as $postID ) : $item = get_post( pll_get_post( $postID, $locale ) ); 
							// Ancestors
							$parent = null;
							$grandParent = null;
							// Description
							$description = $item->post_type === 'photos-gallery' ? get_field( 'description', $item, false ) :
                                            wp_strip_all_tags( get_post_field( 'post_content', $item ) );
            				$description = strlen( $description ) > 300 ? mb_substr( $description, 0, 300 ) . '...' : $description;
		        		?>

						<!-- Gallery -->
						<?php if ( $item->post_type === 'photos-gallery' ) {
							// Subtitle
							$subtitle = get_field( 'subtitle', $item );
							// Authors
							$authors = get_authors( $item, $locale );
							// Thumbnail
							$thumbnail = get_the_post_thumbnail( $item, 'large' );
							// Terms (themes & regions)
							$themes = get_field( 'theme', $item );
				        	$regions = get_field( 'region', $item );
				        	$terms = array_merge( $themes, $regions );
						} ?>

						<!-- Expedition -->
						<?php if ( $item->post_type === 'expedition' ) {
							// Ancestors
							$parent = get_post( $item->post_parent );
							$grandParent = $parent && $parent->post_parent !== 0 ? get_post( $parent->post_parent ) : false;
							// Authors
							$authors = get_field( 'authors', $parent ) ? 
								get_authors( $parent, $locale ) : get_authors( $grandParent, $locale );
							// Thumbnail
							$thumbnail = get_the_post_thumbnail( $parent, 'large' ) ? 
								get_the_post_thumbnail( $parent, 'large' ): get_the_post_thumbnail( $grandParent, 'large' );
							// Terms (themes & regions)
							$themes = get_field( 'theme', $parent ) ? get_field( 'theme', $parent ) : get_field( 'theme', $grandParent );
				        	$regions = get_field( 'region', $parent ) ? get_field( 'region', $parent ) : get_field( 'region', $grandParent );
				        	$terms = array_merge( $themes, $regions );
						} ?>

						<!-- Title(s) -->
						<div class="main-title main-title--marker">
							<small class="post-type"><?php echo $item->post_type === 'photos-gallery' ? __( 'gallery', 'opp' ) : __( 'expedition', 'opp' ); ?></small>
							<?php if ( $grandParent || $parent ) : ?>
								<h4 class="parent-title">
									<?php if ( $grandParent ) { echo $grandParent->post_title; } ?>
									<?php if ( $grandParent && $parent ) { echo '&middot;'; } ?>
									<?php if ( $parent ) { echo $parent->post_title; } ?>
								</h4>
							<?php endif; ?>
							<h3><?php echo $item->post_title; ?></h3>
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
				                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php echo $item->post_title; ?>" />
				            <?php endif; ?>
						 	<p><?php echo $description; ?></p><br />
						 	<!-- See more -->
		       				<a href="<?php echo get_permalink( $item ); ?>" class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></a>
						</div>
						<!-- Terms -->
						<div class="tags">
							<?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
			       				<a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
			       			<?php endforeach; ?>
			       		</div>
				<?php endforeach;
						endforeach; ?>
				<?php endif; ?>
			</div>	
		</div>
	<?php endforeach; ?>
</div>

<?php get_footer(); ?>

<script type="text/javascript">
	$(document).ready(function() {
		// Map
		$('.acf-map').height($(document).height());
		$('.spinner').css('opacity', 0);

		// Scrollbar
		$('#map-side-panel').mCustomScrollbar({
			theme: 'dark-thin',
			scrollButtons: {enable:true}
		});
	});
</script>