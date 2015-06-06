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
				$attributes = array('ENGINE' => 'InnoDB');
				$this->dbforge->add_field( 'id', true )->create_table( 'options' , TRUE, $attributes );
				$fields		=	array(
					'key' 	=>	array( 
						'type'			=>	'VARCHAR',
						'constraint'	=>	'220',
						'null'			=>	false
					),
					'value'	=>	array(
						'type'			=>	'VARCHAR',
						'constraint'	=>	'220',
						'null'			=>	false
					),
					'autoload'	=>	array(
						'type'			=>	'INT',
						'constraint'	=>	'11',
						'null'			=>	false
					),
					'user'				=>	array(
						'type'			=>	'INT',
						'constraint'	=>	11,
						'null'			=>	false
					),
					'app'				=>	array(
						'type'			=>	'VARCHAR',
						'constraint'	=>	100,
						'null'			=>	false
					)
				);
				$this->dbforge->add_column( 'options' , $fields );
				
				$this->options->set( 'database-version', $this->config->item( 'database-version' ), true );
				
				// creating ci_sessions	
				$this->dbforge
					->add_field( 'session_id varchar(40) NOT NULL' )
					->add_field( 'ip_address varchar(16) NOT NULL' )
					->add_field( 'user_agent varchar(120) NOT NULL' )
					->add_field( 'last_activity int(10) unsigned NOT NULL' )
					->add_field( 'user_data text NOT NULL' )
					->add_key( 'last_activity' )
					->add_key( 'session_id' , true )
				->create_table( 'ci_sessions' , TRUE, $attributes );
				
				
				// Creating User Table
				
				$this->dbforge
					->add_field( array(
						'uacc_id'	=>	array(
							'type'				=> 	'INT',
							'constraint' 		=> 	11,
							'unsigned' 			=> 	TRUE,
							'auto_increment' 	=> 	TRUE,
							'null'				=>	false,
							'primary'			=>	true
						)
					) )
					->add_field( 'uacc_group_fk smallint(5) unsigned NOT NULL' )
					->add_field( 'uacc_email varchar(100) NOT NULL' )
					->add_field( 'uacc_username varchar(15) NOT NULL' )
					->add_field( 'uacc_password varchar(60) NOT NULL' )
					->add_field( 'uacc_ip_address varchar(40) NOT NULL' )
					->add_field( 'uacc_salt varchar(60) NOT NULL' )
					->add_field( 'uacc_activation_token varchar(60) NOT NULL' )
					->add_field( 'uacc_forgotten_password_token varchar(60) NOT NULL' )
					->add_field( 'uacc_forgotten_password_expire datetime NOT NULL' )
					->add_field( 'uacc_update_email_token varchar(60) NOT NULL' )
					->add_field( 'uacc_update_email varchar(100) NOT NULL' )
					->add_field( 'uacc_active tinyint(1) NOT NULL' )
					->add_field( 'uacc_suspend tinyint(1) NOT NULL' )
					->add_field( 'uacc_fail_login_attempts smallint(5) NOT NULL' )
					->add_field( 'uacc_fail_login_ip_address varchar(60) NOT NULL' )
					->add_field( 'uacc_date_fail_login_ban datetime NOT NULL' )
					->add_field( 'uacc_date_last_login  datetime NOT NULL' )
					->add_field( 'uacc_date_added datetime NOT NULL' )
					->add_key( 'uacc_group_fk' )
					->add_key( 'uacc_email' )
					->add_key( 'uacc_username' )
					->add_key( 'uacc_fail_login_ip_address' )
					->add_key( 'uacc_id' , true )
				->create_table( 'user_accounts' , TRUE, $attributes );
				
				// creating group table	
				$this->dbforge
					->add_field( array(
						'ugrp_id'	=>	array(
							'type'				=> 	'INT',
							'constraint' 		=> 	11,
							'unsigned' 			=> 	TRUE,
							'auto_increment' 	=> 	TRUE,
							'null'				=>	false,
							'primary'			=>	true
						)
					) )
					->add_field( 'ugrp_name varchar(20) NOT NULL' )
					->add_field( 'ugrp_desc varchar(100) NOT NULL' )
					->add_field( 'ugrp_admin tinyint(1) NOT NULL' )
					->add_field( 'user_data text NOT NULL' )
					->add_key( 'ugrp_id' , true )
				->create_table( 'user_groups' , TRUE, $attributes );
				
				// creating login session					
				$this->dbforge
					->add_field( array(
						'usess_uacc_fk'	=>	array(
							'type'				=> 	'INT',
							'constraint' 		=> 	11,
							'null'				=>	false,
						),
						'usess_token'	=>	array(
							'type'				=> 	'VARCHAR',
							'constraint' 		=> 	100,
							'null'				=>	false,
							'primary'			=>	true
						)
					) )
					->add_field( 'usess_series varchar(40) NOT NULL' )					
					->add_field( 'usess_login_date datetime NOT NULL' )
					->add_key( 'usess_token' , true )
				->create_table( 'user_login_sessions' , TRUE, $attributes );
				
				// ALTER TABLE `tendoo_user_login_sessions` ADD UNIQUE(`usess_token`)
				
				// creating user privilèges
					
				$this->dbforge
					->add_field( array(
						'upriv_id'	=>	array(
							'type'				=> 	'INT',
							'constraint' 		=> 	11,
							'null'				=>	false,
							'auto_increment'	=>	true,
							'primary'			=>	true
						)
					) )
					->add_field( 'upriv_name varchar(40) NOT NULL' )
					->add_field( 'upriv_desc varchar(100) NOT NULL' )
					->add_key( 'upriv_id' , true )
				->create_table( 'user_privileges' , TRUE, $attributes );
				
				// creating user privilèges					
				$this->dbforge
					->add_field( array(
						'upriv_users_id'	=>	array(
							'type'				=> 	'INT',
							'constraint' 		=> 	11,
							'null'				=>	false,
							'auto_increment'	=>	true,
							'primary'			=>	true
						)
					) )
					->add_field( 'upriv_users_uacc_fk int(11) NOT NULL' )
					->add_field( 'upriv_users_upriv_fk smallint(5) NOT NULL' )
					->add_key( 'upriv_users_id' , true )
					->add_key( 'upriv_users_uacc_fk' )
					->add_key( 'upriv_users_upriv_fk' )
				->create_table( 'user_privilege_users' , TRUE, $attributes );
								
				// creating user privilèges group
					
				$this->dbforge
					->add_field( array(
						'upriv_groups_id'	=>	array(
							'type'				=> 	'INT',
							'constraint' 		=> 	11,
							'null'				=>	false,
							'auto_increment'	=>	true,
							'primary'			=>	true
						)
					) )
					->add_field( 'upriv_groups_ugrp_fk int(11) NOT NULL' )
					->add_field( 'upriv_groups_upriv_fk smallint(5) NOT NULL' )
					->add_key( 'upriv_groups_id' , true )
					->add_key( 'upriv_groups_ugrp_fk' )
					->add_key( 'upriv_groups_upriv_fk' )
				->create_table( 'user_privilege_groups' , TRUE, $attributes );
				// populating flexi
				$this->load->library( 'flexi_auth' );
				// Creating Group
				$this->flexi_auth->insert_group( __( 'Administrators' ) , __( 'Adminitrators Group' ), true , array() );
				$this->flexi_auth->insert_group( __( 'Users' ) , __( 'Users Group' ), false , array() );
				// Creating privileges
				$this->flexi_auth->insert_privilege( __( 'Dashboard Access' ), __( 'Master priilege' ), array() );
				// bind privilege to a group
				$this->flexi_auth->insert_user_group_privilege( 1,  1 ); // administrator can access dashboard
				// creating config file
				$this->create_config_file( $config );
				
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
		$this->load->model( 'options' );
		$this->load->library( 'session' );
		$this->load->library( 'flexi_auth' );
		
		// checks user and email availability
		if( ! $this->flexi_auth->identity_available( $username ) ) : return 'username-used'; endif;
		if( ! $this->flexi_auth->identity_available( $email ) ) : return 'email-used'; endif;
		
		// set site_name
		$this->options->set( 'site-name' , $site_name );
		
		// Create user
		if( $this->flexi_auth->insert_user( $email, $username, $password, array() , 1 , true ) ); // set to group 1 as
		{
			$this->flexi_auth->insert_privilege_user( 1 , 1 );// creating master
			return 'user-created';
		}
		return 'unexpected-error';
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