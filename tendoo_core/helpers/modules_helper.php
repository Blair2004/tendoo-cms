<?php
/***
**	Déclaration d'un module
**/
function set_core_mode( $mode ){ // allowed Install|Normal
	if( in_array( $mode , array( 'maintenance' , 'normal' ) ) ){
		set_core_vars( 'core_mode' , $mode );
	}
}
function declare_module( $namespace , $config ){
	if( get_core_vars( 'core_mode' ) == 'maintenance' ){
		$declared_modules	=	is_array( $declared_modules = get_core_vars( 'maintenance_declared_modules' ) ) ? $declared_modules : array();
		$declared_modules[ $namespace ] =	$config;
		set_core_vars( 'maintenance_temp_declared_module' , $namespace );
		return set_core_vars( 'maintenance_declared_modules' , $declared_modules );
	} else {
		$declared_modules	=	is_array( $declared_modules = get_core_vars( 'declared_modules' ) ) ? $declared_modules : array();
		$declared_modules[ $namespace ] =	$config;
		set_core_vars( 'temp_declared_module' , $namespace );
		return set_core_vars( 'declared_modules' , $declared_modules );
	}
}
/**
*	get_module()
**/
function get_modules( $filter = 'filter_namespace' , $namespace = null , $limit = null)
{
	$declared_modules	=	get_core_vars( 'declared_modules' );
	if( $filter == 'filter_active' )
	{
		$actives		=	array();
		foreach( $declared_modules as $_module ){
			if( $_module[ 'active' ] == true ){
				$actives[]	=	$_module;
			}
		}
		return $actives;
	}
	else if( $filter == 'filter_unactive' )
	{
		$actives		=	array();
		foreach( $declared_modules as $_module ){
			if( $_module[ 'active' ] == false ){
				$actives[]	=	$_module;
			}
		}
		return $actives;
	}
	else if( $filter == 'from_maintenance_mode' )
	{
		return get_core_vars( 'maintenance_declared_modules' );
	}
	else if( $filter == 'filter_active_unapp' )
	{
		$filtred	=	get_modules( 'filter_active' );
		// Create A loopable List
		$the_list	=	array();
		$the_list_index	=	0;
		foreach( $filtred as $_filtred ){
			if( $_filtred[ 'handle' ] != 'APP' ){
				$the_list[ $the_list_index ] = $_filtred;
				$the_list_index++;
			}
			if( !is_numeric( $namespace ) && $namespace != null && $namespace == $_filtred[ 'namespace' ]){
				return $_filtred;
			}
		}
		// Module introuvable parmi les non application
		if( !is_numeric( $namespace ) && $namespace != null ){
			return false;
		}
		// Lorsque la limitation est activée
		if( is_numeric( $namespace ) && is_numeric( $limit ) ){
			if( riake( $namespace , $the_list ) ){
				$index		=	0;
				$actives	=	array();	
				foreach( $the_list as $_module ){
					if( $index <= $limit ){ // namespace as int
						$actives[]	=	$_module;
					} else {
						break;
					}
					$index++;
				}
				return $actives;
			}
		} else {
			return $the_list;
		}
		return false;
	}
	else if( $filter == 'filter_active_app' )
	{
		$filtred	=	get_modules( 'filter_active' );
		// Create A loopable List
		$the_list	=	array();
		$the_list_index	=	0;
		foreach( $filtred as $_filtred ){
			if( $_filtred[ 'handle' ] == 'APP' ){
				$the_list[ $the_list_index ] = $_filtred;
				$the_list_index++;
			}
			if( !is_numeric( $namespace ) && $namespace != null && $namespace == $_filtred[ 'namespace' ]){
				return $_filtred;
			}
		}
		// Module introuvable parmi les non application
		if( !is_numeric( $namespace ) && $namespace != null ){
			return false;
		}
		// Lorsque la limitation est activée
		if( is_numeric( $namespace ) && is_numeric( $limit ) ){
			if( riake( $namespace , $the_list ) ){
				$index		=	0;
				$actives	=	array();	
				foreach( $the_list as $_module ){
					if( $index <= $limit ){ // namespace as int
						$actives[]	=	$_module;
					} else {
						break;
					}
					$index++;
				}
				return $actives;
			}
		} else {
			return $the_list;
		}
		return false;
	}
	else if( $filter == 'filter_active_namespace' ) // Filter Active Using Specific Namespace
	{
		$filtred	=	get_modules( 'filter_active' );
		// Create A loopable List
		$the_list	=	array();
		$the_list_index	=	0;
		foreach( $filtred as $_filtred ){
			if( $_filtred[ 'active' ] == true && $_filtred[ 'namespace' ] == $namespace ){
				return $_filtred;
			}
		}
		return false;
	}
	else if($filter == 'filter_namespace')
	{
		return riake( $namespace , $declared_modules );
	}
	else if( $filter == 'all' ){
		return $declared_modules;
	}
	else if( in_array( $filter , array( 'list_filter_active' , 'list_all' , 'list_filter_unactive' ) ) && is_numeric( $namespace ) && is_numeric( $limit ) ){
		$filter		=	substr( $filter , 5 );
		$filtred	=	get_modules( $filter );
		// Create A loopable List
		$the_list	=	array();
		$the_list_index	=	0;
		foreach( $filtred as $_filtred ){
			$the_list[ $the_list_index ] = $_filtred;
			$the_list_index++;
		}
		if( riake( $namespace , $the_list ) ){
			$index		=	0;
			$actives	=	array();	
			foreach( $the_list as $_module ){
				if( $index <= $limit ){ // namespace as int
					$actives[]	=	$_module;
				} else {
					break;
				}
				$index++;
			}
			return $actives;
		}
		return false;
	}
}
/***
**	load_modules
**/
function load_modules(){
	$module_dir	=	opendir( MODULES_DIR );
	while( FALSE !== ( $dir	=	readdir( $module_dir ) ) ){
		if( !in_array( $dir , array( '.' , '..' ) , true ) && is_dir( MODULES_DIR . $dir ) ){
			if( file_exists( $file	= MODULES_DIR . $dir . '/config.php' ) ){
				include_once( $file );
				// Récupération du dernier module chargé
				$lastest_declared	=	get_core_vars( 'temp_declared_module' );
				$active_modules		=	is_array( $active_modules = get_meta( 'active_modules' ) ) ? $active_modules : array();
				$is_active			=	in_array( $lastest_declared , $active_modules );
				$icon				=	is_file(  $icon = MODULES_DIR . $dir . '/app_icon.png' ) ? $icon : 
										is_file(  $icon = MODULES_DIR . $dir . '/app_icon.jpg' ) ? $icon : "";
				_set_module_vars( $lastest_declared , 'uri_path' , MODULES_DIR . $dir . '/' );
				_set_module_vars( $lastest_declared , 'url_path' , get_instance()->url->main_url() . MODULES_DIR . $dir . '/' );
				_set_module_vars( $lastest_declared , 'encrypted_dir' , $dir );
				_set_module_vars( $lastest_declared , 'namespace' , $lastest_declared );
				_set_module_vars( $lastest_declared , 'active' , $is_active );
				_set_module_vars( $lastest_declared , 'icon' , $icon );
			}
		}
	}
}
/***
**	push_module_action
**/
function push_module_action( $namespace , $array ){
	if( get_core_vars( 'core_mode' ) == 'maintenance' ){
		$declared_modules	=	get_core_vars( 'maintenance_declared_modules' );
		$declared_modules[ $namespace ][ 'declared_actions' ][] =	$array;
		return set_core_vars( 'maintenance_declared_modules' , $declared_modules );
	} else {
		$declared_modules	=	get_core_vars( 'declared_modules' );
		$declared_modules[ $namespace ][ 'declared_actions' ][] =	$array;
		return set_core_vars( 'declared_modules' , $declared_modules );
	}
}
/***
**	_set_module_array
**/
function _get_module_declaration_prefix(){
	if( get_core_vars( 'core_mode' ) == 'maintenance' ){
		return 'maintenance_';
	}
}
function _set_module_array( $namespace , $key , $value ){
	$declared_modules	=	get_core_vars( _get_module_declaration_prefix() . 'declared_modules' );
	$declared_modules[ $namespace ][ $key ][] =	$value;
	return set_core_vars( _get_module_declaration_prefix() . 'declared_modules' , $declared_modules );
}
function _set_module_vars( $namespace , $key , $value ){
	$declared_modules	=	get_core_vars( _get_module_declaration_prefix() . 'declared_modules' );
	$declared_modules[ $namespace ][ $key ] =	$value;
	return set_core_vars( _get_module_declaration_prefix() . 'declared_modules' , $declared_modules );
}
/**
*	push_module_sql
**/
function push_module_sql( $namespace , $array ){
	return _set_module_array( $namespace , 'sql_queries' , $array );
}
/**
*	module_icon
**/
function module_icon( $namespace )
{
	$app	=	get_modules( 'filter_namespace' , $namespace );
	if($app)
	{
		$file	=	$app[ 'uri_path' ].'/app_icon.';
		foreach(array('png','jpg','gif') as $g)
		{
			if(is_file($file.$g))
			{
				return get_instance()->url->main_url().$file.$g;
			}
		}
	}
	return false;
}
/**
* 
**/
function unactive_module( $namespace ){
	$active_modules			=	is_array( $active_modules = get_meta( 'active_modules' ) ) ? $active_modules : array();
	if( $is_active			=	in_array( $namespace , $active_modules ) ){
		foreach( $active_modules as $key => $value ){
			if( $value == $namespace ){
				unset( $active_modules[ $key ] );
			}
		}
		return set_meta( 'active_modules' , $active_modules );
	}
	return false;
}
function active_module( $namespace ){
	$active_modules			=	is_array( $active_modules = get_meta( 'active_modules' ) ) ? $active_modules : array();
	if( FALSE === ( $is_active			=	in_array( $namespace , $active_modules ) ) ){
		$active_modules[]	=	$namespace;
		return set_meta( 'active_modules' , $active_modules );
	}
	return false;
}
function uninstall_module( $namespace ){
	$module	= get_modules( 'filter_namespace' , $namespace );
	return get_instance()->tendoo_admin->drop( $module[ 'uri_path' ] );
}
/**
	*	module assets url, renvoi le chemin d'accès vers le dossier du module actif (actuellement ouvert depuis l'interface d'admininstration), à utiliser uniquement dans l'environnement du module.
	**/
	function module_assets_url($segments)
	{
		$instance	=	get_instance();
		if(isset($instance->data))
		{
			if($module = get_core_vars( 'opened_module' ) )
			{
				if(is_array($segments))
				{
					return $instance->url->main_url() . $module[ 'uri_path' ] . '/' . $instance->url->array2Url($segments);
				}
				else
				{
					return $instance->url->main_url() . $module[ 'uri_path' ] . '/' . $segments;
				}
			}
		}
		return false;
	}
	/**
	*	module_include('module_namespace','path');
	*	utilise la méthode include_once pour un fichier contenu dans le dossier du module dont l'espace nom est fourni comme premier paramètre.
	**/
	function module_include($mod_namespace,$path)
	{
		$instance	=	get_instance();
		if(isset($instance->tendoo_admin))
		{
			$_module	=	get_modules( 'filter_namespace' , $mod_namespace );
			if($_module)
			{
				include_once( $_module[ 'uri_path' ] . '/' . $mod_namespace);
			}
		}
		return false;
	}
	/**
	*	Module action
	*	Vérifie l'accès à une action d'un module pour le privilège en cours (Celui utilisé par l'utilisateur courant, voir "current_user").
	**/
	function module_action($mod_namespace,$mod_action)
	{
		$instance	=	get_instance();
		if(SCRIPT_CONTEXT	== 	'ADMIN')
		{
			return $instance->tendoo_admin->actionAccess($mod_action,$mod_namespace);
		}
		return false;
	}
	/**
	*		module_action_location
	*	Opère redirection lorsqu'une action n'est pas autorisé au privilège en cours.
	*	Le privilège en cause est celui actuellement connecté voir "current_user"
	**/
	function module_action_location($mod_namespace,$mod_action,$segment_location)
	{
		if(!module_action($mod_namespace,$mod_action))
		{
			module_location($segment_location);
		}
	}
