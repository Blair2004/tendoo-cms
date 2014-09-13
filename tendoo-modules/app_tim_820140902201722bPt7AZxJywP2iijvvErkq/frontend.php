<?php
class tim_frontend extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->data			=	$data;
		$this->data[ 'page'	]	=	get_core_vars( 'page' );
		$this->data[ 'module']	=	get_core_vars( 'module' );
		$this->data['current_page']		=	get_core_vars( 'page' );
		// Setting Bread
		$this->data['current_page']		=	get_core_vars( 'page' );
		set_bread( array (
			'link'	=>	get_instance()->url->site_url(array($this->data['current_page'][0]['PAGE_CNAME'])),
			'text'	=>	$this->data['current_page'][0]['PAGE_CNAME']
		) );
		// End
	}
	public function index()
	{
		// Bread
		
		//
		set_page('title',$this->data['page'][0]['PAGE_TITLE']);
		set_page('description',$this->data['page'][0]['PAGE_DESCRIPTION']);
		get_core_vars('active_theme_object')->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		get_core_vars('active_theme_object')->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		set_core_vars( 'module_content' , $this->load->view($this->data[ 'module' ]['uri_path'].'/views/common_main',$this->data,true,TRUE) );
		
		get_core_vars('active_theme_object')->head($this->data);
		get_core_vars('active_theme_object')->body($this->data);
	}
}
?>