<?php
$this->gui->cols_width( 1 , 3 );
$this->gui->cols_width( 2 , 1 );
$this->gui->config( 'before_cols' , '<form method="post">' );
$this->gui->config( 'after_cols' , '</form>' );

$this->gui->set_meta( array(
	'type'		=>		'unwrapped',
	'namespace'	=>		$taxonomy_namespace . '-create-new'
) )->push_to( 1 );

$this->gui->set_meta( array(
	'type'				=>		'panel',
	'title'				=>		__( 'Details' ),
	'namespace'			=>		$taxonomy_namespace . '-create-new-sidebar'
) )->push_to( 2 );

$this->gui->set_item( array(
	'type'				=>		'text',
	'name'				=>		'taxonomy_title',
	'placeholder'		=>		__( 'Enter a title' ),
	'value'				=>		riake( 'TITLE' , $get_taxonomy )
) )->push_to( $taxonomy_namespace . '-create-new' );

if( riake( 'is_hierarchical' , riake( $taxonomy_namespace , $taxonomy ) ) === true )
{
	$taxonomies			=	$current_posttype->query->get_taxonomies( $taxonomy_namespace , $taxonomy_id , 'as_excluded_id' );
	$taxonomies_id		=	array();
	$taxonomies_title	=	array();
	
	foreach( $taxonomies as $_taxonomy )
	{
		$taxonomies_id[]	=	riake( 'ID' , $_taxonomy );
		$taxonomies_title[]	=	riake( 'TITLE' , $_taxonomy );
	}
	
	$this->gui->set_item( array(
		'type'			=>		'select',
		'text'			=>		$taxonomies_title,
		'value'			=>		$taxonomies_id,
		'label'			=>		__( 'Select a parent' ),
		'name'			=>		'taxonomy_parent',
		'placeholder'	=>		__( 'Select a parent' ),
		'active'		=>		riake( 'PARENT_REF_ID' , $get_taxonomy )
	) )->push_to( $taxonomy_namespace . '-create-new' );
}

$this->gui->set_item( array(
	'type'			=>		'textarea',
	'name'			=>		'taxonomy_content',
	'value'			=>		riake( 'CONTENT' , $get_taxonomy ),
	'label'			=>		__( 'Taxonomy description' )
) )->push_to( $taxonomy_namespace . '-create-new' );

$this->gui->set_item( array(
	'type'			=>		'buttons',
	'name'			=>		array( 'submit_content' ),
	'value'			=>		array( __( 'Submit'  ) ),
	'buttons_types'	=>		array( 'submit' )
) )->push_to( $taxonomy_namespace . '-create-new-sidebar' );


$this->gui->get();