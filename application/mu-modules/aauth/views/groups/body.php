<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->Gui->col_width(1, 4);

$this->Gui->add_meta(array(
    'namespace'        =>    'role_list',
    'title'            =>    __('Role List', 'aauth'),
    'col_id'        =>    1,
    'footer'        =>    array(
        //'pagination'	=>	array( true )
    ),
    'type'            =>    'box'
));

$group_array        =    array();
foreach (force_array($groups) as $group) {
    ob_start();
    $permissions    =    $this->users->auth->list_perms($group->id);
    foreach ($permissions as $perm) {
        $colors        =    array( 'bg-red' , 'bg-green' , 'bg-yellow' , 'bg-blue' );
        ?>
   <span class="label bg-blue"><?php echo $perm->perm_name;
        ?></span>
   <?php

    }
    $label_permissions    =    ob_get_clean();
    $group_array[]    =    array(
        // '<a href="' . site_url( array( 'dashboard' , 'groups' , 'edit' , $group->id ) ) . '">' . $group->name . '</a>',
        $group->name,
        $group->definition,
        $group->is_admin == 1 ? __('Yes', 'aauth') : __('No', 'aauth'),
        $label_permissions
    );
}

$this->Gui->add_item(array(
    'type'            =>    'table',
    'cols'            =>    array( __('Role name', 'aauth'), __('Description', 'aauth'), __('Admin', 'aauth'), __('Permissions', 'aauth') ),
    'rows'            =>    $group_array
), 'role_list', 1);

$this->Gui->output();
