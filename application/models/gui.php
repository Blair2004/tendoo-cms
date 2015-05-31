<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GUI extends CI_Model
{
	public $ui_cols		=	1;
	private $nbr_ui_cols	=	array( 1 , 2 , 3 , 4 );
	public $cols		=	array();
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
	
	public function load_page( $page_slug )
	{
		// load created pages
		$this->events->do_action( 'create_dashboard_pages' );
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
	 * 	Get GUI cols
	 *	@access		:	Public
	 *	@returns	:	Array
	**/
	
	function get_cols()
	{
		return $this->cols;
	}
	
	function ui_config( $config_key , $value )
	{
		// Ouput content before and after cols
		$ui_config	=	get_core_vars( 'ui_config' ) ? get_core_vars( 'ui_config' ) : array();
		$ui_config[ 'output' ][ $config_key ]	=	$value;
		return set_core_vars( 'ui_config' , $ui_config );
	}
	
	public function enable( $element )
	{
		if( is_array( $element ) )
		{
			foreach( $element as $_element )
			{
				$this->enable( $_element );
			}
		}
		else
		{
			$ui_config	=	get_core_vars( 'ui_config' ) ? get_core_vars( 'ui_config' ) : array();
			$enabled	=	riake( 'enabled' , $ui_config , array() );
			if( in_array( $element, array( 'pagination' , 'submit' , 'reset' , 'loader' , 'dynamic-tables' ) ) ) // dynamic-tables
			{
				$enabled[]	=	$element;
			}
			$ui_config[ 'enabled' ] = $enabled;
			return set_core_vars( 'ui_config' , $ui_config );
		}
	}
	public function set_meta( $options , $title = 'unamed' , $type = 'panel' )
	{
		// Sauvegarde des boites méta en utilisant l'espacenom comme identifiant
		$saved_meta	=	array();
		
		if( is_array( $options ) )
		{
			if( riake( 'namespace' , $options ) ){
				$saved_meta[ $options[ "namespace" ] ]	=	$options;
			}
		}
		else
		{
			$saved_meta[ $options ]  =	array(
				'namespace'	=>	$options,
				'title'		=>	$title,
				'type'		=>	$type
			);
		}
		set_core_vars( 'gui_saved_meta' , $saved_meta );
		return $this;
	}
	/*
		Parameter : Array
			keys  : label, 
					placeholder, 
					type[radio,checkbox,text,visual_editor,password,select,textarea], 
					text[string/Array], 
					value[string/Array], 
	*/
	public function set_item( $array ){
		$saved_items	=	get_core_vars( 'gui_saved_items' ) ? get_core_vars( 'gui_saved_items' ) : array();
		$saved_items	=	$array;
		set_core_vars( 'gui_saved_items' , $saved_items );
		// var_dump( get_core_vars( 'gui_saved_items' ) );die;
		return $this;		
	}
	public function cols_width( $col , $width )
	{
		if( in_array( $col , $this->nbr_ui_cols , true ) )
		{
			if( in_array( $width , array( 1, 2, 3 ) , true ) )
			{
				return $this->cols[ $col ][ 'width' ] = $width;
			}
		}
		return false;
	}
	public function set_tab( $config )
	{
		
		return $this;
	}
	public function col_config( $col , $data )
	{
		$this->cols[ $col ][ 'configs' ] =	$data;
	}
	public function set_form( $array )
	{
		$returnback	= get_instance()->url->site_url();
		$action		= riake( 'action' , $array , '');
		$enctype	= riake( 'enctype' , $array , '');
		$type		= riake( 'type' , $array );
	}
	public function get()
	{
		set_core_vars( 'page-header' , $this->load->view( 'dashboard/gui/page-header' , array() , true ) );
		
		$this->load->view( 'dashboard/header' );		
		$this->load->view( 'dashboard/horizontal-menu' );		
		$this->load->view( 'dashboard/aside' );		
		$this->load->view( 'dashboard/body' );
		$this->load->view( 'dashboard/footer' );	
		$this->load->view( 'dashboard/aside-right' );
	}
	// INSTANT USE
	public function push_to( $cols ){
		if( is_numeric( $cols ) ){
			$saved_meta	=	get_core_vars( 'gui_saved_meta' );
			$this->saved_meta 	=	$saved_meta;
			// Seul les méta correctement définie peuvent être ajoutés à une colonne
			if( $saved_meta ){
				if( in_array( $cols , array( 1 , 2 , 3 , 4 ) ) )
				{
					$this->cols[ $cols ][ 'configs' ][]	 =  $saved_meta;
				}
			}
			set_core_vars( 'gui_saved_meta' , false );
		}
		// Must be called after meta definition
		// Meta namespace are unique
		else if( is_string( $cols ) ){
			// get latest item defined using set_meta or set_item
			$new_items		=	get_core_vars( 'gui_saved_items' );
			$new_sub_metas	=	get_core_vars( 'gui_saved_meta' );
			// 
			set_core_vars( 'gui_saved_items' , false );
			set_core_vars( 'gui_saved_meta' , false );
			// var_dump( $new_items , $new_sub_metas );
			// reseting "gui_saved_meta" disabled because it's already disbled every time "set_meta" is used
			
			// On parcours chaque colonnes
			foreach( $this->cols as &$colones ){
				// Si la colonne a une configuration
				if( is_array( riake( 'configs' , $colones , false ) ) ){
					// parcours des différentes meta
					foreach( $colones[ 'configs' ] as 	&$configs ){
						if( is_array( $configs ) ){
							foreach( $configs as $key => &$metas ){
								// if current meta match the namespace defined as parameter
								// "key" is the meta namespace
								if( $key == $cols ){
									// looking for "meta_item" key if not set create an empty array
									$saved_items			=	riake( 'meta_items' , $metas , array() );
									$saved_items[] 			= 	$new_items;
									
									$saved_metas			=	riake( 'sub_metas' , $metas , array() );
									$saved_metas[] 			= 	$new_sub_metas;
									// if item define is a new meta, it's saved under sub_meta
									if( $new_sub_metas )
									{
										$metas[ 'sub_metas' ] 	= $saved_metas;
									}
									// else it's saved to meta items array
									else
									{
										$metas[ 'meta_items' ] 	= $saved_items;
									}
									// Coz we do need unique namespace per metas, we just get out after first meet
									break;
								};
							}
						}
					}
				}
			};
			print_array( $this->cols );
		}
	}
	// Table
	private $current_table			=	'sample';
	private $empty_table_message	=	'There are no result to display';
	public function set_table( $namespace )
	{
		$this->current_table	=	$namespace;
		return $this;
	}
	public function empty_message( $message )
	{
		$this->empty_table_message	=	$message;
		return $this;
	}
	public function add_col( $name , $title )
	{
		$this->tables[ $this->current_table ][ 'cols' ][ $name ]	=	$title;
	}
	public function add_row( $values )
	{
		if( is_array( $values ) )
		{
			$this->tables[ $this->current_table ][ 'rows' ][]	=	$values;
		}
		return $this;
	}
	public function add_cols_width( $values )
	{
		if( is_array( $values ) )
		{
			$this->tables[ $this->current_table ][ 'cols_width' ]	=	$values;
		}
		return $this;
	}
	public $tables	=	array();
	function get_table( $namespace , $class = '' , $attrs = '')
	{
		if( riake( $namespace , $this->tables ) )
		{
			$empty_table_message	=	$this->empty_table_message;
			?>
            <table class="box-body <?php echo $class;?>" <?php echo $attrs;?>>
                <thead>
                    <tr>
                        <?php
						$col_span = 0;
						foreach( riake( 'cols' , $this->tables[ $namespace ] , array() ) as $key	=>	$cols )
						{
							$col_span++;
							?>
                            <td width="<?php echo riake( $key , riake( 'cols_width' , $this->tables[ $namespace ] ) , 100 );?>"><?php echo $cols;?></td>
                            <?php
						}
						?>
                    </tr>
                </thead>
                <tbody>
                    	<?php
						if( count( riake( 'rows' , $this->tables[ $namespace ] , array() ) ) > 0 )
						{
							foreach( riake( 'rows' , $this->tables[ $namespace ] , array() ) as $rows )
							{
							?>
                            <tr>
                            <?php
								foreach( force_array( $rows ) as $_values )
								{
								?>
                                <td><?php echo $_values;?></td>
								<?php
								}
							?>
                            </tr>
                            <?php
							}
						}
						else
						{
							?>
                            <tr>
                            	<td colspan="<?php echo $col_span;?>"><?php echo $empty_table_message;?></td>
                            </tr>
                            <?php
						}
						?>
                </tbody>
            </table>
            <?php
		}
		return false;
	}
	private $once_called	=	0;
	function get_dynamic_table( $namespace , $class = '' , $attrs = '')
	{
		if( riake( $namespace , $this->tables ) )
		{
			$empty_table_message	=	$this->empty_table_message;
			?>
            <div class="box-body">
            <table class="table table-bordered table-hover <?php echo $class;?> dynamic-tables-<?php echo $this->once_called;?>" <?php echo $attrs;?>>
                <thead>
                    <tr>
                        <?php
						$col_span = 0;
						foreach( riake( 'cols' , $this->tables[ $namespace ] , array() ) as $cols )
						{
							$col_span++;
							?>
                            <td><?php echo $cols;?></td>
                            <?php
						}
						?>
                    </tr>
                </thead>
                <tbody>
                    	<?php
						if( count( riake( 'rows' , $this->tables[ $namespace ] , array() ) ) > 0 )
						{
							foreach( riake( 'rows' , $this->tables[ $namespace ] , array() ) as $rows )
							{
							?>
                            <tr>
                            <?php
								foreach( force_array( $rows ) as $_values )
								{
								?>
                                <td><?php echo $_values;?></td>
								<?php
								}
							?>
                            </tr>
                            <?php
							}
						}
						else
						{
							?>
                            <tr>
                            	<td colspan="<?php echo $col_span;?>"><?php echo $empty_table_message;?></td>
                            </tr>
                            <?php
						}
						?>
                </tbody>
            </table>
            <script>
			$(document).ready(function(e) {
                $('.dynamic-tables-<?php echo $this->once_called;?>').dataTable();
            });
			</script>
            </div>
            <?php
			$this->once_called++;
		}
		return false;
	}
}