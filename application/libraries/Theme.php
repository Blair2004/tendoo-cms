<?php 
! defined('APPPATH') ? die('Direct access not allowed.') : null;
class Theme
{
    // Hold loaded themes
    private static $themes    =    array();
    
    /**
     * Load Theme
     * 
     * @param string Path,
     * @return void
    **/
    
    public static function Load($path)
    {
        if (is_dir($path)) {
            $theme_dir    =    opendir($path);
            while (false !== ($file = readdir($theme_dir))) {
                if (! in_array($file, array( '.', '..' ))) {
                    if ($file === 'theme-config.xml') {
                        // if index.php exists		
                        if (is_file($path . '/index.php') || is_file($path . '/blog.php')) {
                            // get config files
                            $config        =    get_instance()->xml2array->createArray(file_get_contents($path . '/' . $file));
                            // adding index and blog file to theme config
                            $config[ 'files' ][ 'index' ]    =  is_file($path . 'index.php') ? $path . 'index.php' : false;
                            $config[ 'files' ][ 'blog' ]    =  is_file($path . 'blog.php') ? $path . 'blog.php' : false;
                            $config[ 'files' ][ 'single' ]    =  is_file($path . 'single.php') ? $path . 'single.php' : false;
                            $config[ 'files' ][ '404' ]    =  is_file($path . '404.php') ? $path . '404.php' : false;
                        }
                    } elseif (is_dir($path . $file)) {
                        self::Load($path . $file . '/');
                    }
                }
            }
            // Adding Valid init file to module array
            // only namespace is required for a module to be valid
            if (isset($config[ 'application' ][ 'details' ][ 'namespace' ])) {
                $namespace = strtolower($config[ 'application' ][ 'details' ][ 'namespace' ]);
                // Saving details
                self::$themes[ $namespace ]                    =    $config;
                self::$themes[ $namespace ][ 'application' ][ 'details' ][ 'namespace' ]    =    $namespace;
            }
        }
    }
    
    /** 
     * Get active Theme
    **/
    
    public static function Get_Active()
    {
        /** 
         * Default Theme is "Hello"
        **/
        
        return @self::$themes[ 'hello' ];
    }
    /**
     * Get Menu as defined on Theme Mode Menu Builder
     * 
     * @param string menu namespace
     * @return array
    **/
    
    public static function Get_Menu_Location($namespace)
    {
        global $Options;
    }
    
    /**
     * 	Register Nav
     *	register a menu location
     * 	@param string location namespace
     * 	@param	string 	location name
     *	@return void
    **/
    
    public static function Register_Nav_Location($location_namespace, $location_name)
    {
        $locations    =    force_array(get_instance()->config->item('theme_locations'));
        
        $locations[ $location_namespace ]    =    $location_name;
        
        get_instance()->config->set_item('theme_locations', $locations);
    }
    
    /** 
     * Get Saved Locations
     * @return array
     * 
     **/
     
     public static function Get_Registered_Nav_Locations()
     {
         return force_array(get_instance()->config->item('theme_locations'));
     }
     
     /**
      * Url Parser
      * Require Post Type to be active
     **/
     
     private static $Is_Home    =    false;
     
    public static function Run_Theme($arguments)
    {
        if (Modules::is_active('post_type')) {
             
              // Load Current available Theme
             Theme::Load(APPPATH . 'themes/');
             
            if (count($arguments)  == 0) {
                        
                 // If not parameters has been defined, we're on home page.
                 self::$Is_Home    =    true;
                 
                 // Load blog Index page
                 $CurrentTheme    =    self::Get_Active();
                if (! empty($CurrentTheme[ 'files' ][ 'index' ])) {
                    include($CurrentTheme[ 'files' ][ 'index' ]);
                } else {
                    show_error(
                        __('Unable to load "index.php" from current theme.')
                     );
                }
            } elseif ($arguments[1] == 'blog' && in_array(@$arguments[2], array( 'p', '' ))) { // we assume for now that "/blog" slug will load blog.php from Theme folder
                // Load blog Index page
                 $CurrentTheme    =    self::Get_Active();
                if (! empty($CurrentTheme[ 'files' ][ 'blog' ])) {
                    include($CurrentTheme[ 'files' ][ 'blog' ]);
                } else {
                    show_error(
                        __('Unable to load "blog.php" from current theme.')
                     );
                }
            } elseif ($arguments[1] == 'blog' && @$arguments[2] != 'p') {
                // Load blog Index page
                 $CurrentTheme    =    self::Get_Active();
                if (! empty($CurrentTheme[ 'files' ][ 'single' ])) {
                    include($CurrentTheme[ 'files' ][ 'single' ]);
                } else {
                    show_error(
                        __('Unable to load "single.php" from current theme.')
                     );
                }
            } elseif ($arguments[1] == '404') {
                // Load blog Index page
                 $CurrentTheme    =    self::Get_Active();
                if (! empty($CurrentTheme[ 'files' ][ '404' ])) {
                    include($CurrentTheme[ 'files' ][ '404' ]);
                } else {
                    show_error(
                        __('Unable to load "404.php" from current theme.')
                     );
                }
            }
        } else {
            show_error(
                sprintf(__('Post Type module is not enabled. <a href="%s">Please log in and install/enable</a> the module first'), site_url(array( 'dashboard' )))
            );
            die;
        }
    }
     
     /** 
      * Conditional Tags
     **/
         
     public function Is_Home()
     {
         return self::$Is_Home;
     }
}
