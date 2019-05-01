<?php 

/*
 * Plugin name: Laura Testimonials
 * Plugin URI: https://github.com/janbien/laura/tree/master/wp-content/plugins/laura-testimonials
 * Version: 1.1
 * Author: Jan Bien
 * Author URI: https://www.webmistr.wtf
 * License: GPL2
*/

defined( 'ABSPATH' ) or die();

add_action( 'init', function () {
	
	register_post_type('testimonial', 
		array(	
			'label' => 'Testimonials',
			'public' => true,
			'supports' => array( 'title', 'revisions', 'editor', 'thumbnail', 'page-attributes' )
		)
	);

	register_taxonomy( 'testimonial_category', array('testimonial'), 
		array(
			'label' => 'Testimonials categories',
			'hierarchical' => true,
			'show_admin_column' => true,			
			'rewrite' => array( 'slug' => 'testimonial/cat' )
		)
	);

});

add_shortcode( 'testimonials', function() {
	ob_start();
	include( __DIR__ . '/template.php' );
	return ob_get_clean();
});


add_action('pre_get_posts', function ($query) {
	if( !is_admin() ) return;
	if ( $query->get('post_type') != 'testimonial' )  return;
	$query->set('orderby', 'menu_order');
	$query->set('order', 'ASC');
});


