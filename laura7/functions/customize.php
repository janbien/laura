<?php 


add_filter( 'the_tags','laura_the_tags_filter', 10, 1 );

function laura_the_tags_filter( $html ){
    return str_replace( '<a', '<a class="label label-primary"', $html );
}


add_action( 'wp_head', function() {
	?>
		<script type="text/javascript">
			console.log('header');
		</script>
	<?php
});


add_action( 'wp_footer', function() {
	?>
		<script type="text/javascript">
			console.log('footer');
		</script>
	<?php
});


add_filter('the_content', function( $content ) {
	$content = str_replace ( 'Webmistr je pitomec', 'Webmistr je king', $content );
	return $content;
});


add_filter( 'excerpt_more', 'laura_excerpt_more', 10, 1 ); 

function laura_excerpt_more( $hellip ) { 
    return ' &hellip;';
}; 

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() ) return;
	if ( !is_home() ) return;
	if ( !$query->is_main_query() ) return;
	$query->set( 'cat', '-3' );
} );

add_filter('laura_copyright', function( $text ) {
	return 'Copyright &copy; 2017 <strong>FANTOMAS!</strong>';
});


