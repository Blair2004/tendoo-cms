<?php
class PostType
{
	/**
	 * 	Its create post type interface quickly. Callable from "init.php" module and theme file.
	**/
	function __construct( $config )
	{
		$this->namespace			=	riake( 'namespace' , $config );
		$this->meta					=	riake( 'meta' , $config );
		$this->label				=	riake( 'label' , $config , $this->namespace );
		$this->new_post_label		=	riake( 'new-post-label' , $config , sprintf( __( 'Create a new %s' ) , $this->namespace ) );
		$this->edit_post_label		=	riake( 'edit-post-label' , $config , sprintf( __( 'Edit %s' ) , $this->namespace ) );
		$this->posts_list_label		=	riake( 'posts-list-label' , $config , sprintf( __( '%s list' ) , $this->namespace ) );
		$this->delete_post_label	=	riake( 'delete-post-label' , $config , sprintf( __( 'delete %s' ) , $this->namespace ) );
		$this->menu_position		=	riake( 'menu-position' , $config , array( 'after' , 'dashboard' ) );
		$this->menu_icon			=	riake( 'menu-icon' , $config , 'fa fa-star' );
		$this->privilege			=	riake( 'privilege' , $config , 'system@manage_modules' );
		
		if( ! $this->namespace )
		{
			return false;
		}
		
		$this->query				=	new CustomQuery( array(
			'namespace'					=>	$this->namespace,
			'meta'						=>	$this->meta
		) );
		
		$posttypes						=	get_core_vars( 'posttypes' );
		$posttypes[ $this->namespace ]	=	$this;
		
		set_core_vars( 'posttypes' , $posttypes );
	}
	function run()
	{
		if( current_user()->can( $this->privilege ) )
		{
			create_admin_menu( $this->namespace , riake( 0 , $this->menu_position ) , riake( 1 , $this->menu_position ) );
			
			add_admin_menu( $this->namespace , array(
				'title'			=>	$this->label, 
				'href'			=>	'#',
				'is_submenu'	=>	false,
				'icon'			=>	$this->menu_icon
			) );
			
			add_admin_menu( $this->namespace , array(
				'title'			=>	$this->posts_list_label, 
				'href'			=>	get_instance()->url->site_url( array( 'admin' , 'posttype' , $this->namespace , 'list' ) ),
			) );
			
			add_admin_menu( $this->namespace , array(
				'title'			=>	$this->new_post_label, 
				'href'			=>	get_instance()->url->site_url( array( 'admin' , 'posttype' , $this->namespace , 'new' ) ),
			) );
			
			foreach( force_array( $this->query->get_defined_taxonomies() ) as $taxonomy )
			{
				add_admin_menu( $this->namespace , array(
					'title'			=>	riake( 'taxonomy-list-label' , $taxonomy , sprintf( __( '%s list' ) , riake( 'namespace' , $taxonomy ) ) ), 
					'href'			=>	get_instance()->url->site_url( array( 'admin' , 'posttype' , $this->namespace , 'taxonomy' , riake( 'namespace' , $taxonomy ) , 'list' ) ),
				) );
				
				add_admin_menu( $this->namespace , array(
					'title'			=>	riake( 'new-taxonomy-label' , $taxonomy , sprintf( __( 'New %s' ) , riake( 'namespace' , $taxonomy ) ) ), 
					'href'			=>	get_instance()->url->site_url( array( 'admin' , 'posttype' , $this->namespace , 'taxonomy' , riake( 'namespace' , $taxonomy ) , 'new' ) ),
				) );
			}
		}
	}
	
	/**
	 * Define taxonomy for post type
	**/
	
	function define_taxonomy( $namespace , $title , $config = array() )
	{
		return $this->query->define_taxonomy( $namespace , $title , $config );
	}
	
	/**
	 * Set Taxonomy for post type.
	 * Use before run.
	 *
	**/
	
	function set_taxonomy( $namespace ,	$title , $content , $parent_id = null )
	{
		return $this->query->set_taxonomy( $namespace ,	$title , $content , $parent_id );
	}
	
	/**
	 * Save Post type to database
	 * 
	 * @access	:	Public
	 * @params	:	String (title) , String (Content) , String (Status) 
	 * @return	:	String (Post status)
	**/
	
	function set( $title , $content , $meta , $taxonomies , $mode = 'set' )
	{
		return $this->query->set( $title , $content , $meta , $taxonomies , $mode = 'set' );
	}
	
	/**
	 * Update Post type to database
	 * 
	 * @access	:	Public
	 * @params	:	String (title) , String (Content) , String (Status) 
	 * @return	:	String (Post status)
	**/
	
	function update( $title , $content , $status = 'publish' , $id = 0 )
	{
		return $this->query->set( $title , $content , array() , array() , $mode = 'edit' , $id );
	}
	
	/**
	 * get post from database. is CustomQuery::get alias
	 * 
	 * @access	:	Public
	 * @params	:	Array 
	 * @return	:	Multiform
	**/
	
	function get( $config = array() )
	{
		return $this->query->get( $config );
	}
}