<?php 
class Admin
{
	private $data;
	private $core;
	public function __construct()
	{
		$this->core					=	Controller::instance();
		$this->load					=	$this->core->load;
		$this->load->library('users_global');
		
		$this->installStatus();				// 	Install Status
		$this->adminConnection(); 			// 	Admin Users Libraries
		$this->loadLibraries();				//	Affecting Libraries */
		$this->construct_end();				// 	Fin du constructeur
		$this->data['pageDescription']	=	$this->core->hubby->getVersion();
		
		/*$this->hubby_admin->system_not('Modifier vos param&ecirc;tre de s&eacute;curit&eacute;', 'Mettez vous &agrave; jour avec cette version', '#', '10 mai 2013', null);*/
	}
	private function installStatus()
	{
		if(!$this->core->hubby->isInstalled())
		{
			$this->core->url->redirect('install/step/1');
		}
	}
	private function construct_end()
	{
		$this->hubby_admin			=&	$this->core->hubby_admin;
		// GLOBAL NOTICE
		$this->data['global_notice']	=	$this->core->hubby_admin->get_global_info();
		foreach($this->data['global_notice'] as $gl)
		{
			$this->hubby_admin->system_not('Syst&egrave;me', strip_tags(notice($gl)), '#',null, null);
			$this->notice->push_notice(notice($gl));
		}
		$this->loadOuputFile();
	}
	private function adminConnection()
	{
		(!$this->core->users_global->hasAdmin()) ?  $this->core->url->redirect(array('registration','superAdmin')): FALSE;
		(!$this->core->users_global->isConnected()) ? $this->core->url->redirect(array('login?ref='.urlencode($this->core->url->request_uri()))) : FALSE;
		(!$this->core->users_global->isAdmin())	?	$this->core->url->redirect(array('error','code','accessDenied')) : FALSE;
		$this->data['options']		=	$this->core->hubby->getOptions();
	}
	private function loadLibraries()
	{
		$this->load->library('hubby_admin');
		$this->load->library('pagination');
		$this->load->library('file');
		$this->load->library('file',null,'file_2');
		$this->load->library('form_validation');
		$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		$this->input				=&	$this->core->input;
		$this->notice				=&	$this->core->notice;
		$this->file					=&	$this->core->file;
		$this->pagination			=&	$this->core->pagination;
		$this->form_validation		=&	$this->core->form_validation;
		$this->data['notice']		=	'';
		$this->data['error']		=	'';
		$this->data['success']		=	'';
		if($this->data['options'][0]['PUBLIC_PRIV_ACCESS_ADMIN'] == '0') // If public priv is not allowed, not check current user priv class
		{
			$priv				=	$this->core->users_global->current('PRIVILEGE');
			if(!in_array($priv,$this->core->users_global->systemPrivilege()))
			{
				$cur_priv			=	$this->core->hubby_admin->getPrivileges($priv);
				if($cur_priv[0]['IS_SELECTABLE'] == '1') // Is selectable
				{
					$this->core->url->redirect(array('error','code','accessDenied')); // Access denied for public priv admins.
				}
			}
		}
	}
	private function loadOuputFile()
	{
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('css1');
		$this->core->file->css_push('css2');
		$this->core->file->css_push('hubby_global');

		$this->core->file->js_push('jquery-1.9');
		$this->core->file->js_push('jquery.pjax');
		$this->core->file->js_push('morris.min');
		$this->core->file->js_push('raphael-min');
		$this->core->file->js_push('bubbles');
		$this->core->file_2->js_push('app.v2');
		$this->core->file->js_push('hubby_app');
	}
	// Public functions
	public function index()
	{
		$this->core->file_2->js_push('jquery.gridster');
		$this->core->file->css_push('jquery.gridster.min');
		$this->core->file->css_push('demo');
		$this->data['inner_head']	=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['ttTheme']		=	$this->core->hubby_admin->countThemes();
		$this->data['ttModule']		=	$this->core->hubby_admin->count_modules();
		$this->data['ttPages']		=	$this->core->hubby_admin->countPages();
		$this->data['ttPrivileges']	=	$this->core->hubby_admin->countPrivileges();
		$this->data['Stats']		=	$this->core->hubby_admin->hubby_visit_stats();

		$this->core->hubby->setTitle('Panneau de Contr&ocirc;le - Hubby');$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
		$this->data['body']	=	$this->load->view('admin/index/body',$this->data,true);
		
		$this->load->view('admin/header',$this->data);
		$this->load->view('admin/global_body',$this->data);
	}
	public function pages($e = '',$f = '')
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('system','gestpa',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
			$this->data['success']			=	notice_from_url();
			if($e == '')
			{
				$this->data['get_pages']	=	$this->core->hubby->get_pages();

				$this->core->hubby->setTitle('Gestion des contr&ocirc;leurs');
				$this->data['lmenu']		=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']			=	$this->load->view('admin/pages/body',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);
			}
			else if($e == 'edit' && $f != '')
			{
				$this->form_validation->set_rules('page_name','Nom de la page','trim|required|min_length[2]|max_length[100]');
				$this->form_validation->set_rules('page_cname','Nom du controleur','alpha_dash|trim|required|min_length[2]|max_length[30]');
				$this->form_validation->set_rules('page_title','Titre du controleur','trim|required|min_length[2]|max_length[50]');
				$this->form_validation->set_rules('page_module','D&eacute;finir le module','trim|required|min_length[2]|max_length[30]');
				$this->form_validation->set_rules('page_priority','Definir comme page principale','trim|required|min_length[4]|max_length[5]');
				$this->form_validation->set_rules('page_visible','Visibilité de la page','trim|required|min_length[4]|max_length[5]');
				$this->form_validation->set_rules('page_description','champ description du controleur','trim|required|min_length[2]|max_length[100]');
				$this->form_validation->set_rules('page_id','Identifiant de la page','required');
				$this->form_validation->set_rules('page_parent','Emplacement du contr&ocirc;leur','trim|required|min_length[1]');
				if($this->form_validation->run())
				{
					$this->data['notice']	=	$this->core->hubby_admin->controller(
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
						$this->input->post('page_link')
					);
					$this->core->notice->push_notice(notice($this->data['notice']));
					if($this->data['notice']	==	'controler_edited')
					{
						$this->core->url->redirect(array('admin/pages?notice='.$this->data['notice']));
					}
				}
				$this->data['createC']		=	$this->core->hubby->getControllers();
				$this->data['get_mod']		=	$this->core->hubby_admin->get_bypage_module();
				$this->data['get_pages']	=	$this->core->hubby->get_pages($f);
				if($this->data['get_pages'] == null)
				{
					$this->core->url->redirect(array('admin/pages?notice=controller_not_found'));
				}
				$this->core->hubby->setTitle('Modifier un contr&ocirc;leur');$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']	=	$this->load->view('admin/pages/edit_body',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);
			}
			else if($e == 'create')
			{
				$this->form_validation->set_rules('page_name','Nom de la page','trim|required|min_length[2]|max_length[100]');
				$this->form_validation->set_rules('page_cname','Nom du contr&ocirc;leur','alpha_dash|trim|required|min_length[2]|max_length[30]');
				$this->form_validation->set_rules('page_title','Titre du contr&ocirc;leur','trim|required|min_length[2]|max_length[50]');
				$this->form_validation->set_rules('page_module','Affecter un module','trim|required|min_length[2]|max_length[30]');
				$this->form_validation->set_rules('page_priority','Definir comme page principale','trim|required|min_length[4]|max_length[5]');
				$this->form_validation->set_rules('page_description','description de la page','trim|required|min_length[2]|max_length[100]');
				$this->form_validation->set_rules('page_visible','Visibilité de la page','trim|required|min_length[4]|max_length[5]');
				$this->form_validation->set_rules('page_parent','Emplacement du contr&ocirc;leur','trim|required|min_length[1]');
	
				if($this->form_validation->run())
				{
					$this->data['error']	=	$this->core->hubby_admin->controller(
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
						$this->input->post('page_link')
						
					);	
					if($this->data['error'] == 'controler_created')
					{
						$this->core->url->redirect(array('admin/pages?notice=controler_created'));
					}
					$this->core->notice->push_notice(notice($this->data['error']));
				}
				$this->data['createC']		=	$this->core->hubby->getControllers();
				$this->data['get_mod']		=	$this->core->hubby_admin->get_bypage_module();
				$this->core->hubby->setTitle('Cr&eacute;er un contr&ocirc;leur');$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']	=	$this->load->view('admin/pages/create_body',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);
			}
			elseif($e == 'delete')
			{
				$this->data['notice']	=	$this->core->hubby_admin->delete_controler($f);
				$this->core->url->redirect(array('admin/pages?notice='.$this->data['notice']));
			}
			elseif($e == 'manage')
			{
				$this->core->hubby->setTitle('Gestion des cont&ocirc;leurs');
				$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']	=	$this->load->view('admin/pages/controler_manage',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);
			
			}
		}
		else
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function modules($e = '',$a	=	1,$f = '')
	{
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->notice->push_notice(notice_from_url());
		if($e == '' || $e == 'main')
		{
			$this->data['mod_nbr']		= $this->core->hubby_admin->count_modules();
			$page						=	$a;
			$this->data['paginate']			=	$this->core->hubby->paginate(
				10,
				$this->data['mod_nbr'],
				1,
				"bg-color-blue fg-color-white",
				"bg-color-white fg-color-blue",
				$page,
				$this->core->url->site_url(array('admin','modules','main')).'/'
			); // Pagination
			
			if($this->data['paginate'] === FALSE): $this->core->url->redirect(array('error','code','page404')); endif; // Redirect if page is not valid
			
			$this->data['modules']		=	$this->core->hubby_admin->get_modules($this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->core->hubby->setTitle('Gestion des modules - Hubby');	
			$this->data['notice']		=	$this->notice->push_notice(notice($f));$this->data['lmenu']		=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('admin/modules/body',$this->data,true);
			$this->load->view('admin/header',$this->data);
			
			
			$this->load->view('admin/global_body',$this->data);
		}
	}
	public function uninstall($e ='',$id= '')
	{
		if($e == 'module')
		{
			if( !$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('system','gestmo',$this->core->users_global->current('PRIVILEGE')))
			{
				$this->core->url->redirect(array('admin','index?notice=accessDenied'));
				return;
			}
			$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
			$this->load->library('form_validation');
$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('mod_id','','required|trim|alpha_dash|min_length[1]');
			if($this->form_validation->run())
			{
				$this->data['module']	=	$module 	= $this->core->hubby->getSpeModule($this->input->post('mod_id'));
				$installexec			=	$this->core->hubby_admin->uninstall_module($this->data['module'][0]['ID']);
				if($installexec)
				{
					$this->core->url->redirect(array('admin','modules','main',1,'module_uninstalled'));
				}
			}
			$this->data['module']	=	$module 	= $this->core->hubby->getSpeModule($id);
			if(count($module) > 0)
			{
				$this->core->hubby->setTitle('Desinstallation du plugin - '.$module[0]['NAMESPACE']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']	=	$this->load->view('admin/modules/uninstall',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);
			}
			else
			{
				$this->core->url->redirect(array('error','code','unknowModule'));
			}
		}
	}
	public function active($e,$id)
	{
		if($e	== 	'module')
		{
			if($this->core->hubby_admin->moduleActivation($id))
			{
				$this->core->url->redirect(array('admin','modules?notice=done'));
				return true;
			}
		}
		$this->core->url->redirect(array('admin','modules?notice=error_occured'));
		return false;
	}
	public function unactive($e,$id)
	{
		if($e	== 	'module')
		{
			$mod	=	$this->core->hubby_admin->getSpeMod($id,TRUE);
			if($mod)
			{
				$this->core->db->where('ID',$id)->update('hubby_modules',array(
					'ACTIVE'	=>	0
				));
				$this->core->url->redirect(array('admin','modules'));
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
			$this->core->url->redirect(array('error','code','page404'));
		}
		else if($e == 'modules')
		{
			$this->data['module']	=	$this->core->hubby->getSpeModule($a);
			if(count($this->data['module']) > 0)
			{
				$this->core->hubby->setTitle('Panneau d\'administration du module - '.$this->data['module'][0]['NAMESPACE']); // DEFAULT NAME DEFINITION
				/* 	$baseUrl	= 	$this->core->url->site_url(array('admin','open','modules',$this->data['module'][0]['ID'])); */
				$detailsUri	=	$this->core->url->http_request(TRUE);
				
				include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
				include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/admin_controller.php');
				
				$Parameters			=	$this->core->url->http_request(TRUE);
				if(array_key_exists(4,$Parameters))
				{
					$Method				=	$Parameters[4];
				}
				else
				{
					$Method			=	'index';
				}
				for($i = 0;$i < 5;$i++)
				{
					array_shift($Parameters);
				}
				$this->data['interpretation']	=	$this->core->hubby->interpreter($this->data['module'][0]['NAMESPACE'].'_admin_controller',$Method,$Parameters,$this->data);
				if($this->data['interpretation'] == '404')
				{
					$this->core->url->redirect(array('error','code','page404'));
				}
				if(is_array($this->data['interpretation']))
				{
					if(array_key_exists('MCO',$this->data['interpretation'])) // MCO : module content only, renvoi uniquement le contenu du module et non les pied et tete de l'espace administration.
					{
						if($this->data['interpretation']['MCO'] == TRUE)
						{
							$this->data['body']['RETURNED']	=	array_key_exists('RETURNED',$this->data['interpretation']) ? 
								$this->data['interpretation']['RETURNED'] : 
								$this->core->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "RETURNED". Le module chargé renvoi un tableau incorrect ou incomplet.'); // If array key forget, get all content as interpretation.
							$this->data['body']['MCO']		=	$this->data['interpretation']['MCO'];
							$this->load->view('admin/global_body',$this->data);
						}
					}
					else
					{
						$this->core->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "MCO". Le module chargé renvoi un tableau incorrect ou incomplet.');
					}
				}
				else
				{
					$this->data['body']['RETURNED']	=	$this->data['interpretation'];
					$this->data['body']['MCO']		=	FALSE;$this->data['lmenu']			=	$this->load->view('admin/left_menu',$this->data,true);
					
					$this->load->view('admin/header',$this->data);
					$this->load->view('admin/global_body',$this->data);
				}
			}
			else
			{
				$this->core->url->redirect(array('admin/modules?notice=unknowModule'));
			}
		}
	}
	public function setting()
	{
		if($this->core->users_global->isSuperAdmin()) // Setting is now reserved to super admin
		{
			$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
			$this->load->library('form_validation');
$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->load->helper('date');
			if($this->input->post('newName'))
			{
				$this->form_validation->set_rules('newName','"Du nom du site"','required|min_length[4]|max_length[15]');
				if($this->form_validation->run())
				{
					if($this->core->hubby_admin->editSiteName($this->input->post('newName')))
					{
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error'));
					}
				}
			}
			if($this->input->post('newLogo'))
			{
				$this->form_validation->set_rules('newLogo','"De l\'url du logo du site"','required|min_length[4]|max_length[200]');
				if($this->form_validation->run())
				{
					if($this->core->hubby_admin->editLogoUrl($this->input->post('newLogo')))
					{
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error'));
					}
				}
			}
			if($this->input->post('newHoraire'))
			{
				$this->form_validation->set_rules('newHoraire','"Du fuseau horaire"','required|min_length[1]|max_length[20]');
				if($this->form_validation->run())
				{
					if($this->core->hubby_admin->editTimeZone($this->input->post('newHoraire')))
					{
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error'));
					}
				}
			}
			if($this->input->post('newFormat'))
			{
				$this->form_validation->set_rules('newFormat','"Du format horaire"','required|min_length[6]|max_length[10]');
				if($this->form_validation->run())
				{
					if($this->core->hubby_admin->editTimeFormat($this->input->post('newFormat')))
					{
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error'));
					}
				}
			}
			$this->data['result']	=	'';
			if($this->input->post('other_setting')) // Setting notice go here.
			{
				if($this->input->post('show_welcome_msg'))
				{
					$this->core->hubby_admin->editShowMessage($this->input->post('show_welcome_msg'));
				}
				$this->core->notice->push_notice(notice('done'));
			}
			if($this->input->post('autoriseRegistration')) // Setting notice go here.
			{
				if($this->core->hubby_admin->editRegistration($this->input->post('allowRegistration')))
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			if($this->input->post('them_style_button')) // Setting notice go here.
			{
				if($this->core->hubby_admin->editThemeStyle($this->input->post('them_style')))
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			if($this->input->post('allow_priv_selection_button')) // Setting notice go here.
			{
				if($this->core->hubby_admin->editPrivilegeAccess($this->input->post('allow_priv_selection')))
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			if($this->input->post('publicPrivAccessAdmin_button')) // Setting notice go here.
			{
				if($this->core->hubby_admin->editAllowAccessToPublicPriv($this->input->post('publicPrivAccessAdmin')))
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			
			$this->data['options']		=	$this->core->hubby->getOptions();
			
			$this->core->hubby->setTitle('Param&ecirc;tres - Hubby');$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/setting/body',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);
		}
		else
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
			return;
		}
	}
	public function themes($e	=	'main', $a	= 1)
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('system','gestheme',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
			if($e == 'main')
			{
				$page	=	$a;
				
				$this->core->hubby->setTitle('Gestion des th&egrave;mes - Hubby');
				$this->data['ttThemes']	=	$this->core->hubby_admin->countThemes();
				$this->data['paginate']	=	$this->core->hubby->paginate(
					10,
					$this->data['ttThemes'],
					1,
					"bg-color-blue fg-color-white",
					"bg-color-white fg-color-blue",
					$page,
					$this->core->url->site_url(array('admin','modules','main')).'/'
				); // Pagination
				
				$this->data['Themes']	=	$this->core->hubby_admin->getThemes($this->data['paginate'][1],$this->data['paginate'][2]);
				$this->data['lmenu']	=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']		=	$this->load->view('admin/themes/main',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);
			}
			else if($e == 'manage')
			{
				$this->load->library('form_validation');
$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
				$this->form_validation->set_rules('setDefault','Définir par d&eacute;faut');
				$this->form_validation->set_rules('theme_id','identifiant du theme','required');
				if($this->form_validation->run())
				{
					if($this->input->post('setDefault') == 'ADMITSETDEFAULT')
					{
						$this->data['queryResult']	=	$this->core->hubby_admin->setDefault($this->input->post('theme_id'));
					}
				}
				$this->form_validation->set_rules('delete','Supprimer le th&egrave;me');
				$this->form_validation->set_rules('theme_id','identifiant du theme','required');
				if($this->form_validation->run())
				{
					if($this->input->post('delete') == 'ADMITDELETETHEME')
					{
						$this->data['queryResult']	=	$this->core->hubby_admin->uninstall_theme($this->input->post('theme_id'));
						$this->core->url->redirect(array('admin','themes','main?notice='.$this->data['queryResult']));
					}
				}
				$this->data['Spetheme']	=	$this->core->hubby_admin->isTheme($a);
				if($this->data['Spetheme'])
				{
					
					$this->core->hubby->setTitle('Gestion du th&egrave;me - '.$this->data['Spetheme'][0]['NAMESPACE']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
					$this->data['body']	=	$this->load->view('admin/themes/manage',$this->data,true);
					
					$this->load->view('admin/header',$this->data);
					$this->load->view('admin/global_body',$this->data);
				}
				else
				{
					$this->core->url->redirect(array('error','code','unknowTheme'));
					return false;
				}
			}
			else if($e ==  'config') // Added 0.9.2
			{
				$this->data['Spetheme']	=	$this->hubby_admin->isTheme($a);
				if(is_array($this->data['Spetheme'])) 
				{
					$Parameters			=	$this->core->url->http_request(TRUE);
					$admin_controler	=	THEMES_DIR.$this->data['Spetheme'][0]['ENCRYPTED_DIR'].'/admin_controller.php';
					$library			=	THEMES_DIR.$this->data['Spetheme'][0]['ENCRYPTED_DIR'].'/library.php';
					if(is_file($admin_controler) && is_file($library))
					{
						include_once($admin_controler); // Include admin controler
						include_once($library); // Include Theme internal library
						if(array_key_exists(4,$Parameters))
						{
							$Method				=	$Parameters[4];
						}
						else
						{
							$Method			=	'index';
						}
						for($i = 0;$i < 5;$i++)
						{
							array_shift($Parameters);
						}
						$this->data['interpretation']	=	$this->core->hubby->interpreter($this->data['Spetheme'][0]['NAMESPACE'].'_theme_admin_controller',$Method,$Parameters,$this->data);
						if($this->data['interpretation'] == '404')
						{
							$this->core->url->redirect(array('error','code','page404'));
						}
						if(is_array($this->data['interpretation']))
						{
							if(array_key_exists('MCO',$this->data['interpretation']))
							{
								if($this->data['interpretation']['MCO'] == TRUE)
								{
									$this->data['body']['RETURNED']	=	array_key_exists('RETURNED',$this->data['interpretation']) ? 
										$this->data['interpretation']['RETURNED'] : 
										$this->core->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "RETURNED". Le module chargé renvoi un tableau incorrect ou incomplet.'); // If array key forget, get all content as interpretation.
									$this->data['body']['MCO']		=	$this->data['interpretation']['MCO'];
									$this->load->view('admin/global_body',$this->data);
								}
							}
							else
							{
								$this->core->exceptions->show_error('Interpr&eacute;tation mal d&eacute;finie','L\'interpreation renvoi un tableau qui ne contient pas la cl&eacute; "MCO". Le module chargé renvoi un tableau incorrect ou incomplet.');
							}
						}
						else
						{
							$this->data['body']['RETURNED']	=	$this->data['interpretation'];
							$this->data['body']['MCO']		=	FALSE;
							
							$this->load->view('admin/header',$this->data);
							$this->load->view('admin/global_body',$this->data);
						}
					}
					else
					{
						$this->core->url->redirect(array('error','code','themeControlerNoFound'));
					}
				}
				else
				{
					$this->core->url->redirect(array('error','code','unknowTheme'));
				}
			}
			else
			{
				$this->core->url->redrect(array('error','code','page404'));
			}
		}
		else
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
			return;
		}
	}
	public function installer()
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('system','gestapp',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
			if(isset($_FILES['installer_file']))
			{
				$query	=	$this->core->hubby_admin->hubby_installer('installer_file');
			}
			if(isset($_POST['installer_link']))
			{
				$query	=	$this->core->hubby_admin->hubby_url_installer($this->core->input->post('installer_link'));
			}
			$this->core->notice->push_notice(notice($query));
			$this->core->hubby->setTitle('Installer une application - Hubby');
			$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/installer/install',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);
		}
		else
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
			return;
		}
	}
	public function system($option	=	'index',$option_2 = 1)
	{
		// Is Super Admin ?
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		(!$this->core->users_global->isSuperAdmin()) ? $this->core->url->redirect(array('admin','index?notice=accessDenied')) : null;
		// Proceed
		if($option	==	'index')
		{
			$this->data['pageTitle']	=	'Syst&ecirc;me et restauration';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/body',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		}
		else if($option ==  'createAdmin')
		{
			$this->core->form_validation->set_rules('admin_pseudo','Pseudo','trim|required|min_length[6]|max_length[15]');
			$this->core->form_validation->set_rules('admin_password','Mot de passe','trim|required|min_length[6]|max_length[30]');
			$this->core->form_validation->set_rules('admin_password_confirm','Confirmation du mot de passe','trim|required|matches[admin_password]');
			$this->core->form_validation->set_rules('admin_sex','Selection du sexe','trim|min_length[3]|max_length[5]');
			$this->core->form_validation->set_rules('admin_password_email','Email','trim|valid_email|required');
			$this->core->form_validation->set_rules('admin_privilege','Choisir privil&egrave;ge','trim|required|min_length[8]|max_length[11]');
			if($this->core->form_validation->run())
			{
				$creation_status	=	$this->core->users_global->createAdmin(
					$this->core->input->post('admin_pseudo'),
					$this->core->input->post('admin_password'),
					$this->core->input->post('admin_sex'),
					$this->core->input->post('admin_privilege'),
					$this->core->input->post('admin_password_email')
				);
				switch($creation_status)
				{
					case 'notAllowedPrivilege'	:
						$this->core->notice->push_notice(notice('adminCreationFailed'));
						break;
					case 'adminCreated'	:
						$this->core->url->redirect(array('admin','system','createAdmin?notice=adminCreated'));
						break;
					case 'adminCreationFailed'	:
						$this->core->url->redirect(array('admin','system','createAdmin?notice=adminCreationFailed'));
				}
			}
			$this->data['getPrivs']		=	$this->core->hubby_admin->getPrivileges();
			$this->data['pageTitle']	=	'Gestion des administrateurs';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/createAdmin',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		}
		else if($option ==  'create_privilege')
		{
			if(!method_exists($this->core,'form_validation'))
			{
				$this->core->load->library('form_validation');
$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			}
			$this->core->form_validation->set_rules('priv_description','Description du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->core->form_validation->set_rules('priv_name','Nom du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->core->form_validation->set_rules('is_selectable','Acc&eacute;ssibilit&eacute; au public','trim|required|min_length[1]|max_length[1]');
			if($this->core->form_validation->run())
			{
				$data	=	$this->core->hubby_admin->create_privilege(
					$this->core->input->post('priv_name'),
					$this->core->input->post('priv_description'),
					$this->core->session->userdata('privId'),
					$this->core->input->post('is_selectable')
				);
				if($data === TRUE)
				{
					$this->core->url->redirect(array('admin','system','privilege_list?notice=done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			
			$this->core->session->set_userdata('privId',$this->core->hubby_admin->getPrivId());
			$this->data['privId']		=	$this->core->session->userdata('privId');
			$this->data['pageTitle']	=	'Cr&eacute;er un privil&egrave;ge';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/create_privilege',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		}
		else if($option	== 	'edit_priv')
		{
			if(!method_exists($this->core,'form_validation'))
			{
				$this->core->load->library('form_validation');
$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			}
			$this->core->form_validation->set_rules('priv_description','Description du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->core->form_validation->set_rules('priv_name','Nom du privil&egrave;ge','trim|required|min_length[3]|max_length[200]');
			$this->core->form_validation->set_rules('is_selectable','Acc&eacute;ssibilit&eacute; au public','trim|required|min_length[1]|max_length[1]');
			if($this->core->form_validation->run())
			{
				$data	=	$this->core->hubby_admin->edit_privilege(
					$option_2,
					$this->core->input->post('priv_name'),
					$this->core->input->post('priv_description'),
					$this->core->input->post('is_selectable')
				);
				if($data === TRUE)
				{
					$this->core->url->redirect(array('admin','system','privilege_list?notice=done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			$this->data['getPriv']		=	$this->core->hubby_admin->getPrivileges($option_2);
			if(count($this->data['getPriv']) == 0)
			{
				$this->core->url->redirect(array('error','code','privilegeNotFound'));
			}
			$this->data['pageTitle']	=	'Modifier un privil&egrave;ge';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/edit_privilege',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		
		}
		else if($option	==	'manage_actions')
		{
			if(!$this->core->hubby_admin->hasPriv())
			{
				$this->core->url->redirect(array('admin','system','create_privilege?notice=mustCreatePrivilege'));
			}
			$this->data['ttPrivileges']	=	$this->core->hubby_admin->countPrivileges();
			$this->data['getPrivileges']=	$this->core->hubby_admin->getPrivileges();
			$this->data['ttModules']	=	count($this->core->hubby_admin->get_modules());
			$this->data['paginate']		=	$this->core->hubby->paginate(10,$this->data['ttModules'],1,'bg-color-red fg-color-white','',$option_2,$this->core->url->site_url(array('admin','system','manage_actions')).'/');
			$this->data['getModules']	=	$this->core->hubby_admin->get_modules($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->data['pageTitle']	=	'Gestionnaire d\'actions';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/privileges_and_actions',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		}
		else if($option	==	'ajax_manage_system_actions')
		{
			if(isset($_POST['QUERY']))
			{
				if($this->core->hubby_admin->addActionToPriv($_POST['QUERY'],'system'))
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
				if($this->core->hubby_admin->addActionToPriv_MTW($_POST['QUERY_2'],'modules'))
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
			$this->data['ttPrivileges']	=	$this->core->hubby_admin->countPrivileges();
			$this->data['paginate']		=	$this->core->hubby->paginate(10,$this->data['ttPrivileges'],1,'bg-color-red fg-color-white','',$option_2,$this->core->url->site_url(array('admin','system','privilege_list')).'/');
			$this->data['getPriv']		=	$this->core->hubby_admin->getPrivileges($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->data['pageTitle']	=	'Privil&egrave;ges et actions';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/privilege_list',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		
		}
		else if($option == 'delete_priv')
		{
			$this->data['deletion']	=	$this->core->hubby_admin->deletePrivilege($option_2);		
			$this->core->url->redirect(array('admin','system','privilege_list?notice='.$this->data['deletion']));			
		}
		else if($option	==	'editAdmin')
		{
			if($this->core->input->post('set_admin'))
			{
				$this->core->form_validation->set_rules('current_admin','Concernant l\'administrateur en cours','trim|required|min_length[6]');
				$this->core->form_validation->set_rules('edit_priv','Modifier son privil&egrave;ge','trim|required|min_length[8]|max_length[11]');
				$this->core->form_validation->set_rules('user_email','Email','trim|valid_email');
				if($this->core->form_validation->run())
				{
					$query	=	$this->core->users_global->setAdminPrivilege($this->core->input->post('edit_priv'),$this->core->input->post('current_admin'),$this->core->input->post('user_email'));
					$this->core->notice->push_notice(notice($query));
				}
			}
			if($this->core->input->post('delete_admin'))
			{
				$this->core->form_validation->set_rules('current_admin','Concernant l\'administrateur en cours','trim|required|min_length[6]');
				$this->core->form_validation->set_rules('delete_admin','Modifier son privil&egrave;ge','trim|required|min_length[1]');
				if($this->core->form_validation->run())
				{
					if($this->core->users_global->deleteSpeAdmin($this->core->input->post('current_admin')))
					{
						$this->core->url->redirect(array('admin','system','adminMain?notice=adminDeleted'));
					}
					else
					{
						$this->core->notice->push_notice(notice('error_occured'));
					}
				}
			}
			
			$this->data['getPrivs']		=	$this->core->hubby_admin->getPrivileges();
			$this->data['adminInfo']	=	$this->core->users_global->getSpeAdminByPseudo($option_2);
			$this->data['pageTitle']	=	'Profil administrateur - '.$this->data['adminInfo']['PSEUDO'];
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/editAdmin',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
			return true;
		}
		else if($option	==	'restore')
		{
			if($option_2	==	'soft')
			{				
				$this->core->form_validation->set_rules('admin_password','Mot de passe administrateur','trim|required|min_length[6]|max_length[30]');
				if($this->core->form_validation->run())
				{
					if($this->core->hubby_admin->cmsRestore($this->core->input->post('admin_password')))
					{
						$this->core->notice->push_notice(notice('cmsRestored'));
					}
					else
					{
						$this->core->notice->push_notice(notice('cmsRestorationFailed'));
					}
				}
				$this->data['pageTitle']	=	'Restauration souple du syst&egrave;me';
				$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']	=	$this->load->view('admin/system/restore_soft',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);	
			}
			else if($option_2	==	'hard') // hard
			{
				$this->core->form_validation->set_rules('admin_password','Mot de passe administrateur','trim|required|min_length[6]|max_length[30]');
				if($this->core->form_validation->run())
				{
				}
				$this->data['pageTitle']	=	'Restauration brutale du syst&egrave;me';
				$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
				$this->data['body']	=	$this->load->view('admin/system/restore_hard',$this->data,true);
				
				$this->load->view('admin/header',$this->data);
				$this->load->view('admin/global_body',$this->data);	
			}
		}
		else if($option	== 'adminMain')
		{
			$this->data['ttAdmin']		=	count($this->core->users_global->getAdmin());
			$this->data['paginate']		=	$this->core->hubby->paginate(10,$this->data['ttAdmin'],1,'bg-color-red fg-color-white','',$option_2,$this->core->url->site_url(array('admin','system','adminMain')).'/');
			
			
			$this->data['subadmin']		=	$this->core->users_global->getAdmin($this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->data['pageTitle']	=	'Gestion des administrateurs';
			$this->core->hubby->setTitle($this->data['pageTitle']);$this->data['lmenu']=	$this->load->view('admin/left_menu',$this->data,true);
			$this->data['body']	=	$this->load->view('admin/system/adminList',$this->data,true);
			
			$this->load->view('admin/header',$this->data);
			$this->load->view('admin/global_body',$this->data);	
		}
		else
		{
			$this->core->url->redirect(array('page404'));
		}
		
	}
}