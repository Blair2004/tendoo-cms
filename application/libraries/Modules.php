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
			if( substr( $file , -10 ) === 'config.xml' )
			{
				$config		=	get_instance()->xml2array->createArray( file_get_contents( $module_path . '/' . $file ) );
			}
			else if( is_dir( $module_path . '/' . $file ) && ! in_array( $file , array( '.' , '..' ) ) )
			{
				self::load( $module_path . '/' .$file );
			}
		}
		// Adding Valid init file to module array
		if( isset( $config[ 'application' ][ 'details' ][ 'namespace' ] , $config[ 'application' ][ 'details' ][ 'main' ] ) )
		{
			$namespace = strtolower( $config[ 'application' ][ 'details' ][ 'namespace' ] );
			// Saving details
			self::$modules[ $namespace ]					=	$config;
			// Edit main file path
			self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'main' ]	=	$module_path . '/' .  self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'main' ];
			self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ]	=	strtolower( self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ] );
		}
	}
	static function get( $namespace = null )
	{
		if( $namespace == NULL )
		{
			return self::$modules;
		}
		return isset( self::$modules[ $namespace ] ) ? self::$modules[ $namespace ] : false; // if module exists
	}
	
	/**
	 * Include modules init main file defined on config.ini
	**/
	
	static function init( $filter )
	{
		$modules		=	self::get();
		$modules_array	=	array();
		foreach( force_array( $modules ) as $module )
		{
			// print_array( $modules );
			// Load every module when on install mode
			if( is_file( $init_file = $module[ 'application' ][ 'details' ][ 'main' ] ) && $filter === 'all' )
			{
				include_once( $init_file );
			}
			else if( is_file( $init_file = $module[ 'application' ][ 'details' ][ 'main' ] ) && $filter === 'actives' )
			{
				$actives_modules		=	force_array( get_instance()->options->get( 'actives_modules' ) );
				if( in_array( strtolower( $module[ 'application' ][ 'details' ][ 'namespace' ] ) , $actives_modules ) )
				{
					// Check compatibility and other stuffs
					include_once( $init_file );
				}
			}
		}
		// get_instance()->options->set( 'active_modules' , $modules_array );	
	}
	
	/**
	 * 	enable module using namespace
	 *		is most used by tendoo core
	**/
	
	static function enable( $module_namespace )
	{
		$activated_modules			=	get_instance()->options->get( 'actives_modules' );
		if( ! in_array( $module_namespace , $activated_modules ) )
		{
			$activated_modules[]		=	$module_namespace;
			get_instance()->options->set( 'actives_modules' , $activated_modules );
		}
		return;
	}
	
	/**
	 * checks if a module is active
	 *
	 *	@access public
	 * @param string module namespace
	 * @returns bool
	**/
	
	static function is_active( $module_namespace )
	{
		$activated_modules			=	get_instance()->options->get( 'actives_modules' );
		if( ! in_array( $module_namespace , $activated_modules ) )
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Disable module
	 *
	 * @access public
	 * @param string module namespace
	 * @return void
	**/
	
	static function disable( $module_namespace )
	{
		$activated_modules			=	get_instance()->options->get( 'actives_modules' );
		if( in_array( $module_namespace , $activated_modules ) )
		{
			$key	=	array_search( $module_namespace , $activated_modules );
			unset( $activated_modules[ $key ] );
			get_instance()->options->set( 'actives_modules' , $activated_modules );
		}
	}
	
	/**
	 * Install module
	**/
	
	static function install( $file_name )
	{
		 $config[ 'upload_path' ]        =  APPPATH . '/temp/';
		 $config[ 'allowed_types' ]		=	'zip';
		 
		 get_instance()->load->library( 'upload' , $config );
		 
		 if ( ! get_instance()->upload->do_upload( $file_name ) )
		 { 
				get_instance()->notice->push_notice( get_instance()->lang->line( 'fetch-from-upload' ) );
		 }
		 else
		 {
				$data = array( 'upload_data' => get_instance()->upload->data());
				$extraction_temp_path		=	self::__unzip( $data );
				// Look for config.xml file to read config
				if( file_exists( $extraction_temp_path . '/config.xml' ) )
				{
					$module_array	=	get_instance()->xml2array->createArray( file_get_contents( $module_path . '/' . $file ) );					
					if( isset( $module_array[ 'application' ][ 'details' ][ 'namespace' ] ) )
					{
						$module_namespace	= $module_array[ 'application' ][ 'details' ][ 'namespace' ];
						$old_module = self::get( $module_namespace );
						// if module with a same namespace already exists
						if( $old_module && true == false ) // disabling update
						{
							if( isset( $old_module[ 'application' ][ 'details' ][ 'version' ] ) )
							{
								
							}
						}
						// if module does'nt exists
						else
						{
							self::__parse_path( $extraction_temp_path );	
						}
					}
					return 'incorrect-config-file';
				}
				return 'config-file-not-found';
		 }
	}
	
	static function __unzip( $upload_details )
	{
		$extraction_path		=	$upload_details[ 'upload_data' ][ 'file_path' ] . $upload_details[ 'upload_data' ][ 'raw_name' ];
		get_instance()->load->library( 'unzip' );	
		get_instance()->unzip->extract( 
			$upload_details[ 'upload_data' ][ 'full_path' ] , 
			$extraction_path
		);
		return $extraction_path;
	}
	static function __parse_path( $path )
	{
		if( $dir	=	opendir( $path ) )
		{
			while( false !== ( $file	=	readdir( $dir ) ) )
			{
				if( ! in_array( $file , array( '.' , '..' ) , true ) )
				{
					
				}
			}
		}
		return 'extraction-path-not-found';
	}
}