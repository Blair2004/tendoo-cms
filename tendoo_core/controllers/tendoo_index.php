<?php
class Tendoo_index
{
	public function __construct($data = array())
	{
		$this->data		=&	$data;
		__extends($this);
	}
	public function index($arg = '')
	{
		$this->file->css_push('font');
		$this->file->css_push('app.v2');		
		$this->tendoo->setTitle('Bienvenue sur '.$this->tendoo->getVersion());
		$this->load->view('header',$this->data,false,false,$this);
		$this->load->view('tendoo_index_body',$this->data,false,false,$this);
	}
}
