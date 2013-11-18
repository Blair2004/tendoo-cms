<?php
class Captcha
{
	private $captchaList;
	private $captchaDirectory;
	private $captchaExtension;
	public function __construct()
	{
		$this->core					=	Controller::instance();
		$this->captchaList			= array('ADEFGQ','ADGCBE','ADIOPD','ADOPSC','ADPSCS','ADRGVD','ADTGDS','ADUIDK','ADYUHI','BASXSQ','BESQCE','BOSQPX','BPQSCS','BRQSCT','BTYDQI','BUJDSQ','BYQSVC','BZSCQX','CDQSXI','CEQSWE','CPSQXZ','CSPQOS','FEQSsE','RXGLMS');
		$this->captchaDirectory		=	$this->core->url->main_url().'hubby_assets/img/captcha/';
		$this->captchaExtension		=	'.png';
	}
	public function get()
	{
		$ttCapt		=	count($this->captchaList);
		$index		=	rand(0,$ttCapt);
		return array(
			'CODE'		=>	$this->captchaList[$index],
			'DIRECTORY'	=>	$this->captchaDirectory.$this->captchaList[$index].$this->captchaExtension,
		);
	}
}
?>