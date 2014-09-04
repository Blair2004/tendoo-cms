<?php
class tim_backend extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		// $this->load->library( 'GUI' );
		$this->module_metas	=	get_core_vars( 'opened_module' );
		setup_admin_left_menu( 'TIM' , 'star' );
		add_admin_left_menu( 'Accueil' , module_url( array( 'index' ) ) );
		// **
		// declare_notices( 'posted' ,tendoo_success( 'Message envoyé.' ) );
		// **
		set_core_vars( 'page_title' , "Bonjour" );
		
	}
	public function index()
	{
		$active_theme 		= 	get_core_vars( 'active_theme' );
		$setting_key		=	$active_theme[ 'NAMESPACE' ] . '_theme_settings';
		
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'api_limit' , 'API LIMIT' , 'required' );
		$this->form_validation->set_rules( 'declared_apis' , 'Declared API' , 'required' );
		$this->form_validation->set_rules( 'declared_item' , 'Declared Item' , 'required' );
		// For Static using API
		if( $this->form_validation->run() ){
			if( $active_theme ){			
				$datas_get			=	get_meta( $setting_key );	
				$saved_settings		=	$datas_get ? $datas_get : array();
				// If there are same setting already saved, they'll be overwrited
				$saved_settings[ $this->input->post( 'declared_item' ) ] = array(
					'api_limit'		=>	$this->input->post( 'api_limit' ),
					'declared_apis'	=>	$this->input->post( 'declared_apis' ),
					'declared_item'	=>	$this->input->post( 'declared_item' )
				);
				if( set_meta( $active_theme[ 'NAMESPACE' ] . '_theme_settings' , $saved_settings ) ){
					notice( 'push' , fetch_notice_output( 'done' ) );
				}
			}
		}
		// For Static not draggable
		if( $this->input->post( 'is_static_item' ) ){
			$this->load->library( 'form_validation' );
			if( $static	= return_if_array_key_exists( 'static' , $_POST ) ){
				if( is_array( $static ) ){
					$active_theme	=	get_core_vars( 'active_theme' );
					$saved_settings	=	get_meta( $active_theme[ 'NAMESPACE' ] . '_theme_settings' );
					foreach( $static  as $namespace	=> $item ){
						if( is_array( $item ) ){
							foreach( $item as $name	=> $fields ){
								$saved_settings[ $namespace ][ $name ] = $fields;
							}
						}
					};
					if( set_meta( $active_theme[ 'NAMESPACE' ] . '_theme_settings' , $saved_settings ) ){
						notice( 'push' , fetch_notice_output( 'done' ) );
					}
				}				
			}
		}
		// Add Settings to Core vars
		push_core_vars( 'active_theme' , 'theme_settings' , get_meta( $setting_key ) );
				
		set_page( 'title' , 'TIM | ' . get( 'core_version' ) );
		
		return $this->load->view( $this->module_metas[ 'uri_path' ].'views/body', array() , true , true );
	}
}
