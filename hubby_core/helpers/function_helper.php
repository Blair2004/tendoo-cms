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
		?>
        <p style="border:solid 1px #CCC;padding:1%;width:96%;margin:1%;text-align:center;background:#FFE6E6;color:#777;"><span>Error : </span><?php echo $content;?></p>
        <?php
	}
}
if(!function_exists('log_message'))
{
	function log_message($e,$content)
	{
		return // take care after;
		?>
        <h1><?php echo $e;?></h1>
        <p><?php echo $content;?></p>
        <?php
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
		$array['config_1']	=	'<span class="hubby_notice"><i class="icon-info"></i> Un fichier de configuration est d&eacute;j&agrave; existant. Si vous enregistrer de nouvelles informations de connexion, les param&ecirc;tres pr&eacute;c&eacute;dent seront remplac&eacute;s</span>';
		$array['accessDenied']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Vous n\'avez pas ou plus acc&egrave;s &agrave; cette page.</span>';
		
		$array['config_2']	=	'<span class="hubby_warning"><i class="icon-warning"></i> Une erreur s\'est produite. L\'installation n\'a pas pu s\'achever. Veuillez reinstaller le site.</span>';
		$array['noThemeInstalled']	=	'<span class="hubby_warning"><i class="icon-warning"></i> Une erreur est survenu durant l\'affichage de la page, il s\'av&egrave;re qu\'aucun th&egrave;me ne soit install&eacute; ou choisi par d&eacute;faut, v&eacute;rifiez dans le "Panneau de Contr&ocirc;le->gestion de th&egrave;mes".</span>';
		$array['mustCreatePrivilege']	=	'<span class="hubby_warning"><i class="icon-warning"></i> Il est n&eacute;cessaire de cr&eacute;er un privil&egrave;ge au moins avant de cr&eacute;er des administrateurs, ou de g&eacute;rer des actions syst&egrave;me et communes.</span>';
		$array['controler_created']	=	'<span class="hubby_success"><i class="icon-info"></i> Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement cr&eacute;e</span>';		
		$array['c_name_already_found']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Une autre page poss&egrave;de d&eacute;j&agrave; ce contr&ocirc;leur. veuillez changer le nom du contr&ocirc;leur.</span>';
		$array['name_already_found']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Une autre page poss&egrave;de d&eacute;j&agrave; ce nom. veuillez changer le nom de la page.</span>';
		$array['controler_deleted']	=	'<span class="hubby_success"><i class="icon-info"></i> Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement supprim&eacute;</span>';
		$array['incorrectSuperAdminPassword']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Le mot de passe administrateur est incorrect.</span>';
		$array['cant_delete_mainpage']	=	'<span class="hubby_warning"><i class="icon-warning"></i> La page principale ne peut pas &ecirc;tre supprim&eacute;, si vous n\'avez pas d&eacute;fini une autre page principale.</span>';
		$array['controler_edited']	=	'<span class="hubby_success"><i class="icon-info"></i> La page &agrave; &eacute;t&eacute; modifi&eacute;</span>';
		$array['db_unable_to_connect']	=	'<span class="hubby_error"><i class="icon-blocked"></i> La connexion est impossible &agrave; la base de donn&eacute;e avec les informations que vous avez fournies.</span>';
		$array['db_unable_to_select']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Connexion &eacute;tablie, mais impossible de selectionner la base de donn&eacute;e. Bien vouloir v&eacute;rifier son existance .</span>';
		$array['error_occured']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Une erreur s\'est produite durant l\'op&eacute;ration</span>';
		$array['adminDeleted']		=	'<span class="hubby_success"><i class="icon-info"></i> L\'administrateur &agrave; &eacute;t&eacute; correctement supprim&eacute;.</span>';
		$array['controller_not_found']	=	'<span class="hubby_warning"><i class="icon-warning"></i> Ce contr&ocirc;leur est introuvable</span>';
		$array['no_main_page_set']	=	'<span class="hubby_notice"><i class="icon-info"></i> Attention aucune page principale n\'est definie</span>';
		$array['InvalidModule']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Le module que vous tentez d\'installer est invalide, l\'installation &agrave; &eacute;chou&eacute;</span>';
		$array['CantDeleteDir']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Un erreur s\'est produite durant la suppréssion d\'un dossier</span>';
		$array['module_corrupted']	= '<span class="hubby_error"><i class="icon-blocked"></i> Ce module ne peut pas être install&eacute;, car il est corrompu.</span>';	
		$array['errorInstallModuleFirst']	= '<span class="hubby_error"><i class="icon-blocked"></i> Vous devez d\'abord installer le module avant d\'installer les tables.</span>';	
		$array['moduleInstalled']	=	'<span class="hubby_success"><i class="icon-info"></i> L\'installation du module est terminé.</span>';
		$array['module_alreadyExist']	= '<span class="hubby_notice"><i class="icon-info"></i>  Ce module est d&eacute;j&agrave; install&eacute;.</span>';	
		$array['unknowModule']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Ce module est introuvable</span>';
		$array['module_uninstalled']	=	'<span class="hubby_success"><i class="icon-info"></i> Le module &agrave; &eacute;t&eacute; supprim&eacute;.</span>';
		$array['InvalidPage']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Cette page n\'a pas pu être chargé, car le module d&eacute;finie pour cette page est indisponible ou introuvable. Il est &eacute;galement possible que le module en question n\'a pas &eacute;t&eacute; activ&eacute; depuis l\'espace d\'administration. Vous pouvez g&eacute;rer les modules depuis l\'espace d\'administration.</span>';
		$array['noControllerDefined']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Impossible d\'acc&eacute;der. Cet &eacute;l&eacute;ment &agrave; express&eacute;ment refus&eacute; un acc&egrave;s direct.</span>';
		$array['noFileUpdated']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Aucun fichier n\'a été envoy&eacute;, la demande ne peut aboutir.</span>';
		$array['done']				=	'<span class="hubby_success"><i class="icon-info"></i> L\'opération s\'est correctement exécutée.</span>';
		$array['accessForbiden']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Cette page n\'est désormais plus disponible ou vous est interdite.</span>';
		$array['userCreated']	=	'<span class="hubby_success"><i class="icon-info"></i> L\'utilisateur à été crée.</span>';
		$array['userNotFoundOrWrongPass']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Utilisateur introuvable ou pseudo et/ou mot de passe &eacute;rron&eacute;e.</span>';
		$array['notForYourPriv']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Acc&eacute;der &agrave; cet &eacute;l&eacute;ment ne fait pas partie de vos privil&egrave;ges.</span>';
		$array['unknowAdmin']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Administrateur introuvable.</span>';
		$array['moduleBug']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Une erreur s\'est produite. Le module auquel ce module est attach&eacute; est introuvable.</span>';
		$array['notAllowed']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Il ne vous est pas permis d\'effectuer cette op&eacute;ration, soit parceque cela vous &agrave; &eacute;t&eacute; expr&egrave;ssement interdit, soit parceque vos privil&egrave;ges actuels ne vous le permettent pas.</span>';
		$array['theme_alreadyExist']	=	'<span class="hubby_notice"><i class="icon-info"></i> Ce th&egrave;me est d&eacute;j&agrave; install&eacute;.</span>';
		$array['NoCompatibleTheme']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Ce th&egrave;me n\'est pas compatible avec votre version actuelle d\'Hubby.</span>';
		$array['NoCompatibleModule']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Ce module n\'est pas compatible avec votre version actuelle d\'Hubby.</span>';
		$array['SystemDirNameUsed']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Ce th&egrave;me ne peut pas &ecirc;tre install&eacute; car il a tent&eacute; de s\'installer dans un dossier syst&ecirc;me.</span>';
		$array['theme_installed']	=	'<span class="hubby_success"><i class="icon-info"></i> L\'installation du th&egrave;me &agrave; r&eacute;ussi.</span>';
		$array['no_theme_selected']	=	'<span class="hubby_warning"><i class="icon-warning"></i></i> Attention, aucun th&egrave;me n\'a &eacute;t&eacute; choisi par d&eacute;faut.</span>';
		$array['defaultThemeSet']	=	'<span class="hubby_success"><i class="icon-info"></i> le th&egrave;me &agrave; &eacute;t&eacute; correctement d&eacute;finit par d&eacute;faut.</span>';
		$array['unknowTheme']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Une erreur est survenu, ce th&egrave;me est inconnu ou introuvable</span>';
		$array['missingArg']	=	'<span class="hubby_error"><i class="icon-blocked"></i> Une erreur s\'est produite. Cette erreur &agrave; &eacute;t&eacute; caus&eacute; par un manque d\'argument, ou les arguments envoy&eacute;s sont incorrects.</span>';
		$array['page404']		=	'<div class="hubby_error"><i class="icon-blocked"></i> La page que &agrave; laquelle vous souhaitez acc&eacute;der est introuvable ou actuellement indisponible.</div>';
		$array['restoringDone']		=	'<span class="hubby_success"><i class="icon-info"></i> La restauration s\'est correctement d&eacute;roul&eacute;e.</span>';
		$array['cmsRestored']		=	'<span class="hubby_success"><i class="icon-checkmark"></i> La restauration s\'est d&eacute;roul&eacute; avec succ&egrave;s.</span>';
		$array['creatingHiddenControllerFailure']		=	'<span class="hubby_error"><i class="icon-blocked"></i> La cr&eacute;ation du "controlleur module" &agrave; &eacute;chou&eacute;.</span>';
		$array['installFailed']		=	'<span class="hubby_error"><i class="icon-warning"></i> Une erreur est survenue durant l\'installation, certaines composantes n\'ont pas &eacute;t&eacute; correctement install&eacute;.</span>';
		$array['db_connect_error']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Connexion impossible ou int&eacute;rrompu. nombre maximum de connexion atteint pour cet utilisteur ou d&eacute;lai de connexion d&eacute;pass&eacute;. Veuillez recharger la page</span>';
		$array['themeTrashed']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Une erreur est survenu, le th&egrave;me ne fonctionne pas correctement.</span>';
		$array['noMainPage']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Erreur : Vous tentez d\'acc&eacute;der &agrave; la page principale du site, cependant aucune page n\'a &eacute;t&eacute; d&eacute;finie par d&eacute;faut. Connectez-vous &agrave; l\'espace administrateur pour corriger ce probl&egrave;me.</span>';
		$array['AdminAuthFailed']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Pseudo ou mot de passe administrateur incorrect</span>';
		
		$array['SuperAdminCreationError']		=	'<p class="span8 padding10">Une erreur s\'est produite durant la cr&eacute;ation d\'un super administrateur.<br>Assurez vous que :<ul><li>Le pseudo et mot de passe n\'ont pas moins de 6 caract&egrave;res</li><li>Qu\'il n\'existe pas un autre super administrateur</li></ul></p>';
		$array['adminCreated']		=	'<span class="hubby_notice"><i class="icon-info"></i> L\'administrateur &agrave; &eacute;t&eacute; correctement cr&eacute;e</span>';
		$array['no_page_set']		=	'<span class="hubby_notice"><i class="icon-info"></i> Votre site n\'a aucune page cr&eacute;ee.</span>';
		$array['accessDenied']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Vous n\'avez pas le droit d\'acc&eacute;der &agrave; cette page.</span>';
		$array['privilegeNotFound']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Ce privil&egrave;ge est introuvable.</span>';
		$array['invalidApp']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Cette application Hubby est incorrecte, l\'installation &agrave; &eacute;chou&eacute;.</span>';
		$array['adminCreationFailed']		=	'<span class="hubby_error"><i class="icon-blocked"></i> La cr&eacute;ation de l\'administrateur &agrave; &eacute;chou&eacute;. V&eacute;rifiez qu\'un autre administrateur portant le m&ecirc;me pseudo n\'existe pas. Il est &eacute;galement possible que le privili&egrave;ge qui lui a &eacute;t&eacute; affect&eacute; ne soit pas autoris&eacute;, ou que vous n\'avez pas les privil&egrave;ges suffisants pour effectuer cette op&eacute;ration.</span>';
		$array['tableCreationFailed']		=	'<span class="hubby_error"><i class="icon-blocked"></i> Une erreur s\'est produite durant la cr&eacute;ation de tables. Il est possible que les inforamtions qui ont &eacute;t&eacute; fournies pour la connexion vers la base de donn&eacute;e sont incorrecte. Veuillez recommencer.</span>';
		$array['upload_invalid_filetype']		=	'<span class="hubby_error"><i class="icon-blocked"></i> L\'extension de ce fichier n\'est pas autoris&eacute;e</span>';
		$array['themeControlerFailed']		=	'<span class="hubby_notice"><i class="icon-blocked"></i> Le contr&ocirc;leur de ce th&egrave;me n\'est pas correctement d&eacute;finie. La gestion des param&ecirc;tres avanc&eacute;s est suspendue.</span>';
		$array['themeControlerNoFound']		=	'<span class="hubby_notice"><i class="icon-blocked"></i> Ce th&egrave;me ne contient aucun gestionnaire avanc&eacute; de param&ecirc;tre.</span>';
		
		
		
		
		if($e === TRUE)
		{
			?>
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
            <table class="notice_sorter">
            	<thead>
                	<tr>
                    	<td>Index</td>
                        <td>Code</td>
                        <td>Description</td>
                    </tr>
                </thead>
                <tbody>
            <?php    
			$index		=	1;
			foreach($array as $k => $v)
			{
				?>
                <tr>
                	<td><?php echo $index;?></td>
                    <td><?php echo $k;?></td>
                    <td><?php echo strip_tags($v);?></td>
                </tr>
                <?php
				$index++;
			}
			?>
	            </tbody>
            </table>
            <?php
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
						return '<span class="hubby_notice"><i class="icon-info"></i> "'.$e.'" constitue une alerte introuvable</span>';
					}
				}
				else if($e != '' && strlen($e) <= 50)
				{
					return '<span class="hubby_notice"><i class="icon-info"></i> "'.$e.'" constitue une alerte introuvable</span>';
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
			?>
            <div class="notices" id="this_notice" style="position:fixed;width:300px;bottom:10px;left:10px;">
            	<div class="tile double bg-color-purple padding10">
                <?php echo strip_tags(notice($_GET['notice']));?>
                </div>
            </div>
            <script type="text/javascript">
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
			</script>
            <?php
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
			?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Erreur - Serveur incompatible</title>
                <body>
                	<p>Le serveur sous lequel tourne ce site ne supporte pas certaines fonctionnalité. Hubby ne peut pas correctement s'ex&eacute;cuter</p>
                </body>
            </html>
            <?php
		}
	}
}
?>