<?php
class Admin_notice
{
	private $notice_type	=	array( 'info' , 'updates' );
	private $notices		=	array();
	
	function push( $message , $link	=	'#' , $icon	=	'' , $type = 'info' )
	{
		if( in_array( $type , $this->notice_type ) )
		{
			$this->notices[ $type ][]	=	array(
				'message'		=>		$message,
				'icon'			=>		$icon,
				'link'			=>		$link
			);
		}
		return;
	}
	
	function get( $type )
	{
		var_dump( $this->notices );
		return riake( $type , $this->notices );
	}
}