<?php
class Session
{
	private $core;
	private $_user_data;
	public function __construct()
	{
		$this->core			=	Controller::instance();
		if(!isset($_SESSION['Session_user_data']))
		{
			$_SESSION['Session_user_data']	=	array();
		}
		
		$this->_user_data	=& $_SESSION['Session_user_data'];
		if(!is_array($this->_user_data))
		{
			$this->_user_data	= 	array();
		}
	}
	public function set_userdata($array,$next=NULL)
	{
		if(is_array($array))
		{
			foreach($array as $k => $v)
			{
				if(!array_key_exists($k,$this->_user_data))
				{
					$this->_user_data[$k]	=	$v;
				}
			}
			return true;
		}
		else
		{
			$this->_user_data[$array]	=	$next;
		}
		return false;
	}
	public function userdata($mixed_var)
	{
		if(array_key_exists($mixed_var,$this->_user_data))
		{
			return $this->_user_data[$mixed_var];
		}
		return FALSE;
	}
	public function debug_userdata()
	{
		var_dump($this->_user_data);
	}
	public function close()
	{
		$this->_user_data = array();
	}
	public function started()
	{
		if(count($this->_user_data) > 0)
		{
			return true;
		}
		return false;
	}
}