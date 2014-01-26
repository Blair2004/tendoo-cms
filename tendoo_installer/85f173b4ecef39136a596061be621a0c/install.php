<?php
$this->installSession();
$this->appType('THEME');
$this->appVers(0.1);
$this->appTendooVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'Tendoo_modus',
	'HUMAN_NAME'	=> 'Tendoo - Modus',
	'AUTHOR'		=> 'Tendoo Group',
	'DESCRIPTION'	=> 'Un thème fait par adapt&eacute; par l\'equipe Tendoo. Ce th&egrave;me provient du template r&eacute;alis&eacute; par Luizuno disponible sur luizuno.com',
	'TENDOO_VERS'	=> 0.94
));
$this->appSql('CREATE TABlE IF NOT EXISTS `'.DB_ROOT.'Tendoo_theme_modus_table` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TWITTER_ACCOUNT` varchar(200) NULL,
  `FACEBOOK_ACCOUNT` varchar(200) NULL,
  `GOOGLEPLUS_ACCOUNT` varchar(200) NULL,
  PRIMARY KEY (`ID`));
');
