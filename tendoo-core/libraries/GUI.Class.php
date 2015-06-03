<?php
class GUI extends Libraries
{
	public $ui_cols		=	1;
	private $nbr_ui_cols	=	array( 1 , 2 , 3 , 4 );
	public function __construct()
	{
		parent::__construct();
		__extends( $this );
		$this->load->helper('gui');
	}
	//  @since GUI V.1
	function config( $config_key , $value )
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
		if( !gui_is_loaded() ): return false ; endif;
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
		if( !gui_is_loaded() ): return false ; endif;
		//
		$saved_items	=	get_core_vars( 'gui_saved_items' ) ? get_core_vars( 'gui_saved_items' ) : array();
		$saved_items	=	$array;
		set_core_vars( 'gui_saved_items' , $saved_items );
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
		?>
        <?php
	}
	public function get()
	{
		set_core_vars( 'body' ,	$this->load->the_view( 'admin/others/gui' , TRUE ) );

		$this->load->the_view( 'admin/header' );
		$this->load->the_view( 'admin/global_body' );
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
		}
		// Must be called after meta definition
		// Meta namespace are unique
		else if( is_string( $cols ) ){
			$new_items	=	get_core_vars( 'gui_saved_items' );
			//
			set_core_vars( 'gui_saved_items' , false );
			// On parcours chaque colonnes
			foreach( $this->cols as &$colones ){
				// Si la colonne a une configuration
				if( is_array( riake( 'configs' , $colones , false ) ) ){
					foreach( $colones[ 'configs' ] as 	&$configs ){
						if( is_array( $configs ) ){
							foreach( $configs as $key => &$metas ){
								if( $key == $cols ){
									$saved_items	=	riake( 'meta_items' , $metas , array() );
									$saved_items[] = 	$new_items;
									$metas[ 'meta_items' ] = $saved_items;
									// Coz we do need unique namespace per metas, we just get out after first meet
									break;
								};
							}
						}
					}
				}
			};
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