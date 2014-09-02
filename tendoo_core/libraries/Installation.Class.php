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
		/* CREATE tendoo_themes */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_themes` (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(100) NOT NULL,
			`HUMAN_NAME` varchar(200) NOT NULL,
			`AUTHOR` varchar(100) NOT NULL,
			`DESCRIPTION` text NOT NULL,
			`ACTIVATED` varchar(20) NOT NULL,
			`TENDOO_VERS` varchar(100) NOT NULL,
			`ENCRYPTED_DIR` text NOT NULL,
			`APP_VERS` varchar(100) NOT NULL,
			`HAS_PASSIVE_SCRIPTING` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_modules */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_modules` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `NAMESPACE` varchar(200) NOT NULL,
		  `HUMAN_NAME` varchar(200) NOT NULL,
		  `AUTHOR` varchar(200) DEFAULT NULL,
		  `DESCRIPTION` text,
		  `HAS_WIDGET` int(11) NOT NULL,
		  `HAS_MENU` int(11) NOT NULL,
		  `HAS_API`	int(11) NOT NULL,
          `HAS_ICON` int(11) NOT NULL,
          `HAS_ADMIN_API` int(11) NOT NULL,
		  `HAS_PASSIVE_SCRIPTING` int(11) NOT NULL,
		  `HANDLE` varchar(200) NOT NULL,
		  `SELF_URL_HANDLE` int(11) NOT NULL,
		  `TYPE` varchar(50) NOT NULL,
		  `ACTIVE` int(11) NOT NULL,
		  `TENDOO_VERS` varchar(100) NOT NULL,
		  `APP_VERS` varchar(100) NOT NULL,
		  `ENCRYPTED_DIR` text,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_meta */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_metas` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`KEY` varchar(255) NOT NULL,
			`VALUE` text,
			`AUTHOR` varchar(255) NOT NULL,
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
	public function defaultsApp($app)
	{
		$this->load->library('tendoo'); // Refreshing Tendoo Clss
		$this->load->library('tendoo_admin'); // loading Admin Class
		$this->load->library('options');
		if($app	==	'default_theme')
		{
			// Installe le thème par défaut.
			$appFile				=		array();
			$appFile['temp_dir']	=		'19348a97150f23e4782fbcfb83e962f0';
			var_dump( $this->tendoo_admin->tendoo_core_installer($appFile) );
			$installed_theme		=		$this->tendoo_admin->getThemes();
			// Set first Installed theme as default
			$this->tendoo_admin->setDefault($installed_theme[0]['ID']); // retreiving IDs
		}
		else if($app	==	'news')
		{
			// Install "Blogster"
			$appFile				=		array();
			$appFile['temp_dir']	=		'0844d4336594171ad349b41c24adc407';
			var_dump( $this->tendoo_admin->tendoo_core_installer($appFile) );
			$module					=		$this->tendoo_admin->moduleActivation('news',"using_namespace");
			if($module)
			{
				$module				=		$this->tendoo->getSpeModuleByNamespace('news');
				include_once(MODULES_DIR.$module[0]['ENCRYPTED_DIR'].'/library.php');
				$lib				=		new News(array(
					'module'		=>		$module
				));
				$lib_				=		new News_smart(array(
					'module'		=>		$module
				));
				$lib->createCat('Cat&eacute;gorie sans nom','Tous les articles listés dans la catégor');
				// First Article
				$lib->publish_news(
					$title 			=	'Bienvenue sur Tendoo '.get('core_id'),
					$content 		=	'Voici votre premier article, connectez-vous &agrave; l\'espace administration pour le modifier, supprimer ou poster d\'autres articles. Vous pouvez également effectuer des programmations d\'articles, afin que ces derniers soient publiés automatiquement à des dates précises. <br>Merci d\'avoir choisi Tendoo.',
					$state			=	1,
					$image			=	$this->url->img_url('Hub_back.png'),
					$thumb			=	$this->url->img_url('Hub_back.png'),
					$cat 			= 	array(1),
					$first_admin 	= 	TRUE,
					$key_words		= 	array('tendoo','blog'),
					$scheduledDate	=	FALSE,
					$scheduledTime	=	FALSE
				);
				// Fist Comments
				$lib_->postComment(
					1,
					"Bravo ce blog est désormais fonctionnel. Consultez les dernières actualités sur <a href=\"http://tendoo.org/index.php/blog\">tendoo.org/blog</a>.",
					"John Doe",
					"support@tendoo.org",
					$interface	=	'system',
					$user_id	=	0
				);
				$lib_->postComment(
					1,
					"Nous sommes vos premiers participants, vous avez le contrôle sur les commentaire depuis l'interface de l'application Blogster.",
					"Cathy Verana",
					"support@tendoo.org",
					$interface	=	'system',
					$user_id	=	0
				);
			}
		}
		else if($app	==	'tendoo_index_mod')
		{
			// Install "Tendoo_index_mod"
			$appFile				=		array();
			$appFile['temp_dir']	=		'3aa067f9608858e0898965b2ca683291';
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$module					=		$this->tendoo_admin->moduleActivation( 'tim' ,"using_namespace");
		}
		else if($app	==	'file_manager')
		{
			// Install "Tendoo_index_mod"
			$appFile				=		array();
			$appFile['temp_dir']	=		'843a279725edca537755a7aa9acd79f1';
			var_dump( $this->tendoo_admin->tendoo_core_installer($appFile) );

			$module					=		$this->tendoo_admin->moduleActivation('tendoo_contents',"using_namespace");
		}
		else if($app	==	'widget_admin')
		{
			// Install "Widget_admin"
			$appFile				=		array();
			$appFile['temp_dir']	=		'bd3afaf409a5f9ba355e99f884cc5178';
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$module					=		$this->tendoo_admin->moduleActivation('tendoo_widget_administrator',"using_namespace");
		}
		else if($app	==	'pageEditor')
		{
			$appFile				=		array();
			$appFile['temp_dir']	=		'pageCreater5f9ba355e99f884cc5178';
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$this->tendoo_admin->moduleActivation('pages_editor',"using_namespace");
		}
		else if($app	==	'contact_manager')
		{
			$appFile				=		array();
			$appFile['temp_dir']	=		'tendoo_app_6201401230210406wgIlkG5CkcJT7u3DKMOO';
			$option					=		$this->options->get("from_install_interface");
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$module				=	$this->tendoo_admin->moduleActivation('tendoo_contact_handler',"using_namespace");
			if($module)
			{
				$this->db->insert('tendoo_contact_handler_option',array(
					'SHOW_NAME'			=>		1,
					'SHOW_MAIL'			=>		1
				));
			}
		}
		else if($app	==	'final_config')
		{
			// Creating All Pages controllers here
			$this->tendoo_admin->createControllers(array(
				'title'			=>	array('Accueil','blog','contact'),
				'description'	=>	array('Accueil du site','Section blog','Section de contact'),
				'main'			=>	array('TRUE','FALSE','FALSE'),
				'module'		=>	array('tim','news','tendoo_contact_handler'),
				'parent'		=>	array('none','none','none'),
				'name'			=>	array('accueil','blog','contact'),
				'cname'			=>	array('accueil','blog','contact'),
				'keywords'		=>	array('accueil','blog','contact'),
				'link'			=>	array('','',''),
				'visible'		=>	array('TRUE','TRUE','TRUE'),
				'id'			=>	array(1,2,3),
			));	
		}
		
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
		$file = fopen('tendoo_core/config/db_config.php','w+');
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