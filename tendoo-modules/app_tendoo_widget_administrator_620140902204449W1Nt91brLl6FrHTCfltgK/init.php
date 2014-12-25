<?php
class tendoo_widget_administrator_init_class extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->module	=	get_modules( 'filter_namespace' , 'tendoo_widget_administrator' );
		$this->load->library('tendoo_admin',null,'admin');
		if(defined('SCRIPT_CONTEXT'))
		{
			if(SCRIPT_CONTEXT == 'ADMIN')
			{
				$this->admin_context();
				// get_instance()->tendoo_admin->system_not('2 Nouveaux commentaires disponibles', 'Deux nouveaux commentaires sont dans la liste d\'attentes des [Lire la suite] ', '#', '10 mai 2013', null);
			}
			else
			{
				$this->public_context();
			}
			$this->both_context();
		}
	}
	public function admin_context()
	{
		$this->menu		=	new Menu;
		$this->menu->add_admin_menu_core( 'themes' , array(
			'title'			=>		__( 'Manage Widgets' ),
			'icon'			=>		'fa fa-columns',
			'href'			=>		get_instance()->url->site_url( array('admin','open','modules',$this->module['namespace']) )
		) );
	}
	public function public_context()
	{
		bind_event( 'before_frontend' , array( $this , 'before_frontend' ) );
		
		return;
		if( function_exists('declare_shortcut') && get_instance()->users_global->isConnected()){
			if( current_user_can( 'publish_posts@blogster' ) )
			{
				declare_shortcut( __( 'Write a new post' ),$this->url->site_url(array('admin','open','modules',$this->module['namespace'],'publish')));
			}
			if( current_user_can( 'category_manage@blogster' ) )
			{
				declare_shortcut( __( 'Categories' ),$this->url->site_url(array('admin','open','modules',$this->module['namespace'],'category')));
			}
		}
	}
	public function before_frontend()
	{
		$this->instance				=		get_instance();
		$this->data					=		array();
		$this->tendoo				=&		$this->instance->tendoo;
		
		module_include( 'tendoo_widget_administrator' , 'library.php' );
		
		$this->lib					=		new widhandler_common($this->data);
		$this->data['widgetHandler']=&		$this->lib;
		$this->data['getRightWidget']=		$this->lib->getWidgets('RIGHT');
		// var_dump($this->data['getRightWidget']);
		foreach($this->data['getRightWidget'] as $w)
		{
			// Get System Widget
			if(strtolower($w['WIDGET_MODNAMESPACE']) == 'system')
			{
				if($w['WIDGET_NAMESPACE'] == 'texte')
				{
					set_widget( "right" , $w['WIDGET_TITLE'] , $w['WIDGET_PARAMETERS'] , "text" );
				}
			}
			else 
			{
				$module				=	get_modules( 'filter_active_namespace' , $w['WIDGET_MODNAMESPACE'] );
				$configFile			=	MODULES_DIR.$module['encrypted_dir'].'/config/widget_config.php';
				$path				=	MODULES_DIR.$module['encrypted_dir'].'/'; // Chemin d'accès
				if(is_file($configFile)) // Test sur l'exitence des fichiers.
				{
					include_once($configFile); // Intégration des fichiers testé
					if(array_key_exists($w['WIDGET_NAMESPACE'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
					{
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
						$this->data['currentWidget']								=&	$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
						$this->data['widgets']['requestedZone']						=	'RIGHT'; // Set Requested Zone
						include_once($path.$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_FILES']); // Include widget controller;
						$w_output	=	$this->instance->tendoo->interpreter(
							$w['WIDGET_NAMESPACE'].'_'.$w['WIDGET_MODNAMESPACE'].'_common_widget',
							'index',
							array(),
							$this->data					
						);
					}
				}
				else
				{
					$this->instance->notice->push_notice('<strong>Une erreur s\'est produite durant le chargement des widgets');
				}
				
			}
		}
		// Bottom widgets
		$this->data['getBottomWidget']=		$this->lib->getWidgets('BOTTOM');
		// var_dump($this->data['getRightWidget']);
		foreach($this->data['getBottomWidget'] as $w)
		{
			if(strtolower($w['WIDGET_MODNAMESPACE']) == 'system')
			{
				if($w['WIDGET_NAMESPACE'] == 'texte')
				{
					set_widget( "bottom" , $w['WIDGET_TITLE'] , $w['WIDGET_PARAMETERS'] , "text" );
				}
			}
			else
			{
				$module				=	get_modules( 'filter_active_namespace' , $w['WIDGET_MODNAMESPACE'] );
				$configFile			=	MODULES_DIR.$module['encrypted_dir'].'/config/widget_config.php';
				$path				=	MODULES_DIR.$module['encrypted_dir'].'/'; // Chemin d'accès
				if(is_file($configFile)) // Test sur l'exitence des fichiers.
				{
					include_once($configFile); // Intégration des fichiers testé
					if(array_key_exists($w['WIDGET_NAMESPACE'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
					{
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
						$this->data['currentWidget']								=&	$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
						$this->data['widgets']['requestedZone']						=	'BOTTOM'; // Set Requested Zone
						include_once($path.$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_FILES']); // Include widget controller;
						$w_output	=	$this->instance->tendoo->interpreter(
							$w['WIDGET_NAMESPACE'].'_'.$w['WIDGET_MODNAMESPACE'].'_common_widget',
							'index',
							array(),
							$this->data
						);
					}
				}
				else
				{
					$this->instance->notice->push_notice('<strong>Une erreur s\'est produite durant le chargement des widgets');
				}
			}
		}
		// End Bootom widgets
		$this->data['getLeftWidget']=		$this->lib->getWidgets('LEFT');
		foreach($this->data['getLeftWidget'] as $w)
		{
			if(strtolower($w['WIDGET_MODNAMESPACE']) == 'system')
			{
				if($w['WIDGET_NAMESPACE'] == 'texte')
				{
					set_widget( "left" , $w['WIDGET_TITLE'] , $w['WIDGET_PARAMETERS'] , "text" );
				}
			}
			else
			{
				$module				=	get_modules( 'filter_active_namespace' , $w['WIDGET_MODNAMESPACE'] );
				$configFile			=	MODULES_DIR.$module['encrypted_dir'].'/config/widget_config.php';
				$path				=	MODULES_DIR.$module['encrypted_dir'].'/'; // Chemin d'accès
				if(is_file($configFile)) // Test sur l'exitence des fichiers.
				{
					include_once($configFile); // Intégration des fichiers testé
					if(array_key_exists($w['WIDGET_NAMESPACE'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
					{
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
						$this->data['currentWidget']								=&	$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
						$this->data['widgets']['requestedZone']						=	'LEFT'; // Set Requested Zone
						include_once($path.$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_FILES']); // Include widget controller;
						$w_output	=	$this->instance->tendoo->interpreter(
							$w['WIDGET_NAMESPACE'].'_'.$w['WIDGET_MODNAMESPACE'].'_common_widget',
							'index',
							array(),
							$this->data
						);
					}
				}
				else
				{
					$this->instance->notice->push_notice('<strong>Une erreur s\'est produite durant le chargement des widgets');
				}
			}
		}	
	}
	public function both_context()
	{
		// Declaring API_RECENT_POST
		$file	= $this->module[ 'uri_path' ] . 'api/recentspost.php';
		if( is_file( $file ) ){
			
			include_once( $file );
			$this->library = new blogster_recentspost_api($this->module);
			
			declare_api( 'blogster_get_blog_post' , __( 'Recents blog posts' ) , array( $this->library , "getDatas" ) );
		}
		// Declaring API_FEATURED_POST
		$file	= $this->module[ 'uri_path' ] . 'api/featuredpost.php';
		if( is_file( $file ) ){
			
			include_once( $file );
			$this->library = new blogster_featuredpost_api($this->module);
			
			declare_api( 'blogster_get_featured_blog_post' , __( 'Featured blog posts' ) , array( $this->library , "getDatas" ) );
		}
	}
}
