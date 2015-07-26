<?php
/** 
 * An easy way to access Auth and User_model methods
 * @branch 1.5
 * @author Blair Jersyer
 * @since 1.5
**/
class User
{
	static private $user_par;
	
	/**
	 * Checks whether a user is granted for a permission
	 * @access public
	 * @since 1.5
	 * @return boolean
	**/
	
	static function can( $permission )
	{
		$Instance	=	get_instance();
		return $Instance->auth->is_group_allowed( $permission );
	}
	
	/** 
	 * Checks whether a user is connected
	 * @access public
	 * @return bool
	**/
		
	static function is_connected()
	{
		$Instance	=	get_instance();
		return $Instance->users->is_connected();
	}
}