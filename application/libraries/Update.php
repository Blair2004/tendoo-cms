<?php 
class Update
{
	// Expect tendoo_code
	function __construct(){
		get_instance()->load->library('curl');
		$this->curl	=	get_instance()->curl;
	}
	function check(){
		if( riake( 'has_logged_store' , $_SESSION ) ){
			
			$_SESSION[ 'has_logged_store' ]	=	TRUE;
			// Get Repo from Blair2004
			// Check Version Releases
			// http://api.github.com/repos/Blair2004/tendoo-cms/releases
			$json_api	=	$this->curl->security(false)->get( 'https://api.github.com/repos/Blair2004/tendoo-cms/releases' );
			if( $json_api != '' ){
				$array_api			=	json_decode( $json_api , true );
				$latest_release	=	riake( 0 , $array_api );
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
				get_instance()->options->set( 'latest_release' , $tendoo_update );
			}
	
			$core_id			=	get( 'core_version' );
			if( intval( get_instance()->options->get( 'auto_update' ) ) == TRUE )
			{
				$array	=	array();
				// Setting Core Warning
				if( $release		=	riake( 'core' , $tendoo_update ) ){
					if( $release[ 'id' ] > $core_id ){ // 
						if( $release[ 'beta' ] == false ){
							$array[]	=	array(
								'link'		=>	$release[ 'link' ],
								'content'	=>	$release[ 'description' ],
								'title'		=>	$release[ 'name' ],
								'date'		=>	$release[ 'published' ],
								'id'			=>	$release[ 'id' ]
							);
						}
					}
				}
				return $array;
			}		
		}
		return false;
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