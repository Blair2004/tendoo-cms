<?php
class tags_news_common_widget
{
	public function __construct($data)
	{
		/*
			Reçois la zone dans laquelle le widget est appellé, voir clé ['widgets']['requestedZone'] : (LEFT, RIGHT, BOTTOM).
		*/
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=&	$this->data['theme'];
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['ENCRYPTED_DIR'];
		
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
		
		$controler		=	$this->instance->tendoo->getControllersAttachedToModule('news');
		
		$tags			=	'<ul>';
		foreach($this->data['getTotalKeyWords']  as $gtk)
		{
			$tags		.=	'<a href="'.$this->instance->url->site_url(array($controler[0]['PAGE_CNAME'],'tags',$gtk['URL_TITLE'])).'">'.$gtk['TITLE'].'</a> ';
		}
		$tags			.=	'</ul>';
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$rZone		=&	$this->data['widgets']['requestedZone']; // requestedZone
			if($rZone == 'LEFT')
			{
				$this->theme->defineLeftWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$tags);
			}
			elseif($rZone == 'RIGHT')
			{
				$this->theme->defineRightWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$tags);
			}
			else
			{
				$this->theme->defineBottomWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$tags);
			}
		}
	}
}