<?php
class File
{
	private $jsfiles 	= array();
	private $cssfiles	= array();
	public $css_url		=	'';
	public $js_url		=	'';
	public function css_push($e)
	{
		if($this->css_url != '')
		{
			array_push($this->cssfiles,$this->css_url.$e.'.css');
		}
		else
		{
			array_push($this->cssfiles,css_url($e));
		}
	}
	public function js_push($e)
	{
		if($this->js_url != '')
		{
			array_push($this->jsfiles,$this->js_url.$e.'.js');
		}
		else
		{
			array_push($this->jsfiles,js_url($e));
		}
	}
	/*
	Ajoute un fichier Js à la liste des fichiers télécharger si le fichier n'existe pas.
	Tendoo 0.9.7
	*/
	public function js_push_if_not_exists($e,$temporaryLocation = null) 
	{
		if($temporaryLocation == null)
		{
			if(!in_array($this->js_url.$e.'.js',$this->jsfiles))
			{
				array_push($this->jsfiles,$this->js_url.$e.'.js');
				return true;
			}
		}
		else
		{
			if(!in_array($temporaryLocation.$e.'.js',$this->jsfiles))
			{
				array_push($this->jsfiles,$temporaryLocation.$e.'.js');
				return true;
			}
		}
		return false;
	}
	public function js_clear()
	{
		$this->jsfiles	=	array();
	}
	public function css_load()
	{
		if(is_array($this->cssfiles))
		{
			$val	=	'';
			foreach($this->cssfiles as $css)
			{
				$val.='<link rel="stylesheet" href="'.$css.'" media="screen"/>';
			}
			return $val;
		}
	}
	public function js_load()
	{
		if(is_array($this->jsfiles))
		{
			$val	=	'';
			foreach($this->jsfiles as $js)
			{
				$val.='<script type="text/javascript" src="'.$js.'"></script>';
			}
			return $val;
		}
	}
	public function css_clear()
	{
		$this->cssfiles	=	array();
	}
	/*
	Ajoute un fichier css à la liste des fichiers télécharger si le fichier n'existe pas.
	*/
	public function css_push_if_not_exists($e,$temporaryLocation= null)  
	{
		if($temporaryLocation == null)
		{
			if(!in_array($this->css_url.$e.'.css',$this->cssfiles))
			{
				array_push($this->cssfiles,$this->css_url.$e.'.css');
				return true;
			}
		}
		else
		{
			if(!in_array($temporaryLocation.$e.'.css',$this->cssfiles))
			{
				array_push($this->cssfiles,$temporaryLocation.$e.'.css');
				return true;
			}
		}
		return false;
	}
}
?>