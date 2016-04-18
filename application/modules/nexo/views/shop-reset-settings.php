<?php
$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_reset',
	'title'			=>		__( 'Réinitialiser', 'nexo' ),
	'col_id'		=>		2,
	'gui_saver'		=>		true,
	'footer'		=>		array(
		'submit'	=>		array(
			'label'	=>		__( 'Sauvegarder les réglages', 'nexo' )
		)
	),
	'use_namespace'	=>		false,
) );

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$this->load->view( '../modules/nexo/views/reset-script', array(), true )
), 'Nexo_reset', 2 );
