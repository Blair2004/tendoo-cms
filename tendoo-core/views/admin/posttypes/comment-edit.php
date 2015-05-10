<?php
// var_dump( get_core_vars( 'posttypes' ) );
$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( array(
	'type'			=>		'panel-ho',
	'namespace'		=>		$post_namespace . '-table-list',
	'title'			=>		$post_list_label
) )->push_to( 1 );

$default_cols		=		array( __( 'Select' ) , __( 'Title' ) , __( 'Excerpt' ) , __( 'By' ) , __( 'On' ) , __( 'Status' ) );
$table_row			=		array();

foreach( force_array( $post ) as $_post )
{
	$user			=		get_user( riake( 'AUTHOR' , $_post ) , 'as_id' );
	$table_row[]	=		array(
		'<input type="checkbox" name="post_id[]" style="height:30px" value="' . riake( 'QUERY_ID' , $_post ) . '">',
		'<a href="' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'edit' , riake( 'QUERY_ID' , $_post ) ) ) . '">' . riake( 'TITLE' , $_post ) . '</a>', 
		'',
		riake( 'PSEUDO' , $user ),
		get_instance()->date->datetime( riake( 'DATE' , $_post ) ),
		''
	);
}

$this->gui->set_item( array(
	'type'			=>		'table',
	'cols'			=>		$default_cols,
	'rows'			=>		$table_row,
	'cols_width'	=>		array( 5 , 200 , 100 , 100 , 100 , 100 )
) )->push_to( $post_namespace . '-table-list' );

$this->gui->get();