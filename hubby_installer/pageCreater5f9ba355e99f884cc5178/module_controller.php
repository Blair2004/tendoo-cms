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
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library_2.php');
		$this->data['ftp_libSmart']	=		new hubby_refToPage_smart($this->data);
		$this->data['userUtil']		=&		$this->core->users_global;		
	}
	public function index($page= 0)
	{
			$this->hubby->setTitle($this->data['page'][0]['PAGE_TITLE']);
			$this->hubby->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
			// Load View		
			$this->data['fileContent']	=		$this->data['ftp_libSmart']->getContent($this->core->url->controller());
			$this->data['section']		=		'main';
			$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_view',$this->data,true,TRUE);
			
			$this->data['theme']->header($this->data);
			$this->data['theme']->body($this->data);
		if(true == false)
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
