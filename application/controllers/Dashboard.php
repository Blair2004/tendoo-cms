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
		
		// Special assets loading for dashboard
		$this->enqueue->enqueue_js( 'plugins/SlimScroll/jquery.slimscroll.min' );
		
		$this->load->library( 'menu' );	
		$this->load->model( 'gui' );
		$this->load->model( 'dashboard_model' , 'dashboard' );
		
		// Loading Admin Menu
		// this action was move to Dashboard controler instead of aside.php output file. 
		// which was called every time "create_dashboard_pages" was triggered
		$this->events->do_action( 'before_admin_menu' );
	}
	
	function index()
	{
		$this->page( 'home' );
	}
	
	function page( $page = 'home' )
	{
		$this->gui->load_page( $page );
	}
	function options( $mode = 'list' )
	{
		if( $mode = 'save' )
		{
			echo 'TRUE';
		}
	}
	
	
}
