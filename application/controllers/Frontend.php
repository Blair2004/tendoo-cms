<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends Tendoo_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->reserved_controllers    =    $this->config->item('reserved_controllers');
        // Get Reserved Controllers		
    }
    public function index()
    {
        $segments    =    $this->uri->segment_array();
        $this->events->do_action('load_frontend', $segments);
    }
}
