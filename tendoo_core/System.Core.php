<?php
Class instance extends Libraries
{
	private $is_installed			=	false;
	private $db_connected			=	false;
	private $data					=	array();
	private $core_vars				=	array();
	public static $instance;
	public function __construct()
	{
		parent::__construct();
		self::$instance			=&	$this;
		$this->is_installed		=	is_file('tendoo_core/config/db_config.php') ? true : false;
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->description		=	'Page Sans Description | Tendoo CMS';
		$this->title			=	'Page Sans Titre | Tendoo CMS';
		$this->keywords			=	'';
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	}
	public function boot()
	{
		if($this->db_connect())
		{
			$this->date				=	new Tdate;
			$this->options			=	new Options;
		}
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
			if($this->is_installed)
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
			if($this->is_installed)
			{
				if($this->db_connected())
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
			if($this->is_installed)
			{
				if($this->db_connected())
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
			if($this->is_installed)
			{
				if($this->db_connected())
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
			if($this->is_installed)
			{
				if($this->db_connected())
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
			if($this->is_installed)
			{
				if($this->db_connected())
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
			if(!$this->is_installed)
			{
				include_once(CONTROLLERS_DIR.'tendoo_index.php');
				include_once(SYSTEM_DIR.'Executer.php');
			}
			else
			{
				// Connexion a la base de donnée avec le fichier de configuration.
				if(!$this->db_connected())

				{
					$this->tendoo->error('db_connect_error');
					die();
				}
				$this->load->library( 'stats' );
				// LOAD SYSTEME VARS
				$this->data['url_module']	=		$Teurmola[1];
				
				set_core_vars(	'options'	,	($this->data['options']	=	$this->options->get())	);
				set_core_vars(	'controllers'	,	($this->data['controllers']	=	$this->tendoo->get_pages('',FALSE))	);
				set_core_vars(	'page'	,	($this->data['page']	=	$this->tendoo->getPage($Class))	);
				set_core_vars(	'active_theme'	,	($this->data['active_theme']	= $this->tendoo->getSiteTheme()));
				set_core_vars(	'tendoo'	,	($this->data['Tendoo']		=		$this->tendoo)	);
				set_core_vars(	'module_url'	,	($this->data['module_url']	=		$this->url->site_url(array('tendoo@'.$Teurmola[1]))));
				//
				set_core_vars(	'opened_moule'	,  ($this->data['module']		=		$this->tendoo->getSpeModuleByNamespace($this->data['url_module'])));
				set_core_vars(	'module'	,  ($this->data['module']		=		$this->tendoo->getSpeModuleByNamespace($this->data['url_module'])));
				//
				set_core_vars(	'globalModule'	,	($this->data['GlobalModule']	=		$this->tendoo->getGlobalModules(1)));

				$this->data['module_url']	=		$this->url->site_url(array('tendoo@'.$Teurmola[1]));
				$this->stats->addVisit(); // Add visit to global stat;				

				/**
				*		TENDOO PASSIVE SCRIPTING
				**/
				
				$this->engage_tepas();
				
				/**
				*		END
				**/	
				if($this->data['active_theme'] === FALSE)
				{
					$this->url->redirect(array('error','code','noThemeInstalled'));
				}
				else
				{
					if(TRUE !== ($active_theme = does_active_theme_support($this->data['module'][0]['HANDLE'])))
					{
						$this->url->redirect(array('error','code','active_theme_does_not_handle_that'));
					}
					// LOAD THEME HANDLER
					include_once(THEMES_DIR.$this->data['active_theme']['ENCRYPTED_DIR'].'/theme-items-class.php');
					if(class_exists($this->data['active_theme']['NAMESPACE'].'_theme_handler')) // Chargement du theme handler
					{
						eval('set_core_vars("active_theme_object", new '.$this->data['active_theme']['NAMESPACE'].'_theme_handler());'); // Initialize Theme handler;
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
			if(!$this->is_installed)
			{
				include_once(CONTROLLERS_DIR.'tendoo_index.php');
				include_once(SYSTEM_DIR.'Executer.php');
			}
			else
			{
				// Connexion a la base de donnée avec le fichier de configuration.
				if(!$this->db_connected())
				{
					$this->tendoo->error('db_connect_error');
					die();
				}
				$this->load->library( 'stats' );
				// Tendoo 0.9.9
				set_core_vars(	'options'	,	($this->data['options']	=	$this->options->get())	,'readonly');
				set_core_vars(	'controllers'	,	($this->data['controllers']	=	$this->tendoo->get_pages('',FALSE))	,'readonly');
				set_core_vars(	'page'	,	($this->data['page']	=	$this->tendoo->getPage($Class))	,'readonly');		
				if(is_string($this->data['page']))
				{
					$this->url->redirect(array('error','code',$this->data['page']));
				}
				else
				{
					set_core_vars(	'active_theme'	,	($this->data['active_theme']	= $this->tendoo->getSiteTheme()));
					set_core_vars(	'tendoo'	,	($this->data['Tendoo']		=		$this->tendoo)	,'readonly');
					set_core_vars(	'module_url'	,	($this->data['module_url']	=		$this->url->get_controller_url()) ,'readonly');
					$this->data['module']					= $this->tendoo->getSpeModuleByNamespace($this->data['page'][0]['PAGE_MODULES']);
					$this->data['module'][0]['URI_PATH']	=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/';
					$this->data['module'][0]['URL_PATH']	=	$this->url->main_url().MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/';
					//
					set_core_vars(	'module'	,  $this->data['module'] ,'readonly');
					set_core_vars(	'opened_module'	,  $this->data['module'] ,'readonly');
					//
					set_core_vars(	'globalModule'	,	($this->data['GlobalModule']	=		$this->tendoo->getGlobalModules(1)));
					set_page( 'title' , $this->data['page'][0]['PAGE_TITLE'] );
					set_page( 'description' , $this->data['page'][0]['PAGE_DESCRIPTION'] );
					set_page( 'keywords' , $this->data['page'][0]['PAGE_KEYWORDS']);
					// Saved First BreadCrumbs
					$INDEX	=	$this->tendoo->getPage( 'index' );
					set_bread( array (
						'link'	=>	$this->data['module_url'],
						'text'	=>	$INDEX[0][ 'PAGE_NAMES' ]
					) );
					// End BreadCrumbs
					// Tendoo 1.2
					/**
					*		TENDOO PASSIVE SCRIPTING
					**/
					
					$this->engage_tepas();
					
					/**
					*		END
					**/	
					$this->stats->addVisit(); // Add visit to global stats
					if(TRUE !== ($active_theme = does_active_theme_support($this->data['module'][0]['HANDLE'])))
					{
						$this->url->redirect(array('error','code','active_theme_does_not_handle_that'));
					}
					if($this->data['module_url']	==	'noMainPage')
					{
						$this->url->redirect(array('error','code','noMainPage'));
					}
					if($this->data['active_theme'] === FALSE)
					{
						$this->url->redirect(array('error','code','noThemeInstalled'));
					}
					else
					{
						// LOAD THEME HANDLER
						include_once(THEMES_DIR.$this->data['active_theme']['ENCRYPTED_DIR'].'/handler.php');
						if(class_exists($this->data['active_theme']['NAMESPACE'].'_theme_handler')) // Chargement du theme handler
						{
							eval('set_core_vars("active_theme_object",new '.$this->data['active_theme']['NAMESPACE'].'_theme_handler());'); // Initialize Theme handler;
						}
						else // Erreur theme.
						{
							$this->url->redirect(array('error','code','themeCrashed'));
							return;
						}
						if($this->data['module'] !== FALSE) // LE MODULE EST INEXISTANT OU INCORRECT
						{
							// La priorité n'est plus prise en charge
							if(is_array($this->data['GlobalModule']))
							{
								foreach($this->data['GlobalModule'] as $r)
								{
									$TENDOO_MODULE	=	$r;
									include_if_file_exists( MODULES_DIR.$r['ENCRYPTED_DIR'].'/library.php' );
									include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/module_controller.php');
								}
							}
							// $this->SAG has been removed, ever used
							// LOAD ON PAGE MODULE
							$TENDOO_MODULE	=	$this->data['module'][0];
							include_if_file_exists( MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php' );
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
	public function db_connect()
	{
		if($this->is_installed)
		{
			// Pour ne pas multiplier les connexion vers la base de données.
			if(!$this->db_connected())
			{
				include_once(SYSTEM_DIR.'config/db_config.php');
				$this->db	=	DB($db,TRUE);
				set_db($this->db);
				$this->db_connected	=	true;
				if(!defined('DB_ROOT'))
				{
					define('DB_ROOT',$config['dbprefix']);
				}
				return true;
			}
		}
		else
		{
			if(!$this->db_connected() && array_key_exists('db_datas',$_SESSION))
			{
				$config		=	$_SESSION['db_datas'];
				$this->db	=	DB($config,TRUE);
				set_db($this->db);
				$this->db_connected	=	true;
				if(!defined('DB_ROOT'))
				{
					define('DB_ROOT',$config['dbprefix']);
				}
				return true;
			}
		}
		return false;
	}
	public function db_connected()
	{
		return $this->db_connected;
	}
	public static function instance()
	{
		return instance::$instance;
	}
	public function version()
	{
		return 'Tendoo - CMS('.$this->id().')';
	}
	public function id()
	{
		return TENDOO_VERSION;
	}
	/**
	*	Mise à jour du tableau du noyau
	**/
	public function set_core_vars($key,$value,$access ="writable") // Restreindre la modification du système
	{
		$access		=	in_array($access,array('writable','readonly','read_only')) ? $access : 'writable';
		$exists		=	$this->get_core_vars($key,'complete');
		if($exists)
		{
			if(in_array($exists[1],array('readonly','read_only')))
			{
				return false;
			}
		}
		$this->core_vars[$key]	=	array($value,$access);
		return true;
	}
	/**
	*	Recupértion d'un champ du tableau du système.
	**/
	public function get_core_vars($key = null,$process = "normal")
	{
		if($key == null)
		{
			return $this->core_vars;
		}
		else
		{
			if($process == 'normal')
			{
				return array_key_exists($key,$this->core_vars) ? $this->core_vars[$key][0] : false;
			}
			else if($process == 'complete')
			{
				return array_key_exists($key,$this->core_vars) ? $this->core_vars[$key] : false;
			}
		}
	}
	/**
	*	Script Passif Tendoo
	**/
	private function engage_tepas()
	{
		engage_tepas();
	}
}