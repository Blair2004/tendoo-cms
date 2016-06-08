<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

/** $this->Gui->col_width( 1 , 2 );

$this->Gui->add_meta( array(
    'col_id'	=>	1,
    'namespace'	=>	'dashboard',
    'type'		=>	'box-primary'
) );

$this->Gui->add_item( array(
    'type'	=>	'dom',
    'content'	=> $this->events->apply_filters( 'dashboard_home_output', '' )
) , 'dashboard' , 1 );

**/

$this->Gui->output();
