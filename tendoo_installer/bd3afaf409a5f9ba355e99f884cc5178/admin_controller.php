<?php
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
/// -------------------------------------------------------------------------------------------------------------------///
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['widgetCreated']			=	tendoo_success('Le widget &agrave; &eacute;t&eacute; cr&eacute;e.');
$or['errorOccured']				=	tendoo_error('Une erreur s\'est produite durant la cr&eacute;ation du widget.');
$or['widgetAlreadyExists']		=	tendoo_error('Le widget ne peut pas &ecirc;tre cr&eacute;e. Un autre widget contenant le m&ecirc;me intitul&eacute; existe d&eacute;j&agrave;.');
$or['unknowWidget']				=	tendoo_error('Ce widget est introuvable.');
$or['WidgetActivated']			=	tendoo_success('Le widget &agrave; &eacute;t&eacute; correctement activ&eacute;.');
$or['WidgetDisabled']			=	tendoo_success('Le widget &agrave; &eacute;t&eacute; correctement d&eacute;sactiv&eacute;.');
$or['graped']					=	tendoo_success('La modification de la position s\'est effectu&eacute;.');
$or['grapLimitReach']			=	'<span class="tendoo_error">La position de ce widget ne peut plus &ecirc;tre modifi&eacute;.</span>';
$or['widgetDeleted']			=	tendoo_success('Le widget &agrave; &eacute;t&eacute; supprim&eacute;.');

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
/// -------------------------------------------------------------------------------------------------------------------///

class tendoo_widget_administrator_admin_controller
{
	public function __construct($data)
	{
		$this->core						=	Controller::instance();
		$this->tendoo					=	$this->core->tendoo;
		$this->moduleNamespace			=	$data['module'][0]['NAMESPACE']; // retreive namespace
		$this->tendoo_admin				=&	$this->core->tendoo_admin;
		$this->data						=&	$data;
		$this->notice					=&	$this->core->notice;
		$this->data['module_dir']		=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
		$this->lib						=	new widhandler_lib($this->data);
		$this->data['lib']				=&	$this->lib;
		
		// $this->core->tendoo_admin->menuExtendsBefore($this->core->load->view($this->data['module_dir'].'/views/menu',$this->data,true,TRUE));
		$this->data['inner_head']		=	$this->core->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->core->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->tendoo_admin->adminAccess('modules','widgetsMastering',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=access_denied'));
		}
	}
	public function index($page	=	1,$action = "",$element	=	'')
	{
		if(isset($_POST['tewi_wid']))
		{
			$result	=	$this->lib->save_widgets($_POST['tewi_wid']);
			if(is_array($result))
			{
				$this->core->notice->push_notice(tendoo_info($result['success'].' widget(s) a/ont été crée(s). '.$result['error'].' erreur(s)'));
			}
			else
			{
				$this->core->notice->push_notice(notice($result));
			}
		}
		$this->core->file->js_push('jquery-ui-1.10.4.custom.min');
		$this->core->file->js_url	=	$this->core->url->main_url().$this->data['module_dir'].'/js/';
		$this->core->file->js_push('tewi_script');
		
		$this->core->file->css_url	=	$this->core->url->main_url().$this->data['module_dir'].'/css/';
		$this->core->file->css_push('style');
		
		
		$this->data['modules']		=	$this->tendoo_admin->get_modules();
		$this->data['finalMod']		=	array();
		foreach($this->data['modules']	as $module)
		{
			if($module['HAS_WIDGET']	==	1)
			{
				$widget_config_file		=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/widget_config.php';
				if(file_exists($widget_config_file))
				{
					include_once($widget_config_file);
					if(isset($WIDGET_CONFIG))
					{
						foreach($WIDGET_CONFIG as $wc)
						{
							$this->data['finalMod'][]	=	$wc;
						}
					}
				}
			}
		}
		$this->data['widgets_left']			=	$this->lib->tewi_getWidgets('left');
		$this->data['widgets_right']		=	$this->lib->tewi_getWidgets('right');
		$this->data['widgets_bottom']		=	$this->lib->tewi_getWidgets('bottom');
		// var_dump($this->data['widgets_right']);
		$this->tendoo->setTitle('tendoo &raquo; Gestion des widgets');
		
		$this->data['body']			=	$this->core->load->view($this->data['module_dir'].'/views/body',$this->data,true,TRUE);
		return $this->data['body'];
	}
}
