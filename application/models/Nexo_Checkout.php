<?php
class Nexo_Checkout extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Command Save
	 * @access public
	 * @return string
	 * @param post
	**/
	
	function commandes_save( $post )
	{
		// Protecting
		if( ! User::can( 'create_orders' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		global $Options;
		/**
		 * Bug, en cas de réduction, le total de la commande affiche un montant inexacte
		**/
		
		// Selon les options, le champ des remise peut en pas être définit
		$post[ 'REMISE' ] 		=	isset( $post[ 'REMISE' ] ) ? $post[ 'REMISE' ] : 0;
		$post[ 'REF_CLIENT' ] 	=	isset( $post[ 'REF_CLIENT' ] ) ? $post[ 'REF_CLIENT' ] : 0;
		$post[ 'SOMME_PERCU' ] 	=	isset( $post[ 'SOMME_PERCU' ] ) ? $post[ 'SOMME_PERCU' ] : 0;
		$post[ 'PAYMENT_TYPE' ] =	isset( $post[ 'PAYMENT_TYPE' ] ) ? $post[ 'PAYMENT_TYPE' ] : 0;
		
		$client					=	riake( 'REF_CLIENT', $post );
		$payment				=	riake( 'PAYMENT_TYPE', $post );
		$post[ 'SOMME_PERCU' ]	=	intval( riake( 'SOMME_PERCU', $post ) );		
		$somme_percu			=	intval( $post[ 'SOMME_PERCU' ] );
		$remise					=	intval( riake( 'REMISE', $post ) );
		$produits				=	riake( 'order_products', $post );
		$othercharge			=	intval( riake( 'other_charge', $post ) );
		$ttWithCharge			=	intval( riake( 'total_value_with_charge', $post ) ) ;
		$total					=	intval( riake( 'order_total', $post ) ) ;
		
		/**
		 * Définir le type 
		**/
		
		if( $somme_percu >= $ttWithCharge ) {
			$post[ 'TYPE' ]	=	@$Options[ 'nexo_order_comptant' ]; // Comptant
		} else if( $somme_percu == 0 ) {
			$post[ 'TYPE' ] = 	@$Options[ 'nexo_order_devis' ]; // Devis
		} else if( $somme_percu < $ttWithCharge && $somme_percu > 0 ) {
			$post[ 'TYPE' ]	=	@$Options[ 'nexo_order_advance' ]; // Avance
		}
		
		// Other: Ristourne
		
		$post[ 'RISTOURNE' ] = $othercharge;
				
		// Calcul Total		
		
		$post[ 'TOTAL' ]	=	$total; // - ( $othercharge + intval( @$post[ 'REMISE' ] ) );
		
		// Author
		
		$post[ 'AUTHOR' ]	=	User::id();
		
		// Saving discount type
		
		$post[ 'DISCOUNT_TYPE' ]	= @$Options[ 'discount_type' ];
		
		// Payment Type
		/**
		 * First Index is set as payment type
		**/
		
		$post[ 'PAYMENT_TYPE' ]	=	$post[ 'PAYMENT_TYPE' ] == '' ? 
			// Default paiement type
			is_numeric( @$Options[ 'default_payment_means' ] ) ? $Options[ 'default_payment_means' ] : 1
			// end default paiement type
		: $post[ 'PAYMENT_TYPE' ];
		
		// Date
		
		$post[ 'DATE_CREATION' ]=	date_now();
		
		// Code
		
		$post[ 'CODE' ]			=	$this->random_code();
		
		// Client
		/**
		 * Increate Client Product
		**/
		
		$post[ 'REF_CLIENT' ]	=	$post[ 'REF_CLIENT' ] == '' ? 
			// Start Loop for Default Compte client
			is_numeric( @$Options[ 'default_compte_client' ] ) ? $Options[ 'default_compte_client' ] : 1
			// End loop for default compte client
			: $post[ 'REF_CLIENT' ];	
		// Augmenter la quantité de produit du client
				
		$query					=	$this->db->where( 'ID', $post[ 'REF_CLIENT' ] )->get( 'nexo_clients' );
		$result					=	$query->result_array();
		$total_commands			=	intval( $result[0][ 'NBR_COMMANDES' ] ) + 1;
		$overal_commands		=	intval( $result[0][ 'OVERALL_COMMANDES' ] ) + 1;
		
		$this->db->set( 'NBR_COMMANDES', $total_commands );
		$this->db->set( 'OVERALL_COMMANDES', $overal_commands );
		
		// Désactivation des réduction auto pour le client par défaut
		if( $post[ 'REF_CLIENT' ] != @$Options[ 'default_compte_client' ] ) {
		
			// Verifie si le client doit profiter de la réduction
			if( @$Options[ 'discount_type' ] != 'disable' ) {
				// On définie si en fonction des réglages, l'on peut accorder une réduction au client
				if( $total_commands >= intval( @$Options[ 'how_many_before_discount' ] ) - 1 && $result[0][ 'DISCOUNT_ACTIVE' ] == 0 ) {
					$this->db->set( 'DISCOUNT_ACTIVE', 1 );
				} else if( $total_commands >= @$Options[ 'how_many_before_discount' ] && $result[0][ 'DISCOUNT_ACTIVE' ] == 1 ){
					$this->db->set( 'DISCOUNT_ACTIVE', 0 ); // bénéficiant d'une reduction sur cette commande, la réduction est désactivée
					$this->db->set( 'NBR_COMMANDES', 1 ); // le nombre de commande est également désactivé
				}
			}
		
		} // fin désactivation réduction auto pour le client par défaut
		
		$this->db->where( 'ID', $post[ 'REF_CLIENT' ] )
		->update( 'nexo_clients' );
		
		/**
		 * Reducing Qte
		**/
		
		foreach( force_array( riake( 'order_products', $post ) ) as $prod ) {
			$json	=	json_decode( $prod );
			$this->db->where( 'CODEBAR', $json->codebar )->update( 'nexo_articles', array(
				'QUANTITE_RESTANTE'	=>	intval( $json->quantite_restante ) - intval( $json->qte ),
				'QUANTITE_VENDU'	=>	intval( $json->quantite_vendu ) + intval( $json->qte )
			) );
			
			// Adding to order product
			$this->db->insert( 'nexo_commandes_produits', array(
				'REF_PRODUCT_CODEBAR'	=>	$json->codebar,
				'REF_COMMAND_CODE'		=>	$post[ 'CODE' ],
				'QUANTITE'				=>	$json->qte,
				'PRIX'					=>	$json->price,
				'PRIX_TOTAL'			=>	intval( $json->qte ) * intval( $json->price )
			) );
		}			
		return $post;		
	}
	
	/**
	 * Create random Code
	 * 
	 * @param Int length
	 * @return String
	**/
	
	function random_code( $length = 6 )
	{
		$allCode	=	$this->options->get( 'order_code' );
		/**
		 * Count product to increase length
		**/
		do {
			// abcdefghijklmnopqrstuvwxyz
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
		} while( in_array( $randomString, force_array( $allCode ) ) );
		
		$allCode[]	=	$randomString;
		$this->options->set( 'order_code', $allCode );
		
		return $randomString;
	}
	
	/**
	 * Command Update
	 * Update a command
	 *
	 * @param Array
	 * @return Array
	**/
	
	function commandes_update( $post )
	{
		
		// Protecting
		if( ! User::can( 'edit_orders' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		global $Options;
		$segments		=	$this->uri->segment_array();
		$command_id		=	end( $segments ) ;

		// Delete all product from this command
		/**
		 * Bug, en cas de réduction, le total de la commande affiche un montant inexacte
		**/
		
		$client			=	riake( 'REF_CLIENT', $post );
		$payment		=	riake( 'PAYMENT_TYPE', $post );
		$post[ 'SOMME_PERCU' ]	=	intval( riake( 'SOMME_PERCU', $post ) );		
		$somme_percu	=	intval( $post[ 'SOMME_PERCU' ] );
		$remise			=	intval( riake( 'REMISE', $post ) );
		$produits		=	riake( 'order_products', $post );
		$othercharge	=	intval( riake( 'other_charge', $post ) );
		$ttWithCharge	=	intval( riake( 'total_value_with_charge', $post ) ) ;
		$total			=	intval( riake( 'order_total', $post ) ) ;
		
		// Old Command
		$query				=	$this->db->where( 'ID', $command_id )->get( 'nexo_commandes' );
		$result_commandes	=	$query->result_array();
		
		/**
		 * Définir le type 
		**/

		if( $somme_percu >= $ttWithCharge ) {
			$post[ 'TYPE' ]	=	@$Options[ 'nexo_order_comptant' ]; // Comptant
		} else if( $somme_percu == 0 ) {
			$post[ 'TYPE' ] = 	@$Options[ 'nexo_order_devis' ]; // Devis
		} else if( $somme_percu < $ttWithCharge && $somme_percu > 0 ) {
			$post[ 'TYPE' ]	=	@$Options[ 'nexo_order_advance' ]; // Avance
		}
		
		// Other: Ristourne
		
		$post[ 'RISTOURNE' ] = 	$othercharge;
				
		// Calcul Total		
		
		$post[ 'TOTAL' ]	=	$total; // - ( intval( @$post[ 'REMISE' ] ) );
		
		// Author
		
		$post[ 'AUTHOR' ]	=	User::id();
		
		// Saving discount type
		
		$post[ 'DISCOUNT_TYPE' ]	= @$Options[ 'discount_type' ];
		
		// Payment Type
		/**
		 * First Index is set as payment type
		**/
		
		$post[ 'PAYMENT_TYPE' ]	=	$post[ 'PAYMENT_TYPE' ] == '' ? 
			// Default paiement type
			is_numeric( @$Options[ 'default_payment_means' ] ) ? $Options[ 'default_payment_means' ] : 1
			// end default paiement type
		: $post[ 'PAYMENT_TYPE' ];
		
		// Date
		
		$post[ 'DATE_MOD' ]	=	date_now();
		
		// Client
		/**
		 * Increate Client Product
		**/
		
		$post[ 'REF_CLIENT' ]	=	$post[ 'REF_CLIENT' ] == '' ? 
			// Start Loop for Default Compte client
			is_numeric( @$Options[ 'default_compte_client' ] ) ? $Options[ 'default_compte_client' ] : 1
			// End loop for default compte client
		: $post[ 'REF_CLIENT' ];	
		
		// Si le client a changé
		if( intval( $result_commandes[0][ 'REF_CLIENT' ] ) != $post[ 'REF_CLIENT' ] ) {
		
			// Augmenter la quantité de produit du client
			$query					=	$this->db->where( 'ID', $post[ 'REF_CLIENT' ] )->get( 'nexo_clients' );
			$result					=	$query->result_array();
			
			$this->db
			->set( 'NBR_COMMANDES', intval( $result[0][ 'NBR_COMMANDES' ] ) + 1 )
			->set( 'OVERALL_COMMANDES', intval( $result[0][ 'OVERALL_COMMANDES' ] ) + 1 );		
			
			$total_commands			=	intval( $result[0][ 'NBR_COMMANDES' ] ) + 1;
			$overal_commands		=	intval( $result[0][ 'OVERALL_COMMANDES' ] ) + 1;
			
			// Désactivation des reductions pour le client par défaut
			if( $post[ 'REF_CLIENT' ] != @$Options[ 'default_compte_client' ] ) {
			
				// Verifie si le nouveau client doit profiter de la réduction
				if( @$Options[ 'discount_type' ] != 'disable' ) {
					// On définie si en fonction des réglages, l'on peut accorder une réduction au client
					if( $total_commands >= intval( @$Options[ 'how_many_before_discount' ] ) - 1 && $result[0][ 'DISCOUNT_ACTIVE' ] == 0 ) {
						echo 'here';
						$this->db->set( 'DISCOUNT_ACTIVE', 1 );
					} else if( $total_commands >= @$Options[ 'how_many_before_discount' ] && $result[0][ 'DISCOUNT_ACTIVE' ] == 1 ){
						echo 'there';
						$this->db->set( 'DISCOUNT_ACTIVE', 0 ); // bénéficiant d'une reduction sur cette commande, la réduction est désactivée
						$this->db->set( 'NBR_COMMANDES', 0 ); // le nombre de commande est également désactivé
					}
				}
			
			} // Fin désactivation réduction automatique pour le client par défaut
			
			// Fin des modifications du client en cours.
			$this->db->where( 'ID', $post[ 'REF_CLIENT' ] )
			->update( 'nexo_clients' );
			
			// Reduire pour le précédent client
			
			$query					=	$this->db->where( 'ID',  $result_commandes[0][ 'REF_CLIENT' ] )->get( 'nexo_clients' );
			$result					=	$query->result_array();
			
			// Le nombre de commande ne peut pas être inférieur à 0;
			
			$this->db
			->set( 'NBR_COMMANDES',  intval( $result_commandes[0][ 'REF_CLIENT' ] ) == 0 ? 0 : intval( $result[0][ 'NBR_COMMANDES' ] ) - 1 )
			->set( 'OVERALL_COMMANDES',  intval( $result_commandes[0][ 'REF_CLIENT' ] ) == 0 ? 0 : intval( $result[0][ 'OVERALL_COMMANDES' ] ) - 1 )
			->where( 'ID', $result_commandes[0][ 'REF_CLIENT' ] )
			->update( 'nexo_clients' );
			
		}
		
		/**
		 * Reducing Qte
		**/
		
		// Restauration des produits à la boutique
		$query		=	$this->db->where( 'REF_COMMAND_CODE', $post[ 'command_code' ] )->get( 'nexo_commandes_produits' );
		$old_products	=	$query->result_array();
		
		
		// incremente les produits restaurés
		foreach( $old_products as $product ){
			$this->db
				->set( 'QUANTITE_RESTANTE', '`QUANTITE_RESTANTE` + ' . intval( $product[ 'QUANTITE' ] ), FALSE )
				->set( 'QUANTITE_VENDU', '`QUANTITE_VENDU` - ' . intval( $product[ 'QUANTITE' ] ), FALSE )
				->where( 'CODEBAR', $product[ 'REF_PRODUCT_CODEBAR' ] )
				->update( 'nexo_articles' );
		}
		
		// Suppression des produits de la commande
		$this->db->where( 'REF_COMMAND_CODE', $post[ 'command_code' ] )->delete( 'nexo_commandes_produits' );
		
		// Adding articles
		foreach( force_array( riake( 'order_products', $post ) ) as $prod ) {
			$json	=	json_decode( $prod );
			$this->db->where( 'CODEBAR', $json->codebar )->update( 'nexo_articles', array(
				'QUANTITE_RESTANTE'	=>	( intval( $json->quantite_restante ) - intval( $json->qte ) ),
				'QUANTITE_VENDU'	=>	intval( $json->quantite_vendu ) + intval( $json->qte )
			) );
			
			// Adding to order product
			$this->db->insert( 'nexo_commandes_produits', array(
				'REF_PRODUCT_CODEBAR'	=>	$json->codebar,
				'REF_COMMAND_CODE'		=>	$post[ 'command_code' ],
				'QUANTITE'				=>	$json->qte,
				'PRIX'					=>	$json->price,
				'PRIX_TOTAL'			=>	intval( $json->qte ) * intval( $json->price )
			) );
		};
			
		return $post;	
	}
	
	/**
	 * Command delete
	 *
	 * @param Array
	 * @return Array
	**/
	
	function commandes_delete( $post )
	{
		
		// Protecting
		if( ! User::can( 'delete_orders' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		
		// Remove product from this cart
		$query	=	$this->db
					->where( 'ID', $post )
					->get( 'nexo_commandes' );
					
		$command=	$query->result_array();
		
		// Récupère les produits vendu
		$query	=	$this->db
					->where( 'REF_COMMAND_CODE', $command[0][ 'CODE' ] )
					->get( 'nexo_commandes_produits' );
					
		$produits		=	$query->result_array();
		
		$products_data	=	array();
		// parcours les produits disponibles pour les regrouper
		foreach( $produits as $product )
		{
			$products_data[ $product[ 'REF_PRODUCT_CODEBAR' ] ] =	intval( $product[ 'QUANTITE' ] );
		}
		
		// retirer le décompte des commandes passées par le client
		$query		=	$this->db->where( 'ID', $command[0][ 'REF_CLIENT' ] )->get( 'nexo_clients' );
		$client		=	$query->result_array();
		
		$this->db->where( 'ID', $command[0][ 'REF_CLIENT' ] )->update( 'nexo_clients', array(
			'NBR_COMMANDES'		=>	( intval( $client[0][ 'NBR_COMMANDES' ] ) - 1 ) < 0 ? 0 : intval( $client[0][ 'NBR_COMMANDES' ] ) - 1,
			'OVERALL_COMMANDES'	=>	( intval( $client[0][ 'OVERALL_COMMANDES' ] ) - 1 ) < 0 ? 0 : intval( $client[0][ 'OVERALL_COMMANDES' ] ) - 1,
		) );
		
		// Parcours des produits pour restaurer les quantités vendues
		foreach( $products_data as $codebar => $quantity ) {
			// Quantité actuelle
			$query	=	$this->db->where( 'CODEBAR', $codebar )->get( 'nexo_articles' );
			$article	=	$query->result_array();
			
			// Cumul et restauration des quantités
			$this->db->where( 'CODEBAR', $codebar )->update( 'nexo_articles', array(
				'QUANTITE_VENDU'		=>		intval( $article[0][ 'QUANTITE_VENDU' ] ) - $quantity,
				'QUANTITE_RESTANTE'		=>		intval( $article[0][ 'QUANTITE_RESTANTE' ] ) + $quantity,
			) );
		}
		// retire les produits vendu du panier de cette commande et les renvoies au stock
		$this->db->where( 'REF_COMMAND_CODE', $command[0][ 'CODE' ] )->delete( 'nexo_commandes_produits' );
	}
	
	/**
	 * Create Permission
	 *
	 * @return Void
	**/
	
	function create_permissions()
	{
		$this->aauth		=	$this->users->auth;
		User::create_group( 'nexo_cashier' , __( 'Gérant de la caisse', 'nexo' ) , true );
		User::create_group( 'shop_manager' , __( 'Gérant de la boutique', 'nexo' ) , true );
		User::create_group( 'tester' , __( 'Privilège pour testeur', 'nexo' ) , true );
		
		// Shop_Manager
		
		$this->aauth->create_perm( 'create_orders', __( 'Peut créer des commandes', 'nexo' ) );
		$this->aauth->create_perm( 'edit_orders', __( 'Peut modifier des commandes', 'nexo' ) );
		$this->aauth->create_perm( 'delete_orders', __( 'Peut supprimer les commandes', 'nexo' ) );
		
		// Shipipng Managements
		
		$this->aauth->create_perm( 'create_items', __( 'Peut créer des produits', 'nexo' ) );
		$this->aauth->create_perm( 'edit_items', __( 'Peut modifier des produits', 'nexo' ) );
		$this->aauth->create_perm( 'delete_items', __( 'Peut supprimer des produits', 'nexo' ) );
		$this->aauth->create_perm( 'manage_categories', __( 'Gère les catégories', 'nexo' ) );
		$this->aauth->create_perm( 'manage_radius', __( 'Gère les rayons', 'nexo' ) );
		$this->aauth->create_perm( 'manage_shipping', __( 'Gère les collections', 'nexo' ) );
		$this->aauth->create_perm( 'manage_vendor', __( 'Gère les fournisseurs (Livreurs)', 'nexo' ) );
		
		// Shop_Manager
		
		$this->aauth->create_perm( 'manage_shop', __( 'Autorise la gestion complète de la boutique', 'nexo' ) );
		
		// Group Allow
		
			// Allow Checkout Manager
		
			$this->aauth->allow_group( 'nexo_cashier', 'create_orders' );
			$this->aauth->allow_group( 'nexo_cashier', 'edit_orders' );
			
			// Allow Shop Manager
					
			$this->aauth->allow_group( 'shop_manager', 'create_orders' );
			$this->aauth->allow_group( 'shop_manager', 'edit_orders' );
			$this->aauth->allow_group( 'shop_manager', 'delete_orders' );
			$this->aauth->allow_group( 'shop_manager', 'manage_shop' );
			$this->aauth->allow_group( 'shop_manager', 'create_items' );
			$this->aauth->allow_group( 'shop_manager', 'edit_items' );
			$this->aauth->allow_group( 'shop_manager', 'delete_items' );
			$this->aauth->allow_group( 'shop_manager', 'manage_categories' );
			$this->aauth->allow_group( 'shop_manager', 'manage_radius' );
			$this->aauth->allow_group( 'shop_manager', 'manage_shipping' );
			$this->aauth->allow_group( 'shop_manager', 'manage_vendor' );
		
			// Allow Tester
			
			$this->aauth->allow_group( 'tester', 'create_orders' );
			$this->aauth->allow_group( 'tester', 'edit_orders' );
			$this->aauth->allow_group( 'tester', 'create_items' );
			$this->aauth->allow_group( 'tester', 'edit_items' );
		
		// default privilege
		
		$this->aauth->allow_group( 'master', 'create_orders' );
		$this->aauth->allow_group( 'master', 'edit_orders' );
		$this->aauth->allow_group( 'master', 'delete_orders' );
		$this->aauth->allow_group( 'master', 'manage_shop' );
		$this->aauth->allow_group( 'master', 'create_items' );
		$this->aauth->allow_group( 'master', 'edit_items' );
		$this->aauth->allow_group( 'master', 'delete_items' );
		$this->aauth->allow_group( 'master', 'manage_categories' );
		$this->aauth->allow_group( 'master', 'manage_radius' );
		$this->aauth->allow_group( 'master', 'manage_shipping' );
		$this->aauth->allow_group( 'master', 'manage_vendor' );
	}
	
	/** 
	 * Delete Permission
	 *
	 * @return Void
	**/
	
	function delete_permissions()
	{
		$this->aauth		=	$this->users->auth;
		$this->aauth->delete_group( 'nexo_cashier' );
		$this->aauth->delete_group( 'shop_manager' );
		
		$this->aauth->deny_group( 'master', 'create_orders' );
		$this->aauth->deny_group( 'master', 'edit_orders' );
		$this->aauth->deny_group( 'master', 'delete_orders' );
		
		$this->aauth->deny_group( 'master', 'manage_shop' );
		$this->aauth->deny_group( 'master', 'manage_categories' );
		$this->aauth->deny_group( 'master', 'manage_radius' );
		$this->aauth->deny_group( 'master', 'manage_shipping' );
		$this->aauth->deny_group( 'master', 'manage_vendor' );
		
		$this->aauth->deny_group( 'master', 'create_items' );
		$this->aauth->deny_group( 'master', 'edit_items' );
		$this->aauth->deny_group( 'master', 'delete_items' );
		
		$this->aauth->delete_perm( 'create_orders' );
		$this->aauth->delete_perm( 'edit_orders' );
		$this->aauth->delete_perm( 'delete_orders' );
		
		$this->aauth->delete_perm( 'manage_shop' );
		$this->aauth->delete_perm( 'manage_categories' );
		$this->aauth->delete_perm( 'manage_shipping' );
		$this->aauth->delete_perm( 'manage_vendor' );
		$this->aauth->delete_perm( 'manage_radius' );
		
		$this->aauth->delete_perm( 'create_items' );
		$this->aauth->delete_perm( 'edit_items' );
		$this->aauth->delete_perm( 'delete_items' );
	}
	
	/**
	 * Get Order
	 * 
	 * @return array
	**/
	
	function get_order( $order_id = NULL )
	{
		if( $order_id != NULL && ! is_array( $order_id ) ) {
			$this->db->where( 'ID', $order_id );
		} else if( is_array( $order_id ) ) {
			foreach( $order_id as $mark => $value ) {
				$this->db->where( $mark, $value );
			}
		}
		$query	=	$this->db->get( 'nexo_commandes' );
		if( $query->result_array() ) {
			return $query->result_array();
		}
		return false;
	}
	
	/**
	 * Get order products
	 *
	 * @param Int order id
	 * @param Bool return all
	**/
	
	function get_order_products( $order_id, $return_all = false ) 
	{
		$query	=	$this->db
			->where( 'ID', $order_id )
			->get( 'nexo_commandes' );
		if( $query->result_array() ) {
			$data	=	$query->result_array();
			$sub_query	=	$this->db
				->select( '*,
				nexo_articles.DESIGN as DESIGN' )
				->from( 'nexo_commandes' )
				->join( 'nexo_commandes_produits', 'nexo_commandes.CODE = nexo_commandes_produits.REF_COMMAND_CODE', 'inner' ) 
				->join( 'nexo_articles', 'nexo_articles.CODEBAR = nexo_commandes_produits.REF_PRODUCT_CODEBAR', 'inner' ) 
				->where( 'REF_COMMAND_CODE', $data[0][ 'CODE' ] )
				->get();
			$sub_data	= $sub_query->result_array();
			if( $sub_data ) {
				if( $return_all ) {
					return array(
						'order'		=>	$data,
						'products'	=>	$sub_data
					);
				}
				return $sub_query->result_array();
			}
			return false;
		}
		return false;
	}
	
	/**
	 * Get order type
	 *
	 * @param Int
	 * @return String order type
	**/
	
	function get_order_type( $order_type )
	{
		$query	=	$this->db->where( 'ID', $order_type )->get( 'nexo_types_de_commandes' );
		$data	=	$query->result_array();
		return $data[0][ 'DESIGN' ];
	}
}