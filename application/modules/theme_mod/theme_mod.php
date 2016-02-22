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
		
		$this->events->add_action( 'load_dashboard', array( $this, 'dashboard' ) );
		$this->events->add_action( 'load_frontend', array( $this, 'frontend' ) );
		$this->events->add_action( 'tendoo_settings_table', function(){
			Modules::enable( 'theme_mod' );
		});
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
		$this->enqueue->css( css_url( 'theme_mod' ) . 'style', '' );
		
		$this->enqueue->js( js_url( 'theme_mod' ) . 'jquery.nestable', '' );
		$this->enqueue->js( js_url( 'theme_mod' ) . 'sha1', '' );
		
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