<?php  

add_action( 'init', function () {
	register_post_type('event', 
		array(	
			'label' => 'Events',
			'public' => true,
			'supports' => array( 'title', 'revisions', 'editor' )
		)
	);
});


add_action('pre_get_posts', function ( $query ) {
	if( !is_admin() ) return;
	if ( $query->get('post_type') != 'event' )  return;
	$query->set('orderby', 'meta_value');
	$query->set('order', 'DESC');
	$query->set('meta_key', 'date');
});


if ( class_exists( 'Jigsaw' ) and function_exists( 'the_field' ) ) {
	Jigsaw::add_column('event', 'Date', function( $pid ){
		the_field( 'date', $pid );
	}, 2);
}


add_shortcode( 'events', function( $atts, $content ) {

	$atts = shortcode_atts( array(
		'title' => 'Events',
		'null' => 'No events.'
	), $atts , 'events' );

	$query_attrs = array(
		'post_type' => 'event',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
		        'key'		=> 'date',
		        'compare'	=> '>=',
		        'value'		=> date('Ymd')
		    )
	    ),
	    'orderby' => 'meta_value',
	    'order' => 'ASC',
	    'meta_key' => 'date',

	);
	
	$query = new WP_Query( $query_attrs );

	if ( !$query->have_posts() ) return $atts['null'];
	ob_start();
	?>

		<div class="panel panel-default">
		 
		  <div class="panel-heading"><?php echo $atts['title'] ?></div>

		  <table class="table">
		  	<?php while ( $query->have_posts() ) { $query->the_post(); ?>
		   		<tr>
		   			<td><?php the_field( 'date' ) ?></td>
		   			<th><?php the_title() ?></th>
		   			<td><?php the_field( 'note' ) ?></td>
		   			<td><a href="<?php the_permalink(); ?>">Detail</a></td>
		   		</tr>
		    <?php } ?>
		  </table>
		</div>

	<?php
	return ob_get_clean();

});


