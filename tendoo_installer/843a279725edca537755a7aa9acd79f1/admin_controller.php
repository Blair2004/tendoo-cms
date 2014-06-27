<?php
class tendoo_contents_admin_controller extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data						=	$data;
		$this->moduleData				=	$this->data['module'][0];
		$this->lib						=	$this->data['lib']				=	// no is not an error;
		$this->file_contentAdmin		=	new file_contentAdmin($this->data);
		$this->tendoo_admin->menuExtendsBefore($this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/menu',$this->data,true,TRUE));
		$this->notice					=	$this->instance->notice;
		$this->data['module_dir']		=	MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'];
		$this->data['repository_dir']	=	MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/content_repository';
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	public function index($page	=	1)
	{
		set_page('title','Gestionnaire de contenu');
			
		$this->data['loadSection']	=	'main';
		$this->data['ttFiles']		=	$this->file_contentAdmin->countUploadedFiles();
		$this->data['paginate']	=	$this->instance->tendoo->paginate(10,$this->data['ttFiles'],1,'on','off',$page,$this->instance->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'index')).'/',$ajaxis_link=null);
		$this->data['paginate'][3]=== false ? $this->instance->url->redirect(array('error','code','page404')) : null;
		$this->data['files']		=	$this->file_contentAdmin->getUploadedFiles($this->data['paginate'][1],$this->data['paginate'][2]);
		
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function ajax($x = '',$y = 1,$z = '')
	{
		if($x == 'selection')
		{
			$this->data['ttFiles']		=	$this->file_contentAdmin->countUploadedFiles();
			$this->data['paginate']		=	$this->instance->tendoo->paginate(12,$this->data['ttFiles'],1,'on','off',$y,$this->instance->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'ajax','selection')).'/',$ajaxis_link=null);
			$this->data['files']		=	$this->file_contentAdmin->getUploadedFiles($this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_load_files',$this->data,true,TRUE);
			return array(
				'MCO'		=>		TRUE,
				'RETURNED'	=>		$this->data['body']
			);
		}
		else if($x == 'upload')
		{
			if(isset($_FILES['file']))
			{
				$this->file_contentAdmin->uploadFile('file',$_FILES['file']['name'],$_FILES['file']['name']);
			}
		}
	}
	public function upload()
	{
		$this->load->library('form_validation');
		if(isset($_FILES['file']))
		{
			$this->instance->form_validation->set_rules('file_human_name','Le nom du fichier','trim|required|min_length[5]|max_length[40]');
			$this->instance->form_validation->set_rules('file_description','La description du fichier','trim|required|min_length[5]|max_length[200]');
			if($this->instance->form_validation->run())
			{
				$query	=	$this->file_contentAdmin->uploadFile(
					'file',
					$this->instance->input->post('file_human_name'),
					$this->instance->input->post('file_description')
				);
				if($query)
				{
					$this->instance->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
				}
			}
		}
		if(!$this->tendoo_admin->actionAccess('tendoo_contents_upload','tendoo_contents'))
		{
			$this->instance->url->redirect(array('admin','index?notice=accessDenied'));
		}
		set_page('title','Gestionnaire de contenu - Envoyer un fichier');
		
		$this->data['loadSection']	=	'upload';
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/upload',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function manage($id)
	{
		if(!$this->tendoo_admin->actionAccess('tendoo_contents_upload','tendoo_contents'))
		{
			$this->instance->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->instance->file->js_url	=	$this->instance->url->main_url().$this->data['module_dir'].'/js/';
		$this->instance->file->css_url	=	$this->instance->url->main_url().$this->data['module_dir'].'/css/';
		$this->instance->file->js_push('jquery.Jcrop.min');
		$this->instance->file->css_push('jquery.Jcrop.min');
		$this->load->library('form_validation');
		if($this->instance->input->post('delete_file'))
		{
			if(!$this->tendoo_admin->actionAccess('tendoo_contents_delete','tendoo_contents'))
			{
				$this->instance->url->redirect(array('admin','index?notice=accessDenied'));
			}
			$this->instance->form_validation->set_rules('delete_file','','trim|required');
			$this->instance->form_validation->set_rules('content_id','','trim|required|is_numeric');
			if($this->instance->form_validation->run()) // File drop
			{
				$query	=	$this->file_contentAdmin->fileDrop($this->instance->input->post('content_id'));
				if($query)
				{
					$this->instance->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
				}
				else
				{
					$this->instance->notice->push_notice(fetch_error('error_occured'));
				}
			}
		}
		if($this->instance->input->post('edit_file'))
		{
			$this->load->library('form_validation');
			$this->instance->form_validation->set_rules('file_name','Le nom du fichier','trim|required|min_length[5]|max_length[40]');
			$this->instance->form_validation->set_rules('file_description','La description du fichier','trim|required|min_length[5]|max_length[200]');
			$this->instance->form_validation->set_rules('content_id','','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('edit_file','','trim|required|min_length[1]');
			if($this->instance->form_validation->run()) // edit file
			{
				$query	=	$this->file_contentAdmin->editFile(
					$this->instance->input->post('content_id'),
					$this->instance->input->post('file_name'),
					$this->instance->input->post('file_description')
				);
				if($query)
				{
					$this->instance->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
				}
				else
				{
					$this->instance->notiec->push_notice(fetch_error('error_occured'));				
				}
			}
		}
		if($this->instance->input->post('overwrite_file'))
		{
			$this->load->library('form_validation');
			$this->instance->form_validation->set_rules('overwrite_file','Ecraser l\'image','trim|required|min_length[5]|max_length[40]');
			$this->instance->form_validation->set_rules('x1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('y1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('x2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('y2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('w','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('h','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('image_id','Index de l\'image','trim|required|min_length[1]');
			if($this->instance->form_validation->run())
			{
				$query	=	$this->lib->overwrite_image(
					$this->instance->input->post('image_id'),
					$this->instance->input->post('x1'),
					$this->instance->input->post('y1'),
					$this->instance->input->post('x2'),
					$this->instance->input->post('y2'),
					$this->instance->input->post('w'),
					$this->instance->input->post('h')
				);
				if($query)
				{
					$this->instance->notice->push_notice(fetch_error('done'));
				}
				else
				{
					$this->instance->notice->push_notice(fetch_error('error_occured'));
				}
			}
		}
		if($this->instance->input->post('change_file'))
		{
			$this->load->library('form_validation');
			$this->instance->form_validation->set_rules('content_id','cordonn&eacute;e','trim|required|min_length[1]');
			if($this->instance->form_validation->run())
			{
				$query	=	$this->lib->fileReplace($this->instance->input->post('content_id'),'new_file');
				$this->instance->notice->push_notice(fetch_error($query));
			}
		}
		if($this->instance->input->post('create_new_file'))
		{
			$this->load->library('form_validation');
			$this->instance->form_validation->set_rules('create_new_file','Ecraser l\'image','trim|required|min_length[5]|max_length[40]');
			$this->instance->form_validation->set_rules('x1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('y1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('x2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('y2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('w','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('h','cordonn&eacute;e','trim|required|min_length[1]');
			$this->instance->form_validation->set_rules('image_id','Index de l\'image','trim|required|min_length[1]');
			if($this->instance->form_validation->run())
			{
				$query	=	$this->lib->create_new_image(
					$this->instance->input->post('image_id'),
					$this->instance->session->userdata('fileNewName'),
					$this->instance->input->post('x1'),
					$this->instance->input->post('y1'),
					$this->instance->input->post('x2'),
					$this->instance->input->post('y2'),
					$this->instance->input->post('w'),
					$this->instance->input->post('h')
				);
				$this->instance->notice->push_notice(fetch_error($query));
			}
		}
		
		set_page('title','Gestionnaire de contenu - Edition d\'un fichier');
		$this->data['fileNewName']	=	$this->lib->getName();
		$this->instance->session->set_userdata('fileNewName',$this->data['fileNewName']);
		$this->data['getFile']		=	$this->file_contentAdmin->getUploadedFiles($id);
		if(count($this->data['getFile']) == 0)
		{
			$this->instance->url->redirect(array('error','code','page404'));
		}
		$this->data['id']			=	$id;
		$this->data['loadSection']	=	'manage';
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage',$this->data,true,TRUE);
		return $this->data['body'];
	}
}
