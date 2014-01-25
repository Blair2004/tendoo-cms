<?php
/// -------------------------------------------------------------------------------------------------------------------///
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['categoryCreated']			=	'<span class="success">La cat&eacute;gorie &agrave; &eacute;t&eacute; correctement cr&eacute;e</span>';
$or['categoryAldreadyCreated']	=	'<span class="error">Cette cat&eacute;gorie existe d&eacute;j&agrave;</span>';
$or['unknowCat']				=	'<span class="error">Cette cat&eacute;gorie est inexistante</span>';
$or['categoryUpdated']			=	'<span class="success">La mise &agrave; jour &agrave; r&eacute;ussie</span>';
$or['CatDeleted']				=	'<span class="success">La cat&eacute;gorie &agrave; &eacute;t&eacute; supprim&eacute; avec succ&egrave;s</span>';
$or['CatNotEmpty']				=	'<span class="error">Cette cat&eacute;gorie ne peut pas &ecirc;tre supprim&eacute;e, car il existe des publications qui y sont rattach&eacute;es. Changez la cat&eacute;gorie de ces publications avant de supprimer cette cat&eacute;gorie.</span>';
$or['noCategoryCreated']		=	'<span class="error"><i class="icon-warning"></i> Avant de publier un article, vous devez cr&eacute;er une cat&eacute;gorie.</span>';

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
/// -------------------------------------------------------------------------------------------------------------------///
class news_quick_press_admin_widget
{
	private $options;
	private $core;
	private $data;
	private $news;
	private $htmlCode;
	public function __construct($options)
	{
		include_once($this->options['MODULE_DIR'].'library.php');
		$this->core		= 	Controller::instance();
		$this->options	=	$options;
		$this->news		=	new News($this->data);
		$this->data['cat']	=	$this->news->getCat();
		$this->data['getMod']	=	$this->core->tendoo_admin->getSpeMod('news',FALSE);
		
		if(!method_exists($this->core,'form_validation'))
		{
			$this->core->load->library('form_validation');
		}
		$this->core->form_validation->set_rules('quick_press_title','Intitulé de l\'article','trim|required|min_length[5]|max_length[200]');
		$this->core->form_validation->set_rules('quick_press_content','Contenu de l\'article','trim|required|min_length[5]|max_length[5000]');
		$this->core->form_validation->set_rules('push_directly','Choix de l\'action','trim|required|min_length[5]|min_length[1000]');		
		$this->core->form_validation->set_rules('quick_press_img_link','Lien de l\'image','trim|required|min_length[5]|min_length[1000]');		
		$this->core->form_validation->set_rules('quick_press_cat','Categorie','trim|required|min_length[1]|min_length[1000]');		

		$this->data['form_validation']	=	validation_errors();
		if($this->core->form_validation->run())
		{
			$this->data['result']	=	$this->news->publish_news(
				$this->core->input->post('quick_press_title'),
				$this->core->input->post('quick_press_content'),
				$this->core->input->post('push_directly'),
				$this->core->input->post('quick_press_img_link'),
				$this->core->input->post('quick_press_cat')
			);
			if($this->data['result'])
			{
				$this->core->url->redirect(array('admin','index?notice=done'));
			}
			else
			{
				$this->core->url->redirect(array('admin','index?notice=error'));
			}
		}
		$this->htmlCode	=	$this->core->load->view($this->options['MODULE_DIR'].'views/admin_widget_1',$this->data,TRUE,TRUE);
	}
	public function parseCode()
	{
		return $this->htmlCode;
	}
}