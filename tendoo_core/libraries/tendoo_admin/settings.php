<?php
class tendoo_settings
{
	public function __construct()
	{
		__extends($this);
		//
		$this->users_options	=	$this->db->where('ID',$this->users_global->current('ID'))->get('tendoo_users');
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
	public function toggleWelcomeMessage()
	{
		if(in_array((int)$this->users_global->current('SHOW_WELCOME'),array(1,'TRUE')))
		{
			$int	=	0;
		}
		else
		{
			$int	=	1;
		}
		$this->db->where('ID',$this->users_global->current('ID'))->update('tendoo_users',array('SHOW_WELCOME'=>$int));
	}
	public function switchShowAdminIndex()
	{
		$options	=	$this->tendoo->getOptions();
		if((int)$this->users_global->current('SHOW_ADMIN_INDEX_STATS') ==  1)
		{
			$int	=	0;
		}
		else
		{
			$int	=	1;
		}
		$this->db->where('ID',$this->users_global->current('ID'))->update('tendoo_users',array('SHOW_ADMIN_INDEX_STATS'=>$int));
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
	public function editThemeStyle($e)
	{
		$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1,2,3,4,5))  ? $e : 0; // If there is new theme just add it there
		return $this->db->where('ID',$this->users_global->current('ID'))->update('tendoo_users',array('ADMIN_THEME'=>$int));
	}
	public function toggleAppTab() // method used on users_global class.
	{
		$option =	$this->db->where('ID',$this->users_global->current('ID'))->get('tendoo_users');
		$result	=	$option->result_array();
		if($result[0]['OPEN_APP_TAB'] == '0')
		{
			$this->db
				->where('ID',$this->users_global->current('ID'))
				->update('tendoo_users',array(
				'OPEN_APP_TAB'			=>		'1'
			));
		}
		else
		{
			$this->db
				->where('ID',$this->users_global->current('ID'))
				->update('tendoo_users',array(
				'OPEN_APP_TAB'			=>		'0'
			));
		}
	}
	public function toggleFirstVisit()
	{
		if($this->users_options[0]['FIRST_VISIT'] == '0')
		{
			$this->db->where('ID',$this->users_global->current('ID'))->update('tendoo_users',array(
				'FIRST_VISIT'			=>		'1'
			));
		}
		else
		{
			$this->db->where('ID',$this->users_global->current('ID'))->update('tendoo_users',array(
				'FIRST_VISIT'			=>		'0'
			));
		}
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