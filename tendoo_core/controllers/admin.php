<?php 
class Admin
{  
	public function __construct()
	{
		__extends($this);
		// Load Users Global Class
		$this->load->library('users_global',null,null,$this);
		// End
		$this->installStatus();				// 	Install Status
		$this->adminConnection(); 			// 	Admin Users Libraries
		$this->loadLibraries();				//	Affecting Libraries */
		
		$this->construct_end();				// 	Fin du constructeur
		$this->data['pageDescription']		=	$this->tendoo->getVersion();
		/*$this->tendoo_admin->system_not('Modifier vos param&ecirc;tre de s&eacute;curit&eacute;', 'Mettez vous &agrave; jour avec cette version', '#', '10 mai 2013', null);*/		
	}
	private function installStatus()
	{
		if(!$this->tendoo->isInstalled())
		{
			$this->url->redirect('install/step/1');
		}
	}
	private function construct_end()
	{
		// GLOBAL NOTICE
		$this->data['global_notice']	=	$this->tendoo_admin->get_global_info();
		foreach($this->data['global_notice'] as $gl)
		{
			$notice_s	=	strip_tags(notice($gl));
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
			$this->notice->push_notice(notice($gl));
		}
		$this->loadOuputFile();
		// Core NOTICE
		// L'accès au store implique la connexion au Tendoo Threads, sinon le menu est désactivé.
		$this->data['tendoo_core_update']	=	
			(int)$this->data['options'][0]['CONNECT_TO_STORE'] == 1 ?
				$this->tendoo_update->getUpdateCoreNotification() 	:
				false;
	}
	private function adminConnection()
	{
		(!$this->users_global->hasAdmin()) 	?  	$this->url->redirect(array('registration','superAdmin')): FALSE;
		(!$this->users_global->isConnected()) ? $this->url->redirect(array('login?ref='.urlencode($this->url->request_uri()))) : FALSE;
		(!$this->users_global->isAdmin())	?	$this->url->redirect(array('error','code','accessDenied')) : FALSE;
		$this->data['options']				=	$this->tendoo->getOptions();
	}
	private function loadLibraries()
	{	
		// Chargement des classes.
		$this->load->library('tendoo_admin',null,null,$this);
		$this->load->library('pagination',null,null,$this);
		$this->load->library('file',null,'file_2',$this);
		$this->load->library('form_validation',null,null,$this);
		$this->load->library('tendoo_sitemap',null,null,$this);
		$this->load->library('tendoo_update',null,null,$this);
		// Définition des balises d'erreur.
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		
		$this->data['notice']		=	'';
		$this->data['error']		=	'';
		$this->data['success']		=	'';
		if($this->data['options'][0]['PUBLIC_PRIV_ACCESS_ADMIN'] == '0') // If public priv is not allowed, not check current user priv class
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
		$this->file->css_push('font');
		$this->file->css_push('app.v2');
		$this->file->css_push('tendoo_global');
		$this->file->css_push('fuelux');
		$this->file->css_push('introjs/introjs.min');

		//$this->file->js_push('jquery');
		$this->file->js_push('jquery-1.10.2.min');
		
		$this->file->js_push('underscore.1.6.0');
		$this->file->js_push('app.min.vtendoo'); // _2
		$this->file->js_push('tendoo_loader');
		$this->file->js_push('tendoo_app');
		$this->file->js_push('introjs/intro.min');
		// Load Pace
		//	$this->file->css_push('pace/themes/pace-theme-flash');
		// 	$this->file->js_push('pace/pace.min');
		// End Pace
		// var_dump($this->file);
	}
	// Public functions
	public function index()
	{
		$this->file->js_push('admin.index.intro');
		$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
		$this->data['ttTheme']		=	$this->tendoo_admin->countThemes();
		$this->data['ttModule']		=	$this->tendoo_admin->count_modules();
		$this->data['ttPages']		=	$this->tendoo_admin->countPages();
		$this->data['ttPrivileges']	=	$this->tendoo_admin->countPrivileges();
		$this->data['appIconApi']	=	$this->tendoo_admin->getAppIcon();
		$this->data['countUsers']	=	count($this->users_global->getAdmin());

		$this->tendoo->setTitle('Panneau de Contr&ocirc;le - Tendoo');
		
		$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
		$this->data['body']	=	$this->load->view('admin/index/body',$this->data,true,false,$this);
		$this->load->view('admin/header',$this->data,false,false,$this);
		$this->load->view('admin/global_body',$this->data,false,false,$this);
	}
	public function pages($e = '',$f = '')
	{
		if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE')))
		{
			$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
			$this->data['success']			=	notice_from_url();
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
							$this->notice->push_notice(tendoo_error($ttError.' erreurs trouvée(s), la création à été ignorée pour ces erreurs.'));
						}
						$this->notice->push_notice(notice('controllers_updated'));
					}
				}
				$this->file->css_push('controller_style');
				$this->file->js_push('jquery.nestable');
				$this->file->js_push('tendoo_controllersScripts'); // ControllersSripts
				$this->data['get_pages']	=	$this->tendoo->get_pages();
				$this->data['get_mod']		=	$this->tendoo_admin->get_bypage_module();
				
				$this->tendoo->setTitle('Gestion des contr&ocirc;leurs - Tendoo');
				$this->data['lmenu']		=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
				$this->data['body']			=	$this->load->view('admin/pages/body',$this->data,true,false,$this);
				
				$this->load->view('admin/header',$this->data,null,false,$this);
				$this->load->view('admin/global_body',$this->data,false,false,$this);
			}
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function modules($e = '',$a	=	1,$f = '')
	{
		$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
		$this->notice->push_notice(notice_from_url());
		if($e == '' || $e == 'main')
		{
			$this->data['mod_nbr']		= $this->tendoo_admin->count_modules();
			$page						=	$a;
			$this->data['paginate']			=	$this->tendoo->paginate(
				10,
				$this->data['mod_nbr'],
				1,
				"bg-color-blue fg-color-white",
				"bg-color-white fg-color-blue",
				$page,
				$this->url->site_url(array('admin','modules','main')).'/'
			); // Pagination
			
			if($this->data['paginate'] === FALSE): $this->url->redirect(array('error','code','page404')); endif; // Redirect if page is not valid
			
			$this->data['modules']		=	$this->tendoo_admin->get_modules($this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->tendoo->setTitle('Gestion des modules - Tendoo');	
			$this->data['notice']		=	$this->notice->push_notice(notice($f));
			$this->data['lmenu']		=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('admin/modules/body',$this->data,true);
			$this->load->view('admin/header',$this->data,false,false,$this);
			
			
			$this->load->view('admin/global_body',$this->data,false,false,$this);
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
			$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
			$this->load->library('form_validation');
$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('mod_id','','required|trim|alpha_dash|min_length[1]');
			if($this->form_validation->run())
			{
				$this->data['module']	=	$module 	= $this->tendoo->getSpeModule($this->input->post('mod_id'));
				$installexec			=	$this->tendoo_admin->uninstall_module($this->data['module'][0]['ID']);
				if($installexec)
				{
					$this->url->redirect(array('admin','modules','main',1,'module_uninstalled'));
				}
			}
			$this->data['module']	=	$module 	= $this->tendoo->getSpeModule($id);
			if(count($module) > 0)
			{
				$this->tendoo->setTitle('Desinstallation du plugin - '.$module[0]['NAMESPACE']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
				$this->data['body']	=	$this->load->view('admin/modules/uninstall',$this->data,true);
				
				$this->load->view('admin/header',$this->data,false,false,$this);
				$this->load->view('admin/global_body',$this->data,false,false,$this);
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
			if($this->tendoo_admin->moduleActivation($id))
			{
				$this->url->redirect(array('admin','modules?notice=done'));
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
				$this->url->redirect(array('admin','modules'));
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
			$index	=	$this->url->getRewrite()	==	true ? 1 : 0;
			$this->data['module']	=	$this->tendoo->getSpeModule((int)$a);
			if($this->data['module'] == TRUE) // rather than counting
			{
				$this->tendoo->setTitle('Panneau d\'administration du module - '.$this->data['module'][0]['NAMESPACE']); // DEFAULT NAME DEFINITION
				/* 	$baseUrl	= 	$this->url->site_url(array('admin','open','modules',$this->data['module'][0]['ID'])); */
				$detailsUri	=	$this->url->http_request(TRUE);
				include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
				include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/admin_controller.php');
				
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
				$this->data['interpretation']	=	$this->tendoo->interpreter($this->data['module'][0]['NAMESPACE'].'_admin_controller',$Method,$Parameters,$this->data);
				if($this->data['interpretation'] == '404')
				{
					$this->url->redirect(array('error','code','page404'));
				}
				if(is_array($this->data['interpretation']))
				{
					if(array_key_exists('MCO',$this->data['interpretation'])) // MCO : module content only, renvoi uniquement le contenu du module et non les pied et tete de l'espace administration.
					{
						if($this->data['interpretation']['MCO'] == TRUE)
						{
							$this->data['body']['RETURNED']	=	array_key_exists('RETURNED',$this->data['interpretation']) ? 
								$this->data['interpretation']['RETURNED'] : 
								$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "RETURNED". Le module chargé renvoi un tableau incorrect ou incomplet.'); // If array key forget, get all content as interpretation.
							$this->data['body']['MCO']		=	$this->data['interpretation']['MCO'];
							$this->load->view('admin/global_body',$this->data,false,false,$this);
						}
					}
					else
					{
						$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "MCO". Le module chargé renvoi un tableau incorrect ou incomplet.');
					}
				}
				else
				{
					$this->data['body']['RETURNED']	=	$this->data['interpretation'];
					$this->data['body']['MCO']		=	FALSE;
					$this->data['lmenu']			=	$this->load->view('admin/left_menu',$this->data,true);
					
					$this->load->view('admin/header',$this->data,false,false,$this);
					$this->load->view('admin/global_body',$this->data,false,false,$this);
				}
			}
			else
			{
				$this->url->redirect(array('admin/modules?notice=unknowModule'));
			}
		}
	}
	public function setting($action = 'main',$query_1='',$query_2='')
	{
		if($action	==	'main')
		{
		$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
		$this->load->library('form_validation');
$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
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
			$this->load->library('form_validation');
			$this->form_validation->set_rules('theme_style','"Nom du thème"','required|min_length[1]|max_length[15]');
			
			if($this->form_validation->run())
			{
				$themeName	=	$this->users_global->editThemeStyle($this->input->post('theme_style'));
			}
			if($newName || $newLogo || $newHoraire || $newFormat || $themeName)
			{
				$this->url->redirect(array('admin','setting?notice=done'));
			}
			else
			{
				$this->notice->push_notice(notice('error_occured'));
			}
		}
		if($this->users_global->isSuperAdmin()) // this Setting is now reserved to super admin
		{
			$this->data['result']	=	'';
			if($this->input->post('autoriseRegistration')) // Setting notice go here.
			{
				if($this->tendoo_admin->editRegistration($this->input->post('allowRegistration')))
				{
					$this->notice->push_notice(notice('done'));
				}
				else
				{
					$this->notice->push_notice(notice('error_occured'));
				}
			}
			if($this->input->post('allow_priv_selection_button')) // Setting notice go here.
			{
				if($this->tendoo_admin->editPrivilegeAccess($this->input->post('allow_priv_selection')))
				{
					$this->notice->push_notice(notice('done'));
				}
				else
				{
					$this->notice->push_notice(notice('error_occured'));
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
					$this->notice->push_notice(notice('error_occured'));
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
					$this->notice->push_notice(notice('error_occured'));
				}
			}
		}
		$this->data['appIconApi']	=	$this->tendoo_admin->getAppIcon();
		$this->data['options']		=	$this->tendoo->getOptions();
		
		$this->tendoo->setTitle('Param&egrave;tres - Tendoo');
		$this->data['lmenu']		=	$this->load->view('admin/left_menu',$this->data,true);
		$this->data['body']			=	$this->load->view('admin/setting/body',$this->data,true);
		
		$this->load->view('admin/header',$this->data,false,false,$this);
		$this->load->view('admin/global_body',$this->data,false,false,$this);
		}
	}
	public function themes($e	=	'main', $a	= 1)
	{
		if($this->users_global->isSuperAdmin()	|| $this->tendoo_admin->adminAccess('system','gestheme',$this->users_global->current('PRIVILEGE')))
		{
			$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
			if($e == 'main')
			{
				$page	=	$a;
				$this->file->js_push('jtransit/jquery.transit.min');
								
				$this->tendoo->setTitle('Gestion des th&egrave;mes - Tendoo');
				$this->data['ttThemes']	=	$this->tendoo_admin->countThemes();
				$this->data['paginate']	=	$this->tendoo->paginate(
					10,
					$this->data['ttThemes'],
					1,
					"bg-color-blue fg-color-white",
					"bg-color-white fg-color-blue",
					$page,
					$this->url->site_url(array('admin','modules','main')).'/'
				); // Pagination
				
				$this->data['Themes']	=	$this->tendoo_admin->getThemes($this->data['paginate'][1],$this->data['paginate'][2]);
				$this->data['lmenu']	=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']		=	$this->load->view('admin/themes/main',$this->data,true);
				
				$this->load->view('admin/header',$this->data,false,false,$this);
				$this->load->view('admin/global_body',$this->data,false,false,$this);
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
			else if($e ==  'config') // Added 0.9.2
			{
				$this->data['Spetheme']	=	$this->tendoo_admin->isTheme($a);
				if(is_array($this->data['Spetheme'])) 
				{
					// Si la re-écriture est activé, on réduit l'index. 
					$index	=	$this->url->getRewrite()	==	true ? 1 : 0;
					$Parameters			=	$this->url->http_request(TRUE);
					$admin_controler	=	THEMES_DIR.$this->data['Spetheme'][0]['ENCRYPTED_DIR'].'/admin_controller.php';
					$library			=	THEMES_DIR.$this->data['Spetheme'][0]['ENCRYPTED_DIR'].'/library.php';
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
						$this->data['interpretation']	=	$this->tendoo->interpreter($this->data['Spetheme'][0]['NAMESPACE'].'_theme_admin_controller',$Method,$Parameters,$this->data);
						if($this->data['interpretation'] == '404')
						{
							$this->url->redirect(array('error','code','page404'));
						}
						if(is_array($this->data['interpretation']))
						{
							if(array_key_exists('MCO',$this->data['interpretation']))
							{
								if($this->data['interpretation']['MCO'] == TRUE)
								{
									$this->data['body']['RETURNED']	=	array_key_exists('RETURNED',$this->data['interpretation']) ? 
										$this->data['interpretation']['RETURNED'] : 
										$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "RETURNED". Le module chargé renvoi un tableau incorrect ou incomplet.'); // If array key forget, get all content as interpretation.
									$this->data['body']['MCO']		=	$this->data['interpretation']['MCO'];
									$this->load->view('admin/global_body',$this->data,false,false,$this);
								}
							}
							else
							{
								$this->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "MCO". Le module chargé renvoi un tableau incorrect ou incomplet.');
							}
						}
						else
						{
							$this->data['body']['RETURNED']	=	$this->data['interpretation'];
							$this->data['body']['MCO']		=	FALSE;
							
							$this->load->view('admin/header',$this->data,false,false,$this);
							$this->load->view('admin/global_body',$this->data,false,false,$this);
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
			$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
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
				$this->notice->push_notice(notice($query));
			}
			$this->tendoo->setTitle('Installer une application - Tendoo');
			$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/installer/install',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);
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
		$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
		(!$this->users_global->isSuperAdmin()) ? $this->url->redirect(array('admin','index?notice=accessDenied')) : null;
		// Proceed
		if($option	==	'index')
		{
			$this->data['pageTitle']	=	'Syst&ecirc;me et restauration - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/body',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
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
						$this->notice->push_notice(notice('adminCreationFailed'));
						break;
					case 'adminCreated'	:
						$this->url->redirect(array('admin','system','createAdmin?notice=adminCreated'));
						break;
					case 'adminCreationFailed'	:
						$this->url->redirect(array('admin','system','createAdmin?notice=adminCreationFailed'));
				}
			}
			$this->data['getPrivs']		=	$this->tendoo_admin->getPrivileges();
			$this->data['pageTitle']	=	'Gestion des utilisateurs - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/createAdmin',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
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
					$this->notice->push_notice(notice('error_occured'));
				}
			}
			
			$this->session->set_userdata('privId',$this->tendoo_admin->getPrivId());
			$this->data['privId']		=	$this->session->userdata('privId');
			$this->data['pageTitle']	=	'Cr&eacute;er un privil&egrave;ge - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/create_privilege',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
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
					$this->notice->push_notice(notice('error_occured'));
				}
			}
			$this->data['getPriv']		=	$this->tendoo_admin->getPrivileges($option_2);
			if(count($this->data['getPriv']) == 0)
			{
				$this->url->redirect(array('error','code','privilegeNotFound'));
			}
			$this->data['pageTitle']	=	'Modifier un privil&egrave;ge - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/edit_privilege',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
		
		}
		else if($option	==	'manage_actions')
		{
			if(!$this->tendoo_admin->hasPriv())
			{
				$this->url->redirect(array('admin','system','create_privilege?notice=mustCreatePrivilege'));
			}
			$this->data['ttPrivileges']	=	$this->tendoo_admin->countPrivileges();
			$this->data['getPrivileges']=	$this->tendoo_admin->getPrivileges();
			$this->data['ttModules']	=	count($this->tendoo_admin->get_modules());
			$this->data['paginate']		=	$this->tendoo->paginate(10,$this->data['ttModules'],1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','manage_actions')).'/');
			$this->data['getModules']	=	$this->tendoo_admin->get_modules($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->data['pageTitle']	=	'Gestionnaire d\'actions - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/privileges_and_actions',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
		}
		else if($option	==	'ajax_manage_system_actions')
		{
			if(isset($_POST['QUERY']))
			{
				if($this->tendoo_admin->addActionToPriv($_POST['QUERY'],'system'))
				{
					$this->data['state']	=	true;
					$this->data['body']	=	$this->load->view('admin/system/ajax_priv_action',$this->data);
				}
				else
				{
					$this->data['state']	=	false;
					$this->data['body']	=	$this->load->view('admin/system/ajax_priv_action',$this->data);
				}
			}
		}
		else if($option	==	'ajax_manage_common_actions')
		{
			if(isset($_POST['QUERY_2']))
			{
				if($this->tendoo_admin->addActionToPriv_MTW($_POST['QUERY_2'],'modules'))
				{
					$this->data['state']	=	true;
					$this->data['body']	=	$this->load->view('admin/system/ajax_priv_action_2',$this->data);
				}
				else
				{
					$this->data['state']	=	false;
					$this->data['body']	=	$this->load->view('admin/system/ajax_priv_action_2',$this->data);
				}
			}
		}
		else if($option	==	'privilege_list')
		{
			$this->data['ttPrivileges']	=	$this->tendoo_admin->countPrivileges();
			$this->data['paginate']		=	$this->tendoo->paginate(10,$this->data['ttPrivileges'],1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','privilege_list')).'/');
			$this->data['getPriv']		=	$this->tendoo_admin->getPrivileges($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->data['pageTitle']	=	'Privil&egrave;ges et actions - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/privilege_list',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
		
		}
		else if($option == 'delete_priv')
		{
			$this->data['deletion']	=	$this->tendoo_admin->deletePrivilege($option_2);		
			$this->url->redirect(array('admin','system','privilege_list?notice='.$this->data['deletion']));			
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
					$this->notice->push_notice(notice($query));
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
						$this->notice->push_notice(notice('error_occured'));
					}
				}
			}
			
			$this->data['getPrivs']		=	$this->tendoo_admin->getPrivileges();
			$this->data['adminInfo']	=	$this->users_global->getSpeAdminByPseudo($option_2);
			$this->data['pageTitle']	=	'Profil Utilisateur &raquo; '.$this->data['adminInfo']['PSEUDO'].' - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/editAdmin',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
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
						$this->notice->push_notice(notice('cmsRestored'));
					}
					else
					{
						$this->notice->push_notice(notice('cmsRestorationFailed'));
					}
				}
				$this->data['pageTitle']	=	'Restauration souple du syst&egrave;me - Tendoo';
				$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
				$this->data['body']	=	$this->load->view('admin/system/restore_soft',$this->data,true);
				
				$this->load->view('admin/header',$this->data,false,false,$this);
				$this->load->view('admin/global_body',$this->data,false,false,$this);	
			}
			else if($option_2	==	'hard') // hard
			{
				$this->form_validation->set_rules('admin_password','Mot de passe administrateur','trim|required|min_length[6]|max_length[30]');
				if($this->form_validation->run())
				{
				}
				$this->data['pageTitle']	=	'Restauration brutale du syst&egrave;me';
				$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
				$this->data['body']	=	$this->load->view('admin/system/restore_hard',$this->data,true);
				
				$this->load->view('admin/header',$this->data,false,false,$this);
				$this->load->view('admin/global_body',$this->data,false,false,$this);	
			}
		}
		else if($option	== 'adminMain')
		{
			$this->data['ttAdmin']		=	count($this->users_global->getAdmin());
			$this->data['paginate']		=	$this->tendoo->paginate(10,$this->data['ttAdmin'],1,'bg-color-red fg-color-white','',$option_2,$this->url->site_url(array('admin','system','adminMain')).'/');
			
			
			$this->data['subadmin']		=	$this->users_global->getAdmin($this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->data['pageTitle']	=	'Gestion des utilisateurs - Tendoo';
			$this->tendoo->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/system/adminList',$this->data,true);
			
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);	
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
        $this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
        $this->data['pageDescription']	=	$this->tendoo->getVersion();
        
        $this->tendoo->setTitle('Utilitaires - Tendoo');
        $this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
        $this->data['body']	=	$this->load->view('admin/tools/body',$this->data,true);
        $this->load->view('admin/header',$this->data,false,false,$this);
        $this->load->view('admin/global_body',$this->data,false,false,$this);
		}
		else if($action == 'calendar')
		{
			 $this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
			$this->data['pageDescription']	=	$this->tendoo->getVersion();
			
			$this->tendoo->setTitle('Utilitaires - Tendoo');
			$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/tools/calendar',$this->data,true);
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);
		}
		else if($action == 'stats')
		{
			$this->data['Stats']			=	$this->tendoo_admin->tendoo_visit_stats();
			$this->data['priv_stats']		=	$this->tendoo_admin->privilegeStats();
			 $this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
			$this->data['pageDescription']	=	$this->tendoo->getVersion();
			
			$this->tendoo->setTitle('Utilitaires &raquo; Statistiques - Tendoo');
			$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/tools/stats',$this->data,true);
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);
		}
		else if($action == 'seo')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('autoGenerate','Générer automatiquement un sitemap','required');
			if($this->form_validation->run())
			{
				$this->tendoo_sitemap->create_sitemap_automatically();
			}
			$this->data['getSitemap']		=	$this->tendoo_sitemap->getSitemap();
			$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true,false,$this);
			$this->data['pageDescription']	=	$this->tendoo->getVersion();
			
			$this->tendoo->setTitle('Utilitaires &raquo; Outils SEO - Tendoo');
			$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true,false,$this);
			$this->data['body']	=	$this->load->view('admin/tools/seo',$this->data,true);
			$this->load->view('admin/header',$this->data,false,false,$this);
			$this->load->view('admin/global_body',$this->data,false,false,$this);
		}
		else
		{
			$this->url->redirect(array('error','code','page404'));
		}
    }
	public function ajax($option,$x	=	'',$y = '',$z = '')
	{
		if($option == 'toogle_app_tab')
		{
			if(!$this->users_global->toggleAppTab())
			{
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('error_occured');
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		if($option == 'setViewed')
		{
			$page	=	isset($_GET['page']) ? $_GET['page'] : '';
			$this->users_global->setViewed($page);
		}
		if($option == 'get_app_tab')
		{
			$this->data['appIconApi']	=	$this->tendoo_admin->getAppIcon();
			$this->load->view('admin/ajax/get_app_tab',$this->data);
		}
		else if($option	==	'upController')
		{
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE'))== FALSE)
			{
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('accessDenied');
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_admin->upController($x);
				$this->data['type'] =	'success';
				$this->data['notice'] =	notice('done');
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option	== 'store_connect')
		{
			$site_options	=	$this->tendoo->getOptions();
			if((int)$site_options[0]['CONNECT_TO_STORE'] == 1)
			{
				$this->tendoo->store_connect();
			}
			else
			{
				$this->data['type'] =	'wraning';
				$this->data['notice'] =	tendoo_info('Impossible d\'acc&eacute;der au Store. Option d&eacute;sactiv&eacute;e');
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option	==	'toggleFirstVisit')
		{
			if(!$this->users_global->toggleFirstVisit())
			{
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('accessDenied');
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
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('accessDenied');
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
		else if($option	==	'toggleWelcomeMessage')
		{
			$this->users_global->toggleWelcomeMessage();
			$this->load->view('admin/ajax/done',$this->data);
		}
		else if($option	==	'toggleAdminStats')
		{
			$this->users_global->switchShowAdminIndex();
			$this->load->view('admin/ajax/done',$this->data);
		}
		else if($option == 'sm_manual')
		{
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('PRIVILEGE'))== FALSE)
			{
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('accessDenied');
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_sitemap->create_sitemap_manually($this->input->post('sitemap'));
				$this->data['type'] =	'success';
				$this->data['notice'] =	notice('done');
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option == 'sm_remove')
		{
			if($this->users_global->isSuperAdmin() == FALSE && $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('PRIVILEGE'))== FALSE)
			{
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('accessDenied');
				$this->load->view('admin/ajax/notice',$this->data);
			}
			else
			{
				$this->tendoo_sitemap->remove_sitemap();
				$this->data['type'] =	'success';
				$this->data['notice'] =	notice('done');
				$this->load->view('admin/ajax/notice',$this->data);
			}
		}
		else if($option	== 'create_controller')
		{
			if($this->users_global->isSuperAdmin() === FALSE	&& !$this->tendoo_admin->adminAccess('system','gestpa',$this->users_global->current('PRIVILEGE')))
			{
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('accessDenied');
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			$this->form_validation->set_rules('page_name','Nom de la page','trim|required|min_length[2]|max_length[100]');
			$this->form_validation->set_rules('page_cname','Nom du contr&ocirc;leur','alpha_dash|trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_title','Titre du contr&ocirc;leur','trim|required|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('page_module','Affecter un module','trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_priority','Definir comme page principale','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_description','description de la page','trim|required|min_length[2]|max_length[2000]');
			$this->form_validation->set_rules('page_visible','Visibilité de la page','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_parent','Emplacement du contr&ocirc;leur','trim|required|min_length[1]');
			$this->form_validation->set_rules('page_keywords','Emplacement du contr&ocirc;leur','trim|required|min_length[1]');

			if($this->form_validation->run())
			{
				$this->data['result']	=	$this->tendoo_admin->controller(
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
					
				);	
				if($this->data['result'] == 'controler_created')
				{
					$this->data['get_pages']	=	$this->tendoo->get_pages();
					$this->load->view('admin/ajax/controller_create_success',$this->data);
					// $this->url->redirect(array('admin/pages?notice=controler_created'));
				}
				else
				{
					$this->load->view('admin/ajax/controller_create_fail_2',$this->data);
					//$this->notice->push_notice(notice($this->data['error']));
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
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('error_occured');
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			$this->form_validation->set_rules('page_name','Nom de la page','trim|required|min_length[2]|max_length[100]');
			$this->form_validation->set_rules('page_cname','Code du controleur','alpha_dash|trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_title','Titre du controleur','trim|required|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('page_module','D&eacute;finir le module','trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('page_priority','Definir comme page principale','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_visible','Visibilité de la page','trim|required|min_length[4]|max_length[5]');
			$this->form_validation->set_rules('page_description','champ description du controleur','trim|required|min_length[2]|max_length[2000]');
			$this->form_validation->set_rules('page_id','Identifiant de la page','required');
			$this->form_validation->set_rules('page_parent','Emplacement du contr&ocirc;leur','trim|required|min_length[1]');
			$this->form_validation->set_rules('page_keywords','Mots cl&eacute;s du cont&ocirc;leur','trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				$this->data['notice']	=	$this->tendoo_admin->controller(
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
				);
				$this->notice->push_notice(notice($this->data['notice']));
				if($this->data['notice']	==	'controler_edited')
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
				$this->data['type'] =	'danger';
				$this->data['notice'] =	notice('error_occured');
				$this->load->view('admin/ajax/notice',$this->data);
				return;
			}
			$this->data['getSpeController']	=	$this->tendoo_admin->get_controller($y);
			$this->load->view('admin/ajax/load_controller',$this->data);
		}
	}
}