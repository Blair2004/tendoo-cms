<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Tendoo_Controller {
	/**
	 * Admin controller
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/admin
	 *	- or -
	 * 		http://example.com/index.php/admin/index
	 *	- or -
	 * this controller is in other words admin dashboard.
	 */
	 
	public function __construct()
	{
		parent::__construct();
		
		// $this->output->enable_profiler(TRUE);
		// All those variable are not required for option interface
		// Special assets loading for dashboard
		
		// include static libraries
		include_once( LIBPATH .'/Menu.php' );
		include_once( LIBPATH .'/Notice.php' );
		
		// Enqueuing slimscroll
		Enqueue::enqueue_js( '../plugins/SlimScroll/jquery.slimscroll.min' );
		Enqueue::enqueue_js( 'tendoo.core' );
		
		
		$this->load->model( 'gui' );
		$this->load->model( 'dashboard_model' , 'dashboard' );
		
		// Loading Admin Menu
		// this action was move to Dashboard controler instead of aside.php output file. 
		// which was called every time "create_dashboard_pages" was triggered
		$this->events->do_action( 'before_admin_menu' );
	}
	function _remap( $page , $params = array() )
	{
		if( method_exists( $this , $page ) )
		{
			return call_user_func_array( array( $this, $page ), $params);
		}
		else
		{			
			$this->gui->load_page( $page , $params );
		}
	} 
	function modules( $page = 'list' )
	{
		if( $page === 'list' )
		{
			$this->events->add_filter( 'gui_page_title' , function( $title ){
				return '<section class="content-header"><h1>' . strip_tags( $title ) . ' <a class="btn btn-primary btn-sm pull-right" href="' . site_url( array( 'dashboard' , 'modules' , 'install_zip' ) ) . '">' . __( 'Upload a zip file' ) . '</a></h1></section>'; 
			});
			$this->gui->set_title( sprintf( __( 'Module List &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/modules/list' );
		}
		else if( $page === 'install_zip' )
		{
			$this->events->add_filter( 'gui_page_title' , function( $title ){
				return '<section class="content-header"><h1>' . strip_tags( $title ) . ' <a class="btn btn-primary btn-sm pull-right" href="' . site_url( array( 'dashboard' , 'modules' ) ) . '">' . __( 'Back to modules list' ) . '</a></h1></section>'; 
			});
			if( isset( $_FILES[ 'extension_zip' ] ) )
			{
				$notice	=	Modules::install( 'extension_zip' );
				
				// it means that module has been installed
				if( is_array( $notice ) )
				{
					redirect( array( 'dashboard' , 'modules' , 'list?highlight=' . $notice[ 'namespace' ] . '&notice=' . $notice[ 'msg' ] ) );
				}
				
			}
			$this->gui->set_title( sprintf( __( 'Add a new extension &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/modules/install' );
		}		
	}
	function options( $mode = 'list' )
	{
		if( $mode == 'save' )
		{
			if( ! $this->input->post( 'gui_saver_ref' ) )
			{
				redirect( array( 'dashboard' , 'options' ) );
			}
			if( $this->input->post( 'gui_saver_expiration_time' ) >  gmt_to_local( time() , 'UTC' ) )
			{
				$content	=	array();
				// loping post value
				foreach( $_POST as $key => $value )
				{
					if( ! in_array( $key , array( 'gui_saver_option_namespace' , 'gui_saver_ref' , 'gui_saver_expiration_time' , 'gui_saver_use_namespace' ) ) )
					{
						// save only when it's not an array
						if( ! is_array( $_POST[ $key ] ) )
						{
							if( $this->input->post( 'gui_saver_use_namespace' ) == 'true' )
							{
								$content[ $key ]	=	$this->input->post( $key );	
							}
							else
							{
								$this->options->set( $key , $this->input->post( $key ) );
							}							
						}
					}
				}
				// saving all post using namespace
				if( $this->input->post( 'gui_saver_use_namespace' ) == 'true' )
				{
					$this->options->set( $this->input->post( 'gui_saver_option_namespace' ) , $content );
				}
				redirect( urldecode( $this->input->post( 'gui_saver_ref' ) ) . '?notice=option-saved' );
			}
		}
		else if( $mode == 'save_user_meta' )
		{
			if( $this->input->post( 'gui_saver_expiration_time' ) >  gmt_to_local( time() , 'UTC' ) )
			{
				$content	=	array();
				// loping post value
				foreach( $_POST as $key => $value )
				{
					if( ! in_array( $key , array( 'gui_saver_option_namespace' , 'gui_saver_ref' , 'gui_saver_expiration_time' , 'gui_saver_use_namespace' , 'user_id' ) ) )
					{
						// save only when it's not an array
						if( ! is_array( $_POST[ $key ] ) )
						{
							$this->options->set( $key , $this->input->post( $key ) , true , $this->input->post( 'user_id' ) );
						}
					}
				}
			}
		}
	}
}
