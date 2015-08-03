<?php
class post_type_setup extends CI_model
{
	function __construct()
	{
		$this->version			=	'1.0';
		parent::__construct();
		if( ! $this->__is_installed() )
		{
			$this->__install_tables();
		}
	}
	private function __is_installed()
	{
		if( $this->options->get( 'post_type' ) != $this->version )
		{
			return false;
		}
		return true;
	}
	private function __install_tables()
	{
		$this->options->set( 'post_type' , $this->version );
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(255) NOT NULL,
			`TITLE` varchar(255),
			`CONTENT` text NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`AUTHOR` varchar(255) NOT NULL,
			`STATUS` int(11) NOT NULL,
			`PARENT_REF_ID` int(11) NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if( ! $this->db->query($sql) )
		{
			return false;
		};
		/* CREATE tendoo_query_attachment */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query_meta' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`QUERY_REF_ID` int(11) NOT NULL,
			`KEY` varchar(255),
			`VALUE` text NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_taxonomies */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query_taxonomies' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(255) NOT NULL,
			`QUERY_NAMESPACE` varchar(200) NOT NULL,
			`TITLE` varchar(255),
			`CONTENT` text NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`PARENT_REF_ID` int(11) NOT NULL,
			`AUTHOR` varchar(255) NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_taxonomies */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query_taxonomies_relationships' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`TAXONOMY_REF_ID` int(11) NOT NULL,
			`QUERY_REF_ID` int(11),
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_comments */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'. $this->db->dbprefix( 'query_comments' ) .'` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`AUTHOR` int(11) NOT NULL,
			`COMMENTS` text,
			`QUERY_NAMESPACE` varchar(200),
			`CUSTOM_QUERY_ID` int(11) NOT NULL,
			`STATUS` int(11) NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`REPLY_TO` int(11) NOT NULL,
			`AUTHOR_EMAIL` varchar(200),
			`AUTHOR_NAME` varchar(200),
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
	}
}
new post_type_setup;