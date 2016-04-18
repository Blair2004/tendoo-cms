<?php
class Nexo_Rayons extends CI_Model
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
		if( ! User::can( 'manage_shop' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_payment_means_controller' ) ); endif;
		
		$crud = new grocery_CRUD();
		$crud->set_theme('bootstrap');
		$crud->set_subject( __( 'Moyen de paiement', 'nexo' ) );	
		$crud->set_table( $this->db->dbprefix( 'nexo_paiements' )  );
		$crud->columns( 'DESIGN', 'DESCRIPTION' );
		$crud->fields( 'DESIGN', 'DESCRIPTION' );
		
		$crud->display_as('DESIGN', __( 'Intitulé du moyen', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description', 'nexo' ) );
		
		$crud->required_fields( 'DESIGN' );
		
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
		$_var1	=	'paiements';		
				$this->Gui->set_title( __( 'Liste des types de paiements &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'paiements';
				$this->Gui->set_title( __( 'Ajouter un nouveau type de paiement &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Rayons( $this->args );