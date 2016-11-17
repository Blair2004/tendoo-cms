<?php
defined('BASEPATH') or exit('No direct script access allowed');

! is_file(APPPATH . '/libraries/REST_Controller.php') ? die('CodeIgniter RestServer is missing') : null;

include_once(APPPATH . '/libraries/REST_Controller.php'); // Include Rest Controller

include_once(APPPATH . '/modules/nexo_sms/vendor/autoload.php'); // Include from Nexo module dir

class Twilio extends REST_Controller
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
        if ($AccountSid != null && $AuthToken != null) {
            // $AccountSid, $AuthToken 
            // $AccountSid = "ACc50fb29f77551aae948dd760ecf23792"; // Your Account SID from www.twilio.com/console
            // $AuthToken = "c39ab533cdb731a93c1a019a6089e4d9";   // Your Auth Token from www.twilio.com/console

            // Step 3: instantiate a new Twilio Rest Client
            $client = new Services_Twilio($AccountSid, $AuthToken);
        
            // Step 4: make an array of people we know, to send them a message. 
            // Feel free to change/add your own phone number and name here.
            /*$people = array(
                "+****" => "*****", 
                "+****" => "*****"
            );*/
        
            // Step 5: Loop over all our friends. $number is a phone number above, and 
            // $name is the name next to it
            $response            =    '';
            
            foreach ($this->post('phones') as $number) {
                $client->account->messages->sendMessage(
        
                // Step 6: Change the 'From' number below to be a valid Twilio number 
                // that you've purchased, or the (deprecated) Sandbox number
                    $this->post('from_number'),
        
                    // the number we are sending to - Any phone number
                    $number,
        
                    // the sms body
                    $this->post('message')
                );
        
                // Display a confirmation message on the screen
                $response    .= "Message send to $number,";
            }
            
            $this->response(array(
                'status'    =>    'success',
                'message'    =>    $response
            ), 200);
        }
        
        $this->response(array(
            'status'    =>    'failed',
            'error'        =>    array(
                'message'    =>    'An error occured while submiting Twilio API'
            )
        ), 403);
    }
}
