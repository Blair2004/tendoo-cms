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
		$controller		=	$this->core->tendoo->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['NAMESPACE']);
		foreach($this->data['ttCat'] as $t)
		{
			$ttArtThere	=	count($this->news->getArtFromCat($t['ID']));
			$end		.=	'<li><a href="'.$this->core->url->site_url(array($controller[0]['PAGE_CNAME'])).'/category/'.$this->core->tendoo->urilizeText($t['CATEGORY_NAME']).'/'.$t['ID'].'">'.$t['CATEGORY_NAME'].' ('.$ttArtThere.')</a></li>';
		}
		$end			.=	'</ul>';
		// For Each Zone
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$rZone		=&	$this->data['widgets']['requestedZone']; // requestedZone
			if($rZone == 'LEFT')
			{
				$this->theme->defineLeftWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$end);
			}
			elseif($rZone == 'RIGHT')
			{
				$this->theme->defineRightWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$end);
			}
			else
			{
				$this->theme->defineBottomWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$end);
			}
		}
	}
}