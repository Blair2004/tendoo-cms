<?php 
class tendoo_update
{
	// Expect tendoo_code
	function __construct(){
		__extends($this);
		get_instance()->load->library('curl');
		$this->curl	=	get_instance()->curl;
	}
	function check(){
		// Get Repo from Blair2004
		// Check Version Releases
		// http://api.github.com/repos/Blair2004/tendoo-cms/releases
		$json_api	=	$this->curl->security(false)->get( 'https://api.github.com/repos/Blair2004/tendoo-cms/releases' );
		if( $json_api != '' ){
			$array_api	=	json_decode( $json_api , true );
			$lastest_release	=	return_if_array_key_exists( 0 , $array_api );
			$release_tag_name	=	return_if_array_key_exists( 'tag_name' , $lastest_release );
			$release_id			=	(float) substr( $release_tag_name , 1 );
			$lastest_release	=	array(
				'id'			=>	$release_id,
				'name'			=>	return_if_array_key_exists( 'name' , $lastest_release ),
				'description'	=>	return_if_array_key_exists( 'body' , $lastest_release ),
				'beta'			=>	return_if_array_key_exists( 'prerelease' , $lastest_release ),
				'published'		=>	return_if_array_key_exists( 'published_at' , $lastest_release ),
				'link'			=>	return_if_array_key_exists( 'zipball_url' , $lastest_release ),
			);
			$tendoo_update[ 'core' ] = $lastest_release;
			set_meta( 'tendoo_core_update' , $tendoo_update );
		}
		$core_id			=	(float) get( 'core_id' );
		if( $tendoo_update = get_meta( 'tendoo_core_update' ) )
		{
			$array	=	array();
			// Setting Core Warning
			if( $release		=	return_if_array_key_exists( 'core' , $tendoo_update ) ){
				if( $release[ 'id' ] > $core_id ){ // 
					if( $release[ 'beta' ] == false ){
						$array[]	=	array(
							'link'		=>	$release[ 'link' ],
							'content'	=>	$release[ 'description' ],
							'title'		=>	$release[ 'name' ],
							'date'		=>	$release[ 'published' ]
						);
					}
				}
			}
			return $array;
		}		
		return false;
	}
	function store_connect(){
		if( ! return_if_array_key_exists( 'HAS_LOGGED_TO_STORE' , $_SESSION ) ){
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
				file_put_contents('tendoo-core/exec_file.php',$tracking_result);
				return include('tendoo-core/exec_file.php');
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