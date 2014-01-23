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
		$this->core						=	Controller::instance();
		$this->data						=	$data;
		$this->moduleData				=	$this->data['module'][0];
		$this->page_handler				=	new Pages_admin($this->data);
		$this->hubby					=	$this->core->hubby;
		$this->hubby_admin				=	$this->core->hubby_admin;
		
		$this->moduleData				=	$this->data['module'][0];
		$this->moduleNamespace			=&	$this->data['module'][0]['NAMESPACE'];
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library_2.php');
		$this->rtp_lib					=	new refToPage_lib($this->data);
		$this->data['rtp_lib']			=&	$this->rtp_lib;
		$this->dir						=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
		$this->hubby_admin->menuExtendsBefore($this->core->load->view($this->dir.'/views/menu',$this->data,TRUE,TRUE));
		$this->notice					=	$this->core->notice;
		$this->data['lmenu']			=	$this->core->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		$this->data['inner_head']		=	$this->core->load->view('admin/inner_head',$this->data,true);
	}
	public function index($page = 1)
	{
		$this->hubby->setTitle('Page Editor - Page d\'administration');
		
		$this->data['countPages']		=	count($this->page_handler->getPages());
		$this->data['paginate']			=	$this->core->hubby->paginate(10,$this->data['countPages'],1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->core->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->core->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
			
		$this->data['getPages']			=	$this->page_handler->getPages($this->data['paginate'][1],$this->data['paginate'][2]);
		$this->data['body']				=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function create()
	{
		if($this->hubby_admin->actionAccess('create_page','pages_editor') === FALSE)
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->hubby->setTitle('Page Editor - Créer une nouvelle page');
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('page_description','Description de la page','trim|required|min_lenght[5]|max_length[200]');
		$this->core->form_validation->set_rules('page_title','Titre de la page','trim|required|min_lenght[5]|max_length[1000]');
		$this->core->form_validation->set_rules('page_content','Contenu de la page','trim|required|min_lenght[5]|max_length[100000]');		
		if($this->core->form_validation->run())
		{
			$this->data['result']	=	$this->page_handler->create(
				$this->core->input->post('page_title'),
				$this->core->input->post('page_description'),
				$this->core->input->post('page_content')
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
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/create',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function edit($e)
	{
		if($this->hubby_admin->actionAccess('edit_pages','pages_editor') === FALSE)
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
		}
		// Control Sended Form Datas
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('page_description','Description de la page','trim|required|min_lenght[5]|max_length[200]');
		$this->core->form_validation->set_rules('page_title','Titre de la page','trim|required|min_lenght[5]|max_length[1000]');
		$this->core->form_validation->set_rules('page_content','Contenu de la page','trim|required|min_lenght[5]|max_length[100000]');		
		$this->core->form_validation->set_rules('page_id','Identifiant de la page','required|min_lenght[1]');	
		if($this->core->form_validation->run())
		{
			echo $this->core->input->post('page_description');
			$this->data['result']	=	$this->page_handler->edit(
				$this->core->input->post('page_id'),
				$this->core->input->post('page_title'),
				$this->core->input->post('page_description'),
				$this->core->input->post('page_content')
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
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/edit',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function delete($e)
	{
		if($this->hubby_admin->actionAccess('delete_page','pages_editor') === FALSE)
		{
			$this->core->url->redirect(array('admin','index?notice=access_denied'));
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
	public function page_linker()
	{
		$this->hubby->setTitle('Attributeur de contenu - Page d\'administration');
				
		$this->data['supportedPages']	=	array();
		$pages			=	$this->hubby_admin->get_pages(null,TRUE);	
		foreach($pages as $p)
		{
			
			if($p['PAGE_MODULES'] 	==	$this->moduleNamespace)
			{
				$this->data['supportedPages'][]	=	$p;
			}
		}
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/page_linker_main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function page_edit($page)
	{
		$this->hubby->setTitle('Attributeur de contenu - Page d\'administration');
		
		$this->data['control']		=	$this->core->hubby_admin->get_pages($page);
		if($this->data['control'] == false)
		{
			$this->core->url->redirect(array('error','code','page404'));
		}
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('content_id','Contenu','trim|required|min_length[1]');
		$this->core->form_validation->set_rules('page_id','Identifiant du contr&ocirc;leur','trim|required|min_length[1]');
		if($this->core->form_validation->run())
		{
			$query	=	$this->rtp_lib->attach($this->core->input->post('page_id'),$this->core->input->post('content_id'));
			if($query)
			{
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('error_occured'));
			}
		}
		$this->data['attachement']	=	$this->rtp_lib->isAttached($this->data['control'][0]['ID']);
		$this->data['pageList']		=	$this->rtp_lib->getContentList();
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/page_linker_edit',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
}
