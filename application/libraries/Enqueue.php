<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Enqueue JavaScript and CSS Styles in CodeIgniter with a simple, lightweight library.
 * CodeIgniter_Root/application/libraries/enqueue.php
 * Version: 1.0
 */

class Enqueue {
	public $scripts = array();
	public $styles = array();
	public $path_js = 'public/js/';
	public $path_css = 'public/css/';
	
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
	public function js( $script, $path = null ) {
		$this->scripts[] = ( $path === null ) ? $this->path_js . $script : $path . $script;
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
	public function css( $style, $path	= null ) {
		$this->styles[] = ( $path === null ) ? $this->path_css . $style : $path . $style;
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
	public  function load_js() {
		foreach( $this->scripts as $script ) {
			echo '<script src="' . base_url() . $script . '.js"></script>'."\n";
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
	public  function load_css() {
		foreach( $this->styles as $style ) {
			echo '<link rel="stylesheet" href="' . base_url() . $style . '.css" />'."\n";
		}
	}
}
