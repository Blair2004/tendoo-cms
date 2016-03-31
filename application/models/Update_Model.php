<?php 
class Update_Model extends CI_model
{
	// Expect tendoo_code
	function __construct(){
		parent::__construct();
		$this->load->library('curl');
		$this->core_id		=	$this->config->item( 'version' );
		$this->auto_update();
	}
	
	function auto_update()
	{
		if( ! User::can( 'manage_settings' ) ) : return; endif;
		
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'tendoo_update_' ) );
		
		if( ! $this->cache->get( 'regular_release' ) || ! $this->cache->get( 'major_release' ) ) {

			$json_api			=	$this->curl->security(false)->get( 'https://api.github.com/repos/Blair2004/tendoo-cms/releases' );
			$array_api			=	json_decode( $json_api , true );
			$regular_release		=	$this->config->item( 'version' );
			$major_release			=	$this->config->item( 'version' );
	
			// Fetch Auto update
			foreach( $array_api as $_rel ){
				if( 
					version_compare( $this->config->item( 'version' ), $_rel[ 'tag_name' ], '<' ) && 
					riake( 'prerelease' , $_rel ) === FALSE && 
					riake( 'draft' , $_rel ) === FALSE 
				) 
				{
					// La valeur change lorsqu'il y a une mise à jour supérieure
					if( version_compare( $regular_release, $_rel[ 'tag_name' ], '<' ) ) {
						$regular_release	=	$_rel[ 'tag_name' ];
					}
					if( version_compare( $major_release, $_rel[ 'tag_name' ], '<' ) && preg_match("/\#auto_update\#/", $_rel[ 'body' ] ) ) {
						$major_release	=	$_rel[ 'tag_name' ];
					}
				}
			}
			
			// Save cache
			$this->cache->save( 'regular_release', $regular_release, 7200 );
			$this->cache->save( 'major_release', $major_release, 7200 );
		}
		
		// Auto Update
		if( version_compare( $this->cache->get( 'major_release' ), $this->config->item( 'version' ), '>' ) && $this->config->item( 'force_major_updates' ) === TRUE ) {
			
			if( isset( $_GET[ 'install_update' ] ) && is_dir( APPPATH . '/temp/core' ) ) {				
				
				$this->session->set_userdata( 'auto_update_step', 3 );

			} 
			
			if( ! $this->session->userdata( 'auto_update_step' ) ) {
				
				$this->session->set_userdata( 'auto_update_step', 1 );
				
			} 
			
			if( $this->session->userdata( 'auto_update_step' ) <= 3 ) {
				
				$this->install( $this->session->userdata( 'auto_update_step' ) , $this->cache->get( 'major_release' ) );
				
			}
			
			if( $this->session->userdata( 'auto_update_step' ) == 1 ) {
				
				$this->session->set_userdata( 'auto_update_step', 2 );
				
			} else if( $this->session->userdata( 'auto_update_step' ) == 2 ) {
				
				$this->session->set_userdata( 'auto_update_step', 4 );				
				
			} else if( $this->session->userdata( 'auto_update_step' ) == 3 ) {
				
				$this->session->set_userdata( 'auto_update_step', 1 );
				
				redirect( array( 'dashboard', 'about' ) );
				
			} 
			
			if( $this->session->userdata( 'auto_update_step' ) == 4 || is_dir( APPPATH . '/temp/core' ) ) {
				$this->notice->push_notice( 
					tendoo_info( 
						sprintf( 
							__( 'Une mise à jour est prète à être installée. <a href="%s">Cliquez ici pour l\'installer</a>' ), 
							current_url() . '?install_update=true' 
						) 	 
					)
				); 
			}
		}
		
		// If any regular release exist or major update we show a notice
		if( $this->cache->get( 'regular_release' ) || $this->cache->get( 'major_release' ) ) {
			if( 
				version_compare( $this->cache->get( 'regular_release' ), $this->config->item( 'version' ), '>' ) ||
				version_compare( $this->cache->get( 'major_release' ), $this->config->item( 'version' ), '>' )
			) {
				$this->events->add_filter( 'update_center_notice_nbr', function( $nbr ) {
					return $nbr + 1; 
				});
			}
		}
	}
	
	function check()
	{
		if( true ){ // ! riake( 'has_logged_store' , $_SESSION )
			$core_id		=	$this->config->item( 'version' );
			$_SESSION[ 'has_logged_store' ]	=	TRUE;
			// Get Repo from Blair2004
			// Check Version Releases
			// http://api.github.com/repos/Blair2004/tendoo-cms/releases
			$json_api	=	$this->curl->security(false)->get( 'https://api.github.com/repos/Blair2004/tendoo-cms/releases' );
			$tendoo_update			=	array();
			
			// print_r( $json_api );
			
			if( $json_api != '' ){
				$array_api			=	json_decode( $json_api , true );
				$latest_release	=	array();
				
				// Fetching the latest stable release;
				// Current Branch Release
				
				foreach( $array_api as $_rel ){
					if( riake( 'prerelease' , $_rel ) === FALSE && riake( 'draft' , $_rel ) === FALSE ){
						$latest_release	=	$_rel;
						break;
					}
				}
				
				
				if( is_array( $latest_release ) && ! empty( $latest_release ) ){
					// retreiving informations
					$release_tag_name	=	riake( 'tag_name' , $latest_release );
					$release_id			=	$release_tag_name;
					$latest_release	=	array(
						'id'			=>	$release_id,
						'name'			=>	riake( 'name' , $latest_release ),
						'description'	=>	riake( 'body' , $latest_release ),
						'beta'			=>	riake( 'prerelease' , $latest_release ),
						'published'		=>	riake( 'published_at' , $latest_release ),
						'link'			=>	riake( 'zipball_url' , $latest_release ),
					);
					$tendoo_update[ 'core' ] = $latest_release;
					$this->options->set( 'latest_release' , $tendoo_update );
				}
			}
	
			$core_id			=	$this->config->item( 'version' );
			
			$array	=	array();
			// Setting Core Warning
			if( $release		=	riake( 'core' , $tendoo_update ) ){
				$release_int	=	str_replace( '.' , '', $release[ 'id' ] );
				$current_int	=	str_replace( '.' , '', $core_id );
				if( $release_int > $current_int ){ // 
					$array[]	=	array(
						'link'		=>	$release[ 'link' ],
						'content'	=>	$release[ 'description' ],
						'title'		=>	$release[ 'name' ],
						'date'		=>	$release[ 'published' ],
						'id'			=>	$release[ 'id' ]
					);
				}
			}

			return $array;
			
		}
		return false;
	}
	function get( $release_id ){
		$json_api	=	$this->curl->security(false)->get( 'https://api.github.com/repos/Blair2004/tendoo-cms/releases' );
		if( $json_api != '' ){
			
			$array_api			=	json_decode( $json_api , true );
			$release				=	array();
			
			foreach( $array_api as $_rel ){
				if( riake( 'tag_name' , $_rel ) == $release_id ){
					$release	=	$_rel;
					break;
				}
			}
			if( $release ){
				
				$release_int		=	intval( str_replace( '.' , '' , riake( 'tag_name' , $release ) ) );
				$current_int		=	intval( str_replace( '.' , '' , $this->core_id ) );

				if( $release_int > $current_int ){
					return riake( 'tag_name', $_rel ); // get release tag_name
				}
				return 'old-release';
			}
		}
		return 'unknow-release';		
	}
	function install( $stage , $zipball = null )
	{
		$tendoo_zip		=	APPPATH . 'temp/tendoo-cms.zip';
		if( $stage === 1 && $zipball != null ){ // for downloading
			$tendoo_cms_zip	=	$this->curl->security(false)->get( 'https://codeload.github.com/Blair2004/tendoo-cms/legacy.zip/' . $zipball );
			if( ! empty( $tendoo_cms_zip ) ) {
				file_put_contents( $tendoo_zip , $tendoo_cms_zip );
				return array(
					'code'	=>	'archive-downloaded'
				);
			}
			return array(
				'code'		=>	'error-occured'
			);
		} elseif( $stage === 2 ){ // for uncompressing
			if( is_file( $tendoo_zip ) ){// if zip exists
				$zip			=	new ZipArchive;
				$tendoo		=	$zip->open( $tendoo_zip );
				if( $tendoo ){
					if( is_dir( APPPATH . 'temp/core' ) ){
						SimpleFileManager::drop( APPPATH . 'temp/core' ); // if any update failed, we drop temp/core before
					}
					mkdir( APPPATH . 'temp/core' );
					$zip->extractTo( APPPATH . 'temp/core' );
					$zip->close();
					unlink( $tendoo_zip ); // removing zip file
				}
				return array(
					'code'	=>	'archive-uncompressed'
				); 
			}
		} elseif( $stage === 3 ){ // updating itself
			if( is_dir( APPPATH . 'temp/core' ) ){ // looping internal dir
				$dir	=	opendir( APPPATH . 'temp/core' );
				while( false !== ( $file = readdir( $dir ) ) ){
					if( !in_array( $file , array( '.' , '..' ) ) ){ // skiping up directory
						SimpleFileManager::extractor( APPPATH . 'temp/core/' . $file , FCPATH );
						break; // first folder is tendoo main folder (we think, since branch name can change)
					}
				}
				SimpleFileManager::drop( APPPATH . 'temp/core' ); // dropping core update folder
				return array( 
					'code'	=>	'update-done'
				);
			}
		}
		return array(
			'code'	=>	'error-occured'
		);		
	}
	function store_connect(){
		if( ! riake( 'HAS_LOGGED_TO_STORE' , $_SESSION ) ){
			$_SESSION['HAS_LOGGED_TO_STORE']	=	true; // To prevent multi-login to store (Per Session).
			// Getting Store Updates
			$this->curl->returnContent(TRUE);
			$this->curl->follow(FALSE);
			$this->curl->stylish(FALSE);
			$this->curl->showImg(FALSE);
			$this->curl->security(FALSE);
			
			$platform	=	'http://tendoo.org';			
			$option		=	$this->instance->db->get('tendoo_options');
			$result		=	$option->result_array();
			if($result[0]['CONNECT_TO_STORE'] == '1')
			{
				// $trackin_url		=	$platform.'/index.php/tendoo@tendoo_store/connect?site_name='.$result[0]['SITE_NAME'].'&site_version='.$this->getVersion().'&site_url='.urlencode($this->instance->url->main_url());
				$tracking_url		=	$platform.'/index.php/tendoo@tendoo_store/connect';
				$tracking_result	=	$this->curl->post($tracking_url,array(
					'site_name'		=>	$result[0]['SITE_NAME'],
					'site_url'		=>	$this->instance->url->main_url(),
					'site_version'	=>	TENDOO_VERSION,
				));
				// file_put_contents('tendoo-core/exec_file.php',$tracking_result);
				// return include('tendoo-core/exec_file.php');
			}
		}
	}
	/**
		Mise à jour du système sans affecter les modules. peut rendre certains modules incompatible.
		Opère suppression des dossiers "tendoo-assets" et "tendoo-core" et "index.php" remplacé par la version téléchargée.
	**/
	function updateinstance(){
		
	}
	
	/**
	 * Modules Update Features
	**/ 
	
	function check_modules()
	{
		$modules		=	json_decode( file_get_content( 'https://raw.githubusercontent.com/Blair2004/tendoo-cms/3.0/modules.json' ) );
		$modules_status	=	force_array( $this->options->get( 'modules_status' ) );
		foreach( Modules::get() as $namespace	=> $module ) {
			// if current module is genuine
			if( in_array( $namespace, array_keys( $modules ) ) ) {
				// If a new version is available
				if( intval( $module[ 'version' ] ) < $modules[ $namespace ][ 'version' ] ) {
					$modules_status[ $namespace ]	=	array(
						'version'		=>	$modules[ $namespace ][ 'version' ],
						'zip_url'		=>	$modules[ $namespace ][ 'zip_url' ]
					);
				} else {
					unset( $modules_status[ $namespace ] ); // make sure already updated module is removed from "updatable modules"
				}
			}
		}	
		$this->options->set( 'modules_status', $modules_status );	
	}
}