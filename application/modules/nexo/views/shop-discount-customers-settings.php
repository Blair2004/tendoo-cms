<?php
$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_discount_customers',
	'title'			=>		__( 'Réglages de la caisse', 'nexo' ),
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
	'name'		=>	'discount_type',
	'label'		=>	__( 'Type de la remise', 'nexo' ),
	'options'	=>	array(
		'disable'	=>	__( 'Désactiver', 'nexo' ),
		'percent'	=>	__( 'Au pourcentage', 'nexo' ),
		'amount'	=>	__( 'Montant fixe', 'nexo' ),
	)
), 'Nexo_discount_customers', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'how_many_before_discount',
	'label'		=>	__( 'Reduction Automatique', 'nexo' ),
	'description'	=>	__( "Après combien de commandes un client peut-il profiter d'une remise automatique. Veuillez définir une valeur numérique. \"0\" désactive la fonctionnalité.", 'nexo' )
), 'Nexo_discount_customers', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'discount_percent',
	'label'		=>	__( 'Pourcentage de la remise', 'nexo' )
), 'Nexo_discount_customers', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'discount_amount',
	'label'		=>	__( 'Montant fixe', 'nexo' )
), 'Nexo_discount_customers', 1 );

/** 
 * Fetch Clients
**/

$query	=	$this->db->get( 'nexo_clients' );
$result	=	$query->result_array();
$options		=	array();

foreach( $result as $_r ) {
	$options[ $_r[ 'ID' ] ]		=	$_r[ 'NOM' ];
}

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'default_compte_client',
	'label'		=>	__( 'Compte Client par défaut', 'nexo' ),
	'description'	=>	__( 'Ce client ne profitera pas des réductions automatique.', 'nexo' ),
	'options'	=>	$options
), 'Nexo_discount_customers', 1 );

$query	=	$this->db->get( 'tendoo_nexo_paiements' );
$result	=	$query->result_array();
$options		=	array();

foreach( $result as $_r ) {
	$options[ $_r[ 'ID' ] ]		=	$_r[ 'DESIGN' ];
}

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'default_payment_means',
	'label'		=>	__( 'Moyen de paiement par défaut', 'nexo' ),
	'options'	=>	$options
), 'Nexo_discount_customers', 1 );
