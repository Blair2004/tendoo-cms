<?php
class blogster_featuredpost_api
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
		$controler	=	$this->tendoo->getControllersAttachedToModule('blogster');
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
					'link'					=>	$this->url->site_url(array($controler[0]['PAGE_CNAME'],'lecture',$q['URL_TITLE'])),
					'title'					=>	$q['TITLE'],
					'content'				=>	$q['CONTENT'],
					'date'					=>	$q['DATE'],
					'auteur'				=>	$user['PSEUDO'],
					'thumb'					=>	$q['IMAGE'],
					'categories'			=>	$category_datas
				);
			}
		}
		else
		{
			$final[]					=	array(
				'LINK'					=>	'http://tendoo.org/index.php/get-involved/astuces/comment-attacher-un-module',
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