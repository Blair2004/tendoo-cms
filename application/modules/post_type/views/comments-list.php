<?php
// var_dump( get_core_vars( 'posttypes' ) );
$this->Gui->col_width( 1 , 4 );

$this->Gui->add_meta( array(
	'type'			=>		'box',
	'namespace'		=>		$post_namespace . '-table-list',
	'title'			=>		$comments_list_label,
	'col_id'			=>		1
) );

$default_cols		=		array( __( 'Select' ) , __( 'Excerpt' ) , __( 'By' ) , __( 'On' ) , __( 'Status' ) );
$table_row			=		array();

foreach( force_array( $comments ) as $_comment )
{
	$user			=		( $pseudo = get_user( riake( 'AUTHOR' , $_comment ) , 'as_id' ) ) != false ? riake( 'PSEUDO' , $pseudo ) : riake( 'AUTHOR_NAME' , $_comment );
	$user			=		$user == '' ? __( 'N/A' ) : $user ;
	
	$table_row[]	=		array(
		'<input type="checkbox" name="post_id[]" style="height:30px" value="' . riake( 'QUERY_ID' , $_comment ) . '">',
		riake( 'COMMENTS' , $_comment ) . 
		'<br>
		<div class="dropdown">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			' . __( 'Actions' ) . '
			<span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		  	<li role="presentation"><a role="menuitem" tabindex="-1" href=" ' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'comments' , 'approve' , riake( 'ID' , $_comment ) ) ) . ' ">' . __( 'Approve' ) . '</a></li>
			<li role="presentation"><a  href=" ' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'comments' , 'trash' , riake( 'ID' , $_comment ) ) ) . ' ">' . __( 'Trash' ) . '</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href=" ' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'comments' , 'draft' , riake( 'ID' , $_comment ) ) ) . ' ">' . __( 'Draft' ) . '</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href=" ' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'comments' , 'disapprove' , riake( 'ID' , $_comment ) ) ) . ' ">' . __( 'Disapprove' ) . '</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href=" ' . get_instance()->url->site_url( array( 'admin' , 'posttype' , $post_namespace , 'comments' , 'delete' , riake( 'ID' , $_comment ) ) ) . ' ">' . __( 'Delete' ) . '</a></li>
		  </ul>
		</div>' ,
		$user,
		// get_instance()->date->datetime( riake( 'DATE' , $_comment ) ),
		$this->current_posttype->query->get_status( riake( 'STATUS' , $_comment ) )	
	);
}

$this->Gui->add_item( array(
	'type'			=>		'table',
	'cols'			=>		$default_cols,
	'rows'			=>		$table_row,
	'cols_width'	=>		array( 5 , 200 , 100 , 100 , 100 , 100 )
) , $post_namespace . '-table-list' , 1 );

$this->Gui->output();