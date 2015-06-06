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
) );

// User name

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Name' ),
	'name'			=>	'username',
	'description'	=>	__( 'Descrption' )
) , 'create_user' , 1 );

// User email

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Email' ),
	'name'			=>	'user_email',
	'description'	=>	__( 'Descrption' )
) , 'create_user' , 1 );

// user password

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'Password' ),
	'name'			=>	'password',
	'description'	=>	__( 'Descrption' )
) , 'create_user' , 1 );

// user password config

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'Confirm' ),
	'name'			=>	'config',
	'description'	=>	__( 'Descrption' )
) , 'create_user' , 1 );

// Activate

$this->gui->add_item( array(
	'type'			=>	'select',
	'label'			=>	__( 'Activate user ?' ),
	'name'			=>	'username',
	'options'		=>	array(
		'no'		=>	__( 'No' ),
		'yes'		=>	__( 'Yes' )
	)
) , 'create_user' , 1 );

// add to a group

// Group is choosed automatically 
// Give a privilege

$privilege_array	=	array();

foreach( $privileges->result_array() as $privilege )
{
	$privilege_array[ riake( 'privilege_id' , $privilege ) ] = riake( 'privilege_name' , $privilege );
}

$this->gui->add_item( array(
	'type'			=>	'select',
	'label'			=>	__( 'Add a privilege' ),
	'name'			=>	'userprivilege',
	'options'		=>	$privilege_array
) , 'create_user' , 1 );

// load custom field for user creatin

$this->events->do_action( 'load_users_custom_fields' );

$this->gui->output();