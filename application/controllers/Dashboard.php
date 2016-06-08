<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Tendoo_Controller
{
    /**
     * Admin controller
     *
     * Maps to the following URL
     * 		http://example.com/index.php/admin
     *	- or -
     * 		http://example.com/index.php/admin/index
     *	- or -
     * this controller is in other words admin dashboard.
     */

    public function __construct()
    {
        parent::__construct();
        // $this->output->enable_profiler(TRUE);

        // $this->output->enable_profiler(TRUE);
        // All those variable are not required for option interface
        // Special assets loading for dashboard

        // include static libraries
        include_once(LIBPATH .'/Menu.php');
        include_once(LIBPATH .'/Notice.php');

        $this->load->model('Gui', null, 'gui');
        $this->load->model('Update_Model'); // load update model @since 3.0
        $this->load->model('Dashboard_Model', 'dashboard');

        // Loading Admin Menu
        // this action was move to Dashboard controler instead of aside.php output file.
        // which was called every time "create_dashboard_pages" was triggered
        $this->events->do_action('load_dashboard');
    }
    
    /**
     * Remap controller methods
     *
     *
     * @access       public
     * @author       Blair Jersyer
     * @copyright    2015
     * @param        string $page part of segment
     * @param 		  array $params the siblings segments
     * @since        3.0.1
     */
     
    public function _remap($page, $params = array())
    {
        if (method_exists($this, $page)) {
            return call_user_func_array(array( $this, $page ), $params);
        } else {
            $this->Gui->load_page($page, $params);
        }
    }
   
    /**
     * Module List and management controller
     * [New Permission Ready]
     *
     * @access       public
     * @author       Blair Jersyer
     * @copyright    name date
     * @param        string $page
     * @param		  string $arg2
     * @since        3.0.1
     */
     
    public function modules($page = 'list', $arg2 = null, $arg3 = null, $arg4 = null)
    {
        if ($page === 'list') {
            // Can user access modules ?
            if (! User::can('install_modules') &&
                ! User::can('update_modules') &&
                ! User::can('delete_modules') &&
                ! User::can('toggle_modules')
            ) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $this->events->add_filter('gui_page_title', function ($title) {
                return '<section class="content-header"><h1>' . strip_tags($title) . ' <a class="btn btn-primary btn-sm pull-right" href="' . site_url(array( 'dashboard', 'modules', 'install_zip' )) . '">' . __('Upload a zip file') . '</a></h1></section>';
            });

            $this->events->add_action('displays_dashboard_errors', function () {
                if (isset($_GET[ 'extra' ])) {
                    echo tendoo_error(__('An error occured during module installation. There was a file conflict during module installation process.<br>This file seems to be already installed : ' . $_GET[ 'extra' ]));
                }
            });
            $this->Gui->set_title(sprintf(__('Module List &mdash; %s'), get('core_signature')));
            $this->load->view('dashboard/modules/list');
        } elseif ($page === 'install_zip') {
            
            // Can user update/install modules ?
            if (
                ! User::can('install_modules') ||
                ! User::can('update_modules')
            ) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $this->events->add_filter('gui_page_title', function ($title) {
                return '<section class="content-header"><h1>' . strip_tags($title) . ' <a class="btn btn-primary btn-sm pull-right" href="' . site_url(array( 'dashboard', 'modules' )) . '">' . __('Back to modules list') . '</a></h1></section>';
            });

            if (isset($_FILES[ 'extension_zip' ])) {
                $notice    =    Modules::install('extension_zip');
                // it means that module has been installed
                if (is_array($notice)) {
                    // Introducing Migrate
                    if (@$notice[ 'msg' ]    ==    'module-updated-migrate-required') {
                        redirect(array( 'dashboard', 'modules', 'migrate', $notice[ 'namespace' ] ));
                    } else {
                        // Migration will start from this release
                        $this->options->set('migration_' . $notice[ 'namespace' ], $notice[ 'version' ], true);
                        // redirecting						
                    redirect(array( 'dashboard', 'modules', 'list?highlight=' . $notice[ 'namespace' ] . '&notice=' . $notice[ 'msg' ] . (isset($notice[ 'extra' ]) ? '&extra=' . $notice[ 'extra' ] : '') . '#module-' . $notice[ 'namespace' ] ));
                    }
                } else {
                    $this->notice->push_notice($this->lang->line($notice));
                }
            }
            $this->Gui->set_title(sprintf(__('Add a new extension &mdash; %s'), get('core_signature')));
            $this->load->view('dashboard/modules/install');
        } elseif ($page === 'enable') {
            
            // Can user access modules ?
            if (! User::can('toggle_modules')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            /**
             * Module should be enabled before trigger this action
            **/

            Modules::enable($arg2);

            // Enabling recently active module
            Modules::init('unique', $arg2);

            // Run the action
            $this->events->do_action('do_enable_module', $arg2);
                        
            if ($this->events->did_action('do_enable_module')) {
                redirect(array( 'dashboard', 'modules?notice=' . $this->events->apply_filters('module_activation_status', 'module-enabled') ));
            }
        } elseif ($page === 'disable') {
            
            // Can user toggle modules ?
            if (! User::can('toggle_modules')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $this->events->add_action('do_disable_module', function ($arg2) {
                Modules::disable($arg2);
            });
            //
            $this->events->do_action('do_disable_module', $arg2);

            redirect(array( 'dashboard', 'modules?notice=' . $this->events->apply_filters('module_disabling_status', 'module-disabled') ));
        } elseif ($page === 'remove') {
            
            // Can user delete modules ?
            if (! User::can('delete_modules')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $this->events->add_action('do_remove_module', function ($arg2) {
                Modules::uninstall($arg2);
                redirect(array( 'dashboard', 'modules?notice=module-removed' ));
            });

            $this->events->do_action('do_remove_module', $arg2);
        } elseif ($page === 'extract') {
            
            // Can user extract modules ?
            if (! User::can('extract_modules')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $this->events->add_action('do_extract_module', function ($arg2) {
                Modules::extract($arg2);
            });

            $this->events->do_action('do_extract_module', $arg2);
        } elseif ($page == 'migrate' && $arg2 != null && $arg3 == null) {
            
            // Can user extract modules ?
            if (! User::can('update_modules')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $module        =    Modules::get($arg2);
            if (! $module) {
                redirect(array( 'dashboard', 'module-not-found' ));
            }
            $this->Gui->set_title(sprintf(__('Migration &mdash; %s'), get('core_signature')));
            $this->load->view('dashboard/modules/migrate', array(
                'module'    =>    $module
            ));
        } elseif ($page == 'migrate' && $arg3 == 'run' && $arg2 != null) {
            
            // Can user extract modules ?
            if (! User::can('update_modules')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            $module        =    Modules::get($arg2);
            if (! $module) {
                echo json_encode(array(
                    'code'        =>    'error',
                    'msg'        =>    __('Unknow module')
                ));
            } else {    // If module exists
                $migrate_file        =    MODULESPATH . $module[ 'application' ][ 'details' ][ 'namespace' ] . '/migrate.php';
                if (is_file($migrate_file)) {
                    ob_start();
                    $migration_array    =    include_once($migrate_file);
                    // If currrent migration version exists
                    if (@ $migration_array[ $arg4 ]) {
                        // if is file path, it's included
                        if (is_string($migration_array[ $arg4 ]) && is_file($migration_array[ $arg4 ])) {
                            // we asume this file exists
                            @include_once($migration_array[ $arg4 ]);
                        // if it's callable, it's called
                        } elseif (is_callable($migration_array[ $arg4 ])) {
                            $function    =    $migration_array[ $arg4 ];
                            $function($module);
                        } else {
                            $content    =    false;
                        }
                        // When migrate is done the last version key is saved as previous migration version
                        // Next migration will start from here
                        $this->options->set('migration_' . $module[ 'application' ][ 'details' ][ 'namespace' ], $arg4, true);
                    }
                    // Handling error
                    $content    =    ob_get_clean();
                    // If not error occured
                    if (empty($content)) {
                        echo json_encode(array(
                            'code'        =>    'success',
                            'msg'        =>    __('Migration done.')
                        ));
                    } else { // else

                        if ($content === false) {
                            echo json_encode(array(
                                'code'        =>    'error',
                                'msg'        =>    sprintf(__('File not found or incorrect executable provided.'))
                            ));
                        } else {
                            echo json_encode(array(
                                'code'        =>    'error',
                                'msg'        =>    sprintf(__('An error occured'))
                            ));
                        }
                    }
                } else {
                    echo json_encode(array(
                        'code'        =>    'error',
                        'msg'        =>    __('Migration File not found.')
                    ));
                }
            }
        }
    }
    
    /**
     * Options Management ocntroller
     * [New Permission Ready]
     *
     * @access       public
     * @author       blair Jersyer
     * @copyright    name date
     * @param        string $page
     * @param		 string $arg2
     * @since        3.0.1
     */
    
    public function options($mode = 'list')
    {
        if (in_array($mode, array( 'save', 'merge' ))) {
            
            // Can user extract modules ?
            if (! User::can('create_options')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
                        
            if (! $this->input->post('gui_saver_ref') && ! $this->input->post('gui_json')) {
                // if JSON mode is enabled redirect is disabled
                redirect(array( 'dashboard', 'options' ));
            }
            if ($this->input->post('gui_saver_expiration_time') >  gmt_to_local(time(), 'UTC')) {
                $content    =    array();
                
                // loping post value
                global $Options;
                foreach ($_POST as $key => $value) {
                    if (! in_array($key, array( 'gui_saver_option_namespace', 'gui_saver_ref', 'gui_saver_expiration_time', 'gui_saver_use_namespace', 'gui_delete_option_field', 'gui_json' ))) {
                        /**
                         * Merge options which a supposed to be wrapped within the same array
                        **/
                        
                        if ($mode == 'merge' && is_array($value)) {
                            $options    =    $this->options->get($key);
                            $options    =    array_merge(force_array($options), $value);
                        }
                        // save only when it's not an array
                        if (! is_array($_POST[ $key ])) {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                $content[ $key ]    =    ($mode == 'merge') ? $options : $this->input->post($key);
                            } else {
                                if ($mode == 'merge' && is_array($value)) {
                                    $this->options->set($key, $options, true);
                                } else {
                                    $this->options->set($key, $this->input->post($key), true);
                                }
                            }
                        } else {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                $content[ $key ]    =    ($mode == 'merge') ? $options : xss_clean($_POST[ $key ]);
                            } else {
                                if ($mode == 'merge' && is_array($value)) {
                                    $this->options->set($key, $options, true);
                                } else {
                                    $this->options->set($key, xss_clean($_POST[ $key ]), true);
                                }
                            }
                        }
                    }
                    // Fix Checkbox bug, when submiting unchecked box
                    elseif ($key == 'gui_delete_option_field') {
                        foreach (force_array($_POST[ 'gui_delete_option_field' ]) as $field_to_delete) {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                unset($Options[ $this->input->post('gui_saver_option_namespace') ][ $field_to_delete ]);
                                $this->options->set($this->input->post('gui_saver_option_namespace'), $Options[ $this->input->post('gui_saver_option_namespace') ]);
                            } else {
                                $this->options->delete($field_to_delete);
                            }
                        }
                    }
                }
                
                // saving all post using namespace
                if ($this->input->post('gui_saver_use_namespace') == 'true') {
                    $this->options->set($this->input->post('gui_saver_option_namespace'), $content, true);
                }
                
                if (! $this->input->post('gui_json')) { // if JSON mode is enabled redirect is disabled
                    redirect(urldecode($this->input->post('gui_saver_ref')) . '?notice=option-saved');
                }
            }
        } elseif ($mode == 'get') {
            
            // Can user extract modules ?
            if (! User::can('read_options')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
                            
            // Since Option Module already decode JSON
            // Fix bug
            // @since 3.0.5
            echo json_encode($this->options->get(xss_clean($_POST[ 'option_key' ])));
        } elseif (in_array($mode, array( 'save_user_meta', 'merge_user_meta' ))) {
            if (! User::can('edit_profile')) {
                redirect(array( 'dashboard', 'access-denied' ));
            }
            
            if ($this->input->post('gui_saver_expiration_time') >  gmt_to_local(time(), 'UTC')) {
                $content    =    array();
                // loping post value
                foreach ($_POST as $key => $value) {
                    if (! in_array($key, array( 'gui_saver_option_namespace', 'gui_saver_ref', 'gui_saver_expiration_time', 'gui_saver_use_namespace', 'user_id' ))) {
                        if ($mode == 'merge_user_meta' && is_array($value)) {
                            $options    =    $this->options->get($key);
                            $options    =    array_merge(force_array($options), $value);
                        }
                        // save only when it's not an array
                        if (! is_array($_POST[ $key ])) {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                $content[ $key ]    =    ($mode == 'merge') ? $options : $this->input->post($key);
                            } else {
                                if ($mode == 'merge' && is_array($value)) {
                                    $this->options->set($key, $options, true, $this->input->post('user_id'));
                                } else {
                                    $this->options->set($key, $this->input->post($key), true, $this->input->post('user_id'));
                                }
                            }
                        } else {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                $content[ $key ]    =    ($mode == 'merge') ? $options : xss_clean($_POST[ $key ]);
                            } else {
                                if ($mode == 'merge' && is_array($value)) {
                                    $this->options->set($key, $options, true, $this->input->post('user_id'));
                                } else {
                                    $this->options->set($key, xss_clean($_POST[ $key ]), true, $this->input->post('user_id'));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Options Management ocntroller
     * [New Permission Ready]
     *
     * @access       public
     * @author       Blair Jersyer
     * @copyright    name date
     * @param        string $page
     * @param		  string $arg2
     * @since        3.0.1
     */
    public function update($page = 'home',  $version = null)
    {
        if (! Modules::is_active('aauth')) {
            redirect(array( 'dashboard', 'error-occurred?notice=required_module_missing' ));
        }
        
        if (! User::can('manage_core')) {
            redirect(array( 'dashboard', 'access-denied' ));
        }
        
        if ($page === 'core') {
            $this->Gui->set_title(sprintf(__('Updating... &mdash; %s'), get('core_signature')));
            
            $this->load->view('dashboard/update/core', array(
                'release'    =>    $version
            ));
        } elseif ($page === 'download') {
            echo json_encode($this->Update_Model->install(1, $version));
        } elseif ($page === 'extract') {
            echo json_encode($this->Update_Model->install(2));
        } elseif ($page === 'install') {
            echo json_encode($this->Update_Model->install(3));
        } else {
            $this->Gui->set_title(sprintf(__('Update Center &mdash; %s'), get('core_signature')));
            $this->load->view('dashboard/update/home', array());
        }
    }

    /**
     * About controller
     * [New Permission Ready]
     *
     * @access       public
     * @author       blair Jersyer
     * @copyright    name date
     * @since        3.0.1
     */
     
    public function about()
    {
        if (! User::can('manage_core')) {
            redirect(array( 'dashboard', 'access-denied' ));
        }
        
        $this->events-> add_filter('gui_page_title', function () { // disabling header
            return;
        });

        $this->Gui->set_title(sprintf(__('About &mdash; %s'), get('core_signature')));
        $this->load->view('dashboard/about/body');
    }
}
