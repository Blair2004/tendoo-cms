<?php
class tendoo_contact_handler_module_controller extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->data			=	$data;
		$this->data[ 'page'	]	=	get_core_vars( 'page' );
		$this->data[ 'module']	=	get_core_vars( 'module' );
		$this->module_dir	=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
		include_once($this->module_dir.'/library.php');
		$this->lib			=	new tendoo_contact_handler_class();
	}
	public function index()
	{
		$this->load->library('form_validation');
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
				notice('push',fetch_error('done'));
			}
		}
		$this->data['gDescription']	=	$this->lib->getDescription();
		$this->data['fields']		=	$this->lib->getToggledFields();
		$this->data['contact']		=	$this->lib->getContact();
		
		set_page('title',$this->data['page'][0]['PAGE_TITLE']);
		set_page('description',$this->data['page'][0]['PAGE_DESCRIPTION']);
		
		get_core_vars('activeTheme_object')->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		get_core_vars('activeTheme_object')->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		set_core_vars( 'module_content' , $this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_main',$this->data,true,TRUE) );
		
		get_core_vars('activeTheme_object')->head($this->data);
		get_core_vars('activeTheme_object')->body($this->data);
	}
}
?>