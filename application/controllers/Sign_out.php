<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sign_out extends Tendoo_Controller
{

    /**
     * Login out page
     *
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        // doing log_user_out
        $this->events->do_action('log_user_out');
    }
}
