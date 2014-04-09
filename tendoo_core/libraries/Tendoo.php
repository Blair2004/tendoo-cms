<?php
class Tendoo
{
	private $siteState;
	private $coreDir;
	private $defaultTitle;
	private $defaultDesc;
	private $defaultKeyWords;
	private $isInstalled;
	private $data;
	protected	$load;
	protected	$instance;
	private 	$db;
	public function __construct()
	{
		$this->core		=	Controller::instance();
		$this->load			=	$this->core->load;
		$this->defaultTitle = 'Page Sans Titre - Tendoo';
		$this->defaultDesc	= 'Page sans description - Tendoo';
		if(is_file('tendoo_core/config/tendoo_config.php'))
		{
			$this->isInstalled =  true;
		}
		else
		{
			$this->isInstalled = false;
		}		
	}
	public function addVisit()
	{
		$ts_this_month	=	$this->global_date('month_start_date');
		$te_this_month	=	$this->global_date('month_end_date');
		$query	=	$this->core->db->where('DATE >=',$ts_this_month)->where('DATE <=',$te_this_month)->where('VISITORS_IP',$_SERVER['REMOTE_ADDR'])->get('tendoo_visit_stats');
		$result	=	$query->result_array();
		if(!$result)
		{
			$datetime	=	$this->datetime();
			$this->core->db->insert('tendoo_visit_stats',array(
				'DATE'					=>	$datetime,
				'VISITORS_IP'			=>	$_SERVER['REMOTE_ADDR'],
				'VISITORS_USERAGENT'	=>	$_SERVER['HTTP_USER_AGENT'],
				'GLOBAL_VISIT'			=>	1
			));
		}
		else
		{
			$datetime	=	$this->datetime();
			$this->core->db->where('DATE >=',$ts_this_month)
				->where('DATE <=',$te_this_month)
				->where('VISITORS_IP',$_SERVER['REMOTE_ADDR'])
				->update('tendoo_visit_stats',array(
				'DATE'					=>	$datetime,
				'VISITORS_IP'			=>	$_SERVER['REMOTE_ADDR'],
				'VISITORS_USERAGENT'	=>	$_SERVER['HTTP_USER_AGENT'],
				'GLOBAL_VISIT'			=>	(int)$result[0]['GLOBAL_VISIT'] + 1
			));
		}
	}
	public function global_date($request = NULL,$type = 'default')
	{
		$currentTime	=	$this->datetime();
		$currentTimeTS	=	strtotime($currentTime);
		$nbrDays		=	date('t',$currentTimeTS);
		$dateArray		=	$this->time($currentTimeTS,TRUE);
		
		$elapsedTS		=	(int)$dateArray['d'] * 86400; // 86400 seconde par jour
		$TS_start_month	=	$currentTimeTS - $elapsedTS; // timestamp for the start of this month
		$ti_start_month	=	date('c',$TS_start_month); // date "c" format for the start of this month
		$TS_end_month	=	((int)$nbrDays * 86400) + $TS_start_month;
		$ti_end_month	=	date('c',$TS_end_month); // Date "c" format fot the end of this month
		$time_start_month=	$this->time($ti_start_month,TRUE);
		
		$time_start_month=	$time_start_month['y'].'-'.$time_start_month['M'].'-'.$time_start_month['d'].' '.$time_start_month['h'].':'.$time_start_month['i'].':'.$time_start_month['s'];
		$time_end_month	=	$this->time($ti_end_month,TRUE);
		$time_end_month	=	$time_end_month['y'].'-'.$time_end_month['M'].'-'.$time_end_month['d'].' '.$time_end_month['h'].':'.$time_end_month['i'].':'.$time_end_month['s'];
		if($request == 'month_start_date')
		{
			if($type == 'default')
			{
				return $time_start_month;
			}
			else if($type == 'timestamp')
			{
				return $TS_start_month;
			}
		}
		if($request == 'month_end_date')
		{
			if($type == 'default')
			{
				return $time_end_month;
			}
			else if($type == 'timestamp')
			{
				return $TS_end_month;
			}
		}
		if($request	==	'current_day')
		{
			return $dateArray['d'];
		}
		if($request == 'day_this_month')
		{
			return $nbrDays;
		}
		if($request == 'month_current_date')
		{
			if($type == 'default')
			{
				return $currentTime;
			}
			else if($type == 'timestamp')
			{
				return $currentTimeTS;
			}
		}
	}
	public function isInstalled()
	{
		return $this->isInstalled;
	}
	public function createTables()
	{
		$this->core		=	Controller::instance();
		$config			=	$_SESSION['db_datas'];
		$DB_ROOT		=	$config['dbprefix'];
		$this->core->db	=	DB($config,TRUE);
		/* CREATE tendoo_controllers */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_controllers` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `PAGE_NAMES` varchar(40) NOT NULL,
		  `PAGE_CNAME` varchar(40) NOT NULL,
		  `PAGE_MODULES` text,
		  `PAGE_TITLE` varchar(40) NOT NULL,
		  `PAGE_DESCRIPTION` text,
		  `PAGE_MAIN` varchar(5) DEFAULT NULL,
		  `PAGE_VISIBLE` varchar(5) NOT NULL,
		  `PAGE_PARENT` varchar(200) NOT NULL,
		  `PAGE_LINK` text,
		  `PAGE_POSITION` int(11) NOT NULL,
		  `PAGE_KEYWORDS` varchar(200) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
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
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_modules */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_modules` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `NAMESPACE` varchar(40) NOT NULL,
		  `HUMAN_NAME` varchar(100) NOT NULL,
		  `AUTHOR` varchar(100) DEFAULT NULL,
		  `DESCRIPTION` text,
		  `HAS_WIDGET` int(11) NOT NULL,
		  `HAS_MENU` int(11) NOT NULL,
		  `HAS_API`	int(11) NOT NULL,
          `HAS_ICON` int(11) NOT NULL,
          `HAS_ADMIN_API` int(11) NOT NULL,
		  `TYPE` varchar(50) NOT NULL,
		  `ACTIVE` int(11) NOT NULL,
		  `TENDOO_VERS` varchar(100) NOT NULL,
		  `APP_VERS` varchar(100) NOT NULL,
		  `ENCRYPTED_DIR` text,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_options */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_options` (
		`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		`SITE_NAME` varchar(40) NOT NULL,
		`SITE_TYPE` varchar(40) NOT NULL,
		`SITE_LOGO` varchar(200) NOT NULL,
		`SITE_LANG` varchar(200) NOT NULL,
		`ALLOW_REGISTRATION` int(11) NOT NULL,
		`SITE_TIMEZONE` varchar(30) NOT NULL,
		`SITE_TIMEFORMAT` varchar(10) NOT NULL,
		`ALLOW_PRIVILEGE_SELECTION` int(11) NOT NULL,
		`PUBLIC_PRIV_ACCESS_ADMIN` int(11) NOT NULL,
		`ACTIVATE_STATS` int(11) NOT NULL,
		`ADMIN_ICONS` text NOT NULL,
		`CONNECT_TO_STORE` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* 
		 int(11) NOT NULL, Removed, only admin can access private stats.
		*/
		
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
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
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
			`STATE` varchar(100) NOT NULL,
			`PHONE` varchar(100) NOT NULL,
			`TOWN` varchar(100) NOT NULL,
			`REG_DATE` datetime NOT NULL,
			`LAST_ACTIVITY` datetime NOT NULL,
			`PRIVILEGE` varchar(100) NOT NULL,
			`ACTIVE` varchar(100) NOT NULL,
			`ADMIN_THEME` int(11) NOT NULL,
			`FIRST_VISIT` int(11) NOT NULL,
			`OPEN_APP_TAB` int(11) NOT NULL,
			`SHOW_WELCOME` varchar(10) NOT NULL,
			`SHOW_ADMIN_INDEX_STATS` int(110) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
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
		if(!$this->core->db->query($sql))
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
		if(!$this->core->db->query($sql))
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
		if(!$this->core->db->query($sql))
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
		if(!$this->core->db->query($sql))
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
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		return true;
	}
	public function defaultsApp($app)
	{
		$this->core->load->library('Tendoo_admin');
		$this->tendoo_admin		=&		$this->core->tendoo_admin;
		if($app	==	'revera')
		{
			// Installe le thème par défaut.
			$appFile				=		array();
			$appFile['temp_dir']	=		'5cb1d33aedd57193149db9a852525a1b';
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$installed_theme		=		$this->tendoo_admin->getThemes();
			// Set first Installed theme as default
			$this->tendoo_admin->setDefault($installed_theme[0]['ID']); // retreiving IDs
		}
		else if($app	==	'blogster')
		{
			// Install "Blogster"
			$appFile				=		array();
			$appFile['temp_dir']	=		'0844d4336594171ad349b41c24adc407';
			$option					=		$this->getOptions();
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$module					=		$this->tendoo_admin->moduleActivation('news',FALSE);
			if($module)
			{
				$this->tendoo_admin->controller('Blog','blog','news',$option[0]['SITE_NAME'].' - Blog','Aucune description enregistr&eacute;e','FALSE');
				$module					=		$this->getSpeModuleByNamespace('news');
				include_once(MODULES_DIR.$module[0]['ENCRYPTED_DIR'].'/library.php');
				$lib					=	new News(null);
				$lib->createCat('Cat&eacute;gorie sans nom','Cette cat&eacute;gorie sert d\'illustration.');
				$lib->publish_news(
					'Bienvenue sur Tendoo '.$this->getVersId(),
					'Voici votre premi&egrave;re publication dans votre blog Tendoo, connectez-vous &agrave; l\'espace administration pour le modifier, supprimer ou poster d\'autres articles',
					1,
					$this->core->url->img_url('Hub_back.png'),
					$this->core->url->img_url('Hub_back.png'),
					1,
					TRUE
				);
			}
		}
		else if($app	==	'Tendoo_index_mod')
		{
			// Install "Tendoo_index_mod"
			$appFile				=		array();
			$appFile['temp_dir']	=		'41dea5f466452b1555f1fa7d1930d39a';
			$option					=		$this->getOptions();
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$module					=		$this->tendoo_admin->moduleActivation('Tendoo_index_manager',FALSE);
			if($module)
			{
				$this->tendoo_admin->controller('Accueil','home','Tendoo_index_manager',$option[0]['SITE_NAME'].' - Accueil','Aucune description enregistr&eacute;e','TRUE',$obj = 'create',$id = '',$visible	=	'TRUE',$childOf= 'none',$page_link	=	'');
			}
		}
		else if($app	==	'file_manager')
		{
			// Install "Tendoo_index_mod"
			$appFile				=		array();
			$appFile['temp_dir']	=		'843a279725edca537755a7aa9acd79f1';
			$option					=		$this->getOptions();
			$this->tendoo_admin->tendoo_core_installer($appFile);

			$module					=		$this->tendoo_admin->moduleActivation('Tendoo_contents',FALSE);
		}
		else if($app	==	'widget_admin')
		{
			// Install "Widget_admin"
			$appFile				=		array();
			$appFile['temp_dir']	=		'bd3afaf409a5f9ba355e99f884cc5178';
			$option					=		$this->getOptions();
			$this->tendoo_admin->tendoo_core_installer($appFile);

			$module					=		$this->tendoo_admin->moduleActivation('Tendoo_widget_administrator',FALSE);
			if($module)
			{
				include_once(MODULES_DIR.$module[0]['ENCRYPTED_DIR'].'/library.php');
				$lib					=	new widhandler_lib(array(
					'module_dir'		=>	MODULES_DIR.$module[0]['ENCRYPTED_DIR']
				));
				$array['LEFT'][]	=	array(
					'modnamespace'	=>	'system',
					'namespace'		=>	'texte',
					'human_name'	=>	'Widget Texte',
					'title'			=>	'Bienvenu sur Tendoo 0.9.7',
					'params'		=>	'Ceci est un widget ajouté depuis l\'espace administration. Vous pouvez accédez au module "Gestionnaire de widget" pour modifier ce Widget.'
				);
				$array['LEFT'][]	=	array(
					'modnamespace'	=>	'news',
					'namespace'		=>	'syslink',
					'human_name'	=>	'Liens Système',
					'title'			=>	'Meta.'
				);
				$array['RIGHT'][]	=	array(
					'modnamespace'	=>	'system',
					'namespace'		=>	'texte',
					'human_name'	=>	'Widget Texte',
					'title'			=>	'Bienvenu sur Tendoo 0.9.7',
					'params'		=>	'Ceci est un widget ajouté depuis l\'espace administration. Vous pouvez accédez au module "Gestionnaire de widget" pour modifier ce Widget.'
				);
				$array['RIGHT'][]	=	array(
					'modnamespace'	=>	'news',
					'namespace'		=>	'syslink',
					'human_name'	=>	'Liens Système',
					'title'			=>	'Meta.'
				);
				$array['BOTTOM'][]	=	array(
					'modnamespace'	=>	'system',
					'namespace'		=>	'texte',
					'human_name'	=>	'Widget Texte',
					'title'			=>	'Bienvenu sur Tendoo 0.9.7',
					'params'		=>	'Ceci est un widget ajouté depuis l\'espace administration. Vous pouvez accédez au module "Gestionnaire de widget" pour modifier ce Widget.'
				);
				$array['BOTTOM'][]	=	array(
					'modnamespace'	=>	'news',
					'namespace'		=>	'syslink',
					'human_name'	=>	'Liens Système',
					'title'			=>	'Meta.'
				);
				$lib->save_widgets($array);
			}
		}
		else if($app	==	'PageEditor')
		{
			$appFile				=		array();
			$appFile['temp_dir']	=		'pageCreater5f9ba355e99f884cc5178';
			$option					=		$this->getOptions();
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$this->tendoo_admin->moduleActivation('Pages_editor',FALSE);
		}
		else if($app	==	'Contact_manager')
		{
			$appFile				=		array();
			$appFile['temp_dir']	=		'tendoo_app_6201401230210406wgIlkG5CkcJT7u3DKMOO';
			$option					=		$this->getOptions();
			$this->tendoo_admin->tendoo_core_installer($appFile);
			$module				=	$this->tendoo_admin->moduleActivation('Tendoo_contact_handler',FALSE);
			if($module)
			{
				$this->tendoo_admin->controller('Accueil','home','Tendoo_contact_handler',$option[0]['SITE_NAME'].' - Accueil','Aucune description enregistr&eacute;e','TRUE',$obj = 'create',$id = '',$visible	=	'TRUE',$childOf= 'none',$page_link	=	'');
				$this->core->db->insert('Tendoo_contact_handler_option',array(
					'SHOW_NAME'			=>		1,
					'SHOW_MAIL'			=>		1
				));
			}

		}
	}
	public function connectToDb()
	{
		if(is_file(SYSTEM_DIR.'config/tendoo_config.php'))
		{
			include_once(SYSTEM_DIR.'config/tendoo_config.php');
			$this->core->db	=	DB($db,TRUE);
			return $this->core->db->conn_id;
		}
		else
		{
			return FALSE;
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
		$file = fopen('tendoo_core/config/tendoo_config.php','w+');
		fwrite($file,$string_config);
		fclose($file);		
	}
	public function attemptConnexion($host,$user,$pass,$db_name,$type,$extension)
	{
		$this->core		=	Controller::instance();
		$config['hostname'] = $host;
		$config['username'] = $user;
		$config['password'] = $pass;
		$config['database'] = $db_name;
		$config['dbdriver'] = $type;
		$config['dbprefix'] = $extension;
		$config['pconnect'] = TRUE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";
		$config['autoinit'] = TRUE;
		$config['stricton'] = FALSE;
		$this->core->db		=	DB($config,TRUE);
		if(!defined('DB_ROOT'))
		{
			define('DB_ROOT',$config['dbprefix']);
		}
		$this->connexion_status	=	$this->core->db->initialize();
		if($this->connexion_status === TRUE)
		{
			$_SESSION['db_datas']	=	$config;
			return true;
		}
		$this->core->notice->push_notice(notice($this->connexion_status));
		return false;
	}
	public function setOptions($name)
	{
		$q = $this->core->db->get('tendoo_options');
		$r = $q->result();
		$value['CONNECT_TO_STORE']		=	'1'; // by default tendoo connect to store
		if(count($r) == 1)
		{	
			$value['SITE_NAME'] 			= $name;
			$this->core->db->where('ID',1);
			$result = $this->core->db->update('tendoo_options',$value);
		}
		else if(count($r) == 0)
		{
			$value['SITE_NAME'] 			= 	$name;
			$result = $this->core->db->insert('tendoo_options',$value);
		}
		if($result == false)
		{
			return false;
		}
		return true;
	}
	public function firstController($name,$cname,$mod,$title,$description,$main,$visible)
	{
		$this->core	->db->select('*')
					->from('tendoo_controllers');
		$query		=	$this->core->db->get();
		if($query->num_rows == 0)
		{
			$e['PAGE_CNAME']		=	strtolower($cname);
			$e['PAGE_NAMES']		=	strtolower($name);
			$e['PAGE_TITLE']		=	$title;
			$e['PAGE_DESCRIPTION']	=	$description;
			$e['PAGE_MAIN']			=	$main;
			$e['PAGE_MODULES']		=	$mod;
			$e['PAGE_VISIBLE']		=	$visible;
			$e['PAGE_PARENT']		=	'none'; // Par défaut le premier lien est à la racine puisqu'il s'agit du premier contrôleur.
			return $this->core			->db->insert('tendoo_controllers',$e);			
		}
		return false;
	}
	public function getSiteTheme()
	{
		$query	=	$this->core->db->where('ACTIVATED','TRUE')->get('tendoo_themes');
		$data	=	$query->result_array();
		if(array_key_exists(0,$data))
		{
			return $data[0];
		}
		else
		{
			return false;
		}
	}
	public function getOptions()
	{
		$this->core->db->select('*')
					->from('tendoo_options')
					->limit(1,0);
		$r			=	$this->core->db->get();
		return $r->result_array();
	}
	public function getPage($page = 'index',$getAll = FALSE)
	{
		if($page == 'index')
		{
			$this->core->db->select('*')
						->from('tendoo_controllers')
						->where('PAGE_MAIN','TRUE');
			$data 		=	$this->core->db->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;					
			}
			return 'noMainPage';
		}
		else if(preg_match('#@#',$page))
		{
			$Teurmola	=	explode('@',$page);
			return array(
				array(
					'PAGE_TITLE'				=>		$this->getTitle(),
					'PAGE_CNAME'				=>		$page,
					'PAGE_DESCRIPTION'		=>		$this->getDescription()
				)
			);
		}
		else if($getAll == FALSE && $page != null)
		{
			$this->core->db->select('*')
						->from('tendoo_controllers')
						->where('PAGE_CNAME',$page);
			$data		= 	$this->core->db->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;
			}
			else
			{
				return 'page404';
			}
		}
		else
		{
			$this->core->db->select('*')
						->from('tendoo_controllers');
			$data		= 	$this->core->db->get();
			$value		=	$data->result_array();
			return $value;
		}
	}
	public function getControllers()
	{
		$this->core->db->select('*')
					->from('tendoo_controllers')->where('PAGE_VISIBLE','TRUE')->order_by('PAGE_POSITION','asc');
		$r			=	$this->core->db->get();
		return $r->result_array();
	}
	private $levelLimit					= 20; // limitation en terme de sous menu
	public function get_sublevel($cname,$level,$showHidden=TRUE,$getModuleData=TRUE) // Deprecated ?
	{	
		echo tendoo_warning('Tendoo::get_sublevel(...) est une méthode déprécié, Utiliser Tendoo::get_pages(...) à la plage');
		if($level <= $this->levelLimit)
		{
			if($showHidden == FALSE)// ??
			{
				$this->core->db->where('PAGE_VISIBLE','TRUE');
			}
			$this->core	->db->select('*')
						->where('PAGE_PARENT',$cname) // On recupère le menu de base
						->order_by('PAGE_POSITION','asc')
						->from('tendoo_controllers');
			$query 		=	$this->core->db->get();
			if($query->num_rows > 0)
			{
				$array		=	array();
				foreach($query->result() as $obj)
				{
					$array[] = array(
						'ID'				=>		$obj->ID,
						'PAGE_CNAME'		=>		$obj->PAGE_CNAME,
						'PAGE_PARENT'		=>		$obj->PAGE_PARENT,
						'PAGE_NAMES'		=>		$obj->PAGE_NAMES,
						'PAGE_MODULES'		=>		$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : $this->getSpeModuleByNamespace($obj->PAGE_MODULES),
						'PAGE_TITLE'		=>		$obj->PAGE_TITLE,
						'PAGE_DESCRIPTION'	=>		$obj->PAGE_DESCRIPTION,
						'PAGE_MAIN'			=>		$obj->PAGE_MAIN,
						'PAGE_VISIBLE'		=>		$obj->PAGE_VISIBLE,
						'PAGE_CHILDS'		=> 		$this->get_sublevel($obj->ID,$level+1),
						'PAGE_LINK'			=>		$obj->PAGE_LINK,
						'PAGE_POSITION'		=>		$obj->PAGE_POSITION
					);
				}
				return $array;
			}
		}
		return false;
	}
	public function get_menu_limitation() // Deprecated;
	{
		return $this->levelLimit;
	}
	/*
		@$page			=	Code CNAME du contrôleur.
		@$showHidden	=	Recupérer les contrôleurs invisibles sur le menu [true/false].
		@getModuleData	=	Recupérer les modules attachés aux contrôleurs [true/false].
		@getChild		=	Traite $page comme étant parent et opère récupération des enfants au lieu du parent [true/false], défaut FALSE.
	*/
	public function get_pages($page =NULL,$showHidden=TRUE,$getModuleData = TRUE,$getChild = TRUE) 
	{
		// '' pour prendre en charge les anciens modules qui recupère tous les contrôleurs en spécifiant une chaine vide.
		if(in_array($page,array('',NULL))) 
		{
			if($showHidden == FALSE)
			{
				$this->core->db->where('PAGE_VISIBLE','TRUE');
			}
			$this->core	->db->select('*')
						->where('PAGE_PARENT','none') // On recupère le menu de base
						->order_by('PAGE_POSITION','asc')
						->from('tendoo_controllers');
			$query 	=	$this->core->db->get();
			$array		=	array();
			foreach($query->result() as $obj)
			{
				if($getModuleData == TRUE)
				{
					$array[] = array(
						'ID'			=>$obj->ID,
						'PAGE_CNAME'	=>$obj->PAGE_CNAME,
						'PAGE_PARENT'	=>$obj->PAGE_PARENT,
						'PAGE_NAMES'	=>$obj->PAGE_NAMES,
						'PAGE_MODULES'	=>$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : $this->getSpeModuleByNamespace($obj->PAGE_MODULES),
						'PAGE_TITLE'	=>$obj->PAGE_TITLE,
						'PAGE_DESCRIPTION'		=>$obj->PAGE_DESCRIPTION,
						'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
						'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
						'PAGE_CHILDS'	=> 	$this->get_pages($obj->ID,$showHidden,$getModuleData,$getChild),
						'PAGE_LINK'		=>	$obj->PAGE_LINK, // new added 0.9.4
						'PAGE_POSITION'	=>	$obj->PAGE_POSITION,
						'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
					);
				}
				else
				{
					$array[] = array(
						'ID'			=>$obj->ID,
						'PAGE_CNAME'	=>$obj->PAGE_CNAME,
						'PAGE_PARENT'	=>$obj->PAGE_PARENT,
						'PAGE_NAMES'	=>$obj->PAGE_NAMES,
						'PAGE_MODULES'	=>$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : '#MODULE NOT LOADED',
						'PAGE_TITLE'	=>$obj->PAGE_TITLE,
						'PAGE_DESCRIPTION'		=>$obj->PAGE_DESCRIPTION,
						'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
						'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
						'PAGE_CHILDS'	=> 	$this->get_pages($obj->ID,$showHidden,$getModuleData,$getChild),
						'PAGE_LINK'		=>	$obj->PAGE_LINK, // new added 0.9.4
						'PAGE_POSITION'	=>	$obj->PAGE_POSITION,
						'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
					);
				}
			}
			$this->getpages	=	$array;
			return $array;	
		}
		else
		{
			// If there is any content founded, $array will be overwrited.
			$array		=	FALSE;
			if($showHidden == FALSE)
			{
				$this->core->db->where('PAGE_VISIBLE','TRUE');
			}
			if($getChild == TRUE)
			{
				$this->core->db->where('PAGE_PARENT',$page) // On recupère le menu de base
							// ->order_by('PAGE_POSITION','asc')
							->from('tendoo_controllers');
				$query 	=	$this->core->db->get();
				// var_dump($query);
			}
			else
			{
				$this->core	->db->select('*')
							->from('tendoo_controllers')
							->where('PAGE_CNAME',$page);
				$query 	=	$this->core->db->get();
			}
			if(count(get_object_vars($query)) > 0)
			{
				// var_dump($query->result());
				foreach($query->result() as $obj)
				{
					if($getModuleData == TRUE)
					{
						$array[] = array(
							'ID'		=>$obj->ID,
							'PAGE_CNAME'	=>	$obj->PAGE_CNAME,
							'PAGE_PARENT'	=>	$obj->PAGE_PARENT,
							'PAGE_NAMES'	=>	$obj->PAGE_NAMES,
							'PAGE_MODULES'	=>	$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : $this->getSpeModuleByNamespace($obj->PAGE_MODULES),
							'PAGE_TITLE'	=>	$obj->PAGE_TITLE,
							'PAGE_DESCRIPTION'	=>$obj->PAGE_DESCRIPTION,
							'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
							'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
							'PAGE_CHILDS'	=>	$this->get_pages($obj->ID,$showHidden,$getModuleData,$getChild),
							'PAGE_LINK'		=>	$obj->PAGE_LINK, // New added 0.9.4
							'PAGE_POSITION'	=>	$obj->PAGE_POSITION, // added 0.9.5,
							'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
						);
					}
					else
					{
						$array[] = array(
							'ID'		=>$obj->ID,
							'PAGE_CNAME'	=>	$obj->PAGE_CNAME,
							'PAGE_PARENT'	=>	$obj->PAGE_PARENT,
							'PAGE_NAMES'	=>	$obj->PAGE_NAMES,
							'PAGE_MODULES'	=>	$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : '#MODULE NOT LOADED',
							'PAGE_TITLE'	=>	$obj->PAGE_TITLE,
							'PAGE_DESCRIPTION'	=>$obj->PAGE_DESCRIPTION,
							'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
							'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
							'PAGE_CHILDS'	=>	$this->get_pages($obj->ID,$showHidden,$getModuleData,$getChild),
							'PAGE_LINK'		=>	$obj->PAGE_LINK, // New added 0.9.4
							'PAGE_POSITION'	=>	$obj->PAGE_POSITION, // added 0.9.5,
							'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
						);

					}
				}
				$this->getpages	=	$array;
			}	
			return $array;
		}
	}
	public function getControllersAttachedToModule($module) // Recupere la page qui embarque le module spécifié.
	{
		$this->core->db->select('*')
					->from('tendoo_controllers')->where('PAGE_MODULES',$module); // Nous avons choisi de ne pas exiger la selection des controleur visible "->where('PAGE_VISIBLE','TRUE')"
		$r			=	$this->core->db->get();
		return $r->result_array();
	}
	/// MODULES LOADER
	public function getGlobalModules() // Récupération de tous les modules de type GLOBAL
	{
		$query	=	$this->core->db	->where('TYPE','GLOBAL')
									->where('ACTIVE','1')
									->get('tendoo_modules');
		$data	=	$query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function getSpeModule($id,$option =	TRUE) // Obsolete Transit
	{
		return $this->getSpeMod($id,$option);
	}
	public function getSpeMod($value,$option = TRUE)
	{
		$this->core->db		->select('*')
							->from('tendoo_modules');
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
	public function getSpeModuleByNamespace($namespace)
	{
		$this->core->db		->select('*')
							->from('tendoo_modules')
							->where('NAMESPACE',$namespace)
							->where('ACTIVE','1');
		$query				= $this->core->db->get();
		$data				= $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function setTitle($e)
	{
		$this->defaultTitle = $e;
	}
	public function getTitle()
	{
		return $this->defaultTitle;
	}
	public function setDescription($e)
	{
		$this->defaultDesc	=	$e;
	}
	public function getDescription()
	{
		return $this->defaultDesc;
	}
	public function setKeywords($e)
	{
		$this->keyWords		=	$e;
	}
	public function getKeywords()
	{
		return $this->keyWords;
	}
	/* INNER FUNCTION */
	public function loadModules() /// OBSOLETE
	{
		$modules= array();
		if($dir	=	opendir('application/views/modules'))
		{
			while(($file = readdir($dir)) !== FALSE)
			{
				if(!in_array($file,array('.','..')))
				{
					$modules[]	=	new Modules($file);
				}
			}
			return $modules;
		}
		return false;
	}
	public function modules_url($e)
	{
		return site_url();
	}
	public function retreiveControlerUrl()
	{
		$details	=	$this->core->url->http_request(TRUE);
		if(array_key_exists(0,$details))
		{
			$controller	=	$this->getPage();
			if(is_array($controller))
			{
				return $this->core->url->site_url(array($controller[0]['PAGE_CNAME']));
			}
			return $controller;
		}
	}
	public function time($timestamp	=	'',$toArray	=	false)
	{
		$timestamp	=	strtotime($timestamp);
		$this->load->helper('date');
		$options	=	$this->getOptions();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		$timeformat	=	$options[0]['SITE_TIMEFORMAT'];
		if($timezone== '')
		{
			$timezone 		= 'UTC';
		}
		if($timeformat	==	'')
		{
			$timeformat		=	'type_1';
		}
		$daylight_saving 	= TRUE;
		if($timestamp	==	'')
		{
			$timestamp				=	$this->timestamp();
		}
		$month					=	array(
			1	=>	'Janvier',
			2	=>	'F&eacute;vrier',
			3	=>	'Mars',
			4	=>	'Avril',
			5	=>	'Mai',
			6	=>	'Juin',
			7	=>	'Juillet',
			8	=>	'Ao&ucirc;t',
			9	=>	'Septembre',
			10	=>	'Octobre',
			11	=>	'Novembre',
			12	=>	'Decembre'
		);
		$timeToArray			=	array(
			'd'=>mdate('%d',$timestamp),
			'y'=>mdate('%Y',$timestamp),
			'M'=>mdate('%n',$timestamp),
			'h'=>mdate('%H',$timestamp),
			'i'=>mdate('%i',$timestamp),
			's'=>mdate('%s',$timestamp),
			't'=>mdate('%t',$timestamp),
			'month'	=>	$month[mdate('%n',$timestamp)]
		);
		
		if($toArray	==	true)
		{
			return $timeToArray;
		}
		if($timeformat 	==	'type_1')
		{
			return mdate('Le %d '.$month[$timeToArray['M']].' %Y - %H:%i:%s',$timestamp);
		}
		elseif($timeformat 	==	'type_2')
		{
			return mdate('%d/%m/%Y - %H:%i:%s',$timestamp);
		}
		elseif($timeformat 	==	'type_3')
		{
			return mdate('%Y/%m/%d - %H:%i:%s',$timestamp);
		}
	}
	public function arrayToTimestamp($date)
	{
		return strtotime($date['y'].'-'.$date['M'].'-'.$date['d'].' '.$date['h'].':'.$date['i'].':'.$date['s']);
	}
	public function timestamp()
	{		
		$this->load->helper('date');
		$options	=	$this->getOptions();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		if($timezone== '')
		{
			$timezone 		= 'Etc/UTC';
		}
		$tz_object	=	new DatetimeZone($timezone);
		$date		=	new DateTime(null,new DatetimeZone($timezone));
		$timestamp	=	strtotime($date->format('Y-m-d H:i:s'));
		return $timestamp;
	}
	public function getFuseau()
	{
		$final		=	array();
		$final[]	=	array(
			'Index'	=>	'UTC-11',
			'Code'	=>	'Pacific/Samoa',
			'States'=>	'Pacifique (Samoa, Niue)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-10',
			'Code'	=>	'Pacific/Tahiti',
			'States'=>	'Pacifique (Tahiti, Honolulu, Fakaofo)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-09',
			'Code'	=>	'America/Anchorage',
			'States'=>	'Am&eacute;rique (Anchorage)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-08',
			'Code'	=>	'Pacific/Pitcairn',
			'States'=>	'Pacifique (Pitcairn, Vancouver) Amerique(Tijuana, Los angeles)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-07',
			'Code'	=>	'America/Phoenix',
			'States'=>	'Amerique (Phoenix, Mazatlan, Hermosillo, Denver, Edmonton)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-06',
			'Code'	=>	'America/Winnipeg',
			'States'=>	'Amerique (Winnipeg, Tegucigalpa, Regina, Rankin_Inlet, Monterrey)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-05',
			'Code'	=>	'America/Toronto',
			'States'=>	'Amerique (Toronto, Port-au-Prince, Panama, New York, Lima, Nassau)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-04:30',
			'Code'	=>	'America/Caracas',
			'States'=>	'Amerique (Caracas)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-04',
			'Code'	=>	'America/Virgin',
			'States'=>	'Am&eacute;rique (Virginie, Tortola, St Vincent, Porto Rico)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-03:30',
			'Code'	=>	'America/St_Johns',
			'States'=>	'Am&eacute;rique (St Johns)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-03',
			'Code'	=>	'Chile/Continental',
			'States'=>	'Chilie, Amérique(Paramaribo, Miquelon, Maceio, Godthab), Argentine (Buenos Aires)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-02',
			'Code'	=>	'America/Sao_Paulo',
			'States'=>	'Br&eacute;sil (Sao Paulo), Atlantic (Cap-vert), Montevideo'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-01',
			'Code'	=>	'Atlantic/Azores',
			'States'=>	'Atlantique (Azores)'
		);$final[]	=	array(
			'Index'	=>	'UTC-GMT:0',
			'Code'	=>	'Europe/London',
			'States'=>	'Europe(Londres, Lisbon, Jersey, St Helena) Afrique (Abidjan, Accra, Bamako, Bissau)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+1',
			'Code'	=>	'Europe/Zurich',
			'States'=>	'Allemange(Zurich), Italie(Vatican, Rome), France(Paris), Afrique(Guin&eacute;e Equa., Nigeria, Brazzaville, Niamey'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+2',
			'Code'	=>	'Europe/Vilnius',
			'States'=>	'Europe(Vilnius, Tallinn, Riga, Sofia, Kiev), Asie (Jerusalem, Istanbul, Amman), Afrique(Caire, Gaborone, Lusaka, Maputo, Mbabane, Tripoli)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+3',
			'Code'	=>	'Asia/Qatar',
			'States'=>	'Asie(Qatar, Kuwait, Baghdad), Afrique(Nairobi, Khartoum, Kampala, Asmera)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+4',
			'Code'	=>	'Indian/Reunion',
			'States'=>	'Asie (Dubaï, Yerevan, Baku)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+5',
			'Code'	=>	'Asia/Yekaterinburg',
			'States'=>	'Asie(Yekaterinburg, Tashkent, Oral, Dushanbe)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+5:30',
			'Code'	=>	'Asia/Calcutta',
			'States'=>	'Asie(Calcutta)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+5:45',
			'Code'	=>	'Asia/Katmandu',
			'States'=>	'Asie(Katmandu)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+6',
			'Code'	=>	'Asia/Thimphu',
			'States'=>	'Asie(Thimphu, Omsk, Novosibirsk, Bishkek, Almaty)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+6:30',
			'Code'	=>	'Asia/Rangoon',
			'States'=>	'Asie(Rangoon)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+7',
			'Code'	=>	'Asia/Vientiane',
			'States'=>	'Asie( Vientiane, Jakarta, Hovd, Dhaka, Bangkok)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+8',
			'Code'	=>	'Australia/West',
			'States'=>	'Australie(Ouest), Asie(Taipei, Singapore, Manila, Macao, Hong Kong)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+9',
			'Code'	=>	'Pacific/Palau',
			'States'=>	'Pacifique(Palau), Asie(Tokyo, Seoul, Jayapura)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+9:30',
			'Code'	=>	'Australia/North',
			'States'=>	'Australie(Nord)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+10',
			'Code'	=>	'Pacific/Yap',
			'States'=>	'Pacifique(Yap, Truk, Saipan, Port Moresby), Australie(Queensland)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+11',
			'Code'	=>	'Pacific/Ponape',
			'States'=>	'Pacifique(Ponape, Noumea, Kosrae), Australie(Victoria, Tasmanie, Canberra)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+11:30',
			'Code'	=>	'Pacific/Norfolk',
			'States'=>	'Pacific(Norfolk)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+12',
			'Code'	=>	'Pacific/Wallis',
			'States'=>	'Pacifique(Wallis, Tarawa, Nauru, Funafuti)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+13',
			'Code'	=>	'Pacific/Tongatapu',
			'States'=>	'Pacifique(Tongatapu, Auckland, Chatham)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+13:45',
			'Code'	=>	'Pacific/Chatham',
			'States'=>	'Pacifique(Chatham)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+14',
			'Code'	=>	'Pacific/Kiritimati',
			'States'=>	'Pacifique(Kiritimati)'
		);
		return $final;
	}
	public function timespan($timestamp)
	{
		return timespan($timestamp,$this->timestamp());
	}
	public function datetime()
	{
		$this->load->helper('date');
		$timestamp			=	$this->timestamp();
		$datetime			=	mdate('%Y-%m-%d %H:%i:%s',$timestamp);
		return $datetime;
	}
	public function urilizeText($text)
	{
		if(!function_exists('stripThing'))
		{
			function stripThing($delimiter,$offset)
			{
				$newtext	=	explode($delimiter,$offset);
				$e = '';
				for($i = 0;$i < count($newtext) ; $i++)
				{
					if($i+1 == count($newtext))
					{
						$e .=$newtext[$i];
					}
					else
					{
						$e .=$newtext[$i].'-';
					}
				}
				return $newtext	=	strtolower($e);
			}
		}
		$this->load->helper('text');
		$newtext	=	convert_accented_characters($text);
		$newtext	=	stripThing('\'',$newtext);
		$newtext	=	stripThing(' ',$newtext);
		$newtext	=	stripThing('.',$newtext);
		return $newtext;
	}
	// HTML FUNCTION
	private $loaded_editor;
	public function loadEditor($id=1)
	{
		$this->loaded_editor	=	$id;
		if($id == 1)
		{
			$this->core->file->js_push('ckeditor/ckeditor');
		}
	}
	public function getEditor($values)
	{
		$default	=	array(
			'id'			=>null,
			'width'			=>900,
			'height'		=>300,
			'cssclass'		=>'tinyeditor',
			'controlclass'	=>'tinyeditor-control',
			'rowclass'		=>'tinyeditor-header',
			'dividerclass'	=>'tinyeditor-divider',
			'controls'		=>array('bold', 'italic', 'underline', 'strikethrough', '|', 'subscript', 'superscript', '|',
				'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
				'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', 'n',
				'font', 'size', 'style', '|', 'image', 'hr', 'link', 'unlink', '|', 'print'),
			'footer'		=>'true',
			'fonts'			=>array('Verdana','Arial','Georgia','Trebuchet MS'),
			'xhtml'			=>'true',
			'cssfile'		=>'custom.css',
			'bodyid'		=>'editor',
			'footerclass'	=>'tinyeditor-footer',
			'toggle'		=>array('text'=>'source','activetext'=>'wysiwyg','cssclass'=>'toggle'),
			'resize'		=>array('cssclass'=>'resize'),
			'defaultValue'	=>''		
		);
		$default			=	array_merge($default,$values);
		if(array_key_exists('defaultValue',$default))
		{
			$defValue	=	$default['defaultValue'];
		}
		else
		{
			$defValue	=	'';
		}
		switch($this->loaded_editor)
		{
			case 1	:
				if(!array_key_exists('id',$values)): $values['id']		=	'';endif;
				if(!array_key_exists('name',$values)): $values['name']	=	'';endif;
			return "<textarea class=\"ckeditor\" name=\"".$values['name']."\" id=\"".$values['id']."\">".$defValue."</textarea>";
			break;
		}
	}
	// TENDOO_VERSION
	public function getVersion()
	{
		return 'Tendoo - CMS('.$this->getVersId().')';
	}
	public function getVersId()
	{
		return TENDOO_VERSION;
	}
	public function presentation()
	{
		include(SYSTEM_DIR.'presentation.php');
	}
	public function interpreter($Class,$Method,$Parameters,$Init = NULL)
	{
		if($Init == NULL)
		{
            if(class_exists($Class))
            {
			     eval('$objet	= new '.$Class.'();'); // Création de l'objet
            }
            else
            {
                $this->error('themeControlerFailed');
                die();
            }
		}
		else
		{
            if(class_exists($Class))
            {
			     eval('$objet	= new '.$Class.'($Init);'); // Création de l'objet
            }
            else
            {
                $this->error('themeControlerFailed');
                die();
            }
		}
		if(method_exists($objet,$Method))
		{
			$param_text		=	'';
			$i = 0;
			foreach($Parameters as $p)
			{
				if($p != '') // Les parametres vide ne sont pas accepté
				{
				//	var_dump($p);
					if($i+1 < count($Parameters)) // Tant que l'on n'a pas atteind la fin du tableau.
					{
						if(strlen($Parameters[$i+1]) > 0) // Si le nombre de caractère est supérieur a 0
						{
							$param_text .= '"'.$p.'",'; // ajouté une virgule à la fin de la chaine de caractère personnalisée.
						}
					}
					else
					{
						$param_text .= '"'.$p.'"'; // omettre la virgule.
					}
				}
				$i++;
			}		
			// var_dump($param_text);
			// die();
			eval('$BODY 	=	$objet->'.$Method.'('.$param_text.');'); // exécution du controller.
			return $BODY;
		}
		else
		{
			return '404';
		}
	}
	public function error($array)
	{
		$this->setTitle('Erreur');
		$this->core->load->library('file');
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('tendoo_global');
		$error	=	notice($array);
		
		include_once(VIEWS_DIR.'warning.php');
	}
	public function show_error($error,$heading)
	{
		$this->setTitle('Erreur - '.$heading);
		$this->core->load->library('file');
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('tendoo_global');
		include_once(VIEWS_DIR.'warning.php');
	}
	public function paginate($elpp,$ttel,$pagestyle,$classOn,$classOff,$current_page,$baselink,$ajaxis_link=null)
	{
		/*// Gloabl ressources Control*/
		if(!is_finite($elpp))				: echo '<strong>$elpp</strong> is not finite'; return;
		elseif(!is_finite($pagestyle))		: echo '<strong>$pagestyle</strong> is not finite'; return;
		elseif(!is_finite($current_page))	: echo '<strong>$current_page</strong> is not finite'; return;
		endif;
		
		$more	=	array();
		if($pagestyle == 1)
		{
			$ttpage = ceil($ttel / $elpp);
			if(($current_page > $ttpage || $current_page < 1) && $ttel > 0): return array('',null,null,false,$more);
			endif;
			$firstoshow = ($current_page - 1) * $elpp;
			/*// FTS*/
			if($current_page < 5):$fts = 1;
			elseif($current_page >= 5):$fts = $current_page - 4;
			endif;
			/*// LTS*/
			if(($current_page + 4) <= $ttpage):$lts = $current_page + 4;
			/*elseif($ttpage > 5):$lts = $ttpage - $current_page;*/
			else:$lts = $ttpage;
			endif;
			
			$content = null;
			for($i = $fts;$i<=$lts;$i++)
			{
				$more[]	=	array(
					'link'	=>	$baselink.$i,
					'text'	=>	$i,
					'state'	=>	((int)$i === (int)$current_page) ? $classOn : $classOff // Fixing int type 03.11.2013
				);
				static $content = 'Page :';
				if($i == $fts && $i != 1): $content = $content.'<span style="margin:0 2px">...</span>';endif;
				if($current_page == $i)
				{
				$content = $content.'<span style="margin:0 2px">'.$i.'</span>';
				}
				else
				{
					if($ajaxis_link != null)
					{
						$content = $content.'<a ajaxis_link="'.$ajaxis_link.$i.'" href="'.$baselink.$i.'" class="'.$classOn.'" style="margin:0 2px" title="Aller &agrave; la page '.$i.'">'.$i.'</a>';
					}
					else
					{
						$content = $content.'<a href="'.$baselink.$i.'" class="'.$classOn.'" style="margin:0 2px" title="Aller &agrave; la page '.$i.'">'.$i.'</a>';
					}
				}
				if($i == $lts && $i != $ttpage):$content = $content.'<span style="margin:0 2px">...</span>';endif;
			}		
			return array($content,$firstoshow,$elpp,true,$more);
		}
		else if($pagestyle == 2)
		{
			$ttpage = ceil($ttel / $elpp);
			if($current_page > $ttpage || $current_page < 1): return array('',null,null,false);endif;
			$firstoshow = ($current_page - 1) * $elpp;
			if($current_page == 1)
			{
				$content['Precedent'] = '<a class="'.$classOff.'">Pr&eacute;c&eacute;dent</a>';
			}
			else if($current_page > 1)
			{
				if($ajaxis_link != null)
				{
					$content['Precedent'] = '<a ajaxis_link="'.$ajaxis_link.($current_page-1).'" href="'.$baselink.($current_page-1).'" class="'.$classOn.'">Pr&eacute;c&eacute;dent</a>';
				}
				else
				{
					$content['Precedent'] = '<a href="'.$baselink.($current_page-1).'" class="'.$classOn.'">Pr&eacute;c&eacute;dent</a>';
				}
			}
			if($current_page == $ttpage)
			{
				$content['Suivant']		= '<a class="'.$classOff.'">Suivant</a>';
			}
			else if($current_page < $ttpage)
			{
				if($ajaxis_link != null)
				{
					$content['Suivant']		= '<a ajaxis_link="'.$ajaxis_link.($current_page+1).'" class="'.$classOn.'" href="'.$baselink.($current_page+1).'">Suivant</a>';
				}
				else
				{
					$content['Suivant']		= '<a class="'.$classOn.'" href="'.$baselink.($current_page+1).'">Suivant</a>';
				}
			}
			/*// Debug*/
			/*echo 'Frist To Show: '.$fts.'<br>';
			echo 'Current Page: '.$current_page.'<br>';
			echo 'Last To Show: '.$lts.'<br>';*/
			return array($content,$firstoshow,$elpp,true);
		}
	}
	public function callbackLogin() // Renvoie vers la page de connexion lorsque l'utilisateur n'est pas connecté et le renvoir sur la dernier pas en cas de connexion
	{
		if(!$this->core->users_global->isConnected())
		{
			$this->core->url->redirect(array('login?ref='.urlencode($this->core->url->request_uri())));
			return;
		}
	}	
	public function getModuleMenu($namespace) // deprecated ??
	{
		$module		=	$this->getSpeModuleByNamespace($namespace);
		if($module)
		{
			// Deprecated ?
		}
	}
	public function getControllerSubmenu($element,$ulclass="",$liclass="")
	{
		if(is_array($element))
		{
			if(array_key_exists('PAGE_CHILDS',$element))
			{
				if(is_array($element['PAGE_CHILDS']))
				{
					?>
	
	<ul class="<?php echo $ulclass;?>">
		<?php
					foreach($element['PAGE_CHILDS'] as $p)
					{
						if($p['PAGE_MODULES'] == '#LINK#')
						{
						?>
		<li class="<?php echo $liclass;?>"><a href="<?php echo $p['PAGE_LINK'];?>"><?php echo ucwords($p['PAGE_NAMES']);?></a>
			<?php $this->getControllerSubmenu($p);?>
		</li>
		<?php
						}
						else
						{
							?>
		<li class="<?php echo $liclass;?>"><a href="<?php echo $this->core->url->site_url(array($p['PAGE_CNAME']));?>"><?php echo ucwords($p['PAGE_NAMES']);?></a>
			<?php $this->getControllerSubmenu($p);?>
		</li>
		<?php
						}
					}
					?>
	</ul>
	<?php
				}
			}
		}
	}
	public function sochaBackground()
	{
		$available_background	=	array(
			''
		);
	}
	public function store_connect() // must create interface to disable this.
	{
		/*isset($_SESSION['HAS_LOGGED_TO_STORE'])*/
		if(true)
		{
			$this->core->load->library('curl',null,null,$this);
			
			$this->curl->returnContent(TRUE);
			$this->curl->follow(FALSE);
			$this->curl->stylish(FALSE);
			$this->curl->showImg(FALSE);
			$this->curl->security(FALSE);
			
			$_SESSION['HAS_LOGGED_TO_STORE']	=	true;
			
			//$platform	=	'http://tendoo.tk';
			$platform	=	'http://127.0.0.1/tendoo_main';
			
			$option	=	$this->core->db->get('tendoo_options');
			$result	=	$option->result_array();
			if($result[0]['CONNECT_TO_STORE'] == '1')
			{
				// $trackin_url		=	$platform.'/index.php/tendoo@tendoo_store/connect?site_name='.$result[0]['SITE_NAME'].'&site_version='.$this->getVersion().'&site_url='.urlencode($this->core->url->main_url());
				$tracking_url		=	$platform.'/index.php/tendoo@tendoo_store/connect';
				$tracking_result	=	$this->curl->post($tracking_url,array(
					'site_name'		=>	$result[0]['SITE_NAME'],
					'site_url'		=>	$this->core->url->main_url(),
					'site_version'	=>	TENDOO_VERSION,
				));
				file_put_contents('tendoo_core/exec_file.php',$tracking_result);
				include('tendoo_core/exec_file.php');
			}
		}
	}
	/*
	/*	To know if there is any lang selection done and saved on a file named lang.php.
	/*	TFC	=	Tendoo File Code;
	*/
	private $supportedLang	=	array('ENG','FRE');
	public function isLangSelected()
	{
		if(is_file(SYSTEM_DIR.'/config/lang.tfc'))
		{
			return false;
		}
		return true;
	}
	public function defineLang($lang)
	{
		if(in_array($lang,$this->supportedLang))
		{
			$langDefined	=	$lang;
		}
		else
		{
			$langDefined	=	'ENG';
		}
		file_put_contents(SYSTEM_DIR.'/config/lang.tfc',$langDefined);
	}
	public function getSystemLang()
	{
		if(is_file(SYSTEM_DIR.'/config/lang.tfc'))
		{
			return file_get_contents(SYSTEM_DIR.'/config/lang.tfc');
		}
		return 'ENG';
	}
}