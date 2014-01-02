<?php
class aflecatdi_news_common_widget
{
	private $data;
	public function __construct($data)
	{
		$this->core		=	Controller::instance();
		$this->data		=&	$data;
		$this->theme	=&	$this->data['theme'];
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['ENCRYPTED_DIR'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		$this->news		=	new News_smart;
		$setting		=	$this->news->getBlogsterSetting();
		$LIMITCAT		=	$setting['WIDGET_CATEGORY_LIMIT'];
		
		$this->data['ttCat']	=	$this->news->getCat(0,$LIMITCAT);
		$end			=	'<ul>';
		$controller		=	$this->core->hubby->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['NAMESPACE']);
		foreach($this->data['ttCat'] as $t)
		{
			$ttArtThere	=	count($this->news->getArtFromCat($t['ID']));
			$end		.=	'<li><a href="'.$this->core->url->site_url(array($controller[0]['PAGE_CNAME'])).'/category/'.$this->core->hubby->urilizeText($t['CATEGORY_NAME']).'/'.$t['ID'].'">'.$t['CATEGORY_NAME'].' ('.$ttArtThere.')</a></li>';
		}
		$end			.=	'</ul>';
		$this->theme->defineWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_HEAD'],$end);
	}
}