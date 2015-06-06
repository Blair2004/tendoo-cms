<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$users			=	$this->flexi_auth->get_users( array(
	'uacc_id as user_id',
	'uacc_username as user_name',
	'uacc_email as user_email',
	'uacc_active as active',
	'uacc_suspend as status',
	'uacc_date_last_login as last_login'
) );

$complete_users	=	array();
// adding user to complete_users array
foreach( $users->result_array() as $_user )
{
	$complete_users[]	=	array( riake( 'user_id' , $_user ) , riake( 'user_name' , $_user ) , riake( 'user_email' , $_user ) , riake( 'active' , $_user ) , riake( 'status' , $_user ) , riake( 'last_login' , $_user ) );
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
	'cols'		=>	array( __( 'User Id' ) , __( 'Pseudo' ) , __( 'Email' ) , __( 'Active' ) , __( 'Status' ) , __( 'Activity' ) ),
	'rows'		=>	$complete_users
) , 'user-list' , 1 );

// Adding user list



$this->gui->output();