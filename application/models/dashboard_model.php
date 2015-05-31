<?php
/**
 *
 * Title 	:	 Dashboard model
 * Details	:	 Manage dashboard page (creating, ouput)
 *
**/

class Dashboard_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->events->add_action( 'before_admin_menu' , array( $this , 'set_admin_menu' ) );
		$this->events->add_action( 'create_dashboard_pages' , array( $this , 'dashboard_home' ) );
		$this->events->add_action( 'create_dashboard_pages' , array( $this , 'dashboard_settings' ) );
	}
	
	function dashboard_home()
	{
		// Create user page
		$this->gui->create_page( 'home' , __( 'Page Users' ) , __( 'Page Description' ) );
		$this->gui->set_title( 'Custom Title' );
		$this->gui->page_content( 'home' , 'dashboard/index/body' );
	}
	
	function dashboard_settings()
	{
		// Create user page
		$this->gui->create_page( 'settings' , __( 'Page Users' ) , __( 'Page Description' ) );
		$this->gui->set_title( sprintf( __( 'Settings &mdash; %s' ) , get( 'core-signature' ) ) );
		$this->gui->page_content( 'settings' , 'dashboard/settings/body' );
	}

	/**
	 * Define default menu for tendoo dashboard
	**/
	public function set_admin_menu()
	{		
		$this->menu->add_admin_menu_core( 'dashboard' , array(
			'href'			=>		site_url('dashboard/page/home'),
			'icon'			=>		'fa fa-dashboard',
			'title'			=>		__( 'Dashboard' )
		) );
		
		$this->menu->add_admin_menu_core( 'media' , array(
			'title'			=>		__( 'Media Library' ),
			'icon'			=>		'fa fa-image',
			'href'			=>		site_url('dashboard/page/media')
		) );
		
		$this->menu->add_admin_menu_core( 'installer' , array(
			'title'			=>		__( 'Install Apps' ),
			'icon'			=>		'fa fa-flask',
			'href'			=>		site_url('dashboard/page/installer')
		) );
		
		$this->menu->add_admin_menu_core( 'modules' , array(
			'title'			=>		__( 'Modules' ),
			'icon'			=>		'fa fa-puzzle-piece',
			'href'			=>		site_url('dashboard/page/modules')
		) );
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'title'			=>		__( 'Themes' ),
			'icon'			=>		'fa fa-columns',
			'href'			=>		site_url('dashboard/page/themes')
		) );
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'href'			=>		site_url('dashboard/page/controllers'),
			'icon'			=>		'fa fa-bookmark',
			'title'			=>		__( 'Menus' )
		) );
		//
		
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'Manage Users' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/page/users')
		) );
		
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'Create a new User' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/page/users/create')
		) );
		// Self settings
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'My Profile' ) , // current_user( 'PSEUDO' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/page/profile')
		) );
			
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Roles & Groups' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/page/roles')
		) );
		
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Create new role' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/page/roles/create')
		) );
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Roles permissions' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/page/roles/permissions')
		) );
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Manage Groups' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/page/roles/permissions')
		) );
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Create a new Group' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/page/roles/permissions')
		) );
		
		$this->menu->add_admin_menu_core( 'settings' , array(
			'title'			=>		__( 'Settings' ),
			'icon'			=>		'fa fa-cogs',
			'href'			=>		site_url('dashboard/page/settings')
		) );
		
		/** 
		$this->menu->add_admin_menu_core( 'frontend' , array(
			'title'			=>		sprintf( __( 'Visit %s' ) , riake( 'site_name' , $this->options ) ) ,
			'icon'			=>		'fa fa-eye',
			'href'			=>		site_url('index')
		) );
		
		
		$notices_nbr		=		0;
		// $notices_nbr		+=		( get_user_meta( 'tendoo_status' ) == false ) ? 1 : 0;
		
		$this->menu->add_admin_menu_core( 'about' , array(
			'title'			=>		__( 'About' ) ,
			'icon'			=>		'fa fa-rocket',
			'href'			=>		site_url('dashboard/page/about'),
			'notices_nbr'	=>		 $notices_nbr
		) );	
		**/
	}	
	
	/**
	 * Create dashboard page
	**/
	
	
}