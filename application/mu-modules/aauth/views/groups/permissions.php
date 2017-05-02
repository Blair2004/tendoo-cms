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
    'title'        =>    __('Groups permissions', 'aauth'),
    'namespace'    =>    'permissions',
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

$this->Gui->output();
