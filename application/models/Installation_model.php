<?php
class Installation_Model extends CI_Model
{
	function installation( $host_name, $user_name, $user_password, $database_name, $database_driver, $database_prefix )
	{
		$config['hostname'] = $host_name;
		$config['username'] = $user_name;
		$config['password'] = $user_password;
		$config['database'] = $database_name;
		$config['dbdriver'] = $database_driver;
		$config['dbprefix'] = ( $database_prefix == '' ) ? 'tendoo_' : $database_prefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		
		$this->load->database( $config );
		$this->load->dbutil();
		$this->load->dbforge();
		$this->load->model( 'options' );
		
		if( ! $this->dbutil->database_exists( 'database' ) )
		{
			if( $this->dbutil->database_exists( $database_name ) )
			{
				// Creating option table
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}options`;" );				
				$this->db->query( "CREATE TABLE `{$database_prefix}options` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `key` varchar(200) NOT NULL,
				  `value` text,
				  `autoload` int(11) NOT NULL,
				  `user` int(11) NOT NULL,
				  `app` varchar(100) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
				" );
				
				// Creatin Auth Group
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_groups`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_groups` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(100),
				  `definition` text,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;" );
				
				// Creating Auth Permission
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_perms`;" );
				$this->db->query( "
				CREATE TABLE `{$database_prefix}aauth_perms` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(100),
				  `definition` text,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				" );
				
				// Creating Permission to Group
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_perm_to_group`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aaauth_perm_to_group` (
				  `perm_id` int(11) unsigned DEFAULT NULL,
				  `group_id` int(11) unsigned DEFAULT NULL,
				  PRIMARY KEY (`perm_id`,`group_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
				
				// Auth Permission to User
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_perm_to_user`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_perm_to_user` (
				  `perm_id` int(11) unsigned DEFAULT NULL,
				  `user_id` int(11) unsigned DEFAULT NULL,
				  PRIMARY KEY (`perm_id`,`user_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
				
				// Auth PMS
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_pms`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_pms` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `sender_id` int(11) unsigned NOT NULL,
				  `receiver_id` int(11) unsigned NOT NULL,
				  `title` varchar(255) NOT NULL,
				  `message` text,
				  `date` datetime DEFAULT NULL,
				  `read` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`),
				  KEY `full_index` (`id`,`sender_id`,`receiver_id`,`read`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
				
				// System Variables
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_system_variables`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_system_variables` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `key` varchar(100) NOT NULL,
				  `value` text,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
				
				// Auth User Table
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_users`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_users` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
				  `pass` varchar(100) COLLATE utf8_general_ci NOT NULL,
				  `name` varchar(100) COLLATE utf8_general_ci,
				  `banned` tinyint(1) DEFAULT '0',
				  `last_login` datetime DEFAULT NULL,
				  `last_activity` datetime DEFAULT NULL,
				  `last_login_attempt` datetime DEFAULT NULL,
				  `forgot_exp` text COLLATE utf8_general_ci,
				  `remember_time` datetime DEFAULT NULL,
				  `remember_exp` text COLLATE utf8_general_ci,
				  `verification_code` text COLLATE utf8_general_ci,
				  `ip_address` text COLLATE utf8_general_ci,
				  `login_attempts` int(11) DEFAULT '0',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;" );
				
				// User Auth Group
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_user_to_group`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_user_to_group` (
				  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
				  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
				  PRIMARY KEY (`user_id`,`group_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
				
				// Auth User Variable
				$this->db->query( "DROP TABLE IF EXISTS `{$database_prefix}aauth_user_variables`;" );
				$this->db->query( "CREATE TABLE `{$database_prefix}aauth_user_variables` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `user_id` int(11) unsigned NOT NULL,
				  `key` varchar(100) NOT NULL,
				  `value` text,
				  PRIMARY KEY (`id`),
				  KEY `user_id_index` (`user_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
				
				// Creating Database File
				$this->create_config_file( $config );
				
				// Saving First Option
				$this->options->set( 'database-version', $this->config->item( 'database-version' ), true );
				
				return 'database-installed';				
			}
			return 'database-not-found';
		}
		return 'unable-to-connect';
	}
	public function create_config_file( $config )
	{
		/* CREATE CONFIG FILE */
		$string_config = 
		"<?php
/**
 * Database configuration for Tendoo CMS
 * -------------------------------------
 * Tendoo Version : " . get( 'core_version' ) . "
**/

defined('BASEPATH') OR exit('No direct script access allowed');

\$active_group = 'default';
\$query_builder = TRUE;

\$db['default']['hostname'] = '".$config['hostname']."';
\$db['default']['username'] = '".$config['username']."';
\$db['default']['password'] = '".$config['password']."';
\$db['default']['database'] = '".$config['database']."';
\$db['default']['dbdriver'] = '".$config['dbdriver']."';
\$db['default']['dbprefix'] = '".$config['dbprefix']."';
\$db['default']['pconnect'] = FALSE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '/application/cache/database';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;

if(!defined('DB_PREFIX'))
{
	define('DB_PREFIX',\$db['default']['dbprefix']);
}";
		$file = fopen( APPPATH . 'config/database.php' , 'w+' );
		fwrite( $file , $string_config );
		fclose( $file );
	}
	function final_configuration( $site_name , $username , $password , $email )
	{			
		// checks user and email availability
		if( $this->users->auth->user_exsist_by_name( $username ) ) 		: return 'username-used'; endif; 
		if( $this->users->auth->user_exsist_by_email( $email ) ) 		: return 'email-used'; endif;
		
		// set site_name
		$this->options->set( 'site-name' , $site_name );
		
		// Creating Master & Groups
		$this->users->create_default_groups();
		return $this->users->create_master( $email , $password , $username );
	}
	function is_installed()
	{
		if( file_exists( APPPATH . 'config/database.php' ) )
		{
			return true;
		}
		return false;
	}
}