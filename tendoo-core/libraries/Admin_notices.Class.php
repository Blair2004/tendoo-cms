<?php
class Admin_notices
{
	private $notice_type	=	array( 'info' , 'updates' );
	private $notices		=	array();
	
	function push( $message , $link	=	'#' , $icon	=	'' , $type = 'info' )
	{
		if( in_array( $type , $this->notice_type ) )
		{
			$this->notices[ $type ][]	=	array(
				'message'		=>		$message,
				'icon'			=>		$icon == '' ? 'fa-star' : $icon,
				'link'			=>		$link
			);
		}
		return;
	}
	
	function get( $type )
	{
		return riake( $type , $this->notices );
	}
}