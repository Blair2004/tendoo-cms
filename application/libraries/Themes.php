<?php 
! defined( 'APPPATH' ) ? die( 'Direct access not allowed.' ) : null;

class Themes
{
	// Hold loaded themes
	private static $themes	=	array(); 
	
	public static function load( $path )
	{
		$theme_dir	=	opendir( $path );
		while( FALSE !== ( $file = readdir( $dir ) ) )
		{
			if( $file === 'theme-config.xml' ){				
				// if index.php exists		
				if( is_file( $path . $file . '/index.php' ) || is_file( $path . $file . '/blog.php' ) ){
					// get config files
					$config		=	get_instance()->xml2array->createArray( file_get_contents( $module_path . '/' . $file ) );	
					
					// adding index and blog file to theme config
					$config[ 'files' ][ 'index' ]	=  is_file( $path . $file . '/index.php' ) ? $path . $file . '/index.php' : FALSE;
					$config[ 'files' ][ 'blog' ]	=  is_file( $path . $file . '/blog.php' ) ? $path . $file . '/blog.php' : FALSE;
				}
			} else if( is_dir( $path . $file ) ){
				self::load( $path . $file );
			}
		}
		// Adding Valid init file to module array
		// only namespace is required for a module to be valid
		if( isset( $config[ 'application' ][ 'details' ][ 'namespace' ] ) )
		{
			$namespace = strtolower( $config[ 'application' ][ 'details' ][ 'namespace' ] );
			// Saving details
			self::$themes[ $namespace ]					=	$config;
			self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ]	=	strtolower( self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ] );
		}
	}
}