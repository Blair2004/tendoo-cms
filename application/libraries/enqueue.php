<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Enqueue JavaScript and CSS Styles in CodeIgniter with a simple, lightweight library.
 * CodeIgniter_Root/application/libraries/enqueue.php
 * Version: 1.0
 */

class Enqueue {
	public $scripts;
	public $styles;
	public $path_js;
	public $path_css;
	
	public function __construct( $path_js = 'public/js/', $path_css = 'public/css/' ) {
		$this->scripts = array();
		$this->styles = array();
		$this->path_js = $path_js;
		$this->path_css = $path_css;
	}
	
	public function enqueue_js( $script, $jsHelper = null ) {
		$this->scripts[] = (string)$script;
	}
	
	public function enqueue_css( $style ) {
		$this->styles[] = (string)$style;
	}
	
	public function loadjs() {
		foreach( $this->scripts as $script ) {
			echo '<script src="' . base_url() . $this->path_js . $script . '.js" async></script>'."\n";
		}
	}
	
	public function loadcss() {
		foreach( $this->styles as $style ) {
			echo '<link rel="stylesheet" href="' . base_url() . $this->path_css . $style . '.css" />'."\n";
		}
	}
}
