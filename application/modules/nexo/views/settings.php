<?php
$this->Gui->col_width( 1, 2 );
$this->Gui->col_width( 2, 2 );

// Nexo Shop Details Start

include_once( dirname( __FILE__ ) . '/shop-details-settings.php' );

// NexoShop Details End

include_once( dirname( __FILE__ ) . '/shop-discount-customers-settings.php' );

// Nexo Checkout Settings

include_once( dirname( __FILE__ ) . '/shop-checkout-settings.php' );

// Nexo Licence

include_once( dirname( __FILE__ ) . '/shop-licence-settings.php' );

// Nexo Reset

include_once( dirname( __FILE__ ) . '/shop-reset-settings.php' );

// Nexo Sound Effet

include_once( dirname( __FILE__ ) . '/shop-soundeffect-settings.php' );

// Product Settings

include_once( dirname( __FILE__ ) . '/shop-product-settings.php' );

$this->Gui->output();