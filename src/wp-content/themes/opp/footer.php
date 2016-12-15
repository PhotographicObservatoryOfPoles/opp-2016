<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage OPP
 * @since OPP 1.0
 */
?>

	<?php $footerLinkItemsIDs = array(
			pll_get_post( PAGE_NEWS_ID, $locale ) => array('post_type' => 'post'),
		    pll_get_post( PAGE_CONTACT_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_DONATION_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_MEDIAS_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_LEGAL_NOTICE_ID, $locale ) => array('post_type' => '')
	); ?>
	<footer class="site-footer">
		<ul class="links">
			<?php foreach ( $footerLinkItemsIDs as $footerLinkitemID => $footerLinkInfos ) : $footerLinkitem = get_post( $footerLinkitemID ); ?>
				<li class="menu-item <?php echo !is_home() && (($post->ID === $footerLinkitemID) || ($post->post_type === $footerLinkInfos['post_type'])) ? 'current' : ''; ?>">
					<a href="<?php echo get_permalink( $footerLinkitemID ); ?>">
						<?php echo $footerLinkitem->post_title; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="site-info">
			<small>&copy; <?php echo date('Y'); ?> &middot; <?php bloginfo( 'name' ); ?></small>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</main><!--.main-wrapper  -->

<!-- Back to top -->
<div id="back-top">
	<a href="#top"><span class="glyphicon glyphicon-chevron-up"></span></a>
</div>

<!-- Mask -->
<div id="mask" class="mask"></div>

<!-- Main navigation panel -->
<div class="panel panel-vertical panel-right" id="panel-navigation">
	<button class="btn button--panel-close">
		<span class="glyphicon glyphicon-remove"></span>
	</button>

	<!-- Languages -->
	<ul class="languages">
		<?php /*pll_the_languages( array(
			'dropdown'				 => 0, // displays a list if set to 0, a dropdown list if set to 1 (default: 0)
			'show_names' 			 => 1, // displays language names if set to 1 (default: 1)
			'display_names_as' 		 => 'name', // either ‘name’ or ‘slug’ (default: ‘name’)
			'show_flags'			 => 0, // displays flags if set to 1 (default: 0)
			'hide_if_empty' 		 => 1, // hides languages with no posts (or pages) if set to 1 (default: 1)
			'force_home' 			 => 0, // forces link to homepage if set to 1 (default: 0)
			'echo' 					 => 1, // echoes if set to 1, returns a string if set to 0 (default: 1)
			'hide_if_no_translation' => 0, // hides the language if no translation exists if set to 1 (default: 0)
			'hide_current' 			 => 1, // hides the current language if set to 1 (default: 0)
			'post_id' 				 => null, // if set, displays links to translations of the post (or page) defined by post_id (default: null)
			'raw' 					 => 0 // use this to create your own custom language switcher (default:0)
		) );*/ ?>
	</ul>

	<!-- Branding + home link -->
	<a class="site-branding" href="<?php echo pll_home_url( $locale ); ?>" title="<?php echo __( 'Homepage', 'opp' ); ?>">
		<img src="<?php bloginfo('template_directory'); ?>/img/logo.png" alt="<?php echo __( 'Observatory Photographic of Poles' , 'opp'); ?>" />
		<h2 class="site-name">
			<?php echo __( 'Observatory <span class="light-blue">Photographic</span> of Poles', 'opp' ); ?>
		</h2>
	</a>

	<!-- Main menu -->
	<?php $mainMenuItemsIDs = array(
		    pll_get_post( PAGE_OBSERVATORY_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_GALLERIES_ID, $locale ) => array('post_type' => 'photos-gallery'),
		    pll_get_post( PAGE_EXPEDITIONS_ID, $locale ) => array('post_type' => 'expedition'),
		    pll_get_post( PAGE_MAP_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_CONTRIBUTORS_ID, $locale ) => array('post_type' => 'contributor'),
		    pll_get_post( PAGE_DONATION_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_CONTACT_ID, $locale ) => array('post_type' => ''),
		    pll_get_post( PAGE_NEWS_ID, $locale ) => array('post_type' => 'post'),
	); ?>
	<ul class="main-menu">
		<?php foreach ( $mainMenuItemsIDs as $mainMenuItemID => $itemInfos ) : $mainMenuItem = get_post( $mainMenuItemID ); ?>
			<?php
				$isCurrent = !is_home() && (($post->ID === $mainMenuItemID) || ($post->post_type === $itemInfos['post_type']));
				$isMobileHidden = in_array($mainMenuItemID, $GLOBALS['mobile_hidden_pages']);
			?>
			<li class="menu-item <?php echo $isCurrent ? 'current' : ''; ?> <?php echo $isMobileHidden ? 'mobile-hidden' : ''; ?>">
				<a href="<?php echo get_permalink( $mainMenuItemID ); ?>">
					<?php echo $mainMenuItem->post_title; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<!-- Following -->
	<div class="following-buttons">
		<p><?php echo __( 'Follow us', 'opp' ); ?></p>
		<div class="a2a_kit a2a_kit_size_24 a2a_default_style a2a_follow">
		    <a class="a2a_button_twitter" data-a2a-follow="OPP_asso"></a>
		    <a class="a2a_button_facebook" data-a2a-follow="groups/211629738927815"></a>
		    <a class="a2a_button_google_plus" data-a2a-follow="112859177697811162308/about"></a>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

<script type="text/javascript">
	$(window).load(function() {

		// Panel main navigation menu (push right)
		var panelNavigation = new Panel({
			panel: '#panel-navigation',
			type: 'push-right'
		});
		var panelNavigationBtn = document.querySelector('#button--panel-navigation');
		panelNavigationBtn.addEventListener('click', function(e) {
			e.preventDefault;
			panelNavigation.open();
		});

		// Menu bar
		if ($(this).scrollTop() > $('.menu-bar').height()) {
			$('.menu-bar').css('opacity', 0.5);
			$('.site-branding > .button-tooltip').css('opacity', 0.5);
		} else {
			$('.menu-bar').css('opacity', 1);
			$('.site-branding > .button-tooltip').css('opacity', 1);
		}
		$(window).scroll(function() {
			if ($(this).scrollTop() > $('.menu-bar').height()) {
				$('.menu-bar').css('opacity', 0.5);
				$('.site-branding > .button-tooltip').css('opacity', 0);
			} else {
				$('.menu-bar').css('opacity', 1);
				$('.site-branding > .button-tooltip').css('opacity', 1);
			}
		});

		// Search area (slide top)
		if (document.getElementById('button--panel-search')) {
			var search = new Panel({
				panel: '#search'
			});
			var searchBtn = document.querySelector('#button--panel-search');
			searchBtn.addEventListener('click', function(e) {
				e.preventDefault;
				search.open();
			});
		}

		// Homepage slider
		$('#homepage-slider').flexslider({
			animation: "slide"
		});

		// Homepage super-contributors slider
	  	$('#homepage-super-contributors-slider').flexslider({
			animation: "slide",
			animationLoop: true,
			itemWidth: 250,
			itemMargin: 15
		});
		
		// Homepage contributors carousel
		$('#homepage-contributors-carousel').flexslider({
		    animation: "slide",
		    animationLoop: true,
		    itemWidth: 205,
		    itemMargin: 15
	  	});

	  	// Masonry
	  	$('.grid').masonry({
            itemSelector: '.grid-item'
        });

        // ImagesLoaded
	    $('.grid').imagesLoaded(function() {
	        $('.grid').masonry({
	            itemSelector: '.grid-item',
	        });
	    });
	    
	});
</script>

</body>
</html>
