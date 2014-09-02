<?php
class Meta_datas extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		__extends($this);
	}
	public function get($process	= "from_admin_interface")
	{
		if($process == "from_install_interface")
		{
			$config		=	$_SESSION['db_datas'];
			$this->db	=	DB($config,TRUE);
		}
		$this->db		->select('*')
						->from('tendoo_meta');
		$r				=	$this->db->get();
		return $r->result_array();
	}
	public function set($key , $value , $process = 'from_admin_interface' , $app = 'system' , $user = 0)
	{		
		if($process == 'from_install_interface')
		{
			$config		=	$_SESSION['db_datas'];
			$this->db	=	DB($config,TRUE);
		}
		else if($process == "form_admin_interface")
		{
			$this->db		=	get_db(); // Refreshing
		}
		$query			=	$this->db->where( 'KEY' , $key )->get( 'tendoo_meta' );  
		if( count( $query->result_array() ) > 0 ){
			return $this->db->where( 'KEY' , $key )->update( 'tendoo_meta' , array(
				'VALUE'		=>		$value,
				'USER'		=>		$user,
				'APP'		=>		$app,
				'DATE'		=>		0 // Provisoire
			) );
		} else {
			return $this->db->insert( 'tendoo_options' , array(
				'KEY'		=>		$key,
				'VALUE'		=>		$value,
				'USER'		=>		$user,
				'APP'		=>		$app,
				'DATE'		=>		0 // Provisoire
			) );
		}
	}
	public function get_meta( $key ){
		$query			=	$this->db->where( 'KEY' , $key )->get( 'tendoo_meta' );  
		if( count($result = $query->result_array() ) > 0 ){
			
		}
	}
}