<?php !defined('ABSPATH') && exit;

set_include_path(dirname(__FILE__) . '/../lib/' . PATH_SEPARATOR . get_include_path());

mb_substitute_character(0x002A);
ini_set('memory_limit', '-1');
#error_reporting(~ E_WARNING | E_STRICT | E_USER_WARNING | E_NOTICE | E_USER_NOTICE);

require_once dirname(dirname(__FILE__)) . '/inc/constants.php';
require_once WPI_PLUGIN_DIR . '/inc/compat.php';
require_once WPI_PLUGIN_DIR . '/inc/functions.php';

if (!function_exists('get_plugin_data')) 
    require_once ABSPATH . '/wp-admin/includes/plugin.php'; 
    
spl_autoload_register('wpi_spl_autoload');