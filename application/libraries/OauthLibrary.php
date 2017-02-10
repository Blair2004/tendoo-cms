<?php

use Carbon\Carbon;

class OauthLibrary
{
    private $scopes    =    array();

    public function __construct()
    {
        get_instance()->load->config('oauth');
        $this->scopes    =    get_instance()->config->item('oauth_scopes');
    }

    /**
     * Add Scopes
     * @param string
     * @param array
    **/

    public function addScope($label, $details)
    {
        $this->scopes[ $label ]    =    $details;
    }

    /**
     *  delete expired keys
     *  @param string date
     *  @return void
    **/

    public function deleteExpiredKeys( $currentDate )
    {
        $Cache      =   new CI_Cache( array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'tendoo_' ) );
        if( ! $Cache->get( 'has_delete_api_keys' ) )  {
            get_instance()->db
            ->where( 'expire <', $currentDate )
            ->where( 'user !=', 0 )->delete( 'restapi_keys' );

            $Cache->save( 'has_delete_api_keys', true, 86400 );
        }
    }


    /**
     * Get Requested Scopes
     * @param string
     * @return array
    **/

    public function getScopes($requested_scopes)
    {
        $scopes                =    explode(',', $requested_scopes);
        $returned_scopes    =    array();

        if (is_array($scopes) && count($scopes) > 0) {
            foreach ($scopes as $scope) {
                if (! in_array($scope, array_keys($this->scopes))) {
                    return false;
                } else {
                    $returned_scopes[ $scope ]    =    $this->scopes[ $scope ];
                }
            }
        } elseif (in_array($scopes, array_keys($this->scopes))) {
            $returned_scopes[ $scope ]    =    $this->scopes[ $scope ];
        } else {
            return false;
        }

        return $returned_scopes;
    }

    /**
     * Generate Key
    **/

    public function generateKey()
    {
        $keys        =    get_instance()->db->get('restapi_keys')->result();

        if (is_array($keys)) {
            $all_keys    =    array();
            foreach ($keys as $key) {
                $all_keys[]    =    $key->key;
            }
        }

        // Generate key
        do {
            // Create default Keys
            $length        =    40;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        } while (in_array($randomString, $all_keys));

        return $randomString;
    }

    /**
     * Check scope
     * Checks whether a request can access a scope
     *
     * @param string end point scope (unique scope)
     * @return bool
    **/

    public function checkScope($endpoint_scope)
    {
        /**
         * Check request scope
        **/

        get_instance()->load->config('rest');

        $query    =    get_instance()->db
        ->where('key', @$_SERVER[ 'HTTP_' . get_instance()->config->item('rest_header_key') ])
        ->get('restapi_keys')
        ->result();

        // Request Scope
        $app_scopes            =    ( array ) explode(',', @$query[0]->scopes);

        // Is request scope is valid
        if (! in_array($endpoint_scope, $app_scopes)) {
            return false;
        }
        return true;
    }

	/**
	 * Get User Auth id
	 * get user who generated api ID
	**/

	public function getKeyOwnerId()
	{
		$query    =    get_instance()->db
        ->where('key', @$_SERVER[ 'HTTP_' . get_instance()->config->item('rest_header_key') ])
        ->get('restapi_keys')
        ->result();

		return $query[0]->user;
	}

    /**
     *  get User Registered apps
     *  @param int user int
     *  @return array
    **/

    public function getUserApp( $user_id )
    {
        $query    =    get_instance()->db
        ->where('user',  $user_id )
        ->get('restapi_keys')
        ->result();

		return $query;
    }

    /**
     *  Add Application
     *  @param  array scopes
     *  @param  string app name
     *  @param  string callback url
     *  @return void
    **/

    public function saveApp( $userId, $scopes, $appName, $callback, $date )
    {
        $generateKey            =   $this->generateKey();
        get_instance()->load->config( 'oauth' );

        $expiration             =   get_instance()->config->item( 'oauth_key_expiration_days' );
        $date                   =   Carbon::parse( $date );
        $expiration             =   $date->addDays( $expiration );

        get_instance()->db->insert( 'restapi_keys', array(
            'user'              =>  $userId,
            'scopes'            =>  implode( ',', $scopes ),
            'date_created'      =>  $date,
            'app_name'          =>  $appName == false ? 'Unnamed App' : $appName,
            'key'               =>  $generateKey,
            'expire'            =>  $expiration->toDateTimeString()
        ) );

        return $generateKey;
    }



}
