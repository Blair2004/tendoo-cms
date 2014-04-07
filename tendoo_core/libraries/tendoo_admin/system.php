<?php
class tendoo_system
{
	public function __construct()
	{
		__extends($this);
	}
	private $sys_not_array	=	array();
	public function system_not($title,$content,$link,$date,$thumb)
	{
		$this->sys_not_array[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATE'				=>	$date,
			'THUMB'				=>	$thumb
		);
	}
	public function get_sys_not()
	{
		return $this->sys_not_array;
	}
}