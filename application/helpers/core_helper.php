<?php  if (! defined('BASEPATH')) {
     exit('No direct script access allowed');
 }

/**
 * Force a var to be an array.
 *
 * @param Var
 * @return Array
**/
function force_array($array)
{
    if (is_array($array)) {
        return $array;
    }
    return array();
}

/**
 * Output message with error tag
 *
 * @param String (error code)
 * @return String (Html result)
 * @package 3.0
**/

if (!function_exists('tendoo_error')) {
    function tendoo_error($text)
    {
        return '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> '.$text.'</div>';
    }
}

/**
 * Output message with success tag
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('tendoo_success')) {
    function tendoo_success($text)
    {
        return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-thumbs-o-up"></i> '.$text.'</div>';
    }
}

/**
 * Output message with warning tag
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('tendoo_warning')) {
    function tendoo_warning($text)
    {
        return '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> '.$text.'</div>';
    }
}

/**
 * Output message with Info tag
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('tendoo_info')) {
    function tendoo_info($text)
    {
        return '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-info"></i> '.$text.'</div>';
        ;
    }
}

/**
 * Convert short string to long notice message
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('fetch_error')) {
    function fetch_notice_output($e, $extends_msg= '', $sort = false)
    {
        if (is_string($e)) {
            $notices        =    force_array(get_core_vars('tendoo_notices'));
            if (in_array($e, $notices) || array_key_exists($e, $notices)) {
                return $notices[$e];
            } elseif (isset($notices)) {
                if (array_key_exists($e, $notices)) {
                    return $notices[$e];
                } else {
                    return tendoo_warning(__(sprintf('"%s" is not a valid error code', $e)));
                }
            } elseif ($e != '' && strlen($e) <= 50) {
                return tendoo_warning(__(sprintf('"%s" is not a valid error code', $e)));
            } else {
                return $e;
            }
        }
        return false;
    }
}

/**
 * Output message from URL
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('fetch_notice_from_url')) {
    function fetch_notice_from_url()
    {
        $notice = '';
        if (isset($_GET['notice'])) {
            $notice    = get_instance()->lang->line($_GET['notice']);
        }
        return $notice;
    }
}

/**
 * Return true or false if numeric var is between two numbers
 *
 * @param Int( Min ), Int( Max ), $subject
 * @return Bool
**/

if (!function_exists('between')) {
    function between($min, $max, $var) // Site Url Plus
    {
        if ($min >= $max || $min == $max) {
            return false;
        }
        if ((int)$var >= $min && (int)$var <= $max) {
            return true;
        }
        return false;
    }
}

/**
*	Returns if array key exists. If not, return false if $default is not set or return $default instead
*	@access		:	Public
*	@param		:	String (Key), $subject, $default
**/

function riake($key, $subject, $default = false)
{
    if (is_array($subject)) {
        return array_key_exists($key, $subject) ? $subject[ $key ] : $default;
    }
    return $default;
}

/**
 * Return first index from a given Array
 *
 * @access 	:	public
 * @param 	:	Array
 * @return 	:	Array/False
 * @note 	:	Return False if index doesn't exists or if param is not an array.
**/

function farray($array)
{
    return riake(0, $array, false);
}

/**
*	get recupère des informations sur le système.
**/
function get($key) // add to doc
{
    $instance    =    get_instance();
    switch ($key) {
        case "str_core"        :
            return $instance->config->item('version');
        break;
        case "core_version"    :
            return (float) $instance->config->item('version');
        break;
        case "core_signature"    :
            return $instance->config->item('core_signature');
        break;
        case "declared-shortcuts"    :
            return get_declared_shortcuts();
        break;
        case 'app_name':
            return $instance->config->item( 'core_app_name' );
        break;
    }
}

