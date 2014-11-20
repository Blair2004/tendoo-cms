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
			$priv	=	$this->instance->tendoo_admin->get_roles($s['PRIVILEGE']);
			if(!$priv)
			{
				$priv[0]['HUMAN_NAME']	=	$this->instance->users_global->convertCurrentPrivilege($s['PRIVILEGE']);
			}
			$rows[]	=	array( 
				$s[ 'ID' ] , 
				'<a href="' . $this->instance->url->site_url(array('admin','users','edit',$s['PSEUDO'])) . '">' . $s['PSEUDO'] . '</a>' , 
				$priv[0]['HUMAN_NAME'] , 
				$s['PRIVILEGE']	==	'USER' ? __( 'Unavailable' ) : $s['PRIVILEGE'] , 
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
	'cols'		=>	array( __( 'Id' ) , __( 'Pseudo' ) , __( 'Status' ), __( 'Role' ), __( 'Email' ) ),
	'rows'		=>	$rows
) )->push_to( core_meta_namespace( array( 'users' , 'list' ) ) );


$this->gui->get();
?>