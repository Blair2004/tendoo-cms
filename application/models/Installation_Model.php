<?php
class Installation_Model extends CI_Model
{
	function installation( $host_name, $user_name, $user_password, $database_name, $database_driver, $database_prefix )
	{
		$config['hostname'] = $host_name;
		$config['username'] = $user_name;
		$config['password'] = $user_password;
		$config['dbdriver'] = $database_driver;
		$config['dbprefix'] = ( $database_prefix == '' ) ? 'tendoo_' : $database_prefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = FALSE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';

		if( $database_driver == 'mysqli' ) {
			if( ! $link		=	@mysqli_connect( $host_name, $user_name, $user_password ) ) {
				return 'unable-to-connect';
			}
			mysqli_close( $link ); // Closing connexion
		}

		$db_connect	=	$this->load->database( $config );
		$this->load->dbutil();
		$db_exists	=	$this->dbutil->database_exists( $database_name );

		if( ! $db_exists ) {
			return 'database-not-found';
		}

		$this->db->close();
		// Setting database name
		$config['database'] 	= 	$database_name;
		// Reconnect
		$db_connect				=	$this->load->database( $config );

		$this->load->library( 'session' );
		$this->load->model( 'options' );

		// Before tendoo settings tables
		// Used internaly to load module only when database connection is established.

		$this->events->do_action( 'before_setting_tables' , array(
			'database_prefix'	=>		$database_prefix,
			'install_model'		=>		$this
		) );

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

		$this->events->do_action( 'tendoo_settings_tables' , array(
			'database_prefix'		=>		$database_prefix,
			'install_model'			=>		$this
		) );

		// Creating Database File
		$this->create_config_file( $config );

		// Saving First Option
		$this->options->set( 'database_version', $this->config->item( 'database_version' ), true );

		return 'database-installed';
	}
	
	/**
	 * Create a config file
	 * 
	 * @params Array config data
	 * @return Void
	**/
	
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
\$db['default']['cachedir'] = 'application/cache/database/';
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
	
	/**
	 * Final Configuration
	 * 
	 * @params string Site Name
	 * @return mixed
	**/
	
	function final_configuration( $site_name )
	{
		// Saving Site name
		$this->options->set( 'site_name' , $this->input->post( 'site_name' ), TRUE );

		// Do actions
		$this->events->do_action( 'tendoo_settings_final_config' );

		// user can change this behaviors
		return $this->events->apply_filters( 'validating_tendoo_setup' , 'tendoo-installed' );
	}

	/**
	 * Is installed
	 * @return bool
	**/

	function is_installed()
	{
		global $IsInstalled;

		if( $IsInstalled != NULL ) {
			return $IsInstalled;
		}
		
		if( file_exists( APPPATH . 'config/database.php' ) )
		{
				$this->load->database();
				if( $this->db->table_exists( 'options') ) {
					$this->db->close();
					$IsInstalled	=	true;
					return $IsInstalled;
				}
				$this->db->close();
		}
		$IsInstalled	=	false;
		return $IsInstalled;
	}
}
