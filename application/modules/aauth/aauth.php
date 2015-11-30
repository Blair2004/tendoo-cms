<?php 
class auth_module_class extends CI_model
{
	function __construct()
	{
		parent::__construct();
		// Load Model if tendoo is installed
		if( $this->setup->is_installed() )
		{
			$this->load->model( 'users_model' , 'users' );
		}			
		// Events	
		// change send administrator emails		
		$this->events->add_action( 'after_app_init' , array( $this , 'after_session_starts' ) );		
		$this->events->add_action( 'is_connected' , array( $this , 'is_connected' ) );		
		$this->events->add_action( 'log_user_out' , array( $this , 'log_user_out' ) );
		$this->events->add_filter( 'user_id' , array( $this , 'user_id' ) );
		// Tendoo Setup	
	}	
	function user_id()
	{
		if( $this->users->is_connected() )
		{
			return User::get()->id;
		}
		return 0;
	}
	function log_user_out()
	{
		if( $this->users->logout() == NULL )
		{
			if( ( $redir	=	riake( 'redirect' , $_GET ) ) != false )
			{
				// if redirect parameter is set
			}
			else
			{
				redirect( array( 'sign-in' ) );
			}
		}
		// not trying to handle false since this controller require login. 
		// While accessing this controller twice, a redirection will be made to login page from "tendoo_controller".
	}
	
	function is_connected() // deprecated
	{
		if( $this->users->is_connected() )
		{
			redirect( array( $this->config->item( 'default_logout_route' ) ) );
		}
	}
	
	
	/**
	 * After options init
	 *
	 * @return void
	**/
	
	function after_session_starts()
	{
		// load user model
		$this->load->model( 'users_model' , 'users' );
		// If there is no master user , redirect to master user creation if current controller isn't tendoo-setup
		if( ! $this->users->master_exists() && $this->uri->segment(1) !== 'tendoo-setup' )
		{
			redirect( array( 'tendoo-setup' , 'site' ) );
		}
		
		// force user to be connected for certain controller
		if( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_login' ) ) && $this->setup->is_installed() )
		{
			if( ! $this->users->is_connected() )
			{
				redirect( array( $this->config->item( 'default_login_route' ) ) );
			}
		}
	}	
	
	
}
new auth_module_class;

require( LIBPATH . '/User.php' );
require( dirname( __FILE__ ) . '/inc/dashboard.php' );
require( dirname( __FILE__ ) . '/inc/setup.php' );
require( dirname( __FILE__ ) . '/inc/fields.php' );
require( dirname( __FILE__ ) . '/inc/actions.php' );
require( dirname( __FILE__ ) . '/inc/rules.php' );
