<?php
$this->gui->cols_width( 1 , 3 );
$this->gui->cols_width( 2 , 1 );

$this->gui->set_meta( array(
	'namespace'			=>		core_meta_namespace( array( 'roles', 'create' ) ),
	'title'				=>		__( 'Create a new role' ),
	'type'				=>		'panel',
	'form_wrap'			=>		array(
		'method'		=>		'post',
		'submit_text'	=>		__( 'Create Role' )
	)
) )->push_to( 1 );

// Creating Form

$this->gui->set_item( array(
	'type'				=>		'text', 
	'name'				=>		'priv_name',
	'description'		=>		__( 'Set unique name to identify this role.' ),
	'label'				=>		__( 'Role name' ),
	'placeholder'		=>		__( 'Role name' ),
) )->push_to( core_meta_namespace( array( 'roles' , 'create' ) ) );

$this->gui->set_item( array(
	'type'				=>		'select', 
	'name'				=>		'is_selectable',
	'description'		=>		__( 'Set to yes will makes this role will available for registration.' ),
	'label'				=>		__( 'Available for registration ?' ),
	'placeholder'		=>		__( 'Choose' ),
	'value'				=>		array( 0 , 1 ),
	'text'				=>		array( __( 'No' ) , __( 'Yes' ) )
) )->push_to( core_meta_namespace( array( 'roles' , 'create' ) ) );

$this->gui->set_item( array(
	'type'				=>		'textarea', 
	'name'				=>		'priv_description',
	'description'		=>		__( 'Describe this role. The reason why you\'re creating this role.' ),
	'label'				=>		__( 'Description' ),
	'placeholder'		=>		__( 'Description' ),
) )->push_to( core_meta_namespace( array( 'roles' , 'create' ) ) );

$this->gui->get();
