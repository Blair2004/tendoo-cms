<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.3);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'tendoo_widget_administrator',
	'HUMAN_NAME'	=> 'Gestionnaire de widgets',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Permet de créer et d\'administrer des widgets',
	'TYPE'			=> 'GLOBAL',
	'TENDOO_VERS'	=> 0.94,
	'HAS_ICON'		=>	1
));
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_widget_administrator_left` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_TITLE` varchar(200),
  `WIDGET_NAMESPACE` text NOT NULL,
  `WIDGET_MODNAMESPACE` varchar(200) NOT NULL,
  `WIDGET_HUMAN_NAME` varchar(200) NOT NULL,
  `WIDGET_ETAT` varchar(200),
  `WIDGET_PARAMETERS` text,
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `IS_CODE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_widget_administrator_bottom` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_TITLE` varchar(200),
  `WIDGET_NAMESPACE` text NOT NULL,
  `WIDGET_MODNAMESPACE` varchar(200) NOT NULL,
  `WIDGET_HUMAN_NAME` varchar(200) NOT NULL,
  `WIDGET_ETAT` varchar(200),
  `WIDGET_PARAMETERS` text,
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `IS_CODE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_widget_administrator_right` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_TITLE` varchar(200),
  `WIDGET_NAMESPACE` text NOT NULL,
  `WIDGET_MODNAMESPACE` varchar(200) NOT NULL,
  `WIDGET_HUMAN_NAME` varchar(200) NOT NULL,
  `WIDGET_ETAT` varchar(200),
  `WIDGET_PARAMETERS` text,
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `IS_CODE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appAction(array(
	'action'				=>	'widgetsMastering',
	'action_name'			=>	'Gestion des widgets',
	'action_description'	=>	'Cette action permet de cr&eacute;er et d\'administrer un widget.',
	'mod_namespace'			=>	'tendoo_widget_administrator'
));