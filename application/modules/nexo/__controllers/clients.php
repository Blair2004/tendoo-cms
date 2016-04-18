<?php
class Nexo_Clients extends CI_Model
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
		if( ! User::can( 'manage_shop' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_client_controller' ) ); endif;
		
		$crud = new grocery_CRUD();
		$crud->set_subject( __( 'Clients', 'nexo' ) );
		$crud->set_table( $this->db->dbprefix( 'nexo_clients' )  );
		$crud->set_theme('bootstrap');
		$crud->columns( 'NOM', 'PRENOM', 'OVERALL_COMMANDES', 'TEL', 'EMAIL' );
		$crud->fields( 'NOM', 'PRENOM', 'EMAIL', 'TAILLE', 'PREFERENCE', 'TEL', 'DATE_NAISSANCE', 'ADRESSE', 'DESCRIPTION' );
		
		$crud->display_as('NOM', __( 'Nom du client', 'nexo' ) );
		$crud->display_as('EMAIL', __( 'Email du client', 'nexo' ) );
		$crud->display_as('OVERALL_COMMANDES', __( 'Nombre de commandes' , 'nexo' ) );
		$crud->display_as('NBR_COMMANDES', __( 'Nbr Commandes (sess courante)', 'nexo' ) );
		$crud->display_as('TEL', __( 'Téléphone du client', 'nexo' ) );
		$crud->display_as('PRENOM', __( 'Prénom du client', 'nexo' ) );
		$crud->display_as('PREFERENCE', __( 'Préférence du client', 'nexo' ) );
		$crud->display_as('DATE_NAISSANCE', __( 'Date de naissance', 'nexo' ) );
		$crud->display_as('ADRESSE', __( 'Adresse', 'nexo' ) );
		$crud->display_as('TAILLE', __( 'Taille', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description', 'nexo' ) );
				
		$crud->required_fields( 'NOM' );
		
		$crud->set_rules('EMAIL',__( 'Email', 'nexo' ),'valid_email');
	 
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
		$_var1					=	'clients';		
				$this->Gui->set_title( __( 'Liste des clients &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'clients';
				$this->Gui->set_title( __( 'Ajouter un nouveau client &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	/**
	 * User Groups header
	 *
	**/
	
	function groups_header()
	{
		// Protecting
		if( ! User::can( 'manage_shop' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		$crud = new grocery_CRUD();
		$crud->set_subject( __( 'Groupes d\'utilisateurs', 'nexo' ) );
		$crud->set_table( $this->db->dbprefix( 'nexo_clients_groups' )  );
		$crud->set_theme('bootstrap');
		
		$crud->columns( 'NAME', 'AUTHOR', 'DATE_CREATION', 'DATE_MODIFICATION' );
		$crud->fields( 'NAME', 'DESCRIPTION', 'AUTHOR', 'DATE_CREATION', 'DATE_MODIFICATION' );
		
		$crud->display_as('NAME', __( 'Nom', 'nexo' ) );
		$crud->display_as('DESCRIPTION', __( 'Description', 'nexo' ) );
		$crud->display_as('AUTHOR', __( 'Auteur', 'nexo' ) );
		$crud->display_as('DATE_CREATION', __( 'Date de création', 'nexo' ) );
		$crud->display_as('DATE_MODIFICATION', __( 'Date de modification', 'nexo' ) );
		
		// Callback avant l'insertion
		$crud->callback_before_insert( array( $this, '__group_insert' ) );
		$crud->callback_before_update( array( $this, '__group_update' ) );
		
		// Field Visibility
		$crud->change_field_type('DATE_CREATION','invisible');
		$crud->change_field_type('DATE_MODIFICATION','invisible');
		
		$crud->required_fields( 'NAME' );
		
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
	
	/**
	 * Groups
	**/
	
	function groups()
	{
		$data[ 'crud_content' ]	=	$this->groups_header();
		$this->Gui->set_title( __( 'Groupes &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/user-groups.php', $data );
	}
	
	/**
	 * Callback
	**/
	
	function __group_insert( $data )
	{
		$data[ 'DATE_CREATION' ]	=	date_now();
		$data[ 'AUTHOR' ]			=	User::id();
		return $data;
	}
	
	function __group_update( $data )
	{
		$data[ 'DATE_MODIFICATION' ]	=	date_now();
		$data[ 'AUTHOR' ]				=	User::id();
		return $data;
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Clients( $this->args );