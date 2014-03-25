<?php
class comments_news_common_widget
{
	public function __construct($data)
	{
		/*
			Reçois la zone dans laquelle le widget est appellé, voir clé ['widgets']['requestedZone'] : (LEFT, RIGHT, BOTTOM).
		*/
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
		// Dans le cas ou aucune limite n'est fixé nous fixon la limite par défaut à 5 commentaires.
		$LIMIT			=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'] == '' ? 5 : $this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'];
		$this->data['comments']	=	$this->news->getComments(false,0,$LIMIT,'desc');
		$controler		=	$this->core->tendoo->getControllersAttachedToModule('news');
		
		$end			=	'<ul>';
		foreach($this->data['comments']  as $c)
		{
			$user		=	$this->core->users_global->getUser($c['AUTEUR']);
			$article	=	$this->news->getSpeNews($c['REF_ART']);
			if($user)
			{
			$end		.= '
			<a href="'.$this->core->url->site_url(array('account','profile',$user['PSEUDO'])).'">'.$user['PSEUDO'].'</a> dit : 
			"'.word_limiter($c['CONTENT'],10).'" dans <a href="'.$this->core->url->main_url().'index.php/'.$controler[0]['PAGE_CNAME'].'/read/'.$article[0]['ID'].'/'.$this->core->tendoo->urilizeText($article[0]['TITLE']).'">'.$article[0]['TITLE'].'</a><br><br>';
			}
			else
			{
				$offlineUser	=	$c['OFFLINE_AUTEUR'] != '' ? $c['OFFLINE_AUTEUR'] : 'Utilisateur inconnu';
			$end		.= '
			<a href="#">'.$offlineUser.'</a> dit : 
			"'.word_limiter($c['CONTENT'],10).'" dans <a href="'.$this->core->url->main_url().'index.php/'.$controler[0]['PAGE_CNAME'].'/read/'.$article[0]['ID'].'/'.$this->core->tendoo->urilizeText($article[0]['TITLE']).'">'.$article[0]['TITLE'].'</a><br><br>';
			}
		}
		$end			.=	'</ul>';
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