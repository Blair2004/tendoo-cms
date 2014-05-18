	<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.4);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'news',
	'HUMAN_NAME'	=> 'Blogster - Le gestionnaire d\'articles',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Créez, modifiez et publiez des articles pour votre blog.',
	'TYPE'			=> 'BYPAGE',
	'HAS_WIDGET'	=>	1,
	'HAS_MENU'		=>	1,
	'HAS_API'	=>	1,
	'HAS_ICON'		=>	1,
	'TENDOO_VERS'	=> 0.94
));
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `REF_ART` int(11) NOT NULL,
  `SHOW` int(11) NOT NULL,
  `CONTENT` text NOT NULL,
  `DATE` datetime NOT NULL,
  `AUTEUR` int(11) NOT NULL,
  `OFFLINE_AUTEUR` varchar(200) NOT NULL,
  `OFFLINE_AUTEUR_EMAIL` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_ID` int(11) NOT NULL,
  `TITLE` varchar(200) NOT NULL,
  `CONTENT` text NOT NULL,
  `DATE` datetime NOT NULL,
  `AUTEUR` int(11) NOT NULL,
  `ETAT` varchar(5) NOT NULL,
  `IMAGE` varchar(200) NOT NULL,
  `THUMB` varchar(200) NOT NULL,
  `VIEWED` int(11) NOT NULL,
  `SCHEDULED` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_keywords` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NEWS_ID` int(11) NOT NULL,
  `KEYWORDS` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_setting` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EVERYONEPOST` int(11) NOT NULL,
  `APPROVEBEFOREPOST` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(100) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `DATE` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
$this->appAction(array(
	'action'				=>	'publish_news',
	'action_name'			=>	'Publier les articles',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de publier des articles',
	'mod_namespace'			=>	'news'
));
$this->appAction(array(
	'action'				=>	'delete_news',
	'action_name'			=>	'Supprimer les articles',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de supprimer des articles',
	'mod_namespace'			=>	'news'
));
$this->appAction(array(
	'action'				=>	'edit_news',
	'action_name'			=>	'Modifier les articles',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de modifier des articles',
	'mod_namespace'			=>	'news'
));
$this->appAction(array(
	'action'				=>	'category_manage',
	'action_name'			=>	'Gestion des cat&eacute;gories',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de g&eacute;rer les cat&eacute;gories',
	'mod_namespace'			=>	'news'
));
$this->appAction(array(
	'action'				=>	'blogster_setting',
	'action_name'			=>	'Gestion des param&ecirc;tres',
	'action_description'	=>	'Cette action permet de modifier les param&ectres avanc&eacute;s.',
	'mod_namespace'			=>	'news'
));
$this->appAction(array(
	'action'				=>	'blogster_manage_comments',
	'action_name'			=>	'Gestion des commentaires',
	'action_description'	=>	'Cette action permet de g&eacute;rer les commentaires.',
	'mod_namespace'			=>	'news'
));