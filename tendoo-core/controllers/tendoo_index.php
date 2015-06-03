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
		css_push_if_not_exists('../admin-lte/bootstrap/css/bootstrap.min');
		css_push_if_not_exists('../admin-lte/font-awesome/font-awesome.4.3.0.min');
		css_push_if_not_exists('../admin-lte/dist/css/AdminLTE.min');
		css_push_if_not_exists('../admin-lte/plugins/iCheck/square/blue');

		
		js_push_if_not_exists('../admin-lte/plugins/jQuery/jQuery-2.1.3.min');
		js_push_if_not_exists('../admin-lte/bootstrap/js/bootstrap.min');
		js_push_if_not_exists('../admin-lte/plugins/iCheck/icheck.min');
		
		set_page('title', __( 'Welcome on' ) . ' ' .get('core_version'));
		set_core_vars( 'body' , $this->load->the_view( 'tendoo_index_body' , true ) );
		$this->load->the_view( 'header' );
		$this->load->the_view( 'global_body' );		
	}
}
