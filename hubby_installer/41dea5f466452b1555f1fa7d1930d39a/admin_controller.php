<?php
class Hubby_index_mod_admin_controller
{
	private $moduleData;
	private $data;
	private $news;
	private $news_smart;
	private $core;
	private $hubby;
	private $hubby_admin;
	private $notice;
	private $installedModule;
	public function __construct($data)
	{
		$this->core						=	Controller::instance();
		$this->data						=	$data;
		$this->data['core']				=	$this->core;
		$this->moduleData				=	$this->data['module'][0];
		$this->index_lib				=	new index_mod_admin($this->data);
		$this->data['newsOptionNotice']	=	new Notice;
		$this->data['Sf_newsNotice']	=	new Notice; // Small Info notice;
		$this->data['onTopNewsNotice']	=	new Notice;
		$this->hubby					=	$this->core->hubby;
		$this->hubby_admin				=	$this->core->hubby_admin;
		$this->hubby_admin->menuExtendsBefore($this->index_lib->getMenu());
		$this->notice					=	$this->core->notice;
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','hubby_index_mod',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=access_denied'));
		}
		$this->data['inner_head']		=	$this->core->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->core->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	public function index()
	{
		if($this->index_lib->getAccess() === FALSE)
		{
			$this->core->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'],'accessError'));
		}
		if(between(1,20,$this->core->input->post('caroussel_art_limit')))
		{
			$onCar	=	$this->core->input->post('on_caroussel') == 'TRUE' ? 'TRUE' : 'FALSE';
			$limit	=	between(0,20,$this->core->input->post('caroussel_art_limit')) ? $this->core->input->post('caroussel_art_limit') : 10;
			$default_options	=	$this->index_lib->getNewsOpt();
			
			$default_options['CAROUSSEL']['LIMIT']	=	$limit;
			$default_options['CAROUSSEL']['SHOW']	=	$onCar;
			
			$this->index_lib->setNewsOpt($default_options);
			
			$this->data['newsOptionNotice']->push_notice(notice('done'));
		}
		if(between(1,20,$this->core->input->post('infodetails_art_limit')))
		{
			// Control on options
			$show	=	$this->core->input->post('news_on_infodetails') == 'TRUE' ? 'TRUE' : 'FALSE';
			$limit	=	between(0,20,$this->core->input->post('infodetails_art_limit')) ? $this->core->input->post('infodetails_art_limit') : 10;
			// Overwrite options
			$default_options	=	$this->index_lib->getNewsOpt();
			$default_options['INFOSMALLDETAILS']['LIMIT']	=	$limit;
			$default_options['INFOSMALLDETAILS']['SHOW']	=	$show;
			// Write news options
			$this->index_lib->setNewsOpt($default_options);
			// Engage success notice
			$this->data['Sf_newsNotice']->push_notice(notice('done'));
		}
		if(between(1,20,$this->core->input->post('news_showed_ontop_limit')))
		{
			// Control on options
			$show	=	$this->core->input->post('news_showed_ontop') == 'TRUE' ? 'TRUE' : 'FALSE';
			$limit	=	between(0,20,$this->core->input->post('news_showed_ontop_limit')) ? $this->core->input->post('news_showed_ontop_limit') : 10;
			// Overwrite options
			$default_options	=	$this->index_lib->getNewsOpt();
			$default_options['ONTOP']['LIMIT']	=	$limit;
			$default_options['ONTOP']['SHOW']	=	$show;
			// Write news options
			$this->index_lib->setNewsOpt($default_options);
			// Engage success notice
			$this->data['onTopNewsNotice']->push_notice(notice('done'));
		}
		if($this->core->input->post('toggle_carroussel') !== FALSE)
		{
			$this->index_lib->toggleElement('CAROUSSEL');
		}
		if($this->core->input->post('toggle_ontop') !== FALSE)
		{
			$this->index_lib->toggleElement('ONTOP');
		}
		if($this->core->input->post('toogle_infosmalldetails') !== FALSE)
		{
			$this->index_lib->toggleElement('INFOSMALLDETAILS');
		}
		$this->data['newsOptions']		=	$this->index_lib->getNewsOpt();
		$this->data['elementOptions']	=	$this->index_lib->getElementOpt();
		
		$this->hubby->setTitle('Editeur de vitrine - Gestion');
		$this->data['newsModule']		=	$this->index_lib->getNewsModule();

			
		$this->data['loadSection']	=	'main';
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main.php',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function accessError()
	{
		return $this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/access_error',$this->data,true,TRUE);
	}
}