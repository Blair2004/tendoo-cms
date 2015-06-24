<?php
class Modules
{
	private static	$modules;
	static function load( $module_path )
	{
		$dir	=	opendir( $module_path );
		$config	=	array();
		
		// Looping currend folder
		while( FALSE !== ( $file = readdir( $dir ) ) )
		{
			if( substr( $file , -10 ) === 'config.ini' )
			{
				$config		=	parse_ini_file( $module_path . '/' . $file );
			}
			else if( is_dir( $module_path . '/' . $file ) && ! in_array( $file , array( '.' , '..' ) ) )
			{
				self::load( $module_path . '/' .$file );
			}
		}
		// Adding Valid init file to module array
		if( $namespace = riake( 'namespace' , $config ) )
		{
			// Saving details
			self::$modules[ $namespace ]				=	$config;
			// Complete init file path
			self::$modules[ $namespace ][ 'main' ]		=	$module_path . self::$modules[ $namespace ][ 'main' ];
		}
	}
	static function get( $namespace = null )
	{
		if( $namespace == NULL )
		{
			return self::$modules;
		}
	}
	
	/**
	 * Include modules init main file defined on config.ini
	**/
	
	static function init( $actives_modules )
	{
		$modules	=	self::get();
		$modules_array	=	array();
		foreach( $modules as $module )
		{
			// $modules_array[]	=	riake( 'main' , $module ) ;
			if( is_file( $init_file = riake( 'main' , $module ) ) && in_array( $init_file , $actives_modules ) )
			{
				// Check compatibility and other stuffs
				include_once( $init_file );
			}
		}
		// get_instance()->options->set( 'active_modules' , $modules_array );	
	}
}