<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Oauth extends Tendoo_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/oauth
     *	- or -
     * 		http://example.com/index.php/oauth/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->config( 'rest' );
        $this->load->model('Gui', null, 'gui');
        $this->load->model('Update_Model'); // load update model @since 3.0
        $this->load->library( 'OauthLibrary' );
        $this->load->library( 'form_validation' );

        $this->form_validation->set_rules('scopes', __('Scopes'), 'requried');
        if( $this->form_validation->run() ){
            $generatedKey    =   $this->oauthlibrary->saveApp(
                User::id(),
                $_POST[ 'scopes' ],
                $this->input->post( 'app_name' ),
                @$_GET[ 'cb' ],
                date_now()
            );

            redirect( @$_GET[ 'cb' ] . '?key=' . $generatedKey . '&key_header=' . $this->config->item( 'rest_header_key' ) );
        }

        global $Options;
        $data[ 'scopes' ]    =    $this->oauthlibrary->getScopes(@$_GET[ 'scope' ]);

        $this->Gui->set_title(sprintf(__('%s &mdash; Request permissions'), @$Options[ 'site_name' ]));

        $this->load->view('shared/header');
        $this->load->view('oauth/body', $data);
    }
}
