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

    public static function push_notice( $message, $namespace = null, $type = 'info', $icon = false, $href= '#', $prefix = '' )
    {
        if (is_array($message) && count($message) > 0) {
            foreach ($message as $_message) {
                if( @$_message[ 'namespace' ] != null ) {
                    self::push_notice(
                        @$_message[ 'message' ],
                        @$_message[ 'namespace' ],
                        @$_message[ 'type' ],
                        @$_message[ 'icon' ],
                        @$_message[ 'href' ],
                        @$_message[ 'prefix' ]
                    );
                }
            }
        } elseif ( is_string( $message ) ) {

            $Cache      =   new CI_Cache( array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'tendoo_notices_' ) );

            /**
             * Only Save notice when it's not cached
            **/

            if( ! $Cache->get( $namespace ) ) {
                if( $namespace != null ) {
                    $Cache->save( $namespace, array(
                        'message'   =>  $message,
                        'namespace' =>  $namespace,
                        'type'      =>  $type,
                        'icon'      =>  $icon,
                        'href'      =>  $href,
                        'prefix'    =>  $prefix
                    ) );
                }
            }
        }
    }

    /**
     * Get notices
    **/

    public static function get_notices()
    {
        $Cache_data =   array();
        $Cache      =   get_prefixed_cache( 'tendoo_notices_' );
        foreach( $Cache as $_Cache ) {
            $Cache_data[]   =   ( array ) @$_Cache[ 'data' ];
        }
        return $Cache_data;
    }
}
