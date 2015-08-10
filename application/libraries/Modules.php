<?php
class Modules
{
	private static	$modules;
	private static $actives  = array();
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
		$actives_modules	=	force_array( get_instance()->options->get( 'actives_modules' ) );
		
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
				if( in_array( strtolower( $module[ 'application' ][ 'details' ][ 'namespace' ] ) , $actives_modules ) )
				{
					self::$actives[]	=	$module[ 'application' ][ 'details' ][ 'namespace' ];
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
		global $Options;
		// var_dump( $Options[ 'actives_modules' ] , get_instance()->options->get( 'actives_modules' ) );
		$module		=	self::get( $module_namespace );
		if( $module )
		{
			$activated_modules			=	riake( 'actives_modules' , $Options );
			if( ! in_array( $module_namespace , force_array( $activated_modules ) ) )
			{
				$activated_modules[]		=	$module_namespace;
				get_instance()->options->set( 'actives_modules' , $activated_modules , true );
				
				// Check whether cache is enabled
				if( riake( 'enable_cache' , $Options ) )
				{
					// Delete modules list cache
					get_instance()->db->cache_delete( 'dashboard' , 'modules' , 'list' );
				}
			}
		}
		// if module doesn't exists
		return false;
	}
	
	/**
	 * checks if a module is active
	 *
	 *	@access public
	 * @param string module namespace
	 * @returns bool
	**/
	
