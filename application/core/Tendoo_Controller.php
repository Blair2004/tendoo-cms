<?php
class Tendoo_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		// get system lang
		$this->lang->load( 'system' );	
		
		// if is installed, setup is always loaded
		if( $this->setup->is_installed() )
		{
			// Load internal modules here
			$this->load->model( 'internal_modules' );
			// Should load modules and themes heres
			// triggers actions before session init
			$this->events->do_action( 'before_session_start' );			
			
			$this->load->model( 'options' );
			$this->load->model( 'users_model' , 'users' ); // run after flexi_auth
			
			// If there is no master user , redirect to master user creation if current controller isn't tendoo-setup
			if( ! $this->users->master_exists() && $this->uri->segment(1) != 'tendoo-setup' )
			{
				redirect( array( 'tendoo-setup' , 'site' ) );
			}
		}
		
		// if is reserved controllers only
		if( in_array( $this->uri->segment(1) , $this->config->item( 'reserved_controllers' ) ) )
		{
			$this->load->helper( 'ui' );
			$this->load->library( 'notice' );
		}
				
		// Checks system status
		if( in_array( $this->uri->segment(1) , $this->config->item( 'reserved_controllers' ) ) || $this->uri->segment(1) == null ) // null for index page
		{			
			// there are some section which need tendoo to be installed. Before getting there, tendoo controller checks if for those
			// section tendoo is installed. If segment(1) returns null, it means the current section is index. Even for index,
			// installation is required
			if( ( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_installation' ) ) || $this->uri->segment(1) == null ) && ! $this->setup->is_installed() )
			{
				redirect( array( 'tendoo-setup' ) );
			}
			// force user to be connected for certain controller
			if( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_login' ) ) && $this->setup->is_installed() )
			{
				if( ! $this->users->is_connected() )
				{
					redirect( array( $this->config->item( 'default_login_route' ) ) );
				}
			}

			// force user to be connected for certain controller
			if( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_logout' ) ) && $this->setup->is_installed() )
			{
				if( $this->users->is_connected() )
				{
					redirect( array( $this->config->item( 'default_logout_route' ) ) );
				}
			}
			
			// loading assets for reserved controller
			$this->enqueue->enqueue_css( 'bootstrap.min' );
			$this->enqueue->enqueue_css( 'AdminLTE.min' );
			$this->enqueue->enqueue_css( 'skins/_all-skins.min' );			
			$this->enqueue->enqueue_css( 'font-awesome-4.3.0' );
			$this->enqueue->enqueue_css( '../plugins/iCheck/square/blue' );
			/**
			 * 	Enqueueing Js
			**/
			
			$this->enqueue->enqueue_js( '../plugins/jQuery/jQuery-2.1.4.min' );
			$this->enqueue->enqueue_js( 'bootstrap.min' );
			$this->enqueue->enqueue_js( '../plugins/iCheck/icheck.min' );		
			$this->enqueue->enqueue_js( 'app.min' );
		}
	}
}