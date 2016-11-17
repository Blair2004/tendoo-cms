<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sign_up extends Tendoo_Controller
{

    /**
     * Registration Controller for Auth purpose
     *
     * Maps to the following URL
     * 		http://example.com/index.php/registration
     *	- or -
     * 		http://example.com/index.php/registration/index
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->enqueue->css('bootstrap.min');
        $this->enqueue->css('AdminLTE.min');
        $this->enqueue->css('skins/_all-skins.min');

        /**
         * 	Enqueueing Js
        **/

        $this->enqueue->js('plugins/jQuery/jQuery-2.1.4.min');
        $this->enqueue->js('bootstrap.min');
        $this->enqueue->js('plugins/iCheck/icheck.min');
        $this->enqueue->js('app.min');
    }
    public function index()
    {
        $this->events->do_action('registration_rules');

        if ($this->form_validation->run()) {
            $this->events->do_action('do_register_user');
        }

        Html::set_title(sprintf(__('Sign Up &mdash; %s'), get('core_signature')));

        $this->load->view('shared/header');
        $this->load->view('sign-up/body');
    }
}
