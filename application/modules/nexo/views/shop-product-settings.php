<?php
function ___toUpper( $key, $value ) {
	return strtoupper( $value );
}
$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_product_settings',
	'title'			=>		__( 'Réglages des produits', 'nexo' ),
	'col_id'		=>		1,
	'gui_saver'		=>		true,
	'footer'		=>		array(
		'submit'	=>		array(
			'label'	=>		__( 'Sauvegarder les réglages', 'nexo' )
		)
	),
	'use_namespace'	=>		false,
) );

$codebar			=	get_instance()->events->apply_filters( 'nexo_barcode_type', array( 'ean8', 'ean13' ) ); // 'codabar', 'code11', 'code39',



$codebar			=	array_combine( $codebar, array_map( '___toUpper', $codebar, $codebar ) );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_product_codebar',
	'label'		=>	__( 'Choisir le type de Code Barre', 'nexo' ),
	'options'	=>	$codebar
), 'Nexo_product_settings', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_codebar_height',
	'label'		=>	__( 'Hauteur du codebar', 'nexo' ),
), 'Nexo_product_settings', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_bar_width',
	'label'		=>	__( 'Largeur des barres', 'nexo' ),
), 'Nexo_product_settings', 1 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_codebar_limit_nbr',
	'label'		=>	__( 'Limite en chiffre sur le code barre', 'nexo' ),
	'description'	=>	__( 'S\'applique à tout type de code sauf aux suivants : EAN8, EAN13', 'nexo' )
), 'Nexo_product_settings', 1 );

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$this->load->view( '../modules/nexo/views/shop-product-settings-script', array(), true )
), 'Nexo_product_settings', 1 );

$this->Gui->add_item( array(
	'type'		=>	'select',
	'name'		=>	'nexo_products_labels',
	'label'		=>	__( 'Thème des étiquettes des produits', 'nexo' ),
	'description'	=>	__( 'Choisir un template pour les étiquettes des produits.', 'nexo' ),
	'options'	=>	array(
		'5'	=>	__( 'Produits 1/5 sur A4', 'nexo' ),
		'4'	=>	__( 'Produits 1/4 sur A4', 'nexo' ),
		'3'	=>	__( 'Produits 1/3 sur A4', 'nexo' ),
		'2'	=>	__( 'Produits 1/2 sur A4', 'nexo' ),
		'1'	=>	__( 'Produits 1/1 sur A4', 'nexo' ),
	)
), 'Nexo_product_settings', 1 );