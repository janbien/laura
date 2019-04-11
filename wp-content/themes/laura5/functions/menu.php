<?php 


add_filter( 'nav_menu_css_class', 'laura_nav_menu_css_class', 10, 2);

function laura_nav_menu_css_class( $classes, $item ) {
	if ( is_404() ) return $classes;
	if ( in_array( 'current-menu-item', $classes ) ) $classes[] = 'active';
	return $classes;
}


add_filter( 'nav_menu_link_attributes', 'laura_nav_menu_link_attributes', 10, 4 ); 

function laura_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( $args->theme_location != 'top') return $atts;
	if ( !in_array( 'menu-item-has-children', $item->classes )) return $atts;
    $atts_new = array(
    	'class' => "dropdown-toggle", 
    	'data-toggle' => "dropdown",
    	'role' => "button",
    	'aria-haspopup' => "true",
    	'aria-expanded' => "false"
    );
    return array_merge( $atts, $atts_new );
}; 
         

add_filter( 'nav_menu_item_title', 'laura_nav_menu_item_title', 10, 4 ); 

function laura_nav_menu_item_title( $title, $item, $args, $depth ) { 
	if ( !in_array( 'menu-item-has-children', $item->classes )) return $title;
    return $title . ' <span class="caret"></span>'; 
}; 


add_filter( 'wp_nav_menu', 'laura_wp_nav_menu' );  

function laura_wp_nav_menu ( $menu ) {  
  $menu = preg_replace( '/ class="sub-menu"/', '/ class="dropdown-menu" /', $menu);  
  return $menu;  
}  


