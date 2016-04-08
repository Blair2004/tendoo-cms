<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$complete_users	=	array();
// adding user to complete_users array
foreach( $users as $user )
{
	$complete_users[]	=	array( 
		$user->id , 
		'<a href="' . site_url( array( 'dashboard' , 'users' , 'edit' , $user->id ) ) . '">' . $user->name . '</a>' , 
		$user->email , 
		$user->banned , 
		$user->last_login,
		 '<a href="' . site_url( array( 'dashboard' , 'users' , 'delete' , $user->id ) ) . '">' . __( 'Delete' ) . '</a>' , 
	);
}

$this->gui->col_width( 1 , 4 );

$this->gui->add_meta( array(
	'namespace'	=>	'user-list',
	'title'		=>	__( 'List' ),
	'pagination'=>	array( true ),
	'col_id'	=>	1,
	'type'		=>	'box-primary'	
) );

$this->gui->add_item( array(
	'type'		=>	'table',
	'cols'		=>	array( __( 'User Id' ) , __( 'Username' ) , __( 'Email' ) , __( 'Status' ) , __( 'Activity' ) , __( 'Actions' ) ),
	'rows'		=>	$complete_users
) , 'user-list' , 1 );

// Adding user list



$this->gui->output();