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
		
		// $this->output->enable_profiler(TRUE);
		// All those variable are not required for option interface
		// Special assets loading for dashboard
		
		// include static libraries
		include_once( LIBPATH .'/Menu.php' );
		include_once( LIBPATH .'/Notice.php' );
		
		$this->load->model( 'gui' );		
		$this->load->model( 'update_model' ); // load update model @since 3.0
		$this->load->model( 'dashboard_model' , 'dashboard' );
		
		// Loading Admin Menu
		// this action was move to Dashboard controler instead of aside.php output file. 
		// which was called every time "create_dashboard_pages" was triggered
		$this->events->do_action( 'load_dashboard' );
	}
	/**
	 * Remap controller methods
	 *
	 *
	 * @access       public
	 * @author       Blair Jersyer
	 * @copyright    2015
	 * @param        string $page part of segment
	 * @param 		  array $params the siblings segments
	 * @since        3.0.1
	 */
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
	/**
	 * Module List and management controller
	 *
	 *
	 * @access       public
	 * @author       Blair Jersyer
	 * @copyright    name date
	 * @param        string $page
	 * @param		  string $arg2
	 * @since        3.0.1
	 */
	function modules( $page = 'list' , $arg2 = null )
	{
		if( $page === 'list' )
		{
			$this->events->add_filter( 'gui_page_title' , function( $title ){
				return '<section class="content-header"><h1>' . strip_tags( $title ) . ' <a class="btn btn-primary btn-sm pull-right" href="' . site_url( array( 'dashboard' , 'modules' , 'install_zip' ) ) . '">' . __( 'Upload a zip file' ) . '</a></h1></section>'; 
			});
			
			$this->events->add_action( 'displays_dashboard_errors' , function(){
				if( isset( $_GET[ 'extra' ] ) )
				{
					echo tendoo_error( __( 'An error occured during module installation. There was a file conflict during module installation process.<br>This file seems to be already installed : ' . $_GET[ 'extra' ] ) );
				}
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
					// redirecting
					redirect( array( 'dashboard' , 'modules' , 'list?highlight=' . $notice[ 'namespace' ] . '&notice=' . $notice[ 'msg' ] . ( isset( $notice[ 'extra' ] ) ? '&extra=' . $notice[ 'extra' ] : '' ) . '#module-' . $notice[ 'namespace' ] ) );
				}
				else
				{
					$this->notice->push_notice( $this->lang->line( $notice ) );
				}
				
			}
			$this->gui->set_title( sprintf( __( 'Add a new extension &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/modules/install' );
		}		
		else if( $page === 'enable' )
		{
			/**
			 * Module should be enabled before trigger this action
			**/
			
			Modules::enable( $arg2 );
			
			// Enabling recently active module
			Modules::init( 'unique' , $arg2 );
			
			// Run the action
			$this->events->do_action( 'do_enable_module' , $arg2 );
			redirect( array( 'dashboard' , 'modules?notice=' . $this->events->apply_filters( 'module_activation_status' , 'module-enabled' ) ) );
		}
		else if( $page === 'disable' )
		{
			$this->events->add_action( 'do_disable_module' , function( $arg2 ){
				Modules::disable( $arg2 );
			});
			//
			$this->events->do_action( 'do_disable_module' , $arg2 );
			
			redirect( array( 'dashboard' , 'modules?notice=' . $this->events->apply_filters( 'module_disabling_status' , 'module-disabled' ) ) );
		}
		else if( $page === 'remove' )
		{
			$this->events->add_action( 'do_remove_module' , function( $arg2 ){
				Modules::uninstall( $arg2 );				
				redirect( array( 'dashboard' , 'modules?notice=module-removed' ) );
			});
			
			$this->events->do_action( 'do_remove_module' , $arg2 );
		}
		else if( $page === 'extract' )
		{
			$this->events->add_action( 'do_extract_module' , function( $arg2 ){
				Modules::extract( $arg2 );
			});
			
			$this->events->do_action( 'do_extract_module' , $arg2 );
		}
	}
	/**
	 * Options Management ocntroller
	 *
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    name date
	 * @param        string $page
	 * @param		  string $arg2
	 * @since        3.0.1
	 */
	function options( $mode = 'list' )
	{
		if( in_array( $mode, array( 'save', 'merge' ) ) )
		{
			if( ! $this->input->post( 'gui_saver_ref' ) && ! $this->input->post( 'gui_json' ) ) // if JSON mode is enabled redirect is disabled
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
						/**
						 * Merge options which a supposed to be wrapped within the same array
						**/
						
						if( $mode == 'merge' && is_array( $value ) ) {
							$options	=	$this->options->get( $key ); 
							$options	=	array_merge( force_array( $options ), $value );
						}
						// save only when it's not an array
						if( ! is_array( $_POST[ $key ] ) )
						{
							if( $this->input->post( 'gui_saver_use_namespace' ) === 'true' ) {
								$content[ $key ]	=	( $mode == 'merge' ) ? $options : $this->input->post( $key );	
							}	else	{
								if( $mode == 'merge' && is_array( $value ) ) {
									$this->options->set( $key , $options , true );
								} else {
									$this->options->set( $key , $this->input->post( $key ) , true );
								}
							}							
						} else {
							if( $this->input->post( 'gui_saver_use_namespace' ) === 'true' )	{
								$content[ $key ]	=	( $mode == 'merge' ) ? $options : $_POST[ $key ];	
							}	else	{
								if( $mode == 'merge' && is_array( $value ) ) {
									$this->options->set( $key , $options , true );
								} else {
									$this->options->set( $key, $_POST[ $key ], true );
								}
							}	
						}
					}
				}
				// saving all post using namespace
				if( $this->input->post( 'gui_saver_use_namespace' ) == 'true' )
				{
					$this->options->set( $this->input->post( 'gui_saver_option_namespace' ) , $content , true );
				}
				if( ! $this->input->post( 'gui_json' ) ) { // if JSON mode is enabled redirect is disabled
					redirect( urldecode( $this->input->post( 'gui_saver_ref' ) ) . '?notice=option-saved' );
				}
			}
		}
		else if( $mode == 'get' ) {
			echo json_decode( $this->options->get( $_POST[ 'option_key' ] ) );
		}
		else if( in_array( $mode, array( 'save_user_meta', 'merge_user_meta' ) ) )
		{
			if( $this->input->post( 'gui_saver_expiration_time' ) >  gmt_to_local( time() , 'UTC' ) )
			{
				$content	=	array();
				// loping post value
				foreach( $_POST as $key => $value )
				{
					if( ! in_array( $key , array( 'gui_saver_option_namespace' , 'gui_saver_ref' , 'gui_saver_expiration_time' , 'gui_saver_use_namespace' , 'user_id' ) ) )
					{
						if( $mode == 'merge_user_meta' && is_array( $value ) ) {
							$options	=	$this->options->get( $key ); 
							$options	=	array_merge( force_array( $options ), $value );
						}
						// save only when it's not an array
						if( ! is_array( $_POST[ $key ] ) )
						{
							if( $this->input->post( 'gui_saver_use_namespace' ) === 'true' ) {
								$content[ $key ]	=	( $mode == 'merge' ) ? $options : $this->input->post( $key );	
							}	else	{
								if( $mode == 'merge' && is_array( $value ) ) {
									$this->options->set( $key , $options , true, $this->input->post( 'user_id' ) );
								} else {
									$this->options->set( $key , $this->input->post( $key ), true, $this->input->post( 'user_id' ) );
								}
							}
						} else {
							if( $this->input->post( 'gui_saver_use_namespace' ) === 'true' )	{
								$content[ $key ]	=	( $mode == 'merge' ) ? $options : $_POST[ $key ];	
							} else {
								if( $mode == 'merge' && is_array( $value ) ) {
									$this->options->set( $key , $options , true, $this->input->post( 'user_id' ) );
								} else {
									$this->options->set( $key, $_POST[ $key ], true, $this->input->post( 'user_id' ) );
								}
							}
						}
					}
				}
			}
		}
	}
		/**
	 * Options Management ocntroller
	 *
	 *
	 * @access       public
	 * @author       Blair Jersyer
	 * @copyright    name date
	 * @param        string $page
	 * @param		  string $arg2
	 * @since        3.0.1
	 */
	function update( $page = 'home' ,  $version = null )
	{
		if( $page === 'core' ){
			$this->gui->set_title( sprintf( __( 'Updating... &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/update/core' , array(
				'release'	=>	$version
			) );
		} elseif( $page === 'download' ){
			echo json_encode( $this->update_model->install( 1 , $version ) );
		} elseif( $page === 'extract' ){
			echo json_encode( $this->update_model->install( 2 ) );
		} elseif( $page === 'install' ){
			echo json_encode( $this->update_model->install( 3 ) );
		} else {
			$this->gui->set_title( sprintf( __( 'Update Center &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/update/home' , array() );
		}
	}
	
	/**
	 * About controller
	 *
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    name date
	 * @since        3.0.1
	 */
	public function about()
	{
		$this->events-> add_filter( 'gui_page_title' , function(){ // disabling header
			return;
		});
		
		$this->gui->set_title( sprintf( __( 'About &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/about/body' );
	}
}

