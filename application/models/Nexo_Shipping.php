<?php
class Nexo_shipping extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Create Shipping
	 * 
	 * @param string name
	 * @param string provider
	 * @param string description
	 * @param string mode
	 * @param int id
	 * @return string
	**/
	
	function set_shipping( $name , $provider  , $description , $mode = 'create' , $id = 0 ) // Ok
	{
		if( $mode == 'create' ){
			if( ! $this->shipping_exists( $name , 'as_name' ) && $this->provider_exists( $provider , 'as_id' ) ){
				$exec	=	$this->db->insert( 'nexo_arrivages' , array(
					'TITRE'			=>	$name,
					'DESCRIPTION'	=>	$description,
					'DATE_CREATION'	=>	$this->datetime,
					'DATE_MOD'	=>	$this->datetime,
					'AUTHOR'		=>	$this->user_id,
					'FOURNISSEUR_REF_ID'	=>	$provider
				) );
				return $exec ? 'shipping-created' : 'error-occured';
			} 
			return 'shipping-already-exists-or-unknow-provider';
		} else if( $mode == 'edit' ){
			if( ! $this->shipping_exists( $name , 'as_name' , $id ) && $this->provider_exists( $provider , 'as_id' ) ){
				$exec	=	$this->db->where( 'ID' , $id )->update( 'Nexo_arrivages' , array(
					'TITRE'					=>	$name,
					'DESCRIPTION'			=>	$description,
					'DATE_MOD'		=>	$this->datetime,
					'AUTHOR'				=>	$this->user_id,
					'FOURNISSEUR_REF_ID'	=>	$provider
				) );
				return $exec ? 'shipping-updated' : 'error-occured';
			} 
			return 'shipping-already-exists-or-unknow-provider';
		}
	}
	
	/**
	 * Test whether a shipping exists
	 * 
	 * @param string name
	 * @param string filter
	 * @param int exclude
	 * @return bool
	**/
	
	function shipping_exists( $name , $filter = 'as_name' , $exclude = 0 )
	{
		if( $exclude != null )
		{
			$query	=	$this->db->where( 'TITRE' , $name )->where( 'ID !=' , $exclude )->get( 'nexo_arrivages' );
			return $query->result_array() ? true : false;
		}
		else
		{
			return $this->get_shipping( $name , $filter ) ? true : false;
		}
	}
	
	/**
	 * Get shipping
	 * 
	 * @param string name
	 * @param string filter
	 * @return array
	**/
	
	function get_shipping( $name = null , $end = 'as_name' )
	{
		if( is_numeric( $name ) && is_numeric( $end ) )	{
			$this->db->order_by( 'DATE_MOD' , 'desc' )->limit( $end , $name );
		} else if( $name != null ) {
			if( $end == 'as_id' ){
				$this->db->where( 'ID' , $name );
			} else if( $end ==  'as_name' ){
				$this->db->where( 'TITRE' , $name );
			} else if( $end == 'as_excluded_id' ){
				$this->db->where( 'ID !=' , $name );
			} 
		}
		$query	=	$this->db->get( 'nexo_arrivages' );
		return $query->result_array();
	}
}