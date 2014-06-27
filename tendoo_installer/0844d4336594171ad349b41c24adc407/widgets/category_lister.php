<?php
class aflecatdi_news_common_widget
{
	private $data;
	public function __construct($data)
	{
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=&	$this->data['theme'];
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['ENCRYPTED_DIR'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		$this->news		=	new News_smart;
		$setting		=	$this->news->getBlogsterSetting();
		//
		if(!(bool)$this->data['currentWidget']['WIDGET_INFO']['IS_CODE'])
		{
			$LIMIT			=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'] == '' ? 5 : $this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'];
		}
		else
		{
			
		}
		
		//eval($LIMIT)
		$this->data['ttCat']	=	$this->news->getCatForWidgets(0,$LIMIT);
		
		$end			=	'<ul>';
		$controller		=	$this->instance->tendoo->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['NAMESPACE']);
		foreach($this->data['ttCat'] as $t)
		{
			$end		.=	'<li><a href="'.$this->instance->url->site_url(array($controller[0]['PAGE_CNAME'])).'/categorie/'.$t['URL_TITLE'].'">'.$t['CATEGORY_NAME'].' ('.$t['TOTAL_ARTICLES'].')</a></li>';
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