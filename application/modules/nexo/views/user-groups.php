<?php
$this->Gui->col_width( 1, 4 );

$this->Gui->add_meta( array(
	'namespace'		=>	 'group_meta',
	'type'			=>	 'unwrapped',
	'col_id'		=>	 1
) );

$this->Gui->add_item( array(
	'type'			=>	'dom',
	'content'		=>	$crud_content->output
), 'group_meta', 1 );

$this->Gui->output();