<?php
$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_soundfx',
	'title'			=>		__( 'Détails de la boutique', 'nexo' ),
	'col_id'		=>		1,
	'gui_saver'		=>		true,
	'footer'		=>		array(
		'submit'	=>		array(
			'label'	=>		__( 'Sauvegarder les réglages', 'nexo' )
		)
	),
	'use_namespace'	=>		false,
) );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_soundfx',
	'label'		=>	__( 'Activer les effets sonores', 'nexo' ),
	'options'	=>	array(
		'disable'		=>	__( 'Désactiver', 'nexo' ),
		'enable'		=>	__( 'Activer', 'nexo' )
	)
), 'Nexo_soundfx', 1 );
