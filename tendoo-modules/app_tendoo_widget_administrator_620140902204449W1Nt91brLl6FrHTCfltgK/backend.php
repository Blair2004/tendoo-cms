<?php
class tendoo_widget_administrator_backend extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		$this->instance					=	get_instance();
		$this->tendoo					=	$this->instance->tendoo;
		$this->module					=	get_core_vars( 'opened_module' );
		$this->moduleNamespace			=	$this->module['namespace']; // retreive namespace
		$this->tendoo_admin				=&	$this->instance->tendoo_admin;
		$this->data						=&	$data;
		$this->notice					=&	$this->instance->notice;
		$this->data['module_dir']		=	$this->module['uri_path'];
		$this->lib						=	new widhandler_lib($this->data);
		$this->data['lib']				=&	$this->lib;
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		if( !current_user()->can( 'manage_widgets@tendoo_widget_administrator' ) )
		{
			$this->instance->url->redirect(array('admin','index?notice=access_denied'));
		}
	}
	public function index($page	=	1,$action = "",$element	=	'')
	{
		if(isset($_POST['tewi_wid']))
		{
			$result	=	$this->lib->save_widgets($_POST['tewi_wid']);
			if(is_array($result))
			{
				$this->instance->notice->push_notice(tendoo_info($result['success'].' widget(s) has been created. '.$result['error'].' error(s)'));
			}
			else
			{
				$this->instance->notice->push_notice(fetch_notice_output($result));
			}
		}
		$this->instance->file->js_push('jquery-ui-1.10.4.custom.min');
		$this->instance->file->js_url	=	$this->instance->url->main_url().$this->data['module_dir'].'/js/';
		$this->instance->file->js_push('tewi_script');
		
		$this->instance->file->css_url	=	$this->instance->url->main_url().$this->data['module_dir'].'/css/';
		$this->instance->file->css_push('style');
		
		
		$this->data['modules']		=	get_modules( 'filter_active' );
		$this->data['finalMod']		=	array();
		foreach($this->data['modules']	as $module)
		{
			if($module['has_widget']	==	true )
			{
				$widget_config_file		=	MODULES_DIR.$module['encrypted_dir'].'/config/widget_config.php';
				if(file_exists($widget_config_file))
				{
					include_once($widget_config_file);
					if(isset($WIDGET_CONFIG))
					{
						foreach($WIDGET_CONFIG as $wc)
						{
							$this->data[ 'finalMod' ][]	=	$wc;
						}
					}
				}
			}
		}
		$this->data['widgets_left']			=	$this->lib->tewi_getWidgets('left');
		$this->data['widgets_right']		=	$this->lib->tewi_getWidgets('right');
		$this->data['widgets_bottom']		=	$this->lib->tewi_getWidgets('bottom');
		// var_dump($this->data['widgets_right']);
		set_page('title', __( 'Tendoo - Manage Widgets' ) );
		
		$this->data['body']			=	$this->load->view($this->data['module_dir'].'/views/body',$this->data,true,TRUE);
		return $this->data['body'];
	}
}
