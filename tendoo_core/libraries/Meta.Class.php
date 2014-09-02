<?php
class Meta_datas extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		__extends($this);
	}
	public function get($key , $process	= "from_admin_interface")
	{
		if($process == "from_install_interface")
		{
			$config		=	$_SESSION['db_datas'];
			$this->db	=	DB($config,TRUE);
		}
		$key 	=	strtolower( $key );
		$query			=	$this->db->where( 'KEY' , $key )->where( 'USER' , '' )->get( 'tendoo_meta' );  
		if( count($result = $query->result_array() ) > 0 ){
			$_returned	=	$result[0][ 'VALUE' ];
			if( json_decode( $_returned ) != null ){
				return json_decode( $_returned , TRUE );
			} else if( in_array( strtolower( $_returned ) , array( 'true' , 'false' ) ) ){
				return $_returned == 'true' ? true : false ;
			} else {
				return $_returned;
			}
		}
		return false;
	}
	public function set($key , $value , $process = 'from_admin_interface' , $app = 'system' )
	{		
		$datetime	=	get_instance()->date->datetime();
		$key 	=	strtolower( $key );
		if($process == 'from_install_interface')
		{
			$config		=	$_SESSION['db_datas'];
			$this->db	=	DB($config,TRUE);
		}
		else if($process == "form_admin_interface")
		{
			$this->db		=	get_db(); // Refreshing
		}
		$query				=	$this->db->where( 'KEY' , $key )->where( 'USER' , '' )->get( 'tendoo_meta' );  
		// Convert value
		if( is_array( $value ) ){
			$value			=	json_encode( $value , JSON_FORCE_OBJECT );
		} else if( is_bool( $value ) ){
			$value			=	$value === true ? 'true' : 'false' ;
		} 
		// ELSE $value keep his form
		// Conversion ended
		if( count( $query->result_array() ) > 0 ){
			return $this->db->where( 'KEY' , $key )->where( 'USER' , '' )->update( 'tendoo_meta' , array(
				'VALUE'		=>		$value,
				'APP'		=>		$app,
				'DATE'		=>		$datetime
			) );
		} else {
			return $this->db->insert( 'tendoo_meta' , array(
				'KEY'		=>		$key,
				'VALUE'		=>		$value,
				'APP'		=>		$app,
				'DATE'		=>		$datetime
			) );
		}
	}
	// Becode unset already taken
	public function _unset( $key ){
		return get_db()->where( 'KEY' , $key )->where( 'USER' , '' )->delete( 'tendoo_meta' );
	}
	public function get_user_meta( $key ){
		$key 	=	strtolower( $key );
		$query			=	$this->db->where( 'USER' , current_user( 'PSEUDO' ) )->where( 'KEY' , $key )->get( 'tendoo_meta' );  
		if( count($result = $query->result_array() ) > 0 ){
			$_returned	=	$result[0][ 'VALUE' ];
			if( json_decode( $_returned ) != null ){
				return json_decode( $_returned , TRUE );
			} else if( in_array( strtolower( $_returned ) , array( 'true' , 'false' ) ) ){
				return $_returned == 'true' ? true : false ;
			} else {
				return $_returned;
			}
		}
		return false;
	}
	public function set_user_meta( $key , $value , $user_pseudo = null ){
		$datetime	=	get_instance()->date->datetime();
		$user_pseudo=	( $user_pseudo != null ) ? $user_pseudo : current_user( 'PSEUDO' );
		$key 		=	strtolower( $key );
		$query				=	$this->db->where( 'USER' , $user_pseudo )->where( 'KEY' , $key )->get( 'tendoo_meta' );  
		// Convert value
		if( is_array( $value ) ){
			$value			=	json_encode( $value , JSON_FORCE_OBJECT );
		} else if( is_bool( $value ) ){
			$value			=	$value === true ? 'true' : 'false' ;
		} 
		// ELSE $value keep his form
		// Conversion ended
		if( count( $query->result_array() ) > 0 ){
			return $this->db->where( 'USER' , current_user( 'PSEUDO' ) )->where( 'KEY' , $key )->update( 'tendoo_meta' , array(
				'VALUE'		=>		$value,
				'USER'		=>		current_user( 'PSEUDO' ),
				'APP'		=>		"system",
				'DATE'		=>		$datetime
			) );
		} else {
			return $this->db->insert( 'tendoo_meta' , array(
				'KEY'		=>		$key,
				'VALUE'		=>		$value,
				'USER'		=>		current_user( 'PSEUDO' ),
				'APP'		=>		"system",
				'DATE'		=>		$datetime
			) );
		}
	}
	public function _unset_user_meta( $key ){
		return get_db()->where( 'USER' , current_user( 'PSEUDO' ) )->where( 'KEY' , $key )->delete( 'tendoo_meta' );
	}
}