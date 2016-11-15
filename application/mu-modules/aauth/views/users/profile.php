<?php
/**
 * 	File Name 	: 	create.php
 *	Description :	file for user creation form
 *	Since		:	1.4
**/

$this->Gui->col_width(1, 2);

$this->Gui->add_meta(array(
    'col_id'    =>    1,
    'namespace'    =>    'user_profile',
    'gui_saver'    =>    true,
    'custom'    =>    array(
        'action'    =>    null
    ),
    'footer'    =>    array(
        'submit'    =>    array(
            'label'    =>    __('Edit User')
        )
    )
));

// User name

$this->Gui->add_item(array(
    'type'            =>    'text',
    'label'            =>    __('User Name'),
    'name'            =>    'username',
    'disabled'        =>    true,
    'value'            =>    $this->users->current->name
), 'user_profile', 1);

// User email

$this->Gui->add_item(array(
    'type'            =>    'text',
    'label'            =>    __('User Email'),
    'name'            =>    'user_email',
    'value'            =>    $this->users->current->email
), 'user_profile', 1);

// user password

$this->Gui->add_item(array(
    'type'            =>    'password',
    'label'            =>    __('Old Password'),
    'name'            =>    'old_pass',
), 'user_profile', 1);

$this->Gui->add_item(array(
    'type'            =>    'password',
    'label'            =>    __('New Password'),
    'name'            =>    'password',
), 'user_profile', 1);

// user password config

$this->Gui->add_item(array(
    'type'            =>    'password',
    'label'            =>    __('Confirm New'),
    'name'            =>    'confirm',
), 'user_profile', 1);

// add to a group

// load custom field for user creatin

$this->events->do_action('load_users_custom_fields', array(
    'mode'            =>    'profile',
    'groups'        =>    array(),
    'meta_namespace'=>    'user_profile',
    'col_id'        =>    1,
    'gui'            =>    $this->Gui,
    'user_id'        =>    $this->users->current->id
));

$this->Gui->output();
