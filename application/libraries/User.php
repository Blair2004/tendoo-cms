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
	
	static function get( $user_par )
	{
		return get_instance()->auth->get_user( $user_par );
	}
	
	/**
	 * Group Is
	 *
	 * Check whether a user belong to a specific group
	 *
	 * @access public
	 * @param string
	 * @return bool
	**/
	
	static function group_is( $group_name )
	{
		return get_instance()->auth->is_member( $group_name );
	}
	
	/**
	 * Pseudo
	 * retreive user pseudo
	 * 
	 * @access public
	 * @param int (optional)
	 * @return string
	**/
	
	static function pseudo( $id = null )
	{
		if( $id === null )
		{
			$user		=	get_instance()->auth->get_user();
		}
		else
		{
			$user		=	get_instance()->auth->get_user( $id );
		}		
		return $user ? $user->name : __( 'N/A' );
	}
	
	/**
	 * Id
	 * return current user id
	 *
	 * @access public
	 * @return int
	**/
	
	static function id()
	{
		$user			=	get_instance()->auth->get_user();
		return $user ? $user->id : 0;
	}
}