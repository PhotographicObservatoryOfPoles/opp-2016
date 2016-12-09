<?php
/**
 * The template for displaying all single expedition posts and attachments
 */

get_header(); ?>


<?php
// Start the loop.
while ( have_posts() ) : the_post();

	// Children of current page
	$args = array(
		'post_parent' => $post->ID,
		'post_type'   => 'expedition',
		'numberposts' => -1,
		'post_status' => 'publish'
	);
	$children = get_children( $args );
	usort( $children, 'sort_hierarchically' );

	// Ancestors of current page
	$ancestors = get_post_ancestors( $post );
	usort( $ancestors, 'sort_hierarchically' );

	// Always get the first page
	if ( empty($ancestors) ) {
		$firstPage = $post->ID;
	} elseif ( count($ancestors) >= 1 ) {
		$firstPage = $ancestors[0];
	}

	// All expedition's pages
	$allPages = get_pages( array(
		'sort_order' => 'asc',
		'sort_column' => 'menu_order',
		'hierarchical' => true,
		'child_of' => $firstPage,
		'parent' => -1,
		'offset' => 0,
		'post_type' => 'expedition',
		'post_status' => 'publish'
	) );

	// Authors
	$authors = get_authors( $firstPage, $locale );
	$nbAuthors = count( $authors['posts'] );

	// Cover image
	$cover = get_the_post_thumbnail( $firstPage, 'full' );
	$coverInfos = wp_get_attachment_image_src( get_post_thumbnail_id( $firstPage ), 'medium' );
	$coverURL = $coverInfos[0];

	// Locations
	$locations = array();
	foreach ( $allPages as $page ) {
		$geolocation = get_field( 'geolocation', $page->ID );
		if ( !empty( $geolocation ) ) {
			$locations[$geolocation['address']] = $geolocation;	
		}			
	}

	// All expeditions page
	$allExpeditionsPage = pll_get_post( PAGE_EXPEDITIONS_ID, $locale );

?>
	<!-- First page -->
	<?php if ( $post->ID === $firstPage ) : ?>
		<?php include( locate_template( 'partials/expedition-cover.php' ) ); ?>

	<!-- Chapter -->
	<?php elseif ( $post->post_parent === $firstPage ): ?>
		<?php include( locate_template( 'partials/expedition-chapter.php' ) ); ?>

	<!-- Slide -->
	<?php else: ?>
		<?php include( locate_template( 'partials/expedition-slide.php' ) ); ?>

	<?php endif; ?>

<?php endwhile; ?>

<div id="lightbox"></div>

<!-- Panel button -->
<div class="menu-bar menu-bar--page">
	<a href="<?php echo get_permalink( $allExpeditionsPage ); ?>" class="btn button--w-tooltip">
		<span class="glyphicon glyphicon-th-large"></span>
		<span class="button-tooltip button-tooltip--left"><?php echo __( 'All expeditions', 'opp' ); ?></span>
	</a>
</div>

<!-- Panels' buttons -->
<div class="menu-bar menu-bar--expedition mobile-hidden">
	<button id="button--panel-summary" class="button--panel-open button--w-tooltip">
		<span class="glyphicon glyphicon-th-list"></span>
		<span class="button-tooltip button-tooltip--right"><?php echo __( 'Summary', 'opp' ); ?></span>
	</button>
	<button id="button--panel-map" class="button--panel-open button--w-tooltip">
		<span class="glyphicon glyphicon-globe"></span>
		<span class="button-tooltip button-tooltip--right"><?php echo __( 'Map', 'opp' ); ?></span>
	</button>
	<button id="button--panel-contributors" class="button--panel-open button--w-tooltip">
		<span class="glyphicon glyphicon-user"></span>
		<span class="button-tooltip button-tooltip--right"><?php echo ( $nbAuthors > 1 ) ? __( 'Contributors', 'opp' ) : __( 'Contributor', 'opp' ); ?></span>
	</button>
</div>

<!-- Side panel: summary -->
<aside class="panel panel-vertical panel-left" id="summary-panel">
	<button class="btn button--panel-close hidden">
		<span class="glyphicon glyphicon-remove"></span>
	</button>
	<h3><a href="<?php echo get_permalink( $firstPage ); ?>"><?php echo get_the_title( $firstPage ); ?></a></h3>
	<h4><?php echo __( 'Expedition timeline', 'opp' ); ?></h4>
	<ol class="summary">
		<?php foreach ( $allPages as $page ) :
			$class = ( $page->post_parent === $firstPage ) ? 'chapter' : 'slide';
			$current = ( $page->ID === $post->ID ) ? 'current' : '';
		?>
			<li class="nav <?php echo $class; ?> <?php echo $current; ?>">
				<a href="<?php echo get_permalink( $page->ID ); ?>"><?php echo $page->post_title; ?></a>
			</li>
		<?php endforeach; ?>
	</ol>
