<?php
class Pages_editor_module_controller extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data							=		$data;
		$this->moduleData					=&		$this->data['module'][0];
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library_2.php');
		$this->data['ftp_libSmart']			=		new tendoo_refToPage_smart($this->data);
		$this->data['userUtil']				=&		$this->instance->users_global;		
	}
	public function index($page= 0)
	{
		$controller							=		$page == 0 ? $this->url->controller() : $page;
		set_page('title',$this->data['page'][0]['PAGE_TITLE']);
		set_page('description',$this->data['page'][0]['PAGE_DESCRIPTION']);
		// Load View		
		$this->data['fileContent']			=		$this->data['ftp_libSmart']->getContent($controller);
		$this->data['section']				=		'main';
		$this->data['module_content']		=		$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_view',$this->data,true,TRUE);
		
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
}
