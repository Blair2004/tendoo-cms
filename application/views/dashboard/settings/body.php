<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 2 );

$this->gui->add_meta( array(
	'type'		=>	'box-primary',
	'title'		=>	__( 'General Settings' ),
	'namespace'	=>	'mybox',
	'col_id'	=>	1, // required,
	'gui_saver'	=>	true, // use tendoo option saver
	'footer'	=>	array(
		'submit'	=>	array(
			'label'	=>	__( 'Save Settings' )
		)
	),
	'use_namespace'	=>	false
) );

$this->gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'site-name',
	'label'		=>	__( 'Site Name' ),
	'placeholder'	=>	__( 'Enter your site name' )
) , 'mybox' , 1 );

$this->gui->add_item( array(
	'type'		=>	'textarea',
	'name'		=>	'site-description',
	'label'		=>	__( 'Site Description' ),
	'placeholder'	=>	__( 'Enter your site description' )
) , 'mybox' , 1 );

$this->gui->add_item( array(
	'type'			=>	'select',
	'name'			=>	'site-timezone',
	'label'			=>	__( 'Timezone' ),
	'placeholder'	=>	__( 'Enter your site timezone' ),
	'options'		=>	$this->config->item( 'site-timezone' )
) , 'mybox' , 1 );

$this->events->do_action( 'register_general_settings_fields' );

$this->gui->output();