<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.1);
$this->appHubbyVers(0.93);
$this->appTableField(array(
	'NAMESPACE'		=> 'hubby_contents',
	'HUMAN_NAME'	=> 'Gestionnaire de contenu',
	'AUTHOR'		=> 'Hubby Group',
	'DESCRIPTION'	=> 'Gerer vos contenus de type image, video ou musique.',
	'TYPE'			=> 'BYPAGE',
	'HUBBY_VERS'	=> 0.93
));
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `hubby_contents` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(200) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `FILE_NAME` text NOT NULL,
  `FILE_TYPE` varchar(200) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `AUTHOR` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
$this->appAction(array(
	'action'				=>	'hubby_contents_upload',
	'action_name'			=>	'Envoyer des fichiers',
	'action_description'	=>	'Cette action permet aux utilisateurs de pouvoir envoyer des fichiers tels que des image, des vid&eacute;os ou des photos en ligne.',
	'mod_namespace'			=>	'hubby_contents'
));
$this->appAction(array(
	'action'				=>	'hubby_contents_delete',
	'action_name'			=>	'Supprimer un contenu',
	'action_description'	=>	'Cette action permet de supprimer des contenus.',
	'mod_namespace'			=>	'hubby_contents'
));