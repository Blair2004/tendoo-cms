<?php
$this->Gui->col_width( 1 , 4 );

$this->Gui->add_meta( array(
	'type'			=>		'box',
	'namespace'		=>		$post_namespace . '-table-list',
	'title'			=>		$post_list_label,
	'col_id'			=>		1
) );

$default_cols		=		array( __( 'Select' ) , __( 'Title' ) , __( 'Excerpt' ) , __( 'By' ) , __( 'On' ) , __( 'Status' ) );
$table_row			=		array();

foreach( force_array( $post ) as $_post )
{
	$user				=		User::get( riake( 'AUTHOR' , $_post ) , 'as_id' );
	$table_row[]	=		array(
		'<input type="checkbox" name="post_id[]" style="height:30px" value="' . riake( 'QUERY_ID' , $_post ) . '">',
		'<a href="' . site_url( array( 'dashboard' , 'posttype' , $post_namespace , 'edit' , xss_clean( riake( 'QUERY_ID' , $_post ) ) ) ) . '">' . xss_clean( riake( 'TITLE' , $_post ) ) . '</a>', 
		'',
		User::pseudo( riake( 'AUTHOR' , $_post ) ),
		riake( 'DATE' , $_post ),
		''
	);
}

$this->Gui->add_item( array(
	'type'			=>		'table',
	'cols'			=>		$default_cols,
	'rows'			=>		$table_row,
	'cols_width'	=>		array( 5 , 200 , 100 , 100 , 100 , 100 )
) , $post_namespace . '-table-list' , 1 );

$this->Gui->output();