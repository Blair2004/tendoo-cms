<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign_out extends Tendoo_Controller {

	/**
	 * Login out page
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->events->add_action( 'log_user_out' , array( $this , 'log_user_out' ) );
		// doing log_user_out
		$this->events->do_action( 'log_user_out' );
	}
	function log_user_out()
	{
		if( $this->users->logout() == NULL )
		{
			if( ( $redir	=	riake( 'redirect' , $_GET ) ) != false )
			{
				// if redirect parameter is set
			}
			else
			{
				redirect( array( 'sign-in' ) );
			}
		}
		// not trying to handle false since this controller require login. 
		// While accessing this controller twice, a redirection will be made to login page from "tendoo_controller".
	}
	
}