</aside>

<!-- Top panel: map -->
<div class="panel panel-horizontal panel-top" id="map-panel">
	<button class="btn button--panel-close">
		<?php echo __( 'Fold up the map', 'opp' ); ?>
	</button>
	<div class="acf-map scrollable">
		<?php foreach ( $locations as $location ) : $currentLocation = get_field( 'geolocation', $post->ID ); ?>
			<?php $isCurrent = ( $currentLocation['address'] == $location['address'] ) ? 'current' : ''; ?>
			<div class="marker <?php echo $isCurrent; ?>" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
				<p class="marker-infos"><?php echo $location['address']; ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<!-- Side panel: contributors -->
<aside class="panel panel-vertical panel-left" id="contributors-panel">
	<button class="btn button--panel-close hidden">
		<span class="glyphicon glyphicon-remove"></span>
	</button>
	<h3><?php echo ( $nbAuthors > 1 ) ? __( 'Contributors', 'opp' ) : __( 'Contributor', 'opp' ); ?></h3>
	<h4><?php echo __( 'About', 'opp' ); ?></h4>
 	<?php foreach ( $authors['posts'] as $index => $author ) :
 			// Photo
 			$photo = get_field( 'photo', $author->ID );
 			// Biography
 			$biography = strip_tags( get_post_field( 'post_content', $author->ID ) );
 			$maxLength = 200;
 			if ( $nbAuthors === 1 ) {
 				$maxLength = 880;
 			} elseif ( $nbAuthors > 1 && $nbAuthors <= 2 ) {
 				$maxLength = 440;
 			}
			$biography = ( strlen( $biography ) > $maxLength ) ? mb_substr( $biography, 0, $maxLength ) . '...' : $biography;
	?>
		<div class="contributor clearfix">
			<h4><?php echo $author->post_title; ?></h4>
			<div class="clearfix">
				<img src="<?php echo $photo['sizes']['thumbnail']; ?>" alt="<?php echo $author->post_title; ?>" />
				<p><?php echo $biography; ?></p>
			</div>
			<a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo __( 'See more', 'opp' ); ?></a>
		</div>
	<?php endforeach; ?>
</aside>

<?php get_footer(); ?>

<style type="text/css">
	.main-cover--blurry-bg {
		background: #181818 url("<?php echo $cover ? $coverURL : bloginfo('template_directory') . '/img/default/cover_image.jpg'; ?>") repeat center;
	}
</style>

<!-- Panels -->
<script type="text/javascript">
	$(window).load(function() {
		// Map panel (slide top)
		var mapPanel = new Panel({
			panel: '#map-panel',
			type: 'slide-top'
		});
		var mapPanelBtn = document.querySelector('#button--panel-map');
		mapPanelBtn.addEventListener('click', function(e) {
			e.preventDefault;
			mapPanel.open();
		});

		// Contributors panel (push left)
		var contributorsPanel = new Panel({
			panel: '#contributors-panel',
			type: 'push-left'
		});
		var contributorsPanelBtn = document.querySelector('#button--panel-contributors');
		contributorsPanelBtn.addEventListener('click', function(e) {
			e.preventDefault;
			contributorsPanel.open();
		});

		// Summary panel (push left)
		var navigationPanel = new Panel({
			panel: '#summary-panel',
			type: 'push-left'
		});
		var navigationPanelBtn = document.querySelector('#button--panel-summary');
		navigationPanelBtn.addEventListener('click', function(e) {
			e.preventDefault;
			navigationPanel.open();
		});

		// Scrollbars
		$('#summary-panel').mCustomScrollbar({
			theme: 'dark-thin',
			scrollButtons: {enable:true}
		});
		$('#contributors-panel').mCustomScrollbar({
			theme: 'dark-thin',
			scrollButtons: {enable:true}
		});

		// Images center
		$('p:has(img.alignnone)').css('text-align', 'center');
		$('p:has(img.alignnone)').css('margin-bottom', 0);
		$('p:has(img.alignnone) + p').addClass('wp-caption-text');

		// Images lightbox
		$('.content img').click(function() {
			$('#mask').addClass('is-active');
			$('#lightbox').css('height', $(this).height());
			$('#lightbox').addClass('is-active');
			$('#lightbox').html($(this).clone());
		});
		$('#lightbox').click(function() {
			$('#mask').removeClass('is-active');
			$(this).css('height', 0);
			$(this).removeClass('is-active');
			$(this).html('');
		});
		$('#mask').click(function() {
			if (!$(this).hasClass('is-active')) {
				$('#lightbox').removeClass('is-active');
				$('#lightbox').css('height', 0);
				$('#lightbox').removeClass('is-active');
				$('#lightbox').html('');
			}
		});
	});
</script>