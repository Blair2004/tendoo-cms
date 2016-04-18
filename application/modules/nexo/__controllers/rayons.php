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
		if( ! User::can( 'manage_radius' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_ray_c' ) ); endif;
		
		
		$crud = new grocery_CRUD();
		$crud->set_theme('bootstrap');
		$crud->set_subject( __( 'Rayons', 'nexo' ) );	
		$crud->set_table( $this->db->dbprefix( 'nexo_rayons' )  );
		$crud->columns( 'TITRE', 'DESCRIPTION' );
		$crud->fields( 'TITRE', 'DESCRIPTION' );
		
		$crud->display_as('TITRE', __( 'Nom du rayon', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description du rayon', 'nexo' ) );
		
		$crud->required_fields( 'TITRE' );
		
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
		$_var1	=	'rayons';		
			
		if( $page == 'add' ){
			$this->Gui->set_title( __( 'Créer un nouveau rayon &mdash; Nexo', 'nexo' ) );
		} else {
			$this->Gui->set_title( __( 'Liste des rayons &mdash; Nexo', 'nexo' ) );
		}
		
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'rayons';
		$this->Gui->set_title( __( 'Créer une nouveau rayon &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Rayons( $this->args );