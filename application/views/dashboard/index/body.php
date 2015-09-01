<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 4 );

$this->gui->add_meta( array(
	'col_id'	=>	1,
	'namespace'	=>	'dashboard',
	'type'		=>	'unwrapped'
) );

$this->gui->add_item( array(
	'type'	=>	'dom',
	'content'	=> ''
) , 'dashboard' , 1 );

$this->gui->output();