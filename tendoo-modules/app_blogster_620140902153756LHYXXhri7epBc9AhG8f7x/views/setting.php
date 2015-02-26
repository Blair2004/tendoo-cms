<?php
$this->gui->cols_width( 1 , 3 );

$this->gui->set_meta( array(
	'namespace'		=>	'blogster_settings' , 
	'title'			=>	__( 'Blogster Settings' ) , 
	'type'			=>	'panel',
	'form_wrap'		=>	array(
		'gui_saver'		=>	true,
		'use_namespace'	=>	true,
		'submit_text'	=>	__( 'Save Settings' )
	)
) )->push_to( 1 );

$this->gui->set_item( array(
	'type'			=>	'select',
	'value'			=>	array( 0 , 1 ),
	'placeholder'	=>	__( 'Anyone can post a comment' ),
	'text'			=>	array( __( 'Yes' ) , __( 'No' ) ),
	'name'			=>	'EVERYONEPOST',
	'label'			=>	__( 'Anyone can post a comment ?' ),
	'active'		=>	riake( 'EVERYONEPOST' , $blogster_settings )
) )->push_to( 'blogster_settings' );

$this->gui->set_item( array(
	'type'			=>	'select',
	'value'			=>	array( 0 , 1 ),
	'placeholder'	=>	__( 'Approve comment before publishing' ),
	'text'			=>	array( __( 'Yes' ) , __( 'No' ) ),
	'name'			=>	'APPROVEBEFOREPOST',
	'label'			=>	__( 'Approve comment before publishing' ),
	'active'		=>	riake( 'APPROVEBEFOREPOST' , $blogster_settings )
) )->push_to( 'blogster_settings' );

$this->gui->get();