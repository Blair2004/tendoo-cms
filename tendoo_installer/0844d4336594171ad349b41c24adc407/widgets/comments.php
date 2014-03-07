<?php
class comments_news_common_widget
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
		$LIMIT			=	$setting['WIDGET_COMMENTS_LIMIT'];
		$this->data['comments']	=	$this->news->getComments(false,0,$LIMIT,'desc');
		$end			=	'<ul>';
		foreach($this->data['comments']  as $c)
		{
			$user		=	$this->core->users_global->getUser($c['AUTEUR']);
			$article	=	$this->news->getSpeNews($c['REF_ART']);
			if($user)
			{
			$end		.= '
			<a href="'.$this->core->url->site_url(array('account','profile',$user['PSEUDO'])).'">'.$user['PSEUDO'].'</a> dit : 
			"'.word_limiter($c['CONTENT'],10).'" dans <a href="'.$this->core->url->main_url().'index.php/tendoo@news/read/'.$article[0]['ID'].'/'.$this->core->tendoo->urilizeText($article[0]['TITLE']).'">'.$article[0]['TITLE'].'</a><br><br>';
			}
			else
			{
			$end		.= '
			<a href="#">'.$c['OFFLINE_AUTEUR'].'</a> dit : 
			"'.word_limiter($c['CONTENT'],10).'" dans <a href="'.$this->core->url->main_url().'index.php/tendoo@news/read/'.$article[0]['ID'].'/'.$this->core->tendoo->urilizeText($article[0]['TITLE']).'">'.$article[0]['TITLE'].'</a><br><br>';
			}
		}
		$end			.=	'</ul>';
		$this->theme->defineWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_HEAD'],$end);
	}
}