	<?php 
class auth_module_class extends CI_model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model( 'users_model' , 'users' );
		// Events
		
		
		
		
		// change send administrator emails
		
		$this->events->add_action( 'after_app_init' , array( $this , 'after_session_starts' ) );		
		$this->events->add_action( 'is_connected' , array( $this , 'is_connected' ) );		
		$this->events->add_action( 'log_user_out' , array( $this , 'log_user_out' ) );
		// Tendoo Setup			
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
	
	function is_connected()
	{
		if( $this->users->is_connected() )
		{
			redirect( array( $this->config->item( 'default_logout_route' ) ) );
		}
	}
	
	
	
	function dashboard()
	{
		$this->gui->register_page( 'users' , array( $this , 'users' ) );
		$this->gui->register_page( 'roles' , array( $this , 'roles' ) );
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
		
		// Load created roles add push it to their respective type
		$admin_groups	=	force_array( $this->options->get( 'admin_groups' ) );
		$public_groups	=	force_array( $this->options->get( 'public_groups' ) );
		
		// For public groups
		$tendoo_public_groups	=	$this->config->item( 'public_group_label' );
		$merged_public_groups	=	array_merge( $tendoo_public_groups , $admin_groups );
		$this->config->set_item( 'public_group_label' , $merged_public_groups );
		
		// for admin groups
		$tendoo_admin_groups	=	$this->config->item( 'master_group_label' );
		$merged_admin_groups	=	array_merge( $tendoo_admin_groups , $admin_groups );
		$this->config->set_item( 'master_group_label' , $merged_admin_groups );
	}	
	
	
}
new auth_module_class;

require( dirname( __FILE__ ) . '/inc/dashboard.php' );
require( dirname( __FILE__ ) . '/inc/setup.php' );
require( dirname( __FILE__ ) . '/inc/fields.php' );
require( dirname( __FILE__ ) . '/inc/actions.php' );
require( dirname( __FILE__ ) . '/inc/rules.php' );