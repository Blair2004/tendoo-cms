<?php 
/**
*	UPDATED FOR TENDOO 0.99
**/
class Account extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->instance			=	get_instance();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->load->library('users_global');
		$this->load->library('file');
		$this->load->library('menu');
		if( current_user()->isAdmin() )
		{
			$this->load->library('tendoo_admin');
		}
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->file_2			=	new File;
		$this->data				=	array();
		// out put files
		css_push_if_not_exists('font');
		css_push_if_not_exists('app.v2');
		css_push_if_not_exists('tendoo_global');
		////->
		js_push_if_not_exists('jquery-1.9');
		js_push_if_not_exists('underscore.1.6.0');
		js_push_if_not_exists('app.min.vtendoo'); 
		js_push_if_not_exists('tendoo_loader');
		js_push_if_not_exists('tendoo_app');
		
		set_core_vars( 'options' , $this->options = get_meta( 'all' ) );
		
		$this->__creating_menus();
		
		if(!$this->users_global->isConnected())
		{
			$this->url->redirect(array('login?ref='.urlencode($this->url->request_uri())));
			exit;
		}
		set_core_vars( 'inner_head' , $this->load->view( 'admin/inner_head' ), false , true );
		set_core_vars( 'lmenu' , 	$this->data['left_menu']				=	$this->load->view('account/left_menu',$this->data,true) );
		set_core_vars( 'smallHeader' ,  $this->data['smallHeader']			=	$this->load->view('account/smallHeader',$this->data,true) );
	}
	private function __creating_menus()
	{
		$this->menu->add_admin_menu_core( 'profile' , array(
			'href'			=>		$this->instance->url->site_url('account'),
			'icon'			=>		'fa fa-home',
			'title'			=>		__( 'Profile' )
		) );
		
		$this->menu->add_admin_menu_core( 'messaging' , array(
			'title'			=>		__( 'Inbox' ),
			'icon'			=>		'fa fa-flask',
			'href'			=>		$this->instance->url->site_url('admin/installer'),
			'badge'			=>		$this->instance->users_global->getUnreadMsg()
		) );
		
		$this->menu->add_admin_menu_core( 'profile-settings' , array(
			'title'			=>		__( 'Edit profile' ),
			'icon'			=>		'fa fa-edit',
			'href'			=>		$this->instance->url->site_url('account/update')
		) );
		
		if( current_user()->isAdmin() )
		{
			$this->menu->add_admin_menu_core( 'dashboard' , array(
				'title'			=>		__( 'Dashboard' ),
				'icon'			=>		'fa fa-dashboard',
				'href'			=>		$this->instance->url->site_url('admin')
			) );
		}
		
		$this->menu->add_admin_menu_core( 'frontend' , array(
			'title'			=>		sprintf( __( 'Visit %s' ) , riake( 'site_name' , $this->options ) ) ,
			'icon'			=>		'fa fa-eye',
			'href'			=>		$this->instance->url->site_url('index')
		) );
		
		$this->menu->add_admin_menu_core( 'about' , array(
			'title'			=>		__( 'About' ) ,
			'icon'			=>		'fa fa-rocket',
			'href'			=>		$this->instance->url->site_url('admin/system')
		) );
		
	}
	public function index()
	{
		$user_pseudo 						=	$this->users_global->current('PSEUDO');
		set_page('title', riake( 'site_name' , $this->options ) . ' | '.ucfirst($user_pseudo).' &raquo; ' . translate( 'My Profile' ) );
		set_page('description', translate( 'My Profile' ) );
		$this->data['body']			=	$this->load->view('account/profile/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('avatar_usage','','trim|required');
		if($this->form_validation->run())
		{
			$status	=	$this->users_global->setAvatarSetting(
				$this->input->post(	'facebook_profile' ),
				$this->input->post(	'google_profile' ),
				$this->input->post( 'twitter_profile' ),
				$this->input->post( 'avatar_usage' ),
				'avatar_file'
			);
			if($status['error'] > 0)
			{
				$text	=	translate( 'Fields succefully updated, error occured during file upload, please check file weight and try again.' );
			}
			else
			{
				$text	=	translet( 'Avatar and fields updated' ); 
			}
			$this->url->redirect(array('account','update?info='.$text));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		if($this->input->post('user_name') && $this->input->post('user_surname'))
		{
			set_user_meta( 'name' , $this->input->post( 'user_name' ) );
			set_user_meta( 'surname' , $this->input->post( 'user_surname' ) );
			
			$this->url->redirect(array('account','update?notice=user_names_updated'));
		}
		if($this->input->post('user_state') && $this->input->post('user_town'))
		{
			set_user_meta( 'state' , $this->input->post( 'user_state' ) );
			set_user_meta( 'town' , $this->input->post( 'user_town' ) );
			$this->url->redirect(array('account','update?notice=user_geographical_data_updated'));
		}
		$user_pseudo 						=	$this->users_global->current('PSEUDO');
		set_page('title', riake( 'site_name' , $this->options ) .' | '.ucfirst($user_pseudo).' &raquo; ' . translate( 'Updating profile' ) );
		set_page('description', translate( 'Update a profile' ) );
		
		$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['body']			=	$this->load->view('account/update_prof/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function messaging($index	=	'home',$start= 1,$end = 1,$x	=	0)
	{
		$this->instance->date->timestamp();
		if($index 	== 'home')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('conv_id','Identifiant du message','required');
			if($this->form_validation->run())
			{
				if(is_array($_POST['conv_id']))
				{
					foreach($_POST['conv_id'] as $c)
					{
						$result	=	$this->users_global->deleteConversation($c);
						if($result	== false)
						{
							notice('push', translate( 'Error occured while deleting message, maybe this one doen\'t concern you or this message doen\'t exists' ) );
						}
						else
						{
							notice('push',fetch_notice_output('done'));
						}
					}
				}
				else
				{
					$result	=	$this->users_global->deleteConversation($_POST['conv_id']);
					if($result	== false)
					{
							notice('push', translate( 'Error occured while deleting message, maybe this one doen\'t concern you or this message doen\'t exists' ) );
					}
					else
					{
						notice('push',fetch_notice_output('done'));
					}
				}
			}
			$user_pseudo 						=	$this->users_global->current('PSEUDO');
			set_page('title', riake( 'site_name' , $this->options ) .' | '.ucfirst($user_pseudo).' &raquo; ' . translate( 'Messaging' ) );
			set_page('description', sprintf( translate( '%s messaging' ) , $user_pseudo ) );
			$this->data['ttMessage']	=	$this->users_global->countMessage();
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttMessage'],1,'ClasseOn','ClasseOff',$start,$this->url->site_url(array('account','messaging','home')).'/',null);
			$this->data['getMessage']	=	$this->users_global->getMessage($this->data['paginate'][1],$this->data['paginate'][2]);$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/body',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
		else if($index	== 'write')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('receiver', translate( 'Receiver pseudo' ),'trim|required|min_length[5]|max_length[15]');
			$this->form_validation->set_rules('content', translate( 'Message content' ),'trim|required|min_length[3]|max_length[1200]');
			if($this->form_validation->run())
			{
				$result	=	$this->users_global->write(
					$this->input->post('receiver'),
					$this->input->post('content')
				);
				if($result	==	'posted')
				{
					$this->url->redirect(array('account','messaging','home'));
				}
				else
				{
					notice('push',fetch_notice_output('error-occured'));
				}
			}
			
			$user_pseudo 						=	$this->users_global->current('PSEUDO');
			set_page('title', riake( 'site_name' , $this->options ) .' | '.ucfirst($user_pseudo).' &raquo;' . translate( 'Write a new message' ) );
			set_page('description','Tendoo Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/write',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		
		}
		else if($index	==	'open')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('reply','Contenu du message','trim|required|min_length[3]|max_length[1200]');
			$this->form_validation->set_rules('convid','Identifiant de la convesation','trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				$result	=	$this->users_global->addPost($this->input->post('convid'),$this->input->post('reply'));
				if($result	==	true)
				{
					notice('push',fetch_notice_output('done'));
				}
				else
				{
					notice('push', translate( 'This message couldn\'t be posted because you don\'t have access or this message is no more availble' ) );
				}
			}
			$this->users_global->editStatus($start);
			$this->data['ttMsgContent']	=	$this->users_global->countMsgContent($start);
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttMsgContent'],1,'bg-color-red fg-color-white','bg-color-blue',$end,$this->url->site_url(array('account','messaging','open',$start)).'/',$ajaxis_link=null);
			if($this->data['paginate'][3]	==	false)
			{
				$this->url->redirect(array('page404'));
			}
			$this->data['getMsgContent']=	$this->users_global->getMsgContent($start,$this->data['paginate'][1],$this->data['paginate'][2]);
			
			$user_pseudo 						=	$this->users_global->current('PSEUDO');
			set_page('title', riake( 'site_name' , $this->options ) .' | '.ucfirst($user_pseudo).' &raquo;' . translate( 'message reading' ) );

			set_page('description','Tendoo Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/read',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
	}
	public function profile($userPseudo)
	{
		if($this->users_global->current('PSEUDO') == $userPseudo)
		{
			$this->url->redirect(array('account'));
		}
		$user	=	$this->users_global->get_user_using_pseudo($userPseudo);
		if($user)
		{
			$this->data['user'] =& $user;
			
			set_page('title', riake( 'site_name' , $this->options ) .' | '.ucfirst($user[0]['PSEUDO']).' &raquo; ' . translate( 'user profile' ) );
			set_page('description',$user[0]['PSEUDO'].' - Profile');
			
			$this->data['body']			=	$this->load->view('account/profile/user_profil_body',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/user_profile_global_body',$this->data);
		}
		else
		{
			$this->url->redirect(array('error','code','unknowProfil'));
		}
	}
	public function ajax($action)
	{
		$this->load->library('form_validation');
		$result	= array(
			'status'	=>	'warning',
			'message'	=>	translate( 'Error occured during the operation' ),
			'alertType'	=>	'modal',
			'response'	=>	array()
		);
		if($action == 'setTheme')
		{
			$this->form_validation->set_rules('theme_style','Le champ du thème','required|min_length[1]|max_length[2]');
			if($this->form_validation->run())
			{
				if($this->users_global->editThemeStyle($this->input->post('theme_style')))
				{
					$result	=	 array(
						'status'	=>	'success',
						'message'	=>	translate( 'theme options successfully saved' ),
						'alertType'	=>	'notice',
						'response'	=>	array(),
						'exec'		=>	'function(){
							document.location = "'.$this->url->site_url(array('account','update')).'";
						}'
					);
				}
			}
		}
		else if($action == 'setPassword')
		{
			$this->form_validation->set_rules('user_oldpass','','required|min_length[6]');
			$this->form_validation->set_rules('user_newpass','','required|min_length[6]|matches[user_confirmnewpass]');
			$this->form_validation->set_rules('user_confirmnewpass','','required');
			if($this->form_validation->run())
			{
				$result	=	 array(
					'status'	=>	'warning',
					'message'	=>	translate( 'Error occured, check if the old password is correct' ) ,
					'alertType'	=>	'modal',
					'response'	=>	array()
				);
				if($this->input->post('user_oldpass') == $this->input->post('user_newpass'))
				{
					$result	=	 array(
						'status'	=>	'warning',
						'message'	=>	translate( 'The old password and the new shouldn\'t match' ),
						'alertType'	=>	'modal',
						'response'	=>	array()
					);
				}
				else
				{
					if($this->users_global->updainitsword($this->input->post('user_oldpass'),$this->input->post('user_newpass')))
					{
						$result	=	 array(
							'status'	=>	'success',
							'message'	=>	translate( 'Editing password success' ),
							'alertType'	=>	'notice',
							'response'	=>	array()
						);
					}
				}
			}
			else
			{
				$result	=	 array(
					'status'	=>	'warning',
					'message'	=>	translate( 'An error occured, your password must have more than 5 caracters and it must match "Password confirm" field'),
					'alertType'	=>	'modal',
					'response'	=>	array()
				);
			}
		}
		elseif($action	==	"set_user_meta")
		{
			if($_POST[ 'key' ] && $_POST[ 'value' ])
			{
				if(json_encode(set_user_meta($_POST[ 'key' ], $_POST[ 'value' ])))
				{
					$result	= array(
						'status'	=>	'success',
						'message'	=>	translate( 'items successfully updated' ),
						'alertType'	=>	'notice',
						'response'	=>	array()
					);
				}
			}
		}
		elseif($action	==	"get_user_meta")
		{
			if($this->input->post( 'key' ))
			{
				$result	= json_encode(get_user_meta($this->input->post( 'key' )));
			}
			$result		= '{}';
		}
		echo json_encode($result);
	}
}