<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$complete_users    =    array();
// adding user to complete_users array
foreach ($users as $user) {
    $complete_users[]    =    array(
        $user->user_id ,
        '<a href="' . site_url(array( 'dashboard', 'users', 'edit', $user->user_id )) . '">' . $user->user_name . '</a>' ,
        $user->group_name,
        $user->group_description,
        $user->email ,
        $user->last_login,
         '<a href="' . site_url(array( 'dashboard', 'users', 'delete', $user->id )) . '">' . __('Delete') . '</a>' ,
    );
}

$this->Gui->col_width(1, 4);

$this->Gui->add_meta(array(
    'namespace'    =>    'user-list',
    'title'        =>    __('List'),
    'pagination'=>    array( true ),
    'col_id'    =>    1,
    'type'        =>    'box-primary'
));

$this->Gui->add_item(array(
    'type'        =>    'table',
    'cols'        =>    array( __('User Id'), __('Username'), __('Role'), __('Role description'), __('Email'),  __('Activity'), __('Actions') ),
    'rows'        =>    $complete_users
), 'user-list', 1);

// Adding user list

$this->Gui->add_item(array(
    'type'        =>    'dom',
    'content'    =>    $pagination
), 'user-list', 1);



$this->Gui->output();
