<?php
/**
 * 	File Name 	: 	create.php
 *	Description :	file for user creation form
 *	Since		:	1.4
**/

$this->Gui->col_width(1, 2);

$this->Gui->add_meta(array(
    'col_id'    =>    1,
    'namespace'    =>    'edit_user',
    'gui_saver'    =>    false,
    'custom'    =>    array(
        'action'    =>    null,
        'app'        =>    'users'
    ),
    'footer'    =>    array(
        'submit'    =>    array(
            'label'    =>    __('Edit User', 'aauth')
        )
    )
));

// User name

$this->Gui->add_item(array(
    'type'            =>    'text',
    'label'            =>    __('User Name', 'aauth'),
    'name'            =>    'username',
    'disabled'        =>    true,
    'value'            =>    $user->name
), 'edit_user', 1);

// User email

$this->Gui->add_item(array(
    'type'            =>    'text',
    'label'            =>    __('User Email', 'aauth'),
    'name'            =>    'user_email',
    'value'            =>    $user->email
), 'edit_user', 1);

// user password

$this->Gui->add_item(array(
    'type'            =>    'password',
    'label'            =>    __('New Password', 'aauth'),
    'name'            =>    'password',
), 'edit_user', 1);

// user password config

$this->Gui->add_item(array(
    'type'            =>    'password',
    'label'            =>    __('Confirm New', 'aauth'),
    'name'            =>    'confirm',
), 'edit_user', 1);

// add to a group

$groups_array    =    array();

foreach ($groups as $group) {
    $groups_array[ $group->id ] = $group->definition != null ? $group->definition : $group->name;
}

$this->Gui->add_item(array(
    'type'            =>    'select',
    'label'            =>    __('Add to a group', 'aauth'),
    'name'            =>    'userprivilege',
    'options'        =>    $groups_array,
    'active'        =>     is_object($user_group) ? $user_group->group_id : null
), 'edit_user', 1);

$this->Gui->add_item(array(
    'type'        =>    'select',
    'name'        =>    'user_status',
    'label'        =>    __('User Status', 'aauth'),
    'options'    =>    array(
        'default'   =>  __( 'Default', 'aauth'),
        '0'         =>  __( 'Active' , 'aauth'),
        '1'         =>  __( 'Unactive' , 'aauth')
    ),
    'active'    =>  $user->banned
), 'edit_user',1 );

// load custom field for user creatin

$this->events->do_action('load_users_custom_fields', array(
    'mode'            =>    'edit',
    'groups'        =>    $groups_array,
    'meta_namespace'=>    'edit_user',
    'col_id'        =>    1,
    'gui'            =>    $this->Gui,
    'user_id'        =>    $user->id
));

$this->Gui->output();
