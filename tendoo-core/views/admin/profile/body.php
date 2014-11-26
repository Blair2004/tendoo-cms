<?php
$this->gui->cols_width( 1 , 3 );
$this->gui->cols_width( 2 , 1 );

$this->gui->set_meta( array( 
	'namespace'	=>	core_meta_namespace( array( 'users', 'profile' ) ) , 
	'title'		=>	__( 'Users Names' ) , 
	'type'		=>	'panel',
	'form_wrap'	=>	array(
		'method'	=>	'post',
		'submit_text'	=>	__( 'Edit profile' ),
		'enctype'		=>	'multipart/form-data'
	)
) )->push_to( 1 );

$this->gui->set_meta( array( 
	'namespace'	=>	core_meta_namespace( array( 'users', 'advanced' ) ) , 
	'title'		=>	__( 'Advanced Settings' ) , 
	'type'		=>	'panel',
	'form_wrap'	=>	array(
		'method'	=>	'post',
		'submit_text'	=>	__( 'Save Advanced settings' ),
		'enctype'		=>	'multipart/form-data'
	)
) )->push_to( 1 );

// User Profile

$this->gui->set_item( array(
	'type'		=>	'text',
	'name'		=>	'user_name',
	'label'		=>	__( 'User Name' ),
	'placeholder'	=>	__( 'Enter User Name' ),
	'value'		=>	current_user( 'name' )
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

$this->gui->set_item( array(
	'type'		=>	'text',
	'name'		=>	'user_surname',
	'label'		=>	__( 'User Surname' ),
	'placeholder'	=>	__( 'Enter User Surname' ),
	'value'		=>	current_user( 'surname' )
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

$this->gui->set_item( array(
	'type'		=>	'text',
	'name'		=>	'user_state',
	'label'		=>	__( 'User State' ),
	'placeholder'	=>	__( 'Enter User State' ),
	'value'		=>	current_user( 'state' )
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

$this->gui->set_item( array(
	'type'		=>	'text',
	'name'		=>	'user_town',
	'label'		=>	__( 'User City' ),
	'placeholder'	=>	__( 'Enter User City' ),
	'value'		=>	current_user( 'city' )
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

$this->gui->set_item( array(
	'type'		=>	'file',
	'name'		=>	'avatar_file',
	'label'		=>	__( 'User Avatar' ),
	'description'	=>	__( 'Avatar pics should not exceed 300px on height and width' )
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

$this->gui->set_item( array(
	'type'		=>	'textarea',
	'name'		=>	'bio',
	'label'		=>	__( 'More about you' ),
	'description'	=>	__( 'provide more information about you in this field. It may be used by themes.' ),
	'value'		=>	current_user( 'bio' )
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

$this->gui->set_item( array(
	'type'		=>	'hidden',
	'name'		=>	'avatar_usage',
	'value'		=>	'system',
) )->push_to( core_meta_namespace( array( 'users', 'profile' ) ) );

// Advanced Settings

$themes			=	array( __( 'Inverse Theme' ) , __( 'Bubble Showcase' ) , __( 'Green Day' ) , __( 'Red Horn' ) , __( 'Selective Orange' ) , __( 'Skies' ) , __( 'Blurry' ) );
$values			=	array_keys( $themes );

$this->gui->set_item( array(
	'type'		=>	'select',
	'name'		=>	'dashboard_theme',
	'value'		=>	$values,
	'text'		=>	$themes,
	'active'	=>	current_user( 'dashboard_theme' ),
	'label'		=>	__( 'Dashboard Theme' ),
) )->push_to( core_meta_namespace( array( 'users', 'advanced' ) ) );

$this->gui->set_item( array(
	'type'		=>	'password',
	'name'		=>	'user_oldpass',
	'label'		=>	__( 'Old password' ),
	'description'	=>	__( 'To change a password, you must enter the previous password.' ),
) )->push_to( core_meta_namespace( array( 'users', 'advanced' ) ) );

$this->gui->set_item( array(
	'type'		=>	'password',
	'name'		=>	'user_newpass',
	'label'		=>	__( 'New password' ),
	'description'	=>	__( 'It should be different from the previous one.' ),
) )->push_to( core_meta_namespace( array( 'users', 'advanced' ) ) );

$this->gui->set_item( array(
	'type'		=>	'password',
	'name'		=>	'user_confirmnewpass',
	'label'		=>	__( 'Confirm password' ),
	'description'	=>	__( 'It should match the new password.' ),
) )->push_to( core_meta_namespace( array( 'users', 'advanced' ) ) );

$this->gui->get();