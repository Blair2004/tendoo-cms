<?php
class aauth_rules extends CI_model
{
	function __construct()
	{
		$this->events->add_action( 'set_login_rules' , array( $this , 'set_login_rules' ) );
		$this->events->add_action( 'registration_rules' , array( $this , 'registration_rules' ) );
	}
	function set_login_rules()
	{
		$this->form_validation->set_rules( 'username_or_email' , __( 'Email or User Name' ) , 'required|min_length[5]' );
		$this->form_validation->set_rules( 'password' , __( 'Email or User Name' ) , 'required|min_length[6]' );
	}
	function registration_rules()
	{
		$this->form_validation->set_rules( 'username' , __( 'User Name' ) , 'required' );
		$this->form_validation->set_rules( 'email' , __( 'Email' ) , 'valid_email|required' );
		$this->form_validation->set_rules( 'password' , __( 'Password' ) , 'required|min_length[6]' );
		$this->form_validation->set_rules( 'confirm' , __( 'Confirm' ) , 'matches[password]' );
	}

}
new aauth_rules;