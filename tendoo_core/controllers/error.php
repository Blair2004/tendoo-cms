<?php 
class error extends Libraries
{
	private $data;
	private $instance;
	public function __construct()
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		$this->instance					=	get_instance();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->load->library('install');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		if($this->instance->db_connected()) // On connecte si 
		{
			$this->load->library('users_global');
			$this->data['options']		=	get_meta( 'all' );
		}
		else
		{
			$this->users_global			=	FALSE;
			$this->data['options']		=	FALSE;
		}
	}
	public function index($e = '')
	{
		$this->code($e);
	}
	public function code($e)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data['code']				=	notice('push',fetch_notice_output($e));
		$this->data['body']				=	$this->load->view('error/inner_body',$this->data,TRUE);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_page('title','Erreur - Tendoo');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->file->css_push('font');
		$this->file->css_push('app.v2');
		$this->file->css_push('tendoo_global');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->load->view('header',$this->data);
		$this->load->view('error/global_body',$this->data);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */