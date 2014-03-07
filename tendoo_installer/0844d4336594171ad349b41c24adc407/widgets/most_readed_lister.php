<?php
class aflearlep_news_common_widget
{
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
		$LIMIT			=	$setting['WIDGET_MOSTREADED_LIMIT'];
		$this->data['mostViewed']	=	$this->news->getMostViewed(0,$LIMIT);
		$end			=	'<ul>';
		$controller		=	$this->core->tendoo->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['NAMESPACE']);
		foreach($this->data['mostViewed'] as $t)
		{
			$end		.=	'<li><a href="'.$this->core->url->site_url(array($controller[0]['PAGE_CNAME'])).'/read/'.$t['ID'].'/'.$this->core->tendoo->urilizeText($t['TITLE']).'">'.$t['TITLE'].'</a></li>';
		}
		$end			.=	'</ul>';
		$this->theme->defineWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_HEAD'],$end);
	}
}