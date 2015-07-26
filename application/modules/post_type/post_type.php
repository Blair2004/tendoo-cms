<?php
class post_type extends CI_model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'after_app_init' , array( $this , 'loader' ) );
	}
	
	function loader()
	{
		if( Modules::is_active( 'aauth' ) )
		{
		}
		else
		{
			$this->events->add_filter( 'ui_notices' , function( $notices ){
				return $notices[]		=	array(
					'msg'		=>		__( 'Aauth Module is required, please install or enable it' ),
					'type'	=>		'warning',
					'icon'	=>		'fa fa-times'
				);
			});
		}
	}
}
new post_type;