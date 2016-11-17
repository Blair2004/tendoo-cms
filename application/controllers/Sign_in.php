<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sign_in extends Tendoo_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/sing-in
     *	- or -
     * 		http://example.com/index.php/welcome/sing-in
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Login_Model');
    }
    
    /**
     * Sign In index page
     *
     *	Displays login page
     * 	@return : void
    **/
    
    public function index()
    {
        $this->events->do_action('set_login_rules');
        // in order to let validation return true
        $this->form_validation->set_rules('submit_button', __('Submit button'), 'alpha_dash');
		
        if ($this->form_validation->run()) {
            // Log User After Applying Filters
            $this->events->do_action( 'do_login' );
            $exec        =    $this->events->apply_filters('tendoo_login_notice', 'user-logged-in');
            if ($exec    == 'user-logged-in') {
                if (riake('redirect', $_GET)) {
                    redirect(urldecode(riake('redirect', $_GET)));
                } else {
                    redirect( $this->events->apply_filters( 'login_redirection', array( 'dashboard' ) ) );
                }
            }
            $this->notice->push_notice($this->lang->line($exec));
        }
		
        // load login fields
        $this->config->set_item('signin_fields', $this->events->apply_filters('signin_fields', $this->config->item('signin_fields')));
        
        Html::set_title(sprintf(__('Sign In &mdash; %s'), get('core_signature')));
        $this->load->view('shared/header');
        $this->load->view('sign-in/body');
    }
    
    /**
     * 	Recovery Method
     *	
     *	Allow user to get reset email for his account
     *
     *	@return void
    **/
    
    public function recovery()
    {
        $this->form_validation->set_rules('user_email', __('User Email'), 'required|valid_email');
        if ($this->form_validation->run()) {
            /**
             * Actions to be run before sending recovery email
             * It can allow use to edit email
            **/
            $this->events->do_action('do_send_recovery');
        }
        Html::set_title(sprintf(__('Recover Password &mdash; %s'), get('core_signature')));
        $this->load->view('shared/header');
        $this->load->view('sign-in/recovery');
    }
    
    /**
     * 	Reset
     * 	
     *	Checks a verification code an send a new password to user email
     *
     * 	@access : public
     *	@param : int user_id
     * 	@param : string verfication code
     * 	@return : void
     * 
    **/
    
    public function reset($user_id, $ver_code)
    {
        $this->events->do_action('do_reset_user', $user_id, $ver_code);
    }
    
    /**
     * Verify
     * 
     * 	Verify actvaton code for specifc user
     *
     *	@access : public
     *	@param : int user_id
     *	@param : string verification code
     *	@status	: untested
    **/
    
    public function verify($user_id, $ver_code)
    {
        $this->events->do_action('do_verify_user', $user_id, $ver_code);
    }
}
