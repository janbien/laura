<?php 

namespace Laura\Events;

defined( 'ABSPATH' ) or die();

use WP_Query, Jigsaw;

class Container {

    var $post_type = 'event';
    var $shortcode = 'events';

    function boot() {

        add_action( 'init', [ $this, 'cpt' ] );
        add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );
        add_shortcode( $this->shortcode, [ $this, 'shortcode' ] );
    
        add_filter('acf/settings/load_json', function($paths) {
            $paths[] = __DIR__ . '/acf-json';
            return $paths;
        });

        if ( class_exists( 'Jigsaw' ) and function_exists( 'the_field' ) ) {
            Jigsaw::add_column( $this->post_type, 'Datum konání', function( $pid ){
                the_field( 'date', $pid );
            }, 2);
        }

    }

    function cpt() {
        register_post_type( $this->post_type, 
            array(	
                'label' => 'Events',
                'public' => true,
                'supports' => array( 'title', 'revisions', 'editor' )
            )
        );
    }

    function pre_get_posts ( $query ) {
        if( !is_admin() ) return;
        if ( $query->get('post_type') != $this->post_type )  return;
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'DESC' );
        $query->set( 'meta_key', 'date' );
    }

    function shortcode( $atts, $content ) {

        $atts = shortcode_atts( array(
            'title' => 'Events',
            'null' => 'No events.'
        ), $atts , $this->shortcode );
    
        $query_attrs = array(
            'post_type' => $this->post_type,
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key'		=> 'date',
                    'compare'	=> '>=',
                    'value'		=> date( 'Ymd' )
                )
            ),
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_key' => 'date',
    
        );
        
        $query = new WP_Query( $query_attrs );
    
        if ( !$query->have_posts() ) return $atts['null'];
        ob_start();
        include( __DIR__ . '/template.php' );
        return ob_get_clean();
    }

}




