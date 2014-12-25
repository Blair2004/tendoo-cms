<?php
class tim_init_class
{
	function __construct(){
		// Saving Theme Settings
		$active_theme	=	get_core_vars( 'active_theme' );
		if( riake( 'namespace' , $active_theme ) ){
			$settings		=	get_meta( $active_theme[ 'namespace' ] . '_theme_settings' );
			if( $settings ){
				push_core_vars( 'active_theme' , 'theme_settings' , $settings );
			}
		}
		$this->module		=	get_modules( 'filter_namespace' , 'tim' );
		if( is_admin() )
		{
			$this->menu		=	new Menu;
			$this->menu		=	new Menu;
			$this->menu->add_admin_menu_core( 'themes' , array(
				'title'			=>		__( 'Theme Options' ),
				'icon'			=>		'fa fa-columns',
				'href'			=>		get_instance()->url->site_url( array('admin','open','modules',$this->module['namespace']) )
			) );
		}
	}
}