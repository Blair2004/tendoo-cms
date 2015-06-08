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
	
	private $default_login_fields_namespace	=	array( 
		'username_or_email'			=>		'username_or_email',
		'password'					=>		'password',
		'keep_connected'			=>		'keep_connected'
	);
	function __construct()
	{
		parent::__construct();
		$this->create_login_fields();
		
		// add action to display login fields
		$this->events->add_action( 'display_login_fields' , array( $this , 'display_login_fields' ) );		
		$this->events->add_action( 'set_login_rules' , array( $this , 'set_login_rules' ) );		
	}
	function display_login_fields()
	{
		foreach( force_array( $this->config->item( 'signin_fields' ) ) as $fields )
		{
			echo $fields;
		}
	}	
	function create_login_fields()
	{
		// default login fields
		$this->config->set_item( 'signin_fields' , array(  
			'pseudo'	=>
			'<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="' . __( 'Email or User Name' ) .'" name="username_or_email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>',		
			'password'	=>
			'<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="' . __( 'Password' ) .'" name="password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>',
			'submit'	=>
			'<div class="row">
				<div class="col-xs-8">    
				  <div class="checkbox icheck">
					<label>
					  <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false"><input type="checkbox" name="keep_connected"><ins class="iCheck-helper"></ins></div> ' . __( 'Remember me' ) . '
					</label>
				  </div>                        
				</div><!-- /.col -->
				<div class="col-xs-4">
				  <button type="submit" class="btn btn-primary btn-block btn-flat">' . __( 'Sign In' ) .'</button>
				</div><!-- /.col -->
			</div>' 
		) );
	}
	function set_login_rules()
	{
		$this->form_validation->set_rules( 'username_or_email' , __( 'Email or User Name' ) , 'required|min_length[5]' );
		$this->form_validation->set_rules( 'password' , __( 'Email or User Name' ) , 'required|min_length[6]' );
	}
	function get_fields_namespace()
	{
		// Apply Fields Namespace
		return $login_fields_namespace		=	 $this->events->apply_filters( 'signin_fields_namespace' , $this->default_login_fields_namespace );
	}
}