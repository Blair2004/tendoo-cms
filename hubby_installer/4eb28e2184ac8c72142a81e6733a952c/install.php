<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.1);
$this->appHubbyVers(0.94);
$this->appTableField(array(
	'NAMESPACE'		=> 'hubby_index_manager',
	'HUMAN_NAME'	=> 'Gestionnaire de la page d\'accueil',
	'AUTHOR'		=> 'Hubby Group',
	'DESCRIPTION'	=> 'Personnaliser une page d\'accueil qui fl&egrave;te votre blog, forum, boutique ou vos services. Ajuster les informations qui s\'affichent, ainsi que leur quantité.',
	'TYPE'			=> 'BYPAGE',
	'HUBBY_VERS'	=> 0.94
));
$this->appAction(array(
	'action'				=>	'hubby_index_manager',
	'action_name'			=>	'Gestion de la page d\'accueil',
	'action_description'	=>	'Cette action permet de gerer la page d\'accueil, carrousel, publication du blog, témoignages.',
	'mod_namespace'			=>	'hubby_index_mod'
));
$this->appSql(
'CREATE TABLE IF NOT EXISTS `hubby_index_manager` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SHOW_CAROUSSEL` int(11) NOT NULL,
  `SHOW_FEATURED` int(11) NOT NULL,
  `SHOW_GALLERY` int(11) NOT NULL,
  `SHOW_LASTEST` int(11) NOT NULL,
  `SHOW_PARTNERS` int(11) NOT NULL,
  `SHOW_SMALLDETAILS` int(11) NOT NULL,
  `SHOW_TABSHOWCASE` int(11) NOT NULL,
  `SHOW_ABOUTUS`	int(11) NOT NULL,
  `ABOUTUS_TITLE` varchar(200) NOT NULL,
  `PARTNER_TITLE` varchar(200) NOT NULL,
  `GALSHOWCASE_TITLE` varchar(200) NOT NULL,
  `FEATURED_TITLE` varchar(200) NOT NULL,
  `LASTEST_TITLE` varchar(200) NOT NULL,
  `CAROUSSEL_TITLE` varchar(200) NOT NULL,
  `SMALLDETAIL_TITLE` varchar(200) NOT NULL,
  `TABSHOWCASE_TITLE` varchar(200) NOT NULL,
  `ON_CAROUSSEL` varchar(200) NOT NULL,
  `ON_FEATURED` varchar(200) NOT NULL,
  `ON_GALLERY` varchar(200) NOT NULL,
  `ON_LASTEST` varchar(200) NOT NULL,
  `ON_SMALLDETAILS` varchar(200) NOT NULL,
  `ON_TABSHOWCASE`	varchar(200) NOT NULL,
  `ABOUTUS_CONTENT` text,
  `PARTNERS_CONTENT` text,
  `CAROUSSEL_LIMIT` int(11) NOT NULL,
  `FEATURED_LIMIT` int(11) NOT NULL,
  `GALLERY_LIMIT` int(11) NOT NULL,
  `LASTEST_LIMIT` int(11) NOT NULL,
  `SMALLDETAILS_LIMIT` int(11) NOT NULL,
  `TABSHOWCASE_LIMIT` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);');