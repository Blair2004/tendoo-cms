<?php
class OauthLibrary
{
	private $scopes	=	array();
	
	public function __construct()
	{
		$this->scopes	=	array(
			'basic'				=>		array(
				'label'			=>		__( 'Access user details' ),
				'description'	=>		__( 'The current request would like to access user informations such as name, email, except password' ),
				'app'			=>		'system',
				'icon'			=>		'fa fa-user',
				'color'			=>		'bg-aqua',
				'group'			=>		NULL
			),
			'site_details'		=>		array(
				'label'			=>		__( 'Access Tendoo ressources' ),
				'description'	=>		__( 'Allow access to Tendoo informations such as site name, timezone, module list, user list' ),
				'app'			=>		'system',
				'icon'			=>		'fa fa-database',
				'color'			=>		'bg-red',
				'group'			=>		array( 'master', 'administrator' )
			),
			'site_advanced'		=>		array(
				'label'			=>		__( 'Access Tendoo Advanced ressources' ),
				'description'	=>		__( 'The current request would like to control Tendoo CMS.' ),
				'app'			=>		'system',
				'icon'			=>		'fa fa-user-secret',
				'color'			=>		'bg-red',
				'group'			=>		array( 'master' )
			)
		);
	}
	
	/** 
	 * Add Scopes
	 * @param string
	 * @param array
	**/
	
	public function addScope( $label, $details ) 
	{
		$this->scopes[ $label ]	=	$details;
	}
	
	/**
	 * Get Requested Scopes
	 * @param string
	 * @return array
	**/
	
	public function GetScopes( $requested_scopes ) 
	{
		$scopes				=	explode(',', $requested_scopes );
		$returned_scopes	=	array();
		
		if( is_array( $scopes ) && count( $scopes ) > 0 ) {
			foreach( $scopes as $scope ) {
				if( ! in_array( $scope, array_keys( $this->scopes ) ) ) {
					return false;
				} else {
					$returned_scopes[ $scope ]	=	$this->scopes[ $scope ];
				}
			}
		} else if ( in_array( $scopes, array_keys( $this->scopes ) ) ) {
			$returned_scopes[ $scope ]	=	$this->scopes[ $scope ];
		} else {
			return false;
		}
		
		return $returned_scopes;
	}
	
	
}