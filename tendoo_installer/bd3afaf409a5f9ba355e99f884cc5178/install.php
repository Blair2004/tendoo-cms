<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.5);
$this->appTendooVers(0.98);
$this->appTableField(array(
	'NAMESPACE'		=> 'tendoo_widget_administrator',
	'HUMAN_NAME'	=> 'Gestionnaire de widgets',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Permet de créer et d\'administrer des widgets',
	'TYPE'			=> 'GLOBAL',
	'TENDOO_VERS'	=> 0.98,
	'HAS_ICON'		=>	1,
	'HANDLE'		=>	'WIDGETS'
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
// Creating Default Widgets
if($this->getSpeModuleByNamespace('news'))
{
	$this->appSql("
	INSERT INTO `".DB_ROOT."tendoo_widget_administrator_right` 
	(ID,WIDGET_TITLE,WIDGET_NAMESPACE,WIDGET_MODNAMESPACE,WIDGET_HUMAN_NAME,WIDGET_ETAT,WIDGET_PARAMETERS,AUTEUR,DATE,IS_CODE) values
	(1, 'Mots clés disponibles', 'tags', 'news', 'Afficher les mots clés', '1', '9', 4, '".$this->instance->date->datetime()."', 0),
	(2, 'Meta.', 'syslink', 'news', 'Liens Système', '1', '', 4, '2014-06-01 10:20:50', 0),
	(3, 'Catégories Disponibles', 'aflecatdi', 'news', 'Afficher les categorie disponible', '1', '20', 4, '2014-06-01 10:20:50', 0);
	");
	// LEFT
	$this->appSql("
	INSERT INTO `".DB_ROOT."tendoo_widget_administrator_left` 
	(ID,WIDGET_TITLE,WIDGET_NAMESPACE,WIDGET_MODNAMESPACE,WIDGET_HUMAN_NAME,WIDGET_ETAT,WIDGET_PARAMETERS,AUTEUR,DATE,IS_CODE) values
	(1, 'Mots clés disponibles', 'tags', 'news', 'Afficher les mots clés', '1', '9', 4, '".$this->instance->date->datetime()."', 0),
	(2, 'Meta.', 'syslink', 'news', 'Liens Système', '1', '', 4, '2014-06-01 10:20:50', 0),
	(3, 'Catégories Disponibles', 'aflecatdi', 'news', 'Afficher les categorie disponible', '1', '20', 4, '2014-06-01 10:20:50', 0);
	");
	// BOTTOM
	$this->appSql("
	INSERT INTO `".DB_ROOT."tendoo_widget_administrator_bottom`
	(ID,WIDGET_TITLE,WIDGET_NAMESPACE,WIDGET_MODNAMESPACE,WIDGET_HUMAN_NAME,WIDGET_ETAT,WIDGET_PARAMETERS,AUTEUR,DATE,IS_CODE) values
	(1, 'Mots clés disponibles', 'tags', 'news', 'Afficher les mots clés', '1', '9', 4, '".$this->instance->date->datetime()."', 0),
	(2, 'Meta.', 'syslink', 'news', 'Liens Système', '1', '', 4, '2014-06-01 10:20:50', 0),
	(3, 'Catégories Disponibles', 'aflecatdi', 'news', 'Afficher les categorie disponible', '1', '20', 4, '2014-06-01 10:20:50', 0);
	");
}