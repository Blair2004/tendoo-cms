<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GUI extends CI_Model
{
	public $cols	=	array( 
		1 			=>	array(),
		2 			=>	array(),
		3 			=>	array(),
		4 			=>	array(),
	);

	private $created_page	=	array();

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Create new admin page
	 * Using page required page slug.
	 *
	 * @access : public
	 * @param : string page slug required
	 * @param : string page title (using page slug if not set)
	 * @param : string page description (displays nothing if not set)
	**/
	
	public function create_page( $page_slug , $page_title , $page_description ) // may add role required to access this apge
	{
		$this->created_page[ $page_slug ]	=	array(
			'page_slug'						=>	$page_slug,
			'page_title'					=>	$page_title,
			'page_description'				=>	$page_description
		);
	}
	
	/** 
	 * Load created page
	 *
	**/
	
	public function load_page( $page_slug , $params )
	{
		// load created pages
		$this->events->do_action_ref_array( 'create_dashboard_pages' , $params );
		// output pages
		if( riake( $page_slug , $this->created_page ) )
		{
			// loading page content
			if( $content	=	riake( 'content' , $this->created_page[ $page_slug ] ) )
			{
				echo $content();
			}
			else
			{
				// page doesn't exists load 404 internal page error
				$this->html->set_title( sprintf( __( 'Error : Output Not Found &mdash; %s' ) , get( 'core-signature' ) ) );
				$this->html->set_description( __( 'Error page' ) );
				$this->load->view( 'dashboard/error/output-not-found' );
			}
		}
		else if( $page_slug == 'form-expired' )
		{
			// page doesn't exists load 404 internal page error
			$this->html->set_title( sprintf( __( 'Error : Form Expired &mdash; %s' ) , get( 'core-signature' ) ) );
			$this->html->set_description( __( 'Form Expired' ) );
			$this->load->view( 'dashboard/error/custom' , array( 
				'msg'	=>	__( 'This form has expired' )
			) );
		}
		else
		{
			// page doesn't exists load 404 internal page error
			$this->html->set_title( sprintf( __( 'Error : 404 &mdash; %s' ) , get( 'core-signature' ) ) );
			$this->html->set_description( __( 'Error page' ) );
			$this->load->view( 'dashboard/error/404' );
		}
	}
	/**
	 * page_content
	**/
	
	function page_content( $page_slug , $file_path , $array_vars = array() )
	{
		$current_object	=	$this;
		$this->created_page[ $page_slug ][ 'content' ]	=	function() use ( $current_object , $page_slug , $file_path , $array_vars ){
			return $current_object->load->view( $file_path , $array_vars , true );	
		};
	}
	
	/**
	 * Page title
	**/
	
	function set_title( $title )
	{
		$this->html->set_title( $title );
	}
	
	/**
	 * New Gui
	**/
	/**
	 * Set cols width
	 * 
	 * col_id should be between 1 and 4. Every cols are loaded even if they width is not set
	 * @access : public
	 * @param : int cold id
	 * @param : int width
	 * @return : void
	**/
		
	function col_width( $col_id , $width )
	{
		if( in_array( $col_id , array( 1 , 2 , 3 , 4 ) ) )
		{
			$this->cols[ $col_id ][ 'width' ]	=	$width;
		}
	}
	
	function get_col( $col_id )
	{
		return riake( $col_id , $this->cols );
	}
	
	function add_meta( $namespace , $title = 'Unamed' , $type = 'box-default' , $col_id = 1 )
	{
		if( in_array( $col_id , array( 1 , 2 , 3 , 4 ) ) )
		{
			if( is_array( $namespace ) )
			{
				$rnamespace			=	riake( 'namespace' , $namespace );
				$col_id				=	riake( 'col_id' , $namespace );
				$title				=	riake( 'title' , $namespace );
				$type				=	riake( 'type' , $namespace );
				
				foreach( $namespace as $key => $value )
				{
					$this->cols[ $col_id ][ 'metas' ][ $rnamespace ][ $key ]	=	$value;
				}
				
			}
			else
			{				
				$this->cols[ $col_id ][ 'metas' ][ $namespace ]	=	array(
					'namespace'		=>	$namespace,
					'type'			=>	$type,
					'title'			=>	$title
				);
			}
		}
	}
	
	function add_item( $config , $metanamespace , $col_id )
	{
		if( in_array( $col_id , array( 1 , 2 , 3 , 4 ) ) && riake( 'type' , $config ) )
		{
			$this->cols[ $col_id ][ 'metas' ][ $metanamespace ][ 'items' ][]	=	$config;
		}
	}
	
	public function output()
	{
		set_core_vars( 'page-header' , $this->load->view( 'dashboard/gui/page-header' , array() , true ) );
		
		$this->load->view( 'dashboard/header' );		
		$this->load->view( 'dashboard/horizontal-menu' );		
		$this->load->view( 'dashboard/aside' );		
		$this->load->view( 'dashboard/gui/body' , array(
			'cols'		=>		$this->cols
		) );
		$this->load->view( 'dashboard/footer' );	
		$this->load->view( 'dashboard/aside-right' );
	}
	
	/**
	 * 	Get GUI cols
	 *	@access		:	Public
	 *	@returns	:	Array
	**/
	function get_cols()
	{
		return $this->cols;
	}
	
}