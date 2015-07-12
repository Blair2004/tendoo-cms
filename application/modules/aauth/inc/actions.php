<?php
class aauth_action extends CI_model
{
	function __construct()
	{
		$this->events->add_action( 'do_register_user' , array( $this , 'register_user' ) );	
		$this->events->add_action( 'do_send_recovery' , array( $this , 'change_auth_settings' ) );
		$this->events->add_action( 'do_send_recovery' , array( $this , 'recovery_email' ) );
		$this->events->add_action( 'do_login' , array ( $this , 'tendoo_login' ) );
	}
	function register_user()
	{
		$exec	=	$this->users->create( 
			$this->input->post( 'email' ), 
			$this->input->post( 'password' ),
			$this->input->post( 'username' )
		);
		
		if( $exec === 'user-created' )
		{
			redirect( array( 'sign-in?notice=' . $exec ) );
		}
		
		$this->notice->push_notice( $this->lang->line( $exec ) );
	}
	function recovery_email()
	{
			// Send Recovery
			$exec 	=	$this->user->send_recovery_email( $this->input->post( 'user_email' ) );
			
			if( $exec === 'recovery-email-send' )
			{
				redirect( array( 'sign-in?notice=' . $exec ) );
			}
			$this->notice->push_notice( $this->lang->line( $exec ) );
	}
	
	/**
	 * Change Auth Class Email Settings
	 *
	 * @return : void
	**/
	
	function change_auth_settings()
	{
		$auth				=	&$this->users->auth->config_vars;
		$auth[ 'email' ]	=	'cms@tendoo.org';
		$auth[ 'name' ]		=	get( 'core_signature' ); 
	}
	
	/**
	 * Log user in
	 *
	**/
	
	function tendoo_login()
	{
		// Apply filter before login
		$fields_namespace	=	$this->login_model->get_fields_namespace();
		$exec 				=	$this->users->login( $fields_namespace );
		if( $exec == 'user-logged-in' )
		{
			if( riake( 'redirect' , $_GET ) )
			{
				redirect( riake( 'redirect' , $_GET ) );
			}
			else
			{
				redirect( array( 'dashboard' ) );
			}
		}
		$this->notice->push_notice( $this->lang->line( $exec ) );
	}
}
new aauth_action;