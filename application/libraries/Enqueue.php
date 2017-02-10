<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Enqueue JavaScript and CSS Styles in CodeIgniter with a simple, lightweight library.
 * CodeIgniter_Root/application/libraries/enqueue.php
 * Version: 1.0
 */

class Enqueue
{
    public $scripts = array();
    public $styles = array();
    public $path_js = 'public/js/';
    public $path_css = 'public/css/';
    private $_css_namespace     =   'default';
    private $_js_namespace      =   'default';

    /**
     *  CSS Namespace
     *  @param string current namespace
     *  @return void
    **/

    public function css_namespace( $namespace )
    {
        if( @$this->css[ $namespace ] == null ) {
            $this->css[ $namespace ]    =   array();
        }
        $this->_css_namespace    =   $namespace;
    }

    /**
     *  Js Clear
     *  @param
     *  @return
    **/

    public function css_clear( $namespace = null )
    {
        $this->styles[ $namespace == null ? $this->_css_namespace : $namespace ]    =   [];
    }

    /**
     *  JS Namespace
     *  @param string current namespace
     *  @return void
    **/

    public function js_namespace( $namespace )
    {
        if( @$this->js[ $namespace ] == null ) {
            $this->js[ $namespace ]    =   array();
        }
        $this->_js_namespace    =   $namespace;
    }

    /**
     * Enqueue JS
     *
     * Enqueue js to global queue
     *
     * @access       public
     * @author       blair Jersyer
     * @copyright    name date
     * @param        string $script
     * @since        3.0.1
     */
    public function js($script, $path = null)
    {
        $this->scripts[ $this->_js_namespace ][ basename( $script ) ] = ($path === null) ? base_url() . $this->path_js . $script : $path . $script;
    }

    /**
     *  Js Clear
     *  @param
     *  @return
    **/

    public function js_clear( $namespace = null )
    {
        $this->scripts[ $namespace == null ? $this->_js_namespace : $namespace ]    =   [];
    }

    /**
     * Enqueue CSS
     *
     * Enqueue CSS to global queue
     *
     * @access       public
     * @author       blair Jersyer
     * @copyright    name date
     * @param        string $style
     * @since        3.0.1
     */
    public function css($style, $path    = null)
    {
        $this->styles[ $this->_css_namespace ][ basename( $style ) ] = ($path === null) ? base_url() . $this->path_css . $style : $path . $style;
    }

    /**
     * Output JS
     *
     * output js
     *
     * @access       public
     * @author       blair Jersyer
     * @copyright    name date
     * @since        3.0.1
     */
    public function load_js( $namespace = 'default' )
    {
        if( @$this->scripts[ $namespace ] ) {
            foreach ( $this->scripts[ $namespace ] as $script) {
                echo '<script src="' . $script . '.js"></script>'."\n";
            }
        }
    }

    /**
     * Output CSS
     *
     * output css
     *
     * @access       public
     * @author       blair Jersyer
     * @copyright    name date
     * @since        3.0.1
     */
    public function load_css( $namespace = 'default' )
    {
        if( @$this->styles[ $namespace ] ) {
            foreach ( $this->styles[ $namespace ] as $style) {
                echo '<link rel="stylesheet" href="' . $style . '.css" />'."\n";
            }
        }
    }
}
