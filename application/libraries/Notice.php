<?php
class notice
{
	/**
	 * Notice class
	 *
	 * Save and enqueue notifications within a big array 
	 * which can be outputed using "parse_notice" method.
	**/
	
	private $notice;
	public function __construct()
	{
		$this->notice = '';
	}
	public function push_notice($e)
	{
		$this->notice[]	=	$e;
	}
	public function output_notice($return = FALSE)
	{
		if(is_array($this->notice))
		{
			$final		=	'';
			foreach($this->notice as $n)
			{
				if($return == FALSE)
				{
					if( is_callable( $n ) )
					{
						$n();
					}
					else
					{
						echo $n;
					};
				}
				else
				{
					if( is_callable( $n ) )
					{
						ob_start();
						$n();
						$final	.=	ob_get_clean();
					}
					else
					{
						$final	.=	$n;
					};
				}
			}
			return $final;
		}
		else
		{
			return $this->notice;
		}
	}
	public function get_notice_array()
	{
		return $this->notice;
	}
}