<?php
/// -------------------------------------------------------------------------------------------------------------------///
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['widgetCreated']			=	hubby_success('Le widget &agrave; &eacute;t&eacute; cr&eacute;e.');
$or['errorOccured']				=	hubby_error('Une erreur s\'est produite durant la cr&eacute;ation du widget.');
$or['widgetAlreadyExists']		=	hubby_error('Le widget ne peut pas &ecirc;tre cr&eacute;e. Un autre widget contenant le m&ecirc;me intitul&eacute; existe d&eacute;j&agrave;.');
$or['unknowWidget']				=	hubby_error('Ce widget est introuvable.');
$or['WidgetActivated']			=	hubby_success('Le widget &agrave; &eacute;t&eacute; correctement activ&eacute;.');
$or['WidgetDisabled']			=	hubby_success('Le widget &agrave; &eacute;t&eacute; correctement d&eacute;sactiv&eacute;.');
$or['graped']					=	hubby_success('La modification de la position s\'est effectu&eacute;.');
$or['grapLimitReach']			=	'<span class="hubby_error">La position de ce widget ne peut plus &ecirc;tre modifi&eacute;.</span>';
$or['widgetDeleted']			=	hubby_success('Le widget &agrave; &eacute;t&eacute; supprim&eacute;.');

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
/// -------------------------------------------------------------------------------------------------------------------///

class Hubby_widget_administrator_admin_controller
{
	public function __construct($data)
	{
		$this->core						=	Controller::instance();
		$this->hubby					=	$this->core->hubby;
		$this->moduleNamespace			=	$data['module'][0]['NAMESPACE']; // retreive namespace
		$this->hubby_admin				=&	$this->core->hubby_admin;
		$this->data						=&	$data;
		$this->notice					=&	$this->core->notice;
		$this->data['module_dir']		=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
		$this->adwid_lib				=	new widhandler_lib($this->data);
		
		$this->core->hubby_admin->menuExtendsBefore($this->core->load->view($this->data['module_dir'].'/views/menu',$this->data,true,TRUE));
		$this->data['inner_head']		=	$this->core->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->core->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','widgetsMastering',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=access_denied'));
		}
	}
	public function index($page	=	1,$action = "",$element	=	'')
	{
		if($action	==	'activate' && $element != '')
		{
			$exec	=	$this->adwid_lib->activateWidget($element);
			$this->core->notice->push_notice(notice($exec));
		}
		else if($action	==	'disable' && $element != '')
		{
			$exec	=	$this->adwid_lib->disableWidget($element);
			$this->core->notice->push_notice(notice($exec));
		}
		else if($action	==	'goUp' && $element != '')
		{
			$exec	=	$this->adwid_lib->grapWidget($element);
			$this->core->notice->push_notice(notice($exec));
		}
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('id_fordeletion','Identifiant du widget','trim|required|min_length[1]');
		if($this->core->form_validation->run())
		{
			$exec	=	$this->adwid_lib->deleteWidget((int)$this->core->input->post('id_fordeletion'));
			$this->core->notice->push_notice(notice($exec));
		}
		$this->data['currentPage']		=	$page;
		$this->data['ttWidget']			=	$this->adwid_lib->countWidgets();
		$this->data['paginate']			=	$this->core->hubby->paginate(
			30,
			$this->data['ttWidget'],
			1,
			"",
			"",
			$page,
			$this->core->url->site_url(array('admin','open','modules',$this->data['module'][0]['ID'],'index')).'/'
		); // Pagination
		
		$this->data['getWidgets']		=	$this->adwid_lib->getWidgets($this->data['paginate'][1],$this->data['paginate'][2]);
		$this->hubby->setTitle('Gestionnaire de widget - Page d\'administration');
		
		$this->data['body']			=	$this->core->load->view($this->data['module_dir'].'/views/body',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function create_widget()
	{
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('widget_title','Intitulé du widget','trim|required|min_length[5]|max_length[50]');
		$this->core->form_validation->set_rules('widget_content','Contenu du widget','trim|required|min_length[5]|max_length[1000]');
		$this->core->form_validation->set_rules('widget_description','Description du widget','trim|required|min_length[5]|max_length[1000]');
		if($this->core->form_validation->run())
		{
			$query	=	$this->adwid_lib->createWidget(
				$this->core->input->post('widget_title'),
				$this->core->input->post('widget_description'),
				$this->core->input->post('widget_content')
			);
			$this->core->notice->push_notice(notice($query));
		}
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('createSpecial','','trim|required|min_length[2]');
		$this->core->form_validation->set_rules('widget_ref','','trim|required|min_length[2]');
		$this->core->form_validation->set_rules('widget_description','','trim|required|min_length[3]');
		$this->core->form_validation->set_rules('widget_title','','trim|required|min_length[3]');
		if($this->core->form_validation->run())
		{
			$query	=	$this->adwid_lib->createSpecialWidget(
				$this->core->input->post('widget_title'),
				$this->core->input->post('widget_description'),
				$this->core->input->post('widget_ref')
			);	
			$this->core->notice->push_notice(notice($query));
		}
		$this->data['modules']		=	$this->hubby_admin->get_modules();
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
		$this->hubby->loadEditor(3);
		$this->hubby->setTitle('Gestionnaire de widget - Cr&eacute;er un widget');
		
		$this->data['body']			=	$this->core->load->view($this->data['module_dir'].'/views/create',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function edit($we)
	{
		$this->hubby->loadEditor(3);
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('widget_id','Intitulé du widget','trim|required|min_length[1]|max_length[11]');
		$this->core->form_validation->set_rules('widget_title','Intitulé du widget','trim|required|min_length[5]|max_length[50]');
		$this->core->form_validation->set_rules('widget_content','Contenu du widget','trim|required|min_length[5]|max_length[1000]');
		$this->core->form_validation->set_rules('widget_description','Description du widget','trim|required|min_length[5]|max_length[1000]');
		if($this->core->form_validation->run())
		{
			$query	=	$this->adwid_lib->editWidget(
				$this->core->input->post('widget_id'),
				$this->core->input->post('widget_title'),
				$this->core->input->post('widget_description'),
				$this->core->input->post('widget_content')
			);
			if($query)	:	$this->core->notice->push_notice(notice('done'));			endif;
			if(!$query)	:	$this->core->notice->push_notice(notice('error_occured'));	endif;
		}
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('widget_id','Intitulé du widget','trim|required|min_length[1]|max_length[11]');
		$this->core->form_validation->set_rules('widget_title','Intitulé du widget','trim|required|min_length[5]|max_length[50]');
		$this->core->form_validation->set_rules('widget_description','Description du widget','trim|required|min_length[5]|max_length[1000]');
		$this->core->form_validation->set_rules('updateSpecial','Description du widget','trim|required|min_length[2]');
		if($this->core->form_validation->run())
		{
			$query	=	$this->adwid_lib->editSpecialWidget(
				$this->core->input->post('widget_id'),
				$this->core->input->post('widget_title'),
				$this->core->input->post('widget_description'),
				$this->core->input->post('widget_ref')
			);
			if($query)	:	$this->core->notice->push_notice(notice('done'));			endif;
			if(!$query)	:	$this->core->notice->push_notice(notice('error_occured'));	endif;
		}
		// Prie en charge de widgets embarqués.
		$this->data['modules']		=	$this->hubby_admin->get_modules();
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
		$this->data['getWidget']		=	$this->adwid_lib->getWidgets($we);
		if($this->data['getWidget'] != false)
		{
			$this->data['body']			=	$this->core->load->view($this->data['module_dir'].'/views/edit',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->core->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=unknowWidget'));
		}
	}
}
