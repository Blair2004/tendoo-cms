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
}
?>