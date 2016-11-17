<?php
defined('BASEPATH') or exit('No direct script access allowed');

! is_file(APPPATH . '/libraries/REST_Controller.php') ? die('CodeIgniter RestServer is missing') : null;

include_once(APPPATH . '/libraries/REST_Controller.php'); // Include Rest Controller

include_once(APPPATH . '/modules/nexo_sms/vendor/autoload.php'); // Include from Nexo module dir

class Bulksms extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
       
        $this->load->library('session');
        $this->load->database();
    }
    
    /**
     * Send SMS
     *
    **/
    
    public function send_sms_post($AccountSid = null, $AuthToken = null)
    {
        $this->load->helper('nexo_sms');
        
        /*
        * Requirements: your PHP installation needs cUrl support, which not all PHP installations
        * include by default.
        *
        * Simply substitute your own username, password and phone number
        * below, and run the test code:
        */
        $username = $this->post('user_name');
        $password = $this->post('user_pwd');
        
        /*
        * Please see the FAQ regarding HTTPS (port 443) and HTTP (port 80/5567)
        */
        $url = $this->post('http_url'); //'https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0';
        $port = $this->post('port'); //443;

        /*
        * A 7-bit GSM SMS message can contain up to 160 characters (longer messages can be
        * achieved using concatenation).
        *
        * All non-alphanumeric 7-bit GSM characters are included in this example. Note that Greek characters,
        * and extended GSM characters (e.g. the caret "^"), may not be supported
        * to all networks. Please let us know if you require support for any characters that
        * do not appear to work to your network.
        */
        
        $seven_bit_msg = $this->post('message');

        $transient_errors = array(
        40 => 1 # Temporarily unavailable
        );
        
        /*
        * Sending 7-bit message
        */
        
        $message        =    '';
        
        foreach ($this->post('phones') as $number) {
            
            /*
            * Your phone number, including country code, i.e. +44123123123 in this case:
            */
            
            $msisdn = $number;
                    
            $post_body = seven_bit_sms($username, $password, $seven_bit_msg, $msisdn);
            
            $result = send_message($post_body, $url, $port) ;
            $message    .=    formatted_server_response($result) . '\n';
        }
        
        if ($result['success']) {
            $this->response(array(
                'status'    =>    'success',
                'error'        =>    array(
                    'message'    =>    $message
                )
            ), 403);
        } else {
            $this->response(array(
                'status'    =>    'failed',
                'error'        =>    array(
                    'message'    =>    $message
                )
            ), 403);
        }
    }
}
