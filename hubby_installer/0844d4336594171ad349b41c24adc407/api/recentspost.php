<?php
class news_recentspost_api
{
	function __construct($data)
	{
		__extends($this);
		
		$this->data		=&	$data;
		if(!class_exists('News_smart'))
		{
			include_once($this->data['MODULE_DIR'].'/library.php');
		}
		$this->lib		=	new News_smart;
	}
	function getDatas($limitation)
	{
		$query		=	$this->lib->getNews(0,$limitation);
		$controler	=	$this->hubby->getControllersAttachedToModule('news');
		$final		=	array();
		foreach($query as $q)
		{
			$category_datas				=	$this->lib->getCat($q['CATEGORY_ID']);
			$user						=	$this->users_global->getUser($q['AUTEUR']);
			$final[]					=	array(
				'LINK'					=>	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'read',$q['ID'],$this->hubby->urilizeText($q['TITLE']))),
				'TITLE'					=>	$q['TITLE'],
				'CONTENT'				=>	$q['CONTENT'],
				'DATE'					=>	$q['DATE'],
				'AUTEUR'				=>	$user['PSEUDO'],
				'THUMB'					=>	$q['IMAGE'],
				'CATEGORY_TITLE'		=>	$category_datas['CATEGORY_NAME'],
				'CATEGORY_LINK'			=>	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'category',$this->hubby->urilizeText($category_datas['CATEGORY_NAME']),$category_datas['ID'])),
				'PRICE_TEXT'			=>	'',
				'PRICE_LINK'			=>	'',
			);
		}
		return $final;
	}
}