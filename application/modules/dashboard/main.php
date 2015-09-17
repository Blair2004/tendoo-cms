<?php 
class dashboard_manager extends CI_model
{
	function __construct()
	{
		parent::__construct();		
		// load custom config
		$this->events->add_action( 'after_app_init' , array( $this , 'before_session_starts' ) );
		$this->events->add_action( 'tendoo_settings_tables' , array( $this , 'set_tables' ) );
		$this->events->add_action( 'before_dashboard_menus' , array( $this , 'before_dashboard_menus' ) , 1 );
		$this->events->add_action( 'dashboard_footer' , function( $output ){
			ob_start();
			?>
         <script>
			$(document).ready(function(e) {
            $("#wysihtml5").wysihtml5();
				$("#wysihtml5").height( screen.height - 440 );
         });
			</script>
         <?php
			return ob_get_clean();
		});
		
	}
	
	function before_dashboard_menus()
	{
		$this->load->model( 'dashboard_model' , 'dashboard' );
		// Enqueuing slimscroll
		Enqueue::enqueue_js( '../plugins/SlimScroll/jquery.slimscroll.min' );
		Enqueue::enqueue_js( '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min' ); // WYSIHTML5 @since 1.5
		Enqueue::enqueue_css( '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min' ); // CSS for WYSIHTML5
		Enqueue::enqueue_js( 'tendoo.core' );	}
	
	function set_tables()
	{
		Modules::enable( 'dashboard' );
	}
	
	/**
	 * 	Edit Tendoo.php config before session starts
	 *
	 *	@return	: void
	**/
	
	function before_session_starts()
	{
		$this->config->set_item( 'tendoo_logo_long' , '<b>Tend</b>oo' );
		$this->config->set_item( 'tendoo_logo_min' , '<img style="height:40px;" src="' . img_url() . 'logo_minim.png' . '" alt=logo>' );		
	}
}
new dashboard_manager;