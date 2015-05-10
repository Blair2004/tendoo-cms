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
		/* CREATE tendoo_query */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_query` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(255) NOT NULL,
			`TITLE` varchar(255),
			`CONTENT` text NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`AUTHOR` varchar(255) NOT NULL,
			`STATUS` int(11) NOT NULL,
			`PARENT_REF_ID` int(11) NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_attachment */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_query_meta` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`QUERY_REF_ID` int(11) NOT NULL,
			`KEY` varchar(255),
			`VALUE` text NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_taxonomies */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_query_taxonomies` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(255) NOT NULL,
			`QUERY_NAMESPACE` varchar(200) NOT NULL,
			`TITLE` varchar(255),
			`CONTENT` text NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`PARENT_REF_ID` int(11) NOT NULL,
			`AUTHOR` varchar(255) NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_taxonomies */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_query_taxonomies_relationships` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`TAXONOMY_REF_ID` int(11) NOT NULL,
			`QUERY_REF_ID` int(11),
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_comments */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_query_comments` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`AUTHOR` int(11) NOT NULL,
			`COMMENTS` text,
			`QUERY_NAMESPACE` varchar(200),
			`CUSTOM_QUERY_ID` int(11) NOT NULL,
			`STATUS` int(11) NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED datetime NOT NULL`
			`REPLY_TO` int(11) NOT NULL,
			`AUTHOR_EMAIL` varchar(200),
			`AUTHOR_NAME` varchar(200),
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
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
			`REF_ROLE_ID` varchar(100) NOT NULL,
			`ACTIVE` varchar(100) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/// ADMIN REF_ROLE_ID TABLE create  `tendoo_roles`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'.$DB_ROOT.'tendoo_roles` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `NAME` varchar(100) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `DATE` datetime NOT NULL,
		  `IS_SELECTABLE` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;
		;';
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
		$this->load->library('roles'); // loading Admin Class
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
						// Registering Actions : Deprecated
						/**
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
						**/
					}
				}
				// Get unique available theme
				load_themes();
				$themes		=	get_themes( 'all' );
				// Creating Config File
				$this->createConfigFile();
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
					"pages_editor",
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
				get_instance()->meta_datas->set( 'flaty_theme_settings' , '{"slider":{"api_limit":"10","declared_apis":"blogster_get_blog_post","declared_item":"slider"},"testimony":{"testimony_big_title":"Tendoo is also","testimony_big_description":"Many features, more themes and a growing community. Why should you use Tendoo ?","testimony_content":{"level":{"0":"I find this project more accomplished.","1":"i wasn\'t expecting such result with huge work done by contributors.","2":"I hope this project will keep going ahead. I\'m about to contribute as i can, with issues submission.","3":"We worked hard to reach this result, and we\'re proud. We intend to offer a real free web application for both web site and web applications."}},"testimony_authors":{"level":{"0":"B. Jersyer","1":"Afromaster","2":"Lucas Ferry","3":"Sergey Rakovsky"}}},"list_services":{"section_text":"","section_textarea":"","title":{"level":{"0":"Follow us on Facebook","1":"Follow us on Twitter","2":"Google+"}},"link":{"level":{"0":"http:\/\/facebook.com\/tendoocms","1":"http:\/\/twitter.com\/","2":"http:\/\/plus.google.com"}},"description":{"level":{"0":"All news and updates details are available on facebook, the official website and sourceforge.","1":"We are also on Twitter. Don\'t miss our tweets..","2":"Don\'t miss our Google+ updates. Add us to your circles."}},"icons":{"level":{"0":"facebook","1":"twitter","2":"google-plus"}}}}' );
				// Eva theme settings
				get_instance()->meta_datas->set( 'eva_theme_settings' , '{"contact_datas":{"contact_description_title":"A propos de nous","contact_description_content":"Tendoo est un logiciel Open-Source disponible sur <a href=\"http:\/\/github.com\/Blair2004\/tendoo-cms\">github<\/a> et t\u00e9l\u00e9chargeable gratuitement. Nous esp\u00e9rons qu\'il saura vous s\u00e9duire, mais surtout nous sommes en attente de vos avis. N\'h\u00e9sitez pas \u00e0 \"Fork\" le repertoire.","contact_details_title":"Contactez-nous","contact_details_content":"Suivez nos actualit\u00e9s sur les r\u00e9seaux sociaux ou sur <a href=\"http:\/\/tendoo.org\">tendoo.org<\/a>.","social_feeds_icon":{"level":{"0":"map-marker","1":"envelope"}},"social_feeds_title":{"level":{"0":"Adresse","1":"Mail"}},"social_feeds_value":{"level":{"0":"World, Earth","1":"carlosjohnsonluv2004@gmail.com"}}},"theme_color_and_style":{"background":"red","box_style":"fullwidth","bg_image":"black_mamba"},"social_feeds":{"social_links":{"level":{"0":"https:\/\/www.facebook.com\/tendoocms"}},"social_icons":{"level":{"0":"facebook"}}},"list_services":{"title":{"level":{"0":"Plusieurs fonctionnalit\u00e9s","1":"Une performance am\u00e9lior\u00e9","2":"Devenir un contributeur","3":"Administration","4":"Statistiques & Utilisateurs","5":"Suivez-nous sur Facebook"}},"link":{"level":{"0":"#","1":"#","2":"http:\/\/github.com\/Blair2004\/tendoo-cms","3":"#","4":"#","5":"https:\/\/www.facebook.com\/tendoocms"}},"description":{"level":{"0":"La version 1.3 de Tendoo propose plusieurs fonctionnalit\u00e9s. C\'est assur\u00e9ment la version la plus stable de Tendoo. Avec un code revisit\u00e9 et corrig\u00e9.","1":"Le syst\u00e8me a \u00e9t\u00e9 modifi\u00e9. La gestion des th\u00e8mes et des modules \u00e0 \u00e9t\u00e9 am\u00e9lior\u00e9, ainsi que leur gestion. D\u00e9couvrez des th\u00e8mes beaucoup plus beau mais surtout \"Responsive\".","2":"Tendoo est un logiciel gratuit disponible sur Github. Vous pouvez apporter votre contribution comme vous le souhaitez depuis le r\u00e9pertoire officiel. \"Forkez-nous\" sur Gihub.","3":"D\u00e9couvrez un panneau d\'administration pas comme les autres. Avec des zones de widgets personnalisables, qui peuvent \u00eatre administr\u00e9s depuis les param\u00e8tres.","4":"Tendoo mets des outils d\'analyse et de statistiques \u00e0 la disposition de ses utilisateurs. Am\u00e9liorer votre strat\u00e9gie en fonction de vos performances.","5":"Suivez nos actualit\u00e9s directement sur Facebook et ne manquez pas \u00e0 l\'occasion de donner votre avis. Vous resterez connect\u00e9 aux nouveaut\u00e9s sur Tendoo."}},"icons":{"level":{"0":"gift","1":"thumbs-o-up","2":"github-alt","3":"home","4":"group","5":"facebook"}}},"recents_works":{"title":{"level":{"0":"Ceci est un projet de feu","1":"Cold Bold","2":"","3":"","4":"","5":"Dark Cat","6":"Children"}},"category":{"level":{"0":"Fire Bold","1":"une cat\u00e9gorie","2":"","3":"","4":"","5":"Dark Cat","6":"Les enfants"}},"full_image":{"level":{"0":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","1":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","2":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","3":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","4":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","5":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","6":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg"}},"thumb_image":{"level":{"0":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","1":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","2":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","3":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","4":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","5":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg","6":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg"}},"link":{"level":{"0":"#","1":"#","2":"","3":"","4":"","5":"#","6":"#Les enfants"}},"global_title":"Nos projets"},"feature_list":{"feature_list_title":"Quoi de neuf avec Tendoo 1.3","feature_list_description":"D\u00e9couvrez une version beaucoup plus stable que les pr\u00e9c\u00e9dentes. Nous avons longuement travailler pour proposer une application \u00e9pur\u00e9 et simple \u00e0 prendre en main, avec 3 th\u00e8mes disponibles par d\u00e9faut. Tendoo c\'est \u00e9galement.","feature_list_loop_title":{"level":{"0":"Une application web robuste","1":"Un CMS pas comme les autres","2":"Plein de fonctionnalit\u00e9 et de services"}},"feature_list_loop_link":{"level":{"0":"#","1":"#","2":"#"}},"icons":{"level":{"0":"thumbs-o-up","1":"rocket","2":"gift"}}},"testimonials":{"feature_list_title":"Nos t\u00e9moignages","testimonial_author":{"level":{"0":"John Doe","1":"Sacha"}},"testimonial_author_subinfo":{"level":{"0":"Proceder","1":"Reviewer"}},"testimonial_author_img":{"level":{"0":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062004228196593.jpg","1":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-modules\/app_tendoo_contents_620140902154910PqALJ6NSaBKqWW53ryP1t\/content_repository\/tendoo_content_5201409062005303213383.jpg"}},"testimonial_author_content":{"level":{"0":"Lorem ipsum dolor sit amet, cons adipiscing elit. Aenean commodo ligula eget dolor. Cum sociis natoque penatibus mag dis parturient. Lorem ipsum dolor sit amet, cons adipiscing elit. Aenean commodo ligula eget dolor. Cum sociis natoque penatibus mag dis parturient.","1":"Lorem ipsum dolor sit amet, cons adipiscing elit. Aenean commodo ligula eget dolor. Cum sociis natoque penatibus mag dis parturient. Lorem ipsum dolor sit amet, cons adipiscing elit. Aenean commodo ligula eget dolor. Cum sociis natoque penatibus mag dis parturient.Lorem ipsum dolor sit amet, cons adipiscing elit. Aenean commodo ligula eget dolor. Cum sociis natoque penatibus mag dis parturient."}},"testimonials_title":"Nos t\u00e9moignages"},"promo_box":{"promo_title":"D\u00e9couvrez Tendoo 1.3","promo_description":"D\u00e9couvrez une version beaucoup plus stable de tendoo 1.3, avec de nouveaux outils et de nouvelles fonctionnalit\u00e9s.","promo_icon":"archive","promo_button_text":"T\u00e9l\u00e9charger Tendoo","promo_button_link":"https:\/\/github.com\/Blair2004\/tendoo-cms\/releases","promo_visibility":"1"},"fraction_slider":{"slider_namespaces":"item1, item2","slider_anims":"fade, fade","item_slide_id":{"level":{"0":"item1","1":"item1","2":"item2","3":"item2","4":"item2","5":"item2"}},"item_position":{"level":{"0":"180,800","1":"50,485","2":"0,0","3":"150,100","4":"50,750","5":"200,100"}},"item_anim_start":{"level":{"0":"fade"}},"item_anim_end":{"level":{"0":""}},"item_anim_ease":{"level":{"0":"linear","1":"linear"}},"item_anim_delay":{"level":{"0":"0","1":"","2":"","3":"2000","4":"0","5":"1000"}},"item_anim_speed":{"level":{"0":"","1":"","2":"","3":"","4":"","5":""}},"item_anim_dim":{"level":{"0":""}},"item_anim_type":{"level":{"0":"p"}},"item_anim_fixed":{"level":{"0":"fixed","1":"animated","2":"animated","3":"animated","4":"animated","5":"animated"}},"item_anim_start_type":{"level":{"0":"bottom","1":"top","2":"fade","3":"right","4":"top","5":"right"}},"item_anim_end_type":{"level":{"0":"bottom","1":"top","2":"fade","3":"left","4":"top","5":"left"}},"item_anim_ease_in":{"level":{"0":"easeInOutCubic","1":"easeInOutCubic","2":"linear","3":"","4":"","5":""}},"item_anim_ease_out":{"level":{"0":"","1":"","2":"linear","3":"","4":"","5":""}},"item_dim":{"level":{"0":"","1":"","2":"2000x750","3":"","4":"","5":""}},"item_type":{"level":{"0":"img","1":"p","2":"img","3":"p","4":"p","5":"p"}},"item_content":{"level":{"0":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-assets\/img\/tendoo_darken.png","1":"Bienvenue sur Tendoo CMS","2":"http:\/\/127.0.0.1\/tendoo-cms\/tendoo-assets\/eve-theme-images\/2.jpg","3":"Simple et facile \u00e0 utiliser","4":"Ses atouts","5":"Rapide et Puissant"}},"item_class":{"level":{"0":"","1":"para-new","2":"","3":"teaser turky small","4":"claim light-pink","5":"teaser turky small"}},"item_css_style":{"level":{"0":"","1":"","2":"","3":"","4":"","5":""}},"display_slider":"0","item_step":{"level":{"0":"","1":"","2":"","3":"","4":"","5":""}},"item_anim_time":{"level":{"0":"","1":"","2":"","3":"","4":"","5":""}}},"header_datas":{"header_text":{"level":{"0":"carlosjohnsonluv2004@gmail.com"}},"header_icon":{"level":{"0":"envelope"}}},"footer_social_feeds":{"social_links":{"level":{"0":"https:\/\/www.facebook.com\/tendoocms"}},"social_icons":{"level":{"0":"facebook"}}},"contact_get_social":{"get_social_title":"Suivez-nous","social_links":{"level":{"0":"https:\/\/www.facebook.com\/tendoocms"}},"social_icons":{"level":{"0":"facebook"}}},"contact_gmap_data":{"gmap_longitude":"2.3522219","gmap_latitude":"48.8566140"}}' );
				// Creating Base Roles
				$this->roles->create( __( 'Administrator' ) , '' , 0 );
				$this->roles->create( __( 'User' ) , '' , 0 );
				
				if( $themes ){
					foreach( $themes as $namespace	=>	$app_datas ){
						// Activate module 
						if( $namespace == 'eva' ) // Eva is set by default
						{
							active_theme( $namespace );
						}
						// Executing Sql queries
						if( is_array( $queries =	riake( 'sql_queries' , $app_datas ) ) ){
							foreach( $queries as $sql_line ){
								get_db( 'from_install_interface' )->query( $sql_line );
							}
						}
					}
				}
				return json_encode( array( 
					'response'	=>	translate( "Installation is now complete. We're taking you to your new website. <br>Thank you for using Tendoo CMS..." ),
					'type'		=>	'warning',
					'step'		=>	2,
					'progress'	=>	100
				) );
			} else {
				return json_encode( array( 
					'response'	=>	translate( 'Error occurred during tables creation. Please check out the server configuration, and try again.' ),
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