<?php
/**
 * 	Load Core Default Value
 * 	@since : tendoo 1.4
**/
class Load_Core_Values
{
	function __construct()
	{
		// Settings Tendoo Core Vars
		set_core_vars( 'tendoo_core_permissions' , array(
			'name'				=>	__( 'Tendoo Permissions' ),
			'declared_actions'	=>	array(
				array( 
					'action'			=>	'manage_themes',
					'action_name'		=>	__( 'Manage Themes' ),
					'action_description'=>	__( 'This permissions allow user to manage themes (activate, uninstall)' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_modules',
					'action_name'		=>	__( 'Manage Modules' ),
					'action_description'=>	__( 'This permissions allow user to manage modules (activate, uninstall)' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_controllers',
					'action_name'		=>	__( 'Manage Modules' ),
					'action_description'=>	__( 'This permissions allow user to manage controller (create, delete)' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_settings',
					'action_name'		=>	__( 'Manage Settings' ),
					'action_description'=>	__( 'This permissions allow user to manage site settings' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'install_app',
					'action_name'		=>	__( 'Install App' ),
					'action_description'=>	__( 'This permissions allow user to install app' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_roles',
					'action_name'		=>	__( 'Manage Roles' ),
					'action_description'=>	__( 'This permissions allow user to manage roles' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_users',
					'action_name'		=>	__( 'Manage Users' ),
					'action_description'=>	__( 'This permissions allow user to manage users' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_tools',
					'action_name'		=>	__( 'Manage Tools' ),
					'action_description'=>	__( 'This permissions allow user to manage tools' ),
					'mod_namespace'		=>	'system'
				)
			)
		) , 'read_only' );
		$pseudo		=	array(
			'name'	=>	'admin_pseudo',
		);
		
		// Can be filtered using "user_fields"
		register_fields( 'user_form_fields' , array(
			'name'			=>	'admin_bio'
		) );
		
		bind_filter( 'user_form_fields' , array( $this , 'user_form_fields' ) );
	}
	function user_form_fields( $field ) {
		$field[]		=	array(
			'name'			=>	'admin_bio',
			'placeholder'	=>	__( 'User Bio' ),
			'label'			=>	__( 'Bio' ),
			'type'			=>	'textarea',
			'description'	=>	__( 'User Bio' )
		);
		return $field;
	}
}