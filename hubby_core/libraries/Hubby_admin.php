<?php
class hubby_admin
{
	protected $getpages;
	private $leftMenuExtentionBefore 	= '';
	private $leftMenuExtentionAfter 	= '';
	private $core;
	private $reservedControllers		=	array('admin','install','login','logoff','account','registration','error');
	public function __construct()
	{
		$this->core				=	Controller::instance();
		$this->hubby			=&	$this->core->hubby;
	}
	public function get_global_info()
	{
		// About Controllers;
		$this->core	->db->select('*')
					->from('hubby_controllers');
		$query = $this->core->db->get();
		// About Themes
		$hubby_themes_request		=	$this->core->db->where('ACTIVATED','TRUE')->get('hubby_themes');
		// Array Error Contener
		$array	=	array();
		if(count($hubby_themes_request->result_array()) == 0)
		{
			$array[]	= 'no_theme_selected';
		}
		if($query->num_rows == 0)
		{
			$array[]	= 'no_page_set';
		}
		else
		{
			foreach($query->result() as $r)
			{
				$result[]	=	$r->PAGE_MAIN;
			}
			if(!in_array('TRUE',$result))
			{
				$array[]	=	'no_main_page_set';
			}
		}
		$priv	=	$this->getPrivileges();
		if(count($priv) == 0)
		{
			$array[]		=	'no_priv_created';
		}
		return $array;					
	}
	public function countPages()
	{
		$query	=	$this->core->db->get('hubby_controllers');
		return $query->num_rows();
	}
	public function get_pages($e= '')
	{
		return $this->core->hubby->getPage($e);
	}
	private $statsLimitation	=	5;
	public function getStatLimitation()
	{
		return $this->statsLimitation;
	}
	public function hubby_visit_stats()
	{
		$month_limit	=	$this->statsLimitation;
		$currentDate	=	$this->hubby->global_date('month_current_date');
		$time			=	new DateTime($currentDate);
		$time->modify('- '.$month_limit.' months');
		$ts_global		=	$time->format('Y-m-d H:i:s');
		$te_this_month	=	$this->hubby->global_date('month_end_date');
		$uniqueVisits	=	$this->core->db->where('DATE >=',$ts_global)->order_by('DATE','asc')->get('hubby_visit_stats');
		$uniqueResult	=	$uniqueVisits->result_array();
		$array			=	array();
		if(count($uniqueResult) > 0)
		{
			foreach($uniqueResult as $u)
			{
				$currentDate	=	$u['DATE'];
				$timeDecompose	=	$this->core->hubby->time($currentDate,TRUE);
				if(!isset($array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']))
				{
					$array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	0;
				}
				$array['ordered'][$timeDecompose['y']][$timeDecompose['M']][]	=	$u;
				$array['listed'][]	=	$u;
				$array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	+=	(int)$u['GLOBAL_VISIT'];
				$sumQuery		=	$this->core->db->select('COUNT(DISTINCT VISITORS_IP) as `UNIQUE_VISIT`')->where('DATE >=',$timeDecompose['y'].'-'.$timeDecompose['M'].'-'.(1))->where('DATE <=',$timeDecompose['y'].'-'.$timeDecompose['M'].'-'.$timeDecompose['t'])->get('hubby_visit_stats');
				$sumResult		=	$sumQuery->result_array();
				$array['statistics']['unique'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	$sumResult[0]['UNIQUE_VISIT'];
			}
		}
		else
		{
			$currentDate	=	$this->core->hubby->datetime();
			$timeDecompose	=	$this->core->hubby->time($currentDate,TRUE);
			$array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	0;
			$array['statistics']['unique'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	0;
			$array['ordered']	=	null;
		}
		// Recupère information globales
		$overAllUniqueQuery		=	$this->core->db->select('COUNT(DISTINCT VISITORS_IP) as `UNIQUE_GLOBAL`')->where('DATE >=',$ts_global)->get('hubby_visit_stats');
		$overAllUniqueResult	=	$overAllUniqueQuery->result_array();
		
		$array['statistics']['overAll']['unique']['totalVisits']	=	$overAllUniqueResult[0]['UNIQUE_GLOBAL'];
		$overAllGlobalQuery		=	$this->core->db->select('SUM(GLOBAL_VISIT) as `MULTIPLE_GLOBAL`')->where('DATE >=',$ts_global)->get('hubby_visit_stats');
		$overAllGlobalResult	=	$overAllGlobalQuery->result_array();
		$array['statistics']['overAll']['global']['totalVisits']	=	$overAllGlobalResult[0]['MULTIPLE_GLOBAL'];
		return $array;
		//	$array['CURRENT_MONTH']['VISITS']['GLOBAL']	=	$visitGlobal;
	}
	public function getSpeModuleByNamespace($namespace) // La même méthode pour Hubby ne recupère que ce qui est déjà activé.
	{
		$this->core->db		->select('*')
							->from('hubby_modules')
							->where('NAMESPACE',$namespace);
		$query				= $this->core->db->get();
		$data				= $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function moduleActivation($id,$form = TRUE)
	{
		if($form == TRUE)
		{
			$mod	=	$this->core->hubby_admin->getSpeMod($id,TRUE);
			if($mod)
			{
				$this->core->db->where('ID',$id)->update('hubby_modules',array(
					'ACTIVE'	=>	1
				));
				$this->core->url->redirect(array('admin','modules'));
				return true;
			}
			return false;
		}
		else
		{
			$mod	=	$this->getSpeModuleByNamespace($id);
			if($mod)
			{
				$this->core->db->where('NAMESPACE',$id)->update('hubby_modules',array(
					'ACTIVE'	=>	1
				));
				return $mod;
			}
			return false;
		}
	}
	public function get_modules($start = NULL,$end = NULL)
	{
		$this->core->db		->select('*')
							->from('hubby_modules');
		if(is_numeric($start) && is_numeric($end))
		{
			$this->core->db	->limit($end,$start);	
		}
		$query				= $this->core->db->get();
		return $query->result_array();
	}
	public function get_bypage_module()
	{
		$this->core->db		->select('*')
							->where('TYPE','BYPAGE')
							->from('hubby_modules');
		$query				= $this->core->db->get();
		return $query->result_array();
	}
	public function controller($name,$cname,$mod,$title,$description,$main,$obj = 'create',$id = '',$visible	=	'TRUE',$childOf= 'none',$page_link	=	'')
	{
		if(in_array($cname,$this->reservedControllers)): return 'cantUserReservedCNames'; endif; // ne peut utiliser les cname reservés.
		if($childOf == strtolower($cname)) : return 'cantHeritFromItSelf' ;endif; // Ne peut être sous menu de lui même
		$currentPosition=	$childOf;
		if($childOf != 'none') // Si ce controleur est l'enfant d'un autre.
		{
			for($i=0;$i<= $this->core->hubby->get_menu_limitation();$i++)
			{
				$firstQuery	=	$this->core	->db->select('*')
							->from('hubby_controllers')
							->where('ID',$currentPosition);
				$data		=	$firstQuery->get();
				$result		=	$data->result_array();
				if(count($result) > 0)
				{
					if($this->core->hubby->get_menu_limitation() == $i && $result[0]['PAGE_PARENT'] != 'none') // Si le dernier menu, compte tenu de la limitation en terme de sous menu est atteinte, et pourtant le menu nous dis qu'il y a encore un autre menu, nous déclarons qu'il ne peut plus y avoir de sous menu.
					{
						return 'subMenuLevelReach';
					}
					$currentPosition = $result[0]['PAGE_PARENT']; // Affecte le nouveau parent, pour remonter la source.
				}
				else
				{
					if($i == 0) // Nous sommes au premier niveau de la boucle, ici nous vérifions que le contrôleur désigné comme parent existe effectivement
					{
						return 'unkConSpeAsParent';
					}
				}
				
			}
		}
		if($main == 'TRUE' && $childOf != 'none'):return 'cantSetChildAsMain';endif; // Il ne faut pas définir un sous menu comme page principale
		
		$this->core	->db->select('*')
					->from('hubby_controllers');
		$query		=	$this->core->db->get();
		
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $q)
			{
				if(strtolower($q['PAGE_CNAME'])	==	strtolower($cname) && $obj == 'create')
				{
					return 'c_name_already_found';
				}
				if(strtolower($q['PAGE_NAMES']) == strtolower($name) && $obj == 'create')
				{
					return 'name_already_found';
				}
				if($q['PAGE_MAIN'] == 'TRUE' && $main == 'TRUE')
				{
					if($main == 'TRUE' && $childOf == 'none')
					{
						$e['PAGE_MAIN']	=	'FALSE';
						$this->core 	->db->where('ID',$q['ID'])
										->update('hubby_controllers',$e);
					}
				}
			}
		}
		$e['PAGE_CNAME']		=	strtolower($cname);
		$e['PAGE_NAMES']		=	strtolower($name);
		$e['PAGE_TITLE']		=	$title;
		$e['PAGE_DESCRIPTION']	=	$description;
		$e['PAGE_MAIN']			=	$query->num_rows > 0 ? $main == 'TRUE' && $childOf != 'none' ? 'FALSE' : $main : 'TRUE'; // Les sous menu ne devriat pas intervenir en tant que principale.
		$e['PAGE_MODULES']		=	$mod; // SI le controleur doit rediriger vers une page, alors on enregistre la page sinon on enregistre le module.
		$e['PAGE_VISIBLE']		=	$visible;
		$e['PAGE_PARENT']		=	$childOf == $name ? 'none' : $childOf;
		$e['PAGE_LINK']			=	$page_link;
		if($obj == 'create')
		{
			if($this->core		->db->insert('hubby_controllers',$e))
			{
				$query			=	$this->core->db->where('PAGE_MAIN','TRUE')->get('hubby_controllers');
				if($query->num_rows == 0) : 		return "no_main_controller_created";endif;
				return 'controler_created';
			}
			else
			{
				return 'error_occured';
			}
		}
		else if($obj == 'update')
		{
			$query = $this->core	->db->where('ID',$id)
								->update('hubby_controllers',$e);
			if($query)
			{
				return 'controler_edited';
			}
			else
			{
				return 'error_occured';
			}
		}
	}
	public function delete_controler($name)
	{
		$this->core	->db->select('*')
					->from('hubby_controllers')
					->where('PAGE_CNAME',$name);
		$query 		= $this->core->db->get();
		$result 	= $query->result_array();
		if($result[0]['PAGE_MAIN'] == 'TRUE')
		{
			return 'cant_delete_mainpage';
		}
		else
		{
			if($this->core->db->where('PAGE_CNAME',$name)->delete('hubby_controllers'))
			{
				return 'controler_deleted';
			}
			return 'error_occured';
		}
	}
	// Module Functions
	public function uninstall_module($id)
	{
		$Module		=	$this->getSpeMod($id,TRUE);
		if($Module !== FALSE)
		{
			if(is_file(MODULES_DIR.$Module[0]['ENCRYPTED_DIR'].'/uninstall.php'))
			{
				include_once(MODULES_DIR.$Module[0]['ENCRYPTED_DIR'].'/uninstall.php');
			}
			$this->drop(MODULES_DIR.$Module[0]['ENCRYPTED_DIR']);
			return	$this->core->db->delete('hubby_modules',array('ID'=>$id));
		}
	}
	// FILE HELPERS
	private $system_dir	=	array('hubby_themes/','hubby_core/','hubby_installer/','hubby_modules/','hubby_assets/');
	private function drop($source)
	{
		if(in_array($source,$this->system_dir))
		{
			return false;
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						unlink($source.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						$this->drop($source.'/'.$content);
					}
				}
				closedir($open);
			}
			rmdir($source);
		}
	}
	private function extractor($source,$destination,$dir_limit = 10)
	{
		if(!is_dir($destination))
		{
			mkdir($destination);
		}
		if(is_file($source))
		{
			copy($source,$destination);
			unlink($source);
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						copy($source.'/'.$content,$destination.'/'.$content);
						unlink($source.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						if($dir_limit > 0)
						{
							if(!is_dir($destination.'/'.$content))
							{
								mkdir($destination.'/'.$content);
							}
							$this->extractor($source.'/'.$content,$destination.'/'.$content,$dir_limit-1);
						}
						else
						{
							$this->drop($source.'/'.$content);
						}
					}
				}
				closedir($open);
			}
		}
		if(!rmdir($source))
		{
			$this->drop($source);
		}
	}
	// THEMING FUNCTIONS
	public function countThemes()
	{
		$query	=	$this->core->db->get('hubby_themes');
		return count($query->result_array());
	}
	public function getThemes($start = NULL,$end = NULL)
	{
		if($start  != NULL && $end != NULL )
		{
			$this->core->db->limit($end,$start);
		}
		$query	=	$this->core->db->get('hubby_themes');
		return $query->result_array();
	}
	public function isTheme($id)
	{
		$query	=	$this->core->db->where('ID',$id)->get('hubby_themes');
		if(count($query->result_array()) > 0)
		{
			$data	=	$query->result_array();
			if($data[0]['ACTIVATED']	==	'')
			{
				$data[0]['ACTIVATED'] = 'Inactif';
			}
			else if($data[0]['ACTIVATED']	==	'TRUE')
			{
				$data[0]['ACTIVATED'] = 'Actif';
			}
			else
			{
				$data[0]['ACTIVATED'] = 'Statut incompr&eacute;hensible';
			}
			return $data;
		}
		return false;
	}
	public function setDefault($id)
	{
		$theme	=	$this->isTheme($id);
		if($theme)
		{
			$this->core->db->update('hubby_themes',array('ACTIVATED'=>''));
			$this->core->db->where('ID',$id)->update('hubby_themes',array('ACTIVATED'=>'TRUE'));
			return 'defaultThemeSet';
		}
		return 'unknowTheme';
	}
	public function uninstall_theme($id)
	{
		$theme	=	$this->isTheme($id);
		if($theme)
		{
			if(is_file(THEMES_DIR.$theme[0]['ENCRYPTED_DIR'].'/uninstall.php'))
			{
				include_once(THEMES_DIR.$Module[0]['ENCRYPTED_DIR'].'/uninstall.php');
			}
			$this->core->db->where('ID',$id)->delete('hubby_themes');
			$this->drop(THEMES_DIR.$theme[0]['ENCRYPTED_DIR']);
			return 'done';
		}
		return 'unknowTheme';
	}
	// ---
	public function count_modules()
	{
		$query				=	$this->core->db->get('hubby_modules');
		return $query->num_rows();
	}
	public function menuExtendsAfter($e) // Ajout menu après le menu systeme
	{
		$this->leftMenuExtentionAfter = $e;
	}
	public function menuExtendsBefore($e) // Ajout avant le menu système
	{
		$this->leftMenuExtentionBefore = $e;
	}
	public function parseMenuBefore()
	{
		return $this->leftMenuExtentionBefore;
	}
	public function parseMenuAfter()
	{
		return $this->leftMenuExtentionAfter;
	}
	/// SETTING FUNCTIONS
	public function editSiteName($e)
	{
		return $this->core->db->update('hubby_options',array('SITE_NAME'=>$e));
	}
	public function editRegistration($e)
	{
		if(is_numeric($e))
		{
			$e =	($e >= 0 && $e <= 1) ? $e : 0;
		}
		else
		{
			$e	=	0;
		}
		return $this->core->db->update('hubby_options',array('ALLOW_REGISTRATION'=>$e));
	}
	public function editLogoUrl($e)
	{
		return $this->core->db->update('hubby_options',array('SITE_LOGO'=>$e));
	}
	public function editTimeZone($e)
	{
		return $this->core->db->update('hubby_options',array('SITE_TIMEZONE'=>$e));
	}
	public function editTimeFormat($e)
	{
		return $this->core->db->update('hubby_options',array('SITE_TIMEFORMAT'=>$e));
	}
	public function editShowMessage($e)
	{
		$bool	=	is_bool((bool)$e) ? $e : "TRUE";
		$this->core->db->update('hubby_options',array('SHOW_WELCOME'=>$bool));
	}
	public function switchShowAdminIndex()
	{
		$options	=	$this->core->hubby->getOptions();
		if($options[0]['SHOW_ADMIN_INDEX_STATS'] ==  '1')
		{
			$int	=	0;
		}
		else
		{
			$int	=	1;
		}
		$this->core->db->update('hubby_options',array('SHOW_ADMIN_INDEX_STATS'=>$int));
	}
	public function editPrivilegeAccess($e)
	{
		$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1))  ? $e : 0;
		return $this->core->db->update('hubby_options',array('ALLOW_PRIVILEGE_SELECTION'=>$int));
	}
	public function editAllowAccessToPublicPriv($e)
	{
			$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1))  ? $e : 0;
		return $this->core->db->update('hubby_options',array('PUBLIC_PRIV_ACCESS_ADMIN'=>$int));
	}
	public function editThemeStyle($e)
	{
		$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1))  ? $e : 0; // If there is new theme just add it there
		return $this->core->db->update('hubby_options',array('ADMIN_THEME'=>$int));
	}
	public function encrypted_name()
	{
		$alphabet	=	array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
		$index		=	count($alphabet)-1;
		return 'hubby_app_'.rand(0,9).date('Y').date('m').date('d').date('H').date('i').date('s').$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)];
	}
	// New methods
	private $appAllowedType					=	array('MODULE','THEME');
	private $appModuleAllowedTableField		=	array('NAMESPACE','HAS_WIDGET','HAS_MENU','HAS_API','HAS_ICON','HUMAN_NAME','AUTHOR','DESCRIPTION','TYPE','HUBBY_VERS','ENCRYPTED_DIR');
	private $appThemeAllowedTableField		=	array('NAMESPACE','HUMAN_NAME','AUTHOR','DESCRIPTION','HUBBY_VERS','ENCRYPTED_DIR');
	public function hubby_installer($source)
	{
		function Unzip($zip)
		{
			$myZip						=	new ZipArchive;
			$myZip->open($zip);
			if($myZip->getStatusString() == 'No error')
			{
				$installDir				=	INSTALLER_DIR;
				$temporaryDir			=	explode('.',$zip);
				$temporaryDir			=	explode('/',$temporaryDir[0]);
				$temporaryDir			=	$temporaryDir[1];
				if(!is_dir($installDir.$temporaryDir))
				{
					mkdir($installDir.$temporaryDir);
				}
				if($myZip->extractTo($installDir.$temporaryDir))
				{
					$notice	=	 fopen($installDir.$temporaryDir.'/notice.html','r');
					$myZip->close();
					unlink($zip);
					return array(
						'temp_dir'		=> $temporaryDir,
						'notice'		=> fread($notice,filesize($installDir.$temporaryDir.'/notice.html'))
					);
				}
				else
				{
					$myZip->close();
					unlink($zip);
					$this->drop($installDir.$temporaryDir);
					return 'errorOccurred';
				}
				$myZip->close();
			}
			$myZip->close();
			if(is_file($zip))
			{
				unlink($zip);
			}
			return 'CorruptedArchive';
		}
		$config['upload_path'] = INSTALLER_DIR;
		$config['allowed_types'] = 'zip';
		$config['max_size']	= '2048';
		$config['encrypt_name']	=	TRUE;
		$this->core->load->library('upload',$config);
		if($this->core->upload->do_upload($source))
		{
			$appFile	=	Unzip(INSTALLER_DIR.$this->core->upload->file_name);
			include_once(INSTALLER_DIR.$appFile['temp_dir'].'/install.php');
			ob_clean(); // remove outputform install.php
			$temp_dir	=	INSTALLER_DIR.$appFile['temp_dir'];
			
			$appInfo	=	$this->datas(); // got declared info datas
			$appInfo['appTableField']['ENCRYPTED_DIR']	=	$appFile['temp_dir'];
			if(in_array($appInfo['appType'],$this->appAllowedType))
			{
				if($appInfo['appType'] == 'MODULE')
				{
					if(count($appInfo['appTableField']) > 0)
					{
						foreach(array_keys($appInfo['appTableField']) as $_appTableField)
						{
							if(!in_array($_appTableField,$this->appModuleAllowedTableField))
							{
								$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
								$this->core->notice->push_notice(notice('invalidApp'));
								return 'invalidApp';
							}
						}
					}
					else
					{
						$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
						$this->core->notice->push_notice(notice('invalidApp'));
						return 'invalidApp';
					}
					if($appInfo['appHubbyVers'] <= $this->core->hubby->getVersId())
					{
						$this->core->db		->select('*')
											->from('hubby_modules')
											->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
						$query = $this->core->db->get();
						// -----------------------------------------------------------------------------------------
						if($query->num_rows == 0)
						{
							if(is_array($appInfo['appSql']))
							{
								foreach($appInfo['appSql'] as $sql)
								{
									$this->core->db->query($sql);
								}
							}
							$this->core->db->insert('hubby_modules',$appInfo['appTableField']);
							if(is_dir($temp_dir))
							{
								$this->extractor($temp_dir,MODULES_DIR.$appFile['temp_dir']);
								$this->core->notice->push_notice(notice('moduleInstalled'));
								$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
								
								if(array_key_exists('appAction',$appInfo)) // If this app allow action for privileges
								{
									for($i = 0;$i < count($appInfo['appAction']);$i++)
									{
										if(
										!array_key_exists('mod_namespace',$appInfo['appAction'][$i]) ||
										!array_key_exists('action',$appInfo['appAction'][$i]) ||
										!array_key_exists('action_name',$appInfo['appAction'][$i]) ||
										!array_key_exists('action_description',$appInfo['appAction'][$i])
										)
										{
											$this->core->notice->push_notice(notice('creatingHiddenControllerFailure'));
											return 'installFailed';
										}
										$this->createModuleAction(
											$appInfo['appAction'][$i]['mod_namespace'],
											$appInfo['appAction'][$i]['action'],
											$appInfo['appAction'][$i]['action_name'],
											$appInfo['appAction'][$i]['action_description']
										);
									}
								}
								if(array_key_exists('appHiddenController',$appInfo))
								{
									if(is_array($appInfo['appHiddenController']))
									{
									if(
										!array_key_exists('NAME',$appInfo['appHiddenController']) ||
										!array_key_exists('CNAME',$appInfo['appHiddenController']) ||
										!array_key_exists('ATTACHED_MODULE',$appInfo['appHiddenController']) ||
										!array_key_exists('TITLE',$appInfo['appHiddenController']) ||
										!array_key_exists('DESCRIPTION',$appInfo['appHiddenController'])
										)
										{
											$this->core->notice->push_notice(notice('creatingHiddenControllerFailure'));
											return 'installFailed';
										}
									$this->controller(
										$appInfo['appHiddenController']['NAME'],
										$appInfo['appHiddenController']['CNAME'],
										$appInfo['appHiddenController']['ATTACHED_MODULE'],
										$appInfo['appHiddenController']['TITLE'],
										$appInfo['appHiddenController']['DESCRIPTION'],
										FALSE,
										'create',
										null,
										'FALSE'
									); // Creating hidden Controller
								}
								}
								return 'moduleInstalled';
							}
						}
						else
						{
							$this->core->notice->push_notice(notice('module_alreadyExist'));
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'module_alreadyExist';
						}
					}
					$this->core->notice->push_notice(notice('NoCompatibleModule'));
					$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
					return 'NoCompatibleModule';
				}
				else if($appInfo['appType'] == 'THEME')
				{
					if(count($appInfo['appTableField']) > 0)
					{
						foreach(array_keys($appInfo['appTableField']) as $_appTableField)
						{
							if(!in_array($_appTableField,$this->appThemeAllowedTableField))
							{
								$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
								$this->core->notice->push_notice(notice('invalidApp'));
								
								return 'invalidApp';
							}
						}
					}
					else
					{
						$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
						$this->core->notice->push_notice(notice('invalidApp'));
						return 'invalidApp';
					}
					if($appInfo['appHubbyVers'] <= $this->core->hubby->getVersId())
					{
						$this->core->db		->select('*')
											->from('hubby_themes')
											->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
						$query = $this->core->db->get();
						// -----------------------------------------------------------------------------------------
						if($query->num_rows == 0)
						{
							if(is_array($appInfo['appSql']))
							{
								foreach($appInfo['appSql'] as $sql)
								{
									$this->core->db->query($sql);
								}
							}
							$this->core->db->insert('hubby_themes',$appInfo['appTableField']);
							if(is_dir($temp_dir))
							{
								$this->extractor($temp_dir,THEMES_DIR.$appFile['temp_dir']);
								$this->core->notice->push_notice(notice('theme_installed'));
								$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
								return 'theme_installed';
							}
						}
						else
						{
							$this->core->notice->push_notice(notice('theme_alreadyExist'));
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'theme_alreadyExist';
						}
					}
					$this->core->notice->push_notice(notice('NoCompatibleTheme'));
					$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
					return 'NoCompatibleTheme';
				}
			}
			$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
			$this->core->notice->push_notice(notice('invalidApp'));
			return 'invalidApp';
		}
		return 'errorOccured';
	}
	public function hubby_core_installer($appFile)
	{
		include_once(INSTALLER_DIR.$appFile['temp_dir'].'/install.php');
		ob_clean();
		
		$temp_dir	=	INSTALLER_DIR.$appFile['temp_dir'];
		
		$appInfo	=	$this->datas(); // got declared info datas
		$appInfo['appTableField']['ENCRYPTED_DIR']	=	$appFile['temp_dir'];
		
		if(in_array($appInfo['appType'],$this->appAllowedType))
		{
			if($appInfo['appType'] == 'MODULE')
			{
				if(count($appInfo['appTableField']) > 0)
				{
					foreach(array_keys($appInfo['appTableField']) as $_appTableField)
					{
						if(!in_array($_appTableField,$this->appModuleAllowedTableField))
						{
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'invalidApp';
						}
					}
				}
				else
				{
					$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
					return 'invalidApp';
				}
				if($appInfo['appHubbyVers'] <= $this->core->hubby->getVersId())
				{					
					$this->core->db		->select('*')
										->from('hubby_modules')
										->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
					$query = $this->core->db->get();
					// -----------------------------------------------------------------------------------------
					if($query->num_rows == 0)
					{
						if(is_array($appInfo['appSql']))
						{
							foreach($appInfo['appSql'] as $sql)
							{
								$this->core->db->query($sql);
							}
						}
						$this->core->db->insert('hubby_modules',$appInfo['appTableField']);
						if(is_dir($temp_dir))
						{
							$this->extractor($temp_dir,MODULES_DIR.$appFile['temp_dir']);
							$this->core->notice->push_notice(notice('moduleInstalled'));
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							if(array_key_exists('appAction',$appInfo)) // If this app allow action for privileges
							{
								for($i = 0;$i < count($appInfo['appAction']);$i++)
								{
									if(
									!array_key_exists('mod_namespace',$appInfo['appAction'][$i]) ||
									!array_key_exists('action',$appInfo['appAction'][$i]) ||
									!array_key_exists('action_name',$appInfo['appAction'][$i]) ||
									!array_key_exists('action_description',$appInfo['appAction'][$i])
									)
									{
										return 'addingActionFailure';
									}
									$this->createModuleAction(
										$appInfo['appAction'][$i]['mod_namespace'],
										$appInfo['appAction'][$i]['action'],
										$appInfo['appAction'][$i]['action_name'],
										$appInfo['appAction'][$i]['action_description']
									);
								}
							}
							if(array_key_exists('appHiddenController',$appInfo))
							{
								if(is_array($appInfo['appHiddenController']))
								{
									if(
										!array_key_exists('NAME',$appInfo['appHiddenController']) ||
										!array_key_exists('CNAME',$appInfo['appHiddenController']) ||
										!array_key_exists('ATTACHED_MODULE',$appInfo['appHiddenController']) ||
										!array_key_exists('TITLE',$appInfo['appHiddenController']) ||
										!array_key_exists('DESCRIPTION',$appInfo['appHiddenController'])
										)
									{
										$this->core->notice->push_notice(notice('creatingHiddenControllerFailure'));
									}
									$this->controller(
										$appInfo['appHiddenController']['NAME'],
										$appInfo['appHiddenController']['CNAME'],
										$appInfo['appHiddenController']['ATTACHED_MODULE'],
										$appInfo['appHiddenController']['TITLE'],
										$appInfo['appHiddenController']['DESCRIPTION'],
										FALSE,
										'create',
										null,
										'FALSE'
									); // Creating hidden Controller
							}
							}
							return 'moduleInstalled';
						}
					}
					else
					{
						$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
						return 'module_alreadyExist';
					}
				}
				$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
				return 'NoCompatibleModule';
			}
			else if($appInfo['appType'] == 'THEME')
			{
				if(count($appInfo['appTableField']) > 0)
				{
					foreach(array_keys($appInfo['appTableField']) as $_appTableField)
					{
						if(!in_array($_appTableField,$this->appThemeAllowedTableField))
						{
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'invalidApp';
						}
					}
				}
				else
				{
					$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
					return 'invalidApp';
				}
				if($appInfo['appHubbyVers'] <= $this->core->hubby->getVersId())
				{
					$this->core->db		->select('*')
										->from('hubby_themes')
										->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
					$query = $this->core->db->get();
					// -----------------------------------------------------------------------------------------
					if($query->num_rows == 0)
					{
						if(is_array($appInfo['appSql']))
						{
							foreach($appInfo['appSql'] as $sql)
							{
								$this->core->db->query($sql);
							}
						}
						$this->core->db->insert('hubby_themes',$appInfo['appTableField']);
						if(is_dir($temp_dir))
						{
							$this->extractor($temp_dir,THEMES_DIR.$appFile['temp_dir']);
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'theme_installed';
						}
					}
					else
					{
						$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
						return 'theme_alreadyExist';
					}
				}
				$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
				return 'NoCompatibleTheme';
			}
		}
		$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
		return 'invalidApp';
	}
	public function hubby_url_installer($link,$type = 'default') // install through a link
	{
		$zip	=	new ZipArchive;
		$file	=	file($link);
		$encryptedName		=	$this->encrypted_name();
		$fileTemporaryName	=	INSTALLER_DIR.$encryptedName.'.zip';
		$file	=	file_get_contents($link);
		$new	=	fopen($fileTemporaryName,'a+');
		fwrite($new,$file);
		fclose($new);
		$file		=	$zip->open($fileTemporaryName);
		if($file)
		{
			mkdir(INSTALLER_DIR.$encryptedName);
			$zip->extractTo(INSTALLER_DIR.$encryptedName);
			$zip->close();
			if($type == 'github')
			{
				$parcour				=	0;
				$openDir_1				=	opendir(INSTALLER_DIR.$encryptedName);
				while(false !==($file	=	readdir($openDir_1)))
				{
					if(is_dir(INSTALLER_DIR.$encryptedName.'/'.$file) && !in_array($file,array('.','..')))
					{
						$this->extractor(INSTALLER_DIR.$encryptedName.'/'.$file,INSTALLER_DIR.$encryptedName);
					}
					if($parcour == 2){
						break;
					}
					$parcour++;
				}
			}
			unlink($fileTemporaryName);
		}
		$appFile				=		array();
		$appFile['temp_dir']	=		$encryptedName;
		return $this->hubby_core_installer($appFile);
	}
	// Install New Methods
	public function installSession()
	{
		/* 
		/*	START A NEW INSTALL SESSION
		*/
		unset($this->appType);
		unset($this->appVers);
		unset($this->appHubbyVers);
		$this->appTableField	=	array();
		$this->appSql			=	array();
		$this->appAction		=	array();
	}
	private $appType;
	public function appType($type)
	{
		$this->appType	=	$type;
	}
	private $appSql	=	array();
	public function appSql($sql)
	{
		$this->appSql[]	=	$sql;
	}
	private $appVers;
	public function appVers($version)
	{
		$this->appVers	=	$version;
	}
	private $appHubbyVers;
	public function appHubbyVers($version)
	{
		$this->appHubbyVers	=	$version;
	}
	private $appTableField	=	array();
	public function appTableField($fields)
	{
		$this->appTableField	=	$fields; // File information such as NAMESPACE, HUMAN_NAME, DESCRIPTION and others
	}
	private $appAction		=	array();
	public function appAction($action)
	{
		$this->appAction[]	=	$action;
	}
	public function datas()
	{
		$finalArray	=	 array(
			'appType'			=>	$this->appType, // [module or theme]
			'appTableField'		=>	$this->appTableField, // got App infos
			'appVers'			=>	$this->appVers, // App version
			'appHubbyVers'		=>	$this->appHubbyVers, // hubby required version.
		);
		if($this->appAction == true)
		{
			$finalArray['appAction']	=	$this->appAction;
		}
		if($this->appSql == true)
		{
			$finalArray['appSql']	=	$this->appSql;
		}
		else
		{
			$finalArray['appSql']	=	false;
		}
		return $finalArray;
	}
	// End install methods
	public function getSpeMod($value,$option = TRUE)
	{
		$this->core->db		->select('*')
							->from('hubby_modules');
		if($option == TRUE)
		{
			$this->core->db->where('ID',$value);
		}
		else
		{
			$this->core->db->where('NAMESPACE',$value);
		}
							
		$query				= $this->core->db->get();
		$data				=	 $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;		
	}
	public function cmsRestore($password)
	{
		$query		=	$this->core->db->where('PRIVILEGE','NADIMERPUS')->get('hubby_users');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			if($result[0]['PASSWORD'] != sha1($password))
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		// Removing modules
		$modules	=	$this->get_modules();
		if(count($modules) > 0)
		{
			foreach($modules as $m)
			{
				$this->uninstall_module($m['ID']);
			}
		}
		$this->core->db->query('TRUNCATE `hubby_modules`');
		// Removing Themes
		$themes		=	$this->getThemes();
		if(count($themes) > 0)
		{
			foreach($themes as $t)
			{
				$this->uninstall_theme($t['ID']);
			}
		}
		$this->core->db->query('TRUNCATE `hubby_themes`');
		return true;
	}
	public function cmsHardRestore()
	{
		// Removing modules
		$this->core->db->query('TRUNCATE `hubby_modules`');
		$this->drop(MODULES_DIR);
		mkdir(MODULES_DIR);
		mkdir(MODULES_DIR.'hubby_mod_install');
		// Removing Themes
		$this->core->db->query('TRUNCATE `hubby_themes`');
		$this->drop(THEMES_DIR);
		mkdir(THEMES_DIR);
		mkdir(THEMES_DIR.'temp');
		return true;
	}
	public function countPrivileges()
	{
		return count($this->getPrivileges());
	}
	public function getPrivileges($start = NULL,$end = NULL)
	{
		if($start != NULL && $end != NULL)
		{
			$this->core->db->limit($end,$start);
		}
		else if($start != NULL && $end == NULL)
		{
			$this->core->db->where('PRIV_ID',$start);
		}
		$query	=	$this->core->db->get('hubby_admin_privileges');
		return $query->result_array();
	}
	public function create_privilege($name,$description,$priv_id,$is_selectable)
	{
		$query	=	$this->core->db->where('HUMAN_NAME',$name)->get('hubby_admin_privileges');
		if(count($query->result_array()) == 0)
		{
			$array	=	array(
				'HUMAN_NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'DATE'			=>	$this->core->hubby->datetime(),
				'PRIV_ID'		=>	$priv_id,
				'IS_SELECTABLE'	=>	in_array((int)$is_selectable,array(0,1)) ? $is_selectable : 0
			);
			return $this->core->db->insert('hubby_admin_privileges',$array);
		}
		return false;
	}
	public function edit_privilege($priv_id,$name,$description,$is_selectable)
	{
		$query	=	$this->core->db->where('PRIV_ID',$priv_id)->get('hubby_admin_privileges');
		if(count($query->result_array()) > 0)
		{
			$array	=	array(
				'HUMAN_NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'IS_SELECTABLE'	=>	in_array((int)$is_selectable,array(0,1)) ? $is_selectable : 0
			);
			return $this->core->db->where('PRIV_ID',$priv_id)->update('hubby_admin_privileges',$array);
		}
		return false;
	}
	public function deletePrivilege($privid)
	{
		$query	=	$this->core->db->where('PRIVILEGE',$privid)->get('hubby_users');
		if(count($query->result_array()) == 0)
		{
			if($this->core->db->where('PRIV_ID',$privid)->delete('hubby_admin_privileges'))
			{
				return 'done';
			}
			return 'error_occured';
		}
		return 'cannotDeleteUsedPrivilege';
	}
	public function getPrivId()
	{
		while(true)
		{
			$id	=	rand(0,9).rand(0,9).'-'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).'-'.rand(0,9).rand(0,9).rand(0,9);
			$query	=	$this->core->db->where('PRIVILEGE',$id)->get('hubby_users');
			if(count($query->result_array()) == 0)
			{
				break;
			}
		}		
		return $id;
	}
	public function hasPriv()
	{
		$priv	=	$this->getPrivileges();
		if(count($priv) > 0)
		{
			return true;
		}
		return false;
	}
	public function addActionToPriv($query,$context)
	{
		eval($query);
		if(count($EVALUABLE) > 0)
		{
			foreach($EVALUABLE as $key	=> $value)
			{
				$type_namespace	=	$context;
				$type_ref_priv	=	$key;
				foreach($value as $_key =>	$_value)
				{
					$type_action	=	$_key;
					$type_action_v	=	$value;
					$query	=	$this->core->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->get('hubby_privileges_actions');
					if(count($query->result_array()) > 0)
					{
						$this->core->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->update('hubby_privileges_actions',array(
							'TYPE_NAMESPACE'	=>	$type_namespace,
							'REF_TYPE_ACTION'	=>	$_key,
							'REF_ACTION_VALUE'	=>	$_value,
							'REF_PRIVILEGE'		=>	$type_ref_priv
						));
					}
					else
					{
						$this->core->db->insert('hubby_privileges_actions',array(
							'TYPE_NAMESPACE'	=>	$type_namespace,
							'REF_TYPE_ACTION'	=>	$_key,
							'REF_ACTION_VALUE'	=>	$_value,
							'REF_PRIVILEGE'		=>	$type_ref_priv
						));
					}														
				}
			}
			return true;
		}
		return false;
	}
	public function addActionToPriv_MTW($query,$context)
	{
		eval($query);
		if(count($EVALUABLE) > 0)
		{
			foreach($EVALUABLE as $key	=> $value)
			{
				$type_namespace	=	$context;
				$type_ref_priv	=	$key;
				foreach($value as $__key	=>	$__value) // $__key is object_namespace
				{
					foreach($__value as $_key =>	$_value)
					{
						$type_action	=	$_key;
						$type_action_v	=	$value;
						$query	=	$this->core->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->where('OBJECT_NAMESPACE',$__key)->get('hubby_privileges_actions');
						if(count($query->result_array()) > 0)
						{
							$this->core->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->update('hubby_privileges_actions',array(
								'TYPE_NAMESPACE'	=>	$type_namespace,
								'REF_TYPE_ACTION'	=>	$_key,
								'REF_ACTION_VALUE'	=>	$_value,
								'OBJECT_NAMESPACE'	=>	$__key,
								'REF_PRIVILEGE'		=>	$type_ref_priv
							));
						}
						else
						{
							$this->core->db->insert('hubby_privileges_actions',array(
								'TYPE_NAMESPACE'	=>	$type_namespace,
								'REF_TYPE_ACTION'	=>	$_key,
								'REF_ACTION_VALUE'	=>	$_value,
								'OBJECT_NAMESPACE'	=>	$__key,
								'REF_PRIVILEGE'		=>	$type_ref_priv
							));
						}	
					}
				}
			}
			return true;
		}
		return false;
	}
	public function adminAccess($action_namespace,$action,$privilege)
	{
		$query	=	$this->core->db->where('TYPE_NAMESPACE',$action_namespace)->where('REF_TYPE_ACTION',$action)->where('REF_PRIVILEGE',$privilege)->get('hubby_privileges_actions');
		$result = $query->result_array();
		if(count($result) > 0)
		{
			if($result[0]['REF_ACTION_VALUE']	== 'true')
			{
				return true;
			}
			return false;
		}
	}
	public function getValueForPrivNameAndSystem($system,$action,$priv)
	{
		$query	=	$this->core->db->where('TYPE_NAMESPACE',$system)->where('REF_TYPE_ACTION',$action)->where('REF_PRIVILEGE',$priv)->get('hubby_privileges_actions');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return $result[0];
		}
		return array();
	}
	public function getModuleAction($mod_namespace)
	{
		$query	=	$this->core->db->where('MOD_NAMESPACE',$mod_namespace)->get('hubby_modules_actions');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return $result;
		}
		return false;
	}
	public function createModuleAction($mod_namespace,$action,$action_name,$action_description) // Create action for modules
	{
		$query	=	$this->core->db
			->where('MOD_NAMESPACE',$mod_namespace)
			->where('ACTION',$action)
			->get('hubby_modules_actions');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return $this->core->db
			->where('MOD_NAMESPACE',$mod_namespace)
			->where('ACTION',$action)
			->update('hubby_modules_actions',array(
				'ACTION_NAME'			=>	$action_name,
				'ACTION_DESCRIPTION'	=>	$action_description
			));
		}
		return $this->core->db->insert('hubby_modules_actions',array(
			'MOD_NAMESPACE'			=>	$mod_namespace,
			'ACTION'				=>	$action,
			'ACTION_NAME'			=>	$action_name,
			'ACTION_DESCRIPTION'	=>	$action_description
		));
	}
	// 0.92
	private $sys_not_array	=	array();
	public function system_not($title,$content,$link,$date,$thumb)
	{
		$this->sys_not_array[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATE'				=>	$date,
			'THUMB'				=>	$thumb
		);
	}
	public function get_sys_not()
	{
		return $this->sys_not_array;
	}
	// 0.94
	public function getPublicPrivilege()
	{
		$query	=	$this->core->db->where('IS_SELECTABLE',1)->get('hubby_admin_privileges');
		return $query->result_array();
	}
	public function isPublicPriv($priv_id)
	{
		$priv	=	$this->getPrivileges($priv_id);
		if($priv)
		{
			if($priv[0]['IS_SELECTABLE'] == "1")
			{
				return true;
			}
		}
		return false;
	}
	public function getChildren($curent_level,$child)
	{
		if(is_array($child))
		{
			foreach($child as $_g)
			{
				?>
			<tr>
				<td><?php echo $curent_level;?></td>
				<td><a href="<?php echo $this->core->url->site_url('admin/pages/edit/'.$_g['PAGE_CNAME']);?>" data-toggle="modal"><?php echo $_g['PAGE_NAMES'];?></a></td>
				<td><?php echo $_g['PAGE_TITLE'];?></td>
				<td><?php echo $_g['PAGE_DESCRIPTION'];?></td>
				<td><?php echo ($_g['PAGE_MAIN'] == 'TRUE') ? 'Oui' : 'Non';?></td>
				<td><?php echo $_g['PAGE_MODULES'] === FALSE ? 'Aucun module' : is_string($_g['PAGE_MODULES']) ? $_g['PAGE_MODULES'] : $_g['PAGE_MODULES'][0]['HUMAN_NAME'];?></td>
				<td><a onclick="if(!confirm('voulez-vous supprimer ce contrôleur ?')){return false}" href="<?php echo $this->core->url->site_url('admin/pages/delete/'.$_g['PAGE_CNAME']);?>">Supprimer</a></td>
				<td><?php echo count($_g['PAGE_CHILDS']);?></td>
			</tr>
				<?php
				$this->getChildren($curent_level+1,$_g['PAGE_CHILDS']);
			}
		}
	}
	// new
	public function getAppImgIco($appNameSpace)
	{
		$app	=	$this->getSpeModuleByNamespace($appNameSpace);
		if($app)
		{
			$file	=	MODULES_DIR.$app[0]['ENCRYPTED_DIR'].'/app_icon.';
			foreach(array('png','jpg','gif') as $g)
			{
				if(is_file($file.$g))
				{
					return $this->core->url->main_url().$file.$g;
				}
			}
		}
		return false;
	}
	public function getAppIcon()
	{
		$globalMod	=	$this->get_modules();
		$finalIcons	=	array();
		if(is_array($globalMod))
		{
			foreach($globalMod as $modules)
			{
				if($modules['HAS_ICON'] == "1")
				{
					$files	=	MODULES_DIR.$modules['ENCRYPTED_DIR'].'/config/icon_config.php';
					if(is_file($files))
					{
						include($files);
						if(isset($ICON_CONFIG))
						{
							$finalIcons[]	=	$ICON_CONFIG;
						}
					}
				}
			}
			return $finalIcons;
		}
		return false;
	}
	private $gridId	=	-1; // For gridster
	public function getGridId()
	{
		$this->gridId++;
		return $this->gridId;
	}
	//
	public function saveVisibleIcons($availableIcons)
	{
		$content	=	'$icons	=	array();';
		if(is_array($availableIcons))
		{
			foreach($availableIcons as $a)
			{
				$content	.=	'$icons[]	=	"'.$a.'";';
			}
			return $this->core->db->update('hubby_options',array('ADMIN_ICONS'=>$content));
		}
		return false;
	}
}