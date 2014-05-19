<?php
// Started on 24/04/2014
session_start();
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* =-=-=-=-=-=-Tendoo SCRIPT DU NOYAU(2014)-=-=-=-=-=-=-=-= */
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/*
		Définition des constances
*/
define('TENDOO_VERSION','0.98');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('TENDOO_SIGNATURE','Tendoo - CMS('.TENDOO_VERSION.')');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('SYSTEM_DIR','tendoo_core/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('HELPERS_DIR',SYSTEM_DIR.'helpers/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('LIBRARIES_DIR',SYSTEM_DIR.'libraries/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('CONTROLLERS_DIR',SYSTEM_DIR.'controllers/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('MODELS_DIR',SYSTEM_DIR.'models/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('VIEWS_DIR',SYSTEM_DIR.'views/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('CONFIG_DIR',SYSTEM_DIR.'config/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('DATABASE_DIR',SYSTEM_DIR.'libraries/database/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('THEMES_DIR','tendoo_themes/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('ASSETS_DIR','tendoo_assets/'); // T098
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('MODULES_DIR','tendoo_modules/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('INSTALLER_DIR','tendoo_installer/');
/* =-=-=-=-=-=-=-=-=-=-=-=-= SYSTEM SCRIPT -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once(SYSTEM_DIR.'Controller.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD CLASSES -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* Chargement des diffirents class qui seront utilisées dans le noyau */
include_once(LIBRARIES_DIR.'Lang.php');
include_once(LIBRARIES_DIR.'Url.php');
include_once(LIBRARIES_DIR.'Exceptions.php');
include_once(LIBRARIES_DIR.'Helper.php');
include_once(LIBRARIES_DIR.'Security.php');
include_once(LIBRARIES_DIR.'Output.php');
include_once(LIBRARIES_DIR.'Utf8.php');
include_once(LIBRARIES_DIR.'Input.php');
include_once(LIBRARIES_DIR.'Loader.php');
include_once(LIBRARIES_DIR.'database/db.php');
include_once(LIBRARIES_DIR.'Tendoo.php');
include_once(LIBRARIES_DIR.'Session.php');
include_once(LIBRARIES_DIR.'Notice.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD HELPERS -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* Chargement des helpers, fonctions utilitaires. */
include_once(HELPERS_DIR.'function_helper.php');
include_once(HELPERS_DIR.'date.php');
include_once(HELPERS_DIR.'text.php');
include_once(HELPERS_DIR.'cookie_helper.php');
include_once(HELPERS_DIR.'apps_helper.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= BOOT HANDLERS -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//set_error_handler('tendoo_error'); // Aborded
//set_error_handler('tendoo_exception'); // Aborded
/* =-=-=-=-=-=-=-=-=-=-=-=-= LAUNCH TENDOO -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
new Controller;
/* =-=-=-=-=-=-=-=-=-=-=-=-= UBBER ENTERPRISE 2014 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */