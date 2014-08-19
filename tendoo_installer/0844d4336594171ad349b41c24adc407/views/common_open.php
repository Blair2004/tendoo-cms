<?php
// ARTICLE SECTION
$userdata				=	get_user($GetNews[0]['AUTEUR'],'as_id');
$date					=	$GetNews[0]['DATE'];
$Ccategory				=	$news->getArticlesRelatedCategory($GetNews[0]['ID']);
$getKeywords			=	$news->getNewsKeyWords($GetNews[0]['ID']);
// Recupération des catégories
$categories				=	array();
if($Ccategory)
{
	foreach($Ccategory as $category)
	{
		$categories[]		=	array(
			'TITLE'			=>	$category['CATEGORY_NAME'],
			'DESCRIPTION'	=>	$category['CATEGORY_DESCRIPTION'],
			'LINK'			=>	$this->instance->url->site_url(array($page[0]['PAGE_CNAME'],'categorie',$category['CATEGORY_URL_TITLE']))
		);
	}
}
// Preparing Keywords
$keywords	=	array();
foreach($getKeywords as $key)
{
	$keywords[]			=	array(
		'TITLE'			=>	$key['TITLE'],
		'LINK'			=>	$this->instance->url->site_url(array($page[0]['PAGE_CNAME'],'tags',$key['URL_TITLE'])),
		'DESCRIPTION'	=>	$key['DESCRIPTION']
	);
}
set_blog_single( array (
	'title'			=>		$GetNews[0]['TITLE'],
	'content'		=>		$GetNews[0]['CONTENT'],
	'thumb'			=>		$GetNews[0]['IMAGE'],
	'full'			=>		$GetNews[0]['IMAGE'],
	'author'		=>		$userdata,
	'timestamp'		=>		$GetNews[0]['DATE'],
	'categories'	=>		$categories,
	'keywords'		=>		$keywords,
	'comments'		=>		$news->countComments($GetNews[0]['ID'])
) );
// intégration des commentaires
if(count($Comments) >0)
{
	foreach($Comments as $c)
	{
		$userdata		=	get_user( $c['AUTEUR'] , 'as_id' );
		$final_user		=	$userdata;
		
		if(!$userdata)
		{
			$final_user	=	array(
				'PSEUDO'	=>	$c['OFFLINE_AUTEUR'],
				'ID'		=>	0,
				'EMAIL'		=>	'',
			);
			$author_link	=	'#';
		}
		else
		{
			$author_link	=	get_instance()->url->site_url(array('account','profile',$userdata['PSEUDO']));
		}
		set_blog_comment( array (
			'author'		=>	$final_user,
			'authorlink'	=>	$author_link,
			'content'		=>	$c['CONTENT'],
			'timestamp'		=>	$c['DATE']
		) );
	}
}
set_pagination( array(
	'innerLink'			=>		$pagination[4],
	'currentPage'		=>		$currentPage
) );
// Intégration du formulaire de réponse.
if($this->instance->users_global->isConnected())
{
	$pseudo	=	$this->instance->users_global->current('PSEUDO');
	$email	=	$this->instance->users_global->current('EMAIL');
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
		set_form( 'blog_single_reply_form' , array(
			'type'			=>	'text',
			'name'			=>	'pseudo',
			'value'			=>	$pseudo,
			'placeholder'	=>	'Entrez votre pseudo',
			'text'			=>	'Entrez votre pseudo'
		));
		set_form( 'blog_single_reply_form' , array(
			'type'			=>	'text',
			'name'			=>	'mail',
			'value'			=>	$email,
			'placeholder'	=>	'Entrez votre email',
			'text'			=>	'Entrez votre email'
		));
		set_form( 'blog_single_reply_form' , array(
			'type'			=>	'textarea',
			'name'			=>	'content',
			'placeholder'	=>	'Entrez votre commentaire',
			'text'			=>	'Entrez votre commentaire'
		));
		set_form( 'blog_single_reply_form' , array(
			'type'			=>	'submit',
			'value'			=>	'Publier le commentaire'
		));
	}
	else
	{
		get_instance()->notice->push_notice(fetch_error('connectToComment'));
	}
}
else
{
	set_form( 'blog_single_reply_form' , array(
		'type'			=>	'text',
		'name'			=>	'pseudo',
		'value'			=>	$pseudo,
		'placeholder'	=>	'Entrez votre pseudo',
		'text'			=>	'Entrez votre pseudo'
	));
	set_form( 'blog_single_reply_form' , array(
		'type'			=>	'text',
		'name'			=>	'mail',
		'value'			=>	$email,
		'placeholder'	=>	'Entrez votre email',
		'text'			=>	'Entrez votre email'
	));
	set_form( 'blog_single_reply_form' , array(
		'type'			=>	'textarea',
		'name'			=>	'content',
		'placeholder'	=>	'Entrez votre commentaire',
		'text'			=>	'Entrez votre commentaire'
	));
	set_form( 'blog_single_reply_form' , array(
		'type'			=>	'submit',
		'value'			=>	'Publier le commentaire'
	));
	
}		
// Affichage du single article
$theme->blog_single();
	