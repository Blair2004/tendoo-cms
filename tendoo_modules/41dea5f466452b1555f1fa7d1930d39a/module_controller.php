<?php
class Tendoo_index_manager_module_controller
{
	public function __construct($data)
	{
		__extends($this);
		$this->data		=&		$data;
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
		$this->lib					=	new Tendoo_index_manager_library;
		$this->data['lib_options']	=	$this->lib->getOptions();
	}
	public function index()
	{
		$this->tendoo->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->tendoo->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		// Load View		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common',$this->data,true,TRUE);
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
}