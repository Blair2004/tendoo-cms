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
    
    private static $group_permission;
    
    public static function can($permission)
    {
        if (isset(self::$group_permission[ $permission . '-' . $Group[0]->group_id ])) {
            return self::$group_permission[ $permission . '-' . $Group[0]->group_id ];
        } else {
            $Instance    =    get_instance();
            $Group        =    Group::get();
            self::$group_permission[ $permission . '-' . $Group[0]->group_id ]    =    $Instance->auth->is_group_allowed($permission, $Group[0]->group_id);
            return self::$group_permission[ $permission . '-' . $Group[0]->group_id ];
        }
    }
    
    /**
     * Create User Permission
     * 
     * @params string permission
     * @params string definition
     * @return bool
    **/
    
    public static function create_permission($permission, $definition, $is_admin = false, $description = '')
    {
        return get_instance()->auth->create_perm($permission, $definition, $is_admin, $description);
    }
    
    /**
     * Delete User Permission
     * 
     * @params int user id,
     * @return bool
    **/
    
    public static function delete_permission($permission)
    {
        return get_instance()->auth->delete_perm($perm_par);
    }
    
    /**
     * Update User Permission
     * 
     * @params int user id,
     * @params string name
     * @params string definition
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
}
