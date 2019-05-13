<?php 

/*
 * Plugin name: Laura Testimonials
 * Plugin URI: https://github.com/janbien/laura/tree/master/wp-content/plugins/laura-testimonials
 * Version: 1.2.2
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

add_action( 'after_setup_theme', function () {
	add_image_size ( 'testimonial', 120, 120, true );
});

add_action('pre_get_posts', function ($query) {
	if( !is_admin() ) return;
	if ( $query->get('post_type') != 'testimonial' )  return;
	$query->set('orderby', 'menu_order');
	$query->set('order', 'ASC');
});

add_filter('acf/settings/load_json', function($paths) {
	$paths[] = __DIR__ . '/acf-json';
	return $paths;
});

add_shortcode( 'testimonials', function() {
	ob_start();
	include( __DIR__ . '/views/shortcode.php' );
	return ob_get_clean();
});

add_action( 'acf/init', function () {
	if( !function_exists('acf_register_block') ) return;
	acf_register_block(array(
		'name'				=> 'testimonials',
		'title'				=> 'Testimonials',
		'render_template' 	=> __DIR__ . '/views/block.php',
		'category'			=> 'layout',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'testimonials'),
	));
});
