<form role="search" method="get"  action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-group">
		<input name="s" type="text" class="form-control" placeholder="Search" value="<?php echo esc_attr( get_search_query() ); ?>">
	</div>
	<button type="submit" class="btn btn-default">Hledat</button>
</form>