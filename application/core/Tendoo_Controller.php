<?php
class Tendoo_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Include default library class
        include_once(LIBPATH .'/Html.php');
        include_once(LIBPATH .'/Modules.php');
        include_once(LIBPATH .'/UI.php');
        include_once(LIBPATH .'/SimpleFileManager.php');
        include_once(APPPATH . 'third_party/PHP-po-parser-master/src/Sepia/InterfaceHandler.php');
        include_once(APPPATH . 'third_party/PHP-po-parser-master/src/Sepia/FileHandler.php');
        include_once(APPPATH . 'third_party/PHP-po-parser-master/src/Sepia/PoParser.php');
        include_once(APPPATH . 'third_party/PHP-po-parser-master/src/Sepia/StringHandler.php');

        // get system lang
        $this->load->library('enqueue');

        // Load Global Lang lines
        $this->lang->load_lines(APPPATH . '/language/system_lang.php'); // @since 3.0.9

        // Load Modules
        Modules::load(MODULESPATH);

        /**
         * Global Vars
        **/

        global $CurrentMethod, $CurrentScreen, $CurrentParams;

        $CurrentMethod        =    $this->uri->segment(2);
        $CurrentScreen        =    $this->uri->segment(1);
        $CurrentParams        =    $this->uri->segment_array();
        $CurrentParams        =    count($CurrentParams) > 2 ? array_slice($CurrentParams, 2) : array();

        // if is installed, setup is always loaded
        if ($this->setup->is_installed()) {
            /**
             * Load Session, Database and Options
            **/

            $this->load->library('session');
            @$this->load->database(); // load new connection
            $this->load->model('options');

            // Get Active Modules and load it
            Modules::init('actives');

            $this->events->do_action('after_app_init');
        }
        // Only for controller requiring installation
        elseif ($this->uri->segment(1) === 'do-setup' && $this->uri->segment(2) === 'database') {
            // @since 3.0.5
                // $this->lang->load( 'system' );	// Load default system Language
                // Deprecated since all languages are included within /language folder and loaded by default.

                $this->events->add_action('before_setting_tables', function () {
                // this hook let modules being called during tendoo installation
                // Only when site name is being defined
                Modules::init('all');
            });
        }
        // if is reserved controllers only
        if (in_array($this->uri->segment(1), $this->config->item('reserved_controllers'))) {
            $this->load->library('notice');
        }

        // Checks system status
        if (in_array($this->uri->segment(1), $this->config->item('reserved_controllers')) || $this->uri->segment(1) === null) {
            // null for index page

            // there are some section which need tendoo to be installed. Before getting there, tendoo controller checks if for those
            // section tendoo is installed. If segment(1) returns null, it means the current section is index. Even for index,
            // installation is required
            if ((in_array($this->uri->segment(1), $this->config->item('controllers_requiring_installation')) || $this->uri->segment(1) === null) && ! $this->setup->is_installed()) {
                redirect(array( 'do-setup' ));
            }

            // loading assets for reserved controller
            $css_libraries        =    $this->events->apply_filters('default_css_libraries', array(
                'bootstrap.min',
                'AdminLTE.min',
                'tendoo',
                'skins/_all-skins.min',
                'font-awesome-4.3.0',
                '../plugins/iCheck/square/blue'
            ));
            
            if ($css_libraries) {
                foreach ($css_libraries as $lib) {
                    $this->enqueue->css($lib);
                }
            }

            /**
             * 	Enqueueing Js
            **/

            $js_libraries        =    $this->events->apply_filters('default_js_libraries', array(
                '../plugins/jQuery/jQuery-2.1.4.min',
                '../plugins/jQuery/jquery-migrate-1.2.1',
                '../plugins/jQueryUI/jquery-ui-1.10.3.min',
                'bootstrap.min',
                '../plugins/iCheck/icheck.min',
                'app.min'
            ));

            if (is_array($js_libraries)) {
                foreach ($js_libraries as $lib) {
                    $this->enqueue->js($lib);
                }
            }
        }
    }
}
