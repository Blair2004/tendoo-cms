<?php
/**
 * 	File Name 	: 	output-not-found.php
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
	'value'			=>		tendoo_error( 'This page has no output content. You may consider using GUI::page_content in order to create content. Please refer to Tendoo API.' )
) )->push_to( 'error-body' );

$this->gui->get();