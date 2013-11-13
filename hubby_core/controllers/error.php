<?php 
class error
{
	private $data;
	private $core;
	public function __construct()
	{
		$this->core				=	Controller::instance();
		$this->core->load->library('file');
		$this->core->load->library('notice');
		$this->data['notice']	=	'';
		$this->data['error']	=	'';
		$this->data['success']	=	'';
	}
	public function index($e = '')
	{
		$this->code($e);
	}
	public function code($e)
	{
		$this->data['file']	=&	$this->core->file;
		$this->data['code']	=	$this->core->notice->push_notice(notice($e));
		$this->data['body']	=	$this->core->load->view('error/inner_body',$this->data,TRUE);
		$this->core->hubby->setTitle('Erreur - Hubby');
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('css1');
		$this->core->file->css_push('css2');
		$this->core->file->css_push('font');
		$this->core->file->css_push('ub.framework');
		$this->core->file->css_push('hubby_global');
		$this->core->load->view('header',$this->data);
		$this->core->load->view('error/global_body',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */