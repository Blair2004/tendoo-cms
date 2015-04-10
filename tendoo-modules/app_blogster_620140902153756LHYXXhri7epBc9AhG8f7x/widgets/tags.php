<?php
class tags_blogster_common_widget
{
	public function __construct($data)
	{
		/*
			Reçois la zone dans laquelle le widget est appellé, voir clé ['widgets']['requestedZone'] : (LEFT, RIGHT, BOTTOM).
		*/
		$this->instance		=	get_instance();
		$this->data		=	$data;
		$this->theme	=	get_core_vars('active_theme_object');
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['encrypted_dir'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		$this->news		=	new News_smart;
		// Dans le cas ou aucune limite n'est fixé nous fixon la limite par défaut à 5 commentaires.
		$LIMIT			=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'] == '' ? 5 : $this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'];
		// Utilisation de la limite fixée
		$this->data['getTotalKeyWords']	=	$this->news->getAllPopularKeyWords($LIMIT);
		// Recupération du contrôleur attaché au module.
		
		$controler		=	$this->instance->controller->getControllersAttachedToModule('blogster');
		$tags			=	array();
		foreach($this->data['getTotalKeyWords']  as $gtk)
		{
			$tags[]		=	array(
				'link'	=>	$this->instance->url->site_url(array($controler[0]['PAGE_CNAME'],'tags',$gtk['URL_TITLE'])),
				'text'	=>	$gtk['TITLE']
			);
		}
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$widget_title	=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'];
			$rZone			=	$this->data['widgets']['requestedZone']; // requestedZone
			set_widget( strtolower($rZone) , $widget_title , $tags , 'tags' );
		}
	}
}