<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 	File Name 	: 	edit.php
 *	Description :	header file for role edition. include <html> tag and ends at </head> closing tag
 *	Since		:	1.5
**/

$this->Gui->col_width(1, 3);

// Creating Meta
$this->Gui->add_meta(array(
    'type'        =>    'box',
    'title'        =>    __('Edit a new role', 'aauth'),
    'namespace'    =>    'create_role',
    'col_id'    =>    1,
    'footer'        =>    array(
        'submit'    =>    array(
            'label'    =>    __('Edit the role', 'aauth')
        )
    ),
    'gui_saver'    =>    true,
    'custom'    =>    array(
        'action'    =>    null
    )
));

// Adding Fields
$this->Gui->add_item(array(
    'type'            =>    'text',
    'name'            =>    'role_name',
    'description'    =>    __('Edit role name', 'aauth'),
    'label'            =>    __('Role Name', 'aauth'),
    'placeholder'    =>    __('Role Name', 'aauth'),
    'value'            =>    $group->name
), 'create_role', 1);

// Is it an admin group ?
$this->Gui->add_item(array(
    'type'        =>    'select',
    'name'        =>    'role_type',
    'options'    =>    array(
        'public'    =>    __('Public', 'aauth'),
        'admin'        =>    __('Admin', 'aauth')
    ),
    'label'            =>    __('Role Type', 'aauth'),
    'placeholder'    =>    __('Role Type', 'aauth'),
    'active'            =>    $this->users->is_public_group($group->name) ? 'public' : 'admin'
), 'create_role', 1);

// var_dump( $this->users->is_public_group( $group->name ) ? 'public' : 'admin' );die;

$this->Gui->output();
