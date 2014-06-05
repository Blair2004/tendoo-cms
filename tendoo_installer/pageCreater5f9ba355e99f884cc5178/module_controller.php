<?php
class Pages_editor_module_controller
{
	protected 	$data;
	private 	$news;
	private 	$core;
	private 	$tendoo;
	
	public function __construct($data)
	{
		$this->core							=			Controller::instance();
		$this->data							=			$data;
		$this->tendoo						=&			$this->core->tendoo;
		$this->data['users']				=&			$this->core->users_global;		
		$this->load							=& 		$this->core->load;
		$this->moduleData					=&			$this->data['module'][0];
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library_2.php');
		$this->data['ftp_libSmart']	=			new tendoo_refToPage_smart($this->data);
		$this->data['userUtil']			=&			$this->core->users_global;		
	}
	public function index($page= 0)
	{
		$controller								=	$page == 0 ? $this->core->url->controller() : $page;
		$this->tendoo->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->tendoo->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		// Load View		
		$this->data['fileContent']			=		$this->data['ftp_libSmart']->getContent($controller);
		$this->data['section']				=		'main';
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_view',$this->data,true,TRUE);
		
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
	public function show($page_id = 0)
	{
		$controller								=	$page_id == 0 ? $this->core->url->controller() : $page_id;

		// Load View		
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
		$pageLib	=	new Pages_smart($this->data);
		$this->data['fileContent']			=	 	$pageLib->getPage($page_id);
		$this->tendoo->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->tendoo->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		
		$this->data['section']				=		'main';
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_view',$this->data,true,TRUE);
		
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
	
}
