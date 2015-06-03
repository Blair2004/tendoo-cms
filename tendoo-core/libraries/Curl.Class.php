<?php
class Curl
{
	private $co;
	private	$options;
	private $userAgent;
	private $stylish;
	private $loadImage	=	TRUE;
	private $returnContent= TRUE;
	public function __construct()
	{
		if( function_exists( 'curl_init' ) ){
			$this->co		=	curl_init();
		}
		else {
			get_instance()->tendoo->error( "curl_is_not_set" );
			die();
		}
		
	}
	public function _setOpt($opts,$value)
	{
		curl_setopt($this->co,$opts,$value);
	}
	public function showImg($e)
	{
		if(is_bool($e))
		{
			$this->loadImage = $e;
		}
	}
	public function _exec()
	{
		if(!isset($this->userAgent))
		{
			curl_setopt($this->co,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
		}
		else
		{
			curl_setopt($this->co,CURLOPT_USERAGENT,$this->userAgent);
		}
		if($this->stylish == TRUE)
		{
			curl_exec($this->co);
		}
		else
		{
			ob_start();
			curl_exec($this->co);
			$content = ob_get_contents();
			ob_end_clean();
			$content	=	preg_replace('#<link(.+)/>#','',$content);
			$content	=	preg_replace('#<script(.+)>(.+)</script>#','',$content);
			if($this->loadImage != TRUE)
			{
				$content	=	preg_replace('/<img[^>]+\>/i','',$content);
			}
			if($this->returnContent == TRUE)
			{
				return $content;
			}
			else
			{
				echo $content;
			}
		}
	}
	public function userAgent($userAgent)
	{
		$this->userAgent	=	$userAgent;
	}
	public function follow($e)
	{
		if(is_bool($e))
		{
			$this->_setOpt(CURLOPT_FOLLOWLOCATION,$e);
		}
	}
	public function stylish($e)
	{
		is_bool($e)? $this->stylish = $e : $this->stylish = FALSE;
	}
	public function post($url,$data)
	{
		$this->_setOpt(CURLOPT_URL,$url);
		$this->_setOpt(CURLOPT_POST, 1);
		$this->_setOpt(CURLOPT_POSTFIELDS, $data);
		return $this->_exec();
	}
	public function get($url)
	{
		$this->_setOpt(CURLOPT_URL,$url);
		return $this->_exec();
	}
	public function security($option)
	{
		if(is_bool($option)):$this->_setOpt(CURLOPT_SSL_VERIFYPEER,$option);endif;
		return $this;
	}
	public function returnContent($e)
	{
		if(is_bool($e))
		{
			$this->returnContent = $e;
		}
	}
}