<?php
/**
 * 	File Name 	: 	create.php
 *	Description :	file for user creation form
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 2 );

$this->gui->add_meta( array(
	'col_id'	=>	1,
	'namespace'	=>	'user_profile',
	'gui_saver'	=>	true,
	'custom'	=>	array(
		'action'	=>	''
	),
	'footer'	=>	array(
		'submit'	=>	array(
			'label'	=>	__( 'Edit User' )
		)
	)
) );

// User name

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Name' ),
	'name'			=>	'username',
	'description'	=>	__( 'Descrption' ),
	'disabled'		=>	true,
	'value'			=>	$this->users->current->name
) , 'user_profile' , 1 );

// User email

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Email' ),
	'name'			=>	'user_email',
	'description'	=>	__( 'Descrption' ),
	'value'			=>	$this->users->current->email
) , 'user_profile' , 1 );

// user password

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'Old Password' ),
	'name'			=>	'old_pass',
	'description'	=>	__( 'Descrption' )
) , 'user_profile' , 1 );

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'New Password' ),
	'name'			=>	'password',
	'description'	=>	__( 'Descrption' )
) , 'user_profile' , 1 );

// user password config

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'Confirm New' ),
	'name'			=>	'confirm',
	'description'	=>	__( 'Descrption' )
) , 'user_profile' , 1 );

// add to a group

// load custom field for user creatin

$this->events->do_action( 'load_users_custom_fields' , array(
	'mode'			=>	'profile', 
	'groups'		=>	array(),
	'meta_namespace'=>	'user_profile',
	'col_id'		=>	1,
	'gui'			=>	$this->gui,
	'user_id'		=>	$this->users->current->id
) );

$this->gui->output();