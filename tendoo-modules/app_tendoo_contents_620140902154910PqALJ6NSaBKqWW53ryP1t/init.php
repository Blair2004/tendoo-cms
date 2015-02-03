<?php
class tendoo_contents_init_class extends Libraries
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
		create_admin_menu( 'tendoo_contents' , 'after' , 'dashboard' );
		add_admin_menu( 'tendoo_contents' , array(
			'title'	=>	__( 'Media Library' ), 
			'href'	=>	module_url( array( 'index' ) , 'tendoo_contents' ),
			'icon'	=>	'fa fa-image'
		) );
		add_admin_menu( 'tendoo_contents' , array(
			'title'	=>	__( 'Add new media' ), 
			'href'	=>	module_url( array( 'upload' ) , 'tendoo_contents' )
		) );
	}
	public function public_context()
	{
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
