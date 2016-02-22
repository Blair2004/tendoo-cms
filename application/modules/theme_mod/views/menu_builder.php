<?php
$this->Gui->col_width( 1, 4 );

$this->Gui->add_meta( array(
	'col_id'	=>	1,
	'namespace'	=>	'menu_builder',
	'type'		=>	'unwrapped',
	'title'		=>	__( 'Menu' )
) );

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$this->load->view( '../modules/theme_mod/views/menu_builder_output', array(), true )
), 'menu_builder', 1 );

$this->Gui->output();