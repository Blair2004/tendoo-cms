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
				$this->salaire_personnel		=		new PostType( array(
					'namespace'					=>		'posts',
					'label'						=>		__( 'Mise à jour' )
				) );
				
				$this->salaire_personnel->define_taxonomy( 'category' , __( 'Catégorie' ) , array(
					'is_hierarchical'			=>		true
				) );
						
				$this->salaire_personnel->run();
			}
			else
			{
				$this->public_context();
			}
			$this->both_context();
		}
	}
	public function after_editor_plugin( $Params )
	{
		$gui		=	riake( 1 , $Params );
		$posttype	=	riake( 0 , $Params );
		$namespace	=	riake( 2 , $Params );
		$post		=	riake( 3 , $Params ); // If set it means that the post is currently edited
		
		$namespace	=	riake( 'namespace' , $posttype->get_config() );
		
		if( $namespace == 'posts' )
		{		
			$gui->set_meta( array(
				'type'			=>	'panel',
				'namespace'		=>	'custom-meta-box',
				'title'			=>	__( 'More Meta Box' )
			) )->push_to( 1 );
			
			$gui->set_item( array(
				'type'	=>	'text',
				'name'	=>	'post_meta[custom]',
				'label'	=>	__( 'Custom Post' ),
				'value'	=>	riake( 'custom' , $post )
			) )->push_to( 'custom-meta-box' );
		}
	}
	public function admin_context()
	{
		$this->salaire_personnel		=		new PostType( array(
			'namespace'					=>		'posts',
			'label'						=>		__( 'Post' ),
			'meta'						=>		array( 'custom' )
		) );
		
		$this->salaire_personnel->define_taxonomy( 'category' , __( 'Catégorie' ) , array(
			'is_hierarchical'			=>		true
		) );
		
		bind_event( 'after_editor_inition' , array( $this , 'after_editor_plugin' ) );
				
		$this->salaire_personnel->run();
		// Creating Menu 1.4
		create_admin_menu( 'blogster' , 'after' , 'dashboard' );
		
		add_admin_menu( 'blogster' , array(
			'title'	=>	__( 'Posts' ), 
			'href'	=>	module_url( array( 'index' ) , 'blogster' )
		) );
		add_admin_menu( 'blogster' , array(
			'title'			=>	__( 'Write a new post' ), 
			'href'			=>	module_url( array( 'publish' ) , 'blogster' ),
			'notices_nbr'	=> 	3
		) );
		add_admin_menu( 'blogster' ,array(
			'title'			=>	__( 'Create a new category' ), 
			'href'			=>	module_url( array( 'category', 'create' ) , 'blogster' ),
			'notices_nbr'	=> 	1
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
