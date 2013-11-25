<?php
class hubby_modus_theme_admin_controller
{
	public function __construct($data)
	{
		$this->data				=&	$data;
		$this->core				=	Controller::instance();
		$this->modus_lib		=	new modus_lib;
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
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('facebook','du lien vers le compte facebook','trim|min_length[0]');
		$this->core->form_validation->set_rules('twitter','du lien vers le compte twitter','trim|min_length[0]');
		$this->core->form_validation->set_rules('googleplus','du lien vers le compte google+','trim|min_length[0]');
		if($this->core->form_validation->run())
		{
			if($this->modus_lib->updateNetworking(
				$this->core->input->post('facebook'),
				$this->core->input->post('twitter'),
				$this->core->input->post('googleplus')
			))
			{
				$this->core->notice->push_notice(notice('done'));
			}
			else
			{
				$this->core->notice->push_notice(notice('error_occured'));
			}
		}
		$this->data['networking']		=	$this->modus_lib->getNetworking();
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