<?php
if(class_exists($Class.'_frontend'))
{
	if($Teurmola[0] == 'tendoo') // Not ready for SELF_URL_HANDLE
	{
		$this->data['page'] 		=		array(array(
			'PAGE_NAME'				=>		'Tendoo Url Module Launcher',
			'PAGE_CNAME'			=>		$Teurmola[0].'@'.$Teurmola[1],
			'PAGE_TITLE'			=>		'Tendoo Url Module Launcher',
			'PAGE_DESCRIPTION'		=>		'',
			'PAGE_MAIN'				=>		'FALSE',
			'PAGE_PARENT'			=>		'FALSE'
		));
		$this->load->library('users_global'); // 0.9.4
		$theme						=	get_core_vars('active_theme_object'); // Added - Tendoo 0.9.2
		// GLOBAL MODULES
		$GlobalModule				=&	$this->data['GlobalModule'];
		if(is_array($GlobalModule))
		{
			foreach($GlobalModule as $g)
			{
				$this->tendoo->interpreter($g['NAMESPACE'].'_frontend',$Method,$Parameters); // We do not control if there is 404 result.
			}
		}
		if($this->tendoo->interpreter($Class.'_frontend',$Method,$Parameters) === '404')
		{
			$this->tendoo->error('page404');
		}
	}
	else
	{
		// Revisé 1.3
		// $this->load->library('users_global'); // 0.9.4
		// $theme			=	get_core_vars( 'active_theme_object' ); // Added - Tendoo 0.9.2
		// Les modules de type APP ne possè en principe aucune interface utilisateur pour le frontend, la gestion des erreur des requetes n'est donc pas prise en charge.
		if(is_array( get_core_vars( 'app_module' ) ))
		{
			foreach( get_core_vars( 'app_module' ) as $_module )
			{
				$this->tendoo->interpreter( $_module[ 'namespace' ] . '_frontend' , $Method , $Parameters ); // We do not control if there is 404 result.
			}
		}	
		// Initialisation des modules simple.
		// Ce module utilisent l'obect get_core_vars( 'active_theme_object' ); et génèrent une vue.
		if($this->tendoo->interpreter( $Class . '_frontend' , $Method , $Parameters , array() , get_core_vars('module') ) === '404' )
		{
			$this->tendoo->error( 'page404' );
		}
	}
}
else if(class_exists('Tendoo_'.$Class))
{
	if($this->tendoo->interpreter('Tendoo_'.$Class,$Method,$Parameters) === '404')
	{
		$theme						=	get_core_vars('active_theme_object'); // Added - Tendoo 0.9.2
		// GLOBAL MODULES
		$this->tendoo->error('page404');
	}
}
else if(class_exists($Class))
{
	if($this->tendoo->interpreter($Class,$Method,$Parameters) === '404')
	{
		$this->tendoo->error('page404');
	}
	// var_dump($this->db);
}
else
{
	$this->tendoo->error('page404_or_moduleBug');
}