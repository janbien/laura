<?php !defined('ABSPATH') && exit;

/**
 * Plugin Name: WP Inspect
 * Plugin URI: http://wp-inspect.com/
 * Description: The WordPress Debug Plugin.
 * Version: 1.0.0
 * Author: @explodybits
 * Author URI: https://twitter.com/explodybits/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package WP_Inspect
 */

require_once dirname(__FILE__) . '/inc/bootstrap.php';

wp_inspect(); // debug, debug, debug my darling.