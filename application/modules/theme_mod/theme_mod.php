<?php
class Theme_Mod extends CI_Model
{
	/**
	 * Module Constructor
	**/
	function __construct()
	{
		parent::__construct();
		// Constant for Themes path
		define( 'THEMESPATH', APPPATH . 'themes/' );
		
		$this->events->add_action( 'setup_theme', array( $this, 'test' ), 10 );
		$this->events->add_action( 'after_app_init', array( $this, 'init' ), 1 );
		$this->events->add_action( 'do_remove_module', array( $this, 'remove_module' ) );
		$this->events->add_action( 'do_enable_module', array( $this, 'enable_module' ) );
		$this->events->add_action( 'load_dashboard', array( $this, 'dashboard' ) );
		$this->events->add_action( 'load_frontend', array( $this, 'frontend' ) );
		$this->events->add_action( 'tendoo_settings_tables', function(){
			Modules::enable( 'theme_mod' );
		});
		
		$this->events->add_action( 'tendoo_settings_tables', array( $this, 'install_tables' ) );
	}
	
	function install_tables()
	{
		$this->db->query( "CREATE TABLE `{$this->db->dbprefix}navigation_menus` (
		  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `NAMESPACE` varchar(100),
		  `CONTENT` text,
		  `AUTHOR` int(11) NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		  `DATE_MODIFICATION` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;" );
	}
	
	/**
	 * Enable module
	 *
	**/
	
	function enable_module( $module ) 
	{
		global $Options;
		if( $module == 'theme_mod' && @$Options[ 'theme_mod_installed' ] == NULL ) {
			$this->install_tables();
			$this->options->set( 'theme_mod_installed', TRUE, TRUE );
		}
	}
	
	function remove_module( $module )
	{
		if( $module == 'theme_mod' ) {
			$this->db->query( "DROP TABLE IF EXISTS `{$this->db->dbprefix}navigation_menus`;" );
			$this->options->delete( 'theme_mod_installed' );
		}
	}
	
	function test()
	{
		Theme::Register_Nav_Location( 'header', __( 'Header Menu' ) );
		Theme::Register_Nav_Location( 'footer', __( 'Footer Menu' ) );
		Theme::Register_Nav_Location( 'bottom', __( 'Bottom Menu' ) );
	}
	/**
	 * Init
	 * After APP init
	 * Browse Theme Folder
	 *
	 * @access public
	 * @return void
	**/
	
	function init()
	{		
		$this->load->library( 'theme' );
		$this->load->helper( 'text' );
		$this->events->do_action( 'setup_theme' );
	}
	
	/**
	 * Creating a Dashboard Page
	**/
	
	function dashboard()
	{
		// Save Menu
		$this->events->add_filter( 'admin_menus', array( $this, 'create_menus' ) );
		// Register Page
		$this->Gui->register_page( 'menu_builder', 	array( $this, 'menu_builder_controller' ) );
	}
	
	/**
	 * Controller : menu_builder_controller
	**/
	
	function menu_builder_controller()
	{		
		$this->Gui->set_title( sprintf( __( 'Menu Builder &mdash; %s' ) , get( 'core_signature' ) ) );
		
		$this->load->view( '../modules/theme_mod/views/menu_builder' );
	}
	
	/**
	 * Create Menu 
	**/
	
	function create_menus( $menu )
	{
		$splited_1	=	array_slice( $menu, 0, 2 );	
		$splited_2	=	array_slice( $menu, 2 );
		$thismenu	=	array(
			'theme_mod'	=>	array(
				array(
					'title'		=>	__( 'Themes' ),
					'href'		=>	site_url( array( 'dashboard', 'menu_builder' ) ),
					'disable'	=>	true
				),
				array(
					'title'		=>	__( 'Menu' ),
					'href'		=>	site_url( array( 'dashboard', 'menu_builder' ) )
				)
			)
		);	
		
		$menu		=	array_merge( $splited_1, $thismenu, $splited_2 );
		$menu[ 'visit_blog' ]	=	array(
			array(
				'title'		=>	__( 'Get to blog' ),
				'href'		=>	site_url(),
				'icon'		=>	'fa fa-home'
			)	
		);
		return $menu;
	}
	
	/** 
	 * Load Frontend with parser
	**/
	
	function frontend( $params )
	{
		Theme::Run_Theme( $params );
	}
}
new Theme_Mod;