<?php
// ARTICLE SECTION
$userdata				=	$this->core->users_global->getUser($GetNews[0]['AUTEUR']);
$date					=	$GetNews[0]['DATE'];
$Ccategory				=	$news->getArticlesRelatedCategory($GetNews[0]['ID']);
// Recupération des catégories
$categories				=	array();
if($Ccategory)
{
	foreach($Ccategory as $category)
	{
		$categories[]		=	array(
			'TITLE'			=>	$category['CATEGORY_NAME'],
			'DESCRIPTION'	=>	$category['CATEGORY_DESCRIPTION'],
			'LINK'			=>	$this->core->url->site_url(array($page[0]['PAGE_CNAME'],'categorie',$this->core->tendoo->urilizeText($category['CATEGORY_NAME'],'-'),1))
		);
	}
}
// COMMENT SECTIONo
// Preparing Keywords
$keywords	=	array();
foreach($getKeywords as $key)
{
	$keywords[]			=	array(
		'TITLE'			=>	$key['TITLE'],
		'LINK'			=>	$this->core->url->site_url(array($page[0]['PAGE_CNAME'],'tags',$key['TITLE'])),
		'DESCRIPTION'	=>	$key['DESCRIPTION']
	);
}
$theme->defineSingleBlogPost(
	$title				=	$GetNews[0]['TITLE'],
	$content			=	$GetNews[0]['CONTENT'],
	$thumb				=	$GetNews[0]['IMAGE'],
	$full				=	$GetNews[0]['IMAGE'],
	$author				=	$userdata,
	$timestamp			=	$GetNews[0]['DATE'],
	$categories,
	$keywords
);
$theme->defineTT_SBP_comments($news->countComments($GetNews[0]['ID']));
// intégration des commentaires
if(count($Comments) >0)
{
	foreach($Comments as $c)
	{
		$userdata		=	$this->core->users_global->getUser($c['AUTEUR']);
		$final_user		=	$userdata;
		if(!$userdata)
		{
			$final_user	=	array(
				'PSEUDO'	=>	$c['OFFLINE_AUTEUR'],
				'ID'		=>	0,
				'EMAIL'		=>	'',
			);
		}
		$theme->defineSBP_comments(
			$author			=	$final_user,
			$authorLink		=	'#',
			$content		=	$c['CONTENT'],
			$timestamp		=	$c['DATE']
		);
	}
}
// Pagination
$theme->set_pagination_datas(array(
	'innerLink'			=>		$pagination[4],
	'currentPage'		=>		$currentPage
));
// Intégration du formulaire de réponse.
if($this->core->users_global->isConnected())
{
	$pseudo	=	$this->core->users_global->current('PSEUDO');
	$email	=	$this->core->users_global->current('EMAIL');
}
else
{
	$pseudo	=	'';
	$email	=	'';
}
// REPLY FORM
if($setting['EVERYONEPOST'] == 0)
{
	if($userUtil->isConnected())
	{
		$theme->defineForm(array(
			'text'			=>	'Pseudo',
			'name'			=>	'pseudo',
			'value'			=>	$pseudo,
			'subtype'		=>	'text',
			'type'			=>	'input'
		));
		$theme->defineForm(array(
			'text'			=>	'Entrez votre email',
			'name'			=>	'mail',
			'value'			=>	$email,
			'subtype'		=>	'text',
			'type'			=>	'input'
		));
		$theme->defineForm(array(
			'text'			=>	'Entrez votre commentaire',
			'name'			=>	'content',
			'subtype'		=>	'text',
			'type'			=>	'textarea'
		));
		$theme->defineForm(array(
			'subtype'		=>	'submit',
			'value'			=>	'Poster',
			'type'			=>	'input'
		));
	}
	else
	{
		$core->notice->push_notice(notice('connectToComment'));
	}
}
else
{
	
		$theme->defineForm(array(
			'text'			=>	'Pseudo',
			'name'			=>	'pseudo',
			'value'			=>	$pseudo,
			'subtype'		=>	'text',
			'type'			=>	'input'
		));
		$theme->defineForm(array(
			'text'			=>	'Entrez votre email',
			'name'			=>	'mail',
			'value'			=>	$email,
			'subtype'		=>	'text',
			'type'			=>	'input'
		));
		$theme->defineForm(array(
			'text'			=>	'Entrez votre commentaire',
			'name'			=>	'content',
			'subtype'		=>	'text',
			'type'			=>	'textarea'
		));
		$theme->defineForm(array(
			'subtype'		=>	'submit',
			'value'			=>	'Poster',
			'type'			=>	'input'
		));
	
}		
// Affichage du single article
$theme->parseBlog();
	