<?php
class Nexo_Print extends CI_Model
{
	function __construct( $args )
	{
		parent::__construct();
		if( is_array( $args ) && count( $args ) > 1 ) {
			if( method_exists( $this, $args[1] ) ){
				return call_user_func_array( array( $this, $args[1] ),  array_slice( $args, 2 ) );
			} else {
				return $this->defaults( $args );
			}			
		}
		return $this->defaults( $args );
	}
	
	function defaults()
	{
	}
	
	function order_receipt( $order_id = null )
	{
		if( $order_id != null ) {
			
			$this->cache 		=	new CI_Cache( array( 'adapter' => 'file', 'backup' => 'file', 'key_prefix'	=>	'nexo_order_' ) );
			
			if( $order_cache = $this->cache->get( $order_id ) && @$_GET[ 'refresh' ] != 'true' )
			{
				echo get_instance()->cache->get( $order_id );
				return;
			}
			
			$this->load->model( 'Nexo_Checkout' );
			global $Options;
			$data				=	array();			
			$data[ 'order' ]	=	$this->Nexo_Checkout->get_order_products( $order_id, true );
			$data[ 'cache' ]	=	$this->cache;
			if( count( $data[ 'order' ] ) == 0 ) {
				die( sprintf( __( 'Impossible d\'afficher le ticket de caisse. Cette commande ne possède aucun article &mdash; <a href="%s">Retour en arrière</a>', 'nexo' ), $_SERVER['HTTP_REFERER'] ) ); 
			}
			$theme				=	@$Options[ 'nexo_receipt_theme' ] ? @$Options[ 'nexo_receipt_theme' ] : 'default';
			
			$this->load->view( '../modules/nexo/views/receipts/' . $theme . '.php', $data );
		} else {
			die( __( 'Cette commande est introuvable.', 'nexo' ) );
		}
	}
	
	/** 
	 * Gestion des impressions des étiquettes des produits
	**/
	
	function shipping_item_codebar( $shipping_id = null )
	{
		if( $shipping_id  == null ) {
			die( __( 'Arrivage non définie', 'nexo' ) );
		}
		
		$this->cache 		=	new CI_Cache( array('adapter' => 'file', 'backup' => 'file', 'key_prefix'	=>	'nexo_products_labels_' ) );
			
		if( $products_labels = $this->cache->get( $shipping_id ) && @$_GET[ 'refresh' ] != 'true' )
		{
			echo get_instance()->cache->get( $shipping_id );
			return;
		}
		
		$this->load->model( 'Nexo_Products' );		
		$this->load->model( 'Nexo_Shipping' );		
		
		global $Options;
		$pp_row					=	! empty( $Options[ 'nexo_products_labels' ] ) ? @$Options[ 'nexo_products_labels' ] : 4;
		$data					=	array();
		$data[ 'shipping_id' ]	=	$shipping_id;
		$data[ 'pp_row'	]		=	$pp_row;
		$data[ 'cache' ]	=	$this->cache;
				
		if( isset( $_GET[ 'products_ids' ] ) ) {
			$get		=	str_replace( '%2C', ',', $_GET[ 'products_ids' ] );
			$ids		=	explode( ',', $get );
			$products	=	array();
			foreach( $ids as $id ) {
				$unique_product		=	$this->Nexo_Products->get( 'nexo_articles', $id, 'ID' );
				// Si le produit existe
				if( count( $unique_product ) > 0 ) {
					$products[]			=	$unique_product[0];
				}
			}
			// var_dump( $products );
			$data[ 'products' ]		=	$products;
		} else {
			$data[ 'products' ]		=	$this->Nexo_Products->get_products_by_shipping( $shipping_id );
		}
		
		$this->load->view( '../modules/nexo/views/products-labels/default.php', $data );
	}	 
}
new Nexo_Print( $this->args );