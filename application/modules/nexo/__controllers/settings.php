<?php
class Nexo_Rest extends CI_Model
{
	function __construct( $args )
	{
		parent::__construct();
		if( is_array( $args ) && count( $args ) > 1 ) {
			if( method_exists( $this, $args[1] ) ){
				return call_user_func_array( array( $this, $args[1] ), array_slice( $args, 2 ) );
			} else {
				return $this->index();
			}			
		}
		return $this->index();
	}
	
	function index()
	{
		$this->Gui->set_title( __( 'Réglages de la boutique &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/settings.php' );
	}
}
new Nexo_Rest( $this->args );