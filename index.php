<?php
// Started on 23/10/2014
session_start();
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// Set Default timeZone
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
date_default_timezone_set('UTC');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* =-=-=-=-=-=-Tendoo Core Script (2014)-=-=-=-=-=-=-=-= */
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
*		Define Cons
**/
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('SITE_TIMEZONE',date_default_timezone_get());
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('TENDOO_VERSION','1.4');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('TENDOO_SIGNATURE','Tendoo - CMS('.TENDOO_VERSION.')');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('SYSTEM_DIR','tendoo-core/');
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
define('THEMES_DIR','tendoo-themes/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('ASSETS_DIR','tendoo-assets/'); // T098
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('MODULES_DIR','tendoo-modules/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('INSTALLER_DIR','tendoo-installer/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('DEBUG_MODE_ENABLED', false );
/* =-=-=-=-=-=-=-=-=-=-=-=-= INITIAL CONFIG -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once(CONFIG_DIR.'base_config.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= SYSTEM SCRIPT -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once(SYSTEM_DIR.'System.Libraries.php');
include_once(SYSTEM_DIR.'System.Core.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD CLASSES -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* Loading all used classes by core Controller */
include_once(LIBRARIES_DIR . 'Meta.Class.php');
include_once(LIBRARIES_DIR . 'Stats.Class.php');
include_once(LIBRARIES_DIR . 'String.Class.php');
include_once(LIBRARIES_DIR . 'Tdate.Class.php');
include_once(LIBRARIES_DIR . 'Lang.Class.php');
include_once(LIBRARIES_DIR . 'File.Class.php');
include_once(LIBRARIES_DIR . 'Url.Class.php');
include_once(LIBRARIES_DIR . 'Exceptions.Class.php');
include_once(LIBRARIES_DIR . 'Helper.Class.php');
include_once(LIBRARIES_DIR . 'Security.Class.php');
include_once(LIBRARIES_DIR . 'Output.Class.php');
include_once(LIBRARIES_DIR . 'Utf8.Class.php');
include_once(LIBRARIES_DIR . 'Input.Class.php');
include_once(LIBRARIES_DIR . 'Loader.Class.php');
include_once(LIBRARIES_DIR . 'database/db.php');
include_once(LIBRARIES_DIR . 'Tendoo.Class.php');
include_once(LIBRARIES_DIR . 'Session.Class.php');
include_once(LIBRARIES_DIR . 'Notice.Class.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD HELPERS -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* Loading helpers, usefull functions. */
include_once(HELPERS_DIR.'apps_helper.php');
include_once(HELPERS_DIR.'function_helper.php');
include_once(HELPERS_DIR.'date.php');
include_once(HELPERS_DIR.'text.php');
include_once(HELPERS_DIR.'cookie_helper.php');
include_once(HELPERS_DIR.'themes_helper.php');
include_once(HELPERS_DIR.'modules_helper.php');
include_once(HELPERS_DIR.'users_helper.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= BOOT HANDLERS -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//set_error_handler('tendoo_error'); // Aborded
//set_error_handler('tendoo_exception'); // Aborded
/* =-=-=-=-=-=-=-=-=-=-=-=-= LAUNCH TENDOO -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$instance =	new instance();
$instance ->	boot();
/* =-=-=-=-=-=-=-=-=-=-=-=-= Tendoo Foundation 2014 - http://tendoo.org -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
