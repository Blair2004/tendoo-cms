<?php 
class Admin extends Libraries
{  
	public function __construct()
	{
		parent::__construct();
		$this->instance		=	get_instance();
		$this->db			=	get_db();
		$this->data			=	array();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->load->library('users_global');
		$this->load->library('file');
		$this->load->library('visual_editor');
		$this->load->library('string');
		$this->load->library('menu');
		$this->load->library('gui');
		$this->load->library('roles');
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->adminConnection(); 			// 	Admin Users Libraries
		$this->loadLibraries();				//	Affecting Libraries */
		$this->construct_end();				// 	Fin du constructeur
		$this->loadOuputFile();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_core_vars( 'admin_icons' , $this->tendoo_admin->getAppIcon() , 'read_only' );
		set_core_vars( 'active_theme' , site_theme() );
		set_core_vars( 'options' , $this->options	=	get_meta( 'all' ) , 'read_only' );
		set_core_vars( 'tendoo_mode' , riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) , 'readonly' );
		// 1.4 For create_admin_menu && add_admin_menu
		set_core_vars( 'admin_menu_items' , array( 'menu' , 'about' , 'users' , 'controllers' , 'installer' , 'modules' , 'themes' , 'settings' , 'roles' , 'frontend' ) );
		set_core_vars( 'admin_menu_position' , array( 'after' , 'before' ) );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->__admin_widgets(); // USING core WiDGET and thoses defined through tepas
		$this->__creating_menus();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_page( 'description' , translate( 'Dashboard' ) . ' | '.get( 'core_version' ) );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		/*$this->tendoo_admin->system_not('Modifier vos param&ecirc;tre de s&eacute;curit&eacute;', 'Mettez vous &agrave; jour avec cette version', '#', '10 mai 2013', null);*/	
		// Set Default View	
		set_core_vars( 'inner_head' ,	$this->load->view('admin/inner_head',array() , true , false) , 'read_only' );		
		set_core_vars( 'lmenu' , $this->load->view('admin/left_menu' , array() , true , false) , 'read_only' );
	}
	private function construct_end()
	{
		// GLOBAL NOTICE
		set_core_vars( 'global_notice' , $this->tendoo_admin->get_global_info() , 'read_only' );
		foreach(get_core_vars( 'global_notice' ) as $gl)
		{
			$notice_s	=	strip_tags(fetch_notice_output($gl));
			switch($gl)  
			{
				case 'no_theme_selected' :
				$link	=	$this->url->site_url(array('admin','themes'));
				break;
				case 'no_page_set':
				$link	=	$this->url->site_url(array('admin','pages','create'));
				break;
				case 'no_main_page_set':
				$link	=	$this->url->site_url(array('admin','pages'));
				break;
				case 'no_priv_created':
				$link	=	$this->url->site_url(array('admin','system','create_role'));
				break;
				default :
				$link	=	'#';
				break;
			}
			$this->tendoo_admin->system_not( translate( 'System' ) , $notice_s, $link,null, null);
		}		
	}
	private function adminConnection()
	{
		(!$this->users_global->hasAdmin()) 	?  	$this->url->redirect(array('registration','superAdmin')): FALSE;
		(!$this->users_global->isConnected()) ? $this->url->redirect(array('login?ref='.urlencode($this->url->request_uri()))) : FALSE;
		(!$this->users_global->isAdmin())	?	$this->url->redirect(array('error','code','accessDenied')) : FALSE;
		$this->core_options	=	get_core_vars( 'options' );
	}
	private function loadLibraries()
	{	
		// Chargement des classes.
		$this->load->library('tendoo_admin');
		$this->load->library('pagination');
		$this->load->library('file',null,'file_2');
		$this->load->library('form_validation');
		$this->load->library('tendoo_sitemap');
		$this->load->library('tendoo_update');
		$this->load->library('stats');
		// Définition des balises d'erreur.
		if( get_meta( 'PUBLIC_PRIV_ACCESS_ADMIN' ) == '0') // If public priv is not allowed, not check current user priv class
		{
			$priv				=	$this->users_global->current('REF_ROLE_ID');
			if(!in_array($priv,$this->users_global->systemPrivilege()))
			{
				$cur_priv			=	$this->roles->get($priv);
				if($cur_priv[0]['IS_SELECTABLE'] == '1') // Is selectable
				{
					$this->url->redirect(array('error','code','accessDenied')); // Access denied for public priv admins.
				}
			}
		}
	}
	private function loadOuputFile()
	{
		css_push_if_not_exists('font');
		css_push_if_not_exists('app.v2');
		css_push_if_not_exists('tendoo_global');
		css_push_if_not_exists('fuelux');
		
		// js_push_if_not_exists('jquery');
		js_push_if_not_exists('app.min.vtendoo'); // _2
		js_push_if_not_exists('jquery-1.10.2.min');
		js_push_if_not_exists('underscore.1.6.0');
		js_push_if_not_exists('tendoo_loader');
		js_push_if_not_exists('tendoo_app');
	}
	private function __admin_widgets()
	{
		declare_admin_widget(array(
			"module_namespace"		=>	"system",
			"widget_namespace"		=>	"generals_stats",
			"widget_title"			=>	translate( 'Global Stats' ),
			"widget_content"		=>	$this->load->view('admin/others/widgets/generals-stats',null,true),
			"widget_description"	=>	translate( 'Show global stats' )
		));
		declare_admin_widget(array(
			"module_namespace"		=>	"system",
			"widget_namespace"		=>	"welcome",
			"widget_title"			=>	translate( 'Welcome message' ),
			"widget_content"		=>	$this->load->view('admin/others/widgets/welcome-message',null,true),
			"widget_description"	=>	translate( 'Show welcome message' )
		));
		declare_admin_widget(array(
			"module_namespace"		=>	"system",
			"widget_namespace"		=>	"app_icons",
			"widget_title"			=>	translate( 'Apps icons' ),
			"widget_content"		=>	$this->load->view('admin/others/widgets/app-icons',null,true),
			"widget_description"	=>	translate( 'Show available app icons' )
		));
		engage_tepas();
	}
	private function __creating_menus()
	{
		$this->menu->add_admin_menu_core( 'controllers' , array(
			'href'			=>		$this->instance->url->site_url('admin/controllers'),
			'icon'			=>		'fa fa-bookmark',
			'title'			=>		__( 'Controllers' )
		) );
		
		$this->menu->add_admin_menu_core( 'installer' , array(
			'title'			=>		__( 'Add an App' ),
			'icon'			=>		'fa fa-flask',
			'href'			=>		$this->instance->url->site_url('admin/installer')
		) );
		
		$this->menu->add_admin_menu_core( 'modules' , array(
			'title'			=>		__( 'Modules' ),
			'icon'			=>		'fa fa-puzzle-piece',
			'href'			=>		$this->instance->url->site_url('admin/modules')
		) );
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'title'			=>		__( 'Themes' ),
			'icon'			=>		'fa fa-columns',
			'href'			=>		$this->instance->url->site_url('admin/themes')
		) );
		
		if( current_user()->isSuperAdmin() )
		{
			$this->menu->add_admin_menu_core( 'users' , array(
				'title'			=>		__( 'Manage Users' ),
				'icon'			=>		'fa fa-users',
				'href'			=>		$this->instance->url->site_url('admin/users')
			) );
			$this->menu->add_admin_menu_core( 'users' , array(
				'title'			=>		__( 'Create a new User' ),
				'icon'			=>		'fa fa-users',
				'href'			=>		$this->instance->url->site_url('admin/users/create')
			) );
		}
		// Self settings
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'My Profile' ) , current_user( 'PSEUDO' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		$this->instance->url->site_url('admin/profile')
		) );
		/*$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'Edit profile' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		$this->instance->url->site_url('admin/profile/edit')
		) );*/
		
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Roles' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		$this->instance->url->site_url('admin/roles')
		) );
			$this->menu->add_admin_menu_core( 'roles' , array(
				'title'			=>		__( 'Create new role' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		$this->instance->url->site_url('admin/roles/create')
			) );
			$this->menu->add_admin_menu_core( 'roles' , array(
				'title'			=>		__( 'Roles permissions' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		$this->instance->url->site_url('admin/roles/permissions')
			) );
		
		$this->menu->add_admin_menu_core( 'settings' , array(
			'title'			=>		__( 'Settings' ),
			'icon'			=>		'fa fa-cogs',
			'href'			=>		$this->instance->url->site_url('admin/settings')
		) );
		
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
	// Tendoo 1.4
	public function profile( ) // use with GUI
	{
		$this->load->library( 'gui' );
		$this->load->library('form_validation');
		
		$text			=	'';
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
				$text	=	'&info=' . translate( 'Fields succefully updated, error occured during file upload, please check file weight and try again.' );
			}
		}
		$this->load->library('form_validation');
		if( $this->input->post('user_name') || $this->input->post('user_surname') || $this->input->post('user_state') || $this->input->post('user_town') || $this->input->post( 'bio' ) )
		{
			set_user_meta( 'name' , $this->input->post( 'user_name' ) );
			set_user_meta( 'surname' , $this->input->post( 'user_surname' ) );
			set_user_meta( 'state' , $this->input->post( 'user_state' ) );
			set_user_meta( 'town' , $this->input->post( 'user_town' ) );
			set_user_meta( 'bio' , $this->input->post( 'bio' ) ) ;
			
			$this->url->redirect( $this->url->site_url() . '?notice=profile_updated' . $text );
		}	
		if( $this->input->post( 'dashboard_theme' ) || $this->input->post( 'user_oldpass' ) || $this->input->post( 'user_newpass' ) || $this->input->post( 'user_confirmnewpass' ) )
		{
			if( $this->input->post( 'user_oldpass' ) )
			{
				$info = '';
				if( $this->input->post( 'user_newpass' ) == $this->input->post( 'user_confirmnewpass' ) )
				{
					$result		=	current_user()->updatePassword( $this->input->post( 'user_oldpass' ) , $this->input->post( 'user_newpass' ) );
					if( $result )
					{
						$info	=	'&info=' . __( 'Password has been changed' );
					}
					else
					{
						$info  	= 	'&info=' . __( 'Error occured while changing password. Check if your old password doesn\'t match the new one' );
					}
				}
				else
				{
					$info  	= 	'&info=' . __( 'Error occured while changing password. The new password and the confirmation doesn\'t match.' );
				}
			}
			set_user_meta( 'dashboard_theme' , between( 0 , 6 , $dashboard_theme = $this->input->post( 'dashboard_theme' ) ) ? $dashboard_theme : 0 );
			$this->url->redirect( $this->url->site_url() . '?notice=profile_updated' . $info );
		}
				
		set_page('title', riake( 'site_name' , $this->options ) . ' | '.ucfirst( current_user( 'PSEUDO' ) ).' &raquo; ' . translate( 'My Profile' ) );
		set_page('description', translate( 'My Profile' ) );
		
		set_core_vars( 'body' , $this->load->view('admin/profile/body',$this->data,true) );
		
		$this->load->view('admin/header',$this->data,false,false);
		$this->load->view('admin/global_body',$this->data,false,false);
	}
	public function inbox( $action = 'home' )
	{
		if( $action == 'home' ) 
		{
			
		}
		else if( $action == 'read' )
		{
		}
		else 
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
					notice('push',fetch_notice_output('error_occurred'));
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
	}
	// Public functions
	public function index()
	{
		js_push_if_not_exists('jquery-ui-1.10.4.custom.min');		
		js_push_if_not_exists('admin.index.intro');
		set_page('title', translate( 'Dashboard - Tendoo' ) );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_core_vars( 'lmenu' , $this->load->view('admin/left_menu',array(),true,false) , 'read_only' );
		set_core_vars( 'body' , $this->load->view('admin/index/body',array(),true,false) , 'read_only' );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->load->view('admin/header',array(),false,false);
		$this->load->view('admin/global_body',array(),false,false);
	}
	public function controllers($e = '',$f = '')
	{
		redirect_if_webapp_is_enalbled();
		
		current_user()->cannot( 'system@manage_controllers' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		
		if($e == '')
		{
			if(isset($_POST['controller']))
			{
				$result	=	$this->tendoo_admin->createControllers($_POST['controller']);
				if($result)
				{
					$ttError	=	0;
					foreach($result as $r)
					{
						if($r != "controler_created")
						{
							$ttError++;
						}
					}
					if($ttError > 0)
					{
						notice('push',tendoo_error($ttError.' ' . translate( 'errors founded, some controllers has been dismissed' ) ) );
					}
					notice('push',fetch_notice_output('controllers_updated'));
				}
			}
			css_push_if_not_exists('controller_style');
			js_push_if_not_exists('jquery.nestable');
			js_push_if_not_exists('tendoo_controllersScripts'); // ControllersSripts
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			set_core_vars( 'get_pages' ,	$this->tendoo->get_pages());
			set_core_vars( 'get_mod' , 		$modules	=	get_modules( 'filter_active_unapp' ) );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			set_page('title', translate( 'Manage controllers - Tendoo' ) );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			set_core_vars( 'body' , $this->load->view('admin/pages/body',$this->data,true,false) , 'ready_only' );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$this->load->view('admin/header',$this->data,null,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
	}
	public function modules($e = '',$a	=	1)
	{
		current_user()->cannot( 'system@manage_modules' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
				
		notice( 'push' , fetch_error_from_url() );
		if($e == '' || $e == 'main')
		{
			// Filter active APP while WebApp mode is enabled
			$argument	=	riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'webapp' ? 'filter_app' : 'all' ;
			
			set_core_vars( 'mod_nbr' , $mod_nbr	=	count( get_modules( $argument ) ) , 'read_only' );
			
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(
				10,
				$mod_nbr,
				1,
				"bg-color-blue fg-color-white",
				"bg-color-white fg-color-blue",
				$a, // as page
				$this->url->site_url(array('admin','modules','main')).'/'
			) , 'read_only' ); // Pagination
			
			if(get_core_vars( 'paginate' ) === FALSE): $this->url->redirect(array('error','code','page404')); endif; // Redirect if page is not valid
			
			set_core_vars( 'modules_list' ,	$result	= get_modules( $argument , $paginate[1] , $paginate[2] ) , 'read_only' );
			
			set_page('title', translate( 'Manage modules - Tendoo' ) );	
			
			set_core_vars( 'body' ,	$this->load->view('admin/modules/body',$this->data,true), 'read_only' );
			
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
	}
	public function uninstall($e ='',$namespace= '')
	{
		if($e == 'module')
		{
			current_user()->cannot( 'system@manage_modules' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules( 'module_namespace' ,'','required|trim|alpha_dash|min_length[1]');
			if($this->form_validation->run())
			{
				set_core_vars( 'module' ,	$module 	= get_modules( 'filter_namespace' , $this->input->post( 'module_namespace' ) ), 'read_only' );
				if( uninstall_module( $module[ 'namespace' ] ) )
				{
					$this->url->redirect(array('admin','modules','main',1,'module_uninstalled'));
				}
			}
			set_core_vars( 'module' , $module 	= get_modules( 'filter_namespace' , $namespace ), 'read_only' );
			if( $module )
			{
				set_page( 'title' , translate( 'Uninstall' ) . ' : '. $module[ 'name' ] . ' - ' . translate( 'Dashboard' ) );
				set_core_vars( 'body' ,	$this->load->view('admin/modules/uninstall',$this->data,true), 'read_only' );
				
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);
			}
			else
			{
				// $this->url->redirect(array('error','code','unknowModule'));
			}
		}
	}
	public function active($e,$namespace)
	{
		if($e	== 	'module')
		{
			current_user()->cannot( 'system@manage_modules' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
			
			$module	=	get_modules( 'filter_namespace' , $namespace );
			if($module)
			{
				if( active_module( $namespace ) ){
					$this->url->redirect( array( 'admin' , 'modules?info='.strip_tags( sprintf( translate( 'The module <strong>%s</strong> is now enabled' ) , $module['name'] ) ) ) );
				}
				$this->url->redirect(array('admin','modules?notice=error_occurred'));
			}
			$this->url->redirect(array('admin','index?notice=unknowModule'));
		}
		$this->url->redirect(array('admin','modules?notice=error_occurred'));
	}
	public function unactive($e,$namespace)
	{
		if($e	== 	'module')
		{
			current_user()->cannot( 'system@manage_modules' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
			
			$module	=	get_modules( 'filter_namespace' , $namespace );
			if($module)
			{
				if( unactive_module( $namespace ) ){
					$this->url->redirect(array('admin','modules?info='.strip_tags( sprintf( translate( 'The module <strong>%s</strong> is now disabled' ), $module['name'] ) ) ) );
				}
				$this->url->redirect(array('admin','modules?notice=error_occurred'));
			}
			$this->url->redirect(array('admin','index?notice=unknowModule'));
		}
		$this->url->redirect(array('admin','index?notice=error_occurred'));
	}
	public function open($e='',$a='',$b	= '')
	{
		if($e == '' || $a == '')
		{
			$this->url->redirect(array('error','code','page404'));
		}
		else if($e == 'modules')
		{
			// Si la re-écriture est activé, on réduit l'index. 
			// Sauf si dans l'url le fichier index.php est appelé.
			if(!in_array('index.php',$this->url->getSplitedUrl()))
			{
				$index	=	$this->url->getRewrite()	==	true ? 1 : 0;
			}
			else
			{
				$index	=	0;
			}
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$module					=	get_modules( 'filter_namespace' , $a );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			set_core_vars( 'opened_module'	, $module , 'read_only' );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			if(get_core_vars( 'opened_module' )) 
			{
				// Définition d'un titre par défaut
				set_page('title', $module[ 'namespace' ] . ' | ' . translate( 'Dashboard' ) ); 
				if(!is_file(MODULES_DIR.$module[ 'encrypted_dir' ].'/backend.php'))
				{
					$this->exceptions->show_error( translate( 'Several Error' ), translate( 'Some files required for this module are missing. Reinstalling this module may fix this issue' ) );
					exit;
				}
				include_if_file_exists(MODULES_DIR.$module[ 'encrypted_dir' ].'/library.php');
				include_once(MODULES_DIR.$module[ 'encrypted_dir' ].'/backend.php');
				$Parameters			=	$this->url->http_request(TRUE);
				if(array_key_exists(4-$index,$Parameters))
				{
					$Method				=	$Parameters[4-$index];
				}
				else
				{
					$Method			=	'index';
				}
				for($i = 0;$i < (5-$index);$i++)
				{
					array_shift($Parameters);
				}
				set_core_vars( 'interpretation', $interpretation =	$this->tendoo->interpreter($module[ 'namespace' ].'_backend',$Method,$Parameters), 'read_only' );
				if($interpretation == '404')
				{
					$this->url->redirect(array('error','code','page404'));
				}
				if(is_array($interpretation))
				{
					if(array_key_exists('MCO',$interpretation)) // MCO : module content only, renvoi uniquement le contenu du module et non les pied et tete de l'espace administration.
					{
						if($interpretation['MCO'] == TRUE)
						{
							$BODY				=	array();
							$BODY['RETURNED']	=	array_key_exists('RETURNED',$interpretation) ? 
								$interpretation['RETURNED'] : 
								$this->exceptions->show_error( translate( 'interpretation unclear' ) , translate( 'The interpretation returns a array that does not contain the "RETURNED" key. The module loaded return incorrect or incomplete array.' ) ); // If array key forget, get all content as interpretation.
							$BODY['MCO']		=	$interpretation['MCO'];
							set_core_vars( 'body' , $BODY );
							$this->load->view('admin/global_body',$this->data,false,false);
						}
					}
					else
					{
						$this->exceptions->show_error( translate( 'interpretation unclear' ) , translate( 'The interpretation returns a array that does not contain the "MCO" key. The module loaded return incorrect or incomplete array.' ) );
					}
				}
				else
				{
					$BODY['RETURNED']					=	$interpretation;
					$BODY['MCO']						=	FALSE;
					set_core_vars( 'body' , $BODY );					
					$this->load->view('admin/header',$this->data,false,false);
					$this->load->view('admin/global_body',$this->data,false,false);
				}

			}
			else
			{
				$this->url->redirect(array('admin/modules?notice=unknowModule'));
			}
		}
		else if($e == 'themes') /// unfinised
		{
			// Si la re-écriture est activé, on réduit l'index. 
			// Sauf si dans l'url le fichier index.php est appelé.
			if(!in_array('index.php',$this->url->getSplitedUrl()))
			{
				$index	=	$this->url->getRewrite()	==	true ? 1 : 0;
			}
			else
			{
				$index	=	0;
			}
			set_core_vars( 'opened_theme' , $opened_theme	=	$this->tendoo_admin->getThemes($a) );
			if($opened_theme == TRUE) // rather than counting
			{
				$active_theme		=	$opened_theme;
				set_page('title', $active_theme[0]['NAME'] . ' | ' . translate( 'Dashboard' ) ); 
				include_once(THEMES_DIR.$active_theme[0]['encrypted_dir'].'/library.php');
				include_once(THEMES_DIR.$active_theme[0]['encrypted_dir'].'/backend.php');
				$Parameters			=	$this->url->http_request(TRUE);
				if(array_key_exists(4-$index,$Parameters))
				{
					$Method				=	$Parameters[4-$index];
				}
				else
				{
					$Method			=	'index';
				}
				for($i = 0;$i < (5-$index);$i++)
				{
					array_shift($Parameters);
				}
				set_core_vars( 'interpretation' , $interpretation = 	$this->tendoo->interpreter($active_theme[0]['NAMESPACE'].'_theme_backend',$Method,$Parameters), 'read_only'  );
				//var_dump(set_core_vars( 'interpretation']);
				
			}
			else
			{
				$this->url->redirect(array('admin/themes?notice=unknowThemes'));
			}
		}
	}
	public function settings($action = 'main',$query_1='',$query_2='')
	{
		if($action	==	'main')
		{
			$this->load->library('form_validation');
			$this->load->helper('date');
			if($this->input->post('theme_style') !== FALSE || $this->input->post('newName') || $this->input->post('newLogo') !== FALSE  || $this->input->post('newHoraire') || $this->input->post('newFormat'))
			{
				$themeName	=	$newName = $newLogo = $newHoraire = $newFormat = '';
				if($this->users_global->isSuperAdmin()) // those Settings are now reserved to super admin
				{
					$this->form_validation->set_rules('newName', translate( 'Website name' ) ,'required|min_length[4]|max_length[40]');
					if($this->form_validation->run())
					{
						$newName	=	$this->tendoo_admin->editSiteName($this->input->post('newName'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('newLogo', translate( 'Website logo URL' ),'max_length[200]');
					if($this->form_validation->run())
					{
						$newLogo	=	$this->tendoo_admin->editLogoUrl($this->input->post('newLogo'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('newHoraire', translate( 'TimeZone' ),'required|min_length[1]|max_length[20]');
					if($this->form_validation->run())
					{
						$newHoraire	=	$this->tendoo_admin->editTimeZone($this->input->post('newHoraire'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('newFormat', translate( 'TimeFormat' ) ,'required|min_length[6]|max_length[10]');
					if($this->form_validation->run())
					{
						$newFormat	=	$this->tendoo_admin->editTimeFormat($this->input->post('newFormat'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('tendoo_mode', translate( 'Tendoo Mode' ) ,'required');
					if($this->form_validation->run())
					{
						$newFormat	=	set_meta( 'tendoo_mode' , $this->input->post( 'tendoo_mode' ) );
					}
				}
				if($newName || $newLogo || $newHoraire || $newFormat || $themeName)
				{
					$this->url->redirect(array('admin','setting?notice=done'));
				}
				else
				{
					notice('push',fetch_notice_output('error_occurred'));
				}
			}
			if( current_user()->can( 'system@manage_settings' ) ) // this Setting is now reserved to super admin
			{
				if($this->input->post('autoriseRegistration')) // Setting notice go here.
				{
					if( set_meta( 'allow_registration' , $this->input->post('allowRegistration') ) )
					{
						$this->url->redirect(array('admin','setting?notice=done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occurred'));
					}
				}
				if($this->input->post('allow_priv_selection_button')) // Setting notice go here.
				{
					if($this->tendoo_admin->editPrivilegeAccess($this->input->post('allow_priv_selection')))
					{
						$this->url->redirect(array('admin','setting?notice=done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occurred'));
					}
				}
				if($this->input->post('publicPrivAccessAdmin_button')) // Setting notice go here.
				{
					if($this->tendoo_admin->editAllowAccessToPublicPriv($this->input->post('publicPrivAccessAdmin')))
					{
						$this->url->redirect(array('admin','setting?notice=done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occurred'));
					}
				}
				if($this->input->post('appicons')) // Setting notice go here.
				{
					if($this->tendoo_admin->saveVisibleIcons($_POST['showIcon']))
					{
						$this->url->redirect(array('admin','setting?notice=done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occurred'));
					}
				}
			}
			if(array_key_exists('widget_action',$_POST) || array_key_exists('widget_namespace',$_POST))
			{
				$this->users_global->setAdminWidgets($_POST);
				$this->url->redirect(array('admin','setting?notice=done'));
			}
			set_core_vars( 'appIconApi' , $this->tendoo_admin->getAppIcon(), 'read_only' );
			set_page('title', translate( 'Website settings - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/setting/body',$this->data,true) , 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
	}
	public function themes($e	=	'main', $a	= 1)
	{
		current_user()->cannot( 'system@manage_themes' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		
		
			redirect_if_webapp_is_enalbled();
			if($e == 'main')
			{
				js_push_if_not_exists('jtransit/jquery.transit.min');
								
				set_page('title', translate( 'Manage themes - Tendoo' ) );
				set_core_vars( 'ttThemes' , $ttThemes	=	count( get_themes() ) , 'read_only' );
				set_core_vars( 'paginate' , $paginate	=	$this->tendoo->paginate(
					10,
					$ttThemes,
					1,
					"bg-color-blue fg-color-white",
					"bg-color-white fg-color-blue",
					$a, // as page
					$this->url->site_url(array('admin','modules','main')).'/'
				) , 'read_only' ); // Pagination
				set_core_vars( 'themes_list' ,	get_themes( 'list_all' , $paginate[1] , $paginate[2] ) , 'read_only' );
				set_core_vars( 'body' , $this->load->view('admin/themes/main',$this->data,true) , 'read_only' );
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);
			}
			else if($e == 'manage')
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('action', translate( 'Set as active theme' ) );
				$this->form_validation->set_rules('theme_namespace', translate( 'theme id' ) ,'required');
				if($this->form_validation->run())
				{
					if($this->input->post('action') == 'ADMITSETDEFAULT')
					{
						if( active_theme($this->input->post('theme_namespace') ) )
						{
							echo json_encode(array(
								'status'	=>		'success',
								'alertType'	=>		'notice',
								'message'	=>		translate( 'The theme has been set as active' ),
								'response'	=>		'theme_set'
							));
							return;
						}
						echo json_encode(array(
							'status'	=>		'warning',
							'alertType'	=>		'modal',
							'message'	=>		translate( 'Error occured, this theme can\'t been set as active' ),
							'response'	=>		'theme_set_failure'
						));
						return;
					}
				}
				$this->form_validation->set_rules('action', translate( 'Delete theme' ) );
				$this->form_validation->set_rules('theme_namespace',translate( 'Theme id' ),'required');
				if($this->form_validation->run())
				{
					if($this->input->post('action') == 'ADMITDELETETHEME')
					{
						$status		=	uninstall_theme( $this->input->post( 'theme_namespace' ) );
						if($status)
						{
							echo json_encode(array(
								'status'	=>		'success',
								'alertType'	=>		'notice',
								'message'	=>		translate( 'The theme has been deleted' ),
								'response'	=>		'theme_deleted'
							));
							return;
						}
						echo json_encode(array(
							'status'	=>		'warning',
							'alertType'	=>		'modal',
							'message'	=>		translate( 'Error occured, this theme can\'t be deleted' ),
							'response'	=>		'theme_deletion_failure'
						));
						return;
					}
				}
			}
			else
			{
				$this->url->redrect(array('error','code','page404'));
			}
		
	}
	public function installer()
	{
		current_user()->cannot( 'system@install_app' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		
		
			if(isset($_FILES['installer_file']))
			{
				$query	=	$this->tendoo_admin->_install_app( 'installer_file' );
				notice( 'push' , fetch_notice_output( $query ) );
			}
			if(isset($_POST['installer_link'],$_POST['downloadType']))
			{
				$query	=	$this->tendoo_admin->tendoo_url_installer( 
					$this->input->post('installer_link'),
					$this->input->post('downloadType')
				);
				notice( 'push' , fetch_notice_output( $query ) );
			}
			set_page('title', translate( 'Install App - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/installer/install',$this->data,true) , 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		
	}
	public function users( $options = '' , $x = 1 , $y = '' , $z = '' )
	{
		current_user()->cannot( 'system@manage_users' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		
		$this->load->library( 'gui' );
		if( $options == 'create' )
		{
			$this->form_validation->set_rules('admin_pseudo', translate( 'Pseudo' ),'trim|required|min_length[5]|max_length[15]');
			$this->form_validation->set_rules('admin_password', translate( 'Password' ),'trim|required|min_length[6]|max_length[30]');
			$this->form_validation->set_rules('admin_password_confirm',translate( 'Password Confirm' ),'trim|required|matches[admin_password]');
			$this->form_validation->set_rules('admin_sex',translate( 'Sex' ),'trim|min_length[3]|max_length[5]');
			$this->form_validation->set_rules('admin_password_email', translate( 'email' ) ,'trim|valid_email|required');
			$this->form_validation->set_rules('admin_privilege', translate( 'Select privilege' ),'trim|required');
			if($this->form_validation->run())
			{
				$creation_status	=	$this->users_global->createAdmin(
					$this->input->post('admin_pseudo'),
					$this->input->post('admin_password'),
					$this->input->post('admin_sex'),
					$this->input->post('admin_privilege'),
					$this->input->post('admin_password_email')
				);
				switch($creation_status)
				{
					case 'notAllowedPrivilege'	:
						notice('push',fetch_notice_output('adminCreationFailed'));
						break;
					case 'adminCreated'	:
						$this->url->redirect(array('admin','users?notice=adminCreated'));
						break;
					case 'adminCreationFailed'	:
						$this->url->redirect(array('admin','users','create?notice=adminCreationFailed'));
				}
			}
			set_core_vars( 'getPrivs' , $this->roles->get());
			set_page('title', translate( 'Manage Users - Tendoo' ) );
			set_core_vars( 'body' , $this->load->view('admin/users/create',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if( $options == 'edit' )
		{
			if($this->input->post('set_admin'))
			{
				$this->form_validation->set_rules('current_admin', translate( 'About current user' ),'trim|required|min_length[5]');
				$this->form_validation->set_rules('edit_priv', translate( 'Edit his privilege' ),'trim|required');
				$this->form_validation->set_rules('user_email',translate( 'Email' ),'trim|valid_email');
				if($this->form_validation->run())
				{
					$query	=	$this->users_global->setAdminPrivilege($this->input->post('edit_priv'),$this->input->post('current_admin'),$this->input->post('user_email'));
					notice('push',fetch_notice_output($query));
				}
			}
			if($this->input->post('delete_admin'))
			{
				$this->form_validation->set_rules('current_admin', translate( 'About current user' ),'trim|required|min_length[5]');
				$this->form_validation->set_rules('delete_admin', translate( 'Edit his privilege' ),'trim|required|min_length[1]');
				if($this->form_validation->run())
				{
					if($this->users_global->deleteSpeAdmin($this->input->post('current_admin')))
					{
						$this->url->redirect(array('admin','users?notice=adminDeleted'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occurred'));
					}
				}
			}
			
			set_core_vars( 'get_roles' ,	$this->roles->get());
			set_core_vars( 'adminInfo' ,	$adminInfo	=	$this->users_global->getSpeAdminByPseudo($x) );
			set_page('title', sprintf( translate( 'User profile : %s - Tendoo' ), $adminInfo['PSEUDO'] ) );
			
			set_core_vars( 'body' ,	$this->load->view('admin/users/edit',$this->data,true) , 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
			return true;			
		}
		else
		{
			set_core_vars( 'users_nbr' ,	count($this->users_global->getAdmin()));
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(10, get_core_vars( 'users_nbr' ),1,'bg-color-red fg-color-white','',$x,$this->url->site_url(array('admin','system','users')).'/') );
						
			set_core_vars( 'get_users' ,	$this->users_global->getAdmin($paginate[1],$paginate[2]) );
			
			set_page('title', translate( 'Manage users - Tendoo' ) );
			
			set_core_vars( 'body' ,	$this->load->view('admin/users/users',$this->data,true) );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
	}
	public function system($option	=	'index',$option_2 = 1)
	{
		// Is Super Admin ?
		
		(!$this->users_global->isSuperAdmin()) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : null;
		// Proceed
		if($option	==	'index')
		{
			set_page('title', translate( 'About - Tendoo' ) );
			set_core_vars( 'body' , $this->load->view('admin/system/body',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if($option ==  'createAdmin')
		{
		}
		else if($option ==  'create_role')
		{
		}
		else if($option	== 	'edit_priv')
		{
		
		}
		else if($option	==	'manage_actions')
		{
			if(!$this->tendoo_admin->has_roles())
			{
				$this->url->redirect(array('admin','system','create_role?notice=mustCreatePrivilege'));
			}
			set_core_vars( 'ttPrivileges' ,	$this->tendoo_admin->count_roles());
			set_core_vars( 'get_roles' ,	$this->roles->get() );
			set_core_vars( 'ttModules' , 	count( get_modules( 'all' ) ) );
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(10,get_core_vars( 'ttModules' ),1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','manage_actions')).'/') );
			set_core_vars( 'getModules' ,	get_modules( 'list_filter_active' , $paginate[1],$paginate[2] ) );
			set_page('title', translate( 'Manage Actions - Tendoo' ) );
			
			set_core_vars( 'body' ,	$this->load->view('admin/system/privileges_and_actions',$this->data,true));
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if($option	==	'ajax_manage_system_actions')
		{
			if(isset($_POST['QUERY']))
			{
				if($this->tendoo_admin->add_permission_role($_POST['QUERY'],'system'))
				{
					set_core_vars( 'state' ,	true);
					set_core_vars( 'body' ,	$this->load->view('admin/system/ajax_priv_action',$this->data));
				}
				else
				{
					set_core_vars( 'state' ,	false );
					set_core_vars( 'body' ,  $this->load->view('admin/system/ajax_priv_action',$this->data));
				}
			}
		}
		else if($option	==	'ajax_manage_common_actions')
		{
			if(isset($_POST['QUERY_2']))
			{
				if($this->tendoo_admin->add_permission_role_MTW($_POST['QUERY_2'],'modules'))
				{
					set_core_vars( 'state' ,	true);
					set_core_vars( 'body' ,	$this->load->view('admin/system/ajax_priv_action_2',$this->data));
				}
				else
				{
					set_core_vars( 'state' ,	false);
					set_core_vars( 'body' ,	$this->load->view('admin/system/ajax_priv_action_2',$this->data));
				}
			}
		}
		else if($option	==	'editAdmin')
		{
			
		}
		else if($option	==	'restore')
		{
			if($option_2	==	'soft')
			{				
				$this->form_validation->set_rules('admin_password', translate( 'Admin password' ),'trim|required|min_length[6]|max_length[30]');
				if($this->form_validation->run())
				{
					if($this->tendoo_admin->cmsRestore($this->input->post('admin_password')))
					{
						notice('push',fetch_notice_output('cmsRestored'));
					}
					else
					{
						notice('push',fetch_notice_output('cmsRestorationFailed'));
					}
				}
				set_page('title', translate( 'Soft system restore - Tendoo' ) );
				set_core_vars( 'body' ,	$this->load->view('admin/system/restore_soft',$this->data,true), 'read_only' );
				
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);	
			}
			else if($option_2	==	'hard') // hard
			{
				$this->form_validation->set_rules('admin_password', translate( 'Admin password' ),'trim|required|min_length[6]|max_length[30]');
				if($this->form_validation->run())
				{
				}
				set_page('title' , translate( 'Hard system restore - Tendoo' ) );
				set_core_vars( 'body' ,	$this->load->view('admin/system/restore_hard',$this->data,true) , 'read_only' );
				
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);	
			}
		}
		else if($option	== 'users')
		{
			
		}
		else
		{
			$this->url->redirect(array('page404'));
		}
		
	}
	public function roles( $option = '' , $input_1 = '' )
	{
		current_user()->cannot( 'system@manage_roles' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		
		if( ( is_numeric( $option ) && $option > 0 ) or $option ==	'' )
		{
			$option = !is_numeric( $option ) ? 1 : $option;
			
			set_core_vars( 'nbr_roles' ,	$this->roles->count());
			set_core_vars( 'pagination_data' ,	$paginate	=	$this->tendoo->doPaginate(10,get_core_vars( 'nbr_roles' ),$option , $this->url->site_url(array('admin','roles') ) ) );
			set_core_vars( 'get_roles' ,	$this->roles->get($paginate[ 'start' ],$paginate[ 'end' ]));
			set_page('title', translate( 'Roles - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/roles/list',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if($option == 'delete')
		{
			set_core_vars( 'deletion' ,	$this->roles->delete( $input_1 ) );
			$this->url->redirect(array('admin','roles?notice='. get_core_vars( 'deletion' )));			
		}
		else if($option == 'create')
		{
			if( ! method_exists($this,'form_validation'))
			{
				$this->load->library('form_validation');
			}
			$this->form_validation->set_rules('priv_description', translate( 'Privilege description' ) ,'trim|max_length[200]');
			$this->form_validation->set_rules('priv_name', translate( 'Privilege name' ),'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('is_selectable', translate( 'Available on registration' ),'trim|required|min_length[1]|max_length[1]');
			if($this->form_validation->run())
			{
				$data	=	$this->roles->create(
					$this->input->post('priv_name'),
					$this->input->post('priv_description'),
					$this->input->post('is_selectable')
				);
				if($data === TRUE)
				{
					$this->url->redirect(array('admin','roles?notice=done'));
				}
				else
				{
					notice('push',fetch_notice_output('error_occurred'));
				}
			}
						
			set_page( 'title' , sprintf( __( 'Create new role | Tendoo %s' ) , get( 'core_id' ) ) );
			set_core_vars( 'body' ,	$this->load->view('admin/roles/create',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if( $option == 'edit' )
		{
			$this->form_validation->set_rules('priv_description', translate( 'Privilege description' ) ,'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('priv_name', translate( 'Privilege name' ),'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('is_selectable', translate( 'Available on registration' ),'trim|required|min_length[1]|max_length[1]');
			if($this->form_validation->run())
			{
				$data	=	$this->roles->edit(
					$input_1,
					$this->input->post('priv_name'),
					$this->input->post('priv_description'),
					$this->input->post('is_selectable')
				);
				if($data === TRUE)
				{
					$this->url->redirect(array('admin','roles?notice=done'));
				}
				else
				{
					notice('push',fetch_notice_output('errorOccurred'));
				}
			}
			
			set_core_vars( 'get_role' , $this->roles->get( $input_1 ) );
			
			if(count(get_core_vars( 'get_role' )) == 0)
			{
				$this->url->redirect(array('error','code','privilegeNotFound' ) );
			}

			set_page( 'title' , sprintf( __( 'Edit role | Tendoo %s' ) , get( 'core_id' ) ) );
			set_core_vars( 'body' ,	$this->load->view('admin/roles/edit',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if( $option == 'permissions' )
		{
			if( ( $permissions	=	riake( 'roles_permissions' , $_POST ) ) == true && $role_id = $this->input->post( 'role_id' ) )
			{
				$this->roles->reset_permissions( $this->input->post( 'role_id' ) );
				
				foreach( force_array( $permissions ) as $_permission )
				{
					$this->roles->add_permission( $this->input->post( 'role_id' ) , $_permission ); 
				}
				
				$this->url->redirect( array( 'admin' , 'roles' , 'permissions?notice=role_permissions_saved' ) );
			}
			
			set_core_vars( 'get_roles' , $this->roles->get() );
			set_core_vars( 'get_modules' , get_modules( 'filter_active' ) );
			// Merge System Permissions to Modules Permissions, with valid permissions namespaces
			$modules	=	get_core_vars( 'get_modules' );	
			array_unshift( $modules ,	get_core_vars( 'tendoo_core_permissions' ) );
			set_core_vars( 'get_modules' , $modules );
			
			set_page( 'title' , __( 'Roles permissions - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/roles/permissions',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
	}
    public function tools($action	=	'index')
    {
		current_user()->cannot( 'system@manage_tools' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		
		if($action == 'index')
		{
        
        set_page('title', translate( 'Tools - Tendoo' ) );
        set_core_vars( 'body' ,	$this->load->view('admin/tools/body',$this->data,true) );
        $this->load->view('admin/header',$this->data,false,false);
        $this->load->view('admin/global_body',$this->data,false,false);
		}
		else if($action == 'calendar')
		{
			 
			set_page('title', translate( 'Tools - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/tools/calendar',$this->data,true) );
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
		else if($action == 'stats')
		{
			set_core_vars( 'Stats' ,	$this->instance->stats->tendoo_visit_stats() );
			set_core_vars( 'priv_stats' , 	$this->tendoo_admin->privilegeStats() );
			 
			
			set_page('title', translate( 'Tools > Stats - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/tools/stats',$this->data,true) );
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
		else if($action == 'seo')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('autoGenerate', translate( 'Generate automatic sitemap' ),'required');
			if($this->form_validation->run())
			{
				$this->tendoo_sitemap->create_sitemap_automatically();
			}
			set_core_vars( 'getSitemap' ,	$this->tendoo_sitemap->getSitemap() );
			
			
			set_page('title', translate( 'Tools > SEO - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/tools/seo',$this->data,true) );
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
		else
		{
			$this->url->redirect(array('error','code','page404'));
		}
    }
	public function ajax($option,$x	=	'',$y = '',$z = '')
	{
		if($option == 'setViewed')
		{
			$page	=	isset($_GET['page']) ? $_GET['page'] : '';
			$this->users_global->setViewed($page);
		}
		if($option == 'get_app_tab')
		{
			set_core_vars( 'appIconApi' ,	$this->tendoo_admin->getAppIcon() );
			$this->load->view('admin/ajax/get_app_tab',$this->data);
		}
		else if($option	==	'upController')
		{
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('REF_ROLE_ID'))== FALSE)
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('accessDenied') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_admin->upController($x);
				set_core_vars( 'type' ,	'success' );
				set_core_vars( 'notice' ,	notice('done') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option	== 'store_connect')
		{
			$site_options	=	$this->instance->meta_datas->get();
			if((int)$site_options[0]['CONNECT_TO_STORE'] == 1)
			{
				$this->tendoo_update->store_connect();
			}
			else
			{
				set_core_vars( 'type' ,	'wraning' );
				set_core_vars( 'notice' ,	tendoo_info( translate( 'Unabled to reach store' ) ) );
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option	== 'check_updates')
		{
			$this->tendoo_update->check();
		}
		else if($option	==	'toggleFirstVisit')
		{
			if(!$this->users_global->toggleFirstVisit())
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('accessDenied') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->load->view('admin/ajax/done',$this->data);
			}
		}
		else if($option	==	'toogleStoreAccess')
		{
			if(!$this->users_global->isSuperAdmin())
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('accessDenied') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_admin->toogleStoreConnexion();
				$this->load->view('admin/ajax/done',$this->data);
			}
		}
		else if($option	==	'restorePagesVisits')
		{
			// Restaure le statut de visite des pages.
			if($this->users_global->restorePagesVisit())
			{
				echo json_encode(array(
					'status'		=>		'success',
					'message'		=>		translate( 'Pages status has been restored. Introducing tour is now active' ),
					'alertType'		=>		'notice',
					'response'		=>		''
				));
			}
		}
		else if($option == 'sm_manual')
		{
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('REF_ROLE_ID'))== FALSE)
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('accessDenied') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_sitemap->create_sitemap_manually($this->input->post('sitemap'));
				set_core_vars( 'type' ,	'success' );
				set_core_vars( 'notice' , 	notice('done') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option == 'sm_remove')
		{
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('REF_ROLE_ID'))== FALSE)
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('accessDenied') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_sitemap->remove_sitemap();
				set_core_vars( 'type' ,	'success' );
				set_core_vars( 'notice',	notice('done') );
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option	== 'create_controller')
		{
			if($this->users_global->isSuperAdmin() === FALSE	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('REF_ROLE_ID')))
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('accessDenied') );
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			$this->form_validation->set_rules('page_name', translate( 'Controller name' ),'trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_cname',translate( 'Controller code name' ),'alpha_dash|trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_title', translate( 'Controller Title' ),'trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_module', translate( 'Bind module' ) ,'trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_priority', translate( 'Set as main controller' ),'trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_description', translate(' Controller Description' ) ,'trim|required|min_length[2]|max_length[2000]');
			$this->form_validation->set_rules('page_visible', translate( 'Controller visibility' ),'trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_parent', translate( 'Controller Parent' ),'trim|required|min_length[1]');
			$this->form_validation->set_rules('page_keywords', translate( 'Controller tags' ),'trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				set_core_vars( 'result' ,	$this->tendoo_admin->controller(
					$this->input->post('page_name'),
					$this->input->post('page_cname'),
					$this->input->post('page_module'),
					$this->input->post('page_title'),
					$this->input->post('page_description'),
					$this->input->post('page_priority'),
					'create',
					null,
					$this->input->post('page_visible'),
					$this->input->post('page_parent'),
					$this->input->post('page_link'),
					$this->input->post('page_keywords')
					
				) );	
				if(get_core_vars( 'result' ) == 'controler_created')
				{
					set_core_vars( 'get_pages' ,	$this->tendoo->get_pages() );
					$this->load->view('admin/ajax/controller_create_success',$this->data);
					// $this->url->redirect(array('admin/pages?notice=controler_created'));
				}
				else
				{
					$this->load->view('admin/ajax/controller_create_fail_2',$this->data);
					//notice('push',fetch_notice_output(set_core_vars( 'error']));
				}
			}
			else
			{
				$this->load->view('admin/ajax/controller_create_fail');
			}
		}
		else if($option == "edit_controller")
		{
			if(!$this->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('REF_ROLE_ID')))
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('error_occurred') );
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			$this->form_validation->set_rules('page_name', translate( 'Controller name' ),'trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_cname',translate( 'Controller code name' ),'alpha_dash|trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_title', translate( 'Controller Title' ),'trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_module', translate( 'Bind module' ) ,'trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_priority', translate( 'Set as main controller' ),'trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_description', translate(' Controller Description' ) ,'trim|required|min_length[2]|max_length[2000]');
			$this->form_validation->set_rules('page_visible', translate( 'Controller visibility' ),'trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_parent', translate( 'Controller Parent' ),'trim|required|min_length[1]');
			$this->form_validation->set_rules('page_keywords', translate( 'Controller tags' ),'trim|required|min_length[1]');
			$this->form_validation->set_rules('page_id', translate( 'Controller id' ),'required');
			if($this->form_validation->run())
			{
				set_core_vars( 'notice' ,	$this->tendoo_admin->controller(
					$this->input->post('page_name'),
					$this->input->post('page_cname'),
					$this->input->post('page_module'),
					$this->input->post('page_title'),
					$this->input->post('page_description'),
					$this->input->post('page_priority'),
					'update',
					$this->input->post('page_id'),
					$this->input->post('page_visible'),
					$this->input->post('page_parent'),
					$this->input->post('page_link'),
					$this->input->post('page_keywords')
				) );
				notice('push',fetch_notice_output(get_core_vars( 'notice' )));
				if(get_core_vars( 'notice' )	==	'controler_edited')
				{
					$this->load->view('admin/ajax/controller_edit_success',$this->data);
				}
				else
				{
					$this->load->view('admin/ajax/controller_edit_fail_2',$this->data);
				}
			}
			else
			{
				$this->load->view('admin/ajax/controller_edit_fail',$this->data);
			}
		}
		else if($option == "load_controller")
		{
			if(!$this->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('REF_ROLE_ID')))
			{
				set_core_vars( 'type' ,	'danger' );
				set_core_vars( 'notice' ,	notice('error_occurred') );
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			set_core_vars( 'getSpeController' ,	$this->tendoo_admin->get_controller($y) );
			$this->load->view('admin/ajax/load_controller',$this->data);
		}
		// Introducing set data Tendoo 1.2
		elseif($option	==	"set_meta")
		{
			if($_POST[ 'key' ] && $_POST[ 'value' ])
			{
				return json_encode(set_meta($_POST[ 'key' ], $_POST[ 'value' ]));
			}
			return 'false';
		}
		elseif($option	==	"get_meta")
		{
			if($this->input->post( 'key' ))
			{
				return json_encode(get_meta($this->input->post( 'key' )));
			}
			return 'false';
		}
		elseif($option	==	"set_user_meta")
		{
			if($_POST[ 'key' ] && $_POST[ 'value' ])
			{
				return json_encode(set_user_meta($_POST[ 'key' ], $_POST[ 'value' ]));
			}
			return 'false';
		}
		elseif($option	==	"get_user_meta")
		{
			if($this->input->post( 'key' ))
			{
				return json_encode(get_user_meta($this->input->post( 'key' )));
			}
			return 'false';
		}
		else if($option	==	"resetUserWidgetInterface")
		{
			return $this->users_global->resetUserWidgetInterface();
		}
	}
}