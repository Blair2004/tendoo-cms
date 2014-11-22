<?php
declare_module( 'tendoo_contents' , array( 
	'name'		=>		'Gestionnaire des médias',
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		'Ce module vous permet de gérer votre bibliothèque de médias.',
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'APP',
	'compatible'		=>		1.3,
	'version'			=>		0.6
) ); 
push_module_sql( 'tendoo_contents' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_contents` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(200) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `FILE_NAME` text NOT NULL,
  `FILE_TYPE` varchar(200) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `AUTHOR` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
push_module_action( 'tendoo_contents' , array(
	'action'				=>	'tendoo_contents_delete',
	'action_name'			=>	'Supprimer un contenu',
	'action_description'	=>	'Cette action permet de supprimer des contenus.',
	'mod_namespace'			=>	'tendoo_contents'
));
push_module_action( 'tendoo_contents' , array(
	'action'				=>	'tendoo_contents_upload',
	'action_name'			=>	'Envoyer des fichiers',
	'action_description'	=>	'Cette action permet aux utilisateurs de pouvoir envoyer des fichiers tels que des image, des vid&eacute;os ou des photos en ligne.',
	'mod_namespace'			=>	'tendoo_contents'
));