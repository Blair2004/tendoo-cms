<?php
class Nexo_Categories extends CI_Model
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
		if( ! User::can( 'manage_vendor' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_vendor_controller' ) ); endif;
		
		$crud = new grocery_CRUD();
		$crud->set_subject( __( 'Fournisseurs', 'nexo' ) );
		$crud->set_theme('bootstrap');
		// $crud->set_theme( 'bootstrap' );
		$crud->set_table( $this->db->dbprefix( 'nexo_fournisseurs' )  );
		$crud->columns( 'NOM', 'BP', 'TEL', 'EMAIL', 'DESCRIPTION' );
		$crud->fields( 'NOM', 'BP', 'TEL', 'EMAIL', 'DESCRIPTION' );
		
		$crud->display_as('NOM',__( 'Nom du fournisseur', 'nexo' ) );
		$crud->display_as('EMAIL',__( 'Email du fournisseur', 'nexo' ) );
		$crud->display_as('BP', __( 'BP du fournisseur', 'nexo' ) );
		$crud->display_as('TEL', __( 'Tel du fournisseur', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description du fournisseur', 'nexo' ) );
		
		$crud->required_fields( 'NOM' );
		
		$crud->set_rules('EMAIL','Email','valid_email');
		// $crud->columns('customerName','phone','addressLine1','creditLimit');
	 
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
		$_var1					=	'fournisseurs';		
		
		if( $page == 'index' ){
			$this->Gui->set_title( __( 'Liste des fournisseurs &mdash; Nexo', 'nexo' ) );
		} else {
			$this->Gui->set_title( __( 'Ajouter un nouveau fournisseur &mdash; Nexo', 'nexo' ) );
		}
		
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'fournisseurs';
				$this->Gui->set_title( __( 'Ajouter un nouveau fournisseur &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Categories( $this->args );