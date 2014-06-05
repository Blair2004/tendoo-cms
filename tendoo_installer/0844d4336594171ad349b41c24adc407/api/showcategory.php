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
		$query		=	$this->lib->getCat(0,$limitation);
		$final		=	array();
		foreach($query as $q)
		{
			$final[]					=	array(
				'LINK'					=>	$this->url->main_url().$controler[0]['PAGE_CNAME'].'/categorie/'.$this->tendoo->urilizeText($q['CATEGORY_NAME']).'/'.$q['ID'],
				'TITLE'					=>	$q['CATEGORY_NAME'],
				'DATE'					=>	$q['DATE'],
				'AUTEUR'				=>	'',
				'THUMB'					=>	'',
				'CATEGORY_TITLE'		=>	'',
				'CATEGORY_LINK'			=>	'',
				'PRICE_TEXT'			=>	'',
				'PRICE_LINK'			=>	'',
			);
		}
		return $final;
	}
}