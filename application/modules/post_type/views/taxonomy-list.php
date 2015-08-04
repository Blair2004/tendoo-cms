<?php
$this->gui->col_width( 1 , 4 );

$this->gui->add_meta( array(
	'type'			=>		'box',
	'namespace'		=>		$taxonomy_namespace . '-table-list',
	'title'			=>		$taxonomy_list_label,
	'col_id'			=>		1
) );

$default_cols		=		array( __( 'Select' ) , __( 'Title' ) , __( 'By' ) , __( 'On' ) );
$table_row			=		array();

foreach( force_array( $taxonomies ) as $_taxonomy )
{
	$user				=		User::get( riake( 'AUTHOR' , $_taxonomy ) );
	$table_row[]	=		array(
		'<input type="checkbox" name="post_id[]" style="height:30px" value="' . riake( 'QUERY_ID' , $_taxonomy ) . '">',
		'<a href="' . site_url( array( 'dashboard' , 'posttype' , $post_namespace , 'taxonomy' , $taxonomy_namespace , 'edit' , riake( 'ID' , $_taxonomy ) ) ) . '">' . xss_clean( riake( 'TITLE' , $_taxonomy ) ) . '</a>', 
		xss_clean( $user->name ),
		riake( 'DATE' , $_taxonomy )
	);
}

unset( $taxonomies , $user );

$this->gui->add_item( array(
	'type'			=>		'table',
	'cols'			=>		$default_cols,
	'rows'			=>		$table_row,
	'cols_width'	=>		array( 5 , 200 , 100 , 100 )
) , $taxonomy_namespace . '-table-list' , 1 );

$this->gui->output();