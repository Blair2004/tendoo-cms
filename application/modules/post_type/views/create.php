<?php
// var_dump( get_core_vars( 'posttypes' ) );

$this->gui->col_width( 1 , 3 );

$this->gui->col_width( 2 , 1 );

$this->events->add_filter( 'gui_before_cols' , function(){
	return '<form method="post">';
});

$this->events->add_filter( 'gui_after_cols' , function(){
	return '</form>';
});

$this->gui->add_meta( array(
	'type'		=>		'unwrapped',
	'namespace'	=>		$post_namespace . '-create-new',
	'col_id'		=>		1,
	'gui_saver'	=>		false
) );

$this->gui->add_meta( array(
	'type'		=>		'box',
	'title'		=>		__( 'Details' ),
	'namespace'	=>		$post_namespace . '-create-new-sidebar',
	'col_id'		=>		2,
	'gui_saver'	=>		false
) );

$this->events->do_action( 'before_post_title' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' ) ); // Trigger each event bound

if( in_array( 'title' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	$this->gui->add_item( array(
		'type'			=>		'text',
		'name'			=>		'post_title',
		'placeholder'	=>		__( 'Enter a title' )
	) , $post_namespace . '-create-new' , 1 );
}

$this->events->do_action( 'after_post_title' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' ) ); // Trigger each event bound

$this->events->do_action( 'before_post_editor' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' ) ); // Trigger each event bound

if( in_array( 'editor' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	$this->gui->add_item( array(
		'type'			=>		'textarea',
		'name'			=>		'post_content'
	) , $post_namespace . '-create-new' , 1 );
}

$this->events->do_action( 'after_post_editor' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' ) ); // Trigger each event bound



$this->events->do_action( 'before_post_publish' , array( $current_posttype , $this->gui , $post_namespace . '-create-new-sidebar' ) ); // Trigger each event bound

if( in_array( 'publish' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	if( $defined_taxonomies	=	$current_posttype->query->get_defined_taxonomies() )
	{
		foreach( force_array( $defined_taxonomies ) as $tax_namespace	=> $_taxonomy )
		{
			//current_posttype
			$taxonomy_array 	=	array();
			$taxonomies_list	=	$current_posttype->query->get_taxonomies( $tax_namespace );
			
			foreach( force_array( $taxonomies_list ) as $_taxonomy )
			{
				$taxonomy_array[ riake( 'ID' , $_taxonomy ) ]	=	riake( 'TITLE' , $_taxonomy );
			}
			
			$this->gui->add_item( array( 
				'type'			=>		'multiple',
				'name'			=>		'post_taxonomy['. $tax_namespace.'][]',
				'options'		=>		$taxonomy_array,
				'label'			=>		__( 'Select a taxonomy' )
			) , $post_namespace . '-create-new-sidebar' , 2 );
		}	
	}
	
	$this->gui->add_item( array(
		'type'			=>		'select',
		'name'			=>		'post_status',
		'options'		=>		array( __( 'Draft' ) , __( 'Publish' ) ),
		'label'			=>		__( 'Status' )
	) , $post_namespace . '-create-new-sidebar' , 2 );
	
	// is hierarchical
	
	if( riake( 'is-hierarchical' , $current_posttype->get_config() ) == true )
	{
		// get common post list
		$postlist		=	$current_posttype->get();
		$postarray		=	array( -1 => __( 'No parent' ) );
		
		foreach( force_array( $postlist ) as $_post )
		{
			$postarray[ riake( 'QUERY_ID' , $_post ) ]	=	riake( 'TITLE' , $_post );
		}

		$this->gui->add_item( array(
			'type'			=>		'select',
			'name'			=>		'post_parent',
			'options'		=>		$postarray,
			'placeholder'	=>		__( 'Choose a parent' ),
			'label'			=>		__( 'Select Parent' )
		) , $post_namespace . '-create-new-sidebar' , 2 );
	}
}

$this->gui->add_item( array(
	'type'			=>		'buttons',
	'name'			=>		array( 'submit_content' ),
	'value'			=>		array( __( 'Submit' ) ),
	'buttons_types'	=>		array( 'submit' )
) , $post_namespace . '-create-new-sidebar' , 2 );

// $this->events->do_action( 'after_post_publish' , array( $current_posttype , $this->gui , $post_namespace . '-create-new-sidebar' ) ); // Trigger each event bound



$this->gui->output();