<?php
class Login_model extends CI_Model
{
    /**
     * Login model
     * 
     * Load fields and defaults value for login controller
     * Each fields must match other in differents context. So default_login_fields_namespace are names (keys values) available on
     * created fields (using create_login_fields). And those same fields namespace (name) are used within set_login_rules method
    **/
    
    private $default_login_fields_namespace    =    array(
        'username_or_email'            =>        'username_or_email',
        'password'                    =>        'password',
        'keep_connected'            =>        'keep_connected'
    );
    public function __construct()
    {
        parent::__construct();
        $this->create_login_fields();
        $this->events->add_action('display_login_fields', array( $this, 'display_login_fields' )); // Use Once		
    }
    
    /**
     * Default behavior when no auth module is installed
    **/
    
    public function display_login_fields()
    {
        foreach (force_array($this->config->item('signin_fields')) as $fields) {
            echo $fields;
        }
    }
    
    public function create_login_fields()
    {
        // default login fields
        $this->config->set_item('signin_fields', array(
            'submit'    =>
            '<div class="row">
				<div class="col-xs-8">                            
				</div><!-- /.col -->
				<div class="col-xs-4">
				  <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit_button">' . __('Sign In') .'</button>
				</div><!-- /.col -->
			</div>'
        ));
    }
    
        
    
    public function get_fields_namespace()
    {
        // Apply Fields Namespace
        return $login_fields_namespace        =     $this->events->apply_filters('signin_fields_namespace', $this->default_login_fields_namespace);
    }
}
