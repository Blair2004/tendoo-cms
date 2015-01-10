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
		$this->is_installed		=	is_file( CONFIG_DIR . 'db_config.php' ) ? true : false;
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->description		=	__( 'No description available for this page' );
		$this->title			=	__( 'Untitled page' );
		$this->keywords			=	'';
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	}
	public function boot()
	{
		if($this->db_connect())
		{
			$this->date					=	new Tdate;
			$this->meta_datas			=	new Meta_datas;
		}
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		$baseUrl	=	$this->url->site_url(array('index'));
		$Class		=	$this->url->controller();	
		$Method		=	$this->url->method();
		$Parameters	=	$this->url->parameters();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		is_compatible();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		if( $this->is_installed == true ){
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
			load_modules();
			load_themes();
		/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
		}
		
		new Load_Core_Values;
		
		// Controller Start Here
		if( in_array( $this->url->controller() , array( 'install' , 'registration' , 'logoff' , 'admin' , 'login' , 'error' ) ) )
		{
			( $this->url->controller() == 'admin' ) ? define( 'SCRIPT_CONTEXT' , 'ADMIN' ) : define( 'SCRIPT_CONTEXT' , 'PUBLIC' );
			if($this->is_installed)
			{
				if( $this->db_connected() )
				{
					include_once( CONTROLLERS_DIR . $this->url->controller() . '.php' );
					include_once( SYSTEM_DIR . 'Executer.php' );
				}
				else
				{
					$this->tendoo->error( 'db_connect_error' );die;
				}
			}
			else if( $this->url->controller() == 'install' )
			{
				include_once( CONTROLLERS_DIR . $this->url->controller() . '.php' );
				include_once( SYSTEM_DIR . 'Executer.php' );
			}
			else
			{
				$this->url->redirect(array('install'));
			}
		}
		else
		{
			// Permet de savoir dans quel contexte le script est exécuté
			define('SCRIPT_CONTEXT','PUBLIC');
			
			// Is installed ?
			if( ! $this->is_installed )
			{
				include_once( CONTROLLERS_DIR . 'tendoo_index.php');
				include_once( SYSTEM_DIR . 'Executer.php');
			}
			else
			{
				// Connect to databse
				if( ! $this->db_connected() )
				{
					$this->tendoo->error('db_connect_error');die;
				}
				set_core_vars(	'options'	,	( $this->data['options']				=	get_meta( 'all' ) )	, 'readonly' );
				// Is WebApp Mode Enabled ? is so redirect to dashboard with notice enabled
				set_core_vars( 'tendoo_mode' , riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) , 'readonly' );
				if( get_core_vars( 'tendoo_mode' ) == 'webapp' )
				{
					$this->url->redirect( array( 'admin' , 'index?notice=web-app-mode-enabled' ) );
				}
				// Et les stats ?, on initialise
				// $this->load->library( 'stats' );  // No supported on 1.4
				// As we do engage init, users_global should be loaded once.
				$this->load->library( 'users_global' );
				
				// Première super variable Tendoo
				set_core_vars(	'controllers'	,	($this->data['controllers']		=	$this->tendoo->get_pages('',FALSE))	,'readonly'); // ??	
				set_core_vars(	'page'	,	($this->data['page']					=	$this->tendoo->getPage($Class))	,'readonly');	
				set_core_vars(	'active_theme'	,	( $this->data['active_theme']	= 	get_themes( 'filter_active' ) ) );
				// set_core_vars(	'tendoo'	,	($this->data['Tendoo']				=	$this->tendoo)	,'readonly'); // ? Remove Line
				set_core_vars(	'module_url'	,	($this->data['module_url']		=	$this->url->get_controller_url()) ,'readonly');
				set_core_vars(	'module'	,  $module 								= 	get_modules( 'filter_active_namespace' , $this->data['page'][0]['PAGE_MODULES'] ) ,'readonly');
				set_core_vars(	'opened_module'	,  $module ,'readonly');
				set_core_vars(	'app_module'	,	( 	$app_module 				= 	get_modules( 'filter_active_app' ) ),'readonly' );
				
				// Le controleur existe ? oui / Non ?
				
				if( is_string( $this->data['page'] ) )
				{
					$this->url->redirect(array('error','code',$this->data['page']));
				}
				else
				{
					// If selected module is valid
					if( ! $module ){
						$this->url->redirect(array('error','code', 'moduleBug'));
					}
					// Définition des meta données					
					set_page( 'title' , $this->data['page'][0]['PAGE_TITLE'] );
					set_page( 'description' , $this->data['page'][0]['PAGE_DESCRIPTION'] );
					set_page( 'keywords' , $this->data['page'][0]['PAGE_KEYWORDS']);
					
					// Saved First BreadCrumbs
					$INDEX	=	$this->tendoo->getPage( 'index' );
					set_bread( array (
						'link'	=>	$this->data['module_url'],
						'text'	=>	$INDEX[0][ 'PAGE_NAMES' ]
					) );
					
					/**
					 *
					 * Trigger each init.php file within module and theme folders
					 *
					**/
					$this->trigger_inits();
					
					// $this->stats->addVisit(); // No more supported
					
					if( TRUE !== ( $active_theme = does_active_theme_support( $module[ 'handle' ] ) ) )
					{
						$this->url->redirect(array('error','code','active_theme_does_not_handle_that'));
					}
					if( $this->data['module_url']	==	'noMainPage' )
					{
						$this->url->redirect( array( 'error' , 'code' , 'noMainPage' ) );
					}
					if($this->data['active_theme'] == FALSE)
					{
						$this->url->redirect(array('error','code','noThemeInstalled'));
					}
					else
					{
						// Load theme handler file
						include_if_file_exists( $this->data['active_theme']['uri_path'] . '/handler.php' );
						
						if(class_exists( $this->data['active_theme']['namespace'] . '_theme_handler')) // Chargement du theme handler
						{
							eval( 'set_core_vars("active_theme_object",new ' . $this->data['active_theme']['namespace'] . '_theme_handler());' ); // Initialize Theme handler;
						}
						else 
						{
							$this->url->redirect(array('error','code','themeCrashed'));
						}
						
						$TENDOO_MODULE			=	$module;
						$Class					=	$module['namespace']; // REAFFECT CLASS VALUE DUE TO EXISTENT MODULE CLASS
						
						include_if_file_exists( MODULES_DIR . $module['encrypted_dir'] . '/library.php' );
						include_once( MODULES_DIR . $module['encrypted_dir'] . '/frontend.php' );
					}
					include_once( SYSTEM_DIR . 'Executer.php' ); /// MODULE EXECUTER
				}
			}
		}
	}
	public function db_connect()
	{
		if( $this->is_installed )
		{
			// To avoid multiple database connection
			if( ! $this->db_connected() )
			{
				include_once(SYSTEM_DIR.'config/db_config.php');
				$this->db	=	DB($db,TRUE);
				set_db( $this->db );
				$this->db_connected	=	true;
				if( ! defined( 'DB_ROOT' ) )
				{
					define( 'DB_ROOT' , $config[ 'dbprefix' ] );
				}
				return true;
			}
		}
		else
		{
			if( ! $this->db_connected() && array_key_exists( 'db_datas' , $_SESSION ) )
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
	public function is_installed()
	{
		return $this->is_installed;
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
	*	Push value to Core Array.
	**/
	public function set_core_vars( $key , $value , $access ="writable" ) // Restreindre la modification du système
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
	*	Fetch Key Value saved on Core Array.
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
	*	Passive Tendoo Script
	**/
	private function trigger_inits()
	{
		trigger_inits();
	}
}