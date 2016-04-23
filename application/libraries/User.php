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
	 * Checks whether a user is connected
	 * @access public
	 * @return bool
	**/
		
	static function is_connected()
	{
		$Instance	=	get_instance();
		return $Instance->users->is_connected();
	}
	
	static function get( $user_par = FALSE )
	{
		return get_instance()->auth->get_user( $user_par );
	}
		
	/**
	 * Pseudo
	 * retreive user pseudo
	 * 
	 * @access public
	 * @param int (optional)
	 * @return string
	**/
	
	static function pseudo( $id = FALSE )
	{
		$user		=	get_instance()->auth->get_user( $id );	
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
	
	// Permission
	
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
	 * Create User Permission
	 * 
	 * @params string permission
	 * @params string definition
	 * @return bool
	**/
	
	static function create_permission( $permission , $definition, $description = '' )
	{
		return get_instance()->auth->create_perm($permission, $definition='', $description = '');
	}
	
	/**
	 * Delete User Permission
	 * 
	 * @params int user id,
	 * @return bool
	**/
	
	static function delete_permission( $permission )
	{
		return get_instance()->auth->delete_perm($perm_par);
	}
	
	/**
	 * Update User Permission
	 * 
	 * @params int user id,
	 * @params string name
	 * @params string definition
	 * @return bool
	**/
	
	static function update_permission( $perm_id , $name , $definition, $description = '' )
	{
		return get_instance()->auth->update_perm($perm_id, $name, $definition, $description = '' );
	}
	
	// Groups
	
	/**
	 * Create group
	 * let you create more group for tendoo
	 * 
	 * @access public
	 * @params string, string, string
	 * @return string
	**/
	
	static function create_group( $name , $definition , bool $is_admin , $description)
	{
		return get_instance()->auth->create_group( $name , $definition , $is_admin , $description );
	}
	
	/**
	 * Update Group
	 * let you update existent group
	 * 
	 * @access group
	 * @params string, string, string, int
	**/
	
	static function update_group( $id , $name , $definition , bool $is_admin, $description )
	{
		return get_instance()->auth->update_group( $id, $name , $definition , $is_admin , $description );
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
	
	static function in_group( $group_name )
	{
		return get_instance()->auth->is_member( $group_name );
	}
	
	/**
	 * Allow Group 
	 * Add a permission to a group
	 * 
	 * @params int Group id
	 * @params int Permission id
	 * @return bool
	**/
	
	static function allow_group( $group_id , $permission_id )
	{
		return get_instance()->auth->allow_group($group_id, $permission_id );
	}
	
	/**
	 * Delete User Group
	 * 
	 * @params int Group Id
	 * @return bool
	**/
	
	static function delete_group( $group_id )
	{
		return get_instance()->auth->delete_group( $group_id );
	}
	
	/**
	 * User Group
	 *
	 * @param int user id
	 * @return object
	**/
	
	static function groups( $user_id = NULL ) 
	{
		return get_instance()->auth->get_user_groups();
	}
	
	
}