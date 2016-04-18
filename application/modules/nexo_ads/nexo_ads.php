<?php
! defined( 'APPPATH' ) ? die( 'You\'re kidding me right ?' ) : NULL;

class Nexo_ADS extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'load_dashboard', array( $this, 'dashboard' ) );
		$this->events->add_action( 'tendoo_settings_tables', array( $this, 'install' ) );
	}

	/**
	 * Install
	**/

	function install()
	{
		Modules::enable( 'nexoads' );
	}

	/**
	 * Load dashboard
	 *
	**/

	function dashboard()
	{
		$this->events->add_filter( 'gui_before_cols', array( $this, 'output_ads' ), 1, 1 );
	}

	/**
	 * output_ads
	 *
	**/

	function output_ads( $content )
	{
		$array		=	array(
			array(
				'link'	=>	'http://nexo.tendoo.org/get-premium',
				'image'	=>	'1.jpg',
			),
			array(
				'link'	=>	'http://nexo.tendoo.org/go-for-master',
				'image'	=>	'2.jpg',
			),
			array(
				'link'	=>	'http://nexo.tendoo.org',
				'image'	=>	'3.jpg',
			)
		);
		$current_ads	=	$array[rand(0, count( $array ) - 1)];
		ob_start()
		?>
        <div class="container-fluid">
            <a href="<?php echo $current_ads[ 'link' ];?>?from=<?php echo urlencode( current_url() );?>">
                <img src="<?php echo module_url( 'nexo_ads' ) . '/img/' . $current_ads[ 'image' ];?>" alt="NexoBanner"/>
            </a>
        </div>
        <?php
		$content	.=	ob_get_clean();
		return $content;
	}
}
new Nexo_ADS;
