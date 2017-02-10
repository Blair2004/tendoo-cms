<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class make extends CI_Controller {
    public function module( $name )
    {
        if( is_dir( APPPATH . 'modules/' . $name ) ) {
            echo 'a folder with that name already exists !' . PHP_EOL;
            return;
        }

        mkdir( APPPATH . 'modules/' . $name );
    }
}
