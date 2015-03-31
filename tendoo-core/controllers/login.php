<?php
Class login extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->instance			=	get_instance();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->load->library('users_global');
		$this->load->library('file');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		css_push_if_not_exists('../admin-lte/bootstrap/css/bootstrap.min');
		css_push_if_not_exists('../admin-lte/font-awesome/font-awesome.4.3.0.min');
		css_push_if_not_exists('../admin-lte/dist/css/AdminLTE.min');
		css_push_if_not_exists('../admin-lte/plugins/iCheck/square/blue');

		
		js_push_if_not_exists('../admin-lte/plugins/jQuery/jQuery-2.1.3.min');
		js_push_if_not_exists('../admin-lte/bootstrap/js/bootstrap.min');
		js_push_if_not_exists('../admin-lte/plugins/iCheck/icheck.min');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		// Has admin ?
		($this->users_global->hasAdmin()=== FALSE) ? $this->url->redirect(array('registration','superAdmin')) : false;
		// is Connected ?
		($this->users_global->isConnected()=== TRUE) ? $this->url->redirect(array('index')) : false;
		$this->options		=	get_meta( 'all' );
		
		set_core_vars( 'tendoo_notices' , trigger_filters( 'declare_notices' , array( get_core_vars( 'default_notices' ) ) ) ); // @since 1.4		
	}
	public function index() // OK for 0.99
	{
		$this->form_validation->set_rules('admin_pseudo', translate( 'Pseudo' ),'trim|required|min_length[5]|max_length[15]');
		$this->form_validation->set_rules('admin_password', translate( 'Password' ),'trim|required|min_length[6]|max_length[15]');
		if($this->form_validation->run())
		{		
			$login_status	=	$this->users_global->authUser(
				$this->input->post('admin_pseudo'),
				$this->input->post('admin_password'),
				$this->input->post('stayLoggedIn')
			);
			if($login_status ===	'userLoggedIn')
			{
				if(isset($_GET['ref']))
				{
					$this->url->redirect(urldecode($_GET['ref']));
				}
				else if($this->input->post('redirector') != '')
				{
					$this->url->redirect(urldecode($this->input->post('redirector')));
				}
				else
				{
					$this->url->redirect(array('index'));
				}
			}
			else if($login_status	===	'PseudoOrPasswordWrong')
			{
				// Redirection a la page index.
				notice('push',fetch_notice_output('userNotFoundOrWrongPass'));
			}
			else
			{
				notice('push',fetch_notice_output($login_status));
			}
		}
		// var_dump($this->load);
		set_core_vars( 'pageTitle' , 	translate( 'Login' ) . ' - '.riake( 'site_name' , $this->options ) );
		set_page('title', get_core_vars( 'pageTitle' ) );		
		set_core_vars( 'body' ,	$this->load->the_view('login/connect' , true ) );
		
		$this->load->the_view('header');
		$this->load->the_view('global_body');	
	}
	public function recovery($action	=	'home')
	{
		// Library
		if( riake( 'tendoo_registration_status' , $this->options ) == "0")
		{
			$this->url->redirect(array('error','code','registration-disabled'));
		}
		// Method
		if($action == 'home')
		{
			set_core_vars( 'pageTitle' ,	translate( 'Password recovery wizard' ) );
			set_page('title', get_core_vars( 'pageTitle' ) );
			set_core_vars( 'body' ,	$this->load->view('login/recovery_main',true) );
			
			$this->load->the_view('header');
			$this->load->the_view('global_body');	
		}
		else if($action == 'receiveValidation')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email_valid', translate( 'Email' ),'trim|required|valid_email');
			if($this->form_validation->run())
			{
				$query	=	$this->users_global->sendValidationMail($this->input->post('email_valid'));
				if($query	==	'activation-mail-send')
				{
					$this->url->redirect(array('login?notice='.$query)); // redirect to login
				}
				get_instance()->notice->push_notice( fetch_notice_output($query) );
			}
			set_core_vars( 'pageTitle' , translate( 'Receive activation mail' ) );
			set_page('title', get_core_vars( 'pageTitle' ) );
			set_core_vars( 'body' ,	$this->load->view('login/recovery_mailOption',true) );
			
			$this->load->the_view('header');
			$this->load->the_view('global_body');
		}
		else if($action == 'password_lost')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email_valid', translate( 'Email' ) ,'trim|required|valid_email');
			if($this->form_validation->run())
			{
				$query	=	$this->users_global->sendPassChanger($this->input->post('email_valid'));
				if($query	==	'activation-mail-send')
				{
					$this->url->redirect(array('login?notice='.$query)); // redirect to login
				}
				notice( 'push' , fetch_notice_output($query) );
			}
			set_core_vars( 'pageTitle' ,	'Mot de passe perdu' );
			set_page('title', get_core_vars( 'pageTitle' ) );
			set_core_vars( 'body' ,	$this->load->view('login/recovery_password',true) );
			
			$this->load->the_view('header');
			$this->load->the_view('global_body');
		}
	}
	public function activate($email,$timestamp,$password)
	{
		if($timestamp	> $this->instance->date->timestamp())
		{
			if($this->users_global->emailExist($email))
			{
				$connect	=	$this->users_global->emailConnect($email,$password);
				if($connect)
				{
					if($this->users_global->activateUser($connect['ID']))
					{
						$this->url->redirect(array('login?notice=account-activation-done'));
					}
					else
					{
						$this->url->redirect(array('login?notice=account-activation-failed'));
					}					
				}
				else
				{
					$this->url->redirect(array('error','code','activation-failed'));
				}
			}
			else
			{
				$this->url->redirect(array('error','code','unknow-email'));
			}
		}
		else
		{
			$this->url->redirect(array('error','code','expiration-time-reached'));
		}
	}
	public function passchange($email,$timestamp,$password)
	{
		if($timestamp	> $this->instance->date->timestamp())
		{
			if($this->users_global->emailExist($email))
			{
				// Library
				
				$this->load->library('Tendoo_admin');	
				if( riake( 'allow_registration' , $this->options ) == "0")
				{
					$this->url->redirect(array('error','code','registration-disabled'));
				}
				$connect	=	$this->users_global->emailConnect($email,$password);
				if($connect)
				{
					$this->load->library('form_validation');
					$this->form_validation->set_rules('password_new', translate( 'New password' ),'trim|required|min_length[6]|max_length[30]');
					$this->form_validation->set_rules('password_new_confirm',translate( 'Confirm password' ),'trim|required|matches[password_new]');	
					if($this->form_validation->run())
					{
						$query	=	$this->users_global->recoverPassword($connect['ID'],$password,$this->input->post('password_new'));
						if($query == 'password-has-changed')
						{
							$this->url->redirect(array('login?notice='.$query));
						}
						else
						{
							notice(fetch_notice_output($query));
						}
					}
					set_core_vars( 'pageTitle' , translate( 'Changing Password - Tendoo' ) );
					set_page('title', get_core_vars( 'pageTitle' ) );
					set_core_vars( 'menu' ,	$this->load->view('login/recovery_menu',true) );
					set_core_vars( 'body' ,	$this->load->view('login/password_change',true) );
					
					$this->load->the_view('header');
					$this->load->the_view('global_body');
				}
				else
				{
					$this->url->redirect(array('error','code','activation-failed'));
				}
			}
			else
			{
				$this->url->redirect(array('error','code','unknow-email'));
			}
		}
		else
		{
			$this->url->redirect(array('error','code','expiration-time-reached'));
		}
	}
	
}