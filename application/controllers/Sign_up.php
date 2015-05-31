<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign_up extends Tendoo_Controller {

	/**
	 * Registration Controller for Auth purpose
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/registration
	 *	- or -
	 * 		http://example.com/index.php/registration/index
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library( 'session' );
		$this->load->library( 'flexi_auth' );
		$this->load->library( 'form_validation' );
		
		$this->enqueue->enqueue_css( 'bootstrap.min' );
		$this->enqueue->enqueue_css( 'AdminLTE.min' );
		$this->enqueue->enqueue_css( 'skins/_all-skins.min' );
		
		/**
		 * 	Enqueueing Js
		**/
		
		$this->enqueue->enqueue_js( 'plugins/jQuery/jQuery-2.1.4.min' );
		$this->enqueue->enqueue_js( 'bootstrap.min' );
		$this->enqueue->enqueue_js( 'plugins/iCheck/icheck.min' );		
		$this->enqueue->enqueue_js( 'app.min' );
	}
	public function index() // fix later
	{	
		$this->load->model( 'users_model' , 'user' );
		$this->form_validation->set_rules( 'username' , __( 'User Name' ) , 'required' );
		$this->form_validation->set_rules( 'email' , __( 'Email' ) , 'valid_email|required' );
		$this->form_validation->set_rules( 'password' , __( 'Password' ) , 'required|min_length[6]' );
		$this->form_validation->set_rules( 'confirm' , __( 'Confirm' ) , 'matches[password]' );
		if( $this->form_validation->run() )
		{
			$exec	=	$this->user->create( 
				$this->input->post( 'email' ), 
				$this->input->post( 'username' ), 
				$this->input->post( 'password' )
			);
			if( $exec == 'user-created' )
			{
				redirect( array( 'sign-in?notice=' . $exec ) );
			}
			$this->notice->push_notice( $this->lang->line( $exec ) );
		}
		// $this->load->model( 'tendoo_setup' );
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-up/body' );
	}
}
