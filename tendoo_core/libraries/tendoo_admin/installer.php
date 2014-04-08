<?php
class tendoo_installer
{
	public function __construct()
	{
		__extends($this);
		$this->load->library('upload');
		// 
	}
	public function encrypted_name()
	{
		$alphabet	=	array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
		$index		=	count($alphabet)-1;
		return 'tendoo_app_'.rand(0,9).date('Y').date('m').date('d').date('H').date('i').date('s').$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)];
	}
	// New methods
	private $appAllowedType					=	array('MODULE','THEME');
	private $appModuleAllowedTableField		=	array('NAMESPACE','HAS_WIDGET','HAS_MENU','HAS_API','HAS_ICON','HUMAN_NAME','AUTHOR','DESCRIPTION','TYPE','TENDOO_VERS','ENCRYPTED_DIR','APP_VERS');
	private $appThemeAllowedTableField		=	array('NAMESPACE','HUMAN_NAME','AUTHOR','DESCRIPTION','TENDOO_VERS','ENCRYPTED_DIR','APP_VERS');
	public function tendoo_installer($source)
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
		$this->load->library('upload',$config);
		if($this->upload->do_upload($source))
		{
			$appFile	=	Unzip(INSTALLER_DIR.$this->upload->file_name);
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
								$this->notice->push_notice(notice('invalidApp'));
								return 'invalidApp';
							}
						}
					}
					else
					{
						$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
						$this->notice->push_notice(notice('invalidApp'));
						return 'invalidApp';
					}
					if($appInfo['appTendooVers'] <= $this->tendoo->getVersId())
					{
						$this->db		->select('*')
											->from('tendoo_modules')
											->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
						$query = $this->db->get();
						// -----------------------------------------------------------------------------------------
						if($query->num_rows == 0)
						{
							if(is_array($appInfo['appSql']))
							{
								foreach($appInfo['appSql'] as $sql)
								{
									$this->db->query($sql);
								}
							}
							$this->db->insert('tendoo_modules',$appInfo['appTableField']);
							if(is_dir($temp_dir))
							{
								$this->extractor($temp_dir,MODULES_DIR.$appFile['temp_dir']);
								$this->notice->push_notice(notice('moduleInstalled'));
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
											$this->notice->push_notice(notice('creatingHiddenControllerFailure'));
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
								if(array_key_exists('appHiddenController',$appInfo)) // Créer un controlleur pendant l'installation
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
											$this->notice->push_notice(notice('creatingHiddenControllerFailure'));
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
							$this->notice->push_notice(notice('module_alreadyExist'));
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'module_alreadyExist';
						}
					}
					$this->notice->push_notice(notice('NoCompatibleModule'));
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
								$this->notice->push_notice(notice('invalidApp'));
								
								return 'invalidApp';
							}
						}
					}
					else
					{
						$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
						$this->notice->push_notice(notice('invalidApp'));
						return 'invalidApp';
					}
					if($appInfo['appTendooVers'] <= $this->tendoo->getVersId())
					{
						$this->db		->select('*')
											->from('tendoo_themes')
											->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
						$query = $this->db->get();
						// -----------------------------------------------------------------------------------------
						if($query->num_rows == 0)
						{
							if(is_array($appInfo['appSql']))
							{
								foreach($appInfo['appSql'] as $sql)
								{
									$this->db->query($sql);
								}
							}
							$this->db->insert('tendoo_themes',$appInfo['appTableField']);
							if(is_dir($temp_dir))
							{
								$this->extractor($temp_dir,THEMES_DIR.$appFile['temp_dir']);
								$this->notice->push_notice(notice('theme_installed'));
								$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
								return 'theme_installed';
							}
						}
						else
						{
							$this->notice->push_notice(notice('theme_alreadyExist'));
							$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
							return 'theme_alreadyExist';
						}
					}
					$this->notice->push_notice(notice('NoCompatibleTheme'));
					$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
					return 'NoCompatibleTheme';
				}
			}
			$this->drop(INSTALLER_DIR.$appFile['temp_dir']);
			$this->notice->push_notice(notice('invalidApp'));
			return 'invalidApp';
		}
		return 'errorOccured';
	}
	public function tendoo_core_installer($appFile)
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
				if($appInfo['appTendooVers'] <= $this->tendoo->getVersId())
				{					
					$this->db		->select('*')
										->from('tendoo_modules')
										->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
					$query = $this->db->get();
					// -----------------------------------------------------------------------------------------
					if($query->num_rows == 0)
					{
						if(is_array($appInfo['appSql']))
						{
							foreach($appInfo['appSql'] as $sql)
							{
								$this->db->query($sql);
							}
						}
						$this->db->insert('tendoo_modules',$appInfo['appTableField']);
						if(is_dir($temp_dir))
						{
							$this->extractor($temp_dir,MODULES_DIR.$appFile['temp_dir']);
							$this->notice->push_notice(notice('moduleInstalled'));
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
										$this->notice->push_notice(notice('creatingHiddenControllerFailure'));
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
				if($appInfo['appTendooVers'] <= $this->tendoo->getVersId())
				{
					$this->db		->select('*')
										->from('tendoo_themes')
										->where('NAMESPACE',$appInfo['appTableField']['NAMESPACE']);
					$query = $this->db->get();
					// -----------------------------------------------------------------------------------------
					if($query->num_rows == 0)
					{
						if(is_array($appInfo['appSql']))
						{
							foreach($appInfo['appSql'] as $sql)
							{
								$this->db->query($sql);
							}
						}
						$this->db->insert('tendoo_themes',$appInfo['appTableField']);
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
	public function tendoo_url_installer($link,$type = 'default') // install through a link
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
		return $this->tendoo_core_installer($appFile);
	}
	// Install New Methods
	public function installSession()
	{
		/* 
		/*	START A NEW INSTALL SESSION
		*/
		unset($this->appType);
		unset($this->appVers);
		unset($this->appTendooVers);
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
	private $appTendooVers;
	public function appTendooVers($version)
	{
		$this->appTendooVers	=	$version;
	}
	private $appTableField	=	array();
	public function appTableField($fields)
	{
		$this->appTableField	=	$fields; // File information such as NAMESPACE, HUMAN_NAME, DESCRIPTION and others
		$this->appTableField['APP_VERS']	=	$this->appVers;
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
			'appTendooVers'		=>	$this->appTendooVers, // Tendoo required version.
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
	private $system_dir	=	array('tendoo_themes/','tendoo_core/','tendoo_installer/','tendoo_modules/','tendoo_assets/');
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
}