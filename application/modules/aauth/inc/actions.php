<?php
class aauth_action extends CI_model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'do_register_user' , array( $this , 'register_user' ) );	
		$this->events->add_action( 'do_send_recovery' , array( $this , 'change_auth_settings' ) );
		$this->events->add_action( 'do_send_recovery' , array( $this , 'recovery_email' ) );
		$this->events->add_action( 'do_login' , array ( $this , 'tendoo_login' ) );
		$this->events->add_action( 'do_reset_user' , array( $this , 'do_reset_user' ) );
		$this->events->add_action( 'do_verify_user' , array( $this , 'do_verify_user' ) );
		$this->events->add_action( 'do_remove_module' , array( $this , 'module_access' ) , 1 , 1);
		$this->events->add_action( 'do_disable_module' , array( $this , 'module_access' ) , 1 , 1);
		$this->events->add_action( 'do_enable_module' , array( $this , 'module_access' ) , 1 , 1);
	}
	
	/**
	 * Checks whether user is granted to access modules
	**/
	
	function module_access()
	{
		if( ! User::can( 'manage_modules' ) ): redirect( array( 'dashboard?notice=access-denied' ) ); endif;
	}
	function do_verify_user( $user_id , $ver_code )
	{
		$user	=	$this->users->auth->get_user( $user_id );
		if( $user )
		{
			if( $this->users->auth->verify_user( $user_id , $ver_code) )
			{
				redirect( array( 'sign-in?notice=account-activated' ) );
			}
			redirect( array( 'sign-in?notice=error-occured' ) );
		} 		
		redirect( array( 'sign-in?notice=unknow-user' ) );
	}
	function do_reset_user( $user_id , $ver_code )
	{		
		$user	=	$this->users->auth->get_user( $user_id );
		if( $user )
		{
			if( $this->users->auth->reset_password( $user_id , $ver_code) )
			{
				redirect( array( 'sign-in?notice=new-password-created' ) );
			}
			redirect( array( 'sign-in?notice=error-occured' ) );
		} 		
		redirect( array( 'sign-in?notice=unknow-user' ) );
	}
	function register_user()
	{
		$exec	=	$this->users->create( 
			$this->input->post( 'email' ), 
			$this->input->post( 'password' ),
			$this->input->post( 'username' ),
			'subscriber'
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
		if( $this->users->auth->user_exsist_by_email( $this->input->post( 'user_email' ) ) )
		{
			$this->users->auth->remind_password( $this->input->post( 'user_email' ) );
			redirect( array( 'sign-in?notice=recovery-email-send' ) );
		}
		$this->notice->push_notice( $this->lang->line( 'unknow-user' ) );
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
		$this->events->add_filter( 'tendoo_login_notice' , function() use ( $exec ) {
			return $exec;
		});
	}
}
new aauth_action;