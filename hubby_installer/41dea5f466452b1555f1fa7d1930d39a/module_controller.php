<?php
class Hubby_index_mod_module_controller
{
	private $data;
	private $core;
	private $ium;
	public function __construct($data)
	{
		$this->core				=	Controller::instance();
		$this->data				=&	$data;
		
		$this->data['libFile']			=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/library.php';
		$this->data['elementOptFile']	=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/element_options.php';
		$this->data['newsOptFile']		=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/news_options.php';
		
		if(!is_file($this->data['elementOptFile']) && !is_file($this->data['newsOptFile']) && !is_file($this->data['libFile'])) 
		{
			$this->core->url->redirect(array('error','code','moduleBug'));
		}
		include_once($this->data['libFile']);
		include_once($this->data['elementOptFile']);
		include_once($this->data['newsOptFile']);
		
		$this->ium						=	new Index_mod_user;
		$this->data['elementOpt']		=	$ELEMENT_OPTIONS;
		$this->data['newsOpt']			=	$OPTIONS;
		
	}
	public function index()
	{
		if($this->data['elementOpt']['CAROUSSEL']	== TRUE)
		{
			if($this->data['newsOpt']['CAROUSSEL']['SHOW'] === TRUE)
			{
				$this->data['news']		=	$this->ium->getNews(0,$this->data['newsOpt']['CAROUSSEL']['LIMIT']);
				$this->data['Contller']	=	$this->ium->getControllerNameAttachedToNewsMod();
			}
		}
		if($this->data['elementOpt']['INFOSMALLDETAILS']	== TRUE)
		{
			if($this->data['newsOpt']['INFOSMALLDETAILS']['SHOW'] === TRUE)
			{
				$this->data['news_2']		=	$this->ium->getNews(0,$this->data['newsOpt']['INFOSMALLDETAILS']['LIMIT']);
				$this->data['Ctrl_2']		=	$this->ium->getControllerNameAttachedToNewsMod();
			}
		}
		if($this->data['elementOpt']['ONTOP']	== TRUE)
		{
			if($this->data['newsOpt']['ONTOP']['SHOW'] === TRUE)
			{
				$this->data['news_3']		=	$this->ium->getNews(0,$this->data['newsOpt']['ONTOP']['LIMIT']);
				$this->data['Ctrl_3']		=	$this->ium->getControllerNameAttachedToNewsMod();
			}
		}
		$this->data['hubby']->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['hubby']->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		// Load View		
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/module_view',$this->data,true,TRUE);
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
}