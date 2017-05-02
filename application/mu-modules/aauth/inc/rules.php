<?php
class aauth_rules extends CI_model
{
    public function __construct()
    {
        $this->events->add_action('set_login_rules', array( $this, 'set_login_rules' ));
        $this->events->add_action('registration_rules', array( $this, 'registration_rules' ));
        $this->events->add_action('tendoo_setup', array( $this, 'registration_rules' ));
    }
    public function set_login_rules()
    {
        $this->form_validation->set_rules('username_or_email', __('Email or User Name', 'aauth'), 'required|min_length[5]');
        $this->form_validation->set_rules('password', __('Email or User Name', 'aauth'), 'required|min_length[6]');
    }
    public function registration_rules()
    {
        $this->form_validation->set_rules('username', __('User Name', 'aauth'), 'required|min_length[5]');
        $this->form_validation->set_rules('email', __('Email', 'aauth'), 'valid_email|required');
        $this->form_validation->set_rules('password', __('Password', 'aauth'), 'required|min_length[6]');
        $this->form_validation->set_rules('confirm', __('Confirm', 'aauth'), 'matches[password]');
    }
}
new aauth_rules;
