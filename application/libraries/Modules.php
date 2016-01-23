<?php
class Modules
{
	private static	$modules;
	private static $actives  = array();
	/**
	 * Load Modules
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    name date
	 * @param        string $module_path
	 * @param		  int $deepness
	 * @since        3.0.1
	 */
	static function load( $module_path , $deepness = 0 )
	{
		if( $deepness < 2 ){ // avoid multi-folder parsing
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
					self::load( $module_path . '/' .$file , $deepness + 1 ); // Only top folder are parsed
				}
			}
			// Adding Valid init file to module array
			// only namespace is required for a module to be valid
			if( isset( $config[ 'application' ][ 'details' ][ 'namespace' ] ) )
			{
				$namespace = strtolower( $config[ 'application' ][ 'details' ][ 'namespace' ] );
				// Saving details
				self::$modules[ $namespace ]					=	$config;
				// Edit main file path
				if( isset( $config[ 'application' ][ 'details' ][ 'main' ] ) ){
					self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'main' ]	=	$module_path . '/' .  self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'main' ];
				}
				self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ]	=	strtolower( self::$modules[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ] );
			}
			
			// Check for language directory
			/** 
			 * Module namespace is used as text domain
			**/
			// @since 3.0.5
			if( isset( $config[ 'application' ][ 'details' ][ 'language' ] ) ) {
				if( is_dir( APPPATH . 'modules/' . $namespace . '/' . $config[ 'application' ][ 'details' ][ 'language' ] ) ) {
					$text_domain 	=	get_instance()->config->item( 'text_domain' );
					$text_domain[ $namespace ]	 =	APPPATH . 'modules/' . $namespace . '/' . $config[ 'application' ][ 'details' ][ 'language' ];
					get_instance()->config->set_item( 'text_domain', $text_domain );
				}
			}
		}
	}
	
	/**
	 * HashDirectory
	 * 
	 * Provide a hashed name for a defined path
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $directory
	 * @since        3.0.1
	 * @return 		  var
	 */
	static function hashDirectory($directory)
	{
		 if (! is_dir($directory))
		 {
			  return false;
		 }
	 
		 $files = array();
		 $dir = dir($directory);
	 
		 while (false !== ($file = $dir->read()))
		 {
			  if ($file != '.' and $file != '..')
			  {
					if (is_dir($directory . '/' . $file))
					{
						 $files[] = self::hashDirectory($directory . '/' . $file);
					}
					else
					{
						 $files[] = md5_file($directory . '/' . $file);
					}
			  }
		 }
	 
		 $dir->close();
	 
		 return md5(implode('', $files));
	}
	
	/**
	 * Get
	 * 
	 * Get a module using namespace provided as unique parameter
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $namespace module namespace string
	 * @since        3.0.1
	 * @return 		  bool|array
	 */
	static function get( $namespace = null )
	{
		if( $namespace == NULL )
		{
			return self::$modules;
		}
		return isset( self::$modules[ $namespace ] ) ? self::$modules[ $namespace ] : false; // if module exists
	}
	
	/**
	 * Init
	 * 
	 * Init module or modules using defined filters and parameter
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string filter
	 * @param 		  string module namespace
	 * @since        3.0.1
	 * @return 		  void
	 */
	static function init( $filter , $module_namespace = null )
	{
		if( $module_namespace != null ){
			$modules		=	self::get( $module_namespace );
			if( isset( $modules[ 'application' ][ 'details' ][ 'main' ] ) ){
				if( is_file( $init_file = $modules[ 'application' ][ 'details' ][ 'main' ] ) && $filter === 'unique' )
				{
					include_once( $init_file );
					return; // after special init return;
				}
			}
		} else {
			$modules		=	self::get();
		}
		$modules_array	=	array();	
		
		foreach( force_array( $modules ) as $module )
		{
			// print_array( $modules );
			// Load every module when on install mode
			if( isset( $module[ 'application' ][ 'details' ][ 'main' ] ) ){ // if a main file isset
				if( is_file( $init_file = $module[ 'application' ][ 'details' ][ 'main' ] ) && $filter === 'all' )
				{
					include_once( $init_file );
				}
				else if( is_file( $init_file = $module[ 'application' ][ 'details' ][ 'main' ] ) && $filter === 'actives' )
				{
					if( !isset( $actives_modules ) ){
						$actives_modules	=	force_array( get_instance()->options->get( 'actives_modules' ) );
					}
					if( in_array( strtolower( $module[ 'application' ][ 'details' ][ 'namespace' ] ) , $actives_modules ) )
					{
						self::$actives[]	=	$module[ 'application' ][ 'details' ][ 'namespace' ];
						// Check compatibility and other stuffs
						include_once( $init_file );
					}
				} 
			}
		}
		// get_instance()->options->set( 'active_modules' , $modules_array );	
	}
	
	private static $enable_call_time = 0;
	
	/**
	 * Enable
	 * 
	 * Enable a module using namespace provided
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $module_namespace
	 * @since        3.0.1
	 * @return 		  void|bool
	 */
	static function enable( $module_namespace )
	{
		// If self::enable(...) is called twice, cache is disabled.
		if( self::$enable_call_time !== 0 ){
			get_instance()->options->init(); // reseting Options	
		}
		self::$enable_call_time++;
		
		global $Options; // get Global Options
		
		// Get Module
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
	 * Is Active
	 * 
	 * Checks whether a module is active
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $module_namespace
	 * @param 			bool $fresh 
	 * @since        3.0.1
	 * @return 		  bool
	 */
	
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
	 * Disable
	 * 
	 * Disable module using namespace provided as unique parameter
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $namespace module namespace string
	 * @since        3.0.1
	 * @return 		  void
	 */
	
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
	 * Install
	 * 
	 * Install a module from a $_FILE provided
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $file_name
	 * @since        3.0.1
	 * @return 		  var
	 */
	
	static function install( $file_name )
	{
		 $config[ 'upload_path' ]        	=  APPPATH . '/' . 'temp' . '/';
		 $config[ 'allowed_types' ]			=	'zip';
		 $config[ 'max_size' ]				=	50000;
		 
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
			if( file_exists( $extraction_temp_path . '/' . 'config.xml' ) )
			{
				// If config xml file has at least a namespace parameter
				$module_array	=	get_instance()->xml2array->createArray( file_get_contents( $extraction_temp_path . '/' . 'config.xml' ) );					
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
							// Delete temp file
							SimpleFileManager::drop( $extraction_temp_path );
							return 'old-version-cannot-be-installed';								
						}
						
						/**
						 * Update is done only when module has valid version number
						 * Update is done only when new module version is higher than the old version
						**/
						// Delete temp file
						SimpleFileManager::drop( $extraction_temp_path );
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
									'namespace'	=>	$module_array[ 'application' ][ 'details' ][ 'namespace' ],
									'msg'		=>	'module-installed'
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
	
	/**
	 * Unzip
	 * 
	 * Unzip an Uploaded Module
	 *
	 * @access       public
	 * @author       blair Jersyer
	 */
	static function __unzip( $upload_details )
	{
		$extraction_path		=	$upload_details[ 'upload_data' ][ 'file_path' ] . $upload_details[ 'upload_data' ][ 'raw_name' ] ;		
		// If temp path does'nt exists
		if( ! is_dir( $extraction_path ) ): mkdir( $extraction_path ); endif;
		
		get_instance()->load->library( 'unzip' );	
		
		get_instance()->unzip->extract( 
			$upload_details[ 'upload_data' ][ 'full_path' ] , 
			$extraction_path
		);
		
		get_instance()->unzip->close();
		// delete zip file
		
		if( is_file( $upload_details[ 'upload_data' ][ 'full_path' ] ) ): unlink( $upload_details[ 'upload_data' ][ 'full_path' ] );endif;
		
		// Fix module installed from Github
		if( ! file_exists( $extraction_path . '/' . 'config.xml' ) ) {
			$temp_dir	=	opendir( $extraction_path );
			while( false !== ( $file = readdir( $temp_dir ) ) ){

				if( ! in_array( $file, array( '.', '..' ) ) ) {
					if( $file == $upload_details[ 'upload_data' ][ 'raw_name' ] ){ // if internal folder name is the same as the raw name
						// if within this folder a config file exists
						if( file_exists( $extraction_path . '/' . $file . '/' . 'config.xml' ) ) {
							SimpleFileManager::copy( $extraction_path . '/' . $file, $extraction_path ); // moving folder to the top parent folder
							SimpleFileManager::drop( $extraction_path . '/' . $file );
						}
					}
				}
			}
		}
		
		return $extraction_path;
	}
	
	private static $allowed_app_folders	=	array( 'libraries' , 'models' , 'config' , 'helpers' , 'third_party' ); // 'core' ,
	
	/**
	 * Parse Path
	 * 
	 * Parse Path to register manifest files [for intenal use]
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $path
	 * @since        3.0.1
	 */
	 
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
					if( in_array( $file , self::$allowed_app_folders ) && is_dir( $path . '/' . $file ) )
					{
						// var_dump( $sub_dir_path . '/' . $file . '/' );
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
	 * Mode To Module Dir
	 * 
	 * Move module temp fil to valid module folder [for internal use only]
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        array $module_array
	 * @param			array $global_manifest
	 * @param			array $manifest
	 * @param  			array $extraction_data
	 * @param			bool $conflict_checker
	 * @since        3.0.1
	 * @return 		  void
	 */
	
	static function __move_to_module_dir( $module_array , $global_manifest , $manifest , $extraction_data , $conflict_checker = false )
	{
		$module_namespace	=	$module_array[ 'application' ][ 'details' ][ 'namespace' ]; // module namespace
		if( $conflict_checker === true ){
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
		$folder_to_lower		=	strtolower( $module_namespace );
		$module_dir_path		=	MODULESPATH . $folder_to_lower;
		
		// Creating module folder within 
		if( ! is_dir( MODULESPATH . $folder_to_lower ) ){
			mkdir( MODULESPATH . $folder_to_lower , 0777 , true );
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
				$relative_path_to_file[1]	=	$relative_path_to_file[1];
				// write file on the new folder
				SimpleFileManager::file_copy( $_manifest ,  APPPATH . $relative_path_to_file[1] );
				// relative json manifest
				$relative_json_manifest[]	=	APPPATH . $relative_path_to_file[1];
			}
		}
		// Creating Manifest
		file_put_contents( $module_dir_path . '/' . 'manifest.json' , json_encode( $relative_json_manifest ) );
		
		/**
		 * New Feature Assets management
		 * Description : move module assets to public directory within a folder with namespace as name
		**/
		
		if( is_dir( $module_dir_path . '/' . 'assets' ) ){

			if( is_dir( PUBLICPATH . $module_namespace ) ){ // checks if module folder exists on public folder
				SimpleFileManager::drop( PUBLICPATH . 'modules' . '/' . $module_namespace );
			}
			
			mkdir( PUBLICPATH  . 'modules' . '/' . $module_namespace ); // creating module folder within
			SimpleFileManager::extractor( $module_dir_path . '/' . 'assets' , PUBLICPATH . 'modules' . '/' . $module_namespace );			
			
		}
		
		return true;
	}
	
	/**
	 * Uninstall
	 * 
	 * Uninstall a module using namespace provided
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        array $module_namespace
	 * @since        3.0.1
	 * @return 		  void
	 */
	
	static function uninstall( $module_namespace )
	{
		// Disable first
		self::disable( $module_namespace );
		
		// 
		$module 			=	self::get( $module_namespace );

		$modulepath		=	MODULESPATH . $module_namespace;
		$manifest_file	=	$modulepath . '/' . 'manifest.json';

		if( is_file( $manifest_file ) ){
			$manifest_array	=	json_decode( file_get_contents( $manifest_file ) , true );
			// removing file
			foreach( $manifest_array as $file )
			{
				if( is_file( $file ) ): unlink( $file );endif;
			}
		}
		
		// Drop Module Folder
		SimpleFileManager::drop( $modulepath );
		
		// Drop Assets Folder
		if( is_dir( $module_assets_folder	=	PUBLICPATH . 'modules' . '/' . $module_namespace ) ){
			SimpleFileManager::drop( $module_assets_folder );
		}
		
		// Check whether cache is enabled
		if( get_instance()->options->get( 'enable_cache' ) )
		{
			// Delete modules list cache
			get_instance()->db->cache_delete( 'dashboard' , 'modules' , 'list' );
		}
	}
	
	/**
	 * Scan
	 * 
	 * Scan folder and returns content as array
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $folder
	 * @since        3.0.1
	 * @return 		  array|bool
	 */
	 
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
	 * Scan
	 * 
	 * Extract an module with all his dependency
	 *
	 * @access       public
	 * @author       blair Jersyer
	 * @copyright    2015
	 * @param        string $module_namespace
	 * @since        3.0.1
	 * @return 		  void
	 */
	 
	static function extract( $module_namespace )
	{
		$module = self::get( $module_namespace );
		if( $module )
		{
			get_instance()->load->library( 'zip' );
			get_instance()->load->helper( 'security' );
			$module_temp_folder_name	=	do_hash( $module_namespace );
			$module_installed_dir		=	MODULESPATH  . $module_namespace . '/';
			// creating temp folder
			$temp_folder	=	APPPATH . 'temp' . '/' . $module_temp_folder_name;
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
									$temp_folder . '/' . $reserved_folder . $path_splited[1]
								);
							}
						}
					}
				}
				$assets_path = PUBLICPATH . 'modules' . '/' . $module_namespace;
				// Copy Assets to 
				if( is_dir( $assets_path ) ){
					// create assets folder
					if( !is_dir( $temp_folder . '/' . 'assets' ) ){
						mkdir( $temp_folder . '/' . 'assets' );
					}
					SimpleFileManager::copy( $assets_path , $temp_folder . '/' . 'assets' );
				}
			}
			
			// move module file to temp folder
			SimpleFileManager::copy( $module_installed_dir , $temp_folder );
			
			// read temp folder and download it
			get_instance()->zip->read_dir( 
				FCPATH . 'application' . '/' . 'temp' . '/' . $module_temp_folder_name . '/' , 
				FALSE,
				FCPATH . 'application' . '/' . 'temp' . '/' . $module_temp_folder_name . '/'
			);
			// delete temp folder
			SimpleFileManager::drop( $temp_folder );
			
			get_instance()->zip->download( $module_namespace . '-' . $module[ 'application' ][ 'details' ][ 'version' ] );		
		}
	}
}