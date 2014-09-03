<?php
class Pages_editor_frontend extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->module	=	get_core_vars( 'opened_module' );
		$this->lib		=	new page_library;
		$this->data		=	array();
		$this->data['current_page']		=	get_core_vars( 'page' );
		set_bread( array (
			'link'	=>	get_instance()->url->site_url(array($this->data['current_page'][0]['PAGE_CNAME'])),
			'text'	=>	$this->data['current_page'][0]['PAGE_CNAME']
		) );
	}
	public function index($parameters)
	{
		// var_dump( $parameters );
		set_core_vars( 'pages_editor_parameters' , $parameters );
		set_core_vars( 'pages_editor_loaded_page' , $static_page	=	$this->lib->get_static_page( $parameters ) , 'read_only' );
		if( is_array( $static_page ) ){
			if( is_array( return_if_array_key_exists( 'THREAD' , $static_page[0] ) ) ){
				foreach( $static_page[0][ 'THREAD' ] as $_thread ){
					$_current_page	=	$this->lib->get_pages( 'filter_title_url' , $_thread );
					if( $_current_page ){
						if( return_if_array_key_exists( 'THREAD' , $_current_page[0] ) ){
							set_bread( array (
								'link'	=>	get_instance()->url->site_url( $_current_page[0][ 'THREAD' ]),
								'text'	=>	$_current_page[0][ 'TITLE' ]
							) );
						}
					}
				}
			}
		}
		set_core_vars( 'module_content' , $this->load->view($this->module[0]['URI_PATH'].'/views/common',$this->data,true,TRUE) );
		
		get_core_vars('active_theme_object')->head($this->data);
		get_core_vars('active_theme_object')->body($this->data);
	}
}
