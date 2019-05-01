<?php !defined('ABSPATH') && exit;

/**
 * @package WP_Inspect
 * @subpackage WP_Inspect_Exception
 */
class WP_Inspect_Exception extends Exception
{
    function __construct($message = null, $code = 0, $file = null, $line = -1, $context = array(), Exception $previous = null)
    {
        if (is_array($message))
            $message = array_shift($message);
        
        if (!is_long($code))
            $code = PHP_INT_MAX;
        
        parent::__construct((string)$message, (int)$code, $previous);
        
        $this->file = $file;
        $this->line = $line;
    }    
};
