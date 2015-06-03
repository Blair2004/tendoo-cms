<?php
$this->gui->cols_width( 1 , 3 );
$this->gui->cols_width( 2 , 1 );
$this->gui->col_config( 1 , array(
	'inner-opening-wrapper'	=>	'<form method="post" class="submitForm">'
) );
$this->gui->col_config( 2 , array(
	'inner-closing-wrapper'	=>	'</form>'
) );
$this->gui->set_meta( array(
	'namespace'		=>		'post_new',
	'type'			=>		'unwrapped',	
) )->push_to( 1 );

$this->gui->set_meta( array(
	'namespace'		=>		'post_meta',
	'type'			=>		'unwrapped',	
) )->push_to( 2 );

$this->gui->set_item( array(
	'type'		=>	'dom',
	'value'		=>	module_view( 'views/post-new' , true , 'blogster' )
) )->push_to( 'post_new' );

$this->gui->set_item( array(
	'type'		=>	'dom',
	'value'		=>	module_view( 'views/post-new-meta' , true , 'blogster' )
) )->push_to( 'post_meta' );

$this->gui->get();