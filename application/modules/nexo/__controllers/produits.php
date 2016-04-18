<?php
class Nexo_Produits extends CI_Model
{
	function __construct( $args )
	{
		parent::__construct();
		if( is_array( $args ) && count( $args ) > 1 ) {
			if( method_exists( $this, $args[1] ) ){
				return call_user_func_array( array( $this, $args[1] ), array_slice( $args, 2 ) );
			} else {
				return $this->defaults();
			}			
		}
		return $this->defaults();
	}
	
	function crud_header()
	{
		$this->load->model( 'Nexo_Products' );
		$crud = new grocery_CRUD();
		$crud->set_theme('bootstrap');	
		$crud->set_subject( __( 'Articles', 'nexo' ) );	

		$crud->set_table( $this->db->dbprefix( 'nexo_articles' )  );
		$crud->columns( 'DESIGN', 'REF_CATEGORIE', 'REF_SHIPPING', 'QUANTITY', 'DEFECTUEUX', 'QUANTITE_RESTANTE', 'QUANTITE_VENDU', 'PRIX_DE_VENTE', 'CODEBAR' );
		
		$crud->fields( 	'DESIGN', 'SKU', 'REF_RAYON', 'REF_CATEGORIE', 'REF_SHIPPING', 'QUANTITY', 'DEFECTUEUX', 'QUANTITE_RESTANTE', 'QUANTITE_VENDU',
						'PRIX_DACHAT', 'FRAIS_ACCESSOIRE', 'PRIX_DE_VENTE', 'TAUX_DE_MARGE', 'COUT_DACHAT', 'HAUTEUR', 'LARGEUR', 'POIDS', 'COULEUR', 'APERCU', 
						'CODEBAR', 'DESCRIPTION', 'DATE_CREATION', 'DATE_MOD', 'AUTHOR'
		);
		
		$crud->set_relation( 'REF_RAYON', 'nexo_rayons', 'TITRE' );
		$crud->set_relation( 'REF_CATEGORIE', 'nexo_categories', 'NOM' );
		$crud->set_relation( 'REF_SHIPPING', 'nexo_arrivages', 'TITRE' );
		$crud->set_relation( 'AUTHOR', 'aauth_users', 'name' );
		
		$crud->display_as('DESIGN', __( 'Désignation', 'nexo' ) );
		$crud->display_as('SKU', __( 'UGS (Unité de gestion de stock)', 'nexo' ) );
		$crud->display_as('REF_RAYON', __( 'Assigner à un rayon', 'nexo' ) );
		$crud->display_as('REF_CATEGORIE', __( 'Assign à une catégorie', 'nexo' ) );
		$crud->display_as('REF_SHIPPING', __( 'Assign à un arrivage', 'nexo' ) );
		$crud->display_as('QUANTITY', __( 'Quantité Totale', 'nexo' ) );
		$crud->display_as('DEFECTUEUX', __( 'Quantité défectueuse', 'nexo' ) );
		$crud->display_as('FRAIS_ACCESSOIRE', __( 'Frais Accéssoires', 'nexo' ) );
		$crud->display_as('TAUX_DE_MARGE', __( 'Taux de marge', 'nexo' ) );
		$crud->display_as('PRIX_DE_VENTE', __( 'Prix de vente', 'nexo' ) );
		$crud->display_as('COUT_DACHAT', __( "Cout d'achat", 'nexo' ) );
		$crud->display_as('HAUTEUR', __( 'Hauteur', 'nexo' ) );
		$crud->display_as('LARGEUR', __( 'Largeur', 'nexo' ) );
		$crud->display_as('POIDS', __( 'Poids', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description', 'nexo' ) );
		$crud->display_as('COULEUR', __( 'Couleur', 'nexo' ) );
		$crud->display_as('APERCU', __( 'Aperçu de l\'article', 'nexo' ) );
		$crud->display_as('CODEBAR', __( 'Codebarre', 'nexo' ) );		
		$crud->display_as('PRIX_DACHAT', __( 'Prix d\'achat', 'nexo' ) );	
		$crud->display_as('DATE_CREATION', __( 'Crée le', 'nexo' ) );		
		$crud->display_as('DATE_MOD', __( 'Modifié le', 'nexo' ) );	
		$crud->display_as('AUTHOR', __( 'Auteur', 'nexo' ) );		
		$crud->display_as('QUANTITE_RESTANTE', __( 'Qte Rest.', 'nexo' ) );		
		$crud->display_as('QUANTITE_VENDU', __( 'Qte Vendue.', 'nexo' ) );		
		
		$crud->required_fields( 'DESIGN', 'REF_RAYON', 'REF_CATEGORIE', 'REF_SHIPPING', 'TAUX_DE_MARGE', 'FRAIS_ACCESSOIRE', 'PRIX_DE_VENTE', 'DEFECTUEUX', 'QUANTITY', 'PRIX_DACHAT' );
		
		$crud->set_field_upload( 'APERCU','public/upload/' );
		
		$crud->set_rules('QUANTITY', __( 'Quantité Totale', 'nexo' ), 'is_natural_no_zero' );
		$crud->set_rules('DEFECTUEUX', __( 'Quantité Defectueuse', 'nexo' ), 'is_natural' );
		$crud->set_rules('PRIX_DE_VENTE',__( 'Prix de vente', 'nexo' ),'is_natural');
		$crud->set_rules('TAUX_DE_MARGE', __( 'Taux de marge', 'nexo' ),'numeric');
		$crud->set_rules('FRAIS_ACCESSOIRE',__( 'Frais Accessoires', 'nexo' ),'is_natural');
		
		// Masquer le champ codebar
		$crud->change_field_type('CODEBAR','invisible');
		$crud->change_field_type('COUT_DACHAT','invisible');
		$crud->change_field_type('QUANTITE_RESTANTE','invisible');
		$crud->change_field_type('QUANTITE_VENDU','invisible');
		$crud->change_field_type('DATE_CREATION','invisible');
		$crud->change_field_type('DATE_MOD','invisible');
		$crud->change_field_type('AUTHOR','readonly');
		
		// Callback avant l'insertion
		$crud->callback_before_insert( array( $this->Nexo_Products, 'product_save' ) );
		$crud->callback_before_update( array( $this->Nexo_Products, 'product_update' ) );
		
		// $crud->unset_jquery();
		$output = $crud->render();
		
		foreach( $output->js_files as $files ) {
			
			if( ! strstr( $files, 'jquery-1.11.1.min.js' ) ){
				$this->enqueue->js( substr( $files, 0, -3 ), '' );
			//	var_dump( $files );
			}
		}
		foreach( $output->css_files as $files ) {
			$this->enqueue->css( substr( $files, 0, -4 ), '' );
		}
		
		return $output;
	}
	
	function lists( $page = 'index' )
	{
		if( $page == 'index' ){
			$this->Gui->set_title( __( 'Liste des articles &mdash; Nexo', 'nexo' ) );
		} else {
			$this->Gui->set_title( __( 'Ajouter un nouvel article &mdash; Nexo', 'nexo' ) );
		}
		// Protecting
		if( ! User::can( 'create_items' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_items_c' ) ); endif;
			
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1	=	'articles';		
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{
		// Protecting
		if( ! User::can( 'create_items' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_items_c' ) ); endif;		
		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1	=	'articles';
				$this->Gui->set_title( __( 'Ajouter un nouvel article &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Produits( $this->args );