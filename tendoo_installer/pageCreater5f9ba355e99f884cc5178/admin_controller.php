<?php
class Pages_editor_admin_controller extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data						=	$data;
		$this->moduleData				=	$this->data['module'][0];
		$this->page_handler				=	new Pages_admin($this->data);
		
		$this->moduleData				=	$this->data['module'][0];
		$this->moduleNamespace			=&	$this->data['module'][0]['NAMESPACE'];
		include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library_2.php');
		$this->rtp_lib					=	new refToPage_lib($this->data);
		$this->data['rtp_lib']			=&	$this->rtp_lib;
		$this->dir						=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
		$this->tendoo_admin->menuExtendsBefore($this->load->view($this->dir.'/views/menu',$this->data,TRUE,TRUE));
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
	}
	public function index($page = 1)
	{
		set_page('title','Page Editor - Page d\'administration');
		
		$this->data['countPages']		=	count($this->page_handler->getPages());
		$this->data['paginate']			=	$this->tendoo->paginate(10,$this->data['countPages'],1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
			
		$this->data['getPages']			=	$this->page_handler->getPages($this->data['paginate'][1],$this->data['paginate'][2]);
		$this->data['body']				=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function create()
	{
		if($this->tendoo_admin->actionAccess('create_page','pages_editor') === FALSE)
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		set_page('title','Page Editor - Créer une nouvelle page');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('page_description','Description de la page','trim|required|min_lenght[5]|max_length[200]');
		$this->form_validation->set_rules('page_title','Titre de la page','trim|required|min_lenght[5]|max_length[1000]');
		$this->form_validation->set_rules('page_content','Contenu de la page','trim|required|min_lenght[5]|max_length[100000]');		
		if($this->form_validation->run())
		{
			$this->data['result']	=	$this->page_handler->create(
				$this->input->post('page_title'),
				$this->input->post('page_description'),
				$this->input->post('page_content')
			);
			if($this->data['result'])
			{
				notice('push',fetch_error('done'));
			}
			else
			{
				notice('push',fetch_error('error'));
			}
		}
		$this->visual_editor->loadEditor(1);
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/create',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function edit($e)
	{
		if($this->tendoo_admin->actionAccess('edit_pages','pages_editor') === FALSE)
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		// Control Sended Form Datas
		$this->load->library('form_validation');
		$this->form_validation->set_rules('page_description','Description de la page','trim|required|min_lenght[5]|max_length[200]');
		$this->form_validation->set_rules('page_title','Titre de la page','trim|required|min_lenght[5]|max_length[1000]');
		$this->form_validation->set_rules('page_content','Contenu de la page','trim|required|min_lenght[5]|max_length[100000]');		
		$this->form_validation->set_rules('page_id','Identifiant de la page','required|min_lenght[1]');	
		if($this->form_validation->run())
		{
			$this->data['result']	=	$this->page_handler->edit(
				$this->input->post('page_id'),
				$this->input->post('page_title'),
				$this->input->post('page_description'),
				$this->input->post('page_content')
			);
			if($this->data['result'])
			{
				notice('push',fetch_error('done'));
			}
			else
			{
				notice('push',fetch_error('error'));
			}
		}
		// Retreiving News Data
		$this->data['pageInfo']		=	$this->page_handler->getSpePage($e);
		set_page('title','Page Editor - Modifier une page');
		$this->visual_editor->loadEditor(1);		
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/edit',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function delete($e)
	{
		if($this->tendoo_admin->actionAccess('delete_page','pages_editor') === FALSE)
		{
			$this->url->redirect(array('admin','index?notice=access_denied'));
		}
		$code	=	$this->page_handler->deletePage($e);
		if($code)
		{
			$this->url->redirect(array('admin','open','modules',$this->moduleData['ID'].'?notice=done'));
			return true;
		}
		$this->url->redirect(array('admin','open','modules',$this->moduleData['ID'].'?notice=error_occured'));
		return false;
	}
	public function page_linker()
	{
		set_page('title','Attributeur de contenu - Page d\'administration');
				
		$this->data['supportedPages']	=	array();
		$pages			=	$this->tendoo_admin->get_pages(null,TRUE);	
		foreach($pages as $p)
		{
			
			if($p['PAGE_MODULES'] 	==	$this->moduleNamespace)
			{
				$this->data['supportedPages'][]	=	$p;
			}
		}
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/page_linker_main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function page_edit($page)
	{
		set_page('title','Attributeur de contenu - Page d\'administration');
		
		$this->data['control']		=	$this->tendoo_admin->get_pages($page);
		if($this->data['control'] == false)
		{
			$this->url->redirect(array('error','code','page404'));
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('content_id','Contenu','trim|required|min_length[1]');
		$this->form_validation->set_rules('page_id','Identifiant du contr&ocirc;leur','trim|required|min_length[1]');
		if($this->form_validation->run())
		{
			$query	=	$this->rtp_lib->attach($this->input->post('page_id'),$this->input->post('content_id'));
			if($query)
			{
				notice('push',fetch_error('done'));
			}
			else
			{
				notice('push',fetch_error('error_occured'));
			}
		}
		$this->data['attachement']	=	$this->rtp_lib->isAttached($this->data['control'][0]['ID']);
		$this->data['pageList']		=	$this->rtp_lib->getContentList();
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/page_linker_edit',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
}
