<?php
if(count($getArticles) > 0)
{
	foreach($getArticles as $g)
	{
		$userdata				=	$userUtil->getUser($g['AUTEUR']);
		$date					=	$this->instance->date->time($g['DATE'],TRUE);
		$news_categories		=	array();
		$_keyWords				=	array();
		$categories				=	$news->getArticlesRelatedCategory($g['ID']);
		$gkeywords				=	$news->getNewsKeyWords($g['ID']);
		//looping keywords
		foreach($gkeywords as $kw)
		{
			$_keyWords[]	=	array(
				'TITLE'			=>	$kw['TITLE'],
				'LINK'			=>	$this->instance->url->site_url(array($page[0]['PAGE_CNAME'],'tags',$kw['URL_TITLE'])),
				'DESCRIPTION'	=>	$kw['DESCRIPTION']
			);
		}
		foreach($categories as $category)
		{
			$news_categories[]	=	array(
				'TITLE'			=>	$category['CATEGORY_NAME'],
				'LINK'			=>	$this->instance->url->site_url(array($page[0]['PAGE_CNAME'],'categorie',$category['CATEGORY_URL_TITLE'])),
				'DESCRIPTION'	=>	$category['CATEGORY_DESCRIPTION']
			);
		}
		$userdata		=	$this->instance->users_global->getUser($g['AUTEUR']);
		$date			=	$g['DATE'];
		// $Pcategory		=	$news->retreiveCat($g['CATEGORY_ID']);
		$ttComments		=	$news->countComments($g['ID']);
		set_blog_post( array (
			'title'		=>	$g['TITLE'],
			'content'	=>	$g['CONTENT'],
			'thumb'		=>	$g['THUMB'],
			'full'		=>	$g['IMAGE'],
			'author'	=>	$userdata,
			'link'		=>	$this->instance->url->site_url(array($page[0]['PAGE_CNAME'],'lecture',$g['URL_TITLE'])),
			'timestamp'	=>	$date,
			'categories'=>	$news_categories,
			'keywords'	=>	$_keyWords,
			'comments'	=>	$ttComments
		) );
	}
	$superArray['currentPage']	=	$paginate['current_page'];
	$superArray['totalPage']	=	$paginate['available_pages'];
	$superArray['innerLink']	=	$paginate['pagination'];

	set_pagination( $superArray );
}
$theme->blog_posts();
	