<?php
session_start();
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* =-=-=-=-=-=-HUBBY SCRIPT DU NOYAU(2013)-=-=-=-=-=-=-=-= */
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('HUBBY_VERSION','0.91');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('HUBBY_SIGNATURE','Hubby - CMS('.HUBBY_VERSION.')');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('SYSTEM_DIR','hubby_core/');
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
define('BASE_DIR',SYSTEM_DIR.'libraries/database/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('THEMES_DIR','hubby_themes/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('MODULES_DIR','hubby_modules/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define('INSTALLER_DIR','hubby_installer/');
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* =-=-=-=-=-=-=-=-=-=-=-=-= SYSTEM SCRIPT -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once(SYSTEM_DIR.'Controller.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD CLASSES -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
include_once(LIBRARIES_DIR.'Hubby.php');
include_once(LIBRARIES_DIR.'Session.php');
include_once(LIBRARIES_DIR.'Notice.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD HELPERS -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once(HELPERS_DIR.'function_helper.php');
include_once(HELPERS_DIR.'date.php');
include_once(HELPERS_DIR.'text.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LAUNCH HUBBY -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$OUTPUT				=	new Output;
$INSTANCE			=	new Controller;
/* =-=-=-=-=-=-=-=-=-=-=-=-= UBBER ENTERPRISE 2013 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */