<?php

// Get page
$pageID = pll_get_post( PAGE_OBSERVATORY_ABOUT_ID, $locale );
$page = get_post( $pageID );

// Get formatted page content
$page_content = get_formatted_post_content( $page );

?>


<div class="container">
	<div class="row">
		<div class="content">
			<div class="col-sm-12 col-md-12">
				<?php echo $page_content; ?>
			</div>
		</div>
	</div>
</div>