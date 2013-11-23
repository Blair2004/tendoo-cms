<?php
class Hubby_installer
{
	private $appType;
	private $appSql;
	private $appVers;
	private $appHubbyVers;
	private $appNamespace;
	private $appTableField;
	private $core;
	public function __construct()
	{
		$this->core			=	Controller::instance();
		$this->appType		=	'THEME';
		$this->appSql		=	array();
		$this->appVers		=	0.1;
		$this->appHubbyVers	=	0.9;
		$this->appTableField=	array(
			'NAMESPACE'		=> 'hubby_modus',
			'HUMAN_NAME'	=> 'Hubby - Modus',
			'AUTHOR'		=> 'Hubby Group',
			'DESCRIPTION'	=> 'Un thème fait par adapt&eacute; par l\'equipe Hubby. Ce th&egrave;me provient du template r&eacute;alis&eacute; par Luizuno disponible sur luizuno.com',
			'HUBBY_VERS'	=> 0.9
		);
		$this->appSql[]		=	"
		'CREATE TABlE IF NOT EXISTS `hubby_theme_modus_table` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `TWITTER_ACCOUNT` varchar(200) NOT NULL,
		  `FACEBOOK_ACCOUNT` varchar(200) NOT NULL,
		  `GOOGLEPLUS_ACCOUNT` varchar(200) NOT NULL,
		  `WIDGET_REF_ID` int(11)NOT NULL,
		  `ETAT` int(11) NOT NULL,
		  `POSITION` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		);';";
	}
	public function datas()
	{
		return array(
			'appType'			=>	$this->appType,
			'appTableField'		=>	$this->appTableField,
			'appSql'			=>	$this->appSql,
			'appVers'			=>	$this->appVers,
			'appHubbyVers'		=>	$this->appHubbyVers
		);
	}
}