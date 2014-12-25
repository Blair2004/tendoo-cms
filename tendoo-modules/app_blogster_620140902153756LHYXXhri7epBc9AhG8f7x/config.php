<?php
declare_module( 'blogster' , array(  // restore later to blogster please
	'name'				=>		__( 'Blogster' ),
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		__( 'This module help you create a blog section on your website.' ),
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'BLOG',
	'compatible'		=>		1.4,
	'version'			=>		0.7
) ); 
push_module_sql( 'blogster' , 	'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `REF_ART` int(11) NOT NULL,
  `SHOW` int(11) NOT NULL,
  `CONTENT` text NOT NULL,
  `DATE` datetime NOT NULL,
  `AUTEUR` int(11) NOT NULL,
  `OFFLINE_AUTEUR` varchar(200) NOT NULL,
  `OFFLINE_AUTEUR_EMAIL` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
push_module_sql( 'blogster' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(200) NOT NULL,
  `URL_TITLE` varchar(200) NOT NULL,
  `CONTENT` text NOT NULL,
  `DATE` datetime NOT NULL,
  `AUTEUR` int(11) NOT NULL,
  `ETAT` varchar(5) NOT NULL,
  `IMAGE` varchar(200) NOT NULL,
  `THUMB` varchar(200) NOT NULL,
  `VIEWED` int(11) NOT NULL,
  `SCHEDULED` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
push_module_sql( 'blogster' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_ref_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NEWS_REF_ID` int(11) NOT NULL,
  `CATEGORY_REF_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
push_module_sql( 'blogster' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_keywords` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` text(200) NOT NULL,
  `URL_TITLE` varchar(200) NOT NULL,
  `DESCRIPTION` text,
  `AUTEUR` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
push_module_sql( 'blogster' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_ref_keywords` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NEWS_REF_ID` int(11) NOT NULL,
  `KEYWORDS_REF_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');

push_module_sql( 'blogster' ,  'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_setting` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EVERYONEPOST` int(11) NOT NULL,
  `APPROVEBEFOREPOST` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
push_module_sql( 'blogster' , 'CREATE TABLE IF NOT EXISTS `'.DB_ROOT.'tendoo_news_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(100) NOT NULL,
  `URL_TITLE` varchar(200) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `DATE` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
');
push_module_sql( 'blogster' , "INSERT INTO `".DB_ROOT."tendoo_news` 
	(ID,TITLE,URL_TITLE,CONTENT,DATE,AUTEUR,ETAT,IMAGE,THUMB) values
	(1, 'Welcome on tendoo " . get( 'core_id' ) . "', 'welcome-on-tendoo-cms', 'Hi, here is your first post. You can edit it through dahsboard.', '".get_instance()->date->datetime()."', '1' , '1', '".img_url( 'Hub_back.png' )."', '".img_url( 'Hub_back.png' )."')"
);	
push_module_sql( 'blogster' , "INSERT INTO `".DB_ROOT."tendoo_news_category` 
	(ID,CATEGORY_NAME,URL_TITLE,DESCRIPTION,DATE) values
	(1, 'Unamed category', 'unamed-cateogry', 'This is your first category.', '".get_instance()->date->datetime()."')");
push_module_sql( 'blogster' , "INSERT INTO `".DB_ROOT."tendoo_news_keywords` 
	(ID,TITLE,URL_TITLE,DESCRIPTION,AUTEUR) values
	(1, 'tendoo', 'tendoo', 'You can use more than one keyword', '1')"
);
push_module_sql( 'blogster' , "INSERT INTO `".DB_ROOT."tendoo_news_ref_category` 
	(ID,NEWS_REF_ID,CATEGORY_REF_ID) values
	(1, '1', '1')"
);
push_module_sql( 'blogster' , "INSERT INTO `".DB_ROOT."tendoo_news_ref_keywords` 
	(ID,NEWS_REF_ID,KEYWORDS_REF_ID) values
	(1, '1', '1')"
);
push_module_action( 'blogster' , array(
	'action'				=>	'publish_posts',
	'action_name'			=>	__( 'Publish Post' ),
	'action_description'	=>	__( 'This permission let you create a post' ),
));
push_module_action( 'blogster' , array(
	'action'				=>	'delete_posts',
	'action_name'			=>	__( 'Delete Post' ),
	'action_description'	=>	__( 'This permission let you delete posts' ),
));
push_module_action( 'blogster' , array(
	'action'				=>	'edit_posts',
	'action_name'			=>	__( 'Delete posts' ),
	'action_description'	=>	__( 'This permission is used to delete posts' ),
));
push_module_action( 'blogster' , array(
	'action'				=>	'category_manage',
	'action_name'			=>	__( 'Manage Category' ),
	'action_description'	=>	__( 'This permissions let you manage category' ),
));
push_module_action( 'blogster' , array(
	'action'				=>	'blogster_setting',
	'action_name'			=>	__( 'Manage Blogster Settings' ),
	'action_description'	=>	__( 'In order to access blogster settings' ),
));
push_module_action( 'blogster' , array(
	'action'				=>	'blogster_manage_comments',
	'action_name'			=>	__( 'Manage Comments' ),
	'action_description'	=>	__( 'In order to manage comments' ),
));
push_module_action( 'blogster' , array(
	'action'				=>	'blogster_manage_tags',
	'action_name'			=>	__( 'Manage Tags' ),
	'action_description'	=>	__( 'This permission let you manage tags' ),
));