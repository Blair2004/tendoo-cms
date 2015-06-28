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
				
				$this->events->do_action( 'tendoo_settings_tables' );
				
				// Creating Database File
				$this->create_config_file( $config );
				
				// Saving First Option
				$this->options->set( 'database_version', $this->config->item( 'database_version' ), true );
				
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
		// Saving Site name
		$this->options->set( 'site_name' , $site_name );
		
		// Do actions 
		$this->events->do_action( 'tendoo_settings_final_config' );
		
		// user can change this behaviors
		return $this->events->apply_filters( 'validating_tendoo_setup' , 'tendoo-installed' );
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