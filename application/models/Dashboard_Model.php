<?php
/**
 *
 * Title 	:	 Dashboard model
 * Details	:	 Manage dashboard page (creating, ouput)
 *
**/

class Dashboard_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->events->add_action('load_dashboard', array( $this, '__set_admin_menu' ));
        $this->events->add_action('create_dashboard_pages', array( $this, '__dashboard_config' ));
        $this->events->add_action('load_dashboard', array( $this, 'before_session_starts' ));
        // $this->events->add_filter( 'dashboard_home_output', array( $this, '__home_output' ) );
    }


    /**
     * 	Edit Tendoo.php config before session starts
     *
     *	@return	: void
    **/

    public function before_session_starts()
    {
        $this->config->set_item('tendoo_logo_long', '<b>Tend</b>oo');
        $this->config->set_item('tendoo_logo_min', '<img id="tendoo-logo" style="height:30px;" src="' . img_url() . 'logo_minim.png' . '" alt=logo>');
    }

    /**
     * Load dashboard widgets
     * @return void
    **/

    public function load_widgets()
    {
        // get global widget and cols
        global $AdminWidgets;
        global $AdminWidgetsCols;

        $SavedAdminWidgetsCols        =    $this->options->get('admin_widgets', User::id());
        $FinalAdminWidgetsPosition    =    array_merge($AdminWidgetsCols, force_array($SavedAdminWidgetsCols));

        // looping cols
        unset($this->Gui->cols[ 4 ]);
        // var_dump( $this->Gui->cols );die;

        for ($i = 1; $i <= count($this->Gui->cols); $i++) {
            $widgets_namespace    =    $this->dashboard_widgets->col_widgets($i);

            $this->Gui->col_width(1, 1);
            $this->Gui->col_width(2, 1);
            $this->Gui->col_width(3, 1);

            foreach ($widgets_namespace as $widget_namespace) {
                // get widget
                $widget_options    =    $this->dashboard_widgets->get($widget_namespace, User::id());
                // create meta
                $meta_array        =    array(
                    'col_id'    =>    $i,
                    'namespace'    =>    $widget_namespace,
                    'type'        =>    riake('type', $widget_options),
                    'title'        =>    riake('title', $widget_options)
                );

                $meta_array        =    array_merge($widget_options, $meta_array);
                $this->Gui->add_meta($meta_array);
                // create dom
                $this->Gui->add_item(array(
                    'type'        =>    'dom',
                    'content'    =>    riake('content', $widget_options) // $this->load->view( riake( 'content', $widget_options, '[empty_widget]' ), array(), true )
                ), $widget_namespace, $i);
            }
        }
    }


    /**
     * Dashboard Config
     *
     * @return void
    **/

    public function __dashboard_config()
    {
        $this->Gui->register_page('index', array( $this, 'index' ));
        $this->Gui->register_page('settings', array( $this, 'settings' ));
    }

    /**
     * Dashboard Home Load
     *
     * @return void
    **/

    public function index()
    {
        // load widget model here only
        $this->load->model('Dashboard_Widgets_Model', 'dashboard_widgets');

        // trigger action while loading home (for registering widgets)
        $this->events->do_action('load_dashboard_home');
        $this->load_widgets();

        $this->Gui->set_title(sprintf(__('Dashboard &mdash; %s'), get('core_signature')));
        $this->load->view('dashboard/index/body');
    }

    /**
     * Load Tendoo Setting Page
     * [New Permission Ready]
     * @return void
    **/

    public function settings()
    {
        // Can user access modules ?
        if (! User::can('create_options') &&
            ! User::can('edit_options') &&
            ! User::can('delete_options')
        ) {
            redirect(array( 'dashboard', 'access-denied' ));
        }

        $this->Gui->set_title(sprintf(__('Settings &mdash; %s'), get('core_signature')));
        $this->load->view('dashboard/settings/body');
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     *
     * @return void
    **/

    public function __set_admin_menu()
    {
        $admin_menus[ 'dashboard' ][]    =    array(
            'href'            =>        site_url('dashboard'),
            'icon'            =>        'fa fa-dashboard',
            'title'            =>        __('Dashboard')
        );

        if (User::can('manage_core')) {
            $admin_menus[ 'dashboard' ][]    =    array(
                'href'            =>        site_url(array( 'dashboard', 'update' )),
                'icon'            =>        'fa fa-dashboard',
                'title'            =>        __('Update Center'),
                'notices_nbr'    =>        $this->events->apply_filters('update_center_notice_nbr', 0)
            );

            $admin_menus[ 'dashboard' ][]    =    array(
                'href'            =>        site_url(array( 'dashboard', 'about' )),
                'icon'            =>        'fa fa-dashboard',
                'title'            =>        __('About'),
            );
        }

        if (
            User::can('install_modules') ||
            User::can('update_modules') ||
            User::can('extract_modules') ||
            User::can('delete_modules') ||
            User::can('toggle_modules')
         ) {
            $admin_menus[ 'modules' ][]        =    array(
                'title'            =>        __('Modules'),
                'icon'            =>        'fa fa-puzzle-piece',
                'href'            =>        site_url('dashboard/modules')
            );
        }

        if (
            User::can('create_options') ||
            User::can('read_options') ||
            User::can('edit_options') ||
            User::can('delete_options')
         ) {
            $admin_menus[ 'settings' ][]    =    array(
                'title'            =>        __('Settings'),
                'icon'            =>        'fa fa-cogs',
                'href'            =>        site_url('dashboard/settings')
            );
        }

        foreach (force_array($this->events->apply_filters('admin_menus', $admin_menus)) as $namespace => $menus) {
            foreach ($menus as $menu) {
                Menu::add_admin_menu_core($namespace, $menu);
            }
        }
    }
}
