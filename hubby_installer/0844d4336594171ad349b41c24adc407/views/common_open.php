<?php
// ARTICLE SECTION
$userdata				=	$userUtil->getUser($GetNews[0]['AUTEUR']);
$date					=	$GetNews[0]['DATE'];
$Ccategory				=	$news->retreiveCat($GetNews[0]['CATEGORY_ID']);
// COMMENT SECTION
$theme->defineSingleBlogPost(
	$title				=	$GetNews[0]['TITLE'],
	$content			=	$GetNews[0]['CONTENT'],
	$thumb				=	$GetNews[0]['IMAGE'],
	$full				=	$GetNews[0]['IMAGE'],
	$author				=	$userdata['PSEUDO'],
	$timestamp			=	$GetNews[0]['DATE'],
	$category			=	$Ccategory['name'],
	$categoryLink		=	$this->core->url->site_url($Ccategory['url'])
);
$theme->defineTT_SBP_comments($news->countComments($GetNews[0]['ID']));
// intégration des commentaires
if(count($Comments) >0)
{
	foreach($Comments as $c)
	{
		$userdata		=	$this->core->users_global->getUser($c['AUTEUR']);
		$theme->defineSBP_comments(
			$author			=	$userdata == FALSE ? $c['OFFLINE_AUTEUR'] : $userdata['PSEUDO'],
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
			'text'			=>	'Entrer votre mail',
			'name'			=>	'mail',
			'value'			=>	$email,
			'subtype'		=>	'text',
			'type'			=>	'input'
		));
		$theme->defineForm(array(
			'text'			=>	'Entrer votre commentaire',
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
			'text'			=>	'Entrer votre mail',
			'name'			=>	'mail',
			'value'			=>	$email,
			'subtype'		=>	'text',
			'type'			=>	'input'
		));
		$theme->defineForm(array(
			'text'			=>	'Entrer votre commentaire',
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
	