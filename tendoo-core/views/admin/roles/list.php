<?php
$this->gui->cols_width( 1 , 4 );

$this->gui->enable( array( 'pagination' ) );

$this->gui->set_meta( array(
	'type'		=>	'panel-ho',
	'title'		=>	__( 'Roles' ),
	'namespace'	=>	core_meta_namespace( array( 'roles' , 'list' ) )
) )->push_to( 1 );

foreach( force_array( $get_roles ) as $_role )
{
	$rows[]		=	array( 
		'<a href="' . $this->instance->url->site_url(array('admin','roles','edit',$_role['ID'])) . '">' . $_role['ID'] . '</a>',
		$_role['NAME'],
		$_role['DESCRIPTION'],
		timespan( strtotime( $_role['DATE'] ) , $this->instance->date->timestamp() ),
		$_role['IS_SELECTABLE'] == "1" ? __( 'Yes' ) : __( 'No' ),
		'<a href="' . $this->instance->url->site_url(array('admin','roles','delete',$_role['ID'])) . '">' . __( 'Delete' ) . '</a>'
	);
}

$this->gui->set_item( array(
	'type'		=>	'table',
	'cols'		=>	array( __( 'Id' ) , __( 'Name' ) , __( 'Description' ) , __( 'Created' ) , __( 'Available on registration' ) , __( 'Delete' ) ),
	'rows'		=>	$rows
) )->push_to( core_meta_namespace( array( 'roles' , 'list' ) ) );

$this->gui->get();