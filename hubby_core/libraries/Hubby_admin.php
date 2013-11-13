<?php
class hubby_admin
{
	protected $getpages;
	private $leftMenuExtentionBefore 	= '';
	private $leftMenuExtentionAfter 	= '';
	private $core;
	public function __construct()
	{
		$this->core				=	Controller::instance();
		$this->hubby			=	$this->core->hubby;
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
		return $array;					
	}
	public function get_pages($page ='')
	{
		if($page == '')
		{
			$this->core	->db->select('*')
						->from('hubby_controllers');
			$query 	=	$this->core->db->get();
			foreach($query->result() as $obj)
			{
				$array[] = array(
					'ID'		=>$obj->ID,
					'PAGE_CNAME'	=>$obj->PAGE_CNAME,
					'PAGE_NAMES'	=>$obj->PAGE_NAMES,
					'PAGE_MODULES'	=>$this->hubby->getSpeModuleByNamespace($obj->PAGE_MODULES),
					'PAGE_TITLE'	=>$obj->PAGE_TITLE,
					'PAGE_DESCRIPTION'		=>$obj->PAGE_DESCRIPTION,
					'PAGE_MAIN'		=>$obj->PAGE_MAIN,
					'PAGE_VISIBLE'	=>$obj->PAGE_VISIBLE
				);
			}
			$this->getpages	=	$array;
			return $array;	
		}
		else
		{
			$this->core	->db->select('*')
						->from('hubby_controllers')
						->where('PAGE_CNAME',$page);
			$query 	=	$this->core->db->get();
			foreach($query->result() as $obj)
			{
				$array[] = array(
					'ID'		=>$obj->ID,
					'PAGE_CNAME'	=>$obj->PAGE_CNAME,
					'PAGE_NAMES'	=>$obj->PAGE_NAMES,
					'PAGE_MODULES'	=>$this->hubby->getSpeModuleByNamespace($obj->PAGE_MODULES),
					'PAGE_TITLE'	=>$obj->PAGE_TITLE,
					'PAGE_DESCRIPTION'		=>$obj->PAGE_DESCRIPTION,
					'PAGE_MAIN'		=>$obj->PAGE_MAIN,
					'PAGE_VISIBLE'	=>$obj->PAGE_VISIBLE
				);
			}
			$this->getpages	=	$array;
			return $array;
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
	public function controller($name,$cname,$mod,$title,$description,$main,$obj = 'create',$id = '',$visible	=	'TRUE')
	{
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
					$e['PAGE_MAIN']	=	'FALSE';
					$this->core 	->db->where('ID',$q['ID'])
								->update('hubby_controllers',$e);
				}
			}
			$e['PAGE_CNAME']		=	strtolower($cname);
			$e['PAGE_NAMES']		=	strtolower($name);
			$e['PAGE_TITLE']		=	$title;
			$e['PAGE_DESCRIPTION']	=	$description;
			$e['PAGE_MAIN']			=	$main;
			$e['PAGE_MODULES']		=	$mod;
			$e['PAGE_VISIBLE']		=	$visible;
			if($obj == 'create')
			{
				if($this->core		->db->insert('hubby_controllers',$e))
				{
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
		return false;
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
			if(is_file(MODULES_DIR.$Module[0]['NAMESPACE'].'/uninstall.php'))
			{
				include_once(MODULES_DIR.$Module[0]['NAMESPACE'].'/uninstall.php');
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
	public function menuExtendsAfter($e)
	{
		$this->leftMenuExtentionAfter = $e;
	}
	public function menuExtendsBefore($e)
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
	public function setDefaultValuesForOtherSetting()
	{
		return $this->core->db->update('hubby_options',
			array('SHOW_WELCOME'=>'FALSE')
		);
	}
	// New methods
	private $appAllowedType					=	array('MODULE','THEME');
	private $appModuleAllowedTableField		=	array('NAMESPACE','HUMAN_NAME','AUTHOR','DESCRIPTION','TYPE','HUBBY_VERS','ENCRYPTED_DIR');
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
			$temp_dir	=	INSTALLER_DIR.$appFile['temp_dir'];
			if(class_exists('Hubby_installer'))
			{
				$appClass	=	new Hubby_installer;
				$appInfo	=	$appClass->datas();
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
			}
			$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
			$this->core->notice->push_notice(notice('invalidApp'));
			return 'invalidApp';
		}
		return 'errorOccured';
	}
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
	public function create_privilege($name,$description,$priv_id)
	{
		$query	=	$this->core->db->where('HUMAN_NAME',$name)->get('hubby_admin_privileges');
		if(count($query->result_array()) == 0)
		{
			$array	=	array(
				'HUMAN_NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'DATE'			=>	$this->core->hubby->datetime(),
				'PRIV_ID'		=>	$priv_id
			);
			return $this->core->db->insert('hubby_admin_privileges',$array);
		}
		return false;
	}
	public function edit_privilege($priv_id,$name,$description)
	{
		$query	=	$this->core->db->where('PRIV_ID',$priv_id)->get('hubby_admin_privileges');
		if(count($query->result_array()) > 0)
		{
			$array	=	array(
				'HUMAN_NAME'	=>	$name,
				'DESCRIPTION'	=>	$description
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
			return $this->core->db->where('PRIV_ID',$privid)->delete('hubby_admin_privileges');
		}
		return false;
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
}