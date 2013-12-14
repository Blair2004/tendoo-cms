<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.1);
$this->appHubbyVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'Pages_editor',
	'HUMAN_NAME'	=> 'Editeur de page HTML',
	'AUTHOR'		=> 'Hubby Group',
	'DESCRIPTION'	=> 'Créer une page HTML.',
	'TYPE'			=> 'BYPAGE',
	'HUBBY_VERS'	=> 0.9
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
'CREATE TABLE IF NOT EXISTS `hubby_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(200) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `FILE_NAME` text NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `AUTHOR` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
