<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="col-sm-12 col-md-12">

	<div class="input-group">
		<input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s"
				   placeholder="<?php echo __( 'Search through all website', 'opp' ); ?>" class="form-control" />
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit" id="searchsubmit">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</span>
    </div>

</form>