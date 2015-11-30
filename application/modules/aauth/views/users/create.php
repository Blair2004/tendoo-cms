<?php
/**
 * 	File Name 	: 	create.php
 *	Description :	file for user creation form
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 2 );

$this->gui->add_meta( array(
	'col_id'	=>	1,
	'namespace'	=>	'create_user',
	'gui_saver'	=>	true,
	'custom'	=>	array(
		'action'	=>	''
	),
	'footer'	=>	array(
		'submit'	=>	array(
			'label'	=>	__( 'Create User' )
		)
	)
) );

// User name

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Name' ),
	'name'			=>	'username',
) , 'create_user' , 1 );

// User email

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Email' ),
	'name'			=>	'user_email',
) , 'create_user' , 1 );

// user password

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'Password' ),
	'name'			=>	'password',
) , 'create_user' , 1 );

// user password config

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'Confirm' ),
	'name'			=>	'confirm',
) , 'create_user' , 1 );

// add to a group

$groups_array	=	array();

foreach( $groups as $group )
{
	$groups_array[ $group->id ] = $group->name;
}

$this->gui->add_item( array(
	'type'			=>	'select',
	'label'			=>	__( 'Add to a group' ),
	'name'			=>	'userprivilege',
	'options'		=>	$groups_array
) , 'create_user' , 1 );

// load custom field for user creatin

$this->events->do_action( 'load_users_custom_fields' , array(
	'mode'			=>	'create', 
	'groups'		=>	$groups_array,
	'meta_namespace'=>	'create_user',
	'col_id'		=>	1,
	'gui'			=>	$this->gui
) );

$this->gui->output();