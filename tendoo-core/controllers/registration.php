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
		$this->input				=&	$this->instance->input;
		$this->notice				=&	$this->instance->notice;
		$this->file					=&	$this->instance->file;
		$this->pagination			=&	$this->instance->pagination;
		$this->form_validation		=&	$this->instance->form_validation;

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
				
		set_core_vars( 'options' , $options		=	get_meta( 'all' ) , 'read_only' );
		
		if( riake( 'allow_registration' , $options ) == '0')
		{
			$this->instance->url->redirect(array('error','code','registration-not-allowed'));
		}
		$this->instance->form_validation->set_rules('user_pseudo', translate( 'Pseudo' ),'trim|required|min_length[5]|max_length[15]');
		$this->instance->form_validation->set_rules('user_password', __( 'Password' ),'trim|required|min_length[6]|max_length[15]');
		$this->instance->form_validation->set_rules('user_password_confirm', __( 'Confirm Password' ),'trim|required|min_length[6]|max_length[15]');
		$this->instance->form_validation->set_rules('user_mail', __( 'Email' ),'trim|valid_email|required');
		$this->instance->form_validation->set_rules('user_sex', __( 'Sex' ),'trim|required|min_length[3]|max_length[4]');
		$this->instance->form_validation->set_rules('priv_id',__( 'Select Privilege' ),'trim|min_length[11]');
		$this->instance->form_validation->set_rules('captchaCorrespondance', __( 'Captcha Code' ),'trim|required|min_length[6]');
		$this->instance->form_validation->set_rules('user_captcha', __( 'Captcha validation Code' ),'matches[captchaCorrespondance]|trim|required|min_length[6]');
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
			notice('push',fetch_notice_output($query));
		}
		$this->data['allowPrivilege']	=	$this->instance->tendoo_admin->get_public_roles();
		$this->instance->session->set_userdata('captcha_code',$this->instance->captcha->get());
		$this->data['captcha']	=	$this->instance->session->userdata('captcha_code');
		$this->data['pageTitle']	=	'Cr&eacute;er un compte - '. riake( 'site_name' , $options );
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
		
		$this->instance->form_validation->set_rules('super_admin_pseudo', __( 'Pseudo' ),'trim|required|min_length[5]|max_length[15]');
		$this->instance->form_validation->set_rules('super_admin_password',__( 'Password' ),'trim|required|min_length[6]|max_length[15]');
		$this->instance->form_validation->set_rules('super_admin_password_confirm',__( 'Confirm Password' ),'trim|required|min_length[6]|matches[super_admin_password]');
		$this->instance->form_validation->set_rules('super_admin_mail', __( 'Email' ),'trim|valid_email|required');
		$this->instance->form_validation->set_rules('super_admin_sex', __( 'Sex selection' ),'trim|required|min_length[3]|max_length[4]');
		if($this->instance->form_validation->run())
		{
			if($this->instance->users_global->createSuperAdmin(
				$this->instance->input->post('super_admin_pseudo'),
				$this->instance->input->post('super_admin_password'),
				$this->instance->input->post('super_admin_sex'),
				$this->instance->input->post('super_admin_mail')
			))
			{
				$this->instance->url->redirect(array('login?notice=user-has-been-created&ref='.urlencode($this->instance->url->site_url(array('admin','index')))));
			}
			notice('push',fetch_notice_output('super-admin-creation-failed'));
		}
		$this->data['pageTitle']	=	__( 'Create Admin - Tendoo' );
		set_page(	'title'	,	$this->data['pageTitle']);
		set_page(	'description'	,	__( 'Create Super Admin - Tendoo' )	);
		
		$this->data['body']	=	$this->load->view('registration/createSuperAdmin',$this->data,true);
		
		$this->load->view('header',$this->data);
		$this->load->view('global_body',$this->data);
	}
}