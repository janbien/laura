<?php 

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery'), false, true ); 
});


add_action( 'after_setup_theme', function () {

	add_theme_support( 'title-tag' );
	register_nav_menu( 'top', 'Top menu' );

});

