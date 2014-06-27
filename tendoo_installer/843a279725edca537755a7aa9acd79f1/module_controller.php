<?php
class tendoo_contents_module_controller
{
	protected 	$data;
	private 	$news;
	private 	$core;
	private 	$tendoo;
	
	public function __construct($data)
	{
		$this->instance					=		get_instance();
		$this->data					=		$data;
		$this->tendoo				=&		$this->instance->tendoo;
		$this->data['users']		=&		$this->instance->users_global;		
		$this->load					=& 		$this->instance->load;
		$this->moduleData			=&		$this->data['module'][0];
	}
	public function index($page= 0)
	{
		echo 'This Module doesn\'t allow direct access / Ce module ne contient aucun espace utilisateur';
		return;
	}
}
