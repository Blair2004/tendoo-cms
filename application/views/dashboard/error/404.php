<?php
/**
 * 	File Name 	: 	404.php
 *	Description :	Displays dashboard internal 404 page error
 *	Since		:	1.5
**/

$this->gui->cols_width( 1 , 4 );

// creating unique meta
$this->gui->set_meta( array(
	'namespace'		=>		'error-body',
	'type'			=>		'unwrapped'
) )->push_to( 1 );

// creating meta item
$this->gui->set_item( array(
	'type'			=>		'dom',
	'value'			=>		tendoo_error( 'This page doesn\'t exists.' )
) )->push_to( 'error-body' );

$this->gui->get();