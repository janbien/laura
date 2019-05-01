<?php !defined('ABSPATH') && exit;

/**#@+
 * Output Functions
 */
if (!function_exists('print_p')) {    
    /**
     * Prints human-readable information about a variable, but <pre> wrapped.
     * 
     * @param mixed The expression to be printed. 
     * @return boolean
     */    
    function print_p($expression)
    {
        ob_start();
        echo '<pre>';
        print_r($expression, false);
        echo '</pre>';
        return 1;
    };
}

if (!function_exists('print_e')) {
    /**
     * Prints human-readable information about a variable to the PHP error log.
     * 
     * @param mixed The expression to be printed.
     * @return boolean
     */   
    function print_e($expression)
    {
        error_log(print_r($expression, true));
        return 1;
    };
}
/**#@-*/

/**#@+
 * Helper Functions
 */
if (!function_exists('is_debug')) {
    /**
     * Returns whether or not debug is enabled.
     * 
     * @return boolean
     */    
    function is_debug()
    {
        return defined('WP_DEBUG') && true === WP_DEBUG;
    };
}

if (!function_exists('is_ajax')) {
    /**
     * Returns whether or not debug is enabled.
     * 
     * @return boolean
     */    
    function is_ajax($admin = true)
    {
        return ($admin && is_admin()) && (strtolower(@$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' || defined('DOING_AJAX')) && !defined('DOING_AUTOSAVE');
    };
}

if (!function_exists('is_rest')) {
    /**
     * Is rest request?
     *
     * @return bool
     */
    function is_rest()
    {
        if (defined('REST_REQUEST') && true === REST_REQUEST)
            return true;

        if (!function_exists('rest_get_url_prefix') ||
            false !== strpos(current_filter(), 'rest_url'))             
            return false;
        
        $path = get_site_path(rest_get_url_prefix());
        $regex = '/^' . preg_quote($path, '/') . '(?:(?:\/|\?).*)?$/';
        
        return 1 === preg_match($regex, $_SERVER['REQUEST_URI']);
    };
}
/**#@-*/

if (!function_exists('is_user_logging_out')) {
    /**
     * Returns whether or not the user is logging out.
     * 
     * @return bool
     */
    function is_user_logging_out()
    {
        return is_user_logged_in() && isset($_REQUEST['action']) && 'logout' === strtolower($_REQUEST['action']);
    };
};

if (!function_exists('is_user_logging_in')) {
    /**
     * Returns whether or not the user is logging in.
     * 
     * @return bool
     */    
    function is_user_logging_in()
    {
        return !is_user_logged_in() && @isset($_REQUEST['user_login']);
    };
};

if (!function_exists('is_admin_action')) {
    /**
     * Is an admin action being performed?
     * 
     * @return bool
     */    
    function is_admin_action()
    {
        return is_admin() && @isset($_REQUEST['action']);
    };
}

if (!function_exists('get_site_path')) {
    /**
     * Gets the site URI/path.
     *
     * @param string $path {@see get_site_url()}.
     *
     * @return string The site URI/path as returned from get_site_url(), but 
     *                beginning with the request URI like $_SERVER['REQUEST_URI'].
     */
    function get_site_path($path = '')
    {
        $url = get_site_url(null, $path, null);
        return preg_replace('/^https?:\/\/[^\/]+/i', '', $url);
    };
}

if (!function_exists('get_user_roles')) {
    function get_user_roles($user_id = 0)
    {
        if (empty($user_id)) {
            
            if (!function_exists('wp_get_current_user'))
                require_once ABSPATH . WPINC . '/pluggable.php';

            $user = wp_get_current_user();
            
        } else {
            
            $user = new WP_User($user_id);
        }
        
        return (array)$user->roles;        
    }    
}

if (!function_exists('is_user_in_role')) {
    function is_user_in_role($role, $user_id = 0)
    {
        $role = strtolower($role);        
        $roles = get_user_roles($user_id);        
        
        return in_array($role, array_map('strtolower', $roles));
    };
}

/**
 * Plugin entry-point helper
 * 
 * @return object
 */
function wp_inspect()
{
    return WP_Inspect::init();
};

/**
 * SPL autoload helper
 * 
 * @param string $class
 */
function wpi_spl_autoload($class)
{    
    $file = strtr($class, '\\_', DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR) . '.php';

    if (!function_exists('stream_resolve_include_path') ||
        false !== stream_resolve_include_path($file))
        include $file;
};

/**
 * Takes arguments and converts to a readable/formatted string.
 * 
 * @param mixed $arg
 * @param int $indent
 * @return string
 */
function wpi_parse_arg($arg, $indent = 0)
{
    if ($indent >= WPI_MAX_RECURSION)
        return '[RECURSION]';
    
    if (is_object($arg))
        if ($arg instanceof stdClass) {
            $arg = str_replace('array', 'stdClass', wpi_parse_arg((array)$arg, $indent));
        } else {            
            $arg = sprintf("%s(\n%s", get_class($arg),  str_repeat('    ', $indent + 1))
                 . trim(preg_replace('/^array\(|[ ]*\),?$/', '', wpi_parse_arg(get_object_vars($arg), $indent)))
                 . sprintf("\n%s)", str_repeat('    ', $indent));
        }
    else if (is_array($arg)) {
        
        $args = array();

        foreach ($arg as $k => $v) {
                        
            if (preg_match('/salt|pw|password/i', $k))
                $v = '[REMOVED FOR SECURITY PURPOSES]';
            
            if ($arg === $v)
                continue;
            
            if (!is_int($k))
                $args[] = "'" . $k . '\' => '. wpi_parse_arg($v, $indent + 1);
            else
                $args[] = wpi_parse_arg($v, $indent + 1);
        }

        $arg = sprintf("array(\n%s", str_repeat('    ', $indent + 1))
             . implode(sprintf(",\n%s",  str_repeat('    ', $indent + 1)), $args)
             . sprintf("\n%s)", str_repeat('    ', $indent));
        
    } else {
        if (is_resource($arg))
            $arg = '(resource)';
        else if (is_null($arg))
            $arg = 'NULL';
        else if (is_bool($arg))
            $arg = true === $arg ? 'TRUE' : 'FALSE';
        else if (is_string($arg)) {
            if (false !== strpos($arg, '"'))
                $arg = "'" . str_replace("'", "\\'", $arg) . "'";
            else if (false !== strpos($arg, "'"))
                $arg = '"' . str_replace('"', '\"', $arg) . '"';
            else
                $arg = "'" . $arg . "'";

            $arg = htmlentities($arg);
        }
        else if (empty($arg))
            $arg = "''";
    }

    $arg = preg_replace('/\([ \r\n]+\)/ms', '()', $arg);
        
    return $arg;
};

