<?php
$this->gui->cols_width( 1 , 4 );
$this->gui->set_meta( array(
	'namespace'		=>	core_meta_namespace( array( 'users' , 'edit' ) ) , 
	'title'			=>	__( 'Edit user' ), 
	'type'			=>	'panel',
	'form_wrap'		=>	array(
		'method'	=>	'POST'
	)
) )->push_to( 1 );

$this->gui->set_item( array(
	'type'			=>	'text',
	'attrs'			=>	array( 'readonly' => 'readonly' ),
	'value'			=>	$adminInfo['PSEUDO'],
	'placeholder'	=>	__( 'User Pseudo' ),
	'label'			=>	__( 'User Pseudo' )
) )->push_to( core_meta_namespace( array( 'users' , 'edit' ) ) );

$this->gui->set_item( array(
	'type'			=>	'text',
	'name'			=>	'user_email',
	'placeholder'	=>	__( 'Enter Email' ),
	'text'			=>	__( 'User Email' ),
	'label'			=>	__( 'User Email' ),
	'value'			=>	$adminInfo['EMAIL']
) )->push_to( core_meta_namespace( array( 'users' , 'edit' ) ) );

// Get Roles
$text[]				=	__( 'User Role' );
$value[]			=	'';
foreach( force_array( $get_roles ) as $_role )
{
	$value[]		=	riake( 'ID' , $_role );
	$text[]			=	riake( 'NAME' , $_role );
}

$this->gui->set_item( array(
	'type'			=>	'select',
	'name'			=>	'edit_priv',
	'value'			=>	$value,
	'placeholder'	=>	__( 'Select User Role' ),
	'text'			=>	$text,
	'active'		=>	$adminInfo['REF_ROLE_ID'],
	'label'			=>	__( 'User Role' )
) )->push_to( core_meta_namespace( array( 'users' , 'edit' ) ) );

$this->gui->set_item( array(
	'type'			=>	'hidden',
	'name'			=>	'current_admin',
	'value'			=>	$adminInfo['PSEUDO'],
) )->push_to( core_meta_namespace( array( 'users' , 'edit' ) ) );

// Loading Generated Fields using "user_fields" hook

$user_fields		=	trigger_filters( 'user_form_fields' , array( get_core_vars( 'tendoo_user_fields' ) , $adminInfo[ 'ID' ] ) ); // Filter user fields or add

foreach( force_array( $user_fields ) as $field ) {
	$this->gui->set_item( $field )->push_to( core_meta_namespace( array( 'users' , 'edit' ) ) );
}

$this->gui->set_item( array(
	'type'			=>	'buttons',
	'name'			=>	array( 'set_admin' , 'delete_admin' ),
	'value'			=>	array( __( 'Save User' ), __( 'Delete User' ) ),
	'classes'		=>	array( 'btn-primary' , 'btn-warning' ),
	'button_types'	=>	array( 'submit' , 'submit' ),
	'attrs_string'	=>	array( '', 'onclick="return confirm( \'' . __( 'Do you really want to delete this user ?' ) . '\')" ' )
) )->push_to( core_meta_namespace( array( 'users' , 'edit' ) ) );

$this->gui->get();