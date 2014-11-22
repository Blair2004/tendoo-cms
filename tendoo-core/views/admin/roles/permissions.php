<?php
$this->gui->cols_width( 1 , 4 );

// Unique meta box
// var_dump( $get_roles );

// get modules permissions

foreach( force_array( $get_roles ) as $_role )
{
	$this->gui->set_meta( array(
		'type'			=>		'panel',
		'namespace'		=>		core_meta_namespace( array( 'roles' , 'permissions' , riake( 'ID' , $_role ) ) ),
		'title'			=>		riake( 'NAME' , $_role ),
		'form_wrap'		=>		array(
			'method'	=>		'post',
			'submit_text'	=>	__( 'Save Role Permissions' )
		)
	) )->push_to( 1 );

	foreach( force_array( $get_modules ) as $key => $_modules )
	{
		$checked	=	$name	=	$text	= 	$value	=	array();
		foreach( force_array( $_modules[ 'declared_actions' ] ) as $_actions )
		{
			$checked[]		=	$this->roles->can( riake( 'ID' , $_role ) , $_actions[ 'mod_namespace' ] . '@' . $_actions[ 'action' ] );
			$value[]		=	$_actions[ 'mod_namespace' ] . '@' . $_actions[ 'action' ];
			$name[]			=	'roles_permissions[]';
			$text[]			=	$_actions[ 'action_name' ];
		}
		$this->gui->set_item( array( 'type' => 'title' , 'title' =>	$_modules[ 'name' ] ) )->push_to( core_meta_namespace( array( 'roles' , 'permissions' , riake( 'ID' , $_role ) ) ) );
		$this->gui->set_item( array(
			'type'		=>	'checkbox',
			'name'		=>	$name,
			'value'		=>	$value,
			'label'		=>	$text,
			'checked'	=>	$checked
		) )->push_to( core_meta_namespace( array( 'roles' , 'permissions' , riake( 'ID' , $_role ) ) ) );
	}
	$this->gui->set_item( array(
		'type'		=>	'hidden',
		'name'		=>	'role_id',
		'value'		=>	riake( 'ID' , $_role )
	) )->push_to( core_meta_namespace( array( 'roles' , 'permissions' , riake( 'ID' , $_role ) ) ) );;
}

$this->gui->get();