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
		$this->load->library('file');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		if($this->instance->db_connected()) // On connecte si 
		{
			$this->load->library('users_global');
			$this->data['options']		=	get_meta( 'all' );
			trigger_inits(); // For Core menu extension, they are called after default menu.
		
			/**
			 * 	Declare Notices : Notices are internal(system) or module/theme alert.
			**/
				
			set_core_vars( 'tendoo_notices' , trigger_filters( 'declare_notices' , array( get_core_vars( 'default_notices' ) ) ) ); // @since 1.4		
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
		set_core_vars( 'code' ,	notice('push',fetch_notice_output($e)) );
		set_core_vars( 'body' , $this->load->view('error/inner_body',$this->data,TRUE) );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		set_page('title', translate( 'Error - Tendoo' ) );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		css_push_if_not_exists('../admin-lte/bootstrap/css/bootstrap.min');
		css_push_if_not_exists('../admin-lte/font-awesome/font-awesome.4.3.0.min');
		css_push_if_not_exists('../admin-lte/dist/css/AdminLTE.min');
		css_push_if_not_exists('../admin-lte/plugins/iCheck/square/blue');

		
		js_push_if_not_exists('../admin-lte/plugins/jQuery/jQuery-2.1.3.min');
		js_push_if_not_exists('../admin-lte/bootstrap/js/bootstrap.min');
		js_push_if_not_exists('../admin-lte/plugins/iCheck/icheck.min');
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->load->view('header',$this->data);
		$this->load->view('error/global_body',$this->data);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */