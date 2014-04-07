<?php
class tendoo_restore
{
	public function __construct()
	{
		__extends($this);
	}
	public function cmsRestore($password)
	{
		$query		=	$this->db->where('PRIVILEGE','NADIMERPUS')->get('tendoo_users');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			if($result[0]['PASSWORD'] != sha1($password))
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		// Removing modules
		$modules	=	$this->get_modules();
		if(count($modules) > 0)
		{
			foreach($modules as $m)
			{
				$this->uninstall_module($m['ID']);
			}
		}
		$this->db->query('TRUNCATE `tendoo_modules`');
		// Removing Themes
		$themes		=	$this->getThemes();
		if(count($themes) > 0)
		{
			foreach($themes as $t)
			{
				$this->uninstall_theme($t['ID']);
			}
		}
		$this->db->query('TRUNCATE `tendoo_themes`');
		return true;
	}
	public function cmsHardRestore()
	{
		// Removing modules
		$this->db->query('TRUNCATE `tendoo_modules`');
		$this->drop(MODULES_DIR);
		mkdir(MODULES_DIR);
		mkdir(MODULES_DIR.'Tendoo_mod_install');
		// Removing Themes
		$this->db->query('TRUNCATE `tendoo_themes`');
		$this->drop(THEMES_DIR);
		mkdir(THEMES_DIR);
		mkdir(THEMES_DIR.'temp');
		return true;
	}
}