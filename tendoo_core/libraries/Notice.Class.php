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
	public function parse_notice($return = FALSE)
	{
		if(is_array($this->notice))
		{
			$final		=	'';
			foreach($this->notice as $n)
			{
				if($return == FALSE)
				{
					echo $n;
				}
				else
				{
					$final	.=	$n;
				}
			}
			return $final;
		}
		else
		{
			return $this->notice;
		}
	}
}