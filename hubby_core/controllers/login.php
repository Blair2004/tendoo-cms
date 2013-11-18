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
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('css1');
		$this->core->file->css_push('css2');
		$this->core->file->css_push('font');
		$this->core->file->css_push('hubby_global');
	}
	// Index
	public function index()
	{
		// Library
		$this->loadLibraries();
		$this->construct_end();		
		$this->data['options']		=	$this->core->hubby->getOptions();
		// Method
		$this->core->form_validation->set_rules('admin_pseudo','Pseudo','trim|required|min_length[5]|max_length[15]');
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
				$this->core->notice->push_notice(notice('userNotFoundOrWrongPass'));
			}
			else
			{
				$this->core->notice->push_notice(notice($login_status));
			}
		}
		$this->data['pageTitle']	=	'Connexion';
		$this->core->hubby->setTitle($this->data['pageTitle']);
		
		$this->data['body']	=	$this->load->view('login/connect',$this->data,true);
		
		$this->load->view('header',$this->data);
		$this->load->view('global_body',$this->data);	
	}
	public function recovery($action	=	'home')
	{
		// Library
		$this->loadLibraries();
		$this->construct_end();		
		$this->data['options']		=	$this->core->hubby->getOptions();
		// Method
		if($action == 'home')
		{
			$this->data['pageTitle']	=	'Syst&egrave;me de r&eacute;cup&eacute;ration de compte';
			$this->core->hubby->setTitle($this->data['pageTitle']);
			$this->data['menu']	=	$this->load->view('login/recovery_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('login/recovery_main',$this->data,true);
			
			$this->load->view('header',$this->data);
			$this->load->view('global_body',$this->data);	
		}
		else if($action == 'receiveValidation')
		{
			$this->core->load->library('form_validation');
			$this->core->form_validation->set_rules('email_valid','Email','trim|required|valid_email');
			if($this->core->form_validation->run())
			{
				$query	=	$this->core->users_global->sendValidationMail($this->core->input->post('email_valid'));
				$this->core->notice->push_notice(notice($query));
			}
			$this->data['pageTitle']	=	'Recevoir le mail d\'activation';
			$this->core->hubby->setTitle($this->data['pageTitle']);
			$this->data['menu']	=	$this->load->view('login/recovery_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('login/recovery_mailOption',$this->data,true);
			
			$this->load->view('header',$this->data);
			$this->load->view('global_body',$this->data);
		}
		else if($action == 'password_lost')
		{
			$this->data['pageTitle']	=	'Mot de passe perdu';
			$this->core->hubby->setTitle($this->data['pageTitle']);
			$this->data['menu']	=	$this->load->view('login/recovery_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('login/recovery_password',$this->data,true);
			
			$this->load->view('header',$this->data);
			$this->load->view('global_body',$this->data);
		}
	}
}