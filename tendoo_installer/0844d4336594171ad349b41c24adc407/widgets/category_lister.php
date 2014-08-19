<?php
class aflecatdi_news_common_widget
{
	private $data;
	public function __construct($data)
	{
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=	get_core_vars('activeTheme_object');
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
		$controller		=	$this->instance->tendoo->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['NAMESPACE']);
		$final_array	=	array();
		foreach($this->data['ttCat'] as $t)
		{
			$final_array[]	=	array(
				'text'		=>	$t['CATEGORY_NAME'].' ('.$t['TOTAL_ARTICLES'].')',
				'link'		=>	$this->instance->url->site_url(array($controller[0]['PAGE_CNAME'])).'/categorie/'.$t['URL_TITLE']
			);
		}
		$widget_title		=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'];
		// For Each Zone
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$widget_title	=	$this->data['currentWidget'][ 'WIDGET_INFO' ][ 'WIDGET_TITLE' ];
			$zone			=	$this->data['widgets']['requestedZone']; // requestedZone
			set_widget( strtolower($zone) , $widget_title , $final_array , 'categories' );
		}
	}
}