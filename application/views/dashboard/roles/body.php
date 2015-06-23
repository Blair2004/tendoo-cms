<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->gui->col_width( 1 , 4 );

$this->gui->add_meta( array(
	'namespace'		=>	'role_list',
	'title'			=>	__( 'Role List' ),
	'col_id'		=>	1,
	'footer'		=>	array(
		'pagination'	=>	array( true )
	),
	'type'			=>	'box'
) );

$group_array		=	array();
foreach( force_array( $groups ) as $group )
{
	$group_array[]	=	array(
		'<a href="' . site_url( array( 'dashboard' , 'roles' , 'edit' , $group->id ) ) . '">' . $group->name . '</a>',
		$group->definition,
		in_array( $group->name , $this->config->item( 'master_group_label' ) ) ? __( 'Yes' ) : __( 'No' )
	);
}

$this->gui->add_item( array(
	'type'			=>	'table',
	'cols'			=>	array( __( 'Role name' ) , __( 'Description' ) , __( 'Admin' ) ),
	'rows'			=>	$group_array
) , 'role_list' , 1 );

$this->gui->output();