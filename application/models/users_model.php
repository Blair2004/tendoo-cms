<?php
class Users_model extends CI_Model
{
	private $meta			=	array(); // empty meta
	function __construct()
	{
		parent::__construct();
		
		// Loading Aauth Class 
		// @branch 1.5-auth-class		
		$this->load->library( 'aauth' ,  array() ,  'auth' );
		
		// $this->refresh_user_meta();
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
		return $this->auth->is_loggedin();
	}
	
	/**
	 * Checks if a master user exists
	 *
	 * @return : bool
	**/
	
	function master_exists()
	{
		$masters	=	$this->auth->list_users( $this->config->item( 'master-group-label' ) );
		if( $masters ) // if admin main privilège exists
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Creae Master User
	**/
	
	function create_master( $email , $password , $username )
	{
		$this->auth->create_group( $this->config->item( 'master-group-label' ) );
		// Create user
		if( $this->auth->create_user( $email, $password , $username ) ); // set to group 1 as
		{
			// Add user to a group
			// We assume 1 is the index of the first user
			$master_id		=	$this->auth->get_user_id( $email );
			$this->auth->add_member( $master_id , $this->config->item( 'master-group-label' ) );
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
	 *
	**/
	
	function logout()
	{
		return $this->auth->logout();
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