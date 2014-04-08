<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.2);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'tendoo_contact_handler',
	'HUMAN_NAME'	=> 'Gestionnaire de contact',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Recevez les messages envoy&eacute;s par les utilisateurs via l\'interface de contact.',
	'TYPE'			=> 'BYPAGE',
	'TENDOO_VERS'	=> 0.94,
	'HAS_ICON'		=>	1
));
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_contact_handler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_NAME` varchar(200) NOT NULL,
  `USER_CONTENT` text NOT NULL,
  `USER_MAIL` varchar(200) NOT NULL,
  `USER_PHONE` varchar(200) NOT NULL,
  `USER_COUNTRY` text NOT NULL,
  `USER_CITY` text NOT NULL,
  `USER_WEBSITE` varchar(200),
  `USER_ID` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `STATE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_contact_handler_option` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SHOW_NAME` int(11) NOT NULL,
  `SHOW_MAIL` int(11) NOT NULL,
  `SHOW_PHONE` int(11) NOT NULL,
  `SHOW_COUNTRY` int(11) NOT NULL,
  `SHOW_CITY` int(11) NOT NULL,
  `SHOW_WEBSITE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_contact_fields` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTACT_TEXT` varchar(200) NOT NULL,
  `CONTACT_TYPE` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_contact_aboutUs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FIELD_CONTENT` text,
  `AUTHOR` int(11) NOT NULL,
  `DATE` datetime,
  PRIMARY KEY (`ID`)
);');
$this->appAction(array(
	'action'				=>	'tendoo_contact_handler',
	'action_name'			=>	'Gestionnaire de contact',
	'action_description'	=>	'Cette action permet de g&eacute;rer tous les contacts.',
	'mod_namespace'			=>	'tendoo_contact_handler'
));