<?php

		if(count($getNews) > 0)
		{
			foreach($getNews as $g)
			{
				$userdata		=	$this->core->users_global->getUser($g['AUTEUR']);
				$date			=	$g['DATE'];
				$Pcategory		=	$news->retreiveCat($g['CATEGORY_ID']);
				$theme->defineBlogPost(
					$title			=	$g['TITLE'],
					$content		=	$g['CONTENT'],
					$thumb			=	$g['THUMB'],
					$full			=	$g['IMAGE'],
					$author			=	$userdata,
					$link			=	$this->core->url->site_url(array($page[0]['PAGE_CNAME'],'read',$g['ID'],$this->core->tendoo->urilizeText($g['TITLE']))),
					$timestamp		=	$date,
					$category		=	$Pcategory['name'],
					$categoryLink	=	$Pcategory['url']
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
	