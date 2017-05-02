<?php
/**
 * An easy way to access Auth and User_model methods
 * @branch 1.5
 * @author Blair Jersyer
 * @since 1.5
**/
class User
{
    private static $user_par;
    private static $groups_permissions;

    public function __construct()
    {
        $groups    =    Group::get_all();

        if ($groups) {
            foreach ($groups as $group) {
                $permissions    =    get_instance()->auth->list_perms($group->id);
                foreach ($permissions as $permission) {
                    self::$groups_permissions[ $group->name ][]    =    $permission->perm_name;
                }
            }
        }
    }

    /**
     * Checks whether a user is connected
     * @access public
     * @return bool
    **/

    public static function is_connected()
    {
        $Instance    =    get_instance();
        return $Instance->users->is_connected();
    }

    public static function get($user_par = false)
    {
        return get_instance()->auth->get_user($user_par);
    }

    /**
     * Pseudo
     * retreive user pseudo
     *
     * @access public
     * @param int (optional)
     * @return string
    **/

    public static function pseudo($id = false)
    {
        $user        =    get_instance()->auth->get_user($id);
        return $user ? $user->name : __('N/A');
    }

    /**
     * Id
     * return current user id
     *
     * @access public
     * @return int
    **/

    public static function id()
    {
        $user            =    get_instance()->auth->get_user();
        return $user ? $user->id : 0;
    }

    // Permission

    /**
     * Checks whether a user is granted for a permission
     * @access public
     * @since 1.5
     * @return boolean
    **/

    private static $groups_permissionsns;

    public static function can($permission)
    {
        $group        =    Group::get();

        if (in_array($permission, self::$groups_permissions[ $group[0]->name ])) {
            return true;
        }
        return false;
    }

    /**
     * Create User Permission
     *
     * @param string permission
     * @param string definition
     * @return bool
    **/

    public static function create_permission($permission, $definition, $is_admin = false, $description = '')
    {
        return get_instance()->auth->create_perm($permission, $definition, $is_admin, $description);
    }

    /**
     * Delete User Permission
     *
     * @param int user id,
     * @return bool
    **/

    public static function delete_permission($permission)
    {
        return get_instance()->auth->delete_perm($perm_par);
    }

    /**
     * Update User Permission
     *
     * @param int user id,
     * @param string name
     * @param string definition
     * @return bool
    **/

    public static function update_permission($perm_id, $name, $definition = '', $is_admin = false, $description = '')
    {
        return get_instance()->auth->update_perm($perm_id, $name, $definition, $is_admin, $description);
    }

    /**
     * In Group
     *
     * Check whether a user belong to a specific group
     *
     * @access public
     * @param string
     * @return bool
    **/

    public static function in_group($group_name)
    {
        return get_instance()->auth->is_member($group_name);
    }

    /**
     * Get user avatar SRC
     * @return string
    **/

    public static function get_gravatar_url()
    {
        $current_user    =    self::get();
        return self::get_gravatar($current_user->email, 90);
    }

    /**
     * Get use avatar
     * @param string email
     * @param int width
     * @param string
     * @param string
     * @param bool
     * @param array atts
     * @return string avatar src/image tag
    **/

    public static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
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
        $user_creation_status    =    get_instance()->auth->create_user($email, $password, $username);
        if (! $user_creation_status) {
            return false;
        }
        // bind user to a speciifc group
        $user_id        =    get_instance()->auth->get_user_id($email);
        // Send Verification
        get_instance()->auth->send_verification($user_id);

        // Adding to a group
        // refresh group
        get_instance()->auth->add_member($user_id, $group_par);

        // Validate User
        if ($validate == true) {
            $user            =    get_instance()->auth->get_user($user_id);
            get_instance()->auth->verify_user($user, $users->verification_code);
        }

        // add custom user fields
        $custom_fields    =    get_instance()->events->apply_filters('custom_user_meta', array());
        foreach (force_array($custom_fields) as $key => $value) {
            get_instance()->options->set($key, $value, $autoload = true, $user_id, $app = 'users');
        }

        return 'user-created';
    }

}
