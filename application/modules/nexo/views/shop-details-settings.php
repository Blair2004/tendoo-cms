<?php
$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_shop_details',
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
	'type'		=>	'text',
	'name'		=>	'site_name',
	'label'		=>	__( 'Nom de la boutique', 'nexo' ),
	'desc'		=>	__( 'Vous pouvez utiliser le nom du site', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_shop_phone',
	'label'		=>	__( 'Téléphone pour la boutique', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_shop_street',
	'label'		=>	__( 'Rue de la boutique', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_shop_pobox',
	'label'		=>	__( 'Boite postale', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_shop_email',
	'label'		=>	__( 'Email pour la boutique', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_shop_fax',
	'label'		=>	__( 'Fax pour la boutique', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'textarea',
	'name'		=>	'nexo_bills_notices',
	'label'		=>	__( 'Notes pour factures', 'nexo' )
), 'Nexo_shop_details', 1 );

$this->Gui->add_item( array(
	'type'		=>	'textarea',
	'name'		=>	'nexo_other_details',
	'label'		=>	__( 'Détails supplémentaires', 'nexo' ),
	'description'	=>	__( 'Ce champ est susceptible d\'être utilisé au pied de page des rapports', 'nexo' )
), 'Nexo_shop_details', 1 );