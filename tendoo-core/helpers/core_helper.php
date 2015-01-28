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
	function is_php($vers)
	{
		if($vers	>=	phpversion())
		{
			return true;
		}
		return false;
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
		$array['config_1']					=	tendoo_info( __( 'A config file already exists. If you save new data the older will be overwritten' ) );
		$array['accessDenied']				=		$array[ 'access_denied' ]				=	tendoo_warning( __( 'Access denied. Your access is not granted to this page' ) );
		$array['config_2']					=	tendoo_warning('Une erreur fatale s\'est produite durant l\'installation, veuillez re-installer tendoo.');
		$array['noThemeInstalled']			=	tendoo_warning(' Une erreur s\'est produite durant l\'acc&egrave;s au th&egrave;me. Il est possible qu\'aucun th&egrave;me ne soit install&eacute; ou d&eacute;finit comme th&egrave;me par d&eacute;faut.');
		$array['mustCreatePrivilege']		=	tendoo_warning(' Il est n&eacute;cessaire de cr&eacute;er des privil&egrave;ges avant de g&eacute;rer des administrateurs');
		$array['controler_created']			=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement cr&eacute;e.');		
		$array['c_name_already_found']		=	tendoo_warning('Une autre page poss&egrave;de d&eacute;j&agrave; ce nom comme contr&ocirc;leur, veuillez choisir un autre nom.');
		$array['name_already_found']		=	tendoo_warning('Une autre page poss&egrave;de d&eacute;j&agrave; ce nom, veuillez choisir un autre nom.');
		$array['controler_deleted']			=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement supprim&eacute;.');
		$array['controllers_updated']		=	tendoo_success('Les contr&ocirc;leurs ont été correctement mis à jour.');
		$array['incorrectSuperAdminPassword']	=	tendoo_warning('Le mot de passe administrateur est incorrect');
		$array['cantHeritFromItSelf']		=	tendoo_warning('Ce contr&ocirc;leur ne peut pas &ecirc;tre un sous menu de lui m&ecirc;me. La modification de l\'emplacement &agrave; &eacute;chou&eacute;.');
		$array['cantSendMsgToYou']			=	tendoo_warning('Une erreur s\'est produite, vous ne pouvez pas vous envoyer un message.');
		$array['curl_is_not_set']			=	tendoo_warning('CURL n\'est pas disponible sur ce site.');
		$array['unkConSpeAsParent']			=	tendoo_warning('Le contr&ocirc;leur (Menu), d&eacute;finie comme parent est introuvable. La modification du contr&ocirc;leur &agrave; &eacute;chou&eacute;.');
		$array['module_success_enabled']	=	tendoo_success('Le module à correctement été activé.');
		$array['module_success_disabled']	=	tendoo_success('Le module à correctement été désactivé.');
		$array['addingActionFailure']		=	tendoo_warning('La cr&eacute;ation d\'action pour ce module &agrave; &eacute;chou&eacute;.');
		$array['subMenuLevelReach']			=	tendoo_warning('Impossible de cr&eacute;er ou de modifier ce contr&ocirc;leur, la limitation en terme de sous menu &agrave; &eacute;t&eacute; atteinte. Veuillez choisir un autre menu ou en cr&eacute;er un nouveau.');
		$array['cantUserReservedCNames']	=	tendoo_warning('Ce code du contr&ocirc;leur est un code reserv&eacute;, vous ne pouvez pas l\'utiliser.');
		$array['unknowProfil']				=	tendoo_warning('Le profil que vous souhaitez visiter est introuvable. Il est en outre probable que cet utilisateur n\'existe pas ou que son compte &agrave; &eacute;t&eacute; supprim&eacute;.');
		$array['upload_invalid_filesize']	=	tendoo_warning('La taille du fichier est supérieur à celle autorisée.');
		$array['cant_delete_mainpage']		=	tendoo_warning(' La page principale ne peut pas &ecirc;tre supprim&eacute;.');
		$array['controler_edited']			=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement modifi&eacute;.');
		$array['db_unable_to_connect']		=	tendoo_warning('Il est impossible de se connecter &agrave; la base de donn&eacute;es avec les informations fournies.');
		$array['db_unable_to_select']		=	tendoo_warning('La connexion &agrave; &eacute;t&eacute; &eacute;tablie, cependant il est impossible d\'acc&eacute;der &agrave; la base de donn&eacute;e.');
		$array['error-occured']				=	$array['erroroccurred']				=	tendoo_warning( translate( 'A error occured during this operation.' ) );
		$array['adminDeleted']				=	tendoo_success(' L\'utilisateur &agrave; &eacute;t&eacute; correctement supprim&eacute;.');
		$array['controller_not_found']		=	tendoo_warning(' Ce contr&ocirc;leur est introuvable.');
		$array['no_main_controller_created']=	tendoo_warning(' Aucun contr&ocirc;leur d&eacute;finit comme principale n\'a &eacute;t&eacute; retrouv&eacute;, le nouveau contr&ocirc;leur &agrave; &eacute;t&eacute; d&eacute;finit comme contr&ocirc;leur par d&eacute;faut.');
		$array['no_main_page_set']			=	tendoo_info(' Aucun contr&ocirc;leur n\'est d&eacute;finie par d&eacute;faut.');
		$array['no_priv_created']			=	tendoo_info(' Aucun privil&egrave;ge n\'a &eacute;t&eacute; cr&eacute;e, Pour administrer les actions, il est indispensable de cr&eacute;er un privil&egrave;ge au moins.');
		$array['InvalidModule']				=	tendoo_warning('Ce module est invalide ou incompatible.');
		$array['CantDeleteDir']				=	tendoo_warning('Une erreur s\'est produite durant la suppr&eacute;ssion d\'un dossier.');
		$array['module_corrupted']			= 	tendoo_warning('Ce module ne peut pas &ecirc;tre install&eacute;. Il est corrompu ou incompatible.');	
		$array['errorInstallModuleFirst']	= 	tendoo_warning('Vous devez installer les tables avant d\'installer le module');	
		$array['module-has-been-installed']			=	tendoo_success( translate( 'The module has been sucessfully installed.' ) );
		$array['module-already-exists']		= 	tendoo_warning( translate( 'A module with the same namespace already exists.') );	
		$array['unactive-or-unknow-module']		=	tendoo_warning( __( 'This module is not found or has been disabled.' ) ); // Translated
		$array['module-has-been-installed']		=	tendoo_success('Le module &agrave; &eacute;t&eacute; d&eacute;sinstall&eacute;.');
		$array['InvalidPage']				=	tendoo_warning('Cette page n\'a pas pu &ecirc;tre charg&eacute; car le contr&ocirc;leur correspondant &agrave; cette adresse est introuvable ou indisponible.'); // Deprecated ?
		$array['noControllerDefined']		=	tendoo_warning('Impossible d\'acc&eacute;der &agrave; cet &eacute;lement, Il ne dispose pas d\'interface embarqu&eacute;.');
		$array['cantSetChildAsMain']		=	tendoo_warning('Un sous menu ne peut pas &ecirc;tre d&eacute;finie comme page principale. La modification de la priorit&eacute; &agrave; &eacute;chou&eacute;e.');
		$array['noFileUpdated']				=	tendoo_warning('Aucun fichier n\'a &eacute;t&eacute; re&ccedil;u.');
		$array['done']						=	tendoo_success('L\'op&eacute;ration s\'est d&eacute;roul&eacute;e avec succ&egrave;s.');
		$array['accessForbiden']			=	tendoo_warning('Vous ne faites pas partie du privil&egrave;s qui peut acc&eacute;der &agrave; cette page.');
		$array['userCreated']				=	tendoo_success('L\'utilisateur a &eacute;t&eacute; cr&eacute;e.');
		$array['userNotFoundOrWrongPass']	=	tendoo_warning('Utilisateur introuvable ou mot de passe incorrect.');
		$array['notForYourPriv']			=	tendoo_warning('Acc&eacute;der &agrave; cet &eacute;l&eacute;ment ne fait pas partie de vos actions.');
		$array['unknowAdmin']				=	tendoo_warning('Administrateur introuvable.');
		$array['moduleBug']					=	tendoo_warning('Une erreur s\'est produite. Le module attach&eacute; &agrave; ce contr&ocirc;leur est introuvable ou d&eacute;sactiv&eacute;.');
		$array['page404_or_moduleBug']		=	tendoo_warning('Une erreur s\'est produit, la page est introuvable où le module attaché n\'est pas correctement défini.');
		$array['notAllowed']				=	tendoo_warning('Il ne vous est pas permis d\'effctuer cette op&eacute;ration. Soit compte tenu de votre privil&egrave;ge actuel, soit compte tenu de l\'indisponibilit&eacute; du service.');
		$array['theme_alreadyExist']		=	tendoo_info('Ce th&egrave;me avait d&eacute;j&agrave; &eacute;t&eacute; install&eacute;.');
		$array['NoCompatibleTheme']			=	tendoo_warning('Ce th&egrave;me n\'est pas compatible avec la version actuelle d\'tendoo.');
		$array['NoCompatibleModule']		=	tendoo_warning( translate( 'module_compatibility_issues' ) );
		$array['module_updated']			=	tendoo_success( translate( 'module_updated' ) );
		$array['SystemDirNameUsed']			=	tendoo_warning('Ce th&egrave;me ne peut pas s\'installer car il &agrave; tenter d\'utiliser des ressources syst&egrave;me.');
		$array['theme_installed']			=	tendoo_success('Le th&egrave;me a &eacute;t&eacute; install&eacute; correctement.');
		$array['no_theme_selected']			=	tendoo_warning('Aucun th&egrave;me n\'a &eacute;t&eacute; choisi comme th&egrave;me par d&eacute;faut.');
		$array['defaultThemeSet']			=	tendoo_success('Le th&egrave;me &agrave; &eacute;t&eacute; correctement choisi come th&egrave;me par d&eacute;faut.');
		$array['unknowTheme']				=	tendoo_warning('Th&egrave;me inconnu ou introuvable.');
		$array['missingArg']				=	tendoo_warning('Une erreur s\'est produite. Certains &eacute;l&eacute;ment, qui permettent le traitement de votre demande, sont manquant ou incorrect.');
		$array['page404']					=	tendoo_warning('Cette page est introuvable ou indisponible. Veuillez re-&eacute;ssayer.');
		// $array['restoringDone']				=	tendoo_success('La restauration s\'est correctement d&eacute;roul&eacute;.');
		// $array['cmsRestored']				=	tendoo_success('La restauration s\'est correctement d&eacute;roul&eacute;.');
		$array['creatingHiddenControllerFailure']		=	tendoo_warning('La cr&eacute;ation du contr&ocirc;leur invisible &agrave; &eacute;chou&eacute;');
		$array['installFailed']				=	tendoo_warning('Une erreur s\'est produite durant l\'installtion certaines composantes n\'ont pas &eacute;t&eacute; correctement install&eacute;es');
		$array['db_connect_error']			=	tendoo_warning('Connexion impossible,int&eacute;rrompu ou le nombre limit de connexion accord&eacute; &agrave; l\'utilisateur de la base de donn&eacute; est atteinte. Veuillez re-&eacute;ssayer.');
		$array['themeCrashed']				=	tendoo_warning('Une erreur s\'est produite avec le th&egrave;me. Ce th&egrave;me ne fonctionne pas correctement.');
		$array['noMainPage']				=	tendoo_warning('Impossible d\'acc&eacute;der &agrave; la page principale du site. Aucun contr&ocirc;leur n\'a &eacute;t&eacute; d&eacute;finit comme principal');
		$array['AdminAuthFailed']			=	tendoo_warning('Mot de passe administrateur incorrect.');
		
		$array['super-admin-creation-failed']	=	tendoo_warning( __( 'Super administrator creation failed. Check if, for this website, there are not yet a super administrator.') );
		$array['user-has-been-created']			=	tendoo_success( __( 'User has been successfully created.' ) );
		$array['no-controller-set']				=	tendoo_warning( __( 'There is no controller available' ) );
		$array['role-not-found']				=	tendoo_warning( __( 'Role not found' ) );
		$array['invalid-app']					=	tendoo_warning( __( 'This app is not a valid Tendoo App. Installation has failed.' ) );
		$array['users-creation-failed']			=	tendoo_warning( __( 'User creation failed, check if this pseudo is not already taken.' ) );
		$array['table-creation-failed']			=	tendoo_warning( __( 'Error occured. Tables wasn\'t installed. Check your provided database login data' ) );
		$array['upload-invalid-file-type']		=	tendoo_warning( __( 'This file type is not allowed' ) );
		$array['controller-not-properly']		=	tendoo_warning( __( 'Controller interface is not well defined' ) );
		// $array['themeControlerNoFound']		=	tendoo_warning('Ce th&egrave;me ne dispose pas d\'interface embarqu&eacute;..'); // Deprecated ?
		$array['pseudo-already-in-use']			=	tendoo_warning( __( 'This pseudo is already used. Please choose another one' ) );
		$array['email-already-used']			=	tendoo_warning( __( 'This email is already used, please choose another one or try to restore your account.' ) );
		$array['unallowed-role']				=	tendoo_warning( __( 'This role is not allowed.' ) );
		$array['unactive-account']				=	tendoo_warning( __( 'This account is not yet active. Please, check the inbox associated to this email address. If there is no activation mail, you can try to receive it again, with the activation wizard.' ) );
		$array['already-active']				=	tendoo_warning( __( 'Activation mail could not been send. This account seems to be already active.' ) );	
		$array['action-prohibited']				=	tendoo_warning( __( 'You are not granted to do this.' ) );
		$array['unknow-email']					=	tendoo_warning( __( 'There is no account associated to this email address' ) );
		$array['activation-mail-send']			=	tendoo_success( __( 'An activation mail has been send.' ) );
		$array['registration-not-allowed']		=	$array['registration-disabled']			=	tendoo_warning( __( 'Registration and associated services are disabled in this website.' ) );
		$array['new-link-send']					=	tendoo_success( __( 'A new link has been send to your email address.' ) );
		$array['expiration-time-reached']		=	tendoo_warning( __( 'This link is no more valid.' ) );
		$array['activation-failed']				=	tendoo_warning( __( 'This activation link is no more valid.' ) );
		$array['account-activation-done']		=	tendoo_success( __( 'This account is now active' ) );
		$array['account-activation-failed']		=	tendoo_warning( __( 'The account activation failed.' ) );
		$array['password-matches-error']		=	tendoo_warning( __( 'The new password should not match the old one.' ) );
		$array['password-has-changed']			=	tendoo_success( __( 'The password has been changed.' ) );
		$array['upload-file-no-available']		=	tendoo_warning( __( 'Select a file first.' ) );
		$array['cannot-delete-active-role']		=	tendoo_warning( __( 'A role in use can\'t be deleted.') );
		$array[ 'profile-updated' ]				=	tendoo_success( __( 'Profile has been updated.' ) );
		$array[ 'role-permissions-saved' ]		=	tendoo_success( __( 'Role permissions has been saved.' ) );
		$array[ 'unsupported-by-current-theme']	=	tendoo_warning(' Le thème actif ne prend pas en charge le module attaché à ce contrôleur.');
		
		// Tendoo 1.4
		$array[ 'web-app-mode-enabled' ]		=	tendoo_warning( __( 'While "WebApp" Mode is enabled, frontend is disabled. Check your settings to define tendoo mode on Website setings tab.' ) );
		$array['form-expired']					=	tendoo_warning( __( 'Current form data has expired. Please try to submit it again' ) );
		
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
			foreach($array as $k => $v)
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
				global $NOTICE_SUPER_ARRAY;
				if(in_array($e,$array) || array_key_exists($e,$array))
				{
					return $array[$e];
				}
				else if(isset($NOTICE_SUPER_ARRAY))
				{
					if(array_key_exists($e,$NOTICE_SUPER_ARRAY))
					{
						return $NOTICE_SUPER_ARRAY[$e];
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
	function translate($code , $textdomain = 'tendoo-core' )
	{
		$final_lines	=	array();
		$instance		=	get_instance();
		if($instance->lang->getSystemLang() == 'en_US')
		{
			// Lang Recorder is only enabled while en_US lang is activated
			if( LANG_RECORDER_ENABLED == true && $textdomain = 'tendoo-core' )
			{
				$heavy_array	=	array();
				if( ! file_exists( SYSTEM_DIR . 'languages/' . 'en_US.po' ) )
				{
					$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . 'en_US.po' , 'a+' );
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
				$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . 'en_US.po' , 'r+' );
				while ( ( $line = fgets( $lang_file ) ) !== false ) {
					if( substr( $line , 0 , 5 ) == 'msgid' )
					{
						$msgid	=	explode( '"' , $line );
						$latest	=	riake( 1 , $msgid );
					}
					if( substr( $line , 0 , 6 ) == 'msgstr' )
					{
						$msgstr	=	explode( '"' , $line );
						$heavy_array[ $latest ]	=	riake( 1 , $msgstr );
					}
				}
				fclose( $lang_file );
				if( !in_array( htmlentities( $code , ENT_QUOTES ) , array_keys( $heavy_array ) ) )
				{
					$bt 		= debug_backtrace();
					$caller 	= array_shift($bt);
					
					$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . 'en_US.po' , 'a+' );
					
					fwrite( $lang_file , '#: ' . $caller[ 'file' ] . ':' . $caller[ 'line' ] . PHP_EOL );
					fwrite( $lang_file , 'msgid "' . htmlentities( $code , ENT_QUOTES ) . '"' . PHP_EOL );
					fwrite( $lang_file , 'msgstr "' . htmlentities( $code , ENT_QUOTES ) . '"' . PHP_EOL );
					fwrite( $lang_file , PHP_EOL );
					fclose( $lang_file );
				}
			}
			$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . 'en_US.po' , 'r' );
			while ( ( $line = fgets( $lang_file ) ) !== false ) {
				if( substr( $line , 0 , 5 ) == 'msgid' )
				{
					$msgid	=	explode( '"' , $line );
					$latest	=	riake( 1 , $msgid );
				}
				if( substr( $line , 0 , 6 ) == 'msgstr' )
				{
					$msgstr	=	explode( '"' , $line );
					$heavy_array[ $latest ]	=	riake( 1 , $msgstr );
				}
			}
			fclose( $lang_file );
			return riake( htmlentities( $code , ENT_QUOTES ) , $heavy_array , $code );
		}
		else if($instance->lang->getSystemLang() == 'fr_FR')
		{
			$lang_file	=	fopen( SYSTEM_DIR . 'languages/' . 'fr_FR.po' , 'r' );
			while ( ( $line = fgets( $lang_file ) ) !== false ) {
				if( substr( $line , 0 , 5 ) == 'msgid' )
				{
					$msgid	=	explode( '"' , $line );
					$latest	=	riake( 1 , $msgid );
				}
				if( substr( $line , 0 , 6 ) == 'msgstr' )
				{
					$msgstr	=	explode( '"' , $line );
					$heavy_array[ $latest ]	=	riake( 1 , $msgstr );
				}
			}
			fclose( $lang_file );
			return riake( htmlentities( $code , ENT_QUOTES ) , $heavy_array , $code );
		}
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
<body style="background:<?php echo theme_background_color();?>">
    <section class="vbox">
<?php
    }
}
if( !function_exists( 'page_bottom' ) ){
	function page_bottom($options,$obj)
	{
		if( get_user_meta( 'new_comer' ) === true )	 // Set 1 after creating
		{
			?>
<!-- Step 1 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
    	<div class="row">
            <div class="col-lg-7" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="margin:0;"><?php echo sprintf( __( 'Welcome on %s' ) , get('core_version') );?></h1>
                        <smaill><?php _e( 'A new way to create blogs and Web Apps easilly.' );?></small>
                        <hr class="line-dashed">
                        <p><?php _e( 'Thanks for using Tendoo to create your blog or for your webapp. Tendoo Foundation Specially give thanks to all contributors and is proud to release this new version of Tendoo CMS.' );?></p>
                        <p><?php _e( "If you're new, you can read user guides in order to know how to use each features of Tendoo. It's hightly recommended that you start by this steps before." );?></p>
                        <p><?php _e( "There is also guidse for advanced users and for developers. those guides has been simplified to ease reading." );?></p>
						<p><?php _e( "Enough talking !!! enjoy this tour by reading what's new." );?></p>
                        <p> <a class="btn <?php echo theme_button_class();?> btn-large proceed"><?php _e( 'Discover what\'s new' );?></a> <a class="btn <?php echo theme_button_class();?> btn-large" href="http://tendoo-cms.readme.io"><?php _e( 'Read Beginner Tutorials' );?></a> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" dismissmodal id="quitTour"> <?php _e( 'Skip this tour' );?> </a> </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center"> <i class="fa fa-gift" style="font-size:350px;dislay:compact;width:auto;margin-top:40px;"></i> </div>
        </div>
    </div>
</div>
<!-- Step 2 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> 
                    	<img style="width:100%;" src="<?php echo $obj->instance->url->img_url('Hub_back.png');?>" alt="girl"> 
                        <img style="width:100%;margin-top:10px;" src="<?php echo $obj->instance->url->img_url('install_apps.jpg');?>" alt="girl"> 
                    </div>
                    <div class="col-lg-8">
                    	<h3><?php _e( 'What\'s new ?' );?></h3>
						<p><?php _e( 'Many thing has changed during previous version and now we\'re proud to introduce those new features : ');?></p>
                        <h4><?php _e( 'UI has been improved' );?></h4>
                        <p><?php _e( 'Since Tendoo is using GUI Library, UI has been improved. For developper that mean a significant time savings and for user a dashboard more user-friendly' );?>
                        <p>Vous pouvez étendre les fonctionnalités de base de votre site web Tendoo en installant les applications Tendoo. Les applications sont de deux types : Modules et Thèmes.<br>
                        	<p> <a class="btn <?php echo theme_button_class();?> btn-large proceed"> Comment ça marche ? </a> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour" dismissmodal> Ne plus afficher </a> </p>
                        </p>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Step 3 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> <img style="width:100%;" src="<?php echo $obj->instance->url->img_url('how_does_it_work.jpg');?>" alt="girl">  </div>
                    <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Comment ça marche ?</h4>
                                <p>Tendoo est fourni avec des applications par défaut, afin de vous permettre de mettre sur pied un blog assez complet avec un gestionnaire de page d'accueil, un gestionnaire d'article (Blogster), une page de contact et un éditeur de page HTML, un gestionnaire de widgets, il s'agit ici de modules. <br><br>Les modules sont de deux types. Soit ils s'exécutent sur tous votre blog dans l'interface publique (on dit qu'il s'agit d'un module de type "<strong>GLOBAL</strong>"), soit ils s'exécutent uniquement sur une page dans laquelle ils ont été assignés (on dit qu'il s'agit d'un module de type "<strong>UNIQUE</strong>", ou par page).</p>
                                <p>Un même module peut être exécuté sur plusieurs pages. Pour exécuter un module sur une page, il faut "l'affecter" dans la page de création et d'édition de pages. Une fois installé les applications disposent d'une interface embarquée, cette interface vous permet d'utiliser les fonctionnalités du module. Un page qui n'exécute pas un module ou dans laquelle une page n'est pas liée, génèrera une erreur lors de son accès.</p>
                                <p> <a class="btn <?php echo theme_button_class();?> btn-large proceed"> Comment utiliser les outils ? </a> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour" dismissmodal> Ne plus afficher </a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Step 4 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> <img style="width:100%;" src="<?php echo $obj->instance->url->img_url('help_button.jpg');?>" alt="girl"> <img style="width:100%;margin-top:10px;" src="<?php echo $obj->instance->url->img_url('introjs_showcase.jpg');?>" alt="girl"> </div>
                    <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Comment utiliser les outils ?</h4>
                                <p>Sur chaque page de l'espace administration, vous trouverez une bouton d'aide en haut à droite, qui vous permettra d'ouvrir une visite guidée. Pour avoir plus d'information sur Tendoo, <a href="http://tendoo.org/index.php/guide" target="_blank"><strong>lisez le manuel d'utilisation</strong></a>.</p>
                                <p>L'objectif des visites guidées, est de vous aider à mieux comprendre comment utiliser une fonctionnalité. C'est la raison pour laquelle, des petites boites modales flottantes indexeront certains éléments sur une page. Lorsqu'une page sera visitée pour la première fois, le bouton d'aide aura comme texte "<strong>Cliquez pour une visite</strong>". Après une visite, ce statut pourra être réinitialisé depuis la page des paramètres, dans la section des "<strong>autorisations</strong>".</p>
                                <p>Chaque visites guidées, disposent de bouton de navigation, vous permettant de facilement naviguer dans la visite guidée. Vous pourrez donc revenir sur un point que vous n'aurez pas totalement assimilé. </p>
                                <p>Utilisez les flèches de naviguation pour parcourir la visite guidée. Appuyez sur "ESC" sur votre clavier pour quitter la visite guidée.</p>
                                <p> 
                                <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour" dismissmodal> Ne plus afficher </a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
			var wizard	=	'<section class="wizmodal">'+ 
								'<div class="wizard clearfix">'+
									'<ul class="steps">'+
										'<li data-target="#step1" class="active" >'+
										'<span class="badge badge-info">1</span><?php _e( 'Welcome' );?></li>'+
										'<li data-target="#step2" class=""><span class="badge">2</span><?php _e( "What\'s new ?" );?></li>'+
										'<li data-target="#step3" class=""><span class="badge">3</span><?php _e( 'How does it work ?' );?></li>'+
										'<li data-target="#step4" class=""><span class="badge">4</span><?php _e( 'How to use it' );?></li>'+
										//'<li data-target="#step5" class=""><span class="badge">5</span>Par où commencer ?</li>'+
									'</ul>'+
									'<div class="actions">'+
										'<button type="button" class="btn btn-white btn-xs btn-prev"><?php _e( 'Previous' );?></button>'+
										'<button type="button" class="btn btn-white btn-xs btn-next"><?php _e( 'Next' );?></button>'+
									'</div>'+
								'</div>'+
								// '<img class="backgroundImg" src="<?php echo $obj->instance->url->img_url('tendoo_1.jpg');?>" style="position:absolute;">'+
								'<div class="step-content" style="">'+
									'<div class="step-pane active" id="step1">This is step 1</div>'+
									'<div class="step-pane" id="step2">This is step 2</div>'+
									'<div class="step-pane" id="step3">This is step 3</div>'+
									'<div class="step-pane" id="step4">This is step 4</div>'+
									'<div class="step-pane" id="step5">This is step 5</div>'+
								'</div>'+
							'</section>';
			$(document).ready(function(){
				tendoo.window.title( '<?php echo sprintf( __( 'Welcome on %s' ) , get('core_version') );?>' ).show(wizard);
				var steps	=	1;
				$('[data-stepContent]').each(function(){
					$('.wizmodal').find('#step'+steps).html($(this).html());
					steps++;
				});
				tendoo.silentAjax.bind(); // bind Event
				$('#quitTour').bind('click',function(){
					$modal	=	$(this).closest('.modal-dialog');
					$button	=	$($modal).find('[data-dismiss="modal"]').trigger('click');
				});
				var counter	=	1;
				$('.wizmodal ul[class="steps"] li').each(function(){
					$(this).data('id',counter);
					counter++;
				});
				$('.wizmodal .actions button:eq(0)').bind('click',function(){
					if($('.wizmodal ul[class="steps"] li[class="active"]').length == 0)
					{
						$('.wizmodal ul[class="steps"] li').eq(0).addClass('active').find('.badge').addClass('badge-info');
						
					}
					var activeId	=	$('.wizmodal ul[class="steps"] li[class="active"]').data('id');
					if(activeId > 1)
					{
						$('.wizmodal ul[class="steps"]')
							.find('li')
							.removeClass('active')
							.find('.badge')
							.removeClass('badge-info');
						$('.wizmodal ul[class="steps"]')
							.find('li')
							.eq(parseInt(activeId)-2)
							.addClass('active')
							.find('.badge')
							.addClass('badge-info');
						$('.wizmodal .step-content')
							.children()
							.hide()
							.removeClass('active');
						$('.wizmodal .step-content')
							.children()
							.eq(parseInt(activeId)-2)
							.addClass('active')
							.show();
					}
				});
				$('.wizmodal .actions button:eq(1)').bind('click',function(){
					if($('.wizmodal ul[class="steps"] li[class="active"]').length == 0)
					{
						$('.wizmodal ul[class="steps"] li').eq(0).addClass('active').find('.badge').addClass('badge-info');;
					}
					var activeId	=	$('.wizmodal ul[class="steps"] li[class="active"]').data('id');
					// Si le nom d'enfant est inférieur à l'identifiant de la page en cours, on parcours (+1)
					if(activeId < $('.wizmodal ul[class="steps"]').find('li').length)
					{
						$('.wizmodal ul[class="steps"]').children('li')
							.removeClass('active')
							.find('.badge')
							.removeClass('badge-info');
						$('.wizmodal ul[class="steps"]').children('li')
							.eq(parseInt(activeId))
							.addClass('active')
							.find('.badge')
							.addClass('badge-info');
								
						$('.wizmodal .step-content')
							.children()
							.each(function(){
								$(this).hide().removeClass('active');
							})
						$('.wizmodal .step-content')
							.children()
							.eq(parseInt(activeId))
							.addClass('active')
							.show();
					}
				});
				$('.proceed').bind('click',function(){
					$('.actions button:eq(1)').trigger('click');
				});
			});
			</script>
<style type="text/css">
			@media (width: 1280px)
			{
				.wizmodal .logo_Girls
				{
					width:73.9%;position:absolute;top:0px;right:0;
				}
			}
			</style>
</body>
</html><?php
		}
		else
		{
		?>
    </section>
</body>
</html>
<?php
		}

	}
}
?>