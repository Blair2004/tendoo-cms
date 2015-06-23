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
		$this->load->library( 'form_validation' );
		
		Enqueue::enqueue_css( 'bootstrap.min' );
		Enqueue::enqueue_css( 'AdminLTE.min' );
		Enqueue::enqueue_css( 'skins/_all-skins.min' );
		
		/**
		 * 	Enqueueing Js
		**/
		
		Enqueue::enqueue_js( 'plugins/jQuery/jQuery-2.1.4.min' );
		Enqueue::enqueue_js( 'bootstrap.min' );
		Enqueue::enqueue_js( 'plugins/iCheck/icheck.min' );		
		Enqueue::enqueue_js( 'app.min' );
	}
	public function index()
	{	
		$this->form_validation->set_rules( 'username' , __( 'User Name' ) , 'required' );
		$this->form_validation->set_rules( 'email' , __( 'Email' ) , 'valid_email|required' );
		$this->form_validation->set_rules( 'password' , __( 'Password' ) , 'required|min_length[6]' );
		$this->form_validation->set_rules( 'confirm' , __( 'Confirm' ) , 'matches[password]' );
		
		if( $this->form_validation->run() )
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
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-up/body' );
	}
}
