<?php
declare_module( 'tim' , array( 
	'name'				=>		__( 'Theme Option Manager' ),
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		__( 'This module let you customize your theme.' ),
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'INDEX',
	'compatible'		=>		1.3,
	'version'			=>		0.3
) ); 

push_module_action( 'tim' , array(
	'action'				=>	'tim_manage',
	'action_name'			=>	__( 'Manage Theme Option' ),
	'action_description'	=>	__( 'This permission let you manage theme options' ),
	'mod_namespace'			=>	'tim'
) );