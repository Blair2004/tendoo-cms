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
	'namespace'	=>		$post_namespace . '-edit-new',
	'col_id'		=>		1
) );

$this->gui->add_meta( array(
	'type'		=>		'box',
	'title'		=>		__( 'Details' ),
	'namespace'	=>		$post_namespace . '-edit-new-sidebar',
	'col_id'		=>		2
) );

$this->events->do_action( 'before_post_title' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

if( in_array( 'title' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	$this->gui->add_item( array(
		'type'			=>		'text',
		'name'			=>		'post_title',
		'value'			=>		riake( 'TITLE' , $post ),
		'placeholder'	=>		__( 'Enter a title' )
	) , $post_namespace . '-edit-new' , 1 );
}

$this->events->do_action( 'after_post_title' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

$this->events->do_action( 'before_post_editor' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

if( in_array( 'editor' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	$this->gui->add_item( array(
		'type'			=>		'editor',
		'name'			=>		'post_content',
		'value'			=>		riake( 'CONTENT' , $post ),
	) , $post_namespace . '-edit-new' , 1 );
}

$this->events->do_action( 'after_post_editor' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

$this->events->do_action( 'before_post_publish' , array( $current_posttype , $this->gui , $post_namespace . '-create-new-sidebar' , $post ) ); // Trigger each event bound

if( in_array( 'publish' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	if( $defined_taxonomies	=	$current_posttype->query->get_defined_taxonomies() )
	{
		foreach( force_array( $defined_taxonomies ) as $tax_namespace	=> $_taxonomy )
		{
			//current_posttype
			$taxonomy_array	=	array();
			$taxonomies_list	=	$current_posttype->query->get_taxonomies( $tax_namespace );
			
			foreach( force_array( $taxonomies_list ) as $_taxonomy )
			{
				$taxonomy_array[ riake( 'ID' , $_taxonomy ) ]	=	riake( 'TITLE' , $_taxonomy );
			}
			
			$this->gui->add_item( array( 
				'type'			=>		'multiple',
				'name'			=>		'post_taxonomy['. $tax_namespace.'][]',
				'text'			=>		$taxonomy_text,
				'value'			=>		$taxonomy_value,
				'label'			=>		__( 'Select a taxonomy' ),
				'active'		=>		riake( 'TAXONOMIES' , $post )
			) , $post_namespace . '-edit-new-sidebar' , 2 );
		}	
	}
	
	$this->gui->add_item( array(
		'type'			=>		'select',
		'name'			=>		'post_status',
		'options'		=>		array( __( 'Draft' ) , __( 'Publish' ) ),
		'label'			=>		__( 'Status' ),
		'active'		=>		riake( 'STATUS' , $post )
	) , $post_namespace . '-edit-new-sidebar' , 2 );
	
	if( riake( 'is-hierarchical' , $current_posttype->get_config() ) == true )
	{
		// get common post list
		$post_legacy		=	$current_posttype->query->get_post_legacy( riake( 'QUERY_ID' , $post ) );
		
		$legacy_statement	=	array();
		foreach( force_array( $post_legacy ) as $_legacy )
		{
			$legacy_statement[ 'where' ][]	=	array( 'ID !=' => $_legacy );
		}
		// var_dump( $legacy_statement );die;
		
		$postlist		=	$current_posttype->get( $legacy_statement );
		$postarray		=	array( -1 => __( 'No parent' ) );
		
		foreach( force_array( $postlist ) as $_post )
		{
			// disable current element to be selected as parent.
			if( $_post[ 'QUERY_ID' ] != riake( 'QUERY_ID' , $post ) )
			{
				$postarray[ riake( 'QUERY_ID' , $_post ) ]	=	riake( 'TITLE' , $_post );
			}
		}

		$this->gui->add_item( array(
			'type'			=>		'select',
			'name'			=>		'post_parent',
			'options'		=>		$postarray,
			'active'			=>		riake( 'PARENT_REF_ID' , $post ),
			'placeholder'	=>		__( 'Choose a parent' ),
			'label'			=>		__( 'Select Parent' )
		) , $post_namespace . '-edit-new-sidebar' , 2 );
	}
}

$this->events->do_action( 'after_post_publish' , array( $current_posttype , $this->gui , $post_namespace . '-create-new-sidebar' , $post ) ); // Trigger each event bound

$this->gui->add_item( array(
	'type'			=>		'buttons',
	'name'			=>		array( 'submit_content' ),
	'value'			=>		array( __( 'Submit'  ) ),
	'buttons_types'	=>		array( 'submit' )
) , $post_namespace . '-edit-new-sidebar' , 2 );


$this->gui->output();