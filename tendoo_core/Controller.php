<?php
Class Controller
{
	public 	$data;
	public	$url;
	public	$load;
	public	$Tendoo;
	public	$output;
	public	$lang;
	public 	$input;
	public 	$security;
	public 	$utf8;
	public 	$helper;
	public 	$notice;
	public 	$exceptions;
	public	$session;
	public 	$users_global;
	// other vars
	protected static $instance;
	public function __construct()
	{
		/* =-=-=-=-=-=-=-=-=-=-=-=-= INITIALIZE =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		self::$instance	=&	$this;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->url		=	new Url;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->notice	=	new Notice;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->lang		=	new Lang;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->utf8		=	new Utf8;		
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->security	=	new Security();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->load		=	new Loader($this);
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->input	=	new Input($this);
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->helper	=	new Helper($this);
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->exceptions=	new Exceptions;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->tendoo	=	new Tendoo;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->session	=	new Session;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->file		=	new File;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$baseUrl	=	$this->url->site_url(array('index'));
		$Class		=	$this->url->controller();	
		$Method		=	$this->url->method();
		$Parameters	=	$this->url->parameters();
		$Teurmola	=	explode('@',$this->url->controller());
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		is_compatible();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		if(strtolower($this->url->controller()) == 'install')
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if($this->tendoo->isInstalled())
			{
				$this->url->redirect(array('error','code','accessDenied'));
			}
			else
			{
				include_once(CONTROLLERS_DIR.'install.php');
				include_once(SYSTEM_DIR.'Executer.php');
			}
		}
		else if(strtolower($this->url->controller()) == 'registration')
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if($this->tendoo->isInstalled())
			{
				if($this->tendoo->connectToDb())
				{
				include_once(CONTROLLERS_DIR.'registration.php');
				include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
			}
			else
			{
				$this->url->redirect(array('install'));
			}
		}
		else if(strtolower($this->url->controller()) == 'login')
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if($this->tendoo->isInstalled())
			{
				if($this->tendoo->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'login.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
			}
			else
			{
				$this->url->redirect(array('install'));
			}
		}
		else if(strtolower($this->url->controller()) == 'logoff')
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if($this->tendoo->isInstalled())
			{
				if($this->tendoo->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'logoff.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
			}
			else
			{
				$this->url->redirect(array('install'));
			}
		}
		else if(strtolower($this->url->controller()) == 'admin')
		{
			// 	Define Script context to Admin
			define('SCRIPT_CONTEXT','ADMIN');
			// 	End define
			if($this->tendoo->isInstalled())
			{
				if($this->tendoo->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'admin.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
			}
			else
			{
				$this->url->redirect(array('install'));
			}
		}
		else if(strtolower($this->url->controller()) == 'account')
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if($this->tendoo->isInstalled())
			{
				if($this->tendoo->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'account.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
			}
			else
			{
				$this->url->redirect(array('install'));
			}
		}
		else if(strtolower($this->url->controller()) == 'error')
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			include_once(CONTROLLERS_DIR.'error.php');
			include_once(SYSTEM_DIR.'Executer.php');
		}
		else if(strtolower($Teurmola[0]) == 'tendoo') // TENDOO URL MODULE LAUNCHER : teurmola
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if(!$this->tendoo->isInstalled())
			{
				include_once(CONTROLLERS_DIR.'tendoo_index.php');
				include_once(SYSTEM_DIR.'Executer.php');
			}
			else
			{
				// Connexion a la base de donnée avec le fichier de configuration.
				if(!$this->tendoo->connectToDb())
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
				// LOAD SYSTEME VARS
				$this->data['url_module']	=		$Teurmola[1];
				
				$this->data['options']		=		$this->tendoo->getOptions();
				$this->data['controllers']	=		$this->tendoo->get_pages('',FALSE); // Get every page with their childrens instead of getController() who is now obsolete
				$this->data['activeTheme']		=		$this->tendoo->getSiteTheme();
				$this->data['Tendoo']		=		$this->tendoo;
				$this->data['module_url']	=		$this->url->site_url(array('tendoo@'.$Teurmola[1]));
				$this->tendoo->addVisit(); // Add visit to global stat;				

				$this->data['module']		=		$this->tendoo->getSpeModuleByNamespace($this->data['url_module']);
				if($this->data['activeTheme'] === FALSE)
				{
					$this->url->redirect(array('error','code','noThemeInstalled'));
				}
				else
				{
					// LOAD THEME HANDLER
					include_once(THEMES_DIR.$this->data['activeTheme']['ENCRYPTED_DIR'].'/extends/script.php');
					if(class_exists($this->data['activeTheme']['NAMESPACE'].'_theme_handler')) // Chargement du theme handler
					{
						eval('$this->data["theme"] = new '.$this->data['activeTheme']['NAMESPACE'].'_theme_handler($this->data);'); // Initialize Theme handler;
					}
					else // Erreur theme.
					{
						$this->url->redirect(array('error','code','themeCrashed'));
						return;
					}
					if($this->data['module'] !== FALSE) // LE MODULE EST INEXISTANT OU INCORRECT
					{
						// La priorité n'est plus prise en charge
						$this->data['GlobalModule']	=		$this->tendoo->getGlobalModules(1);   // Chargement des modules de type GLOBAL
						if(is_array($this->data['GlobalModule']))
						{
							foreach($this->data['GlobalModule'] as $r)
							{
								$TENDOO_MODULE	=	$r;
								include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/library.php');
								include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/module_controller.php');
							}
						}
						// $this->SAG has been removed, ever used
						// LOAD ON PAGE MODULE
						$TENDOO_MODULE	=	$this->data['module'][0];
						include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
						include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_controller.php');
						$Class	=	$this->data['module'][0]['NAMESPACE']; // REAFFECT CLASS VALUE DUE TO EXISTENT MODULE CLASS
					}
					else
					{
						$this->url->redirect(array('error','code','InvalidPage'));
						return;
					}
				}
				if(TRUE) // $this->SAG == FALSE had beend removed, ever used.
				{
					include_once(SYSTEM_DIR.'Executer.php'); /// MODULE EXECUTER
				}
			}
		}
		else
		{
			//	Define Script Context to Public
			define('SCRIPT_CONTEXT','PUBLIC');
			//	End
			if(!$this->tendoo->isInstalled())
			{
				include_once(CONTROLLERS_DIR.'tendoo_index.php');
				include_once(SYSTEM_DIR.'Executer.php');
			}
			else
			{
				// Connexion a la base de donnée avec le fichier de configuration.
				if(!$this->tendoo->connectToDb())
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
				// LOAD SYSTEME VARS
				$this->data['options']		=		$this->tendoo->getOptions();
				$this->data['controllers']	=		$this->tendoo->get_pages('',FALSE); // Get every page with their childrens instead of getController() who is now obsolete
				$this->data['page'] 		=		$this->tendoo->getPage($Class); // Get info from load Page
				if(is_string($this->data['page']))
				{
					$this->url->redirect(array('error','code',$this->data['page']));
				}
				else
				{
					$this->data['activeTheme']	=		$this->tendoo->getSiteTheme();
					$this->data['Tendoo']		=		$this->tendoo;
					$this->data['module_url']	=		$this->tendoo->retreiveControlerUrl();
					
					$this->tendoo->setKeywords($this->data['page'][0]['PAGE_KEYWORDS']);
					$this->tendoo->addVisit(); // Add visit to global stats
					if($this->data['module_url']	==	'noMainPage')
					{
						$this->url->redirect(array('error','code','noMainPage'));
					}
					$this->data['module']		=		$this->tendoo->getSpeModuleByNamespace($this->data['page'][0]['PAGE_MODULES']);
					if($this->data['activeTheme'] === FALSE)
					{
						$this->url->redirect(array('error','code','noThemeInstalled'));
					}
					else
					{
						// LOAD THEME HANDLER
						include_once(THEMES_DIR.$this->data['activeTheme']['ENCRYPTED_DIR'].'/extends/script.php');
						if(class_exists($this->data['activeTheme']['NAMESPACE'].'_theme_handler')) // Chargement du theme handler
						{
							eval('$this->data["theme"] = new '.$this->data['activeTheme']['NAMESPACE'].'_theme_handler($this->data);'); // Initialize Theme handler;
						}
						else // Erreur theme.
						{
							$this->url->redirect(array('error','code','themeCrashed'));
							return;
						}
						if($this->data['module'] !== FALSE) // LE MODULE EST INEXISTANT OU INCORRECT
						{
							// La priorité n'est plus prise en charge
							$this->data['GlobalModule']	=		$this->tendoo->getGlobalModules(1);   // Chargement des modules de type GLOBAL
							if(is_array($this->data['GlobalModule']))
							{
								foreach($this->data['GlobalModule'] as $r)
								{
									$TENDOO_MODULE	=	$r;
									include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/library.php');
									include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/module_controller.php');
								}
							}
							// $this->SAG has been removed, ever used
							// LOAD ON PAGE MODULE
							$TENDOO_MODULE	=	$this->data['module'][0];
							include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php');
							include_once(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_controller.php');
							$Class	=	$this->data['module'][0]['NAMESPACE']; // REAFFECT CLASS VALUE DUE TO EXISTENT MODULE CLASS
						}
						else
						{
							$this->url->redirect(array('error','code','InvalidPage'));
							return;
						}
					}
				}
				if(TRUE) // $this->SAG == FALSE had beend removed, ever used.
				{
					include_once(SYSTEM_DIR.'Executer.php'); /// MODULE EXECUTER
				}
			}
		}
	}
	public static function instance()
	{
		return Controller::$instance;
	}
	public function config_item($item)
	{
		static $_config_item = array();

		if ( ! isset($_config_item[$item]))
		{
			$config =& get_config();

			if ( ! isset($config[$item]))
			{
				return FALSE;
			}
			$_config_item[$item] = $config[$item];
		}

		return $_config_item[$item];
	}
}