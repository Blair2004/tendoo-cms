<?php
Class logoff
{
	private $instance;
	private $user_global;
	private $load;
	public function __construct()
	{
		$this->instance			=	get_instance();
		$this->instance->load->library('session');
		$this->instance->load->library('users_global');
		$this->users_global	=&	$this->instance->users_global;
		$this->load			=&	$this->instance->load;
		// Has admin ?
		($this->users_global->hasAdmin()=== FALSE) ? $this->instance->url->redirect(array('resgistration','superAdmin')) : false;
	}
	// Privates Methods
	public function index()
	{
		$this->instance->users_global->closeUserSession();
		if( isset( $_GET[ 'ref' ] ) )
		{
			$this->instance->url->redirect( array( 'login?ref=' . $_GET[ 'ref' ] ) );
		}
		else
		{
			$this->instance->url->redirect(array('index'));
		}
	}
}