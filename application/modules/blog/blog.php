<?php
class blog_module extends CI_Model
{
	 function __construct()
	 {
		parent::__construct();
		$this->events->add_action( 'tendoo_settings_tables' , function(){
			Modules::enable( 'blog' );
		});

		$this->events->add_action( 'after_app_init' , array( $this , 'loader' ) );
		$this->events->add_action( 'load_post_types' , array( $this , 'blog_post_type' ) );
	 }
	 
	 function loader()
	 {
		if( ! Modules::is_active( 'post_type' ) )
		{
			$this->events->add_filter( 'ui_notices' , function( $notices ){
				$notices[]	=	array(
					'msg'		=>	__( 'Post Type module is not enabled...' ),
					'icon'	=> 'times',
					'type'	=>	'warning'
				);
				return $notices;
			});
		}
	 }
	 function blog_post_type()
	 {
		 // Blog
		$this->load->library( 'PostType' , array(
			'namespace'				=>		'blog',
			'label'					=>		__( 'Blog Post' ),
			'menu-icon'				=>		'fa fa-newspaper-o',
			'is-hierarchical'		=>	false
		) , 'blog' );
		
		$this->blog->define_taxonomy(	'category' , __( 'Category' ) , array(
		) );
		
		$this->blog->define_taxonomy(	'tag' , __( 'Tags' ) , array(
		) );
		
		$this->blog->run();
		
		// Page
		$this->load->library( 'PostType' , array(
			'namespace'		=>		'page',
			'label'			=>		__( 'Pages' ),
			'menu-icon'				=>		'fa fa-file',
			'is-hierarchical'		=>	true
		) , 'page' );
		
		$this->page->run();
	 }
}
new blog_module;