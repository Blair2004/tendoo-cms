<?php
// var_dump( get_core_vars( 'posttypes' ) );
$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( array(
	'type'			=>		'panel-ho',
	'namespace'		=>		$post_namespace . '-table-list',
	'title'			=>		$comments_list_label
) )->push_to( 1 );

$default_cols		=		array( __( 'Select' ) , __( 'Excerpt' ) , __( 'By' ) , __( 'On' ) , __( 'Status' ) );
$table_row			=		array();

foreach( force_array( $comments ) as $_comment )
{
	$user			=		( $pseudo = get_user( riake( 'AUTHOR' , $_comment ) , 'as_id' ) ) == '' ? $pseudo : riake( 'AUTHOR_NAME' , $_comment );
	$table_row[]	=		array(
		'<input type="checkbox" name="post_id[]" style="height:30px" value="' . riake( 'QUERY_ID' , $_comment ) . '">',
		'',
		riake( 'PSEUDO' , $user ),
		get_instance()->date->datetime( riake( 'DATE' , $_comment ) ),
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