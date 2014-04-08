<?php
class tendoo_contents_module_controller
{
	protected 	$data;
	private 	$news;
	private 	$core;
	private 	$tendoo;
	
	public function __construct($data)
	{
		$this->core					=		Controller::instance();
		$this->data					=		$data;
		$this->tendoo				=&		$this->core->tendoo;
		$this->data['users']		=&		$this->core->users_global;		
		$this->load					=& 		$this->core->load;
		$this->moduleData			=&		$this->data['module'][0];
	}
	public function index($page= 0)
	{
		echo 'This Module doesn\'t allow direct access / Ce module ne contient aucun espace utilisateur';
		return;
	}
}
