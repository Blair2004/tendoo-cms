<?php
class tendoo_settings
{
	public function __construct()
	{
		__extends($this);
	}
	public function editSiteName($e)
	{
		return $this->db->update('tendoo_options',array('SITE_NAME'=>$e));
	}
	public function editRegistration($e)
	{
		if(is_numeric($e))
		{
			$e =	($e >= 0 && $e <= 1) ? $e : 0;
		}
		else
		{
			$e	=	0;
		}
		return $this->db->update('tendoo_options',array('ALLOW_REGISTRATION'=>$e));
	}
	public function editLogoUrl($e)
	{
		return $this->db->update('tendoo_options',array('SITE_LOGO'=>$e));
	}
	public function editTimeZone($e)
	{
		return $this->db->update('tendoo_options',array('SITE_TIMEZONE'=>$e));
	}
	public function editTimeFormat($e)
	{
		return $this->db->update('tendoo_options',array('SITE_TIMEFORMAT'=>$e));
	}
	
	public function editPrivilegeAccess($e)
	{
		$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1))  ? $e : 0;
		return $this->db->update('tendoo_options',array('ALLOW_PRIVILEGE_SELECTION'=>$int));
	}
	public function editAllowAccessToPublicPriv($e)
	{
			$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1))  ? $e : 0;
		return $this->db->update('tendoo_options',array('PUBLIC_PRIV_ACCESS_ADMIN'=>$int));
	}
	public function toogleStoreConnexion()
	{
		$option =	$this->db->get('tendoo_options');
		$result	=	$option->result_array();
		if($result[0]['CONNECT_TO_STORE'] == '0')
		{
			$this->db->update('tendoo_options',array(
				'CONNECT_TO_STORE'			=>		'1'
			));
		}
		else
		{
			$this->db->update('tendoo_options',array(
				'CONNECT_TO_STORE'			=>		'0'
			));
		}
	}
}