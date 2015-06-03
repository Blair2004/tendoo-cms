<?php
// var_dump( get_core_vars( 'posttypes' ) );

$this->gui->cols_width( 1 , 3 );

$this->gui->cols_width( 2 , 1 );

$this->gui->config( 'before_cols' , '<form method="post">' );
$this->gui->config( 'after_cols' , '</form>' );

$this->gui->set_meta( array(
	'type'		=>		'unwrapped',
	'namespace'	=>		$post_namespace . '-edit-new'
) )->push_to( 1 );

$this->gui->set_meta( array(
	'type'		=>		'panel',
	'title'		=>		__( 'Details' ),
	'namespace'	=>		$post_namespace . '-edit-new-sidebar'
) )->push_to( 2 );

trigger_events( 'before_post_title' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

if( in_array( 'title' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	$this->gui->set_item( array(
		'type'			=>		'text',
		'name'			=>		'post_title',
		'value'			=>		riake( 'TITLE' , $post ),
		'placeholder'	=>		__( 'Enter a title' )
	) )->push_to( $post_namespace . '-edit-new' );
}

trigger_events( 'after_post_title' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

trigger_events( 'before_post_editor' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

if( in_array( 'editor' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	$this->gui->set_item( array(
		'type'			=>		'visual_editor',
		'name'			=>		'post_content',
		'value'			=>		riake( 'CONTENT' , $post ),
	) )->push_to( $post_namespace . '-edit-new' );
}

trigger_events( 'after_post_editor' , array( $current_posttype , $this->gui , $post_namespace . '-create-new' , $post ) ); // Trigger each event bound

trigger_events( 'before_post_publish' , array( $current_posttype , $this->gui , $post_namespace . '-create-new-sidebar' , $post ) ); // Trigger each event bound

if( in_array( 'publish' , riake( 'displays' , $current_posttype->get_config() ) ) )
{
	if( $defined_taxonomies	=	$current_posttype->query->get_defined_taxonomies() )
	{
		foreach( force_array( $defined_taxonomies ) as $tax_namespace	=> $_taxonomy )
		{
			//current_posttype
			$taxonomy_text		=	$taxonomy_value	=	array();
			$taxonomies_list	=	$current_posttype->query->get_taxonomies( $tax_namespace );
			
			foreach( force_array( $taxonomies_list ) as $_taxonomy )
			{
				$taxonomy_text[]	=	riake( 'TITLE' , $_taxonomy );
				$taxonomy_value[]	=	riake( 'ID' , $_taxonomy );
			}
			
			$this->gui->set_item( array( 
				'type'			=>		'multiple',
				'name'			=>		'post_taxonomy['. $tax_namespace.'][]',
				'text'			=>		$taxonomy_text,
				'value'			=>		$taxonomy_value,
				'label'			=>		__( 'Select a taxonomy' ),
				'active'		=>		riake( 'TAXONOMIES' , $post )
			) )->push_to( $post_namespace . '-edit-new-sidebar' );
		}	
	}
	
	$this->gui->set_item( array(
		'type'			=>		'select',
		'name'			=>		'post_status',
		'text'			=>		array( __( 'Draft' ) , __( 'Publish' ) ),
		'value'			=>		array( 0 , 1 ),
		'label'			=>		__( 'Status' ),
		'active'		=>		riake( 'STATUS' , $post )
	) )->push_to( $post_namespace . '-edit-new-sidebar' );
	
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
		$postarray		=	array();
		$posttitle		=	array();
		
		foreach( force_array( $postlist ) as $_post )
		{
			$postarray[]	=	riake( 'QUERY_ID' , $_post );
			$posttitle[]	=	riake( 'TITLE' , $_post );
		}

		$this->gui->set_item( array(
			'type'			=>		'select',
			'name'			=>		'post_parent',
			'text'			=>		$posttitle,
			'value'			=>		$postarray,
			'active'		=>		riake( 'PARENT_REF_ID' , $post ),
			'placeholder'	=>		__( 'Choose a parent' ),
			'label'			=>		__( 'Seleect Parent' )
		) )->push_to( $post_namespace . '-edit-new-sidebar' );
	}
}

trigger_events( 'after_post_publish' , array( $current_posttype , $this->gui , $post_namespace . '-create-new-sidebar' , $post ) ); // Trigger each event bound

$this->gui->set_item( array(
	'type'			=>		'buttons',
	'name'			=>		array( 'submit_content' ),
	'value'			=>		array( __( 'Submit'  ) ),
	'buttons_types'	=>		array( 'submit' )
) )->push_to( $post_namespace . '-edit-new-sidebar' );


$this->gui->get();