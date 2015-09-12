<?php 
class Update_model extends CI_model
{
	// Expect tendoo_code
	function __construct(){
		parent::__construct();
		$this->load->library('curl');
		$this->core_id		=	$this->config->item( 'version' );
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
			return array( 'code' => 'error-occured' );
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
}