/*
	Tendoo 0.9.8 Only
	
	Facilite l'utilisation des ressources sans nécessairement avoir besoin d'utiliser l'objet get_instance();
	module_...()
	module_url()
		Renvoie l'url du module actuellement en cours d'exécution. Fait usage des méthodes $this->instance->url... et du tableau $this->data;
*/
	
	function module_url($segments)
	{
		$instance	=	get_instance();
		if(SCRIPT_CONTEXT == 'ADMIN')
		{
			if(true == ($module	=	get_core_vars( 'opened_module' )))
			{
				if(is_array($segments))
				{
					return $instance->url->site_url('admin/open/modules/'.$module[ 'namespace' ].'/'.$instance->url->array2Url($segments));
				}
				else
				{
					return $instance->url->site_url('admin/open/modules/'.$module[ 'namespace' ].'/'.$segments);
				}
			}
		}
		else
		{
			if(true == ($page	=	get_core_vars('page')))
			{
				if(is_array($segments))
				{
					return $instance->url->site_url($page[0]['PAGE_CNAME'].'/'.$instance->url->array2Url($segments));
				}
				else
				{
					return $instance->url->site_url($page[0]['PAGE_CNAME'].'/'.$segments);
				}
			}
		}
		return false;
	}
	function module_location($segments)
	{
		$instance	=	get_instance();
		if(SCRIPT_CONTEXT == 'ADMIN')
		{
			if(get_core_vars('opened_module'))
			{
				$module	=	get_core_vars('opened_module');
				if(is_array($segments))
				{
					$baseSegments	=	array(
					'admin','open','modules',$module['namespace']);
					// Nous ajoutons les segments aux segments de base
					foreach($segments as $seg)
					{
						array_push($baseSegments,$seg);
					}
					$instance->url->redirect($baseSegments);
				}
				else
				{
					$baseSegments	=	array(
					'admin','open','modules',$module['namespace']);
					// Nous ajoutons le segment aux segments de base
					array_push($baseSegments,$segments);
					$instance->url->redirect($baseSegments);
					return $instance->url->site_url($baseSegments);
				}
			}
		}
		else
		{
			if(get_core_vars('module'))
			{
				$page	=	get_core_vars('page');
				if(is_array($segments))
				{
					$baseSegments	=	array($page[0]['PAGE_CNAME']);
					// Nous ajoutons les segments aux segments de base
					foreach($segments as $seg)
					{
						array_push($baseSegments,$seg);
					}
					$instance->url->redirect($baseSegments);
				}
				else
				{
					$baseSegments	=	array($page[0]['PAGE_CNAME']);
					// Nous ajoutons le segment aux segments de base
					array_push($baseSegments,$segments);
					$instance->url->redirect($baseSegments);
					return $instance->url->site_url($baseSegments);
				}
			}
		}
		return false;
	}