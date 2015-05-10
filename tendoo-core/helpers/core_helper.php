<?php
if(!function_exists('css_url'))
{
	function css_url($e)
	{
		$instance	=	get_instance();
		return $instance->url->main_url().'tendoo-assets/css/'.$e.'.css';
	}
}
if(!function_exists('is_php'))
{
	/**
	 * @param  string  $version
	 *
	 * @return  bool
	 */
	function is_php($version = '5.0.0')
	{
		static $phpVer;
		$version = (string) $version;
	
		if ( ! isset($phpVer[ $version ]))
		{
			$phpVer[ $version ] = (version_compare(PHP_VERSION, $version) < 0) ? false : true;
		}
	
		return $phpVer[ $version ];
	}
}
/**
 * Check if a specific feature is enabled on tendoo.
 * 
 * @param string required. feature name
 * @return bool. if feature is enabled or not.
**/

function is_enabled( $feature_name ) {
	switch( $feature_name ){
		case 'tools' :
			return defined( 'TOOLS_ENABLED' ) ? TOOLS_ENABLED : false ;
		break;
	}
}

if ( ! function_exists('remove_invisible_characters'))
{
	function remove_invisible_characters($str, $url_encoded = TRUE)
	{
		$non_displayables = array();
		
		// every control character except newline (dec 10)
		// carriage return (dec 13), and horizontal tab (dec 09)
		
		if ($url_encoded)
		{
			$non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
		}
		
		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}
		while( $count );

		return $str;
	}
}
if(!function_exists('show_message'))
{
	function show_error($content , $heading = '' )
	{
		$heading == '' ? __( 'Error Occured' ) : $heading;
		?>
        <p style="border:solid 1px #CCC;padding:1%;width:96%;margin:1%;text-align:center;background:#FFE6E6;color:#777;">
        	<h4><?php echo strip_tags( $heading );?></h4>
			<?php echo strip_tags( $content );?>
		</p>
		<?php
	}
}
if(!function_exists('log_message'))
{
	function log_message($e,$content)
	{
		return // take care after;
		?><h1><?php echo $e;?></h1><p><?php echo $content;?></p><?php
	}
}
if(!function_exists('js_url'))
{
	function js_url($e="")
	{
		$instance	=	get_instance();
		return $instance->url->main_url().'tendoo-assets/js/'.$e.'.js';
	}
}
if(!function_exists('img_url'))
{
	function img_url($e)
	{
		$instance	=	get_instance();
		return $instance->url->main_url().ASSETS_DIR.'img/'.$e;
	}
}
if(!function_exists('tendoo_error'))
{
	function tendoo_error($text)
	{
		return '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> '.$text.'</div>';
	}
}
if(!function_exists('tendoo_success'))
{
	function tendoo_success($text)
	{
		return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-thumbs-o-up"></i> '.$text.'</div>';
	}
}
if(!function_exists('tendoo_warning'))
{
	function tendoo_warning($text)
	{
		return '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> '.$text.'</div>';
	}
}
if(!function_exists('tendoo_info'))
{
	function tendoo_info($text)
	{
		return '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-info"></i> '.$text.'</div>';;
	}
}
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
if(!function_exists('fetch_notice_from_url'))
{
	function fetch_notice_from_url()
	{
		$notice = ''; $info = '';
		if(isset($_GET['notice']))
		{
			$notice	= fetch_notice_output($_GET['notice']);
		}
		if(isset($_GET['info']))
		{
			$info	= tendoo_info($_GET['info']);
		}
		return $notice . $info ;
	}
}

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
if(!function_exists('is_compatible'))
{
	function is_compatible() // Site Url Plus
	{
		if(fopen('index.php','r')===FALSE || file_get_contents('index.php') === FALSE)
		{
			?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title><?php __( 'Error - Server issue' );?></title><body><p><?php _e( 'This current server cannot trigger somes Tendoo\'s features. It will lead to some issues and troubleshots. Please consider upgrading your server.' );?></p></body></html><?php
		}
	}
}
if(!function_exists('__extends'))
{
	function __extends(&$obj)
	{
		$instance				=	get_instance();
		$instance_property		=	get_object_vars($instance);
		foreach($instance_property as $key	=>	&$value)
		{
			if(!in_array($key,array('load','Load')))
			{
				$obj->$key	=	$value;
			}
		}
	}
}
if(!function_exists('translate')) // gt = Get Text
{
	function __( $code , $templating = null )
	{
		return translate( $code , $templating );
	}
	function _e( $code , $templating = null )
	{
		echo __( $code , $templating );
	}
	function translate( $code , $textdomain = 'tendoo-core' )
	{
		$final_lines	=	array();
		$instance		=	get_instance();
		$heavy__		=	array();
		
		if( in_array( $instance->lang->getSystemLang() , $instance->lang->get_supported_lang() ) )
		{
			// Lang Recorder is only enabled while en_US lang is activated
			if( LANG_RECORDER_ENABLED == true && $textdomain = 'tendoo-core' )
			{
				if( ! file_exists( SYSTEM_DIR . 'languages/' . $instance->lang->getSystemLang() . '.po' ) )
				{
					$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . $instance->lang->getSystemLang() . '.po' , 'a+' );
					fwrite( $lang_file , 'msgid ""' . PHP_EOL );
					fwrite( $lang_file , 'msgstr ""' . PHP_EOL );
					fwrite( $lang_file , '"Plural-Forms: nplurals=2; plural=(n != 1);\n"' . PHP_EOL );
					fwrite( $lang_file , '"Project-Id-Version: Tendoo CMS Translation\n"' . PHP_EOL );
					fwrite( $lang_file , '"Last-Translator: Translate <language@tenoo.org>\n"' . PHP_EOL );
					fwrite( $lang_file , '"POT-Creation-Date: \n"' . PHP_EOL );
					fwrite( $lang_file , '"PO-Revision-Date: \n"' . PHP_EOL );
					fwrite( $lang_file , '"Last-Translator: \n"' . PHP_EOL );
					fwrite( $lang_file , '"Language-Team: Tendoo Lang Team\n"' . PHP_EOL );
					fwrite( $lang_file , '"MIME-Version: 1.0\n"' . PHP_EOL );
					fwrite( $lang_file , '"Content-Type: text/plain; charset=UTF-8\n"' . PHP_EOL );
					fwrite( $lang_file , '"Content-Transfer-Encoding: 8bit\n"' . PHP_EOL );
					fwrite( $lang_file , '"Language: en_US\n"' . PHP_EOL );
					fwrite( $lang_file , '"X-Generator: Tendoo ' . get( 'core_id' ) . '\n"' . PHP_EOL );
					fwrite( $lang_file , '"X-Poedit-SourceCharset: UTF-8\n"' . PHP_EOL );
					fwrite( $lang_file , PHP_EOL );
					fclose( $lang_file );
				}
				$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . $instance->lang->getSystemLang() . '.po' , 'r+' );
				while ( ( $line = fgets( $lang_file ) ) !== false ) {
					if( substr( $line , 0 , 5 ) == 'msgid' )
					{
						$msgid	=	explode( '"' , $line );
						$latest	=	riake( 1 , $msgid );
					}
					if( substr( $line , 0 , 6 ) == 'msgstr' )
					{
						$msgstr	=	explode( '"' , $line );
						$heavy__[ $latest ]	=	riake( 1 , $msgstr );
					}
				}
				fclose( $lang_file );
				if( !in_array( htmlentities( $code , ENT_QUOTES ) , __keys( $heavy__ ) ) )
				{
					$bt 		= debug_backtrace();
					$caller 	= __shift($bt);
					
					$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . $instance->lang->getSystemLang() . '.po' , 'a+' );
					
					fwrite( $lang_file , '#: ' . $caller[ 'file' ] . ':' . $caller[ 'line' ] . PHP_EOL );
					fwrite( $lang_file , 'msgid "' . htmlentities( $code , ENT_QUOTES ) . '"' . PHP_EOL );
					fwrite( $lang_file , 'msgstr "' . htmlentities( $code , ENT_QUOTES ) . '"' . PHP_EOL );
					fwrite( $lang_file , PHP_EOL );
					fclose( $lang_file );
				}
			}
			
		}
		if( file_exists( SYSTEM_DIR . 'languages/' . $instance->lang->getSystemLang() . '.po' ) )
		{
			$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . $instance->lang->getSystemLang() . '.po' , 'r' );
			while ( ( $line = fgets( $lang_file ) ) !== false ) {
				if( substr( $line , 0 , 5 ) == 'msgid' )
				{
					$msgid	=	explode( '"' , $line );
					$latest	=	riake( 1 , $msgid );
				}
				if( substr( $line , 0 , 6 ) == 'msgstr' )
				{
					$msgstr	=	explode( '"' , $line );
					$heavy__[ $latest ]	=	riake( 1 , $msgstr );
				}
			}
			fclose( $lang_file );
		}
		return riake( htmlentities( $code , ENT_QUOTES ) , $heavy__ , $code );
	}
}
if(!function_exists('tendoo_error')) // Deprecated
{
	function tendoo_error($x1,$x2,$x3)
	{
		return;
		$instance	=	get_instance();
		?>
		<div id="tendoo_error_notice">
			<h2>Erreur</h2>
		</div>
		<?php
	}
}
if(!function_exists('tendoo_exception')) // deprecated
{
	function tendoo_exception($x1,$x2,$x3)
	{
		$instance	=	get_instance();
		?>
		<div id="tendoo_error_notice" style="border:solid 1px #999">
			<h2>Tendoo Exception</h2>
		</div>
		<?php
	}
}
if(!function_exists('theme_class')) // Recupère la classe (attribut html) principale à appliquer en tant couleur principale/
{
	function theme_class()
	{
		$instance	=	get_instance();
		return $instance->users_global->getCurrentThemeClass();
	}
}
if(!function_exists('theme_button_class')) // Recupère la classe (attribut html) principale à appliquer en tant couleur principale des boutons/
{
	function theme_button_class()
	{
		$instance	=	get_instance();
		return $instance->users_global->getCurrentThemeButtonClass();
	}
}
if(!function_exists('theme_button_false_class')) // Recupère la classe application à un élément de type "btn" comme couleur de fond.
{
	function theme_button_false_class()
	{
		$instance	=	get_instance();
		return $instance->users_global->getCurrentThemeButtonFalseClass();
	}
}
if(!function_exists('theme_background_color')) // Recupère la classe application à un élément de type "btn" comme couleur de fond.
{
	function theme_background_color()
	{
		$instance	=	get_instance();
		return $instance->users_global->getCurrentThemeBackgroundColor();
	}
}
if( !function_exists( 'page_header' ) )
{
	function page_header()
	{
	?>
    <body class="<?php echo adminlte_skin( get_user_meta( 'dashboard_theme' ) );?> <?php echo get_user_meta( 'admin-left-menu-status' );?> sidebar-open fixed">
	<?php
    }
}
if( !function_exists( 'page_bottom' ) ){
	function page_bottom($options,$obj)
	{
			?>
    </body>
</html>
<?php

	}
}
?>