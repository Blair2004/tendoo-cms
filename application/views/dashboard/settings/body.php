<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->gui->cols_width( 1 , 2 );
$this->gui->cols_width( 2 , 2 );

$this->gui->set_meta( array(
	'namespace'	=>	'settings-tabs',
	'type'		=>	'panel-tabbed',
	'title'		=>	__( 'Custom' )
) )->push_to( 1 );

$this->gui->set_meta( array(
	'namespace'		=>	'custom',
	'type'			=>	'panel',
	'title'			=>	__( 'Tab 1' )
) )->push_to( 'settings-tabs' );

$this->gui->set_meta( array(
	'namespace'		=>	'costo',
	'type'			=>	'panel',
	'title'			=>	__( 'Tab 2' )
) )->push_to( 'settings-tabs' );

die;

$this->gui->get();