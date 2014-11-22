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

$roles				=	array( '' , 'USER' );
$text				=	array( __( 'Choose...' ) , __( 'User' ) );

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

$this->gui->get();

return;
?>