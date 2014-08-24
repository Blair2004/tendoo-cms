<?php
class tendoo_index_manager_module_controller extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data		=&		$data;
		$this->data['module']		=	get_core_vars( 'module' );
		$this->data['page']			=	get_core_vars( 'page' );
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
		$this->lib					=	new tendoo_index_manager_library;
		$this->data['lib_options']	=	$this->lib->getOptions();
	}
	public function index()
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_page('title',$this->data['page'][0]['PAGE_TITLE']);
		set_page('description',$this->data['page'][0]['PAGE_DESCRIPTION']);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		get_core_vars('active_theme_object')->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		get_core_vars('active_theme_object')->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		// Load View		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common',$this->data,true,TRUE);
		get_core_vars('active_theme_object')->head($this->data);
		get_core_vars('active_theme_object')->body($this->data);
	}
}