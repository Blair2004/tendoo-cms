<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class elFinderController extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function index()
    {
        $this->enqueue->js( 'elfinder.min', module_url( 'elfinder/js' ) );
        // $this->enqueue->js( '//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min', '' );
        // $this->enqueue->js( '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min', '' );
        $this->enqueue->js( 'i18n/elfinder.uk', module_url( 'elfinder/js' ) );
        $this->enqueue->css( '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui', '' );
        $this->enqueue->css( 'elfinder.min', module_url( 'elfinder/css' ) );

        $this->Gui->set_title( __( 'File Manager', 'elfinder' ) );
        $this->load->mu_module_view( 'elfinder', 'elFinderGui' );
    }

}
