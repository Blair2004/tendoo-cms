<?php
/// -------------------------------------------------------------------------------------------------------------------///
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['unknowContactMessage']			=	tendoo_error('Discussion introuvable ou indisponible.');

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
/// -------------------------------------------------------------------------------------------------------------------///

class tendoo_contact_handler_admin_controller
{
	public function __construct($data)
	{
		$this->data						=&	$data;
		__extends($this);
		
		$this->module_dir				=	MODULES_DIR.$data['module'][0]['ENCRYPTED_DIR'];
		$this->module_namespace			=	$data['module'][0]['NAMESPACE']; // retreive namespace
		$this->module_id				=	$data['module'][0]['ID'];
		if($this->tendoo_admin->actionAccess('tendoo_contact_handler','tendoo_contact_handler') === FALSE)
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		include_once($this->module_dir.'/library.php');
		$this->lib						=	new tendoo_contact_handler_class();
		$this->tendoo_admin->menuExtendsBefore($this->load->view($this->module_dir.'/views/menu',$this->data,true,TRUE));
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true,FALSE,$this);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE,$this);
		
	}
	public function index($page	=	1,$action = "",$element	=	'')
	{
		$this->data['countPost']		=	count($this->lib->getSendedContact());
		$this->data['paginate']			=	$this->tendoo->paginate(10,$this->data['countPost'],1,'','',$page,$this->url->site_url(array('admin','open','modules',$this->module_id,'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect


		$this->data['retreiContact']	=	$this->lib->getSendedContact($this->data['paginate'][1],$this->data['paginate'][2]);
		$this->tendoo->setTitle($this->data['module'][0]['HUMAN_NAME'].' - Liste des messages');
		
		$this->data['body']			=	$this->load->view($this->module_dir.'/views/body',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function setting()
	{
		$this->load->library('form_validation');
		__extends($this);
		if(isset($_POST['addContact']))
		{
			$this->form_validation->set_rules('contactType','Le champ du type','trim|required');
			$this->form_validation->set_rules('contactNew','Le champ du type','trim|required');
			if($this->form_validation->run())
			{
				if($this->lib->addContact(
					$this->input->post('contactType'),
					$this->input->post('contactNew')
				))
				{
					$this->notice->push_notice(notice('done'));
				}
				else
				{
					$this->notice->push_notice(notice('error_occured'));
				}
			}
		}
		if(isset($_POST['removeContact']))
		{
			$this->form_validation->set_rules('contactId','Le champ du type','trim|required');
			if($this->form_validation->run())
			{
				if($this->lib->removeContact($this->input->post('contactId')))
				{
					$this->notice->push_notice(notice('done'));
				}
				else
				{
					$this->notice->push_notice(notice('error_occured'));
				}
			}
		}
		if(isset($_POST['showFields']))
		{
			 if($this->lib->toogleFields(
			 	$this->input->post('showName'),
				$this->input->post('showEmail'),
				$this->input->post('showPhone'),
				$this->input->post('showWebSite'),
				$this->input->post('showCountry'),
				$this->input->post('showCity')))
			 {
				 $this->notice->push_notice(notice('done'));
			 }
			 else
			 {
				 $this->notice->push_notice(notice('error_occured'));
			 }
		}
		if(isset($_POST['contact_description_submit']))
		{
			if($this->lib->addDescription($this->input->post('contact_description')))
			{
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('error_occured'));
			}
		}
		
		$this->data['gDescription']	=	$this->lib->getDescription();
		$this->data['getFields']	=	$this->lib->getToggledFields();
		$this->data['getContact']	=	$this->lib->getContact();
		
		$this->tendoo->setTitle($this->data['module'][0]['HUMAN_NAME'].' - Param&ecirc;tres');
		$this->tendoo->loadEditor(1);
		$this->data['body']			=	$this->load->view($this->module_dir.'/views/setting',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function check($id)
	{
		if(isset($_POST['messageToSender']))
		{
			$query	=	$this->users_global->write($this->input->post('userTo'),$this->input->post('messageToSender'));
			$this->notice->push_notice(notice($query));
		}
		$this->data['getSpeContact']	=	$this->lib->getSendedContact($id);
		if($this->data['getSpeContact'] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
		
		$this->tendoo->setTitle($this->data['module'][0]['HUMAN_NAME'].' - Lire un message');
		
		$this->data['body']			=	$this->load->view($this->module_dir.'/views/read',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function delete($id)
	{
		if($this->lib->deleteContact($id))
		{
			$this->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=done'));
		}
		else
		{
			$this->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'].'?notice=unknowContactMessage'));
		}
	}
}
