<?php
class news_featuredpost_api
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
		$query		=	$this->lib->getMostViewed(0,$limitation);
		$controler	=	$this->tendoo->getControllersAttachedToModule('news');
		$final		=	array();
		if($controler)
		{
			foreach($query as $q)
			{
				$category_datas				=	$this->lib->getArticlesRelatedCategory($q['ID']);
				foreach($category_datas as &$i)
				{
					$i['CATEGORY_LINK']	=	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'categorie',$i['CATEGORY_URL_TITLE']));
				}
				$user						=	$this->users_global->getUser($q['AUTEUR']);
				$final[]					=	array(
					'LINK'					=>	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'lecture',$q['URL_TITLE'])),
					'TITLE'					=>	$q['TITLE'],
					'CONTENT'				=>	$q['CONTENT'],
					'DATE'					=>	$q['DATE'],
					'AUTEUR'				=>	$user['PSEUDO'],
					'THUMB'					=>	$q['IMAGE'],
					'CATEGORIES'			=>	$category_datas
				);
			}
		}
		else
		{
			$final[]					=	array(
				'LINK'					=>	'http://tendoo.org/index.php/faq/bind-module-to-page',
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