<?php
/**
 * 	Load Core Default Value
 * 	@since : tendoo 1.4
**/
class Load_Core_Values
{
	function __construct( $is_installed )
	{
		// Settings Tendoo Core Vars
		set_core_vars( 'tendoo_core_permissions' , array(
			'name'				=>	__( 'Tendoo Permissions' ),
			'declared_actions'	=>	array(
				array( 
					'action'			=>	'manage_themes',
					'action_name'		=>	__( 'Manage Themes' ),
					'action_description'=>	__( 'This permissions allow user to manage themes (activate, uninstall)' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_modules',
					'action_name'		=>	__( 'Manage Modules' ),
					'action_description'=>	__( 'This permissions allow user to manage modules (activate, uninstall)' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_controllers',
					'action_name'		=>	__( 'Manage Modules' ),
					'action_description'=>	__( 'This permissions allow user to manage controller (create, delete)' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_settings',
					'action_name'		=>	__( 'Manage Settings' ),
					'action_description'=>	__( 'This permissions allow user to manage site settings' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'install_app',
					'action_name'		=>	__( 'Install App' ),
					'action_description'=>	__( 'This permissions allow user to install app' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_roles',
					'action_name'		=>	__( 'Manage Roles' ),
					'action_description'=>	__( 'This permissions allow user to manage roles' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_users',
					'action_name'		=>	__( 'Manage Users' ),
					'action_description'=>	__( 'This permissions allow user to manage users' ),
					'mod_namespace'		=>	'system'
				),
				array( 
					'action'			=>	'manage_tools',
					'action_name'		=>	__( 'Manage Tools' ),
					'action_description'=>	__( 'This permissions allow user to manage tools' ),
					'mod_namespace'		=>	'system'
				)
			)
		) , 'read_only' );
		$pseudo		=	array(
			'name'	=>	'admin_pseudo',
		);
		
		if( $is_installed )
		{
			$this->db_vars();
		}
		// Can be filtered using "user_fields"
		register_fields( 'user_form_fields' , array(
			'name'			=>	'admin_bio'
		) );		
		bind_filter( 'user_form_fields' , array( $this , 'user_form_fields' ) );		
		bind_filter( 'declare_notices' , array( $this , 'declare_notices' ) );
		
		$this->default_notices();
	}
	function user_form_fields( $field ) {
		$field[]		=	array(
			'name'			=>	'admin_bio',
			'placeholder'	=>	__( 'User Bio' ),
			'label'			=>	__( 'Bio' ),
			'type'			=>	'textarea',
			'description'	=>	__( 'User Bio' )
		);
		return $field;
	}
	/**
	 * default_notices
	 *
	 * Register default tendoo warning
	 *
	 * @access private
	 * @return void
	**/
	private function default_notices()
	{
		$__['config-file-founded']		=	tendoo_info( __( 'A config file already exists. If you save new data the older will be overwritten' ) );
		$__['accessDenied']				=	$__[ 'access-denied' ]				=	tendoo_warning( __( 'Access denied. Your access is not granted to this page' ) );
		$__['installation-failed']		=	tendoo_warning( __( 'Error occured during installation. Please remove tendoo and install it again' ) );
		$__['no-theme-installed']		=	tendoo_warning( __( 'Error occured. It seems that there isn\'t any theme installed' ) );
		$__['role-required']			=	tendoo_warning( __( 'Role must be set first before creating user.' ) );
		$__['controler_created']		=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement cr&eacute;e.');		
		$__['c_name_already_found']		=	tendoo_warning('Une autre page poss&egrave;de d&eacute;j&agrave; ce nom comme contr&ocirc;leur, veuillez choisir un autre nom.');
		$__['name_already_found']		=	tendoo_warning('Une autre page poss&egrave;de d&eacute;j&agrave; ce nom, veuillez choisir un autre nom.');
		$__['controler_deleted']		=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement supprim&eacute;.');
		$__['controllers_updated']		=	tendoo_success('Les contr&ocirc;leurs ont été correctement mis à jour.');
		$__['incorrectSuperAdminPassword']	=	tendoo_warning('Le mot de passe administrateur est incorrect');
		$__['cantHeritFromItSelf']		=	tendoo_warning('Ce contr&ocirc;leur ne peut pas &ecirc;tre un sous menu de lui m&ecirc;me. La modification de l\'emplacement &agrave; &eacute;chou&eacute;.');
		$__['cantSendMsgToYou']			=	tendoo_warning('Une erreur s\'est produite, vous ne pouvez pas vous envoyer un message.');
		$__['curl_is_not_set']			=	tendoo_warning('CURL n\'est pas disponible sur ce site.');
		$__['unkConSpeAsParent']		=	tendoo_warning('Le contr&ocirc;leur (Menu), d&eacute;finie comme parent est introuvable. La modification du contr&ocirc;leur &agrave; &eacute;chou&eacute;.');
		$__['module_success_enabled']	=	tendoo_success('Le module à correctement été activé.');
		$__['module_success_disabled']	=	tendoo_success('Le module à correctement été désactivé.');
		$__['addingActionFailure']		=	tendoo_warning('La cr&eacute;ation d\'action pour ce module &agrave; &eacute;chou&eacute;.');
		$__['subMenuLevelReach']		=	tendoo_warning('Impossible de cr&eacute;er ou de modifier ce contr&ocirc;leur, la limitation en terme de sous menu &agrave; &eacute;t&eacute; atteinte. Veuillez choisir un autre menu ou en cr&eacute;er un nouveau.');
		$__['cantUserReservedCNames']	=	tendoo_warning('Ce code du contr&ocirc;leur est un code reserv&eacute;, vous ne pouvez pas l\'utiliser.');
		$__['unknowProfil']				=	tendoo_warning('Le profil que vous souhaitez visiter est introuvable. Il est en outre probable que cet utilisateur n\'existe pas ou que son compte &agrave; &eacute;t&eacute; supprim&eacute;.');
		$__['upload_invalid_filesize']	=	tendoo_warning('La taille du fichier est supérieur à celle autorisée.');
		$__['cant_delete_mainpage']		=	tendoo_warning(' La page principale ne peut pas &ecirc;tre supprim&eacute;.');
		$__['controler_edited']			=	tendoo_success(' Le contr&ocirc;leur &agrave; &eacute;t&eacute; correctement modifi&eacute;.');
		$__['db_unable_to_connect']		=	tendoo_warning('Il est impossible de se connecter &agrave; la base de donn&eacute;es avec les informations fournies.');
		$__['db_unable_to_select']		=	tendoo_warning('La connexion &agrave; &eacute;t&eacute; &eacute;tablie, cependant il est impossible d\'acc&eacute;der &agrave; la base de donn&eacute;e.');
		$__['error-occured']			=	tendoo_warning( translate( 'A error occured during this operation.' ) );
		$__['adminDeleted']				=	tendoo_success(' L\'utilisateur &agrave; &eacute;t&eacute; correctement supprim&eacute;.');
		$__['controller_not_found']		=	tendoo_warning(' Ce contr&ocirc;leur est introuvable.');
		$__['no_main_controller_created']=	tendoo_warning(' Aucun contr&ocirc;leur d&eacute;finit comme principale n\'a &eacute;t&eacute; retrouv&eacute;, le nouveau contr&ocirc;leur &agrave; &eacute;t&eacute; d&eacute;finit comme contr&ocirc;leur par d&eacute;faut.');
		$__['no_main_page_set']			=	tendoo_info(' Aucun contr&ocirc;leur n\'est d&eacute;finie par d&eacute;faut.');
		$__['no_priv_created']			=	tendoo_info(' Aucun privil&egrave;ge n\'a &eacute;t&eacute; cr&eacute;e, Pour administrer les actions, il est indispensable de cr&eacute;er un privil&egrave;ge au moins.');
		$__['InvalidModule']			=	tendoo_warning('Ce module est invalide ou incompatible.');
		$__['CantDeleteDir']			=	tendoo_warning('Une erreur s\'est produite durant la suppr&eacute;ssion d\'un dossier.');
		$__['module_corrupted']			= 	tendoo_warning('Ce module ne peut pas &ecirc;tre install&eacute;. Il est corrompu ou incompatible.');	
		$__['errorInstallModuleFirst']	= 	tendoo_warning('Vous devez installer les tables avant d\'installer le module');	
		$__['module-has-been-installed']=	tendoo_success( translate( 'The module has been sucessfully installed.' ) );
		$__['module-already-exists']	= 	tendoo_warning( translate( 'A module with the same namespace already exists.') );	
		$__['unactive-or-unknow-module']=	tendoo_warning( __( 'This module is not found or has been disabled.' ) ); // Translated
		$__['module-has-been-installed']=	tendoo_success('Le module &agrave; &eacute;t&eacute; d&eacute;sinstall&eacute;.');
		$__['InvalidPage']				=	tendoo_warning('Cette page n\'a pas pu &ecirc;tre charg&eacute; car le contr&ocirc;leur correspondant &agrave; cette adresse est introuvable ou indisponible.'); // Deprecated ?
		$__['noControllerDefined']		=	tendoo_warning('Impossible d\'acc&eacute;der &agrave; cet &eacute;lement, Il ne dispose pas d\'interface embarqu&eacute;.');
		$__['cantSetChildAsMain']		=	tendoo_warning('Un sous menu ne peut pas &ecirc;tre d&eacute;finie comme page principale. La modification de la priorit&eacute; &agrave; &eacute;chou&eacute;e.');
		$__['noFileUpdated']				=	tendoo_warning('Aucun fichier n\'a &eacute;t&eacute; re&ccedil;u.');
		$__['done']						=	tendoo_success('L\'op&eacute;ration s\'est d&eacute;roul&eacute;e avec succ&egrave;s.');
		$__['accessForbiden']			=	tendoo_warning('Vous ne faites pas partie du privil&egrave;s qui peut acc&eacute;der &agrave; cette page.');
		$__['userCreated']				=	tendoo_success('L\'utilisateur a &eacute;t&eacute; cr&eacute;e.');
		$__['userNotFoundOrWrongPass']	=	tendoo_warning('Utilisateur introuvable ou mot de passe incorrect.');
		$__['notForYourPriv']			=	tendoo_warning('Acc&eacute;der &agrave; cet &eacute;l&eacute;ment ne fait pas partie de vos actions.');
		$__['unknowAdmin']				=	tendoo_warning('Administrateur introuvable.');
		$__['moduleBug']					=	tendoo_warning('Une erreur s\'est produite. Le module attach&eacute; &agrave; ce contr&ocirc;leur est introuvable ou d&eacute;sactiv&eacute;.');
		$__['page-404-or-module-bug']	=	tendoo_warning( __( 'Error occured. Page not found or binded module is not well defined.' ) );
		$__['notAllowed']				=	tendoo_warning('Il ne vous est pas permis d\'effctuer cette op&eacute;ration. Soit compte tenu de votre privil&egrave;ge actuel, soit compte tenu de l\'indisponibilit&eacute; du service.');
		$__['theme_alreadyExist']		=	tendoo_info('Ce th&egrave;me avait d&eacute;j&agrave; &eacute;t&eacute; install&eacute;.');
		$__['NoCompatibleTheme']			=	tendoo_warning('Ce th&egrave;me n\'est pas compatible avec la version actuelle d\'tendoo.');
		$__['NoCompatibleModule']		=	tendoo_warning( translate( 'module_compatibility_issues' ) );
		$__['module_updated']			=	tendoo_success( translate( 'module_updated' ) );
		$__['SystemDirNameUsed']			=	tendoo_warning('Ce th&egrave;me ne peut pas s\'installer car il &agrave; tenter d\'utiliser des ressources syst&egrave;me.');
		$__['theme_installed']			=	tendoo_success('Le th&egrave;me a &eacute;t&eacute; install&eacute; correctement.');
		$__['no_theme_selected']			=	tendoo_warning('Aucun th&egrave;me n\'a &eacute;t&eacute; choisi comme th&egrave;me par d&eacute;faut.');
		$__['defaultThemeSet']			=	tendoo_success('Le th&egrave;me &agrave; &eacute;t&eacute; correctement choisi come th&egrave;me par d&eacute;faut.');
		$__['theme-not-found']			=	tendoo_warning('Th&egrave;me inconnu ou introuvable.');
		$__['missingArg']				=	tendoo_warning('Une erreur s\'est produite. Certains &eacute;l&eacute;ment, qui permettent le traitement de votre demande, sont manquant ou incorrect.');
		$__['page-404']					=	tendoo_warning('Cette page est introuvable ou indisponible. Veuillez re-&eacute;ssayer.');
		// $__['restoringDone']				=	tendoo_success('La restauration s\'est correctement d&eacute;roul&eacute;.');
		// $__['cmsRestored']				=	tendoo_success('La restauration s\'est correctement d&eacute;roul&eacute;.');
		$__['creatingHiddenControllerFailure']		=	tendoo_warning('La cr&eacute;ation du contr&ocirc;leur invisible &agrave; &eacute;chou&eacute;');
		$__['installFailed']				=	tendoo_warning('Une erreur s\'est produite durant l\'installtion certaines composantes n\'ont pas &eacute;t&eacute; correctement install&eacute;es');
		$__['db_connect_error']			=	tendoo_warning('Connexion impossible,int&eacute;rrompu ou le nombre limit de connexion accord&eacute; &agrave; l\'utilisateur de la base de donn&eacute; est atteinte. Veuillez re-&eacute;ssayer.');
		$__['themeCrashed']				=	tendoo_warning('Une erreur s\'est produite avec le th&egrave;me. Ce th&egrave;me ne fonctionne pas correctement.');
		$__['noMainPage']				=	tendoo_warning('Impossible d\'acc&eacute;der &agrave; la page principale du site. Aucun contr&ocirc;leur n\'a &eacute;t&eacute; d&eacute;finit comme principal');
		$__['admin-auth-failed']					=	tendoo_warning( __( 'Incorrect password or user not found' ) );
		
		$__['super-admin-creation-failed']		=	tendoo_warning( __( 'Super administrator creation failed. Check if, for this website, there are not yet a super administrator.') );
		$__['user-has-been-created']			=	tendoo_success( __( 'User has been successfully created.' ) );
		$__['no-controller-set']				=	tendoo_warning( __( 'There is no controller available' ) );
		$__['role-not-found']					=	tendoo_warning( __( 'Role not found' ) );
		$__['invalid-app']						=	tendoo_warning( __( 'This app is not a valid Tendoo App. Installation has failed.' ) );
		$__['users-creation-failed']			=	tendoo_warning( __( 'User creation failed, check if this pseudo is not already taken.' ) );
		$__['table-creation-failed']			=	tendoo_warning( __( 'Error occured. Tables wasn\'t installed. Check your provided database login data' ) );
		$__['upload-invalid-file-type']			=	tendoo_warning( __( 'This file type is not allowed' ) );
		$__['controller-not-properly']			=	tendoo_warning( __( 'Controller interface is not well defined' ) );
		// $__['themeControlerNoFound']		=	tendoo_warning('Ce th&egrave;me ne dispose pas d\'interface embarqu&eacute;..'); // Deprecated ?
		$__['pseudo-already-in-use']			=	tendoo_warning( __( 'This pseudo is already used. Please choose another one' ) );
		$__['email-already-used']				=	tendoo_warning( __( 'This email is already used, please choose another one or try to restore your account.' ) );
		$__['unallowed-role']					=	tendoo_warning( __( 'This role is not allowed.' ) );
		$__['unactive-account']					=	tendoo_warning( __( 'This account is not yet active. Please, check the inbox associated to this email address. If there is no activation mail, you can try to receive it again, with the activation wizard.' ) );
		$__['already-active']					=	tendoo_warning( __( 'Activation mail could not been send. This account seems to be already active.' ) );	
		$__['action-prohibited']				=	tendoo_warning( __( 'You are not granted to do this.' ) );
		$__['unknow-email']						=	tendoo_warning( __( 'There is no account associated to this email address' ) );
		$__['activation-mail-send']				=	tendoo_success( __( 'An activation mail has been send.' ) );
		$__['registration-not-allowed']			=	$__['registration-disabled']			=	tendoo_warning( __( 'Registration and associated services are disabled in this website.' ) );
		$__['new-link-send']					=	tendoo_success( __( 'A new link has been send to your email address.' ) );
		$__['expiration-time-reached']			=	tendoo_warning( __( 'This link is no more valid.' ) );
		$__['activation-failed']				=	tendoo_warning( __( 'This activation link is no more valid.' ) );
		$__['account-activation-done']			=	tendoo_success( __( 'This account is now active' ) );
		$__['account-activation-failed']		=	tendoo_warning( __( 'The account activation failed.' ) );
		$__['password-matches-error']			=	tendoo_warning( __( 'The new password should not match the old one.' ) );
		$__['password-has-changed']				=	tendoo_success( __( 'The password has been changed.' ) );
		$__['upload-file-no-available']			=	tendoo_warning( __( 'Select a file first.' ) );
		$__['cannot-delete-active-role']		=	tendoo_warning( __( 'A role in use can\'t be deleted.') );
		$__[ 'profile-updated' ]				=	tendoo_success( __( 'Profile has been updated.' ) );
		$__[ 'role-permissions-saved' ]			=	tendoo_success( __( 'Role permissions has been saved.' ) );
		$__[ 'unsupported-by-current-theme' ]	=	tendoo_warning( __( 'Active theme does\'nt support this module' ) );
		$__[ 'user-meta-has-been-reset']		=	tendoo_success( __( 'Your account settings has been reset' ) );
		
		// Tendoo 1.4
		$__[ 'web-app-mode-enabled' ]			=	tendoo_warning( __( 'While "WebApp" Mode is enabled, frontend is disabled. Check your settings to define tendoo mode on Website setings tab.' ) );
		$__['form-expired']						=	tendoo_warning( __( 'Current form data has expired. Please try to submit it again' ) );
		
		set_core_vars( 'default_notices' , $__ );
	}
	/**
	 * declare_notices
	 *
	 * Get declared notices from module/themes
	 *
	 * @access private
	 * @return void
	**/
	function declare_notices( $notices )
	{
		return	array_merge( $notices ,	force_array( get_core_vars( 'tendoo_notices' ) ) );		
	}
	/**
	 * Register vars if tendoo is installed
	 *
	 * @since 1.4
	 * @return void
	 * @access private
	**/
	private function db_vars()
	{
		set_core_vars( 'active_theme' , site_theme() );
		set_core_vars( 'options' , $this->options	=	get_meta( 'all' ) , 'read_only' );
		set_core_vars( 'tendoo_mode' , riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) , 'readonly' );
	}
}