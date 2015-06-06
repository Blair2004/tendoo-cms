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
		
		$this->events->add_action( 'before_admin_menu' , array( $this , '__set_admin_menu' ) );
		$this->events->add_action( 'create_dashboard_pages' , array( $this , '__dashboard_config' ) );
	}
	
	function __dashboard_config()
	{
		$this->gui->register_page( 'index' , array( $this , 'index' ) );
		$this->gui->register_page( 'settings' , array( $this , 'settings' ) );
		$this->gui->register_page( 'users' , array( $this , 'users' ) );
	}
	function index()
	{
		$this->gui->set_title( 'This Title' );
		$this->load->view( 'dashboard/index/body' );
	}
	
	function settings()
	{
		$this->gui->set_title( sprintf( __( 'Settings &mdash; %s' ) , get( 'core-signature' ) ) );
		$this->load->view( 'dashboard/settings/body' );
	}
	
	function users( $page = 'list' , $index = 1 )
	{		
		if( $page == 'list' )
		{
			$this->gui->set_title( sprintf( __( 'Users &mdash; %s' ) , get( 'core-signature' ) ) );
			$this->load->view( 'dashboard/users/body' );
		}
		else
		{
			// Group is choosen automatically	
			// selecting privileges
			$privileges	=	$this->flexi_auth->get_privileges( array(
				'upriv_id as privilege_id',
				'upriv_name as privilege_name'
			) );			
			
			$this->gui->set_title( sprintf( __( 'Create a new user &mdash; %s' ) , get( 'core-signature' ) ) );
			
			$this->load->view( 'dashboard/users/create' , array( 
				'privileges'	=>	$privileges
			) );
		}
	}

	/**
	 * Define default menu for tendoo dashboard
	**/
	public function __set_admin_menu()
	{		
		$this->menu->add_admin_menu_core( 'dashboard' , array(
			'href'			=>		site_url('dashboard'),
			'icon'			=>		'fa fa-dashboard',
			'title'			=>		__( 'Dashboard' )
		) );
		
		$this->menu->add_admin_menu_core( 'media' , array(
			'title'			=>		__( 'Media Library' ),
			'icon'			=>		'fa fa-image',
			'href'			=>		site_url('dashboard/media')
		) );
		
		$this->menu->add_admin_menu_core( 'installer' , array(
			'title'			=>		__( 'Install Apps' ),
			'icon'			=>		'fa fa-flask',
			'href'			=>		site_url('dashboard/installer')
		) );
		
		$this->menu->add_admin_menu_core( 'modules' , array(
			'title'			=>		__( 'Modules' ),
			'icon'			=>		'fa fa-puzzle-piece',
			'href'			=>		site_url('dashboard/modules')
		) );
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'title'			=>		__( 'Themes' ),
			'icon'			=>		'fa fa-columns',
			'href'			=>		site_url('dashboard/themes')
		) );
		
		$this->menu->add_admin_menu_core( 'themes' , array(
			'href'			=>		site_url('dashboard/controllers'),
			'icon'			=>		'fa fa-bookmark',
			'title'			=>		__( 'Menus' )
		) );
		//
		
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'Manage Users' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/users')
		) );
		
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'Create a new User' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/users/create')
		) );
		// Self settings
		$this->menu->add_admin_menu_core( 'users' , array(
			'title'			=>		__( 'My Profile' ) , // current_user( 'PSEUDO' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/profile')
		) );
			
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Roles & Groups' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/roles')
		) );
		
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Create new role' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/roles/create')
		) );
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Roles permissions' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/roles/permissions')
		) );
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Manage Groups' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/roles/permissions')
		) );
		$this->menu->add_admin_menu_core( 'roles' , array(
			'title'			=>		__( 'Create a new Group' ),
			'icon'			=>		'fa fa-shield',
			'href'			=>		site_url('dashboard/roles/permissions')
		) );
		
		$this->menu->add_admin_menu_core( 'settings' , array(
			'title'			=>		__( 'Settings' ),
			'icon'			=>		'fa fa-cogs',
			'href'			=>		site_url('dashboard/settings')
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
			'href'			=>		site_url('dashboard/about'),
			'notices_nbr'	=>		 $notices_nbr
		) );	
		**/
	}	
	
	/**
	 * Create dashboard page
	**/
	
	
}