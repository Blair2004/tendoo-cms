<?php
class aflearlep_blogster_common_widget
{
	public function __construct($data)
	{
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=	get_core_vars('active_theme_object');
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['encrypted_dir'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		// var_dump($this->data['currentWidget']);
		$this->news		=	new News_smart;
		$setting		=	$this->news->getBlogsterSetting();
		// var_dump($this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS']);
		$LIMIT			=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'];
		
		$this->data['mostViewed']	=	$this->news->getMostViewed(0,$LIMIT);
		$end			=	'<ul>';
		$controller		=	$this->instance->tendoo->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['namespace']);
		// var_dump( $this->data['currentWidget']['WIDGET_MODULE'] );
		// var_dump( $controller );
		foreach($this->data['mostViewed'] as $t)
		{
			$end		.=	'<li><a href="'.$this->instance->url->site_url(array($controller[0]['PAGE_CNAME'])).'/lecture/'.$t['URL_TITLE'].'">'.$t['TITLE'].'</a></li>';
		}
		$end			.=	'</ul>';
		// For Zones
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$widget_title	=	$this->data['currentWidget'][ 'WIDGET_INFO' ][ 'WIDGET_TITLE' ];
			$zone			=	$this->data['widgets']['requestedZone']; // requestedZone
			set_widget( strtolower($zone) , $widget_title , $end , 'text' );
		}
		
	}
}