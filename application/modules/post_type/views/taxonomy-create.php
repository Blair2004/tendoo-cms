<?php

$this->Gui->col_width( 1 , 3 );
$this->Gui->col_width( 2 , 1 );

$this->events->add_filter( 'gui_before_cols' , function(){
	return '<form method="post">' ;
});
$this->events->add_filter( 'gui_after_cols' , function(){
	return '</form>'; 
});

$this->Gui->add_meta( array(
	'type'		=>		'unwrapped',
	'namespace'	=>		$taxonomy_namespace . '-create-new',
	'col_id'		=>		1
) );

$this->Gui->add_meta( array(
	'type'				=>		'panel',
	'title'				=>		__( 'Details' ),
	'namespace'			=>		$taxonomy_namespace . '-create-new-sidebar',
	'col_id'				=>		2
) );

$this->Gui->add_item( array(
	'type'				=>		'text',
	'name'				=>		'taxonomy_title',
	'placeholder'		=>		__( 'Enter a title' )
) , $taxonomy_namespace . '-create-new' , 1 );

if( riake( 'is_hierarchical' , riake( $taxonomy_namespace , $taxonomy ) ) === true )
{
	$taxonomies			=	$current_posttype->query->get_taxonomies( $taxonomy_namespace );
	$taxonomies_array		=	array();
	$taxonomies_title	=	array();
	
	foreach( $taxonomies as $_taxonomy )
	{
		$taxonomies_array[ riake( 'ID' , $_taxonomy ) ]	=	riake( 'TITLE' , $_taxonomy );
	}
	
	$this->Gui->add_item( array(
		'type'			=>		'select',
		'options'			=>		$taxonomies_title,
		'label'			=>		__( 'Select a parent' ),
		'name'			=>		'taxonomy_parent',
		'placeholder'	=>		__( 'Select a parent' )
	) , $taxonomy_namespace . '-create-new' , 1 );
}

$this->Gui->add_item( array(
	'type'			=>		'textarea',
	'name'			=>		'taxonomy_content',
	'label'			=>		__( 'Taxonomy description' )
) , $taxonomy_namespace . '-create-new' , 1 );

$this->Gui->add_item( array(
	'type'			=>		'buttons',
	'name'			=>		array( 'submit_content' ),
	'value'			=>		array( __( 'Submit'  ) ),
	'buttons_types'	=>		array( 'submit' )
) , $taxonomy_namespace . '-create-new-sidebar' , 2 );


$this->Gui->output();