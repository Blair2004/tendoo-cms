<?php
declare_module( 'pages_editor' , array( 
	'name'		=>		__( 'Page Editor' ),
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		__( 'This module let your create static page for your website' ),
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'STATIC',
	'compatible'		=>		1.3,
	'version'			=>		0.5,
	'self_url_handle'	=>		TRUE
) ); 
push_module_sql( 'pages_editor' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_pages` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
push_module_action( 'pages_editor' , array(
	'action'				=>	'create_page',
	'action_name'			=>	__( 'Create Pages' ),
	'action_description'	=>	__( 'This permission let you create static pages.' ),
	'mod_namespace'			=>	'pages_editor'
));
push_module_action( 'pages_editor' , array(
	'action'				=>	'delete_page',
	'action_name'			=>	__( 'Delete Pages' ),
	'action_description'	=>	__( 'This permission let you delete pages.' ),
	'mod_namespace'			=>	'pages_editor'
));
push_module_action( 'pages_editor' , array(
	'action'				=>	'edit_pages',
	'action_name'			=>	__( 'Edit Pages' ),
	'action_description'	=>	__( 'This permission let you edit pages.' ),
	'mod_namespace'			=>	'pages_editor'
));