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
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->__admin_widgets(); // USING core WiDGET and thoses defined through tepas
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_page( 'description' , 'Panneau de contrôle | '.get( 'core_version' ) );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		/*$this->tendoo_admin->system_not('Modifier vos param&ecirc;tre de s&eacute;curit&eacute;', 'Mettez vous &agrave; jour avec cette version', '#', '10 mai 2013', null);*/	
		// Set Default View	
		set_core_vars( 'inner_head' ,	$this->load->view('admin/inner_head',array(),true,false) , 'read_only' );		
		set_core_vars( 'lmenu' , $this->load->view('admin/left_menu',array(),true,false) , 'read_only' );
	}
	private function construct_end()
	{
		// GLOBAL NOTICE
		set_core_vars( 'global_notice' , $this->tendoo_admin->get_global_info() , 'read_only' );
		foreach(get_core_vars( 'global_notice' ) as $gl)
		{
			$notice_s	=	strip_tags(fetch_error($gl));
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
			$this->tendoo_admin->system_not('Syst&egrave;me', $notice_s, $link,null, null);
			notice('push',fetch_error($gl));
		}		
	}
	private function adminConnection()
	{
		(!$this->users_global->hasAdmin()) 	?  	$this->url->redirect(array('registration','superAdmin')): FALSE;
		(!$this->users_global->isConnected()) ? $this->url->redirect(array('login?ref='.urlencode($this->url->request_uri()))) : FALSE;
		(!$this->users_global->isAdmin())	?	$this->url->redirect(array('error','code','accessDenied')) : FALSE;
		set_core_vars( 'options' , $this->instance->options->get(), 'read_only' );
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
		if($this->core_options[0]['PUBLIC_PRIV_ACCESS_ADMIN'] == '0') // If public priv is not allowed, not check current user priv class
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
			"widget_title"			=>	"Statistiques Globales",
			"widget_content"		=>	$this->load->view('admin/others/widgets/generals-stats',null,true),
			"widget_description"	=>	'Affiche les statistiques globales'
		));
		declare_admin_widget(array(
			"module_namespace"		=>	"system",
			"widget_namespace"		=>	"welcome",
			"widget_title"			=>	"Message de bienvenue",
			"widget_content"		=>	$this->load->view('admin/others/widgets/welcome-message',null,true),
			"widget_description"	=>	'affiche le message de bienvenue'
		));
		declare_admin_widget(array(
			"module_namespace"		=>	"system",
			"widget_namespace"		=>	"app_icons",
			"widget_title"			=>	"Icônes des applications",
			"widget_content"		=>	$this->load->view('admin/others/widgets/app-icons',null,true),
			"widget_description"	=>	'Affiche les icônes disponibles'
		));
		engage_tepas();
	}
	// Public functions
	public function index()
	{
		js_push_if_not_exists('jquery-ui-1.10.4.custom.min');		
		js_push_if_not_exists('admin.index.intro');
		set_page('title','Panneau de Contr&ocirc;le - Tendoo');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_core_vars( 'lmenu' , $this->load->view('admin/left_menu',array(),true,false) , 'read_only' );
		set_core_vars( 'body' , $this->load->view('admin/index/body',array(),true,false) , 'read_only' );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->load->view('admin/header',array(),false,false);
		$this->load->view('admin/global_body',array(),false,false);
	}
	public function controllers($e = '',$f = '')
	{
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
							notice('push',tendoo_error($ttError.' erreurs trouvée(s), la création à été ignorée pour ces erreurs.'));
						}
						notice('push',fetch_error('controllers_updated'));
					}
				}
				css_push_if_not_exists('controller_style');
				js_push_if_not_exists('jquery.nestable');
				js_push_if_not_exists('tendoo_controllersScripts'); // ControllersSripts
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				set_core_vars( 'get_pages' ,	$this->tendoo->get_pages());
				set_core_vars( 'get_mod' , $this->tendoo_admin->get_bypage_module());
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				set_page('title','Gestion des contrôleurs');
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
			set_core_vars( 'mod_nbr' , $mod_nbr	=	$this->tendoo_admin->count_modules() , 'read_only' );
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
			
			set_core_vars( 'modules_list' ,	$this->tendoo_admin->get_modules($paginate[1],$paginate[2]), 'read_only' );
			set_page('title','Gestion des modules - Tendoo');	
			set_core_vars( 'body' ,	$this->load->view('admin/modules/body',$this->data,true), 'read_only' );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
	}
	public function uninstall($e ='',$id= '')
	{
		if($e == 'module')
		{
			if( !$this->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('system','gestmo',$this->users_global->current('PRIVILEGE')))
			{
				$this->url->redirect(array('admin','index?notice=accessDenied'));
				return; 
			}
			
			$this->load->library('form_validation');
$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('mod_id','','required|trim|alpha_dash|min_length[1]');
			if($this->form_validation->run())
			{
				set_core_vars( 'module' ,	$module 	= $this->tendoo->getSpeModule($this->input->post('mod_id')), 'read_only' );
				$installexec			=	$this->tendoo_admin->uninstall_module($module[0]['ID']);
				if($installexec)
				{
					$this->url->redirect(array('admin','modules','main',1,'module_uninstalled'));
				}
			}
			set_core_vars( 'module' , $module 	= $this->tendoo->getSpeModule($id), 'read_only' );
			if(count($module) > 0)
			{
				set_page('title','Désinstaller - '.$module[0]['HUMAN_NAME']);
				set_core_vars( 'body' ,	$this->load->view('admin/modules/uninstall',$this->data,true), 'read_only' );
				
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);
			}
			else
			{
				$this->url->redirect(array('error','code','unknowModule'));
			}
		}
	}
	public function active($e,$id)
	{
		if($e	== 	'module')
		{
			$module	=	$this->tendoo_admin->moduleActivation($id);
			if($module)
			{
				$this->url->redirect(array('admin','modules?info='.strip_tags('Le module <strong>'.$module[0]['HUMAN_NAME'].' a été correctement activé')));
				return true;
			}
		}
		$this->url->redirect(array('admin','modules?notice=error_occured'));
		return false;
	}
	public function unactive($e,$id)
	{
		if($e	== 	'module')
		{
			$mod	=	$this->tendoo_admin->getSpeMod($id,TRUE);
			if($mod)
			{
				$this->db->where('ID',$id)->update('tendoo_modules',array(
					'ACTIVE'	=>	0
				));
				$this->url->redirect(array('admin','modules?notice=module_success_disabled'));
				return true;
			}
			return false;
		}
		return false;
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
			$MODULE					=	$this->tendoo->getSpeModule((int)$a);
			$MODULE[0]['URI_PATH']	=	MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/';
			$MODULE[0]['URL_PATH']	=	$this->url->main_url().MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/';
			$png	=	MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/app_icon.png';
			$jpg	=	MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/app_icon.jpg';
			if( is_file( $png ) )
			{
				$MODULE[0]['ICON_URL']	=	$this->url->main_url().$png;	
			}
			if( is_file( $jpg ) )
			{
				$MODULE[0]['ICON_URL']	=	$this->url->main_url().$jpg;	
			}
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			set_core_vars( 'opened_module'	, $MODULE , 'read_only' );
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			if(get_core_vars( 'opened_module' )) 
			{
				// Définition d'un titre par défaut
				set_page('title','Panneau d\'administration du module - '.$MODULE[0]['NAMESPACE']); 
				if(!is_file(MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/admin_controller.php'))
				{
					$this->exceptions->show_error('Erreur Importante','Certains fichiers important à l\'éxecution de ce module sont manquants. La reinstalaltion pourra corriger ce problème.');
					exit;
				}
				include_once(MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/library.php');
				include_once(MODULES_DIR.$MODULE[0]['ENCRYPTED_DIR'].'/admin_controller.php');
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
				set_core_vars( 'interpretation', $interpretation =	$this->tendoo->interpreter($MODULE[0]['NAMESPACE'].'_admin_controller',$Method,$Parameters), 'read_only' );
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
								$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "RETURNED". Le module chargé renvoi un tableau incorrect ou incomplet.'); // If array key forget, get all content as interpretation.
							$BODY['MCO']		=	$interpretation['MCO'];
							set_core_vars( 'body' , $BODY );
							$this->load->view('admin/global_body',$this->data,false,false);
						}
					}
					else
					{
						$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "MCO". Le module chargé renvoi un tableau incorrect ou incomplet.');
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
				set_page('title','Panneau d\'administration du thèmes - '.$active_theme[0]['HUMAN_NAME']); 
				include_once(THEMES_DIR.$active_theme[0]['ENCRYPTED_DIR'].'/library.php');
				include_once(THEMES_DIR.$active_theme[0]['ENCRYPTED_DIR'].'/admin_controller.php');
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
				set_core_vars( 'interpretation' , $interpretation = 	$this->tendoo->interpreter($active_theme[0]['NAMESPACE'].'_theme_admin_controller',$Method,$Parameters), 'read_only'  );
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
					$this->form_validation->set_rules('newName','"Du nom du site"','required|min_length[4]|max_length[40]');
					if($this->form_validation->run())
					{
						$newName	=	$this->tendoo_admin->editSiteName($this->input->post('newName'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('newLogo','"De l\'url du logo du site"','max_length[200]');
					if($this->form_validation->run())
					{
						$newLogo	=	$this->tendoo_admin->editLogoUrl($this->input->post('newLogo'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('newHoraire','"Du fuseau horaire"','required|min_length[1]|max_length[20]');
					if($this->form_validation->run())
					{
						$newHoraire	=	$this->tendoo_admin->editTimeZone($this->input->post('newHoraire'));
					}
					$this->load->library('form_validation');
					$this->form_validation->set_rules('newFormat','"Du format horaire"','required|min_length[6]|max_length[10]');
					if($this->form_validation->run())
					{
						$newFormat	=	$this->tendoo_admin->editTimeFormat($this->input->post('newFormat'));
					}
				}
				// Moved to Account controller
				$this->load->library('form_validation');
				$this->form_validation->set_rules('theme_style','"Nom du thème"','required|min_length[1]|max_length[15]');
				
				if($this->form_validation->run())
				{
					$themeName	=	$this->users_global->editThemeStyle($this->input->post('theme_style'));
				}
				// Moved to Account controller
				if($newName || $newLogo || $newHoraire || $newFormat || $themeName)
				{
					$this->url->redirect(array('admin','setting?notice=done'));
				}
				else
				{
					notice('push',fetch_error('error_occured'));
				}
			}
			if($this->users_global->isSuperAdmin()) // this Setting is now reserved to super admin
			{
				if($this->input->post('autoriseRegistration')) // Setting notice go here.
				{
					if($this->tendoo_admin->editRegistration($this->input->post('allowRegistration')))
					{
						$this->url->redirect(array('admin','setting?notice=done'));
					}
					else
					{
						notice('push',fetch_error('error_occured'));
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
						notice('push',fetch_error('error_occured'));
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
						notice('push',fetch_error('error_occured'));
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
						notice('push',fetch_error('error_occured'));
					}
				}
			}
			if(array_key_exists('widget_action',$_POST) || array_key_exists('widget_namespace',$_POST))
			{
				$this->users_global->setAdminWidgets($_POST);
				$this->url->redirect(array('admin','setting?notice=done'));
			}
			set_core_vars( 'appIconApi' , $this->tendoo_admin->getAppIcon(), 'read_only' );
			set_page('title','Param&egrave;tres du site');
			set_core_vars( 'body' ,	$this->load->view('admin/setting/body',$this->data,true) , 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
	}
	public function themes($e	=	'main', $a	= 1)
	{
		if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gestheme',$this->users_global->current('PRIVILEGE')))
		{
			
			if($e == 'main')
			{
				js_push_if_not_exists('jtransit/jquery.transit.min');
								
				set_page('title','Gestion des th&egrave;mes - Tendoo');
				set_core_vars( 'ttThemes' , $ttThemes	=	$this->tendoo_admin->countThemes() , 'read_only' );
				set_core_vars( 'paginate' , $paginate	=	$this->tendoo->paginate(
					10,
					$ttThemes,
					1,
					"bg-color-blue fg-color-white",
					"bg-color-white fg-color-blue",
					$a, // as page
					$this->url->site_url(array('admin','modules','main')).'/'
				) , 'read_only' ); // Pagination
				set_core_vars( 'themes_list' ,	$this->tendoo_admin->getThemes($paginate[1],$paginate[2]) , 'read_only' );
				set_core_vars( 'body' , $this->load->view('admin/themes/main',$this->data,true) , 'read_only' );
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);
			}
			else if($e == 'manage')
			{
				$this->load->library('form_validation');
$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
				$this->form_validation->set_rules('action','Définir par d&eacute;faut');
				$this->form_validation->set_rules('theme_id','identifiant du theme','required');
				if($this->form_validation->run())
				{
					if($this->input->post('action') == 'ADMITSETDEFAULT')
					{
						if($this->tendoo_admin->setDefault($this->input->post('theme_id')))
						{
							echo json_encode(array(
								'status'	=>		'success',
								'alertType'	=>		'notice',
								'message'	=>		'Le thème à été correctement été définie par défaut',
								'response'	=>		'theme_set'
							));
							return;
						}
						echo json_encode(array(
							'status'	=>		'warning',
							'alertType'	=>		'modal',
							'message'	=>		'Le thème n\'a pas pu être défini par défaut.',
							'response'	=>		'theme_set_failure'
						));
						return;
					}
				}
				$this->form_validation->set_rules('action','Supprimer le th&egrave;me');
				$this->form_validation->set_rules('theme_id','identifiant du theme','required');
				if($this->form_validation->run())
				{
					if($this->input->post('action') == 'ADMITDELETETHEME')
					{
						$status		=	$this->tendoo_admin->uninstall_theme($this->input->post('theme_id'));
						if($status)
						{
							echo json_encode(array(
								'status'	=>		'success',
								'alertType'	=>		'notice',
								'message'	=>		'Le thème à été supprimé',
								'response'	=>		'theme_deleted'
							));
							return;
						}
						echo json_encode(array(
							'status'	=>		'warning',
							'alertType'	=>		'modal',
							'message'	=>		'Le thème n\'a pas pu être supprimé.',
							'response'	=>		'theme_deletion_failure'
						));
						return;
					}
				}
			}
			else if($e ==  'config') // Added 0.9.2 // obsolete
			{
				set_core_vars( 'Spetheme' , $spetheme	=	$this->tendoo_admin->isTheme($a));
				if(is_array(get_core_vars( 'Spetheme' ))) 
				{
					// Si la re-écriture est activé, on réduit l'index. 
					$index	=	$this->url->getRewrite()	==	true ? 1 : 0;
					$Parameters			=	$this->url->http_request(TRUE);
					$admin_controler	=	THEMES_DIR. $spetheme[0]['ENCRYPTED_DIR'].'/admin_controller.php';
					$library			=	THEMES_DIR. $spetheme[0]['ENCRYPTED_DIR'].'/library.php';
					if(is_file($admin_controler) && is_file($library))
					{
						include_once($admin_controler); // Include admin controler
						include_once($library); // Include Theme internal library
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
						set_core_vars( 'interpretation' , $interpretation 	=	$this->tendoo->interpreter( $spetheme['NAMESPACE'].'_theme_admin_controller',$Method,$Parameters));
						if(get_core_vars( 'interpretation' ) == '404')
						{
							$this->url->redirect(array('error','code','page404'));
						}
						if(is_array($interpretation))
						{
							if(array_key_exists('MCO',$interpretation))
							{
								if($interpretation['MCO'] == TRUE)
								{
									$BODY['RETURNED']	=	array_key_exists('RETURNED',$interpretation ) ? 
										$interpretation['RETURNED'] : 
										$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "RETURNED". Le module chargé renvoi un tableau incorrect ou incomplet.'); // If array key forget, get all content as interpretation.
									$BODY['MCO']		=	$interpretation['MCO'];
									set_core_vars( 'body' , $BODY );
									$this->load->view('admin/global_body',$this->data,false,false);
								}
							}
							else
							{
								$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "MCO". Le module chargé renvoi un tableau incorrect ou incomplet.');
							}
						}
						else
						{
						//	set_core_vars( 'body' )'RETURNED']	=	set_core_vars( 'interpretation' );
						//	set_core_vars( 'body' )['MCO']		=	FALSE;
							
							$this->load->view('admin/header',$this->data,false,false);
							$this->load->view('admin/global_body',$this->data,false,false);
						}
					}
					else
					{
						$this->url->redirect(array('error','code','themeControlerNoFound'));
					}
				}
				else
				{
					$this->url->redirect(array('error','code','unknowTheme'));
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
				$query	=	$this->tendoo_admin->tendoo_installer('installer_file');
			}
			if(isset($_POST['installer_link'],$_POST['downloadType']))
			{
				$query	=	$this->tendoo_admin->tendoo_url_installer( 
					$this->input->post('installer_link'),
					$this->input->post('downloadType')
				);
				notice('push',fetch_error($query));
			}
			set_page('title','Installer une application - Tendoo');
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
			set_page('title', "A propos de Tendoo");
			set_core_vars( 'body' , $this->load->view('admin/system/body',$this->data,true), 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
		}
		else if($option ==  'createAdmin')
		{
			$this->form_validation->set_rules('admin_pseudo','Pseudo','trim|required|min_length[5]|max_length[15]');
			$this->form_validation->set_rules('admin_password','Mot de passe','trim|required|min_length[6]|max_length[30]');
			$this->form_validation->set_rules('admin_password_confirm','Confirmation du mot de passe','trim|required|matches[admin_password]');
			$this->form_validation->set_rules('admin_sex','Selection du sexe','trim|min_length[3]|max_length[5]');
			$this->form_validation->set_rules('admin_password_email','Email','trim|valid_email|required');
			$this->form_validation->set_rules('admin_privilege','Choisir privil&egrave;ge','trim|required|min_length[8]|max_length[11]');
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
						notice('push',fetch_error('adminCreationFailed'));
						break;
					case 'adminCreated'	:
						$this->url->redirect(array('admin','system','createAdmin?notice=adminCreated'));
						break;
					case 'adminCreationFailed'	:
						$this->url->redirect(array('admin','system','createAdmin?notice=adminCreationFailed'));
				}
			}
			set_core_vars( 'getPrivs' , $this->tendoo_admin->getPrivileges());
			set_page('title','Gestion des utilisateurs - Tendoo');
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
			$this->form_validation->set_rules('priv_description','Description du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('priv_name','Nom du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('is_selectable','Acc&eacute;ssibilit&eacute; au public','trim|required|min_length[1]|max_length[1]');
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
					notice('push',fetch_error('error_occured'));
				}
			}
			
			$this->session->set_userdata('privId',$this->tendoo_admin->getPrivId());
			set_core_vars( 'privId' ,	$this->session->userdata('privId') );
			set_page('title','Cr&eacute;er un privil&egrave;ge - Tendoo');
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
			$this->form_validation->set_rules('priv_description','Description du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('priv_name','Nom du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('is_selectable','Acc&eacute;ssibilit&eacute; au public','trim|required|min_length[1]|max_length[1]');
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
					notice('push',fetch_error('error_occured'));
				}
			}
			set_core_vars( 'getPriv' , $this->tendoo_admin->getPrivileges($option_2));
			if(count(get_core_vars( 'getPriv' )) == 0)
			{
				$this->url->redirect(array('error','code','privilegeNotFound'));
			}
			set_page('title','Modifier un privil&egrave;ge - Tendoo');
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
			set_core_vars( 'ttModules' , 	count($this->tendoo_admin->get_modules()) );
			set_core_vars( 'paginate' ,	$paginate	=	$this->tendoo->paginate(10,get_core_vars( 'ttModules' ),1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','manage_actions')).'/') );
			set_core_vars( 'getModules' ,	$this->tendoo_admin->get_modules($paginate[1],$paginate[2]) );
			set_page('title','Gestionnaire d\'actions - Tendoo');
			
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
			set_page('title','Privil&egrave;ges et actions - Tendoo' );
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
				$this->form_validation->set_rules('current_admin','Concernant l\'utilisateur en cours','trim|required|min_length[5]');
				$this->form_validation->set_rules('edit_priv','Modifier son privil&egrave;ge','trim|required|min_length[8]|max_length[11]');
				$this->form_validation->set_rules('user_email','Email','trim|valid_email');
				if($this->form_validation->run())
				{
					$query	=	$this->users_global->setAdminPrivilege($this->input->post('edit_priv'),$this->input->post('current_admin'),$this->input->post('user_email'));
					notice('push',fetch_error($query));
				}
			}
			if($this->input->post('delete_admin'))
			{
				$this->form_validation->set_rules('current_admin','Concernant l\'utilisateur en cours','trim|required|min_length[6]');
				$this->form_validation->set_rules('delete_admin','Modifier son privil&egrave;ge','trim|required|min_length[1]');
				if($this->form_validation->run())
				{
					if($this->users_global->deleteSpeAdmin($this->input->post('current_admin')))
					{
						$this->url->redirect(array('admin','system','adminMain?notice=adminDeleted'));
					}
					else
					{
						notice('push',fetch_error('error_occured'));
					}
				}
			}
			
			set_core_vars( 'getPrivs' ,	$this->tendoo_admin->getPrivileges());
			set_core_vars( 'adminInfo' ,	$adminInfo	=	$this->users_global->getSpeAdminByPseudo($option_2) );
			set_page('title','Profil Utilisateur &raquo; '.$adminInfo['PSEUDO'].' - Tendoo');
			
			set_core_vars( 'body' ,	$this->load->view('admin/system/editAdmin',$this->data,true) , 'read_only' );
			
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);	
			return true;
		}
		else if($option	==	'restore')
		{
			if($option_2	==	'soft')
			{				
				$this->form_validation->set_rules('admin_password','Mot de passe administrateur','trim|required|min_length[6]|max_length[30]');
				if($this->form_validation->run())
				{
					if($this->tendoo_admin->cmsRestore($this->input->post('admin_password')))
					{
						notice('push',fetch_error('cmsRestored'));
					}
					else
					{
						notice('push',fetch_error('cmsRestorationFailed'));
					}
				}
				set_page('title','Restauration souple du syst&egrave;me - Tendoo');
				set_core_vars( 'body' ,	$this->load->view('admin/system/restore_soft',$this->data,true), 'read_only' );
				
				$this->load->view('admin/header',$this->data,false,false);
				$this->load->view('admin/global_body',$this->data,false,false);	
			}
			else if($option_2	==	'hard') // hard
			{
				$this->form_validation->set_rules('admin_password','Mot de passe administrateur','trim|required|min_length[6]|max_length[30]');
				if($this->form_validation->run())
				{
				}
				set_page('title' , 'Restauration brutale du syst&egrave;me');
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
			
			set_page('title','Gestion des utilisateurs - Tendoo');
			
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
        
        set_page('title','Utilitaires - Tendoo');
        set_core_vars( 'body' ,	$this->load->view('admin/tools/body',$this->data,true) );
        $this->load->view('admin/header',$this->data,false,false);
        $this->load->view('admin/global_body',$this->data,false,false);
		}
		else if($action == 'calendar')
		{
			 
			set_page('title','Utilitaires - Tendoo');
			set_core_vars( 'body' ,	$this->load->view('admin/tools/calendar',$this->data,true) );
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
		else if($action == 'stats')
		{
			set_core_vars( 'Stats' ,	$this->instance->stats->tendoo_visit_stats() );
			set_core_vars( 'priv_stats' , 	$this->tendoo_admin->privilegeStats() );
			 
			
			set_page('title','Utilitaires &raquo; Statistiques - Tendoo');
			set_core_vars( 'body' ,	$this->load->view('admin/tools/stats',$this->data,true) );
			$this->load->view('admin/header',$this->data,false,false);
			$this->load->view('admin/global_body',$this->data,false,false);
		}
		else if($action == 'seo')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('autoGenerate','Générer automatiquement un sitemap','required');
			if($this->form_validation->run())
			{
				$this->tendoo_sitemap->create_sitemap_automatically();
			}
			set_core_vars( 'getSitemap' ,	$this->tendoo_sitemap->getSitemap() );
			
			
			set_page('title','Utilitaires &raquo; Outils SEO - Tendoo');
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
			$site_options	=	$this->instance->options->get();
			if((int)$site_options[0]['CONNECT_TO_STORE'] == 1)
			{
				$this->tendoo_update->store_connect();
			}
			else
			{
				set_core_vars( 'type' ,	'wraning' );
				set_core_vars( 'notice' ,	tendoo_info('Impossible d\'acc&eacute;der au Store. Option d&eacute;sactiv&eacute;e') );
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
					'message'		=>		'Le statut des pages a été remis à zéro. Le procéssus de visite guidé s\'affichera désormais sur toutes les pages.',
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
			$this->form_validation->set_rules('page_name','Nom de la page','trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_cname','Code de la page','alpha_dash|trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_title','Titre de la page','trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_module','Affecter un module','trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_priority','Definir comme page principale','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_description','description de la page','trim|required|min_length[2]|max_length[2000]');
			$this->form_validation->set_rules('page_visible','Visibilité de la page','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_parent','Emplacement de la page','trim|required|min_length[1]');
			$this->form_validation->set_rules('page_keywords','mots-clés de la page','trim|required|min_length[1]');

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
					//notice('push',fetch_error(set_core_vars( 'error']));
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
				set_core_vars( 'notice' ,	notice('error_occured') );
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			$this->form_validation->set_rules('page_name','Nom de la page','trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_cname','Code du controleur','alpha_dash|trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_title','Titre du controleur','trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('page_module','D&eacute;finir le module','trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_priority','Definir comme page principale','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_visible','Visibilité de la page','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_description','champ description du controleur','trim|required|min_length[2]|max_length[2000]');
			$this->form_validation->set_rules('page_id','Identifiant de la page','required');
			$this->form_validation->set_rules('page_parent','Emplacement du contr&ocirc;leur','trim|required|min_length[1]');
			$this->form_validation->set_rules('page_keywords','Mots cl&eacute;s du cont&ocirc;leur','trim|required|min_length[1]');
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
				notice('push',fetch_error(get_core_vars( 'notice' )));
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
				set_core_vars( 'notice' ,	notice('error_occured') );
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			set_core_vars( 'getSpeController' ,	$this->tendoo_admin->get_controller($y) );
			$this->load->view('admin/ajax/load_controller',$this->data);
		}
		// Introducing set data Tendoo 1.2
		elseif($option	==	"set_data")
		{
			if($_POST[ 'key' ] && $_POST[ 'value' ])
			{
				return json_encode(set_data($_POST[ 'key' ], $_POST[ 'value' ]));
			}
			return 'false';
		}
		elseif($option	==	"get_data")
		{
			if($this->input->post( 'key' ))
			{
				return json_encode(get_data($this->input->post( 'key' )));
			}
			return 'false';
		}
		elseif($option	==	"set_user_data")
		{
			if($_POST[ 'key' ] && $_POST[ 'value' ])
			{
				return json_encode(set_user_data($_POST[ 'key' ], $_POST[ 'value' ]));
			}
			return 'false';
		}
		elseif($option	==	"get_user_data")
		{
			if($this->input->post( 'key' ))
			{
				return json_encode(get_user_data($this->input->post( 'key' )));
			}
			return 'false';
		}
		else if($option	==	"resetUserWidgetInterface")
		{
			return $this->users_global->resetUserWidgetInterface();
		}
	}
}