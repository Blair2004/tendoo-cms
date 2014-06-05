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
		$controler	=	$this->tendoo->getControllersAttachedToModule('news');
		$final		=	array();
		foreach($query as $q)
		{
			$category_datas				=	$this->lib->getArticlesRelatedCategory($q['ID']);
			$category_datas				=	$this->lib->getArticlesRelatedCategory($q['ID']);
			foreach($category_datas as &$i)
			{
				$i['CATEGORY_LINK']	=	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'categorie',$this->tendoo->urilizeText($i['CATEGORY_NAME']),$i['CATEGORY_ID']));
			}
			$user						=	$this->users_global->getUser($q['AUTEUR']);
			$final[]					=	array(
				'LINK'					=>	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'lecture',$q['ID'],$this->tendoo->urilizeText($q['TITLE']))),
				'TITLE'					=>	$q['TITLE'],
				'CONTENT'				=>	$q['CONTENT'],
				'DATE'					=>	$q['DATE'],
				'AUTEUR'				=>	$user['PSEUDO'],
				'THUMB'					=>	$q['IMAGE'],
				'CATEGORIES'			=>	$category_datas
			);
		}
		return $final;
	}
}