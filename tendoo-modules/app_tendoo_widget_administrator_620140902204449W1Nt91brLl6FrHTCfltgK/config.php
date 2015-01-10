<?php
declare_module( 'tendoo_widget_administrator' , array( 
	'name'		=>		'MIDATE',
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		'Ajoutez et gérez vos widgets avec MIDATE',
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'APP',
	'compatible'		=>		1.3,
	'version'			=>		0.6
) ); 
push_module_sql( 'tendoo_widget_administrator' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_widget_administrator_left` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_TITLE` varchar(200),
  `WIDGET_NAMESPACE` text NOT NULL,
  `WIDGET_MODNAMESPACE` varchar(200) NOT NULL,
  `WIDGET_NAME` varchar(200) NOT NULL,
  `WIDGET_ETAT` varchar(200),
  `WIDGET_PARAMETERS` text,
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `IS_CODE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
push_module_sql( 'tendoo_widget_administrator' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_widget_administrator_right` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_TITLE` varchar(200),
  `WIDGET_NAMESPACE` text NOT NULL,
  `WIDGET_MODNAMESPACE` varchar(200) NOT NULL,
  `WIDGET_NAME` varchar(200) NOT NULL,
  `WIDGET_ETAT` varchar(200),
  `WIDGET_PARAMETERS` text,
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `IS_CODE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
push_module_sql( 'tendoo_widget_administrator' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_widget_administrator_bottom` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_TITLE` varchar(200),
  `WIDGET_NAMESPACE` text NOT NULL,
  `WIDGET_MODNAMESPACE` varchar(200) NOT NULL,
  `WIDGET_NAME` varchar(200) NOT NULL,
  `WIDGET_ETAT` varchar(200),
  `WIDGET_PARAMETERS` text,
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  `IS_CODE` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');
// Default Optinos
push_module_sql( 'tendoo_widget_administrator' , "INSERT INTO `".DB_ROOT."tendoo_widget_administrator_right` 
	(ID,WIDGET_TITLE,WIDGET_NAMESPACE,WIDGET_MODNAMESPACE,WIDGET_NAME,WIDGET_ETAT,WIDGET_PARAMETERS,AUTEUR,DATE,IS_CODE) values
	(1, 'Mots clés disponibles', 'tags', 'blogster', 'Afficher les mots clés', '1', '9', 4, '".get_instance()->date->datetime()."', 0),
	(2, 'Meta.', 'syslink', 'blogster', 'Liens Système', '1', '', 4, '2014-06-01 10:20:50', 0),
	(3, 'Catégories Disponibles', 'aflecatdi', 'blogster', 'Afficher les categorie disponible', '1', '20', 4, '2014-06-01 10:20:50', 0);"
);
push_module_sql( 'tendoo_widget_administrator' , "
	INSERT INTO `".DB_ROOT."tendoo_widget_administrator_left` 
	(ID,WIDGET_TITLE,WIDGET_NAMESPACE,WIDGET_MODNAMESPACE,WIDGET_NAME,WIDGET_ETAT,WIDGET_PARAMETERS,AUTEUR,DATE,IS_CODE) values
	(1, 'Mots clés disponibles', 'tags', 'blogster', 'Afficher les mots clés', '1', '9', 4, '".get_instance()->date->datetime()."', 0),
	(2, 'Meta.', 'syslink', 'blogster', 'Liens Système', '1', '', 4, '2014-06-01 10:20:50', 0),
	(3, 'Catégories Disponibles', 'aflecatdi', 'blogster', 'Afficher les categorie disponible', '1', '20', 4, '2014-06-01 10:20:50', 0);
	"
);
push_module_sql( 'tendoo_widget_administrator' , "
	INSERT INTO `".DB_ROOT."tendoo_widget_administrator_bottom`
	(ID,WIDGET_TITLE,WIDGET_NAMESPACE,WIDGET_MODNAMESPACE,WIDGET_NAME,WIDGET_ETAT,WIDGET_PARAMETERS,AUTEUR,DATE,IS_CODE) values
	(1, 'Mots clés disponibles', 'tags', 'blogster', 'Afficher les mots clés', '1', '9', 4, '".get_instance()->date->datetime()."', 0),
	(2, 'Meta.', 'syslink', 'blogster', 'Liens Système', '1', '', 4, '2014-06-01 10:20:50', 0),
	(3, 'Catégories Disponibles', 'aflecatdi', 'blogster', 'Afficher les categorie disponible', '1', '20', 4, '2014-06-01 10:20:50', 0);
	"
);
push_module_action( 'tendoo_widget_administrator' , array(
	'action'				=>	'manage_widgets',
	'action_name'			=>	'Gestion des widgets',
	'action_description'	=>	'Cette action permet de cr&eacute;er et d\'administrer un widget.',
	'mod_namespace'			=>	'tendoo_widget_administrator'
));