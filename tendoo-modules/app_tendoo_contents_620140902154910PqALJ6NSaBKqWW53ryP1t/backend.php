<?php
class tendoo_contents_backend extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data						=	$data;
		$module							=	get_core_vars( 'opened_module' );
		$this->config();
		$this->opened_module			=	$module;
		$this->data[ 'module' ] 		=	$module;
		$this->lib						=	$this->data['lib']				=	// no is not an error;
		$this->file_contentAdmin		=	new file_contentAdmin($this->data);
		$this->data['module_dir']		=	MODULES_DIR.$this->opened_module['encrypted_dir'];
		$this->data['repository_dir']	=	MODULES_DIR.$this->opened_module['encrypted_dir'].'/content_repository';
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	private function config(){
		setup_admin_left_menu( 'File Manager' , 'file' );
		add_admin_left_menu( 'Accueil' , module_url( array( 'index' ) ) );
		add_admin_left_menu( 'Ajouter un fichier' , module_url( array( 'upload' ) ) );
	}
	public function index($page	=	1)
	{
		set_page('title','Gestionnaire de contenu');
			
		$this->data['loadSection']	=	'main';
		$this->data['ttFiles']		=	$this->file_contentAdmin->countUploadedFiles();
		$this->data['paginate']	=	$this->tendoo->paginate(10,$this->data['ttFiles'],1,'on','off',$page,$this->url->site_url(array('admin','open','modules',$this->opened_module['namespace'],'index')).'/',$ajaxis_link=null);
		$this->data['paginate'][3]=== false ? $this->url->redirect(array('error','code','page404')) : null;
		$this->data['files']		=	$this->file_contentAdmin->getUploadedFiles($this->data['paginate'][1],$this->data['paginate'][2]);
		
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/main',$this->data,true,TRUE);
		
		return $this->data['body'];
	}
	public function ajax($x = '',$y = 1,$z = '')
	{
		if($x == 'selection')
		{
			$this->data['ttFiles']		=	$this->file_contentAdmin->countUploadedFiles();
			$this->data['paginate']		=	$this->tendoo->paginate(12,$this->data['ttFiles'],1,'on','off',$y,$this->url->site_url(array('admin','open','modules',$this->opened_module['namespace'],'ajax','selection')).'/',$ajaxis_link=null);
			$this->data['files']		=	$this->file_contentAdmin->getUploadedFiles($this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/ajax_load_files',$this->data,true,TRUE);
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
			$this->form_validation->set_rules('file_name','Le nom du fichier','trim|required|min_length[5]|max_length[40]');
			$this->form_validation->set_rules('file_description','La description du fichier','trim|required|min_length[5]|max_length[200]');
			if($this->form_validation->run())
			{
				$query	=	$this->file_contentAdmin->uploadFile(
					'file',
					$this->input->post('file_name'),
					$this->input->post('file_description')
				);
				if($query)
				{
					$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'].'?notice=done'));
				}
			}
		}
		if( current_user()->cannot( 'tendoo_contents@tendoo_contents_upload') )
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		set_page('title', __( 'Upload a new file' ) );
		
		$this->data['loadSection']	=	'upload';
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/upload',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function manage($id)
	{
		if( !current_user_can( 'tendoo_contents@upload_media' ) )
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->file->js_url	=	$this->url->main_url().$this->data['module_dir'].'/js/';
		$this->file->css_url	=	$this->url->main_url().$this->data['module_dir'].'/css/';
		$this->file->js_push('jquery.Jcrop.min');
		$this->file->css_push('jquery.Jcrop.min');
		$this->load->library('form_validation');
		if($this->input->post('delete_file'))
		{
			if( !current_user_can( 'tendoo_contents@delete_media' ) )
			{
				$this->url->redirect(array('admin','index?notice=accessDenied'));
			}
			$this->form_validation->set_rules('delete_file','','trim|required');
			$this->form_validation->set_rules('content_id','','trim|required|is_numeric');
			if($this->form_validation->run()) // File drop
			{
				$query	=	$this->file_contentAdmin->fileDrop($this->input->post('content_id'));
				if($query)
				{
					$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'].'?notice=done'));
				}
				else
				{
					$this->notice->push_notice(fetch_notice_output('error-occured'));
				}
			}
		}
		if($this->input->post('edit_file'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('file_name','Le nom du fichier','trim|required|min_length[5]|max_length[40]');
			$this->form_validation->set_rules('file_description','La description du fichier','trim|required|min_length[5]|max_length[200]');
			$this->form_validation->set_rules('content_id','','trim|required|min_length[1]');
			$this->form_validation->set_rules('edit_file','','trim|required|min_length[1]');
			if($this->form_validation->run()) // edit file
			{
				$query	=	$this->file_contentAdmin->editFile(
					$this->input->post('content_id'),
					$this->input->post('file_name'),
					$this->input->post('file_description')
				);
				if($query)
				{
					module_location( array( 'manage' , $this->input->post( 'content_id' ) . '?notice=done' ) );
				}
				else
				{
					$this->notice->push_notice(fetch_notice_output('error-occured'));				
				}
			}
		}
		if($this->input->post('overwrite_file'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('overwrite_file','Ecraser l\'image','trim|required|min_length[5]|max_length[40]');
			$this->form_validation->set_rules('x1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('y1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('x2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('y2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('w','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('h','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('image_id','Index de l\'image','trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				$query	=	$this->lib->overwrite_image(
					$this->input->post('image_id'),
					$this->input->post('x1'),
					$this->input->post('y1'),
					$this->input->post('x2'),
					$this->input->post('y2'),
					$this->input->post('w'),
					$this->input->post('h')
				);
				if($query)
				{
					$this->notice->push_notice(fetch_notice_output('done'));
				}
				else
				{
					$this->notice->push_notice(fetch_notice_output('error-occured'));
				}
			}
		}
		if($this->input->post('change_file'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('content_id','cordonn&eacute;e','trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				$query	=	$this->lib->fileReplace($this->input->post('content_id'),'new_file');
				$this->notice->push_notice(fetch_notice_output($query));
			}
		}
		if($this->input->post('create_new_file'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('create_new_file','Ecraser l\'image','trim|required|min_length[5]|max_length[40]');
			$this->form_validation->set_rules('x1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('y1','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('x2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('y2','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('w','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('h','cordonn&eacute;e','trim|required|min_length[1]');
			$this->form_validation->set_rules('image_id','Index de l\'image','trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				$query	=	$this->lib->create_new_image(
					$this->input->post('image_id'),
					$this->session->userdata('fileNewName'),
					$this->input->post('x1'),
					$this->input->post('y1'),
					$this->input->post('x2'),
					$this->input->post('y2'),
					$this->input->post('w'),
					$this->input->post('h')
				);
				$this->notice->push_notice(fetch_notice_output($query));
			}
		}
		
		set_page('title','Gestionnaire de contenu - Edition d\'un fichier');
		$this->data['fileNewName']	=	$this->lib->getName();
		$this->session->set_userdata('fileNewName',$this->data['fileNewName']);
		$this->data['getFile']		=	$this->file_contentAdmin->getUploadedFiles($id);
		if(count($this->data['getFile']) == 0)
		{
			$this->url->redirect(array('error','code','page404'));
		}
		$this->data['id']			=	$id;
		$this->data['loadSection']	=	'manage';
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/manage',$this->data,true,TRUE);
		return $this->data['body'];
	}
}
