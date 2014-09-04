<?php
class news_showcategory_api
{
	function __construct($data)
	{
		__extends($this);
		$this->data		=&	$data;
		include_once($this->data['MODULE_DIR'].'/library.php');
		$this->lib		=	new News_smart;
	}
	function getDatas($limitation)
	{
		$controler	=	$this->tendoo->getControllersAttachedToModule('news');
		if($controler)
		{
			$query		=	$this->lib->getCat(0,$limitation);
			$final		=	array();
			foreach($query as $q)
			{
				$final[]					=	array(
					'LINK'					=>	$this->url->main_url().$controler[0]['PAGE_CNAME'].'/categorie/'.$q['URL_TITLE'],
					'TITLE'					=>	$q['CATEGORY_NAME'],
					'DATE'					=>	$q['DATE'],
					'CONTENT'				=>	$q['DESCRIPTION'],
					'AUTEUR'				=>	'',
					'THUMB'					=>	'',
					'CATEGORIES'			=>	array()
				);
			}
		}
		else
		{
			$final[]						=	array(
					'LINK'					=>	'http://tendoo.org/index.php/faq/bind-module-to-page',
					'TITLE'					=>	"Erreur, blogster non exécuté",
					'DATE'					=>	"",
					'CONTENT'				=>	"",
					'AUTEUR'				=>	'',
					'THUMB'					=>	'',
					'CATEGORIES'			=>	array()
				);
		}
		return $final;
	}
}