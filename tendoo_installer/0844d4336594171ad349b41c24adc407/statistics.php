<?php
class news_statistics_admin_widget
{
	private $options;
	private $core;
	private $data;
	private $htmlCode;
	public function __construct($options)
	{
		$this->core		= 	Controller::instance();
		$this->options	=	$options;
		$this->data['nbrArticles']			=	$this->core->db->get('tendoo_news');
		$this->data['nbrArticlesActvated']	=	$this->core->db->where("ETAT","1")->get('tendoo_news');
		$this->data['draft']				=	$this->core->db->where("ETAT","0")->get('tendoo_news');
		$this->data['nbrCat']				=	$this->core->db->get('tendoo_news_category');
		$this->htmlCode	=	$this->core->load->view($this->options['MODULE_DIR'].'views/admin_widget_2',$this->data,TRUE,TRUE);
	}
	public function parseCode()
	{
		return $this->htmlCode;
	}
}
