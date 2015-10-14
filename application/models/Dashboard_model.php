<?php
/**
 *
 * Title 	:	 Dashboard model
 * Details	:	 Manage dashboard page (creating, ouput)
 *
**/

class Dashboard_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();		
		$this->events->do_action( 'load_dashboard' );	
		$this->events->add_action( 'before_dashboard_menu' , array( $this , '__set_admin_menu' ) );
		$this->events->add_action( 'create_dashboard_pages' , array( $this , '__dashboard_config' ) );			
		$this->events->add_action( 'dashboard_header', array( $this, '__dashboard_header' ) );
		$this->events->add_action( 'dashboard_footer', array( $this, '__dashboard_footer' ) );
		$this->events->add_filter( 'dashboard_home_output', array( $this, '__home_output' ) );
	}
	
	/**
	 * Load dashboard widgets
	**/
	
	function load_widgets()
	{
		// get global widget and cols
		global $AdminWidgets;
		global $AdminWidgetsCols;
		
		// looping cols
		for( $i = 1; $i <= 4; $i++ ) {
			$widgets_namespace	=	$this->dashboard_widgets->col_widgets( $i );
			
			$this->gui->col_width( 1, 1 );
			$this->gui->col_width( 2, 1 );
			$this->gui->col_width( 3, 1 );
			$this->gui->col_width( 4, 1 );
			
			foreach( $widgets_namespace as $widget_namespace ) {
				// get widget
				$widget_options	=	$this->dashboard_widgets->get( $widget_namespace );
				// create meta
				$this->gui->add_meta( array(
					'col_id'	=>	$i,
					'namespace'	=>	$widget_namespace,
					'type'		=>	riake( 'type', $widget_options ),
					'title'		=>	riake( 'title', $widget_options )
				) );
				// create dom
				$this->gui->add_item( array(
					'type'		=>	'dom',
					'value'		=>	'<h3>Hello World</h3>'
				), $widget_namespace, $i );
			}
		}
	}
	
	function __dashboard_footer()
	{
		$segments	= $this->uri->segment_array();
		if( riake( 2, $segments, 'index' ) == 'index' ) {
		?>
        <script>
		$( '.row .box' ).draggable({
			connectToSortable : '.row .col-lg-3',
			scope	:	'widget',
			// containment 	:	'.row .col-lg-3'
		});
		$( '.row .col-lg-3').droppable({
			accept	: 	'.row .box',
			addClass : 'bg-primary',
			scope 	:	'widget'
		});
		$( '.row .col-lg-3').sortable({
			connectWith	: 	'.row .box',
			forceHelperSize : true
		});
        </script>
        <?php
		}
	}
	function __dashboard_header()
	{
		// Including Highlight.js
		?>
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/styles/default.min.css">
      <script type="text/javascript" src="http://underscorejs.org/underscore-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/highlight.min.js"></script>
      <script>
		jQuery(document).ready(function(){
			hljs.initHighlightingOnLoad();
		})</script>
      <?php
	}
	function __dashboard_config()
	{
		$this->gui->register_page( 'index' , array( $this , 'index' ) );
		$this->gui->register_page( 'settings' , array( $this , 'settings' ) );
	}
	function index()
	{
		// load widget model here only
		$this->load->model( 'dashboard_widgets_model', 'dashboard_widgets' );
		
		// trigger action while loading home (for registering widgets)
		$this->events->do_action( 'load_dashboard_home' );
		$this->load_widgets();
		
		$this->gui->set_title( sprintf( __( 'Dashboard &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/index/body' );
	}
	
	function settings()
	{
		$this->gui->set_title( sprintf( __( 'Settings &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/settings/body' );
	}
	
	public function __set_admin_menu()
	{	
		$admin_menus		=	array(
			'dashboard'		=>	array(
				array(	
					'href'			=>		site_url('dashboard'),
					'icon'			=>		'fa fa-dashboard',
					'title'			=>		__( 'Dashboard' )
				),
				array(	
					'href'			=>		site_url( array( 'dashboard', 'update' ) ),
					'icon'			=>		'fa fa-dashboard',
					'title'			=>		__( 'Update Center' )
				),
			),
			/** 'media'			=>	array(
				array(
					'title'			=>		__( 'Media Library' ),
					'icon'			=>		'fa fa-image',
					'href'			=>		site_url('dashboard/media')
				)
			),
			'installer'			=>	array(
				array(
					'title'			=>		__( 'Install Apps' ),
					'icon'			=>		'fa fa-flask',
					'href'			=>		site_url('dashboard/installer')
				)
			),
			**/
			'modules'			=>	array(
				array(
					'title'			=>		__( 'Modules' ),
					'icon'			=>		'fa fa-puzzle-piece',
					'href'			=>		site_url('dashboard/modules')
				)
			),
			/** 'themes'			=>	array(
				array(
					'title'			=>		__( 'Themes' ),
					'icon'			=>		'fa fa-columns',
					'href'			=>		site_url('dashboard/themes')
				),
				array(
					'href'			=>		site_url('dashboard/controllers'),
					'icon'			=>		'fa fa-bookmark',
					'title'			=>		__( 'Menus' )
				)
			),
			**/
			'settings'			=>	array(
				array(
					'title'			=>		__( 'Settings' ),
					'icon'			=>		'fa fa-cogs',
					'href'			=>		site_url('dashboard/settings')
				)
			),
		);
		
		foreach( force_array( $this->events->apply_filters( 'admin_menus' , $admin_menus ) ) as $namespace => $menus )
		{
			foreach( $menus as $menu )
			{
				Menu::add_admin_menu_core( $namespace , $menu  );
			}
		}		
	}	
}