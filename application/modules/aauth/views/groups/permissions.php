<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 	File Name 	: 	edit.php
 *	Description :	header file for role edition. include <html> tag and ends at </head> closing tag
 *	Since		:	1.5
**/

$this->gui->col_width( 1 , 3 );

// Creating Meta
$this->gui->add_meta( array(
	'type'		=>	'box',
	'title'		=>	__( 'Groups permissions' ),
	'namespace'	=>	'permissions',
	'col_id'	=>	1,
	'footer'		=>	array(
		'submit'	=>	array(
			'label'	=>	__( 'Edit the role' )
		)
	), 
	'gui_saver'	=>	true,
	'custom'	=>	array(
		'action'	=>	null
	)
) );

$this->gui->output();