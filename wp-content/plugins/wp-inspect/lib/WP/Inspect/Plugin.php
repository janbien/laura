<?php !defined('ABSPATH') && exit;

/**
 * @package WP_Inspect
 * @subpackage WP_Inspect_Plugin
 */
abstract class WP_Inspect_Plugin extends WP_Inspect_Singleton {
    
    protected $meta;
    
    /**
     * @access protected
     * @constructor
     * @return void
     */
    protected function __construct()
    {
        $this->meta = (object)array_change_key_case(get_plugin_data($this->get_file()));    
        $this->meta->slug = sanitize_title($this->meta->name);
        $this->meta->abbr = strtolower(preg_replace('/[^A-Z]/', '', $this->meta->name));
    }
    
    /**
     * Returns the WP_Inspect_Plugin derived instance.
     * 
     * @static
     * @access protected
     * @param string $class
     * @return object Instance of WP_Inspect_Plugin
     */
    protected static function get_instance($class = __CLASS__)
    {        
        $instance = parent::get_instance($class);
        
        add_action('plugins_loaded', array($instance, 'load'), 0);
        add_action('init', array($instance, 'loaded'), 0);
                
        if (is_admin()) {
            $file = $instance->get_file();            
            register_activation_hook($file, array($instance, 'activate'));
            register_deactivation_hook($file, array($instance, 'deactivate'));
        }

        return $instance;
    }    
    
    /**
     * Executes after 'plugins_loaded' hook.
     * 
     * @return void
     */
    public function load()
    {}
    
    /**
     * Executes after 'init' hook.
     * 
     * @return void
     */    
    public function loaded()
    {}
    
    /**
     * Executes during plugin activation.
     * 
     * @return void
     */        
    public function activate()
    {}

    /**
     * Executes during plugin deactivation.
     * 
     * @return void
     */    
    public function deactivate()
    {}

    /**
     * Creates an <input> name attribute value in array format.
     * 
     * @param string $name
     * @return string
     */
    function get_field_name($name, $abbr = false)
    {
        if (false === strpos($name, '['))
            $name = sprintf('%s[%s]', !$abbr ? $this->meta->slug : $this->meta->abbr, str_replace('-', '_', sanitize_title($name)));
        else {
            $name = array_filter(preg_split('/[\[\]]/', $name));
            $name = $this->get_field_name(array_shift($name)) . '[' . array_shift($name) . ']';
        }
        
        return $name;
        //return sprintf('%s[%s]', !$abbr ? $this->meta->slug : $this->meta->abbr, str_replace('-', '_', sanitize_title($name)));
    }
    
    /**
     * Echos the <input> name attribute value.
     * 
     * @see self::get_field_name()
     * @param string $name
     */
    function field_name($name, $abbr = false)
    {        
        echo $this->get_field_name($name, $abbr);
    }

    /**
     * Creates an element id attribute value in WP's slug format.
     * 
     * @param string $id
     * @return string
     */
    
    function get_field_id($id, $abbr = false)
    {
        return sprintf('%s-%s', !$abbr ? $this->meta->slug : $this->meta->abbr, str_replace('_', '-', sanitize_title($id)));
    }
    
    /**
     * Echos the element id attribute value.
     * 
     * @see self::get_field_id()
     * @param string $id
     */    
    function field_id($id, $abbr = false)
    {
        echo $this->get_field_id($id, $abbr);
    }
    
    /**
     * Returns the contents of a rendered template.
     * 
     * @see self::render()
     * @param string $tpl
     * @param array $data
     * @return string
     */
    function get_render($tpl, $data = array())
    {
        ob_start();
        $this->render($tpl, $data);
        return ob_get_clean();
    }
    
    /**
     * Echos the renderd template.
     * 
     * @param string $tpl
     * @param array $data
     */
    function render($tpl, $data = array())
    {
        if (null !== $data && is_object($data))
            $data = (array)$data;
        
        extract($data);
        require dirname($tpl) . DS . basename($tpl, '.php') . '.php';        
    }
    
    /**
     * Returns entry-point file for plugin.
     * @throws Exception
     */
    public function get_file()
    {
        throw new Exception(__METHOD__ . 'must be overridden.');
    }       

    /**
     * Plugin entry-point.
     * 
     * @throws Exception
     */
    public static function init()
    {
        throw new Exception(__METHOD__ . 'must be overridden.');
    }
};