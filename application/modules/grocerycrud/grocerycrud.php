<?php
class GroceryCrud extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'after_app_init', array( $this, 'init' ) );
	}
	function init()
	{
		global $Options;
		$language		=	'english';
		switch( @$Options[ 'site_language' ] ) {
			case 'en_US' : $language	= 	'english'; break;
			case 'fr_FR' : $language	= 	'french'; break;
		}
		
		$this->config->load( 'grocery_crud' );
		$this->config->set_item( 'grocery_crud_default_language', $language );
		
		$this->config->load( 'grocery_crud' );
		$this->load->library( 'Grocery_CRUD' );
	}
}
new GroceryCrud;