<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once( dirname( __FILE__ ) . '/inc/elFinderController.php' );

class elFinder extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        //Codeigniter : Write Less Do More

        $this->events->add_action( 'load_dashboard', array( $this, 'load_dashboard' ) );
        $this->events->add_filter( 'admin_menus', array( $this, 'admin_menus' ), 15 );
    }

    /**
    *
    * Admin Menus
    *
    * @param  array Menus
    * @return array new menu
    */

    public function admin_menus( $menus )
    {
        $backup     =   $menus;
        if( User::can( 'edit_options' ) ) :
            $menus  =   array_insert_before( 'settings', $menus, 'elfinder', array(
                array(
                    'title' =>  __( 'File Manager', 'elfinder' ),
                    'href'  =>  site_url( array( 'dashboard', 'elfinder' ) ),
                    'icon'  =>  'fa fa-file'
                )
            ));
        endif;
        return $menus ? $menus : $backup;
    }

    /**
    *
    * Load dashboard
    *
    * @return void
    */

    public function load_dashboard()
    {
        if( User::can( 'edit_options' ) ) :
            $this->Gui->register_page_object( 'elfinder', new elFinderController );
        endif;
    }

}

new elFinder;
