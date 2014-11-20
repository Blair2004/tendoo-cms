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
		while ($count);

		return $str;
	}
}
if(!function_exists('show_message'))
{
	function show_error($content)
	{
		?><p style="border:solid 1px #CCC;padding:1%;width:96%;margin:1%;text-align:center;background:#FFE6E6;color:#777;"><span>Error : </span><?php echo $content;?></p><?php
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
		$array['cantHeritFromItSelf']		=	tendoo_error('Ce contr&ocirc;leur ne peut pas &ecirc;tre un sous menu de lui m&ecirc;me. La modification de l\'emplacement &agrave; &eacute;chou&eacute;.');
		$array['cantSendMsgToYou']			=	tendoo_error('Une erreur s\'est produite, vous ne pouvez pas vous envoyer un message.');
		$array['curl_is_not_set']			=	tendoo_error('CURL n\'est pas disponible sur ce site.');
		$array['unkConSpeAsParent']			=	tendoo_error('Le contr&ocirc;leur (Menu), d&eacute;finie comme parent est introuvable. La modification du contr&ocirc;leur &agrave; &eacute;chou&eacute;.');
		$array['module_success_enabled']	=	tendoo_success('Le module à correctement été activé.');
		$array['module_success_disabled']	=	tendoo_success('Le module à correctement été désactivé.');
		$array['addingActionFailure']		=	tendoo_error('La cr&eacute;ation d\'action pour ce module &agrave; &eacute;chou&eacute;.');
		$array['subMenuLevelReach']			=	tendoo_error('Impossible de cr&eacute;er ou de modifier ce contr&ocirc;leur, la limitation en terme de sous menu &agrave; &eacute;t&eacute; atteinte. Veuillez choisir un autre menu ou en cr&eacute;er un nouveau.');
		$array['cantUserReservedCNames']	=	tendoo_error('Ce code du contr&ocirc;leur est un code reserv&eacute;, vous ne pouvez pas l\'utiliser.');
		$array['unknowProfil']				=	tendoo_error('Le profil que vous souhaitez visiter est introuvable. Il est en outre probable que cet utilisateur n\'existe pas ou que son compte &agrave; &eacute;t&eacute; supprim&eacute;.');
		$array['upload_invalid_filesize']	=	tendoo_error('La taille du fichier est supérieur à celle autorisée.');
		$array['cant_delete_mainpage']		=	tendoo_warning(' La page principale ne peut pas &ecirc;tre supprim&eacute;.');
		$array['controler_edited']			=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement modifi&eacute;.');
		$array['db_unable_to_connect']		=	tendoo_warning('Il est impossible de se connecter &agrave; la base de donn&eacute;es avec les informations fournies.');
		$array['db_unable_to_select']		=	tendoo_warning('La connexion &agrave; &eacute;t&eacute; &eacute;tablie, cependant il est impossible d\'acc&eacute;der &agrave; la base de donn&eacute;e.');
		$array['error_occurred']				=	tendoo_warning( translate( 'error_occurred' ) );
		$array['erroroccurred']				=	tendoo_warning( translate( 'error_occurred' ) );
		$array['adminDeleted']				=	tendoo_success(' L\'utilisateur &agrave; &eacute;t&eacute; correctement supprim&eacute;.');
		$array['controller_not_found']		=	tendoo_warning(' Ce contr&ocirc;leur est introuvable.');
		$array['no_main_controller_created']=	tendoo_warning(' Aucun contr&ocirc;leur d&eacute;finit comme principale n\'a &eacute;t&eacute; retrouv&eacute;, le nouveau contr&ocirc;leur &agrave; &eacute;t&eacute; d&eacute;finit comme contr&ocirc;leur par d&eacute;faut.');
		$array['no_main_page_set']			=	tendoo_info(' Aucun contr&ocirc;leur n\'est d&eacute;finie par d&eacute;faut.');
		$array['no_priv_created']			=	tendoo_info(' Aucun privil&egrave;ge n\'a &eacute;t&eacute; cr&eacute;e, Pour administrer les actions, il est indispensable de cr&eacute;er un privil&egrave;ge au moins.');
		$array['InvalidModule']				=	tendoo_warning('Ce module est invalide ou incompatible.');
		$array['CantDeleteDir']				=	tendoo_warning('Une erreur s\'est produite durant la suppr&eacute;ssion d\'un dossier.');
		$array['module_corrupted']			= 	tendoo_warning('Ce module ne peut pas &ecirc;tre install&eacute;. Il est corrompu ou incompatible.');	
		$array['errorInstallModuleFirst']	= 	tendoo_warning('Vous devez installer les tables avant d\'installer le module');	
		$array['module_installed']			=	tendoo_success( translate( 'module_installed' ) );
		$array['module_alreadyExist']		= 	tendoo_warning( translate( 'module_already_exists') );	
		$array['unknowModule']				=	tendoo_warning('Ce module est introuvable.');
		$array['module_uninstalled']		=	tendoo_success('Le module &agrave; &eacute;t&eacute; d&eacute;sinstall&eacute;.');
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
		$array['restoringDone']				=	tendoo_success('La restauration s\'est correctement d&eacute;roul&eacute;.');
		$array['cmsRestored']				=	tendoo_success('La restauration s\'est correctement d&eacute;roul&eacute;.');
		$array['creatingHiddenControllerFailure']		=	tendoo_warning('La cr&eacute;ation du contr&ocirc;leur invisible &agrave; &eacute;chou&eacute;');
		$array['installFailed']				=	tendoo_warning('Une erreur s\'est produite durant l\'installtion certaines composantes n\'ont pas &eacute;t&eacute; correctement install&eacute;es');
		$array['db_connect_error']			=	tendoo_warning('Connexion impossible,int&eacute;rrompu ou le nombre limit de connexion accord&eacute; &agrave; l\'utilisateur de la base de donn&eacute; est atteinte. Veuillez re-&eacute;ssayer.');
		$array['themeCrashed']				=	tendoo_warning('Une erreur s\'est produite avec le th&egrave;me. Ce th&egrave;me ne fonctionne pas correctement.');
		$array['noMainPage']				=	tendoo_warning('Impossible d\'acc&eacute;der &agrave; la page principale du site. Aucun contr&ocirc;leur n\'a &eacute;t&eacute; d&eacute;finit comme principal');
		$array['AdminAuthFailed']			=	tendoo_warning('Mot de passe administrateur incorrect.');
		
		$array['SuperAdminCreationError']	=	tendoo_warning('Un erreur s\'est produite durant la cr&eacute;ation du Super-administrateur. V&eacute;fiez les informations envoy&eacute;es ou assurez vous qu\'il n\'existe pas un autre Super-administrateur pour ce site.');
		$array['adminCreated']				=	tendoo_success('L\'utilisateur &agrave; &eacute;t&eacute; correctement cr&eacute;e');
		$array['no_page_set']				=	tendoo_warning('Aucun contr&ocirc;leur disponible.');
		$array['privilegeNotFound']			=	tendoo_warning('Privil&egrave;ge introuvable.');
		$array['invalidApp']				=	tendoo_warning('Application Tendoo non valide. L\'installation &agrave; &eacute;chou&eacute;e');
		$array['adminCreationFailed']		=	tendoo_warning('Impossible de cr&eacute;er un utilisateur, vérifiez que ce pseudo ne soit déjà utilisé.');
		$array['tableCreationFailed']		=	tendoo_warning('Impossible d\'installer Tendoo, les informations fournies sont peut &ecirc;tre invalide. Assurez-vous de la validité de la connexion et de leur conformit&eacute; aux informations fournies.');
		$array['upload_invalid_filetype']	=	tendoo_warning('Extension du fichier non autoris&eacute;e');
		$array['controllerNotWellDefined']	=	tendoo_warning('L\'interace embarqu&eacute; n\'est pas correctement d&eacute;fini.');
		$array['themeControlerNoFound']		=	tendoo_warning('Ce th&egrave;me ne dispose pas d\'interface embarqu&eacute;..');
		$array['registrationNotAllowed']	=	tendoo_warning('Il impossible de s\'inscrire. L\'inscription &agrave; &eacute;t&eacute; d&eacute;sactiv&eacute;e sur ce site.');
		$array['userExists']					=	tendoo_warning('Un utilisateur poss&eacute;dant ce pseudo existe d&eacute;j&agrave;.');
		$array['emailUsed']						=	tendoo_warning(' Cet email est d&eacute;j&agrave; utilis&eacute;, veuillez choisir un autre.');
		$array['unallowedPrivilege']			=	tendoo_warning(' Ce privil&egrave;ge n\'est pas autoris&eacute;.');
		$array['UnactiveUser']					=	tendoo_warning(' Cet utilisateur est inactif, veuillez consulter l\'adresse email fournie pour cet utilsateur. Si aucun mail d\'activation n\'a &eacute;t&eacute; envoy&eacute;, vous pouvez essayer &agrave; nouveau. En utilisant la proc&eacute;dure de r&eacute;cup&eacute;ration de mot de passe');
		$array['alreadyActive']					=	tendoo_warning(' Impossible d\'envoyer le mail d\'activation car le compte attach&eacute; &agrave; cette adresse mail est d&eacute;j&agrave; actif.');	
		$array['actionProhibited']				=	tendoo_warning(' Il vous est interdit d\'effectuer cette op&eacute;ration.');
		$array['unknowEmail']					=	tendoo_warning(' Aucun compte n\'est attach&eacute; &agrave; cette adresse mail.');
		$array['validationSended']				=	tendoo_success(' Un mail d\'activation &agrave; &eacute;t&eacute; envoy&eacute; &agrave; cette addresse.');
		$array['regisAndAssociatedFunLocked']	=	tendoo_warning(' L\'inscription et les services associ&eacute;s sont d&eacute;sactiv&eacute;s sur ce site.');
		$array['NewLinkSended']					=	tendoo_success(' Un nouveau lien &agrave; &eacute;t&eacute; envoy&eacute; &agrave; votre boite mail.');
		$array['timeStampExhausted']			=	tendoo_warning(' Ce lien n\'est plus valide. La dur&eacute;e de vie de ce lien &agrave; expir&eacute;e.');
		$array['activationFailed']				=	tendoo_warning(' Ce lien n\'est plus valide. La dur&eacute;e de vie de ce lien &agrave; expir&eacute;e.');
		$array['accountActivationDone']			=	tendoo_success(' Le compte est d&eacute;sormais actif.');
		$array['accountActivationFailed']		=	tendoo_warning(' L\'activation du compte &agrave; &eacute;chou&eacute;e.');
		$array['samePassword']					=	tendoo_warning(' Le nouveau mot de passe ne peut pas &ecirc;re identique &agrave; l\'ancien.');
		$array['passwordChanged']				=	tendoo_success(' Le mot de passe &agrave; &eacute;t&eacute; correctement modifi&eacute;.');
		$array['upload_no_file_selected']		=	tendoo_warning(' Aucun fichier n\'a &eacute;t&eacute; envoy&eacute;.');
		$array['cannotDeleteUsedPrivilege']		=	tendoo_warning(' Vous ne pouvez pas supprimer un privil&egrave;ge en cours d\'utilisation.');
		$array[ 'profile_updated' ]				=	tendoo_success( __( 'Profile has been updated.' ) );
		$array['active_theme_does_not_handle_that']	=	tendoo_warning(' Le thème actif ne prend pas en charge le module attaché à ce contrôleur.');
		// Tendoo 1.4
		$array[ 'webapp_enabled' ]				=	tendoo_warning( __( 'While "WebApp" Mode is enabled, frontend is disabled. Check your settings to define tendoo mode on Website setings tab.' ) );
		
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
						return tendoo_warning(' "'.$e.'" constitue une alerte introuvable');
					}
				}
				else if($e != '' && strlen($e) <= 50)
				{
					return tendoo_warning(' "'.$e.'" constitue une alerte introuvable');
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
if(!function_exists('fetch_error_from_url'))
{
	function fetch_error_from_url()
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
	function translate($code,$templating = null)
	{
		$final_lines	=	array();
		$instance		=	get_instance();
		if($instance->lang->getSystemLang() == 'en_US')
		{
			// not yet
		}
		else if($instance->lang->getSystemLang() == 'fr_FR')
		{
			$text	=	file_get_contents( SYSTEM_DIR . '/config/fr_FR.txt' );
			$exploded	=	explode('[#]',$text);
			$final_lines=	array();
			foreach($exploded as $translate_line)
			{
				if(strlen($translate_line) > 4 && preg_match('#::#',$translate_line))
				{	
					$line_exploder	=	explode('::',$translate_line);
					if(is_array($templating))
					{
						$string			=	$line_exploder[1];
						foreach($templating as $remplacement)
						{
							$percent		=	"%%";
							$position		=	strpos($string,$percent);
							$segment2		=	strlen($string)-$position;
							$first			=	substr($string,0,-($segment2));
							$second			=	$remplacement.substr($string,$position+1);
							$string			=	$first.$second;
						}
						$final_string		=	$string;
					}
					else
					{
						$final_string		=	$line_exploder[1];
					}
					$final_lines[$line_exploder[0]]	=	$final_string;
				}
			}
		}
		if(array_key_exists($code,$final_lines))
		{
			return $final_lines[$code];
		}
		else
		{
			if( SAFE_MODE ){
				return $code;
			} else {
				return '<strong>'.$code.'</strong> does\'nt match any lang code';
			}
		}
	}
}
if(!function_exists('tendoo_error'))
{
	function tendoo_error($x1,$x2,$x3)
	{
		$instance	=	get_instance();
		?>
		<div id="tendoo_error_notice">
			<h2>Erreur</h2>
		</div>
		<?php
	}
}
if(!function_exists('tendoo_exception'))
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
?>