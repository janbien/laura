<?php  
/*
 * Plugin name: Laura Events
 * Plugin URI: https://github.com/janbien/laura/tree/master/wp-content/plugins/laura-events
 * Version: 1.2
 * Author: Jan Bien
 * Author URI: https://www.webmistr.wtf
 * License: GPL2
*/

namespace Laura\Events;

defined( 'ABSPATH' ) or die();

require_once( __DIR__ . '/class-container.php' );

function boot() {
	$container = new Container;
	$container->boot();
}

boot();

