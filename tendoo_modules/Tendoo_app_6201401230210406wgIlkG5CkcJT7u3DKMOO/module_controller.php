<?php
class Tendoo_contact_handler_module_controller
{
	public function __construct($data)
	{
		__extends($this);
		$this->data			=&	$data;
		$this->module_dir	=	MODULES_DIR.$data['module'][0]['ENCRYPTED_DIR'];
		include_once($this->module_dir.'/library.php');
		$this->lib			=	new Tendoo_contact_handler_class();
	}
	public function index()
	{
		$this->load->library('form_validation');
		__extends($this);
		$this->form_validation->set_rules('contact_user_content','Du contenu du message','trim|required|min_length[5]');
		if($this->form_validation->run())
		{
			if($this->lib->pushContact(
				$this->input->post('user_id'),
				$this->input->post('contact_user_name'),
				$this->input->post('contact_user_content'),
				$this->input->post('contact_user_mail'),
				$this->input->post('contact_user_phone'),
				$this->input->post('contact_user_website'),
				$this->input->post('contact_user_country'),
				$this->input->post('contact_user_city')
			))
			{
				$this->notice->push_notice(notice('done'));
			}
		}
		$this->data['gDescription']	=	$this->lib->getDescription();
		$this->data['fields']		=	$this->lib->getToggledFields();
		$this->data['contact']		=	$this->lib->getContact();
		$this->tendoo->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->tendoo->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_main',$this->data,true,TRUE);
		
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
}
?>