<?php
Class login
{
	private $core;
	private $user_global;
	private $load;
	public function __construct()
	{
		$this->core			=	Controller::instance();
		$this->core->load->library('session');
		$this->core->load->library('users_global');
		$this->users_global	=&	$this->core->users_global;
		$this->load			=&	$this->core->load;
		// Has admin ?
		($this->users_global->hasAdmin()=== FALSE) ? $this->core->url->redirect(array('resgistration','superAdmin')) : false;
		// is Connected ?
		($this->users_global->isConnected()=== TRUE) ? $this->core->url->redirect(array('index')) : false;
	}
	// Privates Methods
	private function construct_end()
	{
		$this->loadOuputFile();
	}
	private function loadLibraries()
	{
		$this->load->library('pagination');
		$this->load->library('file');
		$this->load->library('form_validation');
		$this->input				=&	$this->core->input;
		$this->notice				=&	$this->core->notice;
		$this->file					=&	$this->core->file;
		$this->pagination			=&	$this->core->pagination;
		$this->form_validation		=&	$this->core->form_validation;
		$this->form_validation->set_error_delimiters('<span class="fg-color-redLight">', '</span>');
		$this->data['notice']		=	'';
		$this->data['error']		=	'';
		$this->data['success']		=	'';
	}
	private function loadOuputFile()
	{
		$this->core->file->css_push('modern');
		$this->core->file->css_push('modern-responsive');
		$this->core->file->css_push('hubby_default');
		$this->core->file->css_push('ub.framework');
		$this->core->file->css_push('hubby_global');

		$this->core->file->js_push('jquery');
		$this->core->file->js_push('dropdown');
		$this->core->file->js_push('hubby_app');
		$this->core->file->js_push('resizer');
	}
	// Index
	public function index()
	{
		// Library
		$this->loadLibraries();
		$this->construct_end();		
		// Method
		$this->core->file->js_push('tile-slider');
		$this->core->form_validation->set_rules('admin_pseudo','Pseudo','trim|required|min_length[6]|max_length[15]');
		$this->core->form_validation->set_rules('admin_password','Mot de passe','trim|required|min_length[6]|max_length[15]');
		if($this->core->form_validation->run())
		{
			$login_status	=	$this->core->users_global->authUser($this->core->input->post('admin_pseudo'),$this->core->input->post('admin_password'));
			if($login_status ===	'userLoggedIn')
			{
				if(isset($_GET['ref']))
				{
					$this->core->url->redirect(urldecode($_GET['ref']));
				}
				else
				{
					$this->core->url->redirect(array('index'));
				}
			}
			else if($login_status	===	'PseudoOrPasswordWrong')
			{
				// Redirection a la page index.
				$this->core->notice->push_notice(notice('AdminAuthFailed'));
			}
		}
		$this->data['pageTitle']	=	'Connexion';
		$this->core->hubby->setTitle($this->data['pageTitle']);
		
		$this->data['foot']	=	$this->load->view('login/footer',$this->data,true);
		$this->data['body']	=	$this->load->view('login/connect',$this->data,true);
		
		$this->load->view('login/header',$this->data);
		$this->load->view('login/global_body',$this->data);	
	}
}