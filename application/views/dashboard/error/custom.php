<?php
/**
 * 	File Name 	: 	custom.php
 *	Description :	Displays dashboard internal 404 page error
 *	Since		:	1.5
**/


$this->gui->col_width( 1 , 4 );

$this->gui->add_meta( array(
	'namespace'	=>	'error_meta',
	'col_id'	=>	1
) );

$this->gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$msg
) , 'error_meta' , 1 );

$this->gui->output();