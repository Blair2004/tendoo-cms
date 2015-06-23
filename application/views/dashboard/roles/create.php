<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 3 );

// Creating Meta
$this->gui->add_meta( array(
	'type'		=>	'box',
	'title'		=>	__( 'Create a new role' ),
	'namespace'	=>	'create_role',
	'col_id'	=>	1,
	'footer'		=>	array(
		'submit'	=>	array(
			'label'	=>	__( 'Create the role' )
		)
	), 
	'gui_saver'	=>	true,
	'custom'	=>	array(
		'action'	=>	null
	)
) );

// Adding Fields
$this->gui->add_item( array(
	'type'			=>	'text',
	'name'			=>	'role_name',
	'description'	=>	__( 'Enter role name' ),
	'label'			=>	__( 'Role Name' ),
	'placeholder'	=>	__( 'Role Name' )
) , 'create_role' , 1 );

// Is it an admin group ?
$this->gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'role_type',
	'options'	=>	array(
		'public'	=>	__( 'Public' ),
		'admin'		=>	__( 'Admin' )
	),
	'label'			=>	__( 'Role Type' ),
	'placeholder'	=>	__( 'Role Type' )
) , 'create_role' , 1 );

// Group definition
$this->gui->add_item( array(
	'type'		=>	'textarea',
	'name'		=>	'role_definition',
	'description'	=>	__( 'Enter role description' ),
	'label'		=>	__( 'Role Description' ),
	'placeholder'	=>	__( 'Role Description' )
) , 'create_role' , 1 );

$this->gui->output();