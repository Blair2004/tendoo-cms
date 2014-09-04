<?php
class pages_editor_tepas_class extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->module	=	$data;
		$this->load->library('tendoo_admin',null,'admin');
		if(function_exists('declare_shortcut') && get_instance()->users_global->isConnected()){
			if($this->admin->actionAccess('create_page', 'page_creater' ))
			{
				declare_shortcut('Créer une page',$this->url->site_url(array('admin','open','modules', 'page_creater' ,'create')));
			}
		}
	}
}
