<?php
class blogster_init_class extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->module	=	get_modules( 'filter_namespace' , 'blogster' );
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
		$this->posts					=		new PostType( array(
			'namespace'					=>		'posts',
			'label'						=>		__( 'Posts' ),
			'is-hierarchical'			=>		false
		) );
		
		$this->posts->run();
		
		$this->pages					=		new PostType( array(
			'namespace'					=>		'pages',
			'label'						=>		__( 'Pages' ),
			'is-hierarchical'			=>		true
		) );
		
		$this->pages->run();
		// Creating Menu 1.4
		create_admin_menu( 'blogster' , 'after' , 'dashboard' );
		
		add_admin_menu( 'blogster' , array(
			'title'	=>	__( 'Posts' ), 
			'href'	=>	module_url( array( 'index' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' , array(
			'title'	=>	__( 'Write a new post' ), 
			'href'	=>	module_url( array( 'publish' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' ,array(
			'title'	=>	__( 'Create a new category' ), 
			'href'	=>	module_url( array( 'category', 'create' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' ,array(
			'title'	=>	__( 'Categories' ), 
			'href'	=>	module_url( array( 'category' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' ,array(
			'title'	=>	__( 'Comments' ), 
			'href'	=>	module_url( array( 'comments' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' ,array(
			'title'	=>	__( 'Tags' ), 
			'href'	=>	module_url( array( 'tags' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' ,array(
			'title'	=>	__( 'Settings' ), 
			'href'	=>	module_url( array( 'setting' ) , 'blogster' )
		) );
		declare_admin_widget(array(
			"module_namespace"		=>	"blogster",
			"widget_namespace"		=>	"articles_stats",
			"widget_title"			=>	__( 'Blogster statistics' ),
			"widget_content"		=>	$this->load->view(MODULES_DIR.$this->module['encrypted_dir'].'/views/widgets/articles_stats',null,true,true),
			"widget_description"	=>	__( 'Displays blogster stats' )
		));
		declare_admin_widget(array(
			"module_namespace"		=>	"blogster",
			"widget_namespace"		=>	"recents_commentaires",
			"widget_title"			=>	__( 'Recents comments' ),
			"widget_content"		=>	$this->load->view(MODULES_DIR.$this->module['encrypted_dir'].'/views/widgets/recents_comments',null,true,true),
			"widget_description"	=>	__( 'Displays recents comments' ),
			"action_control"		=>	module_action('blogster','blogster_manage_comments')
		));
	}
	public function public_context()
	{
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
