<?php
if(!function_exists('css_url'))
{
	function css_url($e)
	{
		$instance	=	Controller::instance();
		return $instance->url->main_url().'hubby_assets/css/'.$e.'.css';
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
		$instance	=	Controller::instance();
		return $instance->url->main_url().'hubby_assets/script/'.$e.'.js';
	}
}
if(!function_exists('img_url'))
{
	function img_url($e)
	{
		$instance	=	Controller::instance();
		return $instance->url->base_url().'assets/files/'.$e;
	}
}
if(!function_exists('notice'))
{
	function notice($e,$sort = FALSE)
	{
		$array['config_1']					=	'<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-info"></i>Un fichier de configuration est d&eacute;j&agrave; existant. Si vous enregistrer de nouvelles donn&eacute;es, l\'ancien sera &eacute;cras&eacute;</div>';
		$array['accessDenied']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Vous n\'avez pas ou plus acc&egrave;s &agrave; cette page.</div>';
		
		$array['config_2']					=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une erreur fatale s\'est produite durant l\'installation, veuillez re-installer Hubby.</div>';
		$array['noThemeInstalled']			=	'<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Une erreur s\'est produite durant l\'acc&egrave;s au th&egrave;me. Il est possible qu\'aucun th&egrave;me ne soit install&eacute; ou d&eacute;finit comme th&egrave;me par d&eacute;faut.</div>';
		$array['mustCreatePrivilege']		=	'<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Il est n&eacute;cessaire de cr&eacute;er des privil&egrave;ges avant de g&eacute;rer des administrateurs</div>';
		$array['controler_created']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement cr&eacute;e.</div>';		
		$array['c_name_already_found']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une autre page poss&egrave;de d&eacute;j&agrave; ce nom comme contr&ocirc;leur, veuillez choisir un autre nom.</div>';
		$array['name_already_found']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une autre page poss&egrave;de d&eacute;j&agrave; ce nom, veuillez choisir un autre nom.</div>';
		$array['controler_deleted']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement supprim&eacute;.</div>';
		$array['incorrectSuperAdminPassword']	=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Le mot de passe administrateur est incorrect</div>';
		$array['cant_delete_mainpage']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> La page principale ne peut pas &ecirc;tre supprim&eacute;.</div>';
		$array['controler_edited']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement modifi&eacute;.</div>';
		$array['db_unable_to_connect']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Il est impossible de se connect&eacute; avec les informations fournies.</div>';
		$array['db_unable_to_select']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>La connexion &agrave; &eacute;t&eacute; &eacute;tablie, cependant il est impossible d\'acc&eacute;der &agrave; la base de donn&eacute;e.</div>';
		$array['error_occured']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Une erreur s\'est produite durant l\'op&eacute;ration.</div>';
		$array['adminDeleted']				=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> L\'utilisateur &agrave; &eacute;t&eacute; correctement supprim&eacute;.</div>';
		$array['controller_not_found']		=	'<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Ce contr&ocirc;leur est introuvable.</div>';
		$array['no_main_page_set']			=	'<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-info"></i> Aucun contr&ocirc;leur n\'est d&eacute;finie par d&eacute;faut.</div>';
		$array['InvalidModule']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Ce module est invalide ou incompatible.</div>';
		$array['CantDeleteDir']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une erreur s\'est produite durant la suppr&eacute;ssion d\'un dossier.</div>';
		$array['module_corrupted']			= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Ce module ne peut pas &ecirc;tre install&eacute;. Il est corrompu ou incompatible.</div>';	
		$array['errorInstallModuleFirst']	= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Vous devez installer les tables avant d\'installer le module</div>';	
		$array['moduleInstalled']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> L\'installation du module est termin&eacute;.</div>';
		$array['module_alreadyExist']		= '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-info"></i> Ce module &agrave; d&eacute;j&agrave; &eacute;t&eacute; install&eacute;.</div>';	
		$array['unknowModule']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Ce module est introuvable.</div>';
		$array['module_uninstalled']		=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>Le module &agrave; &eacute;t&eacute; install&eacute;.</div>';
		$array['InvalidPage']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Cette page n\'a pas pu &ecirc;tre charg&eacute; car le contr&ocirc;leur correspondant &agrave; cette adresse est introuvable ou indisponible.</div>';
		$array['noControllerDefined']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Impossible d\'acc&eacute;der &agrave; cet &eacute;lement, Il ne dispose pas d\'interface embarqu&eacute;.</div>';
		$array['noFileUpdated']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Aucun fichier n\'a &eacute;t&eacute; re&ccedil;u.</div>';
		$array['done']						=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>L\'op&eacute;ration s\'est d&eacute;roul&eacute;e avec succ&egrave;s.</div>';
		$array['accessForbiden']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Vous ne faites pas partie du privil&egrave;s qui peut acc&eacute;der &agrave; cette page.</div>';
		$array['userCreated']				=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>L\'utilisateur a &eacute;t&eacute; cr&eacute;e.</div>';
		$array['userNotFoundOrWrongPass']	=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Utilisateur introuvable ou mot de passe incorrect.</div>';
		$array['notForYourPriv']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Acc&eacute;der &agrave; cet &eacute;l&eacute;ment ne fait pas partie de vos actions.</div>';
		$array['unknowAdmin']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Administrateur introuvable.</div>';
		$array['moduleBug']					=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une erreur s\'est produite. Le module attach&eacute; &agrave; ce contr&ocirc;leur est introuvable.</div>';
		$array['notAllowed']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Il ne vous est pas permis d\'effctuer cette op&eacute;ration. Soit compte tenu de votre privil&egrave;ge actuel, soit compte tenu de l\'indisponibilit&eacute; du service.</div>';
		$array['theme_alreadyExist']		=	'<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-info"></i>Ce th&egrave;me avait d&eacute;j&agrave; &eacute;t&eacute; install&eacute;.</div>';
		$array['NoCompatibleTheme']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Ce th&egrave;me n\'est pas compatible avec la version actuelle d\'hubby.</div>';
		$array['NoCompatibleModule']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Ce module n\'est pas compatible avec la version actuelle d\'hubby.</div>';
		$array['SystemDirNameUsed']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Ce th&egrave;me ne peut pas s\'installer car il &agrave; tenter d\'utiliser des ressources syst&egrave;me.</div>';
		$array['theme_installed']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>Le th&egrave;me a &eacute;t&eacute; install&eacute; correctement.</div>';
		$array['no_theme_selected']			=	'<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Aucun th&egrave;me n\'a &eacute;t&eacute; choisi comme th&egrave;me par d&eacute;faut.</div>';
		$array['defaultThemeSet']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>Le th&egrave;me &agrave; &eacute;t&eacute; correctement choisi come th&egrave;me par d&eacute;faut.</div>';
		$array['unknowTheme']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Th&egrave;me inconnu ou introuvable.</div>';
		$array['missingArg']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une erreur s\'est produite. Certains &eacute;l&eacute;ment, qui permettent le traitement de votre demande, sont manquant ou incorrect.</div>';
		$array['page404']					=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Cette page est introuvable ou indisponible. Veuillez re-&eacute;ssayer.</div>';
		$array['restoringDone']				=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>La restauration s\'est correctement d&eacute;roul&eacute;.</div>';
		$array['cmsRestored']				=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>La restauration s\'est correctement d&eacute;roul&eacute;.</div>';
		$array['creatingHiddenControllerFailure']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>La cr&eacute;ation du contr&ocirc;leur invisible &agrave; &eacute;chou&eacute;</div>';
		$array['installFailed']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une erreur s\'est produite durant l\'installtion certaines composantes n\'ont pas &eacute;t&eacute; correctement install&eacute;es</div>';
		$array['db_connect_error']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Connexion impossible,int&eacute;rrompu ou le nombre limit de connexion accord&eacute; &agrave; l\'utilisateur de la base de donn&eacute; est atteinte. Veuillez re-&eacute;ssayer.</div>';
		$array['themeTrashed']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Une erreur s\'est produite avec le th&egrave;me. Ce th&egrave;me ne fonctionne pas correctement.</div>';
		$array['noMainPage']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Impossible d\'acc&eacute;der &agrave; la page principale du site. Aucun contr&ocirc;leur n\'a &eacute;t&eacute; d&eacute;finit comme principal</div>';
		$array['AdminAuthFailed']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Mot de passe administrateur incorrect.</div>';
		
		$array['SuperAdminCreationError']	=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Un erreur s\'est produite durant la cr&eacute;ation du Super-administrateur. V&eacute;fiez les informations envoy&eacute;es ou assurez vous qu\'il n\'existe pas un autre Super-administrateur pour ce site.</div>';
		$array['adminCreated']				=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i>L\'utilisateur &agrave; &eacute;t&eacute; correctement cr&eacute;e</div>';
		$array['no_page_set']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Aucun contr&ocirc;leur disponible.</div>';
		$array['privilegeNotFound']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Privil&egrave;ge introuvable.</div>';
		$array['invalidApp']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Application Hubby non valide. L\'installation &agrave; &eacute;chou&eacute;e</div>';
		$array['adminCreationFailed']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Impossible de cr&eacute;er un administrateur, verifiez la correspondance de pseudo et vos actions.</div>';
		$array['tableCreationFailed']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Impossible d\'installer Hubby, les informations fournies sont peut &ecirc;tre invalide. Assurez-vous de la validité de la connexion et de leur conformit&eacute; aux informations fournies.</div>';
		$array['upload_invalid_filetype']	=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Extension du fichier non autoris&eacute;e</div>';
		$array['themeControlerFailed']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>L\'interace embarqu&eacute; de ce th&egrave;me n\'est pas correctement d&eacute;finie.</div>';
		$array['themeControlerNoFound']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Ce th&egrave;me ne dispose pas d\'interface embarqu&eacute;..</div>';
		$array['registrationNotAllowed']	=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Il impossible de s\'inscrire. L\'inscription &agrave; &eacute;t&eacute; d&eacute;sactiv&eacute;e sur ce site.</div>';
		$array['userExists']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>Un utilisateur poss&eacute;dant ce pseudo existe d&eacute;j&agrave;.</div>';
		$array['emailUsed']					=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Cet email est d&eacute;j&agrave; utilis&eacute;, veuillez choisir un autre.</div>';
		$array['unallowedPrivilege']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Ce privil&egrave;ge n\'est pas autoris&eacute;.</div>';
		$array['UnactiveUser']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Cet utilisateur est inactif, veuillez consulter l\'adresse email fournie pour cet utilsateur. Si aucun mail d\'activation n\'a &eacute;t&eacute; envoy&eacute;, vous pouvez essayer &agrave; nouveau. En utilisant la proc&eacute;dure de r&eacute;cup&eacute;ration de mot de passe</div>';
		$array['alreadyActive']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Impossible d\'envoyer le mail d\'activation car le compte attach&eacute; &agrave; cette adresse mail est d&eacute;j&agrave; actif.</div>';
		$array['actionProhibited']			=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Il vous est interdit d\'effectuer cette op&eacute;ration.</div>';
		$array['unknowEmail']				=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Aucun compte n\'est attach&eacute; &agrave; cette adresse mail.</div>';
		$array['validationSended']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> Un mail d\'activation &agrave; &eacute;t&eacute; envoy&eacute; &agrave; cette addresse.</div>';
		$array['regisAndAssociatedFunLocked']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> L\'inscription et les services associ&eacute;s sont d&eacute;sactiv&eacute;s sur ce site.</div>';
		$array['NewLinkSended']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> Un nouveau lien &agrave; &eacute;t&eacute; envoy&eacute; &agrave; votre boite mail.</div>';
		$array['timeStampExhausted']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Ce lien n\'est plus valide. La dur&eacute;e de vie de ce lien &agrave; expir&eacute;e.</div>';
		$array['activationFailed']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Ce lien n\'est plus valide. La dur&eacute;e de vie de ce lien &agrave; expir&eacute;e.</div>';
		$array['accountActivationDone']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> Le compte est d&eacute;sormais actif.</div>';
		$array['accountActivationFailed']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> L\'activation du compte &agrave; &eacute;chou&eacute;e.</div>';
		$array['samePassword']					=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Le nouveau mot de passe ne peut pas &ecirc;re identique &agrave; l\'ancien.</div>';
		$array['passwordChanged']			=	'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-thumbs-up-alt"></i> Le mot de passe &agrave; &eacute;t&eacute; correctement modifi&eacute;.</div>';
		$array['upload_no_file_selected']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Aucun fichier n\'a &eacute;t&eacute; envoy&eacute;.</div>';
		$array['cannotDeleteUsedPrivilege']		=	'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> Vous ne pouvez pas supprimer un privil&egrave;ge en cours d\'utilisation.</div>';
		
		
		
		
		
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
						return '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> "'.$e.'" constitue une alerte introuvable</div>';
					}
				}
				else if($e != '' && strlen($e) <= 50)
				{
					return '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i> "'.$e.'" constitue une alerte introuvable</div>';
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
if(!function_exists('notice_from_url'))
{
	function notice_from_url()
	{
		if(isset($_GET['notice']))
		{
			return notice($_GET['notice']);
		}
	}
}
if(!function_exists('notice_from_url_by_modal'))
{
	function notice_from_url_by_modal()
	{
		if(isset($_GET['notice']))
		{
			?><div class="notices" id="this_notice" style="position:fixed;width:300px;bottom:10px;left:10px;"><div class="tile double bg-color-purple padding10"><?php echo strip_tags(notice($_GET['notice']));?></div></div><script type="text/javascript">
				$('#this_notice').bind('click',function()
				{
					$(this).fadeOut(500,function()
					{
						$(this).remove();
					});
				});
				$(document).ready(function()
				{
					$('#this_notice').animate({"margin-left":"10px"},80,'linear',function()
					{
						$(this).animate({"margin-left":"-10px"},80,"linear",function()
						{
							$(this).animate({"margin-left":"10px"},80,'linear',function()
							{
								$(this).animate({"margin-left":"-10px"},80,"linear",function()
								{
									$(this).animate({"margin-left":"10px"},80,'linear');
								});								
							});
						})
					});
					setTimeout(function(){
						$('#this_notice').trigger('click');
					},10000);
				});
			</script><?php
		}
	}
}
if(!function_exists('sup'))
{
	function sup($e) // Site Url Plus
	{
		$ci		=	get_instance();
		$ci		=	$ci->uri;
		$uri	=	explode('/',$ci->uri_string);
		$length	=	count($uri);
		$end_uri=	'';
		for($_i = 0;$_i <= 2 ;$_i++)
		{
			$end_uri	.= '/';
			$end_uri	.=$uri[$_i];
		}
		return site_url($end_uri.'/'.$e);
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
			?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Erreur - Serveur incompatible</title><body><p>Le serveur sous lequel tourne ce site ne supporte pas certaines fonctionnalité. Hubby ne peut pas correctement s'ex&eacute;cuter</p></body></html><?php
		}
	}
}
?>