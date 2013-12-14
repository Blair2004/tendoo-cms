<?php
class Pages_editor_admin_controller
{
	private $moduleData;
	private $data;
	private $news;
	private $news_smart;
	private $ci;
	private $hubby;
	private $hubby_admin;
	private $notice;
	public function __construct($data)
	{
		$this->ci						=	Controller::instance();
		$this->data						=	$data;
		$this->moduleData				=	$this->data['module'][0];
		$this->page_handler				=	new Pages_admin($this->data);
		$this->hubby					=	$this->ci->hubby;
		$this->hubby_admin				=	$this->ci->hubby_admin;
		$this->hubby_admin->menuExtendsBefore($this->page_handler->getMenu());
		$this->notice					=	$this->ci->notice;
		$this->data['lmenu']			=	$this->ci->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	public function index()
	{
		$this->hubby->setTitle('Page Editor - Page d\'administration');
			
		$this->data['loadSection']	=	'main';
		$this->data['getPages']		=	$this->page_handler->getPages(0,50);
		$this->data['body']			=	$this->ci->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/admin_view',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function create()
	{
		if(!$this->ci->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','create_page',$this->ci->users_global->current('PRIVILEGE')))
		{
			$this->ci->url->redirect(array('admin','index?notice=access_denied'));
		}
		$this->hubby->setTitle('Page Editor - Créer une nouvelle page');
		$this->ci->load->library('form_validation');
		$this->ci->form_validation->set_rules('page_description','Description de la page','trim|required|min_lenght[5]|max_length[200]');
		$this->ci->form_validation->set_rules('page_title','Titre de la page','trim|required|min_lenght[5]|max_length[1000]');
		$this->ci->form_validation->set_rules('page_content','Contenu de la page','trim|required|min_lenght[5]|max_length[100000]');		
		if($this->ci->form_validation->run())
		{
			$this->data['result']	=	$this->page_handler->create(
				$this->ci->input->post('page_title'),
				$this->ci->input->post('page_description'),
				$this->ci->input->post('page_content')
			);
			if($this->data['result'])
			{
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('error'));
			}
		}
		$this->hubby->loadEditor(3);
		$this->data['loadSection']	=	'create';
		$this->data['body']			=	$this->ci->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/admin_view',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function edit($e)
	{
		if(!$this->ci->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','edit_pages',$this->ci->users_global->current('PRIVILEGE')))
		{
			$this->ci->url->redirect(array('admin','index?notice=access_denied'));
		}
		// Control Sended Form Datas
		$this->ci->load->library('form_validation');
		$this->ci->form_validation->set_rules('page_description','Description de la page','trim|required|min_lenght[5]|max_length[200]');
		$this->ci->form_validation->set_rules('page_title','Titre de la page','trim|required|min_lenght[5]|max_length[1000]');
		$this->ci->form_validation->set_rules('page_content','Contenu de la page','trim|required|min_lenght[5]|max_length[100000]');		
		$this->ci->form_validation->set_rules('page_id','Identifiant de la page','required|min_lenght[1]');	
		if($this->ci->form_validation->run())
		{
			echo $this->ci->input->post('page_description');
			$this->data['result']	=	$this->page_handler->edit(
				$this->ci->input->post('page_id'),
				$this->ci->input->post('page_title'),
				$this->ci->input->post('page_description'),
				$this->ci->input->post('page_content')
			);
			if($this->data['result'])
			{
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('error'));
			}
		}
		// Retreiving News Data
		$this->data['pageInfo']		=	$this->page_handler->getSpePage($e);
		$this->hubby->setTitle('Page Editor - Modifier une page');
		$this->hubby->loadEditor(3);		
		$this->data['loadSection']	=	'edit';
		$this->data['body']			=	$this->ci->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/admin_view',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function delete($e)
	{
		if(!$this->ci->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','delete_page',$this->ci->users_global->current('PRIVILEGE')))
		{
			$this->ci->url->redirect(array('admin','index?notice=access_denied'));
		}
		$code	=	$this->page_handler->deletePage($e);
		if($code)
		{
			redirect(array('admin','open','modules',$this->moduleData['ID'].'?notice=done'));
			return true;
		}
		redirect(array('admin','open','modules',$this->moduleData['ID'].'?notice=error_occured'));
		return false;
	}
}
