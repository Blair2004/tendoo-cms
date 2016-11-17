<?php
class Dashboard_Widgets_Model extends CI_Model
{
    public function __construct()
    {
		global $AdminWidgetsCols;
		if ($AdminWidgetsCols === null) {
			$AdminWidgetsCols    =    force_array($this->options->get('dashboard_widget_position', User::id()));
		}
    }
    
    /**
     * Create a new Admin Widget
     * 
     * @since 3.1
     * @access public
     * @param string widget namespace
     * @param array widget config
     * @return void
    **/
    
    public function add($namespace, $config)
    {
        // Get Admin Widgets
        global $AdminWidgets;
        $AdminWidgets = ($AdminWidgets === null) ? array() : $AdminWidgets;
        
        $AdminWidgets[ $namespace ]    =    $config;
        $this->save_position($namespace, riake('position', $config, 1));
    }
    
    /**
     * Load saved Admin widget
     *
     * @access public
     * @since 3.1
     * @return array
    **/
    
    public function get($namespace)
    {
        global $AdminWidgets;
        $AdminWidgets === null ? array() : $AdminWidgets;
        
        // if widgets exists
        if (isset($AdminWidgets[ $namespace ])) {
            return $AdminWidgets[ $namespace ];
        }
        return array();
    }
    
    /**
     * Output Widget
     * 
     * @since 3.1
     * @return void
     * @param array widget config
     * @access public
    **/
    
    public function displays($widget_config)
    {
        if ($view_path = riake('view', $widget_config)) {
            $output    = $this->load->view($view_path, array(), true);
        }
    }
    
    /**
     * Save Widget Position
     * 
     * @since 3.1
     * @param string widget namespace
     * @param int col id
     * @return void
     * @access public
    **/
    
    public function save_position($widget_namespace, $col_id)
    {
		global $AdminWidgetsCols;
		// is widget already exists within a cols, this save is ignored
		if (is_array($AdminWidgetsCols)) {
			foreach ($AdminWidgetsCols as $cols) {
				if (in_array($widget_namespace, $cols)) {
					return;
				}
			}
		}
		if (! isset($AdminWidgetsCols[ $col_id ])) {
			$AdminWidgetsCols[ $col_id ]    =    array();
		}
		if (! in_array($widget_namespace, $AdminWidgetsCols[ $col_id ])) {
			$AdminWidgetsCols[ $col_id ][]    =    $widget_namespace;
			$this->options->set('dashboard_widget_position', $AdminWidgetsCols, true, User::id());
		}
    }
    
    /**
     * Save Widget posistions
     * 
     * @param string namespace
     * @param int Col Id
     * @return void
    **/
    
    public function save_positions($widgets_namespaces, $col_id)
    {
		global $AdminWidgetsCols;
		$AdminWidgetsCols[ $col_id ]    =    $widgets_namespaces;
		$this->options->set('dashboard_widget_position', $AdminWidgetsCols, true, User::id());
    }
    
    /**
     * get Position widgets
     * 
     * @access public
     * @return array
     * @param int col id
     * @since 3.1
    **/
    
    public function col_widgets($col_id)
    {
        global $AdminWidgetsCols;
        return riake($col_id, $AdminWidgetsCols, array());
    }
	
	/**
	 * Remove Widget
	 *
	 * @param string widget namespace
	**/
	
	public function remove( $namespace ) 
	{
		global $AdminWidgets;
		if( isset( $AdminWidgets[ $namespace ] ) ) {
			unset( $AdminWidgets[ $namespace ] );
		}
	}
}
