<?php
class tags_news_moreClass extends Libraries
{
	public function __construct()
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->cur_module			=	$this->tendoo_admin->getSpeMod('news',FALSE);
		$this->encrypted_dir		=& 	$this->cur_module[0]['ENCRYPTED_DIR'];
		$this->cur_module_dir		=	MODULES_DIR.$this->encrypted_dir;
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
		return $this->load->view($this->cur_module_dir.'/views/widgets/tags_more',$this->data,true,true);
	}
}
