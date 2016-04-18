<?php
class Reset_Shop extends CI_Model
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
	function defaults()
	{
		// Vérification de la permission du requérant
		
		if( User::can( 'manage_shop' ) ) {
			
			// Vérification de l'identifiacation du requérant
			
			if( get_instance()->auth->test_credentials( User::id(), @$_POST[ '_nexo_uz_pwd' ] )	) {
				
				if( @$_POST[ 'reset_type' ] == 'empty_shop' ) { // Sans contenu demo
				
					$this->load->model( 'Nexo_Misc' );
					$this->Nexo_Misc->empty_shop();
					
					echo json_encode( array(
						'type'		=>	'success', 
						'msg'		=>	__( 'La boutique a correctement été vidée.', 'nexo' )
					) );	
					
				} else if( @$_POST[ 'reset_type' ] == 'empty_with_demo' ) { // Avec le contenu demo à l'appui
				
					$this->load->model( 'Nexo_Misc' );
					$this->Nexo_Misc->enable_demo();
					
					echo json_encode( array(
						'type'		=>	'success', 
						'msg'		=>	__( 'La boutique a correctement été vidée, et les données "démo" ont été ajoutées.', 'nexo' )
					) );	
					
				} else {
					
					echo json_encode( array(
						'type'		=>	'warning', 
						'msg'		=>	__( 'Impossible de déterminer l\'action à effectuer pour la restauration.', 'nexo' )
					) );	
					
				}
			} else {
				
				echo json_encode( array(
					'type'		=>	'warning', 
					'msg'		=>	__( 'Le mot de passe spécifié est incorrect. Veuillez fournir votre mot de passe "Super administrateur" ou "gérant de la boutique".', 'nexo' )
				) );	
				
			}
		} else {
			
			echo json_encode( array(
				'type'		=>	'warning', 
				'msg'		=>	__( 'Vous n\'avez pas les permissions requises pour effectuer cette action', 'nexo' )
			) );
			
		}
	}
}
new Reset_Shop( $this->args );