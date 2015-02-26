<?php
declare_module( 'tendoo_contents' , array( 
	'name'		=>		'Media Library',
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		'Media Manager for Tendoo CMS.',
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'APP',
	'compatible'		=>		1.4,
	'version'			=>		0.4
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
	'action'				=>	'delete_media',
	'action_name'			=>	'Delete Media File',
	'action_description'	=>	'This let you delete media file.',
	'mod_namespace'			=>	'tendoo_contents'
));
push_module_action( 'tendoo_contents' , array(
	'action'				=>	'upload_media',
	'action_name'			=>	'Send Files',
	'action_description'	=>	'This let you upload media file.',
	'mod_namespace'			=>	'tendoo_contents'
));