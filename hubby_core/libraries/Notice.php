<?php
class notice
{
	private $notice;
	public function __construct()
	{
		$this->notice = '';
	}
	public function push_notice($e)
	{
		$this->notice[]	=	$e;
	}
	public function parse_notice()
	{
		if(is_array($this->notice))
		{
			foreach($this->notice as $n)
			{
				echo $n;
			}
			return;
		}
		else
		{
			return $this->notice;
		}
	}
}