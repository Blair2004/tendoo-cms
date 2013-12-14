<?php
class Pages_editor_module_controller
{
	protected 	$data;
	private 	$news;
	private 	$core;
	private 	$hubby;
	
	public function __construct($data)
	{
		$this->core					=		Controller::instance();
		$this->data					=		$data;
		$this->hubby				=&		$this->core->hubby;
		$this->data['users']		=&		$this->core->users_global;		
		$this->load					=& 		$this->core->load;
		$this->moduleData			=&		$this->data['module'][0];
	}
	public function index($page= 0)
	{
		if($page == 0)
		{
		}
		else
		{
			// We Do load htmlPages;
			$id											=	$page;
			$this->data['page_handler']					=	new Pages_smart($this->data);
			$this->data['retreive']						=	$this->data['page_handler']->getPage($id);
			$this->data['page'][0]['PAGE_TITLE']		=	$this->data['retreive'][0]['TITLE'];
			$this->data['page'][0]['PAGE_DESCRIPTION']	=	$this->data['retreive'][0]['DESCRIPTION'];
			$this->data['loadOnPageModule']				=	FALSE; // On empêche au module de se charger
			$this->hubby->setTitle($this->data['page'][0]['PAGE_TITLE']);
			$this->hubby->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
			// Load View		
			$this->data['section']						=		'loadPage';
			$this->data['module_content']				=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/module_view',$this->data,true,true);
			
			$this->data['theme']->header($this->data);
			$this->data['theme']->body($this->data);
		}
	}
}
