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
                $this->refresh_user_meta();
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

    public function get_meta($key = null)
    {
        if ($key != null) {
            return riake($key, $this->meta);
        } else {
            return $this->meta;
        }
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
        $masters    =    $this->auth->list_users('master');
        if ($masters) {
            // if admin main privilège exists

            return true;
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
        if (! $group = $this->auth->get_group_id('master')) {
            $this->auth->create_group('master', __('Master Group'), true, __('Can create users, install modules, manage options'));
        }

        // Creating admin Group
        if (! $group = $this->auth->get_group_id('administrator')) {
            $this->auth->create_group('administrator', __('Admin Group'), true, __('Can install modules, manage options'));
        }

        // Create user
        if (! $group = $this->auth->get_group_id('users')) {
            $this->auth->create_group('user', __('User Group'), true, __('Just a user'));
        }
    }

    /**
     * Creae Master User
     * @param string Email
     * @param string password
     * @param string user name
     * @return string
    **/

    public function create_master($email, $password, $username)
    {
        // Create user
        if ($this->auth->create_user($email, $password, $username)) {
            // Add user to a group
            // We assume 1 is the index of the first user
            $master_id                =    $this->auth->get_user_id($email);

            $this->auth->add_member($master_id, 'master'); // assign user to one of the admin group
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

    public function create($email, $password, $username, $group_par, $user_status = '1')
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

        // User Status
        if ($user_status == '0') {
            $user            =    $this->auth->get_user($user_id);
            if( $user ) {
                $this->auth->verify_user($user_id, $user->verification_code);
            }
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

    public function edit($user_id, $email, $password, $group_id, $user_group, $old_password = null, $mode = 'edit', $user_status = '0')
    {
        $return        =    'user-updated';
        // old password has been defined
        if ($old_password != null && $mode == 'profile') {
            if ($password === $old_password):
                return 'pass-change-error';
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

            // User Status
            $user            =    $this->auth->get_user($user_id);
            if ($user_status == '0') {
                $this->auth->verify_user($user_id, $user->verification_code);
            } else if( $user_status == '1' ){
                $this->auth->ban_user($user_id);
            }
        }

        // add custom user fields
        $custom_fields    =    $this->events->apply_filters('custom_user_meta', array());

        foreach (force_array($custom_fields) as $key => $value) {
            $this->options->set($key, $value, $autoload = true, $user_id, $app = 'users');
        }
        // Refresh user meta
        $this->refresh_user_meta();

        return $return;
    }

    /**
     * Delete specified user with his meta
     *
     * @access : public
     * @param : array
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
     * @param string
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
     * Create default permission
     *
     * @return void
    **/

    public function create_permissions()
    {
        // Creating default permissions

        /**
         * Core Permission
        **/

        $this->auth->create_perm('manage_core', __('Manage Core'), __('Allow core management'));

        /**
         * Options Permissions
        **/

        $this->auth->create_perm('create_options', __('Create Options'), __('Allow option creation'));
        $this->auth->create_perm('edit_options', __('Edit Options'), __('Allow option edition'));
        $this->auth->create_perm('read_options', __('Read Options'), __('Allow option read'));
        $this->auth->create_perm('delete_options', __('Delete Options'), __('Allow option deletion.'));

        /**
         * Modules Permissions
        **/

        $this->auth->create_perm('install_modules', __('Install Modules'), __('Let user install modules.'));
        $this->auth->create_perm('update_modules', __('Update Modules'), __('Let user update modules'));
        $this->auth->create_perm('delete_modules', __('Delete Modules'), __('Let user delete modules'));
        $this->auth->create_perm('toggle_modules', __('Enable/Disable Modules'), __('Let user enable/disable modules'));
        $this->auth->create_perm('extract_modules', __('Extract Modules'), __('Let user extract modules'));

        /**
         * Users Permissions
        **/

        $this->auth->create_perm('create_users', __('Create Users'), __('Allow create users.'));
        $this->auth->create_perm('edit_users', __('Edit Users'), __('Allow edit users.'));
        $this->auth->create_perm('delete_users', __('Delete Users'), __('Allow delete users.'));

        /**
         * Profile Permission
        **/

        $this->auth->create_perm('edit_profile', __('Create Options'), __('Allow option creation'));

        /**
         * Assign Permission to Groups
        **/

        // Master
        $this->users->auth->allow_group('master', 'manage_core');

        $this->users->auth->allow_group('master', 'create_options');
        $this->users->auth->allow_group('master', 'edit_options');
        $this->users->auth->allow_group('master', 'delete_options');
        $this->users->auth->allow_group('master', 'read_options');

        $this->users->auth->allow_group('master', 'install_modules');
        $this->users->auth->allow_group('master', 'update_modules');
        $this->users->auth->allow_group('master', 'delete_modules');
        $this->users->auth->allow_group('master', 'toggle_modules');
        $this->users->auth->allow_group('master', 'extract_modules');

        $this->users->auth->allow_group('master', 'create_users');
        $this->users->auth->allow_group('master', 'edit_users');
        $this->users->auth->allow_group('master', 'delete_users');

        $this->users->auth->allow_group('master', 'edit_profile');

        // Administrators
        $this->users->auth->allow_group('administrator', 'create_options');
        $this->users->auth->allow_group('administrator', 'edit_options');
        $this->users->auth->allow_group('administrator', 'delete_options');
        $this->users->auth->allow_group('administrator', 'read_options');

        $this->users->auth->allow_group('administrator', 'install_modules');
        $this->users->auth->allow_group('administrator', 'update_modules');
        $this->users->auth->allow_group('administrator', 'delete_modules');
        $this->users->auth->allow_group('administrator', 'toggle_modules');
        $this->users->auth->allow_group('administrator', 'extract_modules');

        $this->users->auth->allow_group('administrator', 'edit_profile');

        // Users
        $this->users->auth->allow_group('user', 'edit_profile');
    }
}
