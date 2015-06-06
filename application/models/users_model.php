<?php
class Users_model extends CI_Model
{
	private $meta			=	array(); // empty meta
	function __construct()
	{
		parent::__construct();
		
		$this->refresh_user_meta();
	}
	
	function refresh_user_meta()
	{
		$this->meta		=	$this->options->get( null , $this->flexi_auth->get_user_id() , true );	
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
		if( $this->flexi_auth->is_logged_in() || $this->flexi_auth->is_logged_in_via_password() )
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Checks if a master user exists
	 *
	 * @return : bool
	**/
	
	function master_exists()
	{
		$this->db->cache_on(); // update while saving data to user database
			
		$masters	=	farray( $this->flexi_auth->get_user_privileges( array(
			'upriv_id as user_id',
			'upriv_name as privilege_name',
			'upriv_desc as privilege_desc',
			'upriv_id as privilege_id'			
		) , array(
			'upriv_users_upriv_fk'	=>	1
		) )->result_array() );
		
		$this->db->cache_off(); // turning off cache
		
		if( $masters ) // if admin main privilège exists
		{
			return true;
		}
		return false;
	}
	
	/**
	 * 	create user
	 *
	**/
	
	function create( $email , $username , $password , $privilege = 2 , $activate = false ) // 2 for user
	{
		$activate 			= 	$activate === 'yes' ? true : false;
		$custom_meta		=	$this->events->apply_filters( 'custom_user_meta' , array() );
		
		if( $this->flexi_auth->email_available( $email ) )
		{
			if( $this->flexi_auth->username_available( $username ) )
			{
				// may retreive default privilege for new users
				if( $this->flexi_auth->insert_user( $email , $username, $password , force_array( $custom_meta ) , $privilege , $activate ) )
				{
					return 'user-created';
				}
				return 'error-occured';
			}
			return 'username-already-taken';
		}
		return 'email-already-taken';
	}
	
	/**
	 * Send recovery email to an registered email
	**/
	
	function send_recovery_email( $email )
	{
		if( ! $this->flexi_auth->email_available( $email ) )
		{
			$exec	=	$this->flexi_auth->forgotten_password( $email );
			if( $exec )
			{
				return 'recovery-email-send';
			}
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
		$user	=	$this->flexi_auth->get_user_by_id( $user_id , array(
			'uacc_id as user_id',
			'uacc_email as user_email',
			'uacc_username as user_name',
			'uacc_active as active',
			'uacc_group_fk as group_id'
		) )->result_array();
		
		return farray( $user );		
	}
	
	/***
	 * Edit user
	 *
	 * @access : public
	 * @param
	**/
	
	function edit( $user_id , $email , $password , $activate , $group_id )
	{
		// activate convert
		$activate 			= 	$activate === 'yes' ? true : false;
		
		$default_fields	=	array(
			'uacc_email'		=>	$email,
			'uacc_active'		=>	$activate,
			'uacc_group_fk'		=>	$group_id,
			'uacc_active'		=>	$activate
		);		
		
		// password is not required
		if( $password )
		{
			$default_fields[ 'uacc_password' ] =  $password;
		}
		
		// add custom user fields
		$custom_fields	=	$this->events->apply_filters( 'custom_user_meta' , array() );
		
		foreach( force_array( $custom_fields ) as $key => $value )
		{
			$this->options->set( $key , $value , $autoload = true , $user_id , $app = 'users' );
		}
		
		$this->flexi_auth->update_user( $user_id , $default_fields );
	}
}