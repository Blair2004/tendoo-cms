<?php
// var_dump( get_core_vars( 'posttypes' ) );
$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( array(
	'type'			=>		'panel-ho',
	'namespace'		=>		$taxonomy_namespace . '-table-list',
	'title'			=>		$taxonomy_list_label
) )->push_to( 1 );

$default_cols		=		array( __( 'Select' ) , __( 'Title' ) , __( 'By' ) , __( 'On' ) );
$table_row			=		array();

foreach( force_array( $taxonomies ) as $_taxonomy )
{
	$user			=		get_user( riake( 'AUTHOR' , $_taxonomy ) , 'as_id' );
	$table_row[]	=		array(
		'<input type="checkbox" name="post_id[]" style="height:30px" value="' . riake( 'QUERY_ID' , $_taxonomy ) . '">',
		'<a href="' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'taxonomy' , $taxonomy_namespace , 'edit' , riake( 'ID' , $_taxonomy ) ) ) . '">' . riake( 'TITLE' , $_taxonomy ) . '</a>', 
		riake( 'PSEUDO' , $user ),
		get_instance()->date->datetime( riake( 'DATE' , $_taxonomy ) )
	);
}

$this->gui->set_item( array(
	'type'			=>		'table',
	'cols'			=>		$default_cols,
	'rows'			=>		$table_row,
	'cols_width'	=>		array( 5 , 200 , 100 , 100 )
) )->push_to( $taxonomy_namespace . '-table-list' );

$this->gui->get();