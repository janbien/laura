<?php 

add_filter( 'less_vars', function ( $vars, $handle ) {
    $vars[ 'brand-primary' ] = get_theme_mod('laura_primary_color', '#457AB2');
    return $vars;
}, 10, 2 );


add_action( 'customize_register', function ( $wp_customize ) {

    $wp_customize->add_section( 'laura_bootstrap' , array(
        'title'    => 'Laura Bootstrap',
        'priority' => 30
    ) );   

    $wp_customize->add_setting( 'laura_primary_color' , array(
        'default'   => '#457AB2',
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( 
    	new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		        'label'    => 'Primary color',
		        'section'  => 'laura_bootstrap',
		        'settings' => 'laura_primary_color',
			) 
    	) 
    );
});