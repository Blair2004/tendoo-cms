<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Gui Cols Width
$this->Gui->col_width(1, 4);

// Gui Meta
$this->Gui->add_meta( array(
    'col_id'    =>  1,
    'namespace' =>  'elfinder',
    'title'     =>  __( 'File Manager', 'elfinder' ),
    'type'      =>  'unwrapped'
) );

$this->Gui->add_item( array(
'type'          =>    'dom',
'content'       =>     $this->load->mu_module_view( 'elfinder', 'elFinderDom', array(), true )
), 'elfinder', 1 );

// Gui Output
$this->Gui->output();
