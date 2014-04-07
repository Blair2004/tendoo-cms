<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.3);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'Tendoo_contents',
	'HUMAN_NAME'	=> 'Librarie multimedia',
	'AUTHOR'		=> 'Tendoo Group',
	'DESCRIPTION'	=> 'G&eacute;rer vos contenus de type image, video ou musique.',
	'TYPE'			=> 'BYPAGE',
	'TENDOO_VERS'	=> 0.94,
	'HAS_ICON'		=>	1
));
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'Tendoo_contents` (
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
	'action'				=>	'Tendoo_contents_upload',
	'action_name'			=>	'Envoyer des fichiers',
	'action_description'	=>	'Cette action permet aux utilisateurs de pouvoir envoyer des fichiers tels que des image, des vid&eacute;os ou des photos en ligne.',
	'mod_namespace'			=>	'Tendoo_contents'
));
$this->appAction(array(
	'action'				=>	'Tendoo_contents_delete',
	'action_name'			=>	'Supprimer un contenu',
	'action_description'	=>	'Cette action permet de supprimer des contenus.',
	'mod_namespace'			=>	'Tendoo_contents'
));