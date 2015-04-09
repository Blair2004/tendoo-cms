<?php
$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( array( 
	'namespace'		=>		'about-text' , 
	'title'			=>		__( 'About' ) , 
	'type'			=>		'unwrapped' 
) )->push_to( 1 );

$view = $this->load->the_view( 'admin/about/about-text' , true ); // where true means Return  value.

$this->gui->set_item( array(
    'type'    =>    'dom',
    'value'   =>    	$view
) )->push_to( 'about-text' );

$this->gui->get();