	static function is_active( $module_namespace , $fresh = false )
	{
		global $Options;
		
		if( $fresh === TRUE ){
			$activated_modules			=	riake( 'actives_modules' , $Options );
		} else {
			$activated_modules			=	self::$actives;
		}

		if( in_array( $module_namespace , force_array( $activated_modules ) , true ) )
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
		global $Options;
		$activated_modules			=	riake( 'actives_modules' , $Options );
		
		if( in_array( $module_namespace , $activated_modules ) )
		{
			$key	=	array_search( $module_namespace , $activated_modules );
			unset( $activated_modules[ $key ] );
			get_instance()->options->set( 'actives_modules' , $activated_modules , true );

			// Check whether cache is enabled
			if( riake( 'enable_cache' , $Options ) )
			{
				// Delete modules list cache
				get_instance()->db->cache_delete( 'dashboard' , 'modules' , 'list' );
			}
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
				$data = array( 'upload_data' => get_instance()->upload->data() );
				
				$extraction_temp_path		=	self::__unzip( $data );
				// Look for config.xml file to read config
				if( file_exists( $extraction_temp_path . '/config.xml' ) )
				{
					$module_array	=	get_instance()->xml2array->createArray( file_get_contents( $extraction_temp_path . '/config.xml' ) );					
					if( isset( $module_array[ 'application' ][ 'details' ][ 'namespace' ] ) )
					{
						$module_namespace	= $module_array[ 'application' ][ 'details' ][ 'namespace' ];
						$old_module = self::get( $module_namespace );
						// if module with a same namespace already exists
						if( $old_module )
						{
							if( isset( $old_module[ 'application' ][ 'details' ][ 'version' ] ) )
							{
								$old_version		=	str_replace( '.' , '' , $old_module[ 'application' ][ 'details' ][ 'version' ] );
								$new_version		=	str_replace( '.' , '' , $module_array[ 'application' ][ 'details' ][ 'version' ] );
								if( $new_version > $old_version )
								{
									$module_global_manifest	=	self::__parse_path( $extraction_temp_path );	

									if( is_array( $module_global_manifest ) )
									{
										$response	=	self::__move_to_module_dir( $module_array , $module_global_manifest[0] , $module_global_manifest[1] , $data );
										// Delete temp file
										SimpleFileManager::drop( $extraction_temp_path );
										if( $response !== true )
										{
											return $response;
										}
										else
										{
											return array( 
												'namespace'		=>	$module_array[ 'application' ][ 'details' ][ 'namespace' ],
												'msg'				=>	'module-updated'
											);
										}
									}
									// If it's not an array, return the error code.
									return $module_global_manifest;
								}
								return 'old-version-cannot-be-installed';								
							}
							
							/**
							 * Update is done only when module has valid version number
							 * Update is done only when new module version is higher than the old version
							**/
							
							return 'unable-to-update';
						}
						// if module does'nt exists
						else
						{
							$module_global_manifest	=	self::__parse_path( $extraction_temp_path );	

							if( is_array( $module_global_manifest ) )
							{
								$response	=	self::__move_to_module_dir( $module_array , $module_global_manifest[0] , $module_global_manifest[1] , $data , true );
								// Delete temp file
								SimpleFileManager::drop( $extraction_temp_path );
								if( $response !== true )
								{
									return $response;
								}
								else
								{
									return array( 
										'namespace'		=>	$module_array[ 'application' ][ 'details' ][ 'namespace' ],
										'msg'				=>	'module-installed'
									);
								}
							}
							// If it's not an array, return the error code.
							return $module_global_manifest;
						}
					}
					// Delete temp file
					SimpleFileManager::drop( $extraction_temp_path );
					return 'incorrect-config-file';
				}
				// Delete temp file
				SimpleFileManager::drop( $extraction_temp_path );
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
		get_instance()->unzip->close();
		// delete zip file
		if( is_file( $upload_details[ 'upload_data' ][ 'full_path' ] ) ): unlink( $upload_details[ 'upload_data' ][ 'full_path' ] );endif;
		return $extraction_path;
	}
	static function __parse_path( $path )
	{
		$manifest	=	array();
		$module_manifest	=	array();
		if( $dir	=	opendir( $path ) )
		{
			while( false !== ( $file	=	readdir( $dir ) ) )
			{
				if( ! in_array( $file , array( '.' , '..' ) , true ) )
				{
					// Set sub dir path
					$sub_dir_path	=	$path;
					// If a correct folder is found
					if( in_array( $file , array( 'libraries' , 'models' , 'config' , 'helpers' , 'language' ) ) && is_dir( $path . '/' . $file ) )
					{
						$manifest	=	array_merge( $manifest , self::scan( $sub_dir_path . '/' . $file ) );	
					}
					// for other file and folder, they are included in module dir
					else
					{
						$module_manifest[]	=	$sub_dir_path . '/' . $file;
					}
				}
			}
			closedir( $dir );
			// When everything seems to be alright
			return array( $module_manifest , $manifest );
		}
		return 'extraction-path-not-found';
	}

	/**
	 * Move module temp fil to valid module folder
	**/
	
	static function __move_to_module_dir( $module_array , $global_manifest , $manifest , $extraction_data , $conflict_checker = false )
	{
		if( $conflict_checker === true )
		{
			// Check first
			foreach( $manifest as $_manifest_file )
			{
				// removing raw_name from old manifest to ease copy
				$relative_path_to_file	=	explode( $extraction_data[ 'upload_data' ][ 'raw_name' ] . '/' , $_manifest_file );
				$_manifest_file			=	APPPATH . $relative_path_to_file[1];
				
				if( file_exists( $_manifest_file ) ) : return array(
					'msg'				=>		'file-conflict',
					'extra'			=>		urlencode( $_manifest_file )
				); endif;
			}
		}
		// 
		get_instance()->load->helper( 'file' );
		$folder_to_lower		=	strtolower( $module_array[ 'application' ][ 'details' ][ 'namespace' ] );
		$module_dir_path		=	APPPATH . 'modules/' . $folder_to_lower;
		if( ! is_dir( APPPATH . 'modules/' . $folder_to_lower ) )
		{
			mkdir( APPPATH . 'modules/' . $folder_to_lower , 0777 , true );
		}
		// moving global manifest
		foreach( $global_manifest as $_manifest )
		{
			// creating folder if it does'nt exists
			if( ! is_file( $_manifest ) )
			{
				$dir_name	=	basename( $_manifest );
				SimpleFileManager::copy( $_manifest , $module_dir_path . '/' . $dir_name );
			}
			else
			{
				$file_name	=	basename( $_manifest );
				write_file( $module_dir_path . '/' . $file_name , file_get_contents( $_manifest ) );
			}
		}
		$relative_json_manifest			=	array();
		// moving manifest to system folder
		foreach( $manifest as $_manifest )
		{
			// removing raw_name from old manifest to ease copy
			$relative_path_to_file	=	explode( $extraction_data[ 'upload_data' ][ 'raw_name' ] . '/' , $_manifest );
			
			if( ! is_file( $_manifest ) )
			{
				$dir_name	=	basename( $_manifest );
				SimpleFileManager::copy( $_manifest , $relative_path_to_file[1] );
			}
			else
			{
				// write file on the new folder
				write_file( APPPATH . $relative_path_to_file[1] , file_get_contents( $_manifest ) );
				// relative json manifest
				$relative_json_manifest[]	=	str_replace( '/', '\\' , APPPATH . $relative_path_to_file[1] );
			}
		}
		// Creating Manifest
		file_put_contents( $module_dir_path . '/manifest.json' , json_encode( $relative_json_manifest ) );
		return true;
	}
	
	/**
	 * Uninstall a module
	 *
	**/
	
	static function uninstall( $module_namespace )
	{
		// Disable first
		self::disable( $module_namespace );
		
		// 
		$module 			=	self::get( $module_namespace );
		$modulepath		=	dirname( $module[ 'application' ][ 'details' ][ 'main' ] );
		$manifest_file	=	$modulepath . '/manifest.json';
		
		$manifest_array	=	json_decode( file_get_contents( $manifest_file ) , true );
		// removing file
		foreach( $manifest_array as $file )
		{
			if( is_file( $file ) ): unlink( $file );endif;
		}
		// Drop Module Folder
		SimpleFileManager::drop( $modulepath );
		
		// Check whether cache is enabled
		if( get_instance()->options->get( 'enable_cache' ) )
		{
			// Delete modules list cache
			get_instance()->db->cache_delete( 'dashboard' , 'modules' , 'list' );
		}
	}
	
	static function scan( $folder )
	{
		$files_array		=	array();
		if( is_dir( $folder ) )
		{
			$folder_res	=	opendir( $folder );
			while( FALSE !== ( $file = readdir( $folder_res ) ) )
			{
				if( ! in_array( $file , array( '.' , '..' ) ) )
				{
					if( is_dir( $folder . '/' . $file ) )
					{
						$files_array	 =	array_merge( $files_array , self::scan( $folder . '/' . $file ) );
					}
					else
					{
						$files_array[]		=	$folder . '/' . $file;
					}
				}
			}
			closedir( $folder_res );
			return $files_array;
		}
		return false;
	}
	
	/**
	 * Extract an module with all his dependency
	 *
	 * @access public
	 * @param string module namespace
	 * @return void
	**/
	
	static function extract( $module_namespace )
	{
		$module = self::get( $module_namespace );
		if( $module )
		{
			get_instance()->load->library( 'zip' );
			get_instance()->load->helper( 'security' );
			$module_temp_folder_name	=	do_hash( $module_namespace );
			$module_installed_dir		=	MODULESPATH  . $module_namespace . DIRECTORY_SEPARATOR;
			// creating temp folder
			$temp_folder	=	APPPATH . 'temp' . DIRECTORY_SEPARATOR . $module_temp_folder_name;
			if( !is_dir( $temp_folder ) ){
				mkdir( $temp_folder );
			}
			// check manifest
			if( is_file( $manifest	=	$module_installed_dir . 'manifest.json' ) )
			{
				$manifest_content	=	file_get_contents( $manifest );
				$manifest_array	=	json_decode( $manifest_content );
				//var_dump( $manifest_content );
				// manifest is valid
				if( is_array( $manifest_array ) )
				{
					//var_dump( $manifest_array );
					// moving manifest file to temp folder
					foreach( array( 'models' , 'libraries' , 'language' , 'config' ) as $reserved_folder ){
						foreach( $manifest_array as $file ){
							//var_dump( $path_id_separator = APPPATH . $reserved_folder );
							if( strstr( $file , $path_id_separator = APPPATH . $reserved_folder ) ){
								// we found a a file
								$path_splited	= explode( $path_id_separator , $file );
								//var_dump( $path_splited );
								SimpleFileManager::file_copy( 
									APPPATH . $reserved_folder . $path_splited[1] , 
									$temp_folder . DIRECTORY_SEPARATOR . $reserved_folder . $path_splited[1]
								);
							}
						}
					}
					// delete temp folder
					// SimpleFileManager::drop( $temp_folder );
				}
			}
			
			// move module file to temp folder
			SimpleFileManager::copy( $module_installed_dir , $temp_folder );			

			// read temp folder and download it
			get_instance()->zip->read_dir( APPPATH . 'temp' . DIRECTORY_SEPARATOR . $module_temp_folder_name , false , APPPATH . 'temp' . DIRECTORY_SEPARATOR . $module_temp_folder_name . DIRECTORY_SEPARATOR );
			// delete temp folder
			SimpleFileManager::drop( $temp_folder );
			
			get_instance()->zip->download( $module_namespace );
			
			
		}
	}
}