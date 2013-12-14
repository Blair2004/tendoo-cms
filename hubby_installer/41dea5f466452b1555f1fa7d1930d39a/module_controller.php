<?php
class hubby_index_manager_module_controller
{
	public function __construct($data)
	{
		__extends($this);
		$this->data		=&		$data;
		include_once(__DIR__.'/library.php');
		$this->lib					=	new hubby_index_manager_library;
		$this->data['lib_options']	=	$this->lib->getOptions();
	}
	public function index()
	{
		$this->hubby->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->hubby->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		// Load View		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common',$this->data,true,TRUE);
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
}