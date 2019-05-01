<?php !defined('ABSPATH') && exit;

/**
 * PHP < 5.3 singleton pattern.
 * 
 * @package WP_Inspect
 * @subpackage WP_Inspect_Singleton
 */
abstract class WP_Inspect_Singleton {

    protected static $_instances;
    
    protected function __construct()
    {}
    
    protected function __clone()
    {}
    
    /**
     * Returns the singleton instance.
     * 
     * @param string $class
     * @return string
     * @throws Exception
     */
    protected static function get_instance($class = __CLASS__)
    {        
        if (__CLASS__ === $class)
            throw new Exception(__METHOD__ . ' must be overridden');
        
        if (null === self::$_instances)
            self::$_instances = array();

        if (@isset(self::$_instances[$class]))
            return self::$_instances[$class];
        
        self::$_instances[$class] = new $class();
        $instance = self::$_instances[$class];

        return $instance;
    }
};