<?php
$this->Gui->col_width( 1, 4 );
// var_dump( $crud_content );die;
$this->Gui->add_meta( array(
	'namespace'	=>	'clients',
	'type'		=>	'box',
	'col_id'	=>	1,
	'title'		=>	__( 'Gestion & Création des clients', 'nexo' )
) );

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$crud_content->output
), 'clients', 1 );

$this->Gui->output();