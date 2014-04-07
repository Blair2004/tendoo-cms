<?php
class tendoo_themes
{
	public function __construct()
	{
		__extends($this);
	}
	// THEMING FUNCTIONS
	public function countThemes()
	{
		$query	=	$this->db->get('tendoo_themes');
		return count($query->result_array());
	}
	public function getThemes($start = NULL,$end = NULL)
	{
		if($start  != NULL && $end != NULL )
		{
			$this->db->limit($end,$start);
		}
		$query	=	$this->db->get('tendoo_themes');
		return $query->result_array();
	}
	public function isTheme($id)
	{
		$query	=	$this->db->where('ID',$id)->get('tendoo_themes');
		if(count($query->result_array()) > 0)
		{
			$data	=	$query->result_array();
			if($data[0]['ACTIVATED']	==	'')
			{
				$data[0]['ACTIVATED'] = 'Inactif';
			}
			else if($data[0]['ACTIVATED']	==	'TRUE')
			{
				$data[0]['ACTIVATED'] = 'Actif';
			}
			else
			{
				$data[0]['ACTIVATED'] = 'Statut incompr&eacute;hensible';
			}
			return $data;
		}
		return false;
	}
	public function setDefault($id)
	{
		$theme	=	$this->isTheme($id);
		if($theme)
		{
			$this->db->update('tendoo_themes',array('ACTIVATED'=>''));
			$this->db->where('ID',$id)->update('tendoo_themes',array('ACTIVATED'=>'TRUE'));
			return 'defaultThemeSet';
		}
		return 'unknowTheme';
	}
	public function uninstall_theme($id)
	{
		$theme	=	$this->isTheme($id);
		if($theme)
		{
			if(is_file(THEMES_DIR.$theme[0]['ENCRYPTED_DIR'].'/uninstall.php'))
			{
				include_once(THEMES_DIR.$Module[0]['ENCRYPTED_DIR'].'/uninstall.php');
			}
			$this->db->where('ID',$id)->delete('tendoo_themes');
			$this->drop(THEMES_DIR.$theme[0]['ENCRYPTED_DIR']);
			return 'done';
		}
		return 'unknowTheme';
	}
}