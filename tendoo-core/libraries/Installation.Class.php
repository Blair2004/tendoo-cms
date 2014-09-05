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
			`encrypted_dir` text NOT NULL,
			`APP_VERS` varchar(100) NOT NULL,
			`HAS_PASSIVE_SCRIPTING` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_modules : Replace by new module declaration process */
		/* $sql = 
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
		  `encrypted_dir` text,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		}; */
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