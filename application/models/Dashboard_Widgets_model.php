<?php
class Dashboard_Widgets_Model extends CI_Model
{
	public function __construct()
	{
		global $AdminWidgetsCols;
		if( $AdminWidgetsCols === NULL ) {
			$AdminWidgetsCols	=	array();
		}
	}
	/**
	 * Create a new Admin Widget
	 * 
	 * @since 3.1
	 * @access public
	 * @param string widget namespace
	 * @param array widget config
	 * @return void
	**/
	function add( $namespace, $config )
	{
		// Get Admin Widgets
		global $AdminWidgets;
		$AdminWidgets = ( $AdminWidgets === null ) ? array() : $AdminWidgets;
		
		$AdminWidgets[ $namespace ]	=	$config;	
		$this->save_position( $namespace, riake( 'position', $config, 1 ) );	
	}
	
	/**
	 * Load saved Admin widget
	 *
	 * @access public
	 * @since 3.1
	 * @return array
	**/
	
	function get( $namespace )
	{
		global $AdminWidgets;
		$AdminWidgets === null ? array() : $AdminWidgets;
		
		// if widgets exists
		if( isset( $AdminWidgets[ $namespace ] ) ) {
			return $AdminWidgets[ $namespace ];
		}
		return array();
	}
	
	/**
	 * Output Widget
	 * 
	 * @since 3.1
	 * @return void
	 * @param array widget config
	 * @access public
	**/
	
	function displays( $widget_config ) 
	{
		if( $view_path = riake( 'view', $widget_config ) ) {
			$output	= $this->load->view( $view_path, array(), true );
		}
	}
	
	/**
	 * Save Widget Position
	 * 
	 * @since 3.1
	 * @param string widget namespace
	 * @param int col id
	 * @return void
	 * @access public
	**/
	
	function save_position( $widget_namespace, $col_id ) 
	{
		global $AdminWidgetsCols;
		$AdminWidgetsCols[ $col_id ][]	=	$widget_namespace;		
	}
	
	/**
	 * get Position widgets
	 * 
	 * @access public
	 * @return array
	 * @param int col id
	 * @since 3.1
	**/
	
	function col_widgets( $col_id )
	{
		global $AdminWidgetsCols;
		return riake( $col_id, $AdminWidgetsCols, array() );
	}
	
	
}