<?php
class Tendoo_index
{
	protected $data;
	private $core;
	public function __construct()
	{
		$this->core	=	Controller::instance();
		$this->core->load->library('file');
	}
	public function index($arg = '')
	{
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('css1');
		$this->core->file->css_push('css2');
		$this->core->file->css_push('font');$this->core->file->css_push('Tendoo_global');
		
		$this->core->tendoo->setTitle('Bienvenue sur '.$this->core->tendoo->getVersion());
		$this->core->load->view('header',$this->data);
		$this->core->load->view('tendoo_index_body',$this->data);
	}
}
