<?php
/**
 * 	File Name 	: 	output-not-found.php
 *	Description :	Displays dashboard internal 404 page error
 *	Since		:	1.5
**/

$this->gui->col_width( 1 , 4 );

// creating unique meta
$this->gui->add_meta( array(
	'namespace'		=>		'error-body',
	'type'			=>		'box',
	'col_id'		=>		1
) );

// creating meta item
$this->gui->add_item( array(
	'type'			=>		'dom',
	'content'		=>		tendoo_error( 'This page has no output content. You may consider using GUI::page_content in order to create content. Please refer to Tendoo API.' )
) , 'error-body' , 1 );

$this->gui->output();