<?php
class Tendoo_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		// Include default library class
		include_once( LIBPATH .'/Html.php' );
		include_once( LIBPATH .'/Enqueue.php' );
		include_once( LIBPATH .'/Modules.php' );
		include_once( LIBPATH .'/UI.php' );
		
		// get system lang
		$this->lang->load( 'system' );	
		
		// Load Modules
		Modules::load( MODULESPATH );
		
		// if is installed, setup is always loaded
		if( $this->setup->is_installed() )
		{
			/**
			 * Load Session, Database and Options
			**/
			$this->load->library( 'session' );
			$this->load->database();
			$this->load->model( 'options' );			
			
			// Get Active Modules and load it
			Modules::init( 'actives' );
			
			$this->events->do_action( 'after_app_init' );
		}
		// Only for controller requiring installation
		else if( $this->uri->segment(1) === 'tendoo-setup' && $this->uri->segment(2) === 'database' )
		{
			$this->events->add_action( 'before_setting_tables' , function(){
				// this hook let modules being called during tendoo installation
				// Only when site name is being defined
				Modules::init( 'all' );
			});
		}
		// if is reserved controllers only
		if( in_array( $this->uri->segment(1) , $this->config->item( 'reserved_controllers' ) ) )
		{
			$this->load->library( 'notice' );
		}
				
		// Checks system status
		if( in_array( $this->uri->segment(1) , $this->config->item( 'reserved_controllers' ) ) || $this->uri->segment(1) === null ) // null for index page
		{			
			// there are some section which need tendoo to be installed. Before getting there, tendoo controller checks if for those
			// section tendoo is installed. If segment(1) returns null, it means the current section is index. Even for index,
			// installation is required
			if( ( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_installation' ) ) || $this->uri->segment(1) === null ) && ! $this->setup->is_installed() )
			{
				redirect( array( 'tendoo-setup' ) );
			}

			// force user to be connected for certain controller
			if( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_logout' ) ) && $this->setup->is_installed() )
			{
				$this->events->do_action( 'is_connected' );
			}
			
			// loading assets for reserved controller
			Enqueue::enqueue_css( 'bootstrap.min' );
			Enqueue::enqueue_css( 'AdminLTE.min' );
			Enqueue::enqueue_css( 'skins/_all-skins.min' );			
			Enqueue::enqueue_css( 'font-awesome-4.3.0' );
			Enqueue::enqueue_css( '../plugins/iCheck/square/blue' );
			
			/**
			 * 	Enqueueing Js
			**/
			
			Enqueue::enqueue_js( '../plugins/jQuery/jQuery-2.1.4.min' );
			Enqueue::enqueue_js( 'bootstrap.min' );
			Enqueue::enqueue_js( '../plugins/iCheck/icheck.min' );		
			Enqueue::enqueue_js( 'app.min' );
		}
	}
}