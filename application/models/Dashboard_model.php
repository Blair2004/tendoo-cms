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
		$this->events->do_action( 'load_dashboard' );	
		$this->events->add_action( 'before_dashboard_menu' , array( $this , '__set_admin_menu' ) );
		$this->events->add_action( 'create_dashboard_pages' , array( $this , '__dashboard_config' ) );			
	}
	
	function __dashboard_config()
	{
		$this->gui->register_page( 'index' , array( $this , 'index' ) );
		$this->gui->register_page( 'settings' , array( $this , 'settings' ) );
	}
	function index()
	{
		$this->gui->set_title( sprintf( __( 'Dashboard &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/index/body' );
	}
	
	function settings()
	{
		$this->gui->set_title( sprintf( __( 'Settings &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/settings/body' );
	}
	
	public function __set_admin_menu()
	{	
		$admin_menus		=	array(
			'dashboard'		=>	array(
				array(	
					'href'			=>		site_url('dashboard'),
					'icon'			=>		'fa fa-dashboard',
					'title'			=>		__( 'Dashboard' )
				)
			),
			'media'			=>	array(
				array(
					'title'			=>		__( 'Media Library' ),
					'icon'			=>		'fa fa-image',
					'href'			=>		site_url('dashboard/media')
				)
			),
			'installer'			=>	array(
				array(
					'title'			=>		__( 'Install Apps' ),
					'icon'			=>		'fa fa-flask',
					'href'			=>		site_url('dashboard/installer')
				)
			),
			'modules'			=>	array(
				array(
					'title'			=>		__( 'Modules' ),
					'icon'			=>		'fa fa-puzzle-piece',
					'href'			=>		site_url('dashboard/modules')
				)
			),
			'themes'			=>	array(
				array(
					'title'			=>		__( 'Themes' ),
					'icon'			=>		'fa fa-columns',
					'href'			=>		site_url('dashboard/themes')
				),
				array(
					'href'			=>		site_url('dashboard/controllers'),
					'icon'			=>		'fa fa-bookmark',
					'title'			=>		__( 'Menus' )
				)
			),
			'settings'			=>	array(
				array(
					'title'			=>		__( 'Settings' ),
					'icon'			=>		'fa fa-cogs',
					'href'			=>		site_url('dashboard/settings')
				)
			),
		);
		
		foreach( force_array( $this->events->apply_filters( 'admin_menus' , $admin_menus ) ) as $namespace => $menus )
		{
			foreach( $menus as $menu )
			{
				Menu::add_admin_menu_core( $namespace , $menu  );
			}
		}		
	}	
}