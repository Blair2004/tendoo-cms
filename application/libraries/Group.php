<?php
/**
 * An easy way to handle groups
 *
 * @dependency aauth module
 * @author blair jersyer
 * @since 1.0
**/

class Group
{
    /**
     * Create group
     * let you create more group for tendoo
     * 
     * @access public
     * @param string, string, string
     * @return string
    **/
    
    public static function create($name, $definition, $is_admin, $description)
    {
        return get_instance()->auth->create_group($name, $definition, $is_admin, $description);
    }
    
    /**
     * Update Group
     * let you update existent group
     * 
     * @access group
     * @param string, string, string, int
    **/
    
    public static function update($id, $name, $definition, $is_admin, $description)
    {
        return get_instance()->auth->update_group($id, $name, $definition, $is_admin, $description);
    }
    
    /**
     * Allow Group 
     * Add a permission to a group
     * 
     * @param int Group id
     * @param int Permission id
     * @return bool
    **/
    
    public static function allow_group($group_id, $permission_id)
    {
        return get_instance()->auth->allow_group($group_id, $permission_id);
    }
    
    /**
     * Delete User Group
     * 
     * @param int Group Id
     * @return bool
    **/
    
    public static function delete_group($group_id)
    {
        return get_instance()->auth->delete_group($group_id);
    }
    
    /**
     * User Group
     *
     * @param int user id
     * @return object
    **/
    
    public static function get($user_id = null)
    {
        return get_instance()->auth->get_user_groups();
    }
    
    /**
     * Get All
     * @return Array
     *
    **/
    
    public static function get_all()
    {
        return get_instance()->auth->list_groups();
    }
}
