<?php
class Nexo_Products extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Create codebar image
	 * @param string code
	 * @return void
	**/
	
	function create_codebar( $code ) 
	{
		$this->load->model( 'Nexo_Misc' );
		
		global $Options;
		
		$width		=	empty( $Options[ 'nexo_codebar_width' ] ) ? 300 : intval( $Options[ 'nexo_codebar_width' ] );
		$height		=	empty( $Options[ 'nexo_codebar_height' ] ) ? 300 : intval( $Options[ 'nexo_codebar_height' ] );
		$code_type	=	empty( $Options[ 'nexo_product_codebar' ] ) ? "code128" : @$Options[ 'nexo_product_codebar' ];
		$barwidth	=	empty( $Options[ 'nexo_bar_width' ] ) ? 3 : intval( @$Options[ 'nexo_bar_width' ] );
		
		$generator = 	new Picqer\Barcode\BarcodeGeneratorJPG();
		
		if( $code_type == 'ean8' ) {
			$generator_type	=	$generator::TYPE_EAN_8;
		} else if( $code_type == 'ean13' ) {
			$generator_type	=	$generator::TYPE_EAN_13;
		}
		
		$barcode_path		=	NEXO_CODEBAR_PATH . $code . $this->Nexo_Misc->ean_checkdigit( $code, $code_type );
		file_put_contents( $barcode_path . '.jpg', $generator->getBarcode( $code, $generator_type, $barwidth, $height ) );
	}
	
	/**
	 * Generate Bar code
	 * @return void
	**/
	
	function generate_barcode()
	{
		$this->load->model( 'Nexo_Misc' );
		global $Options;
		
		function random( $start = true ) {
			$start_int	=	$start ? 1 : 0;
			return rand( $start_int, 9 );
		}
		
		$saved_barcode	=	$this->options->get( 'nexo_saved_barcode' );
		$code			=	'';
		$limit	   		= 	! empty( $Options[ 'nexo_codebar_limit_nbr' ] ) ? intval( @$Options[ 'nexo_codebar_limit_nbr' ] ) : 6;
		
		if( $saved_barcode ) {
			do {
				
				if( @$Options[ 'nexo_product_codebar' ] == 'ean8' ) {
					
					for( $i = 0; $i < 7; $i++ ) {
						$start = ( $i == 0 ) ? true : false;
						$code .= random( $start );
					}
					$code		=	$code . $this->Nexo_Misc->ean_checkdigit( $code, @$Options[ 'nexo_product_codebar' ] );
					
				} else if( @$Options[ 'nexo_product_codebar' ] == 'ean13' ) {
					
					for( $i = 0; $i < 12; $i++ ) {
						$start 	= ( $i == 0 ) ? true : false;
						$code 	.= random( $start );
					}
					$code		.=	$this->Nexo_Misc->ean_checkdigit( $code, @$Options[ 'nexo_product_codebar' ] );
					
				} else {
					
					for( $i = 0; $i < $limit ; $i++ ) {
						$start = ( $i == 0 ) ? true : false;
						$code .= random( $start );
					}
					
				}
								
			} while( in_array( $code, $saved_barcode ) );
		} else {
			if( @$Options[ 'nexo_product_codebar' ] == 'ean8' ) {
				
				for( $i = 0; $i < 7; $i++ ) {
					$start 	= ( $i == 0 ) ? true : false;
					$code 	.= random( $start );
				}
				$code		.=	$this->Nexo_Misc->ean_checkdigit( $code, @$Options[ 'nexo_product_codebar' ] );
				
			} else if( @$Options[ 'nexo_product_codebar' ] == 'ean13' ) {
				
				for( $i = 0; $i < 12; $i++ ) {
					$start = ( $i == 0 ) ? true : false;
					$code .= random( $start );
				}
				$code		.= $this->Nexo_Misc->ean_checkdigit( $code, @$Options[ 'nexo_product_codebar' ] );
				
			} else {
				
				for( $i = 0; $i < $limit ; $i++ ) {
					$start = ( $i == 0 ) ? true : false;
					$code .= random( $start );
				}
				
			}
		}
		$saved_barcode[]	=	$code;

		$this->options->set( 'nexo_saved_barcode', $saved_barcode, true );		
		if( in_array( @$Options[ 'nexo_product_codebar' ], array( 'ean8', 'ean13' ) ) ) {
			$this->create_codebar( substr( $code, 0, -1 ) );
		} else {
			$this->create_codebar( $code );
		}
		
		return $code;	
	}
	
	/**
	 * Reset saved Barcode
	 * @return void
	 *
	**/
	
	function reset_barcode()
	{
		$this->options->delete( 'nexo_saved_barcode' );
		
		/**
		 * @source http://stackoverflow.com/questions/4594180/deleting-all-files-from-a-folder-using-php
		**/
		$files = glob('public/upload/codebar/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file)) {
			unlink($file); // delete file
		  }
		}
	}
	
	/**
	 * Resample barcode
	 *
	 * @param int product id
	 * @return string json
	**/
	
	function resample_codebar( $product_id ) {
		// Get a new barcode based on current settings
		$barcode		=	$this->generate_barcode();

		// Update Barcode
		$this->db->where( 'ID', $product_id )->update( 'nexo_articles', array(
			'CODEBAR'	=>	$barcode
		) );
		
		return json_encode( array(
			'type'	=>	'success'
		) );
	}
	
	/**
	 * Product Save
	 * 
	 * @param array
	 * @return array
	**/
	
	function product_save( $param )
	{
		// Protecting
		if( ! User::can( 'create_items' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		global $Options;
		$param[ 'CODEBAR' ]				=	$this->generate_barcode();
		$param[ 'AUTHOR' ]				=	intval( User::id() );
		$param[ 'QUANTITE_RESTANTE' ]	=	intval( $param[ 'QUANTITY' ] ) - intval( $param[ 'DEFECTUEUX' ] );
		$param[ 'QUANTITE_VENDU' ]		=	0;
		$param[ 'COUT_DACHAT' ]			=	intval( $param[ 'PRIX_DACHAT' ] ) + intval( $param[ 'FRAIS_ACCESSOIRE' ] );
		$param[ 'DATE_CREATION' ]		=	date_now();

		return $param;
	}
	
	/**
	 * Product Update
	 * 
	 * @param array
	 * @return array
	**/
	
	function product_update( $param )
	{
		// Protecting
		if( ! User::can( 'edit_items' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		global $Options;
		$article						=	$this->get( 'nexo_articles', $param[ 'DESIGN' ], 'DESIGN' );
		$quantite						=	intval( $article[0][ 'QUANTITY' ] );
		$old_defectueux					=	intval( $article[0][ 'DEFECTUEUX' ] );
		
		$param[ 'QUANTITE_RESTANTE' ]	=	( ( intval( $param[ 'QUANTITY' ] ) - intval(  $param[ 'DEFECTUEUX' ] ) ) - intval( $article[0][ 'QUANTITE_VENDU' ] ) );
		$param[ 'DATE_MOD' ]			=	date_now();
		$param[ 'AUTHOR' ]				=	intval( User::id() );
		$param[ 'COUT_DACHAT' ]			=	intval( $param[ 'PRIX_DACHAT' ] ) + intval( $param[ 'FRAIS_ACCESSOIRE' ] );
		
		return $param;
	}	
	
	// Deprecated
	
	function get( $element, $key, $as = 'ID' )
	{
		$query	=	$this->db->where( $as, $key )->get( $element );
		return $query->result_array();
	}
	
	/**
	 * Product delete
	 * 
	 * @param Array
	 * @return Array
	*/
	
	function product_delete( $param ) 
	{
		// Protecting
		if( ! User::can( 'delete_items' ) ) : redirect( array( 'dashboard', 'access-denied' ) ); endif;
		
		return $param;
	}
	
	/** 
	 * get products linked to a shipping
	 * 
	 * @param int shipping id
	 * @return Array
	**/
	
	function get_products_by_shipping( $shipping_id ) 
	{
		$query	=	$this->db->where( 'REF_SHIPPING', $shipping_id )->get( 'nexo_articles' );
		return $query->result_array();		
	}
}