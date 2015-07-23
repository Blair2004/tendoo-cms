<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		'<a href="' . site_url( array( 'dashboard' , 'groups' , 'edit' , $group->id ) ) . '">' . $group->name . '</a>',
		$group->definition,
		in_array( $group->name , $this->config->item( 'master_group_label' ) ) ? __( 'Yes' ) : __( 'No' ),
		var_dump( $this->users->auth->list_perms( $group->id ) )		
	);
}

$this->gui->add_item( array(
	'type'			=>	'table',
	'cols'			=>	array( __( 'Role name' ) , __( 'Description' ) , __( 'Admin' ) , __( 'Permissions' ) ),
	'rows'			=>	$group_array
) , 'role_list' , 1 );

$this->gui->output();