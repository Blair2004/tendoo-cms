<?php
class Users_model extends CI_Model
{
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
	
	function create( $email , $username , $password )
	{
		if( $this->flexi_auth->email_available( $email ) )
		{
			if( $this->flexi_auth->username_available( $username ) )
			{
				// may retreive default privilege for new users
				if( $this->flexi_auth->insert_user( $email , $username, $password , array(), 2 , false ) )
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
}