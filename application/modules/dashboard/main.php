<?php 
class dashboard_manager extends CI_model
{
	function __construct()
	{
		parent::__construct();		
		// load custom config
		$this->events->add_action( 'after_app_init' , array( $this , 'before_session_starts' ) );
		
	}
	
	/**
	 * 	Edit Tendoo.php config before session starts
	 *
	 *	@return	: void
	**/
	
	function before_session_starts()
	{
		$this->config->set_item( 'tendoo_logo_long' , '<b>Tend</b>oo' );
		$this->config->set_item( 'tendoo_logo_min' , '<img style="height:40px;" src="' . img_url() . 'logo_minim.png' . '" alt=logo>' );		
	}
}
new dashboard_manager;