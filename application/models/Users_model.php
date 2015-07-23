<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
	private $meta			=	array(); // empty meta
	function __construct()
	{
		parent::__construct();
		
		// Loading Aauth Class 
		// @branch 1.5-auth-class
		$this->load->library( 'aauth' ,  array() ,  'auth' );		
		
		if( $this->auth->is_loggedin() )
		{
			$this->refresh_user_meta();
		}
	}
	
	function refresh_user_meta()
	{
		$this->meta		=	$this->options->get( null , $this->auth->get_user_id() , true );
		$this->current	=	$this->auth->get_user();	
	}
	public function get_meta( $key )
	{
		return riake( $key , $this->meta );
	}
	/**
	 * Checks whether a user is connected 
	 *
	 *	@return : bool
	**/
	function is_connected()
	{
		return $this->auth->is_loggedin();
	}
	
	/**
	 * Checks if a master user exists
	 *
	 * @return : bool
	**/
	
	function master_exists()
	{
		foreach( $this->config->item( 'master_group_label' ) as $group_name )
		{
			$masters	=	$this->auth->list_users( $group_name );
			if( $masters ) // if admin main privilège exists
			{
				return true;
			}
		}		
		return false;
	}
	
	// Should be called by tendoo only
	function create_default_groups()
	{
		// Only create if group does'nt exists (it's optional)
		// Creating admin Group
		foreach( $this->config->item( 'master_group_label' ) as $group_name )
		{
			if( ! $group = $this->auth->get_group_id( $group_name ) )
			{
				$this->auth->create_group( $group_name );
			}
		}
		
		// Creating Public Group
		foreach( $this->config->item( 'public_group_label' ) as $group_name )
		{
			if( ! $group = $this->auth->get_group_id( $group_name ) )
			{
				$this->auth->create_group( $group_name );
			}
		}
	}
	
	/**
	 * Creae Master User
	**/
	
	function create_master( $email , $password , $username )
	{
		// Create user
		if( $this->auth->create_user( $email, $password , $username ) ); // set to group 1 as
		{
			// Add user to a group
			// We assume 1 is the index of the first user
			$master_id				=	$this->auth->get_user_id( $email );
			
			// Fetch Master Group Name
			$master_group_array		=	$this->config->item( 'master_group_label' );
			$this->auth->add_member( $master_id , $master_group_array[0] ); // assign user to one of the admin group
			// Send Verification
			$this->auth->send_verification( $master_id );
			// Activate Master
			$users			=	$this->auth->get_user( $master_id );
			$this->auth->verify_user( $master_id , $users->verification_code );
			return 'user-created';
		}
		return 'unexpected-error';
	}
	
	/**
	 * 	Create user with default privilege
	 *  
	 * 	@access : public
	 *  @param : string email
	 * 	@param : string password
	 * 	@param : string name
	 * 	@return : bool
	**/
	
	function create( $email , $password , $username , $group_par , $validate = false )
	{
		$user_creation_status	=	$this->auth->create_user($email, $password, $username);
		if( ! $user_creation_status )
		{
			return 'fetch-error-from-auth';
		}
		// bind user to a speciifc group
		$user_id		=	$this->auth->get_user_id( $email );
		// Send Verification
		$this->auth->send_verification( $user_id );
		
		// Adding to a group		
		// refresh group
		$this->auth->add_member( $user_id , $group_par );			
		
		// Validate User
		if( $validate == true )
		{
			$user			=	$this->auth->get_user( $user_id );
			$this->auth->verify_user( $user , $users->verification_code );
		}
		
		// add custom user fields
		$custom_fields	=	$this->events->apply_filters( 'custom_user_meta' , array() );		
		foreach( force_array( $custom_fields ) as $key => $value )
		{
			$this->options->set( $key , $value , $autoload = true , $user_id , $app = 'users' );
		}
		
		return 'user-created';		
	}
	
	/***
	 * Edit user
	 *
	 * @access : public
	 * @param
	**/
	
	function edit( $user_id , $email , $password , $group_id , $user_group , $old_password = null , $mode = 'edit' )
	{
		$return		=	'user-updated';
		// old password has been defined
		if( $old_password != NULL && $mode == 'profile' )
		{
			if( $password === $old_password ): return 'pass-change-error'; endif;
			// get user using old password
			$query	=	$this->db->where( 'id' , $user_id )->where( 'pass' , $this->auth->hash_password( $old_password , $user_id ) )->get( 'aauth_users' );
			// if password is correct
			if( $query->result_array() )
			{
				 $return	=	array();
				 $return[]	=	$this->auth->update_user( $user_id , $email , $password );
			}
			else
			{
				return 'old-pass-incorrect';
			}
		}
		
		// This prevent editing privilege on profile dash
		if( $mode == 'edit' )
		{
			// var_dump( $user_group );
			// remove member
			$this->auth->remove_member( $user_id , $user_group->group_id );
			
			// refresh group
			$this->auth->add_member( $user_id , $group_id );
			
			// Change user password and email
			$this->auth->update_user( $user_id , $email , $password );
		}
				
		// add custom user fields
		$custom_fields	=	$this->events->apply_filters( 'custom_user_meta' , array() );
		
		foreach( force_array( $custom_fields ) as $key => $value )
		{
			$this->options->set( $key , $value , $autoload = true , $user_id , $app = 'users' );
		}
		return $return;
	}
	
	/**
	 * Delete specified user with his meta
	 *
	 * @access : public
	 * @params : array
	 * @return : bool
	**/
	
	function delete( $user_id )
	{
		// delete options
		$this->options->delete( null , $user_id , 'users' );
		// remove front auth class
		return $this->auth->delete_user( $user_id );
	}
	/**
	 *
	**/
	
	function logout()
	{
		return $this->auth->logout();
	}
	
	/**
	 * Login
	**/
	
	function login( $login_fields_namespace )
	{
		$exec		=		$this->auth->login( 
			$this->input->post( riake( 'username_or_email' , $login_fields_namespace ) ) , 
			$this->input->post( riake( 'password' , $login_fields_namespace ) ) , 
			$this->input->post( riake( 'keep_connected' , $login_fields_namespace ) ) ? true : false,
			$this->config->item( 'username_login' )
		); 
		
		if( $this->auth->is_loggedin() )
		{
			return 'user-logged-in';
		}
		return 'fetch-error-from-auth';
	}
	
	/**
	 * Send recovery email to an registered email
	**/
	
	function do_send_recovery( $email )
	{
		if( $this->auth->user_exsist_by_email( $email ) )
		{
			$exec	=	$this->auth->remind_password( $email );
			return 'recovery-email-send';
		}
		else
		{
			return 'unknow-email';
		}
	}
	/**
	 * Get user By id
	**/
	function get( $user_id )
	{
		$user	=	$this->auth->get_user_by_id( $user_id );
		
		return farray( $user );		
	}
	
	/**
	 * Create a new role
	 *
	 * @access public
	 * @params string role name
	 * @params string role definition
	 * @params string role type
	 * @return string error code
	**/
	
	function set_group( $name , $definition , $type , $mode = 'create' , $group_id = 0 )
	{
		$name	=	strtolower( $name );
		// Check wether a group using this name exists
		$group	=	$this->auth->get_group_name( $name );
		
		if( $mode === 'create' )
		{
			if( $group === FALSE )
			{
				$this->users->auth->create_group( $name );
				$admin_groups		=	force_array( $this->options->get( 'admin_groups' ) );
				$public_groups		=	force_array( $this->options->get( 'public_groups' ) );  
				// make sure to delete groups saved on option table
				if( ! in_array( $name , $admin_groups ) &&  ! in_array( $name , $public_groups ) )
				{
					// Saving as public group
					if( $type === 'public' )
					{
						$public_groups[]	=	$name;
						$this->options->set( 'public_groups' , $public_groups );
					}
					// Saving as admin group
					else
					{
						$admin_groups[]	=	$name;
						$this->options->set( 'admin_groups' , $admin_groups );
					}
					return 'group-created';
				}
			}
		}
		else
		{
			$group_name			=	$this->auth->get_group_name( $group_id );
			if( $group_name )
			{
				// Update group name
				$this->auth->update_group($group_id, $name );
				
				// get all groups types
				$admin_groups		=	force_array( $this->options->get( 'admin_groups' ) );
				$public_groups		=	force_array( $this->options->get( 'public_groups' ) );  
				
				// remove from admin_groups
				array_walk( $admin_groups , function( &$item , $key , $group_name ) use( &$admin_groups ){					
					if( $group_name === $item )
					{
						unset( $admin_groups[ $key ] );
					}
				} , $group_name );
				
				// remove from public group
				array_walk( $public_groups , function( &$item , $key , $group_name ) use( &$public_groups ){
					if( $group_name === $item )
					{
						unset( $public_groups[ $key ] );
					}
				} , $group_name );
				
				// make sure to delete groups saved on option table
				if( ! in_array( $name , $admin_groups ) || ! in_array( $name , $public_groups ) )
				{
					// Saving as public group
					if( $type === 'public' )
					{
						$public_groups[]	=	$name;						
					}
					// Saving as admin group
					else
					{ 
						$admin_groups[]	=	$name;						
					}
					$this->options->set( 'public_groups' , $public_groups );
					$this->options->set( 'admin_groups' , $admin_groups );

					return 'group-updated';
				}
			}
			return 'unknow-group';
		}
		return 'group-already-exists';
	}
	
	function create_permissions()
	{
		// Creating default permissions
		$this->auth->create_perm( 'manage_options' , 'Let user access settings page and to manage it.' ); // index 1
		$this->auth->create_perm( 'manage_modules' , 'Let user access to modules list and to manage it.' ); // 2
		$this->auth->create_perm( 'manage_users' , 'Let user access user list and manage them.' ); // index 3		

		// Master		
		$this->users->auth->allow_group( 'master' , 'manage_options' );
		$this->users->auth->allow_group( 'master' , 'manage_modules' );
		$this->users->auth->allow_group( 'master' , 'manage_users' );
		
		// Administrators
		$this->users->auth->allow_group( 'administrators' , 'manage_options' );
		$this->users->auth->allow_group( 'administrators' , 'manage_modules' );		
	}
}