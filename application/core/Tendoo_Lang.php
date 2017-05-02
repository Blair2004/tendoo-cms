<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Language Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Language
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/language.html
 */
class Tendoo_Lang
{

    /**
     * List of translations
     *
     * @var	array
     */
    public $language =    array();

    /**
     * List of loaded language files
     *
     * @var	array
     */
    public $is_loaded =    array();

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct()
    {
        log_message('info', 'Language Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Load a language file
     *
     * @param	mixed	$langfile	Language file name
     * @param	string	$idiom		Language name (english, etc.)
     * @param	bool	$return		Whether to return the loaded array of translations
     * @param 	bool	$add_suffix	Whether to add suffix to $langfile
     * @param 	string	$alt_path	Alternative path to look for the language file
     *
     * @return	void|string[]	Array containing translations, if $return is set to TRUE
     */
    public function load($langfile, $idiom = '', $return = false, $add_suffix = true, $alt_path = '')
    {
        if (is_array($langfile)) {
            foreach ($langfile as $value) {
                $this->load($value, $idiom, $return, $add_suffix, $alt_path);
            }

            return;
        }

        $langfile = str_replace('.php', '', $langfile);

        if ($add_suffix === true) {
            $langfile = preg_replace('/_lang$/', '', $langfile).'_lang';
        }

        $langfile .= '.php';

        if (empty($idiom) or ! preg_match('/^[a-z_-]+$/i', $idiom)) {
            $config =& get_config();
            $idiom = empty($config['language']) ? 'english' : $config['language'];
        }

        if ($return === false && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom) {
            return;
        }

        // Load the base file, so any others found can override it
        $basepath = BASEPATH.'language/'.$idiom.'/'.$langfile;
        if (($found = file_exists($basepath)) === true) {
            include($basepath);
        }

        // Do we have an alternative path to look in?
        if ($alt_path !== '') {
            $alt_path .= 'language/'.$idiom.'/'.$langfile;
            if (file_exists($alt_path)) {
                include($alt_path);
                $found = true;
            }
        } else {
            foreach (get_instance()->load->get_package_paths(true) as $package_path) {
                $package_path .= 'language/'.$idiom.'/'.$langfile;
                if ($basepath !== $package_path && file_exists($package_path)) {
                    include($package_path);
                    $found = true;
                    break;
                }
            }
        }

        if ($found !== true) {
            show_error('Unable to load the requested language file: language/'.$idiom.'/'.$langfile);
        }

        if (! isset($lang) or ! is_array($lang)) {
            log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);

            if ($return === true) {
                return array();
            }
            return;
        }

        if ($return === true) {
            return $lang;
        }

        $this->is_loaded[$langfile] = $idiom;
        $this->language = array_merge($this->language, $lang);

        log_message('info', 'Language file loaded: language/'.$idiom.'/'.$langfile);
        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Language line
     *
     * Fetches a single line of text from the language array
     *
     * @param	string	$line		Language line key
     * @param	bool	$log_errors	Whether to log an error message if the line is not found
     * @return	string	Translation
     */
    public function line($line, $log_errors = true)
    {
        $value = isset($this->language[$line]) ? $this->language[$line] : false;

        // Because killer robots like unicorns!
        if ($value === false && $log_errors === true) {
            log_message('error', 'Could not find the language line "'.$line.'"');
        }

        return $value;
    }
    
    /**
     * Load Language Line
     * 
     * @return void
     * @since 3.0.9
     * @author Blair Jersyer
    **/
    
    public function load_lines($path = null, $is_file = false)
    {
        $lang            =    array();
        if ($is_file) {
            if (is_file($path)) {
                include $path;
            } else {
                show_error(__('Unable to load the requested lang file'));
            }
        } else {
            foreach ( glob($path) as $filename) {
                if (is_file($filename)) {
                    include $filename;
                } else {
                    show_error(__('Unable to load the requested lang file'));
                }
            }
        }
        
        $this->language = array_merge($this->language, $lang);
    }
}
