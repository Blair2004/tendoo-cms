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
		
		$this->html->set_title( sprintf( __( 'Sign In &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-in/body' );
	}
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
		$this->html->set_title( sprintf( __( 'Recover Password &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-in/recovery' );
	}
}
