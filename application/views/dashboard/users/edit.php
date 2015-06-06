<?php
/**
 * 	File Name 	: 	create.php
 *	Description :	file for user creation form
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 2 );

$this->gui->add_meta( array(
	'col_id'	=>	1,
	'namespace'	=>	'edit_user',
	'gui_saver'	=>	true,
	'custom'	=>	array(
		'action'	=>	false
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
	'value'			=>	riake( 'user_name' , $user )
) , 'edit_user' , 1 );

// User email

$this->gui->add_item( array(
	'type'			=>	'text',
	'label'			=>	__( 'User Email' ),
	'name'			=>	'user_email',
	'description'	=>	__( 'Descrption' ),
	'value'			=>	riake( 'user_email' , $user )
) , 'edit_user' , 1 );

// user password

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'New Password' ),
	'name'			=>	'password',
	'description'	=>	__( 'Descrption' )
) , 'edit_user' , 1 );

// user password config

$this->gui->add_item( array(
	'type'			=>	'password',
	'label'			=>	__( 'Confirm New' ),
	'name'			=>	'confirm',
	'description'	=>	__( 'Descrption' )
) , 'edit_user' , 1 );

// Activate

$this->gui->add_item( array(
	'type'			=>	'select',
	'label'			=>	__( 'Activate user ?' ),
	'name'			=>	'activate',
	'options'		=>	array(
		'no'		=>	__( 'No' ),
		'yes'		=>	__( 'Yes' )
	),
	'active'		=>	riake( 'active' , $user ) == '1' ? 'yes' : 'no'
) , 'edit_user' , 1 );

// add to a group

$groups_array	=	array();

foreach( $groups->result_array() as $group )
{
	$groups_array[ riake( 'group_id' , $group ) ] = riake( 'group_name' , $group );
}

$this->gui->add_item( array(
	'type'			=>	'select',
	'label'			=>	__( 'Add to a group' ),
	'name'			=>	'userprivilege',
	'options'		=>	$groups_array,
	'active'		=>	riake( 'group_id' , $user )
) , 'edit_user' , 1 );

// load custom field for user creatin

$this->events->do_action( 'load_users_custom_fields' , array(
	'mode'			=>	'edit', 
	'groups'		=>	$groups_array,
	'meta_namespace'=>	'edit_user',
	'col_id'		=>	1,
	'gui'			=>	$this->gui,
	'user_id'		=>	riake( 'user_id' , $user )
) );

$this->gui->output();