<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Enqueue JavaScript and CSS Styles in CodeIgniter with a simple, lightweight library.
 * CodeIgniter_Root/application/libraries/enqueue.php
 * Version: 1.0
 */

class Enqueue {
	public static $scripts = array();
	public static $styles = array();
	public static $path_js = 'public/js/';
	public static $path_css = 'public/css/';
	
	public static function enqueue_js( $script, $jsHelper = null ) {
		self::$scripts[] = (string)$script;
	}
	
	public static function enqueue_css( $style ) {
		self::$styles[] = (string)$style;
	}
	
	public static function loadjs() {
		foreach( self::$scripts as $script ) {
			echo '<script src="' . base_url() . self::$path_js . $script . '.js"></script>'."\n";
		}
	}
	
	public static function loadcss() {
		foreach( self::$styles as $style ) {
			echo '<link rel="stylesheet" href="' . base_url() . self::$path_css . $style . '.css" />'."\n";
		}
	}
}
