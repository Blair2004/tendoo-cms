<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 4 );

$this->gui->add_meta( array(
	'col_id'		=>	1,
	'title'		=>	__( 'Module List' ),
	'type'		=>	'unwrapped',
	'namespace'	=>	'module_list'
) );

$dom				=	$this->load->view( 'dashboard/modules/list-dom' , array() , true );

// var_dump( $dom );

$this->gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$dom,
) , 'module_list' , 1 );



$this->gui->output();