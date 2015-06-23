<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign_in extends Tendoo_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/sing-in
	 *	- or -
	 * 		http://example.com/index.php/welcome/sing-in
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library( 'form_validation' );
		$this->load->model( 'login_model' );
		$this->load->model( 'users_model' , 'user' );
	}
	
	/**
	 * Sign In index page
	 *
	 *	Displays login page
	 * 	@return : void
	**/
	
	public function index()
	{
		$this->events->do_action( 'set_login_rules' );
		if( $this->form_validation->run() )
		{
			// Apply filter before login
			$fields_namespace	=	$this->login_model->get_fields_namespace();
			
			// Log User After Applying Filters
			$exec 	=	$this->users->login( $fields_namespace );
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
		// load login fields
		$this->config->set_item( 'signin_fields' , $this->events->apply_filters( 'signin_fields' , $this->config->item( 'signin_fields' ) ) );
		
		Html::set_title( sprintf( __( 'Sign In &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-in/body' );
	}
	
	/**
	 * 	Recovery Method
	 *	
	 *	Allow user to get reset email for his account
	 *
	 *	@return void
	**/
	
	function recovery()
	{
		$this->form_validation->set_rules( 'user_email' , __( 'User Email' ) , 'required|valid_email' );
		if( $this->form_validation->run() )
		{
			/**
			 * Actions to be run before sending recovery email
			 * It can allow use to edit email
			**/
			$this->events->do_action( 'send_recovery_email' );
			
			// Send Recovery
			$exec 	=	$this->user->send_recovery_email( $this->input->post( 'user_email' ) );
			
			if( $exec === 'recovery-email-send' )
			{
				redirect( array( 'sign-in?notice=' . $exec ) );
			}
			$this->notice->push_notice( $this->lang->line( $exec ) );
		}
		Html::set_title( sprintf( __( 'Recover Password &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-in/recovery' );
	}
	
	/**
	 * 	Reset
	 * 	
	 *	Checks a verification code an send a new password to user email
	 *
	 * 	@access : public
	 *	@params : int user_id
	 * 	@params : string verfication code
	 * 	@return : void
	 * 
	**/
	
	function reset( $user_id , $ver_code )
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
	
	/**
	 * Verify
	 * 
	 * 	Verify actvaton code for specifc user
	 *
	 *	@access : public
	 *	@params : int user_id
	 *	@params : string verification code
	 *	@status	: untested
	**/
	
	function verify( $user_id , $ver_code )
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
}
