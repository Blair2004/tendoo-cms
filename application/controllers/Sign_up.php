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
		$this->events->do_action( 'registration_rules' );	
		
		if( $this->form_validation->run() )
		{
			$this->events->do_action( 'do_register_user' );
		}
		
		$this->load->view( 'shared/header' );
		$this->load->view( 'sign-up/body' );
	}
}
