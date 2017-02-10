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
        'app'            =>        'profile',
        'icon'            =>        'fa fa-user',
        'color'            =>        'bg-aqua',
        'group'            =>        array( 'user', 'master', 'administrator' )
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

$config[ 'oauth_key_expiration_days' ]   =   7;
