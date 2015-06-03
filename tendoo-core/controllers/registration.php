<?php
Class registration extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		$this->instance				=	get_instance();
		$this->load->library('users_global');
		$this->load->library('roles');
		$this->load->library('file');
		$this->load->library('captcha');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		
		css_push_if_not_exists('font');		
		css_push_if_not_exists('../admin-lte/bootstrap/css/bootstrap.min');
		css_push_if_not_exists('../admin-lte/font-awesome/font-awesome.4.3.0.min');
		css_push_if_not_exists('../admin-lte/dist/css/AdminLTE.min');
		css_push_if_not_exists('../admin-lte/plugins/iCheck/square/blue');

		
		js_push_if_not_exists('../admin-lte/plugins/jQuery/jQuery-2.1.3.min');
		js_push_if_not_exists('../admin-lte/bootstrap/js/bootstrap.min');
		js_push_if_not_exists('../admin-lte/plugins/iCheck/icheck.min');

		// is Connected ?
		($this->instance->users_global->isConnected()=== TRUE) ? $this->instance->url->redirect(array('index?notice=disconnectFirst')) : false;
		
		set_core_vars( 'tendoo_notices' , trigger_filters( 'declare_notices' , array( get_core_vars( 'default_notices' ) ) ) ); // @since 1.4		
	}
	// Public methods
	public function index()
	{
		set_core_vars( 'options' , $options		=	get_meta( 'all' ) , 'read_only' );
		if( riake( 'tendoo_registration_status' , $options ) == '0')
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
		set_core_vars( 'allowPrivilege' , $this->roles->get_public_roles() );
		
		$this->instance->session->set_userdata( 'captcha_code' , $this->instance->captcha->get() );
		
		set_core_vars( 'captcha' ,	$this->instance->session->userdata( 'captcha_code' ) );
		set_core_vars( 'pageTitle' , sprintf( __( 'Create an account - %s ' ) , riake( 'site_name' , $options ) ) );
		set_page( 'title' , get_core_vars( 'pageTitle' ) );		
		set_core_vars( 'body' ,	$this->load->the_view('registration/createUser',true) );
		
		$this->load->view('header');
		$this->load->view('global_body');
	}
	public function superAdmin()
	{
		// Has Admin ?
		($this->users_global->hasAdmin()=== TRUE) ? $this->instance->url->redirect(array('login')) : false;
		
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
		set_core_vars( 'pageTitle' , __( 'Create Admin - Tendoo' ) );
		set_page(	'title'	,	get_core_vars( 'pageTitle' ) );
		set_page(	'description'	,	__( 'Create Super Admin - Tendoo' )	);
		
		set_core_vars( 'body' ,	$this->load->view('registration/createSuperAdmin' , true ) );
		
		$this->load->view('header');
		$this->load->view('global_body');
	}
}