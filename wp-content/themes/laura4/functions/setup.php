<?php 

add_action( 'wp_enqueue_scripts', function () {

	//	my jquery
	/*
	wp_dequeue_script( 'jquery');
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/libs/jquery/jquery.min.js' );
	wp_enqueue_script('jquery');
	*/
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery'), false, true ); 

});


add_action( 'after_setup_theme', function () {

	add_theme_support( 'title-tag' );
	add_image_size ( 'my_size', 200, 80, true );

});

