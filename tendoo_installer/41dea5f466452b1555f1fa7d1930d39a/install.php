<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.3);
$this->appTendooVers(0.98);
$this->appTableField(array(
	'NAMESPACE'		=> 'tendoo_index_manager',
	'HUMAN_NAME'	=> 'Gestionnaire de la page d\'accueil',
	'AUTHOR'		=> 'tendoo Group',
	'DESCRIPTION'	=> 'Personnalisez une page d\'accueil qui refl&egrave;te votre blog, forum, boutique ou vos services. Ajuster les informations qui s\'affichent, ainsi que leur quantité.',
	'TYPE'			=> 'BYPAGE',
	'TENDOO_VERS'	=> 0.98,
	'HAS_ICON'		=>	1
));
$this->appAction(array(
	'action'				=>	'tendoo_index_manager',
	'action_name'			=>	'Gestion de la page d\'accueil',
	'action_description'	=>	'Cette action permet de gerer la page d\'accueil, carrousel, publication du blog, témoignages.',
	'mod_namespace'			=>	'tendoo_index_manager'
));
$this->appSql(
'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_index_manager` (
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
$this->appSql("INSERT INTO `".DB_ROOT."tendoo_index_manager` (`ID`, `SHOW_CAROUSSEL`, `SHOW_FEATURED`, `SHOW_GALLERY`, `SHOW_LASTEST`, `SHOW_PARTNERS`, `SHOW_SMALLDETAILS`, `SHOW_TABSHOWCASE`, `SHOW_ABOUTUS`, `ABOUTUS_TITLE`, `PARTNER_TITLE`, `GALSHOWCASE_TITLE`, `FEATURED_TITLE`, `LASTEST_TITLE`, `CAROUSSEL_TITLE`, `SMALLDETAIL_TITLE`, `TABSHOWCASE_TITLE`, `ON_CAROUSSEL`, `ON_FEATURED`, `ON_GALLERY`, `ON_LASTEST`, `ON_SMALLDETAILS`, `ON_TABSHOWCASE`, `ABOUTUS_CONTENT`, `PARTNERS_CONTENT`, `CAROUSSEL_LIMIT`, `FEATURED_LIMIT`, `GALLERY_LIMIT`, `LASTEST_LIMIT`, `SMALLDETAILS_LIMIT`, `TABSHOWCASE_LIMIT`) VALUES
(1, 1, 0, 0, 1, 0, 0, 0, 0, 'A propos de nous', '', '', 'Au top', 'Actualités', '', '', '', 'news/featuredpost', 'news/featuredpost', '', 'news/recentspost', '', '', '<p>Bienvenue sur tendoo. Ceci est la page d&#39;accueil de votre site web. Vous avez la possibilit&eacute; de modifier les &eacute;l&eacute;ments qui doivent s&#39;afficher, selectionner parmis les possibilit&eacute;s, les informations qui doivent apparaitre dans chaque espace, et limiter le nombre d&#39;&eacute;l&eacute;ment qui peuvent s&#39;afficher, depuis l&#39;espace administration. Connectez vous pour modifier cet &eacute;l&eacute;ment.&nbsp;</p>\r\n\r\n<p>Nous vous remercions d&#39;avoir choisi tendoo comme votre application de conception de site web.&nbsp;<img alt=\"cool\" src=\"http://localhost/hub_ex/tendoo_assets/js/ckeditor/plugins/smiley/images/shades_smile.gif\"  width:20px\" title=\"cool\" /></p>', NULL, 6, 3, 0, 6, 0, 0);");