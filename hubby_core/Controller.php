<?php
Class Controller
{
	public	$url;
	public	$load;
	public	$hubby;
	public	$output;
	public	$lang;
	public 	$input;
	public 	$security;
	public 	$utf8;
	public 	$helper;
	public 	$notice;
	public 	$exceptions;
	public	$session;
	public 	$user_global;
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
		$this->load		=	new Loader();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->input	=	new Input($this);
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->helper	=	new Helper($this);
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->exceptions=	new Exceptions;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->hubby	=	new Hubby;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$this->session	=	new Session;
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$baseUrl	=	$this->url->site_url(array('index'));
		$Class		=	$this->url->controller();	
		$Method		=	$this->url->method();
		$Parameters	=	$this->url->parameters();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		is_compatible();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		if(strtolower($this->url->controller()) == 'install')
		{
			if($this->hubby->isInstalled())
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
			if($this->hubby->isInstalled())
			{
				if($this->hubby->connectToDb())
				{
				include_once(CONTROLLERS_DIR.'registration.php');
				include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->hubby->error('db_connect_error');
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
			if($this->hubby->isInstalled())
			{
				if($this->hubby->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'login.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->hubby->error('db_connect_error');
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
			if($this->hubby->isInstalled())
			{
				if($this->hubby->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'logoff.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->hubby->error('db_connect_error');
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
			if($this->hubby->isInstalled())
			{
				if($this->hubby->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'admin.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->hubby->error('db_connect_error');
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
			if($this->hubby->isInstalled())
			{
				if($this->hubby->connectToDb())
				{
					include_once(CONTROLLERS_DIR.'account.php');
					include_once(SYSTEM_DIR.'Executer.php');
				}
				else
				{
					$this->hubby->error('db_connect_error');
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
			include_once(CONTROLLERS_DIR.'error.php');
			include_once(SYSTEM_DIR.'Executer.php');
		}
		else
		{
			if(!$this->hubby->isInstalled())
			{
				include_once(CONTROLLERS_DIR.'hubby_index.php');
				include_once(SYSTEM_DIR.'Executer.php');
			}
			else
			{
				// Connexion a la base de donnée avec le fichier de configuration.
				if(!$this->hubby->connectToDb())
				{
					$this->hubby->error('db_connect_error');
					die();
				}
				// LOAD SYSTEME VARS
				$this->data['options']		=		$this->hubby->getOptions();
				$this->data['controllers']	=		$this->hubby->getControllers();
				$this->data['page'] 		=		$this->hubby->getPage($Class); // Get info from load Page
				if(is_string($this->data['page']))
				{
					$this->url->redirect(array('error','code',$this->data['page']));
				}
				else
				{
					$this->data['getTheme']		=		$this->hubby->getSiteTheme();
					$this->data['hubby']		=		$this->hubby;
					$this->data['module_url']	=		$this->hubby->retreiveControlerUrl();
					if($this->data['module_url']	==	'noMainPage')
					{
						$this->url->redirect(array('error','code','noMainPage'));
					}
					$this->data['module']		=		$this->hubby->getSpeModuleByNamespace($this->data['page'][0]['PAGE_MODULES']);
					if($this->data['getTheme'] === FALSE)
					{
						$this->url->redirect(array('error','code','noThemeInstalled'));
					}
					else
					{
						// LOAD THEME HANDLER
						include_once(THEMES_DIR.$this->data['getTheme']['ENCRYPTED_DIR'].'/extends/script.php');
						if(class_exists($this->data['getTheme']['NAMESPACE'].'_theme_handler')) // Chargement du theme handler
						{
							eval('$this->data["theme"] = new '.$this->data['getTheme']['NAMESPACE'].'_theme_handler($this->data);'); // Initialize Theme handler;
						}
						else // Erreur theme.
						{
							$this->url->redirect(array('error','code','themeTrashed'));
							return;
						}
						if($this->data['module'] !== FALSE) // LE MODULE EST INEXISTANT OU INCORRECT
						{
							// La priorité n'est plus prise en charge
							$this->data['GlobalModule']	=		$this->hubby->getGlobalModules(1);   // Chargement des modules de type GLOBAL
							if(is_array($this->data['GlobalModule']))
							{
								foreach($this->data['GlobalModule'] as $r)
								{
									$HUBBY_MODULE	=	$r;
									include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/library.php');
									include_once(MODULES_DIR.$r['ENCRYPTED_DIR'].'/module_controller.php');
								}
							}
							// $this->SAG has been removed, ever used
							// LOAD ON PAGE MODULE
							$HUBBY_MODULE	=	$this->data['module'][0];
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
	public function __clone()
	{
		return $this->instance();
	}
}