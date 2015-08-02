<?php
class blog_module extends CI_Model
{
	 function __construct()
	 {
		 parent::__construct();
		 $this->events->add_action( 'load_post_types' , array( $this , 'blog_post_type' ) );
		 $this->events->add_action( 'tendoo_settings_tables' , function(){
			Modules::enable( 'blog' );
		});
	 }
	 
	 function blog_post_type()
	 {
		 // Blog
		$this->load->library( 'posttype' , array(
			'namespace'				=>		'blog',
			'label'					=>		__( 'Blog Post' ),
			'menu-icon'				=>		'fa fa-newspaper-o',
			'is-hierarchical'		=>	false
		) , 'blog' );
		
		$this->blog->run();
		
		// Page
		$this->load->library( 'posttype' , array(
			'namespace'		=>		'page',
			'label'			=>		__( 'Pages' ),
			'menu-icon'				=>		'fa fa-file',
		) , 'page' );
		
		$this->page->run();
	 }
}
new blog_module;