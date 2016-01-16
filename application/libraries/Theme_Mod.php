<?php 
! defined( 'APPPATH' ) ? die( 'Direct access not allowed.' ) : null;

class Themes
{
	// Hold loaded themes
	private static $themes	=	array(); 
	
	public static function load( $path )
	{
		$theme_dir	=	opendir( THEMESPATH );
		while( FALSE !== ( $file = readdir( $dir ) ) )
		{
			if( $file === 'theme-config.xml' )
			{
				
			}
		}
	}
}