if (!function_exists('translate')) {

    /**
     * Alias of "translate"
    **/

    function __($code, $templating = 'tendoo-core')
    {
        return translate($code, $templating);
    }

    /**
     * Alias of __, but echo instead
    **/

    function _e($code, $templating = 'tendoo-core')
    {
        echo __($code, $templating);
    }

    /**
     * Echo Translation filtered with addslashes
     * @param string code
     * @param string text domain
     * @return string
    **/

    function _s($code, $templating)
    {
        return addslashes(__($code, $templating));
    }

    /**
     * Get translated text
     * @param string text string
     * @param string text domain
     * @return string translated text
    **/

    function translate($code, $textdomain = 'tendoo-core')
    {
        $instance        =    get_instance();
        global $Options, $LangFileHandler, $PoParsed;

        $text_domains    =    $instance->config->item('text_domain');

        if (in_array($textdomain, array_keys($text_domains))) {
            $lang_file    =    $text_domains[ $textdomain ] . '/' . $instance->config->item('site_language') . '.po';

            if (is_file($lang_file)) {
                if (! isset($LangFileHandler[ $textdomain ])) {
                    $LangFileHandler[ $textdomain ]        =    new Sepia\FileHandler($lang_file);
                    $PoParsed[ $textdomain ]            =    new Sepia\PoParser($LangFileHandler[ $textdomain ]);
                    $PoParsed[ $textdomain ]->parse();
                    $PoParsed[ $textdomain ]->AllEntries    =    $PoParsed[ $textdomain ]->entries();

                    foreach ($PoParsed[ $textdomain ]->AllEntries as $key => $entry) {
                        $newKey                        =    str_replace('<##EOL##>', '', $key);
                        if ($key !== $newKey) {
                            $PoParsed[ $textdomain ]->AllEntries[ $newKey ] = $entry;
                            unset($PoParsed[ $textdomain ]->AllEntries[ $key ]); //unset key
                        }
                    }
                }

                return implode('', riake('msgstr', riake($code, $PoParsed[ $textdomain ]->AllEntries, array( 'msgstr' => array( $code ) ))));
            }
        }
        return $code;
    }
}

/**
 * Output array details
 * @access public
 * @param Array
 * @param Bool
 * @return String
**/

function print_array($array, $return = false)
{
    ob_start();
    echo '<pre>';
    print_r($array, $return);
    echo '</pre>';
    return $return ? ob_get_clean() : null;
}

/**
 * date_now()
 * Returns current date considering Tendoo settings
 *
 * @access public
 * @since 3.0.4
 * @param string date format
 * @author Blair Jersyer
 * @return string date
**/

function date_now( $format = DATE_W3C )
{
    return date( $format, date_timestamp());
}

/**
 * Date Timestamp
 * Returns a UNIX Timestamp based on Current site settings
 *
 * @access public
 * @since 3.0.5
 * @author Blair Jersyer
 * @returns int Unix Timestamp
**/

function date_timestamp()
{
    global $Options;

    // while using options from CI_Controller interface

    if ($Options == null) {
        $query                          =    get_instance()->db->where('key', 'site_timezone')->get('options');
        $result                         =    $query->result_array();
        $Options[ 'site_timezone' ]     =    @$result[0][ 'key' ];
    }

    return now( @$Options[ 'site_timezone' ] );
}

/**
 * Pagination Helper
 *
 * @access public
 * @param int
 * @param int
 * @param int
 * @param string
 * @param string url
 * @param string url
 * @return array
**/
function pagination_helper($ContentPerPage, $TotalContent, $CurrentPage, $BaseUrl, $RedirectUrl = array('error', 'code', 'page-404'))
{
    $instance    =    get_instance();
    $result        =    doPaginate($ContentPerPage, $TotalContent, $CurrentPage, $BaseUrl);
    if ($result[0] == 'page-404'): redirect($RedirectUrl);
    endif;
    return $result;
}
function doPaginate($elpp, $ttel, $current_page, $baselink)
{
    /*// Gloabl ressources Control*/
    if (!is_finite($elpp))                : echo '<strong>$elpp</strong> is not finite';
    return; elseif (!is_finite($current_page))    : echo '<strong>$current_page</strong> is not finite';
    return;
    endif;

    $more    =    array();
    $ttpage = ceil($ttel / $elpp);
    if (($current_page > $ttpage || $current_page < 1) && $ttel > 0): return array(
        'start'                =>    0,
        'end'                =>    0,
        'page-404',            // 	Deprécié
        array(),            // 	Déprécié
        'status'            =>    'page-404',
        'pagination'        =>    array(),
        'available_pages'    =>    0,
        'current_page'        =>    0
    );
    endif;
    $firstoshow = ($current_page - 1) * $elpp;
    /*// FTS*/
    if ($current_page < 5):$fts = 1; elseif ($current_page >= 5):$fts = $current_page - 4;
    endif;
    /*// LTS*/
    if (($current_page + 4) <= $ttpage):$lts = $current_page + 4;
    /*elseif($ttpage > 5):$lts = $ttpage - $current_page;*/
    else:$lts = $ttpage;
    endif;

    $content = null;
    for ($i = $fts;$i<=$lts;$i++) {
        $more[]    =    array(
            'link'    =>    $baselink.'/'.$i,
            'text'    =>    $i,
            'state'    =>    ((int)$i === (int)$current_page) ? "active" : "" // Fixing int type 03.11.2013
        );
    }
    return array(
        'start'                =>    $firstoshow,
        'end'                =>    $elpp,
        'pageExists',        // 	Deprécié
        $more,                // 	Déprécié
        'status'            =>    'pageExists',
        'pagination'        =>    $more,
        'available_pages'    =>    $ttpage,
        'current_page'        =>    $current_page
    );
}
/**
 * __return_true
 *
 * @return bool true
**/

