<?php
class Hubby_contents_admin_controller
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
		$this->file_contentAdmin		=	new file_contentAdmin($this->data);
		$this->hubby					=	$this->core->hubby;
		$this->hubby_admin				=	$this->core->hubby_admin;
		$this->hubby_admin->menuExtendsBefore($this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/menu',$this->data,true,TRUE));
		$this->notice					=	$this->core->notice;
		$this->data['inner_head']		=	$this->core->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->core->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	public function index($page	=	1)
	{
		$this->hubby->setTitle('Gestionnaire de contenu');
			
		$this->data['loadSection']	=	'main';
		$this->data['ttFiles']		=	$this->file_contentAdmin->countUploadedFiles();
		$this->data['pagination']	=	$this->core->hubby->paginate(10,$this->data['ttFiles'],1,'on','off',$page,$this->core->url->site_url(array('blog','index')).'/',$ajaxis_link=null);
		$this->data['pagination'][3]=== false ? $this->core->url->redirect(array('error','code','page404')) : null;
		$this->data['files']		=	$this->file_contentAdmin->getUploadedFiles($this->data['pagination'][1],$this->data['pagination'][2]);
		
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function upload()
	{
		$this->core->load->library('form_validation');
		if(isset($_FILES['file']))
		{
			$this->core->form_validation->set_rules('file_human_name','Le nom du fichier','trim|required|min_length[5]|max_length[40]');
			$this->core->form_validation->set_rules('file_description','La description du fichier','trim|required|min_length[5]|max_length[200]');
			if($this->core->form_validation->run())
			{
				$query	=	$this->file_contentAdmin->uploadFile(
					'file',
					$this->core->input->post('file_human_name'),
					$this->core->input->post('file_description')
				);
				if($query)
				{
					$this->core->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
				}
			}
		}
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','hubby_contents_upload',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=access_denied'));
		}
		$this->hubby->setTitle('Gestionnaire de contenu - Envoyer un fichier');
		
		$this->data['loadSection']	=	'upload';
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/upload',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function manage($id)
	{
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','hubby_contents_upload',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=access_denied'));
		}
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('delete_file','','trim|required');
		$this->core->form_validation->set_rules('content_id','','trim|required|is_numeric');
		if($this->core->form_validation->run())
		{
			$query	=	$this->file_contentAdmin->fileDrop($this->core->input->post('content_id'));
			if($query)
			{
				$this->core->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
			}
			else
			{
				$this->core->notice->push_notice(notice('errorOccured'));
			}
		}
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('file_name','Le nom du fichier','trim|required|min_length[5]|max_length[40]');
		$this->core->form_validation->set_rules('file_description','La description du fichier','trim|required|min_length[5]|max_length[200]');
		$this->core->form_validation->set_rules('content_id','','trim|required|min_length[1]');
		$this->core->form_validation->set_rules('edit_file','','trim|required|min_length[1]');
		if($this->core->form_validation->run())
		{
			$query	=	$this->file_contentAdmin->editFile(
				$this->core->input->post('content_id'),
				$this->core->input->post('file_name'),
				$this->core->input->post('file_description')
			);
			if($query)
			{
				$this->core->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
			}
			else
			{
				$this->core->notiec->push_notice(notice('error_occured'));				
			}
		}
		$this->hubby->setTitle('Gestionnaire de contenu - Edition d\'un fichier');
		
		$this->data['getFile']		=	$this->file_contentAdmin->getUploadedFiles($id);
		if(count($this->data['getFile']) == 0)
		{
			$this->core->url->redirect(array('error','code','page404'));
		}
		$this->data['id']			=	$id;
		$this->data['loadSection']	=	'manage';
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage',$this->data,true,TRUE);
		return $this->data['body'];
	}
}
