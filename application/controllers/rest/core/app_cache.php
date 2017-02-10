<?php
defined('BASEPATH') or exit('No direct script access allowed');

! is_file(APPPATH . '/libraries/REST_Controller.php') ? die('CodeIgniter RestServer is missing') : null;

include_once(APPPATH . '/libraries/REST_Controller.php');

class App_Cache extends REST_Controller
{
    /**
     *  Delete Cache
     *  @param  string cache prefix
     *  @return json
    **/

    public function clear_delete( $string, $prefix = 'tendoo_notices_' )
    {
        $Cache      =   new CI_Cache( array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => $prefix ) );
        $Cache->delete( $string );
    }
}
