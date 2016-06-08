<?php
class aauth_setup extends CI_model
{
    public function __construct()
    {
        $this->events->add_action('tendoo_settings_tables', array( $this, 'sql' ));
        $this->events->add_action('tendoo_settings_final_config', array( $this, 'final_config' ));
        $this->events->add_action('tendoo_settings_tables', array( $this, 'settings_tables' ));
        $this->events->add_action('tendoo_setup', array( $this, 'tendoo_setup' ));
    }
    
    /**
     * Set groupes
     *
     * @return void
    **/
    
    public function settings_tables()
    {
        $this->load->model('Users_Model', 'users');
        $this->users->create_default_groups();
        $this->users->create_permissions();
    }
    
    /**
     * Tendoo Setup
     * Checks if there is a master user
     *
     * @return void
    **/
    
    public function tendoo_setup()
    {
        // If a master already exists, 
        if ($this->users->auth->has_member('master')) {
            redirect(array( 'sign-in?notice=access-denied' ));
        }
    }
    
    /**
     * Final config
     *
     * @return void
    **/
    
    public function final_config()
    {
        // Creating Master & Groups
        $create_user    =    $this->users->create_master(
            $this->input->post('email'),
            $this->input->post('password'),
            $this->input->post('username')
        );
        
        if ($create_user != 'user-created') {
            $this->events->add_filter('validating_tendoo_setup', array( $this, 'preparing_errors' ));
        }
    }
    
    public function preparing_errors()
    {
        if (is_array($this->users->auth->errors)) {
            foreach ($this->users->auth->errors as $error) {
                $this->notice->push_notice(tendoo_error($error));
            }
        }
    }
    
    public function sql($config)
    {
        // let's set this module active
        Modules::enable('aauth');
        
        extract($config);
        // Creatin Auth Group
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_groups`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_groups` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(100),
		  `definition` text,
		  `description` text,
		  `is_admin` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;");
        
        // Creating Auth Permission
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_perms`;");
        $this->db->query("
		CREATE TABLE `{$database_prefix}aauth_perms` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(100),
		  `definition` text,
		  `description` text,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
        
        // Creating Permission to Group
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_perm_to_group`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_perm_to_group` (
		  `perm_id` int(11) unsigned NOT NULL,
		  `group_id` int(11) unsigned NOT NULL,
		  PRIMARY KEY (`perm_id`,`group_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth Permission to User
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_perm_to_user`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_perm_to_user` (
		  `perm_id` int(11) unsigned NOT NULL,
		  `user_id` int(11) unsigned NOT NULL,
		  PRIMARY KEY (`perm_id`,`user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth PMS
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_pms`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_pms` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `sender_id` int(11) unsigned NOT NULL,
		  `receiver_id` int(11) unsigned NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `message` text,
		  `date` datetime DEFAULT NULL,
		  `read` tinyint(1) DEFAULT '0',
		  PRIMARY KEY (`id`),
		  KEY `full_index` (`id`,`sender_id`,`receiver_id`,`read`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // System Variables
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_system_variables`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_system_variables` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `key` varchar(100) NOT NULL,
		  `value` text,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth User Table
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_users`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_users` (
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
		) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        
        // User Auth Group
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_user_to_group`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_user_to_group` (
		  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
		  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
		  PRIMARY KEY (`user_id`,`group_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth User Variable
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}aauth_user_variables`;");
        $this->db->query("CREATE TABLE `{$database_prefix}aauth_user_variables` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) unsigned NOT NULL,
		  `key` varchar(100) NOT NULL,
		  `value` text,
		  PRIMARY KEY (`id`),
		  KEY `user_id_index` (`user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }
}
new aauth_setup;
