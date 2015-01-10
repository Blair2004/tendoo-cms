<?php
$this->gui->cols_width( 1 , 4 );
// Creating Meta
$this->gui->set_meta( array(
	'namespace'		=>	core_meta_namespace( array( 'users' , 'create' ) ),
	'title'			=>	__( 'Create User' ),
	'type'			=>	'panel',
	'form_wrap'		=>	array(
		'method'	=>	'post',
		'submit_text'	=>	__( 'Create user' ),
		'reset_text'	=>	__( 'Reset Form' )
	)
) )->push_to( 1 );

$this->gui->set_meta( array(
	'namespace'		=>	'tips',
	'title'			=>	__( 'How to create a user' ),
	'type'			=>	'panel'
) )->push_to( 2);
// Creating Fields
// Static Fields

$this->gui->set_item( array(
	'type'			=>	'text',
	'name'			=>	'admin_pseudo',
	'placeholder'	=>	__( 'Enter a Username' ),
	'label'			=>	__( 'Username' )	
) )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );

$this->gui->set_item( array(
	'type'			=>	'password',
	'name'			=>	'admin_password',
	'placeholder'	=>	__( 'Password' ),
	'label'			=>	__( 'Enter a password' )	
) )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );

$this->gui->set_item( array(
	'type'			=>	'password',
	'name'			=>	'admin_password_confirm',
	'placeholder'	=>	__( 'Confirm password' ),
	'label'			=>	__( 'Confirm password' )	
) )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );

$this->gui->set_item( array(
	'type'			=>	'text',
	'name'			=>	'admin_password_email',
	'placeholder'	=>	__( 'Email' ),
	'label'			=>	__( 'Enter a user email' )	
) )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );

$this->gui->set_item( array(
	'type'			=>	'select',
	'name'			=>	'admin_sex',
	'placeholder'	=>	__( 'Select user sex' ),
	'value'			=>	array( '' , 'MASC' , 'FEM' ),
	'text'			=>	array( __( 'Choose...' ) , __( 'Male' ) , __( 'Female' ) ),
	'label'			=>	__( 'User Sex' )	
) )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );

$roles				=	array( '' );
$text				=	array( __( 'Choose...' ) );

foreach( force_array( $getPrivs ) as $_role )
{
	$roles[]		=	riake( 'ID' , $_role );
	$text[]			=	riake( 'NAME' , $_role );
}

$this->gui->set_item( array(
	'type'			=>	'select',
	'name'			=>	'admin_privilege',
	'placeholder'	=>	__( 'Select user role' ),
	'value'			=>	$roles,
	'text'			=>	$text,
	'label'			=>	__( 'User role' )	
) )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );

// Loading Generated Fields using "user_form_fields" hook
$user_fields		=	trigger_filters( 'user_form_fields' , array( get_core_vars( 'tendoo_user_fields' ) ) ); // Filter user fields or add

foreach( force_array( $user_fields ) as $field ) {
	$this->gui->set_item( $field )->push_to( core_meta_namespace( array( 'users' , 'create' ) ) );
}

$this->gui->get();