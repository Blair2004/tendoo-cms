<?php
$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( core_meta_namespace( array( 'users' , 'list' ) ) , __( 'Users' ) , 'panel-ho' )->push_to( 1 );

$rows			=	array();
$subadmin		=	get_core_vars( 'get_users' );

if(is_array($subadmin))
{
	if(count($subadmin) > 0)
	{
		foreach($subadmin as $s)
		{
			$role	=	$this->instance->roles->get( $s['REF_ROLE_ID'] );
			if( ! $role )
			{
				$priv[0]['NAME']	=	$this->instance->users_global->convertCurrentPrivilege($s['REF_ROLE_ID']);
			}
			$rows[]	=	array( 
				$s[ 'ID' ] , 
				'<a href="' . $this->instance->url->site_url(array('admin','users','edit',$s['PSEUDO'])) . '">' . $s['PSEUDO'] . '</a>' , 
				$role[0]['NAME'] , 
				$s['EMAIL'] == '' ? __( 'Unavailable' ) : $s['EMAIL'] 
			);
		}
	}
}

gui_item( array(
	'label'		=>	'Contenu',
	'type'		=>	'table-panel',
	'name'		=>	'nom',
	'id'		=>	'mon_editeur',
	'cols'		=>	array( __( 'Id' ) , __( 'Pseudo' ) , __( 'Role' ), __( 'Email' ) ),
	'rows'		=>	$rows
) )->push_to( core_meta_namespace( array( 'users' , 'list' ) ) );


$this->gui->get();
?>