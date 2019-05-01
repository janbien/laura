<?php !defined('ABSPATH') && exit;

// obvs
!defined('PS') && define('PS', PATH_SEPARATOR);
!defined('DS') && define('DS', DIRECTORY_SEPARATOR);

!defined('E_DEPRECATED') && define('E_DEPRECATED', 8192);
!defined('E_USER_DEPRECATED') && define('E_USER_DEPRECATED', 16384);

define('WPI_PLUGIN_DIR', dirname(dirname(__FILE__)) . DS); // Plugin DIR
define('WPI_PLUGIN_FILE', WPI_PLUGIN_DIR . '/wp-inspect.php'); // Plugin FILE
define('WPI_MAX_RECURSION', 10);
