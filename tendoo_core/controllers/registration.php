<?php
Class registration extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		$this->instance				=	get_instance();
		$this->load->library('users_global');
		$this->load->library('captcha');
		$this->user_global			=&	$this->instance->users_global;
		$this->load					=&	$this->load;
		// is Connected ?
		($this->instance->users_global->isConnected()=== TRUE) ? $this->instance->url->redirect(array('index?notice=disconnectFirst')) : false;
	}
	// Privates Methods
	private function construct_end()
	{
		$this->tendoo_admin			=&	$this->instance->tendoo_admin;
		$this->data['Tendoo_admin']	=&	$this->instance->tendoo_admin;
		$this->load->library('Tendoo_admin');
		$this->loadOuputFile();
	}
	private function loadLibraries()
	{
		$this->load->library('pagination');
		$this->load->library('form_validation');
$this->instance->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		$this->input				=&	$this->instance->input;
		$this->notice				=&	$this->instance->notice;
		$this->file					=&	$this->instance->file;
		$this->pagination			=&	$this->instance->pagination;
		$this->form_validation		=&	$this->instance->form_validation;
		$this->instance->form_validation->set_error_delimiters('<span class="fg-color-redLight">', '</span>');
		$this->data['notice']		=	'';
		$this->data['error']		=	'';
		$this->data['success']		=	'';
	}
	private function loadOuputFile()
	{
		$this->instance->file->css_push('font');
		$this->instance->file->css_push('app.v2');
		$this->instance->file->css_push('css1');
		$this->instance->file->css_push('css2');
		$this->instance->file->css_push('tendoo_global');
	}
	// Public methods
	public function index()
	{
		$this->loadLibraries();				//	Affecting Libraries */
		$this->construct_end();				// 	Fin du constructeur
		
		$this->data['options']		=	$this->instance->meta_datas->get();
		if($this->data['options'][0]['ALLOW_REGISTRATION'] == '0')
		{
			$this->instance->url->redirect(array('error','code','registrationNotAllowed'));
		}
		$this->instance->form_validation->set_error_delimiters('<span style="color:red">','</span>');
		$this->instance->form_validation->set_rules('user_pseudo','Pseudo','trim|required|min_length[5]|max_length[15]');
		$this->instance->form_validation->set_rules('user_password','Mot de passe','trim|required|min_length[6]|max_length[15]');
		$this->instance->form_validation->set_rules('user_password_confirm','Confirmer le mot de passe','trim|required|min_length[6]|max_length[15]');
		$this->instance->form_validation->set_rules('user_mail','Email','trim|valid_email|required');
		$this->instance->form_validation->set_rules('user_sex','Selection du sexe','trim|required|min_length[3]|max_length[4]');
		$this->instance->form_validation->set_rules('priv_id','Selection du privil&egrave;ge','trim|min_length[11]');
		$this->instance->form_validation->set_rules('captchaCorrespondance','Code captcha','trim|required|min_length[6]');
		$this->instance->form_validation->set_rules('user_captcha',' ','matches[captchaCorrespondance]|trim|required|min_length[6]');
		if($this->instance->form_validation->run())
		{
			$query	=	$this->instance->users_global->createUser(
				$this->instance->input->post('user_pseudo'),
				$this->instance->input->post('user_password'),
				$this->instance->input->post('user_sex'),
				$this->instance->input->post('user_mail'),
				$active	=	'FALSE',
				$this->instance->input->post('priv_id')
			);
			if($query	==	'userCreated')
			{
				$this->instance->url->redirect(array('login?notice='.$query));
			}
			notice('push',fetch_error($query));
		}
		$this->data['allowPrivilege']	=	$this->instance->tendoo_admin->getPublicPrivilege();
		$this->instance->session->set_userdata('captcha_code',$this->instance->captcha->get());
		$this->data['captcha']	=	$this->instance->session->userdata('captcha_code');
		$this->data['pageTitle']	=	'Cr&eacute;er un compte - '.$this->data['options'][0]['SITE_NAME'];
		set_page('title',$this->data['pageTitle']);
		
		$this->data['body']	=	$this->load->view('registration/createUser',$this->data,true);
		
		$this->load->view('header',$this->data);
		$this->load->view('global_body',$this->data);
	}
	public function superAdmin()
	{
		// Has Admin ?
		($this->user_global->hasAdmin()=== TRUE) ? $this->instance->url->redirect(array('login')) : false;
		$this->loadLibraries();				//	Affecting Libraries */
		$this->construct_end();				// 	Fin du constructeur
		
		$this->instance->form_validation->set_rules('super_admin_pseudo','Pseudo','trim|required|min_length[5]|max_length[15]');
		$this->instance->form_validation->set_rules('super_admin_password','Mot de passe','trim|required|min_length[6]|max_length[15]');
		$this->instance->form_validation->set_rules('super_admin_password_confirm','Confirmer le mot de passe','trim|required|min_length[6]|matches[super_admin_password]');
		$this->instance->form_validation->set_rules('super_admin_mail','Email','trim|valid_email|required');
		$this->instance->form_validation->set_rules('super_admin_sex','Selection du sexe','trim|required|min_length[3]|max_length[4]');
		if($this->instance->form_validation->run())
		{
			if($this->instance->users_global->createSuperAdmin(
				$this->instance->input->post('super_admin_pseudo'),
				$this->instance->input->post('super_admin_password'),
				$this->instance->input->post('super_admin_sex'),
				$this->instance->input->post('super_admin_mail')
			))
			{
				$this->instance->url->redirect(array('login?notice=adminCreated&ref='.urlencode($this->instance->url->site_url(array('admin','index')))));
			}
			notice('push',fetch_error('SuperAdminCreationError'));
		}
		$this->data['pageTitle']	=	'Cr&eacute;er un super administrateur - Tendoo';
		set_page(	'title'	,	$this->data['pageTitle']);
		set_page(	'description'	,	'Créer un super administrateur'	);
		
		$this->data['body']	=	$this->load->view('registration/createSuperAdmin',$this->data,true);
		
		$this->load->view('header',$this->data);
		$this->load->view('global_body',$this->data);
	}
}