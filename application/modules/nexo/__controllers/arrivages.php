<?php
class Nexo_Arrivages extends CI_Model
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
		// Protecting
		if( ! User::can( 'manage_shipping' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_shipping_page' ) ); endif;
		
		$crud = new grocery_CRUD();
		$crud->set_theme('bootstrap');
		$crud->set_subject( __( 'Livraisons', 'nexo' ) );	

		$crud->set_table( $this->db->dbprefix( 'nexo_arrivages' )  );
		$crud->columns( 'TITRE', 'FOURNISSEUR_REF_ID', 'DESCRIPTION' );
		$crud->fields( 'TITRE', 'FOURNISSEUR_REF_ID', 'DESCRIPTION' );
		$crud->set_relation( 'FOURNISSEUR_REF_ID', 'nexo_fournisseurs','NOM');
		
		$crud->display_as('TITRE', __( 'Nom de la livraison', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description', 'nexo' ) );
		$crud->display_as('FOURNISSEUR_REF_ID', __( 'Fournisseur', 'nexo' ) );
		
		// Liste des produits
		$crud->add_action( __( 'Etiquettes des articles', 'nexo' ), '', site_url( array( 'dashboard', 'nexo', 'print', 'shipping_item_codebar' ) ) . '/', 'btn btn-success fa fa-file' );
		
		$crud->required_fields( 'TITRE', 'FOURNISSEUR_REF_ID' );
		
		$crud->unset_jquery();
		$output = $crud->render();
				
		foreach( $output->js_files as $files ) {
			$this->enqueue->js( substr( $files, 0, -3 ), '' );
		}
		foreach( $output->css_files as $files ) {
			$this->enqueue->css( substr( $files, 0, -4 ), '' );
		}
		return $output;
	}
	
	function lists( $page = 'index' )
	{
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1	=	'arrivages';		
		
		if( $page == 'index' ) {
			$this->Gui->set_title( __( 'Liste des livraisons &mdash; Nexo', 'nexo' ) );
		} else {
			$this->Gui->set_title( __( 'Ajouter une nouvelle livraison &mdash; Nexo', 'nexo' ) );	
		}
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1	=	'arrivages';
		$this->Gui->set_title( sprintf( __( 'Ajouter une nouvelle livraison : &mdash; %s', 'nexo' ) , ucwords( str_replace( '_' , ' ' , $_var1 ) ), get( 'core_signature' ) ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Arrivages( $this->args );