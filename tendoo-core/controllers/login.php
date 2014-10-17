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
		css_push_if_not_exists('font');
		css_push_if_not_exists('app.v2');
		css_push_if_not_exists('tendoo_global');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		// Has admin ?
		($this->users_global->hasAdmin()=== FALSE) ? $this->url->redirect(array('registration','superAdmin')) : false;
		// is Connected ?
		($this->users_global->isConnected()=== TRUE) ? $this->url->redirect(array('index')) : false;
		$this->data['options']		=	get_meta( 'all' );
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
		$this->data['pageTitle']	=	translate( 'Login' ) . ' - '.riake( 'site_name' , $this->data['options'] );
		set_page('title',$this->data['pageTitle']);
		
		$this->data['body']	=	$this->load->view('login/connect',$this->data,true);
		
		$this->load->view('header',$this->data);
		$this->load->view('global_body',$this->data);	
	}
	public function modal() // Disabled
	{
		$redirect	=	isset($_GET['ref']) ? $_GET['ref'] : '';
		// Library
		
		$this->data['options']		=	get_meta( 'all' );
		// Method
		$this->data['redirect']		=	$redirect;
		$this->data['body']	=	$this->load->view('login/connect_modal',$this->data,true);
		
		$this->load->view('header',$this->data);
		$this->load->view('global_body',$this->data);	
	}
	public function recovery($action	=	'home')
	{
		// Library
		if( riake( 'allow_registration' , $this->data['options'] ) == "0")
		{
			$this->url->redirect(array('error','code','regisAndAssociatedFunLocked'));
		}
		// Method
		if($action == 'home')
		{
			$this->data['pageTitle']	=	translate( 'Password recovery wizard' );
			set_page('title',$this->data['pageTitle']);
			$this->data['body']	=	$this->load->view('login/recovery_main',$this->data,true);
			
			$this->load->view('header',$this->data);
			$this->load->view('global_body',$this->data);	
		}
		else if($action == 'receiveValidation')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email_valid', translate( 'Email' ),'trim|required|valid_email');
			if($this->form_validation->run())
			{
				$query	=	$this->users_global->sendValidationMail($this->input->post('email_valid'));
				if($query	==	'validationSended')
				{
					$this->url->redirect(array('login?notice='.$query)); // redirect to login
				}
				notice(fetch_notice_output($query));
			}
			$this->data['pageTitle']	=	translate( 'Receive activation mail' );
			set_page('title',$this->data['pageTitle']);
			$this->data['body']	=	$this->load->view('login/recovery_mailOption',$this->data,true);
			
			$this->load->view('header',$this->data);
			$this->load->view('global_body',$this->data);
		}
		else if($action == 'password_lost')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email_valid', translate( 'Email' ) ,'trim|required|valid_email');
			if($this->form_validation->run())
			{
				$query	=	$this->users_global->sendPassChanger($this->input->post('email_valid'));
				if($query	==	'validationSended')
				{
					$this->url->redirect(array('login?notice='.$query)); // redirect to login
				}
				notice(fetch_notice_output($query));
			}
			$this->data['pageTitle']	=	'Mot de passe perdu';
			set_page('title',$this->data['pageTitle']);
			$this->data['body']	=	$this->load->view('login/recovery_password',$this->data,true);
			
			$this->load->view('header',$this->data);
			$this->load->view('global_body',$this->data);
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
						$this->url->redirect(array('login?notice=accountActivationDone'));
					}
					else
					{
						$this->url->redirect(array('login?notice=accountActivationFailed'));
					}					
				}
				else
				{
					$this->url->redirect(array('error','code','activationFailed'));
				}
			}
			else
			{
				$this->url->redirect(array('error','code','unknowEmail'));
			}
		}
		else
		{
			$this->url->redirect(array('error','code','timeStampExhausted'));
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
				if( riake( 'allow_registration' , $this->data['options'] ) == "0")
				{
					$this->url->redirect(array('error','code','regisAndAssociatedFunLocked'));
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
						if($query == 'passwordChanged')
						{
							$this->url->redirect(array('login?notice='.$query));
						}
						else
						{
							notice(fetch_notice_output($query));
						}
					}
					$this->data['pageTitle']	=	translate( 'Changing Password - Tendoo' );
					set_page('title',$this->data['pageTitle']);
					$this->data['menu']	=	$this->load->view('login/recovery_menu',$this->data,true);
					$this->data['body']	=	$this->load->view('login/password_change',$this->data,true);
					
					$this->load->view('header',$this->data);
					$this->load->view('global_body',$this->data);
				}
				else
				{
					$this->url->redirect(array('error','code','activationFailed'));
				}
			}
			else
			{
				$this->url->redirect(array('error','code','unknowEmail'));
			}
		}
		else
		{
			$this->url->redirect(array('error','code','timeStampExhausted'));
		}
	}
	
}