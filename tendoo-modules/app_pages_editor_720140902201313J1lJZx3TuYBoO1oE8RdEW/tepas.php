<?php
class pages_editor_tepas_class extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->module	=	$data;
		$this->load->library('tendoo_admin',null,'admin');
		if(function_exists('declare_shortcut') && get_instance()->users_global->isConnected()){
			if( current_user()->can( 'page_creater@create_page' ) )
			{
				declare_shortcut('Créer une page',$this->url->site_url(array('admin','open','modules', 'page_creater' ,'create')));
			}
		}
		if( is_admin() )
		{
			create_admin_menu( 'pages_editor' , 'after' , 'controllers' );
			
			add_admin_menu( 'pages_editor' , array(
				'title'	=>	__( 'Pages' ), 
				'href'	=>	module_url( array( 'index' ) , 'pages_editor' ),
				'icon'	=>	'fa fa-file-text'
			) );
			
			add_admin_menu( 'pages_editor' , array(
				'title'	=>	__( 'Create a new page' ), 
				'href'	=>	module_url( array( 'create' ) , 'pages_editor' )
			) );
		}
	}
}
