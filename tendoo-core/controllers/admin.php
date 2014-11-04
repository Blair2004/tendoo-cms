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
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->adminConnection(); 			// 	Admin Users Libraries
		$this->loadLibraries();				//	Affecting Libraries */
		$this->construct_end();				// 	Fin du constructeur
		$this->loadOuputFile();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_core_vars( 'admin_icons' , $this->tendoo_admin->getAppIcon() , 'read_only' );
		set_core_vars( 'active_theme' , site_theme() );
		set_core_vars( 'options' , get_meta( 'all' ) , 'read_only' );
		set_core_vars( 'tendoo_mode' , riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) , 'readonly' );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->__admin_widgets(); // USING core WiDGET and thoses defined through tepas
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
				$link	=	$this->url->site_url(array('admin','system','create_privilege'));
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
			$priv				=	$this->users_global->current('PRIVILEGE');
			if(!in_array($priv,$this->users_global->systemPrivilege()))
			{
				$cur_priv			=	$this->tendoo_admin->getPrivileges($priv);
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
		
		//js_push_if_not_exists('jquery');
		js_push_if_not_exists('jquery-1.10.2.min');
		js_push_if_not_exists('underscore.1.6.0');
		js_push_if_not_exists('app.min.vtendoo'); // _2
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
		//var_dump( $this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE') ) );
		//die;
		if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE')))
		{
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
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function modules($e = '',$a	=	1)
	{
		notice( 'push' , fetch_error_from_url() );
		if($e == '' || $e == 'main')
		{
			// Filter active APP while WebApp mode is enabled
			$argument	=	riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'webapp' ? 'filter_active_app' : 'list_all' ;
			
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
			if( !$this->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('system','gestmo',$this->users_global->current('PRIVILEGE')))
			{
				$this->url->redirect(array('admin','index?notice=accessDenied'));
				return; 
			}
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
				set_page( 'title' , translate( 'Uninstall' ) . ' : '. $module[ 'human_name' ] . ' - ' . translate( 'Dashboard' ) );
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
			if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gesmo',$this->users_global->current('PRIVILEGE'))){
				$module	=	get_modules( 'filter_namespace' , $namespace );
				if($module)
				{
					if( active_module( $namespace ) ){
						$this->url->redirect( array( 'admin' , 'modules?info='.strip_tags( sprintf( translate( 'The module <strong>%s</strong> is now enabled' ) , $module['human_name'] ) ) ) );
					}
					$this->url->redirect(array('admin','modules?notice=error_occurred'));
				}
				$this->url->redirect(array('admin','index?notice=unknowModule'));
			}
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->url->redirect(array('admin','modules?notice=error_occurred'));
	}
	public function unactive($e,$namespace)
	{
		if($e	== 	'module')
		{
			if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gesmo',$this->users_global->current('PRIVILEGE'))){
				$module	=	get_modules( 'filter_namespace' , $namespace );
				if($module)
				{
					if( unactive_module( $namespace ) ){
						$this->url->redirect(array('admin','modules?info='.strip_tags( sprintf( translate( 'The module <strong>%s</strong> is now disabled' ), $module['human_name'] ) ) ) );
					}
					$this->url->redirect(array('admin','modules?notice=error_occurred'));
				}
				$this->url->redirect(array('admin','index?notice=unknowModule'));
			}
			$this->url->redirect(array('admin','index?notice=accessDenied'));
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
				set_page('title', $active_theme[0]['HUMAN_NAME'] . ' | ' . translate( 'Dashboard' ) ); 
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
	public function setting($action = 'main',$query_1='',$query_2='')
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
			if($this->users_global->isSuperAdmin()) // this Setting is now reserved to super admin
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
		if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gestheme',$this->users_global->current('PRIVILEGE')))
		{
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
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
			return;
		}
	}
	public function installer()
	{
		if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gestapp',$this->users_global->current('PRIVILEGE')))
		{
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
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
			return;
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
			$this->form_validation->set_rules('admin_pseudo', translate( 'Pseudo' ),'trim|required|min_length[5]|max_length[15]');
			$this->form_validation->set_rules('admin_password', translate( 'Password' ),'trim|required|min_length[6]|max_length[30]');
			$this->form_validation->set_rules('admin_password_confirm',translate( 'Password Confirm' ),'trim|required|matches[admin_password]');
			$this->form_validation->set_rules('admin_sex',translate( 'Sex' ),'trim|min_length[3]|max_length[5]');
			$this->form_validation->set_rules('admin_password_email', translate( 'email' ) ,'trim|valid_email|required');
			$this->form_validation->set_rules('admin_privilege', translate( 'Select privilege' ),'trim|required|min_length[8]|max_length[11]');
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
						$this->url->redirect(array('admin','system','createAdmin?notice=adminCreated'));
						break;
					case 'adminCreationFailed'	:
						$this->url->redirect(array('admin','system','createAdmin?notice=adminCreationFailed'));
				}
			}
			set_core_vars( 'getPrivs' , $this->tendoo_admin->getPrivileges());
			set_page('title', translate( 'Manage Users - Tendoo' ) );
			set_core_vars( 'body' , $this->load->view('admin/system/createAdmin',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if($option ==  'create_privilege')
		{
			if(!method_exists($this,'form_validation'))
			{
				$this->load->library('form_validation');
$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			}
			$this->form_validation->set_rules('priv_description', translate( 'Privilege description' ) ,'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('priv_name', translate( 'Privilege name' ),'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('is_selectable', translate( 'Available on registration' ),'trim|required|min_length[1]|max_length[1]');
			if($this->form_validation->run())
			{
				$data	=	$this->tendoo_admin->create_privilege(
					$this->input->post('priv_name'),
					$this->input->post('priv_description'),
					$this->session->userdata('privId'),
					$this->input->post('is_selectable')
				);
				if($data === TRUE)
				{
					$this->url->redirect(array('admin','system','privilege_list?notice=done'));
				}
				else
				{
					notice('push',fetch_notice_output('error_occurred'));
				}
			}
			
			$this->session->set_userdata('privId',$this->tendoo_admin->getPrivId());
			set_core_vars( 'privId' ,	$this->session->userdata('privId') );
			set_page('title', translate( 'Create privilege - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/system/create_privilege',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if($option	== 	'edit_priv')
		{
			if(!method_exists($this,'form_validation'))
			{
				$this->load->library('form_validation');
$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			}
			$this->form_validation->set_rules('priv_description', translate( 'Privilege description' ) ,'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('priv_name', translate( 'Privilege name' ),'trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('is_selectable', translate( 'Available on registration' ),'trim|required|min_length[1]|max_length[1]');
			if($this->form_validation->run())
			{
				$data	=	$this->tendoo_admin->edit_privilege(
					$option_2,
					$this->input->post('priv_name'),
					$this->input->post('priv_description'),
					$this->input->post('is_selectable')
				);
				if($data === TRUE)
				{
					$this->url->redirect(array('admin','system','privilege_list?notice=done'));
				}
				else
				{
					notice('push',fetch_notice_output('error_occurred'));
				}
			}
			set_core_vars( 'getPriv' , $this->tendoo_admin->getPrivileges($option_2));
			if(count(get_core_vars( 'getPriv' )) == 0)
			{
				$this->url->redirect(array('error','code','privilegeNotFound'));
			}
			set_page('title', translate( 'Edit privilege - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/system/edit_privilege',$this->data,true) );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		
		}
		else if($option	==	'manage_actions')
		{
			if(!$this->tendoo_admin->hasPriv())
			{
				$this->url->redirect(array('admin','system','create_privilege?notice=mustCreatePrivilege'));
			}
			set_core_vars( 'ttPrivileges' ,	$this->tendoo_admin->countPrivileges());
			set_core_vars( 'getPrivileges' ,	$this->tendoo_admin->getPrivileges() );
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
				if($this->tendoo_admin->addActionToPriv($_POST['QUERY'],'system'))
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
				if($this->tendoo_admin->addActionToPriv_MTW($_POST['QUERY_2'],'modules'))
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
		else if($option	==	'privilege_list')
		{
			set_core_vars( 'ttPrivileges' ,	$this->tendoo_admin->countPrivileges());
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(10,get_core_vars( 'ttPrivileges' ),1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','privilege_list')).'/'));
			set_core_vars( 'getPriv' ,	$this->tendoo_admin->getPrivileges($paginate[1],$paginate[2]));
			set_page('title', translate( 'Privileges and actions - Tendoo' ) );
			set_core_vars( 'body' ,	$this->load->view('admin/system/privilege_list',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		
		}
		else if($option == 'delete_priv')
		{
			set_core_vars( 'deletion' ,	$this->tendoo_admin->deletePrivilege($option_2) );
			$this->url->redirect(array('admin','system','privilege_list?notice='.get_core_vars( 'deletion' )));			
		}
		else if($option	==	'editAdmin')
		{
			if($this->input->post('set_admin'))
			{
				$this->form_validation->set_rules('current_admin', translate( 'About current user' ),'trim|required|min_length[5]');
				$this->form_validation->set_rules('edit_priv', translate( 'Edit his privilege' ),'trim|required|min_length[8]|max_length[11]');
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
						$this->url->redirect(array('admin','system','adminMain?notice=adminDeleted'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occurred'));
					}
				}
			}
			
			set_core_vars( 'getPrivs' ,	$this->tendoo_admin->getPrivileges());
			set_core_vars( 'adminInfo' ,	$adminInfo	=	$this->users_global->getSpeAdminByPseudo($option_2) );
			set_page('title', sprintf( translate( 'User profile : %s - Tendoo' ), $adminInfo['PSEUDO'] ) );
			
			set_core_vars( 'body' ,	$this->load->view('admin/system/editAdmin',$this->data,true) , 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
			return true;
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
		else if($option	== 'adminMain')
		{
			set_core_vars( 'ttAdmin' ,	count($this->users_global->getAdmin()));
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(10,get_core_vars( 'ttAdmin' ),1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','adminMain')).'/') );
			
			
			set_core_vars( 'subadmin' ,	$this->users_global->getAdmin($paginate[1],$paginate[2]) );
			
			set_page('title', translate( 'Manage users - Tendoo' ) );
			
			set_core_vars( 'body' ,	$this->load->view('admin/system/adminList',$this->data,true) );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else
		{
			$this->url->redirect(array('page404'));
		}
		
	}
    public function tools($action	=	'index')
    {
		if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('PRIVILEGE'))== FALSE)
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
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
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE'))== FALSE)
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
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('PRIVILEGE'))== FALSE)
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
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('PRIVILEGE'))== FALSE)
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
			if($this->users_global->isSuperAdmin() === FALSE	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE')))
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
			if(!$this->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE')))
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
			if(!$this->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE')))
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