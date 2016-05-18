<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    private $meta            =    array(); // empty meta

    public function __construct()
    {
        parent::__construct();
        
        // Loading Aauth Class 
        // @branch 1.5-auth-class
        $this->load->library('aauth',  array(),  'auth');
        
        if ($this->auth->is_loggedin()) {
            $this->refresh_user_meta();
        } else {
            // Autologin user
            if ($user_id    =    $this->input->cookie('user', true)) {
                $this->auth->login_fast($user_id);
            }
        }
    }
    
    /**
     * Refresh User Meta
     * @return void
    **/
    
    public function refresh_user_meta()
    {
        $this->meta        =    $this->options->get(null, $this->auth->get_user_id(), true);
        $this->current    =    $this->auth->get_user();
    }
    
    /**
     * Get user Meta
     * 
     * @return mixed
    **/
    
    public function get_meta($key)
    {
        return riake($key, $this->meta);
    }
    
    /**
     * Checks whether a user is connected 
     *
     *	@return : bool
    **/
    
    public function is_connected()
    {
        return $this->auth->is_loggedin();
    }
    
    /**
     * Checks if a master user exists
     *
     * @return : bool
    **/
    
    public function master_exists()
    {
        foreach ($this->config->item('master_group_label') as $group_name) {
            $masters    =    $this->auth->list_users($group_name);
            if ($masters) {
                // if admin main privilège exists

                return true;
            }
        }
        return false;
    }
    
    // Should be called by tendoo only
    /**
     * Create default Group
     * 
     * @return void
    **/
    
    public function create_default_groups()
    {
        // Only create if group does'nt exists (it's optional)
        // Creating admin Group
        foreach ($this->config->item('master_group_label') as $group_name) {
            if (! $group = $this->auth->get_group_id($group_name)) {
                $this->auth->create_group($group_name, __('Master Group'), true, __('Can create users, install modules, manage options'));
            }
        }
        
        // Creating admin Group
        foreach ($this->config->item('admin_group_label') as $group_name) {
            if (! $group = $this->auth->get_group_id($group_name)) {
                $this->auth->create_group($group_name, __('Admin Group'), true, __('Can install modules, manage options'));
            }
        }
        
        // Creating Public Group
        foreach ($this->config->item('public_group_label') as $group_name) {
            if (! $group = $this->auth->get_group_id($group_name)) {
                $this->auth->create_group($group_name, __('User Group'), false, __('Just a user'));
            }
        }
    }
    
    /**
     * Creae Master User
     * @params string Email
     * @params string password
     * @params string user name
     * @return string
    **/
    
    public function create_master($email, $password, $username)
    {
        // Create user
        if ($this->auth->create_user($email, $password, $username)) {
            // Add user to a group
            // We assume 1 is the index of the first user
            $master_id                =    $this->auth->get_user_id($email);
            
            // Fetch Master Group Name
            $master_group_array        =    $this->config->item('master_group_label');
            
            $this->auth->add_member($master_id, $master_group_array[0]); // assign user to one of the admin group
            // Send Verification

            $this->auth->send_verification($master_id);
            // Activate Master

            $users            =    $this->auth->get_user($master_id);
            $this->auth->verify_user($master_id, $users->verification_code);
            return 'user-created';
        }
        return 'unexpected-error';
    }
    
    /**
     * 	Create user with default privilege
     *  
     * 	@access : public
     *  @param : string email
     * 	@param : string password
     * 	@param : string name
     * 	@return : bool
    **/
    
    public function create($email, $password, $username, $group_par, $validate = false)
    {
        $user_creation_status    =    $this->auth->create_user($email, $password, $username);
        if (! $user_creation_status) {
            return false;
        }
        // bind user to a speciifc group
        $user_id        =    $this->auth->get_user_id($email);
        // Send Verification
        $this->auth->send_verification($user_id);
        
        // Adding to a group		
        // refresh group
        $this->auth->add_member($user_id, $group_par);
        
        // Validate User
        if ($validate == true) {
            $user            =    $this->auth->get_user($user_id);
            $this->auth->verify_user($user, $users->verification_code);
        }
        
        // add custom user fields
        $custom_fields    =    $this->events->apply_filters('custom_user_meta', array());
        foreach (force_array($custom_fields) as $key => $value) {
            $this->options->set($key, $value, $autoload = true, $user_id, $app = 'users');
        }
        
        return 'user-created';
    }
    
    /***
     * Edit user
     *
     * @access : public
     * @param
    **/
    
    public function edit($user_id, $email, $password, $group_id, $user_group, $old_password = null, $mode = 'edit')
    {
        $return        =    'user-updated';
        // old password has been defined
        if ($old_password != null && $mode == 'profile') {
            if ($password === $old_password): return 'pass-change-error';
            endif;
            // get user using old password
            $query    =    $this->db->where('id', $user_id)->where('pass', $this->auth->hash_password($old_password, $user_id))->get('aauth_users');
            // if password is correct
            if ($query->result_array()) {
                $return    =    array();
                $return[]    =    $this->auth->update_user($user_id, $email, $password);
            } else {
                return 'old-pass-incorrect';
            }
        }
        
        // This prevent editing privilege on profile dash
        if ($mode == 'edit') {
            // var_dump( $user_group );
            // remove member
            $this->auth->remove_member($user_id, $user_group->group_id);
            
            // refresh group
            $this->auth->add_member($user_id, $group_id);
            
            // Change user password and email
            $this->auth->update_user($user_id, $email, $password);
        }
                
        // add custom user fields
        $custom_fields    =    $this->events->apply_filters('custom_user_meta', array());
        
        foreach (force_array($custom_fields) as $key => $value) {
            $this->options->set($key, $value, $autoload = true, $user_id, $app = 'users');
        }
        return $return;
    }
    
    /**
     * Delete specified user with his meta
     *
     * @access : public
     * @params : array
     * @return : bool
    **/
    
    public function delete($user_id)
    {
        // delete options
        $this->options->delete(null, $user_id, 'users');
        // remove front auth class
        return $this->auth->delete_user($user_id);
    }
    /**
     * 	Log User Out
     *	@return bool
    **/
    
    public function logout()
    {
        return $this->auth->logout();
    }
    
    /**
     * Login
     * @params string
     * @return string
    **/
    
    public function login($login_fields_namespace)
    {
        $exec        =        $this->auth->login(
            $this->input->post(riake('username_or_email', $login_fields_namespace)),
            $this->input->post(riake('password', $login_fields_namespace)),
            $this->input->post(riake('keep_connected', $login_fields_namespace)) ? true : false
        );
        
        if ($this->auth->is_loggedin()) {
            return 'user-logged-in';
        }
        return 'fetch-error-from-auth';
    }
    
    /**
     * Send recovery email to an registered email
     * @params string email
     * @return string;
    **/
    
    public function do_send_recovery($email)
    {
        if ($this->auth->user_exsist_by_email($email)) {
            $exec    =    $this->auth->remind_password($email);
            return 'recovery-email-send';
        } else {
            return 'unknow-email';
        }
    }
    
    /**
     * Get user By id
     * @params int
     * @return array
    **/
    
    public function get($user_id)
    {
        $user    =    $this->auth->get_user_by_id($user_id);
        
        return farray($user);
    }
    
    /**
     * Create a new role
     *
     * @access public
     * @params string role name
     * @params string role definition
     * @params string role type
     * @return string error code
     * Deprecated
    **/
    
    public function set_group($name, $definition, $type, $mode = 'create', $group_id = 0)
    {
        $name    =    strtolower($name);
        // Check wether a group using this name exists
        $group    =    $this->auth->get_group_name($name);
        
        if ($mode === 'create') {
            if ($group === false) {
                $this->users->auth->create_group($name, $definition);
                $admin_groups        =    force_array($this->options->get('admin_groups'));
                $public_groups        =    force_array($this->options->get('public_groups'));
                // make sure to delete groups saved on option table
                if (! in_array($name, $admin_groups) &&  ! in_array($name, $public_groups)) {
                    // Saving as public group
                    if ($type === 'public') {
                        $public_groups[]    =    $name;
                        $this->options->set('public_groups', $public_groups, true);
                    }
                    // Saving as admin group
                    else {
                        $admin_groups[]    =    $name;
                        $this->options->set('admin_groups', $admin_groups, true);
                    }
                    return 'group-created';
                }
            }
        } else {
            $group_name            =    $this->auth->get_group_name($group_id);
            if ($group_name) {
                // Update group name
                $this->auth->update_group($group_id, $name);
                
                // get all groups types
                $admin_groups        =    force_array($this->options->get('admin_groups'));
                $public_groups        =    force_array($this->options->get('public_groups'));
                
                // remove from admin_groups
                array_walk($admin_groups, function (&$item, $key, $group_name) use (&$admin_groups) {
                    if ($group_name === $item) {
                        unset($admin_groups[ $key ]);
                    }
                }, $group_name);
                
                // remove from public group
                array_walk($public_groups, function (&$item, $key, $group_name) use (&$public_groups) {
                    if ($group_name === $item) {
                        unset($public_groups[ $key ]);
                    }
                }, $group_name);
                
                // make sure to delete groups saved on option table
                if (! in_array($name, $admin_groups) || ! in_array($name, $public_groups)) {
                    // Saving as public group
                    if ($type === 'public') {
                        $public_groups[]    =    $name;
                    }
                    // Saving as admin group
                    else {
                        $admin_groups[]    =    $name;
                    }
                    $this->options->set('public_groups', $public_groups, true);
                    $this->options->set('admin_groups', $admin_groups, true);

                    return 'group-updated';
                }
            }
            return 'unknow-group';
        }
        return 'group-already-exists';
    }
    
    /**
     * Create default permission
     * 
     * @return void
    **/
    
    public function create_permissions()
    {
        // Creating default permissions
        $this->auth->create_perm('manage_options', __('Manage Options'), __('Let user access settings page and to manage it.')); // index 1
        $this->auth->create_perm('manage_modules', __('Manage Modules'), __('Let user access to modules list and to manage it.')); // 2
        $this->auth->create_perm('manage_users', __('Mange Users'), __('Let user access user list and manage them.')); // index 3		

        // Master		
        $this->users->auth->allow_group('master', 'manage_options');
        $this->users->auth->allow_group('master', 'manage_modules');
        $this->users->auth->allow_group('master', 'manage_users');
        
        // Administrators
        $this->users->auth->allow_group('administrators', 'manage_options');
        $this->users->auth->allow_group('administrators', 'manage_modules');
    }
}
