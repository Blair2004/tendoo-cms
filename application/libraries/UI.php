<?php
class UI
{
    private static $notices    =    array();
    private static $info    =    array();
    
    /**
     * Push notice to UI array
     *
     * @access public
     * @param string message
     * @param string type
     * @returns bool
    **/
    
    public static function push_notice($message, $type = 'info', $icon = false, $href= '#')
    {
        if (is_array($message) && count($message) > 0) {
            foreach ($message as $_message) {
                self::push_notice($_message[ 'msg' ], riake('type', $_message), riake('icon', $_message), riake('href', $_message, $href));
            }
        } elseif (is_string($message)) {
            self::$notices[]    =    array(
                'type'        =>    $type,
                'msg'            =>    $message,
                'icon'        =>    $icon,
                'href'        =>    $href
            );
        }
    }
    
    /**
     * Get notices
    **/
    
    public static function get_notices()
    {
        return self::$notices;
    }
}
