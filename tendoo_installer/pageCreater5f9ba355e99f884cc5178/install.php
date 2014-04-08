<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.3);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'Pages_editor',
	'HUMAN_NAME'	=> 'Editeur de page HTML',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Créez une page HTML.',
	'TYPE'			=> 'BYPAGE',
	'TENDOO_VERS'	=> 0.94,
	'HAS_ICON'		=>	1
));
$this->appAction(array(
	'action'				=>	'create_page',
	'action_name'			=>	'Cr&eacute;er des pages',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de cr&eacute;er des pages.',
	'mod_namespace'			=>	$this->appTableField['NAMESPACE']
));
$this->appAction(array(
	'action'				=>	'delete_page',
	'action_name'			=>	'Supprimer des pages',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de supprimer des pages',
	'mod_namespace'			=>	$this->appTableField['NAMESPACE']
));
$this->appAction(array(
	'action'				=>	'edit_pages',
	'action_name'			=>	'Modifier les pages cr&eacute;e',
	'action_description'	=>	'Action qui permet &agrave; tout utilisateur de modifier des articles',
	'mod_namespace'			=>	$this->appTableField['NAMESPACE']
));
$this->appAction(array(
	'action'				=>	'attachPageTo',
	'action_name'			=>	'Liée une page',
	'action_description'	=>	'Cette action permet de lier une page à un contenu HTML cr&eacute;e.',
	'mod_namespace'			=>	$this->appTableField['NAMESPACE']
));
$this->appSql(	
	'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_refTopage` (
	  `ID` int(11) NOT NULL AUTO_INCREMENT,
	  `PAGE_CONTROLEUR` varchar(200) NOT NULL,
	  `PAGE_HTML` varchar(200) NOT NULL,
	  `DATE` varchar(200) NOT NULL,
	  `AUTEUR` int(11) NOT NULL,
	  PRIMARY KEY (`ID`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(200) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `FILE_NAME` text NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `AUTHOR` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
