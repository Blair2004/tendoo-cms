<?php

		if(count($getNews) > 0)
		{
			foreach($getNews as $g)
			{
				$news_categories		=	array();
				$_keyWords				=	array();
				$categories				=	$news->getArticlesRelatedCategory($g['ID']);
				$gkeywords				=	$news->getNewsKeyWords($g['ID']);
				//looping keywords
				foreach($gkeywords as $kw)
				{
					$_keyWords[]	=	array(
						'TITLE'			=>	$kw['TITLE'],
						'LINK'			=>	$this->core->url->site_url(array($page[0]['PAGE_CNAME'],'tags',$kw['TITLE'],1)),
						'DESCRIPTION'	=>	$kw['DESCRIPTION']
					);
				}
				foreach($categories as $category)
				{
					$news_categories[]	=	array(
						'TITLE'			=>	$category['CATEGORY_NAME'],
						'LINK'			=>	$this->core->url->site_url(array($page[0]['PAGE_CNAME'],'categorie',$this->core->tendoo->urilizeText($category['CATEGORY_NAME'],'-'),1)),
						'DESCRIPTION'	=>	$category['CATEGORY_DESCRIPTION']
					);
				}
				$userdata		=	$this->core->users_global->getUser($g['AUTEUR']);
				$date			=	$g['DATE'];
				// $Pcategory		=	$news->retreiveCat($g['CATEGORY_ID']);
				$ttComments		=	$news->countComments($g['ID']);
				$theme->defineBlogPost(
					$title			=	$g['TITLE'],
					$content		=	$g['CONTENT'],
					$thumb			=	$g['THUMB'],
					$full			=	$g['IMAGE'],
					$author			=	$userdata,
					$link			=	$this->core->url->site_url(array($page[0]['PAGE_CNAME'],'lecture',$g['ID'],$this->core->tendoo->urilizeText($g['TITLE']))),
					$timestamp		=	$date,
					$news_categories,
					$comments		=	$ttComments,
					$keywords		=	$_keyWords
				);
			}
			$superArray['currentPage']	=	$currentPage;
			$superArray['totalPage']	=	$ttNews;
			$superArray['innerLink']	=	$pagination[4];
	
			$theme->set_pagination_datas($superArray);
			$theme->parseBlog();
		}
		else
		{
			$theme->defineBlogPost	=	FALSE;
			$theme->parseBlog();
		}
	