function __return_true()
{
    return true;
}

/**
 * __return_false
 *
 * @return bool false
**/

function __return_false()
{
    return false;
}

/*
 * Inserts a new key/value before the key in the array.
 *
 * @param $key
 * The key to insert before.
 * @param $array
 * An array to insert in to.
 * @param $new_key
 * The key to insert.
 * @param $new_value
 * An value to insert.
 *
 * @return
 * The new array if the key exists, FALSE otherwise.
 *
 * @see array_insert_after()
 */
function array_insert_before($key, $array, $new_key, $new_value)
{
    if (array_key_exists($key, $array)) {
        $new = array();
        foreach ($array as $k => $value) {
            if ($k === $key) {
                $new[$new_key] = $new_value;
            }
            $new[$k] = $value;
        }
        return $new;
    }
    return false;
}

/*
 * Inserts a new key/value after the key in the array.
 *
 * @param $key
 * The key to insert after.
 * @param $array
 * An array to insert in to.
 * @param $new_key
 * The key to insert.
 * @param $new_value
 * An value to insert.
 *
 * @return
 * The new array if the key exists, FALSE otherwise.
 *
 * @see array_insert_before()
 */
function array_insert_after($key, &$array, $new_key, $new_value)
{
    if (array_key_exists($key, $array)) {
        $new = array();
        foreach ($array as $k => $value) {
            $new[$k] = $value;
            if ($k === $key) {
                $new[$new_key] = $new_value;
            }
        }
        return $new;
    }
    return false;
}

/**
 * is
 * Return boolean whether an item is a bool or not
 * @param string page string slug
**/

function page_is( $page ) {
	if( $page == get_instance()->uri->segment(3) ) {
		return true;
	}
	return false;
}

/**
 *  Get Cache with same prefix
 *  @param string cache prefix
 *  @return array
**/

function get_prefixed_cache( $prefix )
{
    $path           =   get_instance()->config->item('cache_path');
    $cache_path     =   ($path === '') ? APPPATH.'cache/' : $path;
    $cache_array	=	array();

    if (is_dir($cache_path)) {
        if ($dh = opendir($cache_path)) {
            while( ( $file = readdir( $dh ) ) !== false ) {
                $limit	=	strlen( $prefix );
                $file_prefix	=	substr( $file, 0, $limit );

                if( $file_prefix == $prefix ) {
                    $cache_array[ $file ]	= 	unserialize( file_get_contents( $cache_path . $file ) );

                    if ($cache_array[ $file ]['ttl'] > 0 && time() > $cache_array[ $file ]['time'] + $cache_array[ $file ]['ttl'])

                    {
                        $cache_array[ $file ]	=	array();
                        unlink( $cache_path . $file );
                    }
                }
            }
            closedir( $dh );
        }
    }

    return $cache_array;
}

/**
 *  Unique Multi Dimensionnal Array
 *  @param array Multi dimentional Array
 *  @param string key
 *  @return array a filtred array
**/

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

/**
 *  Get Options
 *  @param string option key
 *  @return string/int/array
**/

function get_option( $key = null ) {
    global $Options;
    if( $key != null ) {
        return @$Options[ 'key' ];
    }
    return $Options;
}
/* End of file core_helper.php */
