<?php
class tendoo_modules
{
	private $leftMenuExtentionBefore 	= '';
	private $leftMenuExtentionAfter 	= '';
	public function __construct()
	{
		__extends($this);
	}
	public function getSpeModuleByNamespace($namespace) // La même méthode pour Tendoo ne recupère que ce qui est déjà activé.
	{
		$this->db		->select('*')
							->from('tendoo_modules')
							->where('NAMESPACE',$namespace);
		$query				= $this->db->get();
		$data				= $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function count_modules()
	{
		$query				=	$this->db->get('tendoo_modules');
		return $query->num_rows();
	}
	public function moduleActivation($id,$form = TRUE)
	{
		if($form == TRUE)
		{
			$mod	=	$this->tendoo_admin->getSpeMod($id,TRUE);
			if($mod)
			{
				$this->db->where('ID',$id)->update('tendoo_modules',array(
					'ACTIVE'	=>	1
				));
				$this->url->redirect(array('admin','modules'));
				return true;
			}
			return false;
		}
		else
		{
			$mod	=	$this->getSpeModuleByNamespace($id);
			if($mod)
			{
				$this->db->where('NAMESPACE',$id)->update('tendoo_modules',array(
					'ACTIVE'	=>	1
				));
				return $mod;
			}
			return false;
		}
	}
	public function get_modules($start = NULL,$end = NULL)
	{
		$this->db		->select('*')
							->from('tendoo_modules');
		if(is_numeric($start) && is_numeric($end))
		{
			$this->db	->limit($end,$start);	
		}
		$query				= $this->db->get();
		return $query->result_array();
	}
	public function get_bypage_module()
	{
		$this->db		->select('*')
							->where('TYPE','BYPAGE')
							->from('tendoo_modules');
		$query				= $this->db->get();
		return $query->result_array();
	}
	// Module Functions
	public function uninstall_module($id)
	{
		$Module		=	$this->getSpeMod($id,TRUE);
		if($Module !== FALSE)
		{
			if(is_file(MODULES_DIR.$Module[0]['ENCRYPTED_DIR'].'/uninstall.php'))
			{
				include_once(MODULES_DIR.$Module[0]['ENCRYPTED_DIR'].'/uninstall.php');
			}
			$this->drop(MODULES_DIR.$Module[0]['ENCRYPTED_DIR']);
			return	$this->db->delete('tendoo_modules',array('ID'=>$id));
		}
	}
	public function getSpeMod($value,$byid = TRUE)
	{
		$this->db		->select('*')
							->from('tendoo_modules');
		if($byid == TRUE)
		{
			$this->db->where('ID',$value);
		}
		else
		{
			$this->db->where('NAMESPACE',$value);
		}
							
		$query				= $this->db->get();
		$data				=	 $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;		
	}
	public function getAppImgIco($appNameSpace)
	{
		$app	=	$this->getSpeModuleByNamespace($appNameSpace);
		if($app)
		{
			$file	=	MODULES_DIR.$app[0]['ENCRYPTED_DIR'].'/app_icon.';
			foreach(array('png','jpg','gif') as $g)
			{
				if(is_file($file.$g))
				{
					return $this->url->main_url().$file.$g;
				}
			}
		}
		return false;
	}
	public function getAppIcon()
	{
		$globalMod	=	$this->get_modules();
		$finalIcons	=	array();
		if(is_array($globalMod))
		{
			foreach($globalMod as $modules)
			{
				if($modules['HAS_ICON'] == "1")
				{
					$files	=	MODULES_DIR.$modules['ENCRYPTED_DIR'].'/config/icon_config.php';
					if(is_file($files))
					{
						include($files);
						if(isset($ICON_CONFIG))
						{
							$finalIcons[]	=	$ICON_CONFIG;
						}
					}
				}
			}
			return $finalIcons;
		}
		return false;
	}
	public function saveVisibleIcons($availableIcons)
	{
		$content	=	'$icons	=	array();';
		if(is_array($availableIcons))
		{
			foreach($availableIcons as $a)
			{
				$content	.=	'$icons[]	=	"'.$a.'";';
			}
			return $this->db->update('tendoo_options',array('ADMIN_ICONS'=>$content));
		}
		return false;
	}
	
}