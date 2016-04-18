<?php
$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_checkout',
	'title'			=>		__( 'Réglages de la caisse', 'nexo' ),
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
	'content'	=>	'<strong>' . __( 'Visibilité des champs', 'nexo' ) . '</strong>'
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'checkbox',
	'label'		=>	__( 'Selection du client', 'nexo' ),
	'name'		=>	'nexo_display_select_client',
	'value'		=>	'enable',
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'checkbox',
	'label'		=>	__( 'Mode de paiement', 'nexo' ),
	'name'		=>	'nexo_display_payment_means',
	'value'		=>	'enable',
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'checkbox',
	'label'		=>	__( 'Somme perçu', 'nexo' ),
	'name'		=>	'nexo_display_amount_received',
	'value'		=>	'enable',
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'checkbox',
	'label'		=>	__( 'Remise express', 'nexo' ),
	'name'		=>	'nexo_display_discount',
	'value'		=>	'enable',
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	'<strong>' . __( 'Type des commandes', 'nexo' ) . '</strong>'
), 'Nexo_checkout', 2 );

$query	=	$this->db->get( 'nexo_types_de_commandes' );
$result	=	$query->result_array();
$options		=	array();

foreach( $result as $_r ) {
	$options[ $_r[ 'ID' ] ]		=	xss_clean( $_r[ 'DESIGN' ] );
}

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_order_comptant',
	'label'		=>	__( 'Commande Comptant', 'nexo' ),
	'description'	=>	__( 'Affecter ce type de commande aux commandes dont la somme perçu est supérieure ou également à la valeur réelle de la commande', 'nexo' ),
	'options'	=>	$options
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_order_advance',
	'label'		=>	__( 'Commande Avance', 'nexo' ),
	'description'	=>	__( 'Affecter ce type de commande aux commandes dont la somme perçu est inférieure à la valeur réelle de la commande, mais supérieure à 0', 'nexo' ),
	'options'	=>	$options
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_order_devis',
	'label'		=>	__( 'Commande Devis', 'nexo' ),
	'description'	=>	__( 'Affecter ce type de commande aux commandes dont la somme perçu total est égale à 0', 'nexo' ),
	'options'	=>	$options
), 'Nexo_checkout', 2 );	

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	'<h4>' . __( 'Configuration de la devise', 'nexo' ) . '</h4>'
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_currency',
	'label'		=>	__( 'Symbole de la devise', 'nexo' )
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_currency_position',
	'label'		=>	__( 'Position de la devise', 'nexo' ),
	'options'	=>	array(
		'before'	=>	__( 'Avant le montant', 'nexo' ),
		'after'		=>	__( 'Après le montant', 'nexo' )
	)
), 'Nexo_checkout', 2 );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_receipt_theme',
	'label'		=>	__( 'Thème des tickets de caisse', 'nexo' ),
	'options'	=>	array(
		'default'	=>	__( 'Par défaut', 'nexo' ),
	)
), 'Nexo_checkout', 2 );

/**
 * @since 2.3
**/

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_enable_autoprint',
	'label'		=>	__( 'Activer l\'impression automatique des tickets de caisse ?', 'nexo' ),
	'description'		=>	__( 'Par défaut vaut : "Non"', 'nexo' ),
	'options'	=>	array(
		''			=>	__( 'Veuillez choisir une option', 'nexo' ),
		'yes'		=>	__( 'Oui', 'nexo' ),
		'no'		=>	__( 'Non', 'nexo' )
	)
), 'Nexo_checkout', 2 );

// Définit une date de validité pour les com

$this->Gui->add_item( array(
	'type'		=>	'text',
	'label'		=>	__( 'Validité des commandes devis (en jours)', 'nexo' ),
	'name'		=>	'nexo_devis_expiration',
	'placeholder'	=>	__( 'Par défaut: Illimité', 'nexo' )
), 'Nexo_checkout', 2 );