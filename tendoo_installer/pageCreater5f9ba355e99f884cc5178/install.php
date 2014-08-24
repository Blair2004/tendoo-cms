<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.4);
$this->appTendooVers(1.2);
$this->appTableField(array(
	'NAMESPACE'		=> 'pages_editor',
	'HUMAN_NAME'	=> 'Editeur de page HTML',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Créez une page HTML.',
	'TYPE'			=> 'BYPAGE',
	'TENDOO_VERS'	=> 1.2,
	'HAS_ICON'		=>	1,
	'HAS_WIDGET'	=>	1,
	'HANDLE'		=>	'STATIC'
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
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) NOT NULL,
  `FILE_NAME` varchar(255),
  `TITLE_URL` varchar(255),
  `DESCRIPTION` text,
  `CONTROLLER_REF_CNAME` varchar(255) NOT NULL,
  `PAGE_PARENT` int(11) NOT NULL,
  `DATE` datetime NOT NULL,
  `EDITION_DATE` datetime NOT NULL,
  `STATUS` varchar(255) NOT NULL,
  `AUTHOR` int(11) NOT NULL, 
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
