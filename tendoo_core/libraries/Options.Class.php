<?php
class Options extends Libraries
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
						->from('tendoo_options')
						->limit(1,0);
		$r				=	$this->db->get();
		return $r->result_array();
	}
	public function set($array,$process = 'from_admin_interface')
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
		$q = $this->db->get('tendoo_options');
		$r = $q->result();
		if(count($r) == 1)
		{	
			$this->db->where('ID',1);
			$result = $this->db->update('tendoo_options',$array);
		}
		else if(count($r) == 0)
		{
			$result = $this->db->insert('tendoo_options',$array);
		}
		if($result == false)
		{
			return false;
		}
		return true;
	}
}