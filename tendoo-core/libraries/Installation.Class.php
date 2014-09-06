<?php
class Installation extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		__extends($this);
	}
	public function createTables()
	{
		$config			=	$_SESSION['db_datas'];
		$DB_ROOT		=	$config['dbprefix'];
		/* CREATE tendoo_controllers */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_controllers` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `PAGE_NAMES` varchar(200) NOT NULL,
		  `PAGE_CNAME` varchar(200) NOT NULL,
		  `PAGE_MODULES` text,
		  `PAGE_TITLE` varchar(200) NOT NULL,
		  `PAGE_DESCRIPTION` text,
		  `PAGE_MAIN` varchar(5) DEFAULT NULL,
		  `PAGE_VISIBLE` varchar(5) NOT NULL,
		  `PAGE_PARENT` varchar(200) NOT NULL,
		  `PAGE_LINK` text,
		  `PAGE_POSITION` int(11) NOT NULL,
		  `PAGE_KEYWORDS` varchar(200) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_visit_stats */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_visit_stats` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `DATE` datetime NOT NULL,
		  `VISITORS_IP` varchar(200) NOT NULL,
		  `VISITORS_USERAGENT` varchar(40) NOT NULL,
		  `GLOBAL_VISIT` int(50) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_meta */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_meta` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`KEY` varchar(255) NOT NULL,
			`VALUE` text,
			`USER` varchar(255) NOT NULL,
			`DATE` datetime NOT NULL,
			`APP` varchar(255) NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		// APP eg. theme_nevia, module_blogster, module_static_pages, module_eshopping etc
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* 
		 int(11) NOT NULL, Removed, only admin can access private stats.
		*/
		/* CREATE tendoo_users */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_users` (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`PSEUDO` varchar(100) NOT NULL,
			`PASSWORD` varchar(100) NOT NULL,
			`NAME` varchar(100) NOT NULL,
			`SURNAME` varchar(100) NOT NULL,
			`EMAIL` varchar(100) NOT NULL,
			`SEX` varchar(50) NOT NULL,
			`REG_DATE` datetime NOT NULL,
			`LAST_ACTIVITY` datetime NOT NULL,
			`PRIVILEGE` varchar(100) NOT NULL,
			`ACTIVE` varchar(100) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/// MESSAGING TABLE create `tendoo_users_messaging_content`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_users_messaging_content` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `MESG_TITLE_REF` int(11) NOT NULL,
		  `CONTENT` text NOT NULL,
		  `AUTHOR` int(11) NOT NULL,
		  `DATE` datetime NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		
		/// ADMIN PRIVILEGE TABLE create  `tendoo_admin_privileges`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_admin_privileges` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `HUMAN_NAME` varchar(100) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `DATE` datetime NOT NULL,
		  `PRIV_ID` varchar(100) NOT NULL,
		  `IS_SELECTABLE` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;
		;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/// ADMIN PRIVILEGE TABLE create  `tendoo_privileges_actions`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_privileges_actions` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `OBJECT_NAMESPACE` 	varchar(200) NOT NULL,
		  `TYPE_NAMESPACE` 		varchar(200) NOT NULL,
		  `REF_TYPE_ACTION` 	varchar(100) NOT NULL,
		  `REF_ACTION_VALUE` 	varchar(100) NOT NULL,
		  `REF_PRIVILEGE` varchar(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		// Create `tendoo_modules_actions`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_modules_actions` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `MOD_NAMESPACE` varchar(200) NOT NULL,
		  `ACTION` varchar(100) NOT NULL,
		  `ACTION_NAME` varchar(100) NOT NULL,
		  `ACTION_DESCRIPTION` varchar(200) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		// Create `tendoo_modules_actions`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_users_messaging_title` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `AUTHOR` int(11) NOT NULL,
		  `RECEIVER` int(11) NOT NULL,
		  `CREATION_DATE` datetime NOT NULL,
		  `STATE` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		return true;
	}
	public function app_step( $step )
	{
		$this->load->library('tendoo'); // Refreshing Tendoo Clss
		$this->load->library('tendoo_admin'); // loading Admin Class
		// Base config, creating tables and saving firt name
		if( $step == 1 ){
			// Working 100%
			if( $this->createTables() && get_instance()->meta_datas->set( 'site_name' , $this->input->post( 'site_name' ) , 'from_install_interface' , 'system' ) ){ 
				// Get all module and exec sql queries
				load_modules();
				$modules	=	get_modules( 'all' );
				if( $modules ){
					foreach( $modules as $namespace	=>	$app_datas ){
						// Activate module 
						active_module( $namespace );
						// Executing Sql queries
						if( is_array( $queries =	riake( 'sql_queries' , $app_datas ) ) ){
							foreach( $queries as $sql_line ){
								get_db( 'from_install_interface' )->query( $sql_line );
							}
						}
						// Registering Actions
						if( is_array( $actions	=	riake ( 'declared_actions' , $app_datas ) ) ){
							foreach( $actions  as $_action ){
								if( $this->tendoo_admin->_action_keys_is_allowed( array_keys( $_action ) ) ){
									foreach( $_action as $key => $value ){
										$$key	=	$value;
									}
									$this->tendoo_admin->createModuleAction($mod_namespace,$action,$action_name,$action_description);
								}
							}
						}
					}
				}
				// Get unique available theme
				load_themes();
				$themes		=	get_themes( 'all' );
				// Creating Config File
				$this->createConfigFile();
				// Consider changing the way admin icons are reconnized. Saving Admin Icon
				get_instance()->meta_datas->set( 'admin_icons' , '$icons	=	array();$icons[]	=	"";$icons[]	=	"blogster/main_icon";$icons[]	=	"pages_editor/main_icon";$icons[]	=	"tendoo_contact_handler/main_icon";$icons[]	=	"tendoo_contents/main_icon";$icons[]	=	"tendoo_widget_administrator/main_icon";$icons[]	=	"tim/main_icon";' );
				// Setting Logo URL
				get_instance()->meta_datas->set( 'site_logo' , img_url( 'start_logo.png' ) );
				// Creating Controllers
				// Home
				$this->tendoo_admin->controller(
					"Accueil",
					"home",
					"tim",
					"Accueil - " . get_meta( 'site_name' ),
					"Un site Web utilisant Tendoo.",
					"TRUE",
					$obj = 'create',
					$id = '',
					$visible	=	'TRUE',
					$childOf= 'none',
					$page_link	=	'',
					$keywords = 'tendoo, cms'
				);
				// Blog
				$this->tendoo_admin->controller(
					"Blog",
					"blog",
					"blogster",
					"Blog - " . get_meta( 'site_name' ),
					"Un site Web utilisant Tendoo.",
					"FALSE",
					$obj = 'create',
					$id = '',
					$visible	=	'TRUE',
					$childOf= 'none',
					$page_link	=	'',
					$keywords = 'tendoo, cms, blog'
				);
				// Static
				$this->tendoo_admin->controller(
					"Nouvelle page",
					"nouvelle-page",
					"page_editor",
					"Nouvelle page",
					"Un site Web utilisant Tendoo.",
					"FALSE",
					$obj = 'create',
					$id = '',
					$visible	=	'TRUE',
					$childOf= 'none',
					$page_link	=	'',
					$keywords = 'tendoo, cms, new page'
				);				
				// Setting Theme Config
				get_instance()->meta_datas->set( 'flaty_theme_settings' , '{"slider":{"api_limit":"10","declared_apis":"blogster_get_blog_post","declared_item":"slider"},"testimony":{"testimony_big_title":"Tendoo c\'est \u00e9galement","testimony_big_description":"Plusieurs fonctionnalit\u00e9s, plusieurs th\u00e8mes et une communaut\u00e9 qui grandit chaque jour. Pourquoi utiliser Tendoo ?","testimony_content":{"level":{"0":"Je le trouve tr\u00e8s abouti pour un projet r\u00e9alis\u00e9 par une petite \u00e9quipe de b\u00e9n\u00e9voles.","1":"Je ne m\'attendais pas \u00e0 autant de succ\u00e8s, mais surtout de s\u00e9rieux dans le travail de mes coll\u00e8gues.","2":"C\'est certainement un projet qui ira loin. De toutes les fa\u00e7ons je suis d\u00e9cid\u00e9 \u00e0 apporter mon expertise.","3":"Nous avons beaucoup travaill\u00e9 pour atteindre ce r\u00e9sultat et nous en sommes fiers. Nous comptons proposer une v\u00e9ritable application gratuite pour tous les utilisateurs."}},"testimony_authors":{"level":{"0":"B. Jersyer","1":"Afromaster","2":"Lucas Ferry","3":"Sergey Rakovsky"}}},"list_services":{"section_text":"","section_textarea":"","title":{"level":{"0":"Suivez-nous sur Facebook","1":"Suivez-nous sur Twitter","2":"Google+"}},"link":{"level":{"0":"http:\/\/facebook.com\/tendoocms","1":"http:\/\/twitter.com\/","2":"http:\/\/plus.google.com"}},"description":{"level":{"0":"Toutes les actualit\u00e9s, les mises \u00e0 jours, les \u00e9v\u00e9nements sont disponibles sur facebook.","1":"Nous sommes \u00e9galement sur Twitter, ne manquez aucun de nos tweets.","2":"Ne ratez aucune de nos actualit\u00e9s sur Google+. Ajoutez-nous \u00e0 vos cercles."}},"icons":{"level":{"0":"facebook","1":"twitter","2":"google-plus"}}}}' );
				if( $themes ){
					foreach( $themes as $namespace	=>	$app_datas ){
						// Activate module 
						active_theme( $namespace );
						// Executing Sql queries
						if( is_array( $queries =	riake( 'sql_queries' , $app_datas ) ) ){
							foreach( $queries as $sql_line ){
								get_db( 'from_install_interface' )->query( $sql_line );
							}
						}
					}
				}
				return json_encode( array( 
					'response'	=>	translate( "Installation is now complete. We're taking you to your new website. This install process won't be no more visible..." ),
					'type'		=>	'warning',
					'step'		=>	2,
					'progress'	=>	100
				) );
			} else {
				return json_encode( array( 
					'response'	=>	translate( 'Error occurred during tables creation. Please check out the connectivity between your configuration and the server.' ),
					'type'		=>	'warning',
					'step'		=>	0,
					'progress'	=>	0
				) );
			}
		}
		return json_encode( array( 
			'response'	=>	translate( 'Unknow install step, please try again.' ),
			'type'		=>	'warning'
		) );		
	}
	public function createConfigFile()
	{
		/* CREATE CONFIG FILE */
		$config			=	$_SESSION['db_datas'];
		$string_config = 
		"<?php
		\$db['hostname'] = '".$config['hostname']."';
		\$db['username'] = '".$config['username']."';
		\$db['password'] = '".$config['password']."';
		\$db['database'] = '".$config['database']."';
		\$db['dbdriver'] = '".$config['dbdriver']."';
		\$db['dbprefix'] = '".$config['dbprefix']."';
		\$db['pconnect'] = FALSE;
		\$db['db_debug'] = TRUE;
		\$db['cache_on'] = FALSE;
		\$db['cachedir'] = '';
		\$db['char_set'] = 'utf8';
		\$db['dbcollat'] = 'utf8_general_ci';
		\$db['swap_pre'] = '';
		\$db['autoinit'] = TRUE;
		\$db['stricton'] = FALSE;
		if(!defined('DB_ROOT'))
		{
			define('DB_ROOT',\$db['dbprefix']);
		}
		";
		$file = fopen('tendoo-core/config/db_config.php','w+');
		fwrite($file,$string_config);
		fclose($file);
	}
	public function attempt_db_connection($host,$user,$pass,$db_name,$type,$extension)
	{
		$this->instance		=	get_instance();
		$config['hostname'] = 	$host;
		$config['username'] = 	$user;
		$config['password'] = 	$pass;
		$config['database'] = 	$db_name;
		$config['dbdriver'] = 	$type;
		$config['dbprefix'] = 	(!preg_match('#^tendoo#',$extension)) ? $extension : 'td_';
		$config['pconnect'] = 	TRUE;
		$config['db_debug'] = 	TRUE;
		$config['cache_on'] = 	FALSE;
		$config['cachedir'] = 	"";
		$config['char_set'] = 	"utf8";
		$config['dbcollat'] = 	"utf8_general_ci";
		$config['autoinit'] = 	TRUE;
		$config['stricton'] = 	FALSE;
		$this->db			=	DB($config,TRUE);
		if(!defined('DB_ROOT'))
		{
			define('DB_ROOT',$config['dbprefix']);
		}
		$this->connexion_status	=	$this->db->initialize();
		if($this->connexion_status === TRUE)
		{
			$_SESSION['db_datas']	=	$config;
			return true;
		}
		notice('push',fetch_notice_output($this->connexion_status));

		return false;
	}
}