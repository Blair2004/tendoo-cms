<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Oauth Scope
**/

$config[ 'oauth_scopes' ]    =    array(
    'profile'            =>        array(
        'label'            =>        __('Access user details'),
        'description'    =>        __('The current request would like to access user informations such as name, email, except password'),
        'app'            =>        'system',
        'icon'            =>        'fa fa-user',
        'color'            =>        'bg-aqua',
        'group'            =>        null
    ),
    'core'                =>        array(
        'label'            =>        __('Control Tendoo CMS'),
        'description'    =>        __('Give full access to modules, users and options on Tendoo CMS.'),
        'app'            =>        'system',
        'icon'            =>        'fa fa-user-secret',
        'color'            =>        'bg-red',
        'group'            =>        array( 'master', 'administrator' )
    )
);
