<?php
class UI
{
	private static $notices	=	array();
	private static $info	=	array();
	
	/**
	 * Push notice to UI array
	 *
	 * @access public
	 * @params string message
	 * @params string type
	 * @returns bool
	**/
	
	static function push_notice( $message , $type = 'info' , $icon = false , $href= '#' )
	{
		if( is_array( $message ) && count( $message ) > 0 )
		{
			// var_dump( $message );
			self::push_notice( $message[ 'msg' ] , riake( 'type' , $message ) , riake( 'icon' , $message ) , riake( 'href' , $message , $href ) );
		}
		else if( is_string( $message ) )
		{
			self::$notices[]	=	array(
				'type'		=>	$type,
				'msg'			=>	$message,
				'icon'		=>	$icon,
				'href'		=>	$href
			);
		}
	}
	
	/**
	 * Get notices
	**/
	
	static function get_notices()
	{
		return self::$notices;
	}
}