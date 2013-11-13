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
		$this->core->file->css_push('reset');
		$this->core->file->css_push('hubby_global');
		$this->core->file->css_push('ub.framework');
		$this->core->hubby->setTitle('Bienvenue sur '.$this->core->hubby->getVersion());
		$this->core->load->view('header',$this->data);
		$this->core->load->view('hubby_index_body',$this->data);
	}
}
