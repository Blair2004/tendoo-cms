<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.1);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'Tendoo_widget_administrator',
	'HUMAN_NAME'	=> 'Gestionnaire de widgets',
	'AUTHOR'		=> 'Tendoo Group',
	'DESCRIPTION'	=> 'Permet de créer et d\'administrer des widgets',
	'TYPE'			=> 'GLOBAL',
	'Tendoo_VERS'	=> 0.94
));
$this->appSql(	
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'Tendoo_mod_widgets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `WIDGET_HEAD` varchar(200) NOT NULL,
  `WIDGET_CONTENT` text NOT NULL,
  `WIDGET_REFERING_NAME` varchar(200) NOT NULL,
  `WIDGET_REFERING_OBJ_NAMESPACE` varchar(200) NOT NULL,
  `WIDGET_DESCRIPTION` text NOT NULL,
  `WIDGET_ORDER` int(11),
  `WIDGET_ETAT` varchar(200),
  `AUTEUR` int(11) NOT NULL,
  `DATE` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
);');
$this->appAction(array(
	'action'				=>	'widgetsMastering',
	'action_name'			=>	'Gestion des widgets',
	'action_description'	=>	'Cette action permet de cr&eacute;er et d\'administrer un widget.',
	'mod_namespace'			=>	'Tendoo_widget_administrator'
));