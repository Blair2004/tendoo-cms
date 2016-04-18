<?php
class Nexo_Bon_Davoir extends CI_Model
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
		$crud = new grocery_CRUD();

		$crud->set_theme('bootstrap');
		$crud->set_subject( 'Bon d\'avoir' );	

		$crud->set_table( $this->db->dbprefix( 'nexo_bon_davoir' )  );
		$crud->columns( 'RAISON', 'DESCRIPTION', 'DATE_CREATION', 'DATE_MOD', 'AUTHOR', 'REF_CLIENT', 'REF_COMMAND', 'MONTANT' );
		$crud->fields( 'RAISON', 'MONTANT', 'REF_PRODUCT_CODEBAR', 'REF_CLIENT', 'COMMANDE_REF_ID', 'DESCRIPTION', 'DATE_MOD', 'DATE_CREATION' );
		
		$crud->set_relation( 'COMMANDE_REF_ID', 'nexo_commandes', 'CODE' );
		$crud->set_relation( 'REF_CLIENT', 'nexo_clients', 'NOM' );
		
		$crud->display_as('RAISON', __( "Justification du bon d'avoir", 'nexo' ) );
		$crud->display_as('REF_CLIENT', __( "Client concerné", 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( "Détails du bon d'avoir", 'nexo' ) );
		$crud->display_as( 'REF_PRODUCT_CODEBAR', __( 'Article concerné (Code Barre)', 'nexo' ) );
		$crud->display_as('COMMANDE_REF_ID', __( 'Choisir la commande concernée', 'nexo' ) );
		$crud->display_as('MONTANT', __( "Montant du bon d'avoir", 'nexo' ) );
		
		$crud->required_fields( 'MONTANT', 'RAISON', 'REF_CLIENT' );
		
		$crud->change_field_type('TITRE','readonly');
		$crud->change_field_type('DATE_CREATION','invisible');
		$crud->change_field_type('DATE_MOD','invisible');
		$crud->change_field_type('AUTHOR','readonly');
		
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
	
	function lists()
	{
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'bon_davoir';		
				$this->Gui->set_title( __( 'Liste des bons d\'avoir &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'bon_davoir';
				$this->Gui->set_title( __( 'Créer un nouveau bon d\'avoir &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}	
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Bon_Davoir( $this->args );