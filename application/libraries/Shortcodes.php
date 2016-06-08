<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Shortcodes class
 *
 * @package	SwarmTv
 * @subpackage	Libraries
 * @category	shortcodes
 * @author	Alcwyn Parker
 * @link	http://www.alcwynparker.co.uk
 */

class Shortcodes
{

    private $shortcodes = null;

    //private $accepted_keys = array('internal', 'external', 'youtube', 'vimeo');

    //private $accepted_styling = array('b','i','u');

    private $original_string = "";
    private $adapted_string = "";

    private $modified = false;

    /**
     * Shortcodes Constructor
     *
     * Instantiate the array to store shortcodes in
     * 
     */
    public function __construct()
    {
        $this->shortcodes = array();
    }
    // --------------------------------------------------------------------
    // PUBLIC METHODS
    // --------------------------------------------------------------------

    /**
     * Break up the raw string into shortcodes and save them to list
     *
     * @access	public
     * @return	null
     */
    public function process_string($string)
    {
        $this->original_string = $string;
        $this->adapted_string = $string;
        $pattern = "/(?<=\[\[)[\w \!\?\&\+'=@:\/\.\\\-]+(?=\]\])/"; // [[ ... ]] regex
        $short_code_info = null;

        // find all the links in $string
        // execute the regex on string and populate $links array storing the offset with the match
        preg_match_all($pattern, $string, $short_code_info, PREG_OFFSET_CAPTURE);

        // loop through the results of the regex and process shortcodes
        foreach ($short_code_info[0] as $info) {
            $sc = new Shortcode($info[0], $info[1]);
            $this->add_short_code($sc);
        }
    }

    // --------------------------------------------------------------------

    /**
     * returns the total number of short codes in the string
     *
     * @access	public
     * @return	int
     */
    public function length()
    {
        return (sizeof($this->shortcodes));
    }

    // --------------------------------------------------------------------

    /**
     * returns an array of shortcodes by their key type
     * @param 	array of string for accepted keys
     * @access	public
     * @return	array of arrays [shortcodes][index in main array]
     */
    public function return_shortcodes_by_key($types)
    {
        $short_codes_by_type = array();

        foreach ($types as $type) {
            for ($i = 0; $i < sizeof($this->shortcodes);$i++) {
                if ($this->shortcodes[$i]->getKey() === $type) {
                    $match['shortcode']    = $this->shortcodes[$i];
                    $match['index']    = $i;
                    array_push($short_codes_by_type, $match);
                }
            }
        }
        return ($short_codes_by_type);
    }

    // --------------------------------------------------------------------

    /**
     * alters a duplicate of the original text with the replacement for the short code
     * @param 	index of short code in the shortcode array, the replacement html
     * @access	public
     * @return	n/a
     */
    public function replaceShortCodeWithHTML($index, $html)
    {
        $length = strlen($html);
        $original_length = $this->shortcodes[$index]->getLength();

        // get the difference in the length of the short code to the new html
        $diff = $length - ($original_length);

        //loop through all the short codes and update their start and end position
        for ($i = 0; $i < sizeof($this->shortcodes); $i++) {
            if (($i != $index) && ($this->shortcodes[$i]->getStart() >$this->shortcodes[$index]->getStart())) {
                $this->shortcodes[$i]->moveBy($diff);
            }
        }

        // update the adapted string with the change
        $this->adapted_string = substr_replace($this->adapted_string, $html, $this->shortcodes[$index]->getStart()-2, $this->shortcodes[$index]->getLength()+4);
    }

    // -------------------------------------------------------------------- 
    // PRIVATE METHODS
    // --------------------------------------------------------------------

    /**
     * Fetch the current session data if it exists
     *
     * @access	private
     * @return	null
     */
    private function add_short_code($short_code)
    {
        array_push($this->shortcodes, $short_code);
    }

    // --------------------------------------------------------------------
    // GETTERS & SETTERS
    // --------------------------------------------------------------------

    public function getAdaptedString()
    {
        return $this->adapted_string;
    }
}

/**
 * Shortcode class
 *
 * @package	SwarmTv
 * @subpackage	Libraries
 * @category	shortcodes
 * @author	Alcwyn Parker
 * @link	http://www.alcwynparker.co.uk
 */

class Shortcode
{
    // property declaration
    private $raw = null;
    private $length = null;
    private $start = 0;
    private $end = 0;
    private $key = '';
    private $value = '';

    /**
     * Shortcodes Constructor
     *
     * Initiates the starting parameters and kicks of the process of breaking
     * the shortcode into its constituents. 
     */
    public function __construct($raw, $start)
    {
        $this->raw = $raw;
        $this->start = $start;

        $this->process_raw_shortcode();
    }

    // --------------------------------------------------------------------

    /**
     * moves the start and end of a shortcode in conjunction with a shortcode modification
     * before it
     * @param 	the amount the code has to move by
     * @access	public
     * 
     */
    public function moveBy($diff)
    {
        $this->start    = $this->start + $diff;
        $this->end    = $this->end + $diff;
    }

    // --------------------------------------------------------------------
    // PRIVATE METHODS
    // --------------------------------------------------------------------

    /**
     * find out more info about the shortcode and break it apart
     *
     * @access	private
     * @return	null
     */
    private function process_raw_shortcode()
    {
        // GENERAL DETAILS
        $this->length    = strlen($this->raw);
        $this->end    = $this->start + $this->length;

        // KEY & VALUE
        $key_val_pair    = explode('::', $this->raw);

        // check to see if both key and value have been given
        if (sizeof($key_val_pair) > 1) {
            $this->key = $key_val_pair[0];
            $this->value = $key_val_pair[1];
        } else {
            $http = strpos($this->raw, 'http');

            if ($http === false) {
                $this->key = 'internal';
            } else {
                $this->key = 'external';
            }
            $this->value = $this->raw;
        }
    }

    // --------------------------------------------------------------------
    // GETTERS & SETTERS
    // --------------------------------------------------------------------

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getLength()
    {
        return $this->length;
    }
}
