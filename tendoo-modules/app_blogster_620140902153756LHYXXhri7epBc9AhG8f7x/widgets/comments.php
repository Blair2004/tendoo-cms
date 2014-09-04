<?php
class comments_blogster_common_widget
{
	public function __construct($data)
	{
		/*
			Reçois la zone dans laquelle le widget est appellé, voir clé ['widgets']['requestedZone'] : (LEFT, RIGHT, BOTTOM).
		*/
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=	get_core_vars('active_theme_object');
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['encrypted_dir'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		$this->news		=	new News_smart;
		$setting		=	$this->news->getBlogsterSetting();
		// Dans le cas ou aucune limite n'est fixé nous fixon la limite par défaut à 5 commentaires.
		$LIMIT			=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'] == '' ? 5 : $this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'];
		$this->data['comments']	=	$this->news->getComments(false,0,$LIMIT,'desc');
		$controler		=	$this->instance->tendoo->getControllersAttachedToModule('news');
		
		$end			=	'<ul>';
		foreach($this->data['comments']  as $c)
		{
			$user		=	$this->instance->users_global->getUser($c['AUTEUR']);
			$article	=	$this->news->getSpeNews($c['REF_ART']);
			if($article)
			{
				if($user)
				{
				$end		.= '
				<a href="'.$this->instance->url->site_url(array('account','profile',$user['PSEUDO'])).'">'.$user['PSEUDO'].'</a> dit : 
				"'.word_limiter($c['CONTENT'],10).'" dans <a href="'.$this->instance->url->main_url().'index.php/'.$controler[0]['PAGE_CNAME'].'/lecture/'.$article[0]['URL_TITLE'].'">'.$article[0]['TITLE'].'</a><br><br>';
				}
				else
				{
					$offlineUser	=	$c['OFFLINE_AUTEUR'] != '' ? $c['OFFLINE_AUTEUR'] : 'Utilisateur inconnu';
				$end		.= '
				<a href="#">'.$offlineUser.'</a> dit : 
				"'.word_limiter($c['CONTENT'],10).'" dans <a href="'.$this->instance->url->main_url().'index.php/'.$controler[0]['PAGE_CNAME'].'/lecture/'.$article[0]['URL_TITLE'].'">'.$article[0]['TITLE'].'</a><br><br>';
				}
			}
		}
		$end			.=	'</ul>';
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$widget_title	=	$this->data['currentWidget'][ 'WIDGET_INFO' ][ 'WIDGET_TITLE' ];
			$zone			=	$this->data['widgets']['requestedZone']; // requestedZone
			set_widget( strtolower($zone) , $widget_title , $end , 'text' );
		}
	}
}