<?php
class aflearlep_blogster_moreClass extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		__extends($this);
		$this->cur_module			=	get_modules( 'filter_active_namespace' , 'blogster' );
		$this->encrypted_dir		=& 	$this->cur_module['encrypted_dir'];
		$this->cur_module_dir		=	$this->cur_module['uri_path'];
		$this->data					=	array();
		$this->data['cur_module']	=&	$this->cur_module;
	}
	public function get($parameters = array(),$zone = '',$index = '')
	{
		/*
			Set Parameters available for widget config.
		*/
		$this->data['zone']			=	$zone;
		$this->data['index']		=	$index;
		$this->data['parameters']	=	$parameters;
		return $this->load->view($this->cur_module_dir.'/views/widgets/aflearlep_more',$this->data,true,true);
	}
}
