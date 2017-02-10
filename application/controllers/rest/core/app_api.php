<?php
defined('BASEPATH') or exit('No direct script access allowed');

! is_file(APPPATH . '/libraries/REST_Controller.php') ? die('CodeIgniter RestServer is missing') : null;

include_once(APPPATH . '/libraries/REST_Controller.php');

class App_Api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('nexopos');
        $this->load->library('session');
        $this->load->model('Options');
        $this->load->database();

        if (! $this->oauthlibrary->checkScope('core')) {
            $this->__forbidden();
        }
    }
    
    /**
     *  Delete Cache
     *  @param  string cache prefix
     *  @return json
    **/

    public function revoke_delete( $key_id )
    {
        $this->db->where( 'id', $key_id )->delete( 'restapi_keys' );
        $this->response( array(
            'status'    =>  'success'
        ), 200 );
    }
}
