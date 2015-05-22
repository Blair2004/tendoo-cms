<?php 
class Admin extends Libraries
{  
	public function __construct()
	{
		parent::__construct();
		$this->instance		=	get_instance();
		$this->db			=	get_db();
		$this->data			=	array();
		$this->options		=	get_core_vars( 'options' );
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->libraries_loader();				//	Affecting Libraries */
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_core_vars( 'admin_menu_items' , 
			array( 'dashboard' , 'menu' , 'about' , 'users' , 'controllers' , 'installer' , 'modules' , 'themes' , 'settings' , 'roles' , 'frontend' ) 
		); // @since 1.4
		
		set_core_vars( 'admin_menu_position' , array( 'after' , 'before' ) ); // @since 1.4
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		
		$this->__admin_widgets(); // USING core WiDGET and thoses defined through init
		$this->__creating_menus();
		
		trigger_inits(); // For Core menu extension, they are called after default menu.
		
		$this->notices_loader();
		$this->file_loader();
		
		if( get_user_meta( 'tendoo_status' ) == false && get_instance()->url->method() != 'about' ): 
			get_instance()->url->redirect( array( 'admin' , 'about' ) );
		endif;
		
		
		/**
		 * 	Declare Notices : Notices are internal(system) or module/theme alert.
		**/
		set_core_vars( 'tendoo_notices' , trigger_filters( 'declare_notices' , array( get_core_vars( 'default_notices' ) ) ) ); // @since 1.4		
		set_page( 'description' , translate( 'Dashboard' ) . ' | '.get( 'core_version' ) );
		
		/*$this->tendoo_admin->system_not('Modifier vos param&ecirc;tre de s&eacute;curit&eacute;', 'Mettez vous &agrave; jour avec cette version', '#', '10 mai 2013', null);*/	
		// Set Default View	
		set_core_vars( 'inner_head' ,	$this->load->view('admin/inner_head', array() , true , false) , 'read_only' );		
		set_core_vars( 'lmenu' , $this->load->view('admin/left_menu' , array() , true , false) , 'read_only' );
	}
	function test()
	{
		$cu		=	new CustomQuery( array(
			'namespace'		=>	'custom-post',
			'meta'			=>	array( 'image' , 'settings' )
		) );
		
		$cu->define_taxonomy( 'category' , __( 'Category' ) , array(
			'is_hierarchical'	=>	true
		) );
		
		// var_dump( $cu->set_taxonomy( 'category' ,	__( 'Custom Category 4' ) , __( 'Custom Content 4' ) , 15 ) );
		
		/*$set	=	$cu->set( 'Hello World' , 'Contenu' , array(
			'image'		=>	'#image',
			'settings'		=>	'Reglages'
		) , array(
			'category'	=>	array( 1 )
		) , $mode = 'set' , $identifier = 0 , $filter = 'as_id' );
		
		var_dump( $set );*/
		
		/**$set	=	$cu->set( 'Titre' , 'Contenu' , array(
			'image'		=>	'#image',
			'settings'		=>	'Reglages'
		) );
		var_dump( $set );
		**/
		/*$get	=	$cu->get( array( 
			'where'	=>	array( 'taxonomy_id'	=>	1 )
		) );
		var_dump( $get );*/
		
		// var_dump( $cu->delete_taxonomies( 2 ) );
		
		/*$tax	=	$cu->get_taxonomies( 'category' , $get[0][ 'ID' ] , 'as_query_id' );
		
		var_dump( $tax );*/
	}
	private function notices_loader()
	{
		// GLOBAL NOTICE
		set_core_vars( 'global_notice' , $this->tendoo_admin->get_global_info() , 'read_only' );
		foreach( get_core_vars( 'global_notice' ) as $notice_message)
		{
			$notice_s	=	strip_tags(fetch_notice_output($notice_message));
			switch( $notice_message )  
			{
				case 'no_theme_selected' :
				$link	=	$this->url->site_url(array('admin','themes'));
				break;
				case 'no-controller-set':
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
			$this->admin_notices->push( $notice_message , $link );
		}		
	}
	private function libraries_loader()
	{	
		$this->load->library('users_global');
		$this->load->library('file');
		$this->load->library('visual_editor');
		$this->load->library('string');
		$this->load->library('menu');
		$this->load->library('gui');
		$this->load->library('roles');
		$this->load->library( 'admin_notices' );
		// Admin Connections
		(!$this->users_global->hasAdmin()) 	?  	$this->url->redirect(array('registration','superAdmin')): FALSE;
		(!$this->users_global->isConnected()) ? $this->url->redirect(array('login?ref='.urlencode($this->url->request_uri()))) : FALSE;
		(!$this->users_global->isAdmin())	?	$this->url->redirect(array('error','code','accessDenied')) : FALSE;
		$this->core_options	=	get_core_vars( 'options' );
		// Chargement des classes.
		$this->load->library('tendoo_admin');
		$this->load->library('pagination');
		$this->load->library('file',null,'file_2');
		$this->load->library('form_validation');
		// $this->load->library('tendoo_sitemap');
		$this->load->library('tendoo_update');
		// $this->load->library('stats');
		$this->load->library('tdate' , 'date' );
		// Définition des balises d'erreur.
		if( get_meta( 'PUBLIC_ROLE_ACCESS_ADMIN' ) == '0') // If public priv is not allowed, not check current user priv class
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
	private function file_loader()
	{
		css_push_if_not_exists('font');
		css_push_if_not_exists('../admin-lte/bootstrap/css/bootstrap.min');
		css_push_if_not_exists('../admin-lte/font-awesome/font-awesome.4.3.0.min');
		css_push_if_not_exists('../admin-lte/code.ionic/ionicons.min');
		css_push_if_not_exists('../admin-lte/dist/css/AdminLTE.min');
		css_push_if_not_exists('../admin-lte/dist/css/skins/_all-skins.min');
		css_push_if_not_exists('tendoo_global');
		
		js_push_if_not_exists('../admin-lte/plugins/jQuery/jQuery-2.1.3.min');
		js_push_if_not_exists('../admin-lte/bootstrap/js/bootstrap.min');
		
		js_push_if_not_exists('../admin-lte/plugins/datatables/jquery.dataTables');
		js_push_if_not_exists('../admin-lte/plugins/datatables/dataTables.bootstrap');		
		js_push_if_not_exists('../admin-lte/plugins/slimScroll/jquery.slimScroll.min');
		js_push_if_not_exists('../admin-lte/plugins/fastclick/fastclick.min');
		js_push_if_not_exists('../admin-lte/dist/js/app.min');
		
		js_push_if_not_exists('heartcode-canvasloader-min-0.9.1');
		js_push_if_not_exists('underscore.1.6.0');
		js_push_if_not_exists('tendoo_app');
		
		return;		
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
	}
	private function __creating_menus()
	{
		$this->menu->add_admin_menu_core( 'dashboard' , array(
			'href'			=>		$this->instance->url->site_url('admin'),
			'icon'			=>		'fa fa-dashboard',
			'title'			=>		__( 'Dashboard' )
		) );
		
		if( current_user()->can( 'system@manage_media' ) )
		{
			$this->menu->add_admin_menu_core( 'media' , array(
				'title'			=>		__( 'Media Library' ),
				'icon'			=>		'fa fa-image',
				'href'			=>		$this->instance->url->site_url('admin/media')
			) );
		}

		// Controller has been deprecated for "menu" instead
			
		if( current_user()->can( 'system@install_app' ) )
		{
			$this->menu->add_admin_menu_core( 'installer' , array(
				'title'			=>		__( 'Install Apps' ),
				'icon'			=>		'fa fa-flask',
				'href'			=>		$this->instance->url->site_url('admin/installer')
			) );
		}
		
		if( current_user()->can( 'system@manage_modules' ) )
		{
			$this->menu->add_admin_menu_core( 'modules' , array(
				'title'			=>		__( 'Modules' ),
				'icon'			=>		'fa fa-puzzle-piece',
				'href'			=>		$this->instance->url->site_url('admin/modules')
			) );
		}
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'title'			=>		__( 'Themes' ),
			'icon'			=>		'fa fa-columns',
			'href'			=>		$this->instance->url->site_url('admin/themes')
		) );
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'href'			=>		$this->instance->url->site_url('admin/controllers'),
			'icon'			=>		'fa fa-bookmark',
			'title'			=>		__( 'Menus' )
		) );
		//
		
		
		if( current_user()->can( 'system@manage_users' ) )
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
				
		if( current_user()->can( 'system@manage_roles' ) )
		{
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
		}
		
		if( current_user()->can( 'system@manage_settings' ) )
		{
			$this->menu->add_admin_menu_core( 'settings' , array(
				'title'			=>		__( 'Settings' ),
				'icon'			=>		'fa fa-cogs',
				'href'			=>		$this->instance->url->site_url('admin/settings')
			) );
		}
		
		$this->menu->add_admin_menu_core( 'frontend' , array(
			'title'			=>		sprintf( __( 'Visit %s' ) , riake( 'site_name' , $this->options ) ) ,
			'icon'			=>		'fa fa-eye',
			'href'			=>		$this->instance->url->site_url('index')
		) );
		
		$notices_nbr		=		0;
		$notices_nbr		+=		( get_user_meta( 'tendoo_status' ) == false ) ? 1 : 0;
		
		$this->menu->add_admin_menu_core( 'about' , array(
			'title'			=>		__( 'About' ) ,
			'icon'			=>		'fa fa-rocket',
			'href'			=>		$this->instance->url->site_url('admin/about'),
			'notices_nbr'	=>		 $notices_nbr
		) );
		
	}
	// Tendoo 1.4
	public function about( $option	=	'index',$option_2 = 1)
	{
		set_user_meta( 'tendoo_status' , 1 );
		set_page('title', translate( 'About - Tendoo' ) );
		$this->load->the_view( 'admin/about/body' );
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
					$this->url->redirect( array( 'admin' , 'modules?info='.htmlentities( sprintf( translate( 'The module %s is now enabled' ) , $module['name'] ) ) ) );
				}
				$this->url->redirect(array('admin','modules?notice=error-occured'));
			}
			$this->url->redirect(array('admin','index?notice=unactive-or-unknow-module'));
		}
		$this->url->redirect(array('admin','modules?notice=error-occured'));
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
				set_core_vars( 'notice' ,	notice('error-occured') );
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
				set_core_vars( 'notice' ,	notice('error-occured') );
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
	public function controllers($e = '',$f = '')
	{
		redirect_if_webapp_is_enabled();
		
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
			set_core_vars( 'get_pages' ,	$this->controller->get());
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
		set_page('title', translate( 'Install Apps - Tendoo' ) );
		
		$this->load->the_view('admin/installer/install' );		
	}
	public function modules($e = '',$a	=	1)
	{
		current_user()->cannot( 'system@manage_modules' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
				
		notice( 'push' , fetch_notice_from_url() );
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
			
			if(get_core_vars( 'paginate' ) === FALSE): $this->url->redirect(array('error','code','page-404')); endif; // Redirect if page is not valid
			
			set_core_vars( 'modules_list' ,	$result	= get_modules( $argument , $paginate[1] , $paginate[2] ) , 'read_only' );
			
			set_page('title', translate( 'Manage modules - Tendoo' ) );	
			
			$this->load->the_view( 'admin/modules/body' );
		}
	}
	public function open($e='',$a='',$b	= '')
	{
		if($e == 'modules')
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
			$module					=	get_modules( 'filter_active_namespace' , $a );
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
					$this->url->redirect(array('error','code','page-404'));
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
							
							// If current module require GUI, let GUI handle header and global_body
							if( !in_array( 'gui' , riake( 'require' , $module , array() ) ) )
							{
								$this->load->view('admin/global_body',$this->data,false,false);
							}
						}
					}
					else
					{
						$this->exceptions->show_error( translate( 'interpretation unclear' ) , translate( 'The interpretation returns a array that does not contain the "MCO" key. The module loaded return incorrect or incomplete array.' ) );
					}
				}
				else
				{
					// If nothing is returned, tendoo foresee that module use GUI library.
					if( !is_null( $interpretation ) )
					{
						$BODY['RETURNED']					=	$interpretation;
						$BODY['MCO']						=	FALSE;
						
						set_core_vars( 'body' , $BODY );
						
						// If current module require GUI, let GUI handle header and global_body
						if( !in_array( 'gui' , riake( 'require' , $module , array() ) ) )
						{
							$this->load->view('admin/header',$this->data,false,false);
							$this->load->view('admin/global_body',$this->data,false,false);
						}
					}
				}

			}
			else
			{
				$this->url->redirect(array('admin/modules?notice=unactive-or-unknow-module'));
			}
		}
		else
		{
			$this->url->redirect( array( 'error' , 'code' , 'page-404' ) );
		}
	}
	public function options( $page = 'index' )
	{
		// Check Permissions
		// current_user()->cannot( 'system@manage_settings' ) ? $this->url->redirect( array( 'admin?notice=accessDenied' ) ) : false ;
		// We trust interface can handle permissions.
		// IF he can...
		if( $page == 'save' )
		{
			if( $this->tdate->timestamp() < riake( 'gui_saver_expiration_time' , $_POST , $this->tdate->timestamp() - 1 ) )
			{
				if( in_array( $this->input->post( 'gui_saver_use_namespace' ) , array ( 'false' , false ) , true ) )
				{
					foreach( $_POST as $key => $value )
					{
						// We do not save gui fields
						if( ! in_array( $key , array( 'gui_saver_option_namespace' , 'gui_saver_ref' , 'gui_saver_expiration_time' , 'gui_saver_use_namespace' ) ) )
						{
							set_meta( $key , $value );
						}
					}
				}
				else
				{
					foreach( $_POST as $key => $value )
					{
						// We do not save gui fields
						if( ! in_array( $key , array( 'gui_saver_option_namespace' , 'gui_saver_ref' , 'gui_saver_expiration_time' , 'gui_saver_use_namespace' ) ) )
						{
							$saved_meta				=	get_meta( riake( 'gui_saver_option_namespace' , $_POST , 'default_options' ) );
							$saved_meta[ $key ]		=	$value;
							if( $option_namespace	=	 riake( 'gui_saver_option_namespace' , $_POST ) ){
								set_meta( $option_namespace , $saved_meta );
							}
						}
					}
				}
				$this->url->redirect( urldecode( riake( 'gui_saver_ref' , $_POST , $this->url->site_url( array( 'admin' ) ) ) ) . '?notice=done' );
			}
			$this->url->redirect( urldecode( riake( 'gui_saver_ref' , $_POST , $this->url->site_url( array( 'admin' ) ) ) ) . '?notice=form-expired' );
		}
	}
	public function posttype( $namespace , $page = 'list' , $id = 0 , $taxonomy_arg1 = 'list' , $taxonomy_arg2 = 0 )
	{
		if( $this->current_posttype	= riake( $namespace , get_core_vars( 'posttypes' ) ) )
		{
			set_core_vars( 'current_posttype' , $this->current_posttype );
			set_core_vars( 'post_namespace' , $namespace );
						
			if( $page === 'list' )
			{
				$id			=	$id 	=== 0 ? 1 : $id;
				$post_limit	=	20;
				$post_nbr	=	count( $this->current_posttype->get() );
				
				$pagination	=	pagination_helper( 
					$post_limit , 
					$post_nbr , 
					$id , 
					get_instance()->url->site_url( array( 'admin' , 'posttype' , $namespace , 'list' ) ),
					get_instance()->url->site_url( array( 'error' , 'code' , 'page-404' ) ) 
				);
				
				set_core_vars( 'pagination_data' , $pagination );
				
				$post			=	$this->current_posttype->get( array(
					'limit'		=>	array( 
						'start' 	=> riake( 'start' , $pagination ),
						'end' 		=> riake( 'end' , $pagination ) 
					)
				) );
				
				set_core_vars( 'post' , $post );				
				set_core_vars( 'post_list_label' , $this->current_posttype->posts_list_label );
				
				set_page( 'title' ,  $this->current_posttype->posts_list_label , 'Post List Label [#Unexpected error occured]' );
				$this->load->the_view( 'admin/posttypes/list' , false );
			}
			else if( $page === 'new' )
			{
				set_core_vars( 'post_namespace' , $namespace );
				set_core_vars( 'new_post_label' , $this->current_posttype->new_post_label );
				
				$this->load->library( 'form_validation' );
				$this->form_validation->set_rules( 'post_title' , __( 'Post title' ) );
				
				if( $this->form_validation->run() )
				{
					$return		=	$this->current_posttype->set( 
						$this->input->post( 'post_title' ) , 
						$this->input->post( 'post_content' ) , 
						riake( 'post_meta' , $_POST ),
						riake( 'post_taxonomy' , $_POST ),
						$this->input->post( 'post_status' ),
						$this->input->post( 'post_parent' ),
						$status = 'set' 
					);					
					
					if( riake( 'msg' , $return ) === 'custom-query-saved' )
					{
						get_instance()->url->redirect( 
							array( 'admin' , 'posttype' , $namespace , 'edit' , riake( 'id' , $return ) . '?notice=' . riake( 'msg' , $return ) )
						);
					}
					
					get_instance()->notice->push_notice( fetch_notice_output( riake( 'msg' , $return ) ) );
				}			
				
				set_page( 'title' ,  $this->current_posttype->new_post_label , 'Post List Label [#Unexpected error occured]' );
				$this->load->the_view( 'admin/posttypes/create' , false );
			}
			else if( $page === 'edit' )
			{
				set_core_vars( 'post_namespace' , $namespace );
				set_core_vars( 'new_post_label' , $this->current_posttype->new_post_label );
				
				$this->load->library( 'form_validation' );
				$this->form_validation->set_rules( 'post_title' , __( 'Post title' ) );
				
				if( $this->form_validation->run() )
				{
					$return		=	$this->current_posttype->update( 
						$this->input->post( 'post_title' ) , 
						$this->input->post( 'post_content' ) , 
						riake( 'post_meta' , $_POST ),
						riake( 'post_taxonomy' , $_POST ),
						$this->input->post( 'post_status' ),
						$this->input->post( 'post_parent' ),
						$status = 'publish' , 
						$id 
					);					
					
					if( riake( 'msg' , $return ) === 'custom-query-saved' )
					{
						get_instance()->url->redirect( 
							array( 'admin' , 'posttype' , $namespace , 'edit' , riake( 'id' , $return ) . '?notice=' . riake( 'msg' , $return ) )
						);
					}
					
					get_instance()->notice->push_notice( fetch_notice_output( riake( 'msg' , $return ) ) );
				}		
				
				set_core_vars( 'post' , farray( $this->current_posttype->get( array( 
					'where' =>	array( 'id'	=>	$id )
				) ) ) );	
				
				// print_array( get_core_vars( 'post' ) );die;
							
				set_page( 'title' ,  $this->current_posttype->edit_post_label , 'Post List Label [#Unexpected error occured]' );
				$this->load->the_view( 'admin/posttypes/edit' , false );
			}
			else if( $page === 'taxonomy' )
			{
				// $id is taxonomy namespace here
				if( in_array( $id , array_keys( force_array( $taxonomy	=	$this->current_posttype->query->get_defined_taxonomies() ) ) ) )
				{
					set_core_vars( 'current_taxonomy' , $current_taxonomy	=	riake( $id , $taxonomy ) );
					set_core_vars( 'taxonomy_namespace' , $taxonomy_namespace	=	$id );					
					set_core_vars( 'taxonomy' , $taxonomy );
					set_core_vars( 'taxonomy_list_label' , riake( 'taxonomy-list-label' , $current_taxonomy ) );
					
					if( $taxonomy_arg1 === 'list' )
					{
						$taxonomy_limit		=	20;
						$taxonomy_arg2		=	$taxonomy_arg2 	=== 0 ? 1 : $taxonomy_arg2;
						
						set_core_vars( 'taxonomies_nbr' , $taxonomies_nbr 	=	count( $this->current_posttype->query->get_taxonomies( $taxonomy_namespace ) ) ); 
						set_core_vars( 'pagination' , $pagination =	pagination_helper( 
							$taxonomy_limit , 
							$taxonomies_nbr , 
							$taxonomy_arg2 , 
							get_instance()->url->site_url( array( 'admin' , 'posttype' , $namespace , $page , $id , $taxonomy_arg1 ) ) , 
							get_instance()->url->site_url( array('error','code','page-404' ) ) ) 
						);
						set_core_vars( 'taxonomies' , $this->current_posttype->query->get_taxonomies( $pagination[ 'start' ] , $pagination[ 'end' ] ) );
						
						set_page( 'title' ,  riake( 'new-taxonomy-label' , $current_taxonomy ) , 'Post List Label [#Unexpected error occured]' );
						$this->load->the_view( 'admin/posttypes/taxonomy-list' , false );
					}
					else if( $taxonomy_arg1 === 'new' )
					{
						$this->load->library( 'form_validation' );
						$this->form_validation->set_rules( 'taxonomy_title' , __( 'Taxonomy Title' ) , 'required' );
						
						if( $this->form_validation->run() )
						{
							$result	=	$this->current_posttype->query->set_taxonomy( 
								$id , 
								$this->input->post( 'taxonomy_title' ) , 
								$this->input->post( 'taxonomy_content' ) , 
								in_array( $this->input->post( 'taxonomy_parent' ) , array( false , '' ) , TRUE ) ? null : $this->input->post( 'taxonomy_parent' )								
							);
							get_instance()->notice->push_notice( fetch_notice_output( $result ) );
						}
						
						set_page( 'title' ,  riake( 'new-taxonomy-label' , $current_taxonomy , __( 'New taxonomy' ) ) , 'Post List Label [#Unexpected error occured]' );
						$this->load->the_view( 'admin/posttypes/taxonomy-create' , false );
					}
					else if( $taxonomy_arg1 === 'edit' )
					{
						$this->load->library( 'form_validation' );
						$this->form_validation->set_rules( 'taxonomy_title' , __( 'Taxonomy Title' ) , 'required' );
						
						if( $this->form_validation->run() )
						{
							$result	=	$this->current_posttype->query->update_taxonomy( 
								$id , 
								$this->input->post( 'taxonomy_title' ) , 
								$this->input->post( 'taxonomy_content' ) , 
								in_array( $this->input->post( 'taxonomy_parent' ) , array( false , '' ) , TRUE ) ? null : $this->input->post( 'taxonomy_parent' ),
								$taxonomy_arg2 // Since this is the taxonomy id					
							);
							get_instance()->notice->push_notice( fetch_notice_output( 'taxonomy-set' ) );
						}
						
						set_core_vars( 'taxonomy_id' , $taxonomy_arg2 );
						set_core_vars( 'get_taxonomy' , farray( $this->current_posttype->query->get_taxonomies( $taxonomy_namespace , $taxonomy_arg2 , 'as_id' ) ) );						
						set_page( 'title' ,  riake( 'edit-taxonomy-label' , $current_taxonomy , __( 'Edit taxonomy' ) ) , 'Post List Label [#Unexpected error occured]' );
						$this->load->the_view( 'admin/posttypes/taxonomy-edit' , false );
					}
				}
				else
				{
					$this->url->redirect( array( 'error' , 'code' , 'unknow-taxonomy' ) );
				}
			}
			else if( $page === 'comments' )
			{
				if( $taxonomy_arg1 == 'approve' )
				{
					
				}
				else if( $taxonomy_arg1 == 'disapprove' )
				{
					
				}
				else if( $taxonomy_arg1 == 'trash' )
				{
					
				}
				else if( $taxonomy_arg1 == 'draft' )
				{
					
				}
				// $this->current_posttype->query->post_comment( 1 , 'Custom' , $author = false , $mode = 'create' , $comment_id = null , $author_name = 'Blair' , $author_email = 'carlos@hoazd.de'  , $reply_to = false );
				
				$id				=	$id 	=== 0 ? 1 : $id;
				$comment_limit	=	10;
				$comments_nbr	=	count( $this->current_posttype->query->get_comments() );				
				
				$pagination		=	pagination_helper(
					$comment_limit,
					$comments_nbr,
					$id,
					get_instance()->url->site_url( array( 'admin' , 'posttype' , $namespace , 'comments' ) ),
					get_instance()->url->site_url( array( 'error' , 'code' , 'page-404' ) ) 
				);
				
				set_core_vars( 'pagination_data' , $pagination );
				 
				$comments		=	$this->current_posttype->query->get_comments( array( 
					'limit'		=>	array(
						'start'	=>	riake( 'start' , $pagination ),
						'end'	=>	riake( 'end' , $pagination )
					)
				) );
				
				set_core_vars( 'comments' , $comments );				
				set_core_vars( 'comments_list_label' , $this->current_posttype->comments_list_label );
				
				set_page( 'title' ,  $this->current_posttype->comments_list_label , 'Post List Label [#Unexpected error occured]' );
				$this->load->the_view( 'admin/posttypes/comments-list' , false );
			}
			else if( $page === 'comment-edit' )
			{
			}
		}
		else
		{
			$this->url->redirect( array( 'error' , 'code' , 'unknow-post-type' ) );
		}
	}
	public function profile() // use with GUI
	{
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
			
			$this->url->redirect( $this->url->site_url() . '?notice=profile-updated' . $text );
		}	
		if( $this->input->post( 'dashboard_theme' ) || $this->input->post( 'user_oldpass' ) || $this->input->post( 'user_newpass' ) || $this->input->post( 'user_confirmnewpass' ) )
		{
			if( $this->input->post( 'user_oldpass' ) )
			{
				$info = '';
				if( $this->input->post( 'user_newpass' ) == $this->input->post( 'user_confirmnewpass' ) )
				{
					$result		=	current_user()->updainitsword( $this->input->post( 'user_oldpass' ) , $this->input->post( 'user_newpass' ) );
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
			$this->url->redirect( $this->url->site_url() . '?notice=profile-updated' . $info );
		}
		// Admin Widget Section
		if(riake('widget_action',$_POST) || riake('widget_namespace',$_POST))
		{
			$this->users_global->setAdminWidgets($_POST);
			$this->url->redirect(array('admin','profile?notice=done'));
		}
		if( $this->input->post( 'reset_account' ) )
		{
			current_user()->reset();
			$this->url->redirect( array( 'admin', 'profile?notice=user-meta-has-been-reset' ) );
		}

				
		set_page('title', riake( 'site_name' , $this->options ) . ' | '.ucfirst( current_user( 'PSEUDO' ) ).' &raquo; ' . translate( 'My Profile' ) );
		set_page('description', translate( 'My Profile' ) );
		
		$this->load->the_view('admin/profile/body' );
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
				
				$this->load->view('admin/roles/list' );
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
						notice('push',fetch_notice_output('error-occured'));
					}
				}
							
				set_page( 'title' , sprintf( __( 'Create new role | Tendoo %s' ) , get( 'core_id' ) ) );
				
				$this->load->the_view( 'admin/roles/create' );
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
						notice('push',fetch_notice_output('error-occured'));
					}
				}
				
				set_core_vars( 'get_role' , $this->roles->get( $input_1 ) );
				
				if(count(get_core_vars( 'get_role' )) == 0)
				{
					$this->url->redirect(array('error','code','role-not-found' ) );
				}
	
				set_page( 'title' , sprintf( __( 'Edit role | Tendoo %s' ) , get( 'core_id' ) ) );
				
				$this->load->the_view( 'admin/roles/edit' );
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
					
					$this->url->redirect( array( 'admin' , 'roles' , 'permissions?notice=role-permissions-saved' ) );
				}
				
				set_core_vars( 'get_roles' , $this->roles->get() );
				set_core_vars( 'get_modules' , get_modules( 'filter_active' ) );
				// Merge System Permissions to Modules Permissions, with valid permissions namespaces
				$modules	=	get_core_vars( 'get_modules' );	
				array_unshift( $modules ,	get_core_vars( 'tendoo_core_permissions' ) );
				set_core_vars( 'get_modules' , $modules );
				
				set_page( 'title' , __( 'Roles permissions - Tendoo' ) );
				
				$this->load->the_view( 'admin/roles/permissions' );
			}
		}
	public function settings()
	{
		$this->load->helper('date');
		set_page('title', translate( 'Website settings - Tendoo' ) );
		$this->load->view( 'admin/setting/body' );
	}
    public function tools($action	=	'index') // Disabled
    {
		$this->url->redirect( array( 'error' , 'code' , 'page-404' ) ); // @since 1.4
		
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
			set_core_vars( 'priv_stats' , 	$this->tendoo_admin->roles_stats() );
			 
			
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
			$this->url->redirect(array('error','code','page-404'));
		}
    }
	public function themes($e	=	'main', $a	= 1)
	{
		current_user()->cannot( 'system@manage_themes' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
		redirect_if_webapp_is_enabled();
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
			
			$this->load->the_view( 'admin/themes/main' );
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
			$this->url->redrect(array('error','code','page-404'));
		}
		
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
				$this->url->redirect(array('admin','modules?notice=error-occured'));
			}
			$this->url->redirect(array('admin','index?notice=unactive-or-unknow-module'));
		}
		$this->url->redirect(array('admin','index?notice=error-occured'));
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
					$this->url->redirect(array('admin','modules','main',1,'module-has-been-installed'));
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
				// $this->url->redirect(array('error','code','unactive-or-unknow-module'));
			}
		}
	}
	public function users( $options = '' , $x = 1 , $y = '' , $z = '' )
	{
		current_user()->cannot( 'system@manage_users' ) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : false;
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
						notice('push',fetch_notice_output('users-creation-failed'));
						break;
					case 'user-has-been-created'	:
						$this->url->redirect(array('admin','users?notice=user-has-been-created'));
						break;
					case 'users-creation-failed'	:
						$this->url->redirect(array('admin','users','create?notice=users-creation-failed'));
				}
			}
			set_core_vars( 'getPrivs' , $this->roles->get());
			set_page('title', translate( 'Manage Users - Tendoo' ) );
			
			$this->load->the_view('admin/users/create');
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
						notice('push',fetch_notice_output('error-occured'));
					}
				}
			}
			
			set_core_vars( 'get_roles' ,	$this->roles->get());
			set_core_vars( 'adminInfo' ,	$adminInfo	=	$this->users_global->getSpeAdminByPseudo($x) );
			set_page('title', sprintf( translate( 'User profile : %s - Tendoo' ), $adminInfo['PSEUDO'] ) );
			
			$this->load->the_view( 'admin/users/edit' );
		}
		else
		{
			set_core_vars( 'users_nbr' ,	count($this->users_global->getAdmin()));
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(10, get_core_vars( 'users_nbr' ),1,'bg-color-red fg-color-white','',$x,$this->url->site_url(array('admin','system','users')).'/') );
						
			set_core_vars( 'get_users' ,	$this->users_global->getAdmin($paginate[1],$paginate[2]) );
			
			set_page('title', translate( 'Manage users - Tendoo' ) );
			
			$this->load->the_view( 'admin/users/users' );
		}
	}
	public function upload( $action = 'main' )
	{
		if( $action == 'main' )
		{
			$this->load->view( 'admin/uploads/dialog.php' );
		}
		else if( $action == 'ajax_call' )
		{
			$this->load->view( 'admin/uploads/ajax_call.php' );
		}
		else if( $action == 'execute' )
		{
			$this->load->view( 'admin/uploads/execute.php' );
		}
		else if( $action == 'force_download' )
		{
			$this->load->view( 'admin/uploads/force_download.php' );
		}
	}
	public function send()
	{
		$this->load->view( 'admin/uploads/send.php' );
	}
	public function media()
	{
		set_page( 'title' , __( 'Media Library - Tendoo' ) );
		$this->load->the_view( 'admin/uploads/media' , false );
	}
	// Public function






}