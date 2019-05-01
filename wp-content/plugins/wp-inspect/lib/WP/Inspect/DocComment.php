<?php !defined('ABSPATH') && exit;

/**
 * @package WP_Inspect
 * @subpackage WP_Inspect_DocComment
 */
class WP_Inspect_DocComment extends Reflection {
    
    protected $comment;
    
    function __construct($comment)
    {
        $this->comment = $comment;
    }
    
    function getDocComment()
    {
        return $this->comment;
    }
};