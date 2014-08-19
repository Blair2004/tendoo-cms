<?php
class news_recentspost_api
{
	function __construct($module)
	{
		__extends($this);
		$this->module	=	$module;
		if(!class_exists('News_smart'))
		{
			include_once($this->module['URI_PATH'].'/library.php');
		}
		$this->lib		=	new News_smart;
	}
	function getDatas($limitation)
	{
		$query		=	$this->lib->getNews(0,$limitation);
		$controler	=	$this->tendoo->getControllersAttachedToModule('news');
		$final		=	array();
		if($controler)
		{
			foreach($query as $q)
			{
				$category_datas				=	$this->lib->getArticlesRelatedCategory($q['ID']);
				$category_datas				=	$this->lib->getArticlesRelatedCategory($q['ID']);
				foreach($category_datas as &$i)
				{
					$i['CATEGORY_LINK']	=	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'categorie',$i['CATEGORY_URL_TITLE']));
				}
				$user						=	$this->users_global->getUser($q['AUTEUR']);
				$final[]					=	array(
					'link'					=>	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'lecture',$q['URL_TITLE'])),
					'title'					=>	$q['TITLE'],
					'content'				=>	$q['CONTENT'],
					'date'					=>	$q['DATE'],
					'author'				=>	$user,
					'thumb'					=>	$q['IMAGE'],
					'categories'			=>	$category_datas
				);
			}
		}
		else
		{
			$final[]					=	array(
				'LINK'					=>	'http://tendoo.org/index.php/apprendre/astuces/comment-attacher-un-module',
				'TITLE'					=>	'Blogster non affecté à une page',
				'CONTENT'				=>	'Le module Blogster n\'est pas attaché à une page',
				'DATE'					=>	'',
				'AUTEUR'				=>	'',
				'THUMB'					=>	img_url('Hub_back.png'),
				'CATEGORIES'			=>	array()
			);
		}
		return $final;
	}
}