<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Force a var to be an array.
 *
 * @param Var
 * @return Array
**/
function force_array( $array )
{
	if( is_array( $array ) )
	{
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

if(!function_exists('tendoo_error'))
{
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

if(!function_exists('tendoo_success'))
{
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

if(!function_exists('tendoo_warning'))
{
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

if(!function_exists('tendoo_info'))
{
	function tendoo_info($text)
	{
		return '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-info"></i> '.$text.'</div>';;
	}
}

/** 
 * Convert short string to long notice message
 *
 * @param String (error code)
 * @return String (Html result)
**/

if(!function_exists('fetch_error'))
{
	function fetch_notice_output($e,$extends_msg= '',$sort = FALSE)
	{
		
		if($e === TRUE)
		{
			?><style>
			.notice_sorter
			{
				border:solid 1px #999;
				color:#333;
			}
			.notice_sorter thead td
			{
				padding:2px 10px;
				text-align:center;
				background:#EEE;
				background:-moz-linear-gradient(top,#EEE,#CCC);
				border:solid 1px #999;
			}
			.notice_sorter tbody td
			{
				padding:2px 10px;
				text-align:justify;
				background:#FFF;
				border:solid 1px #999;
			}
			</style><table class="notice_sorter"><thead>
            <style>
			.notice_sorter
			{
				border:solid 1px #999;
				color:#333;
			}
			.notice_sorter thead td
			{
				padding:2px 10px;
				text-align:center;
				background:#EEE;
				background:-moz-linear-gradient(top,#EEE,#CCC);
				border:solid 1px #999;
			}
			.notice_sorter tbody td
			{
				padding:2px 10px;
				text-align:justify;
				background:#FFF;
				border:solid 1px #999;
			}
			</style>
            <tr><td>Index</td><td>Code</td><td>Description</td></tr></thead><tbody><?php    
			$index		=	1;
			foreach($__ as $k => $v)
			{
				?><tr><td><?php echo $index;?></td><td><?php echo $k;?></td><td><?php echo strip_tags($v);?></td></tr><?php
				$index++;
			}
			?></tbody></table><?php
		}
		else
		{
			if(is_string($e))
			{
				$notices		=	force_array( get_core_vars( 'tendoo_notices' ) );
				if( in_array( $e , $notices ) || array_key_exists( $e , $notices ) )
				{
					return $notices[$e];
				}
				else if(isset($notices))
				{
					if(array_key_exists($e,$notices))
					{
						return $notices[$e];
					}
					else
					{
						return tendoo_warning( __( sprintf( '"%s" is not a valid error code' , $e ) ) );
					}
				}
				else if($e != '' && strlen($e) <= 50)
				{
					return tendoo_warning( __( sprintf( '"%s" is not a valid error code' , $e ) ) );
				}
				else
				{
					return $e;
				}
			}
			return false;
		}
	}
}

/** 
 * Output message from URL
 *
 * @param String (error code)
 * @return String (Html result)
**/

if(!function_exists('fetch_notice_from_url'))
{
	function fetch_notice_from_url()
	{
		$notice = ''; 		
		if( isset( $_GET['notice'] ) )
		{
			$notice	= get_instance()->lang->line( $_GET['notice'] );
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

if(!function_exists('between'))
{
	function between($min,$max,$var) // Site Url Plus
	{
		if($min >= $max || $min == $max)
		{
			return FALSE;
		}
		if((int)$var >= $min && (int)$var <= $max)
		{
			return TRUE;
		}
		return FALSE;
	}
}

/**
*	Returns if array key exists. If not, return false if $default is not set or return $default instead
*	@access		:	Public
*	@params		:	String (Key), $subject, $default
**/

function riake( $key , $subject, $default = false ){	
	if( is_array( $subject ) )
	{
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

function farray( $array )
{
	return riake( 0 , $array , false );
}

/**
*	get recupère des informations sur le système.
**/
function get($key) // add to doc
{
	$instance	=	get_instance();
	switch($key)
	{
		case "str_core"		: 
			return $instance->config->item( 'version' );
		break;
		case "core_version"	:
			return (float) $instance->config->item( 'version' );
		break;
		case "core_signature"	:
			return $instance->config->item( 'core_signature' );
		break;
		case "declared-shortcuts"	:
			return get_declared_shortcuts();
		break;				
	}
}

if(!function_exists('translate')) // gt = Get Text
{
	function __( $code , $templating = 'tendoo-core' )
	{
		return translate( $code , $templating );
	}
	function _e( $code , $templating = 'tendoo-core' )
	{
		echo __( $code , $templating );
	}
	function translate( $code , $textdomain = 'tendoo-core' )
	{
		$final_lines	=	array();
		$instance		=	get_instance();
		$heavy__		=	array();
		global $Options, $LangFileHandler, $PoParsed;
		
		$text_domains	=	$instance->config->item( 'text_domain' );
		
		if( in_array( $textdomain, array_keys( $text_domains ) ) ) {
			$lang_file	=	$text_domains[ $textdomain ] . '/' . $instance->config->item( 'site_language' ) . '.po';			
			
			if( is_file( $lang_file ) ) {
				if( ! isset( $LangFileHandler[ $textdomain ] ) ){
					$LangFileHandler[ $textdomain ]	=	new Sepia\FileHandler( $lang_file );
					$PoParsed[ $textdomain ]		= 	new Sepia\PoParser( $LangFileHandler[ $textdomain ] );
					$PoParsed[ $textdomain ]->parse();
					$PoParsed[ $textdomain ]->AllEntries	=	$PoParsed[ $textdomain ]->entries();
					foreach( $PoParsed[ $textdomain ]->AllEntries as $key => $entry ){
						$newKey						=	str_replace( '<##EOL##>', '', $key );
						if( $key !== $newKey ) {
							// var_dump( $newKey );
							$PoParsed[ $textdomain ]->AllEntries[ $newKey ] = $entry;
							unset( $PoParsed[ $textdomain ]->AllEntries[ $key ] ); //unset key
						}
					}
				} 
				return implode( '', riake( 'msgstr', riake( $code, $PoParsed[ $textdomain ]->AllEntries, array( 'msgstr' => array( $code ) ) ) ) );
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
function print_array( $array , $return = FALSE )
{
	ob_start();
	echo '<pre>';
	print_r( $array , $return );
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

function date_now( $format = 'DATE_W3C' )
{
	return standard_date( $format, date_timestamp() );;
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
	return gmt_to_local( now(), riake( 'site_timezone', $Options, 'Etc/Greenwich' ), TRUE );
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
function pagination_helper($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl,$RedirectUrl = array('error','code','page-404'))
{
	$instance	=	get_instance();
	$result		=	doPaginate($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl);
	if($result[0] == 'page-404'): redirect($RedirectUrl);endif;
	return $result;
}
function doPaginate($elpp,$ttel,$current_page,$baselink)
{
	/*// Gloabl ressources Control*/
	if(!is_finite($elpp))				: echo '<strong>$elpp</strong> is not finite'; return;
	elseif(!is_finite($current_page))	: echo '<strong>$current_page</strong> is not finite'; return;
	endif;
	
	$more	=	array();
	$ttpage = ceil($ttel / $elpp);
	if(($current_page > $ttpage || $current_page < 1) && $ttel > 0): return array(
		'start'				=>	0,
		'end'				=>	0,
		'page-404', 			// 	Deprécié
		array(),			// 	Déprécié
		'status'			=>	'page-404',
		'pagination'		=>	array(),
		'available_pages'	=>	0,
		'current_page'		=>	0
	);
	endif;
	$firstoshow = ($current_page - 1) * $elpp;
	/*// FTS*/
	if($current_page < 5):$fts = 1;
	elseif($current_page >= 5):$fts = $current_page - 4;
	endif;
	/*// LTS*/
	if(($current_page + 4) <= $ttpage):$lts = $current_page + 4;
	/*elseif($ttpage > 5):$lts = $ttpage - $current_page;*/
	else:$lts = $ttpage;
	endif;
	
	$content = null;
	for($i = $fts;$i<=$lts;$i++)
	{
		$more[]	=	array(
			'link'	=>	$baselink.'/'.$i,
			'text'	=>	$i,
			'state'	=>	((int)$i === (int)$current_page) ? "active" : "" // Fixing int type 03.11.2013
		);
	}		
	return array(
		'start'				=>	$firstoshow,
		'end'				=>	$elpp,
		'pageExists', 		// 	Deprécié
		$more,				// 	Déprécié
		'status'			=>	'pageExists',
		'pagination'		=>	$more,
		'available_pages'	=>	$ttpage,
		'current_page'		=>	$current_page
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
/* End of file core_helper.php */

