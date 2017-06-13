<?php 

add_action( 'widgets_init', function() {
	register_sidebar(array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
	    'before_widget' => '<section id="%1$s" class="panel panel-default widget %2$s">',
	    'after_widget'  => '</div></section>',
	    'before_title'  => '',
	    'after_title'   => '',
	));
});

add_action( 'dynamic_sidebar_before', function( $index, $false ) {
	if ( 'sidebar' != $index ) return;
	add_filter( 'widget_title', 'laura_siebar_widget_title' );
}, 10, 2 ); 

add_action( 'dynamic_sidebar_after', function( $index, $false ) {
	if ( 'sidebar' != $index ) return;
	remove_filter( 'widget_title', 'laura_siebar_widget_title' );
}, 10, 2 ); 

function laura_siebar_widget_title( $title ) {
	if ( $title ) $title = '<div class="panel-heading"><h3 class="panel-title">'.$title.'</h3></div>';
	$title .= '<div class="panel-body">';
    return $title;
}

add_action( 'widgets_init', function() {

	register_sidebar(array(
		'name'          => 'Footer 1',
		'id'            => 'footer-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>' 
	)); 

	register_sidebar(array(
		'name'          => 'Footer 2',
		'id'            => 'footer-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>' 
	)); 

	register_sidebar(array(
		'name'          => 'Footer 3',
		'id'            => 'footer-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>' 
	)); 

	register_sidebar(array(
		'name'          => 'Footer 4',
		'id'            => 'footer-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>' 
	)); 


});



