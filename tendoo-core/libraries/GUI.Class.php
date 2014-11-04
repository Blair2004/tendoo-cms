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
	public function enable( $element )
	{
		$ui_config	=	get_core_vars( 'ui_config' ) ? get_core_vars( 'ui_config' ) : array();
		$enabled	=	return_if_array_key_exists( 'enabled' , $ui_config ) 
			? return_if_array_key_exists( 'enabled' , $ui_config ) : array();
		if( in_array( $element, array( 'pagination' , 'submit' , 'reset' , 'loader' ) ) )
		{
			$enabled[]	=	$element;
		}
		$ui_config[ 'enabled' ] = $enabled;
		return set_core_vars( 'ui_config' , $ui_config );
	}
	public function set_meta( $options , $title , $type )
	{
		if( !gui_is_loaded() ): return false ; endif;
		// Sauvegarde des boites méta en utilisant l'espacenom comme identifiant
		$saved_meta	=	array();
		
		if( is_array( $options ) )
		{
			if( return_if_array_key_exists( 'namespace' , $options ) ){
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
	public function set_field( $array ){
		if( !gui_is_loaded() ): return false ; endif;
		//
		$saved_fields	=	get_core_vars( 'gui_saved_fields' ) ? get_core_vars( 'gui_saved_fields' ) : array();
		$saved_fields	=	$array;
		set_core_vars( 'gui_saved_fields' , $saved_fields );
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
	public function col_push( $col , $data )
	{
		$this->cols[ $col ][ 'configs' ] =	$data;
	}
	public function set_form( $array )
	{
		$returnback	= get_instance()->url->site_url();
		$action		= return_if_array_key_exists( 'action' , $array );
		$enctype	= return_if_array_key_exists( 'enctype' , $array );
		$type		= return_if_array_key_exists( 'type' , $array );
		?>
        <?php
	}
	public function get( $return = false )
	{
		$value	=	$this->load->view( 'admin/others/gui' , array() , TRUE );
		if( $return ){
			return $value;
		}
		echo $value;
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
			$new_fields	=	get_core_vars( 'gui_saved_fields' );
			//
			set_core_vars( 'gui_saved_fields' , false );
			//
			foreach( $this->cols as &$colones ){
				if( is_array( return_if_array_key_exists( 'configs' , $colones ) ) ){
					foreach( $colones[ 'configs' ] as 	&$configs ){
						if( is_array( $configs ) ){
							foreach( $configs as $key => &$metas ){
								if( $key == $cols ){
									$saved_fields	=	return_if_array_key_exists( 'meta_fields' , $metas ) 
										? return_if_array_key_exists( 'meta_fields' , $metas ) : array();
									$saved_fields[] = 	$new_fields;
									$metas[ 'meta_fields' ] = $saved_fields;
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
}