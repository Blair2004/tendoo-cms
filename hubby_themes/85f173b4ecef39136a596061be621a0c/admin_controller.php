<?php
class hubby_modus_theme_admin_controller
{
	public function __construct($data)
	{
		$this->data				=&	$data;
		$this->core				=	Controller::instance();
		$this->load				=&	$this->core->load;
		$this->hubby			=&	$this->core->hubby;
		$this->hubby_admin		=&	$this->core->hubby_admin;
		$this->data['Spetheme']	=&	$this->data['Spetheme'][0];
		$this->location			=&	$this->data['Spetheme']['ENCRYPTED_DIR'];
		$this->loadAccess		=	$this->data['loadAccess']	=	THEMES_DIR.$this->location.'/';
		
		$this->data['Omenu']	=	$this->load->view($this->loadAccess.'views/left_menu',$this->data,true,true);
		$this->hubby_admin->menuExtendsBefore($this->data['Omenu']);
		
		$this->data['sHead']	=	$this->load->view(VIEWS_DIR.'/admin/inner_head',$this->data,true,TRUE);
		$this->data['lmenu']	=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		
	}
	public function index()
	{
		$this->data['pageTitle']		=	'Modus Gestion du th&egrave;me';
		$this->data['pageDescription']	=	'Gesionnaire du th&egrave;me modus';
		
		$this->hubby->setTitle($this->data['pageTitle']);
		$this->hubby->setDescription($this->data['pageDescription']);
		
		$this->data['body']	=	$this->load->view($this->loadAccess.'views/body',$this->data,true,true);
		return $this->data['body'];
	}
	public function about()
	{
		$this->data['pageTitle']		=	'A propos d\'hubby modus';
		$this->data['pageDescription']	=	'Gesionnaire du th&egrave;me modus';
		
		$this->hubby->setTitle($this->data['pageTitle']);
		$this->hubby->setDescription($this->data['pageDescription']);
		
		$this->data['body']	=	$this->load->view($this->loadAccess.'views/about',$this->data,true,true);
		return $this->data['body'];
	}
}