<?php
Class logoff
{
	private $core;
	private $user_global;
	private $load;
	public function __construct()
	{
		$this->core			=	Controller::instance();
		$this->core->load->library('session');
		$this->core->load->library('users_global');
		$this->users_global	=&	$this->core->users_global;
		$this->load			=&	$this->core->load;
		// Has admin ?
		($this->users_global->hasAdmin()=== FALSE) ? $this->core->url->redirect(array('resgistration','superAdmin')) : false;
	}
	// Privates Methods
	public function index()
	{
		$this->core->users_global->closeUserSession();
		$this->core->url->redirect(array('index'));
	}
}