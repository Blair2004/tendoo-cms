<?php
class tendoo_contact_handler_backend extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		// **
		// Setup Admin Menu
		setup_admin_left_menu( 'Contact Manager' , 'comments' );
		add_admin_left_menu( 'Accueil' , module_url( array( 'index' ) ) );
		add_admin_left_menu( 'Réglages' , module_url( array( 'setting' ) ) );
		// End Setup Admin Menu
		declare_notices( 'posted' , tendoo_success( 'Message envoyé.' ) );
		declare_notices( 'unknowContactMessage' , tendoo_error( 'Discussion introuvable ou indisponible.' ) );
		// **
		$this->data						=&	$data;		
		$this->data['module']			=	$data['module']	=	get_core_vars( 'opened_module' );
		$this->module_dir				=	MODULES_DIR.$data['module']['encrypted_dir'];
		$this->module_namespace			=	$data['module']['namespace']; // retreive namespace
		if($this->tendoo_admin->actionAccess('tendoo_contact_handler','tendoo_contact_handler') === FALSE)
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		include_once($this->module_dir.'/library.php');
		$this->lib						=	new tendoo_contact_handler_class();
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true,FALSE,$this);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE,$this);
		set_page('description',$this->data['module']['human_name']);
		
	}
	public function index($page	=	1,$action = "",$element	=	'')
	{
		$this->data['countPost']		=	count($this->lib->getSendedContact());
		$this->data['paginate']			=	$this->tendoo->paginate(10,$this->data['countPost'],1,'','',$page,$this->url->site_url(array('admin','open','modules',$this->module_namespace,'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect


		$this->data['retreiContact']	=	$this->lib->getSendedContact($this->data['paginate'][1],$this->data['paginate'][2]);
		set_page('title','Liste des messages');
		
		$this->data['body']			=	$this->load->view($this->module_dir.'/views/body',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function setting()
	{
		$this->load->library('form_validation');
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
					notice('push',fetch_notice_output('done'));
				}
				else
				{
					notice('push',fetch_notice_output('error_occured'));
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
					notice('push',fetch_notice_output('done'));
				}
				else
				{
					notice('push',fetch_notice_output('error_occured'));
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
				 notice('push',fetch_notice_output('done'));
			 }
			 else
			 {
				 notice('push',fetch_notice_output('error_occured'));
			 }
		}
		if(isset($_POST['contact_description_submit']))
		{
			if($this->lib->addDescription($this->input->post('contact_description')))
			{
				notice('push',fetch_notice_output('done'));
			}
			else
			{
				notice('push',fetch_notice_output('error_occured'));
			}
		}
		
		$this->data['gDescription']	=	$this->lib->getDescription();
		$this->data['getFields']	=	$this->lib->getToggledFields();
		$this->data['getContact']	=	$this->lib->getContact();
		
		set_page('title','Param&ecirc;tres');
		$this->visual_editor->loadEditor(1);
		$this->data['body']			=	$this->load->view($this->module_dir.'/views/setting',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function check($id)
	{
		if(isset($_POST['messageToSender']))
		{
			$query	=	$this->users_global->write($this->input->post('userTo'),$this->input->post('messageToSender'));
			notice('push',fetch_notice_output($query));
		}
		$this->data['getSpeContact']	=	$this->lib->getSendedContact($id);
		if($this->data['getSpeContact'] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
		
		set_page('title','Lecture d\'un message');
		
		$this->data['body']			=	$this->load->view($this->module_dir.'/views/read',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function delete($id)
	{
		if($this->lib->deleteContact($id))
		{
			$this->url->redirect(array('admin','open','modules',$this->data['module']['namespace'].'?notice=done'));
		}
		else
		{
			$this->url->redirect(array('admin','open','modules',$this->data['module']['namespace'].'?notice=unknowContactMessage'));
		}
	}
}
