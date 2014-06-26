<?php
class Tendoo_index extends Libraries
{
	public function __construct($data = array())
	{
		parent::__construct();
		__extends($this);
		$this->data		=	$data;
		$this->load->library('file');
	}
	public function index($arg = '')
	{
		css_push_if_not_exists('font');
		css_push_if_not_exists('app.v2');		
		set_page('title','Bienvenue sur '.get('core_version'));
		$this->load->view('header',$this->data,false,false,$this);
		$this->load->view('tendoo_index_body',$this->data,false,false,$this);
	}
}
