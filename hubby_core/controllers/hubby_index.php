<?php
class hubby_index
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
		$this->core->file->css_push('font');$this->core->file->css_push('hubby_global');
		
		$this->core->hubby->setTitle('Bienvenue sur '.$this->core->hubby->getVersion());
		$this->core->load->view('header',$this->data);
		$this->core->load->view('hubby_index_body',$this->data);
	}
}
