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
include( 'constants.php' );
/* =-=-=-=-=-=-=-=-=-=-=-=-= INITIAL CONFIG -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once( CONFIG_DIR . 'base_config.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= SYSTEM SCRIPT -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once( SYSTEM_DIR . 'System.Libraries.php');
include_once( SYSTEM_DIR . 'System.Core.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD CLASSES -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* Loading all used classes by core Controller */
include_once( LIBRARIES_DIR . 'Meta.Class.php'); 
include_once( LIBRARIES_DIR . 'Controller.Class.php');
include_once( LIBRARIES_DIR . 'CustomQuery.Class.php');
include_once( LIBRARIES_DIR . 'PostType.Class.php');
include_once( LIBRARIES_DIR . 'String.Class.php');
include_once( LIBRARIES_DIR . 'Tdate.Class.php');
include_once( LIBRARIES_DIR . 'Lang.Class.php');
include_once( LIBRARIES_DIR . 'File.Class.php');
include_once( LIBRARIES_DIR . 'Url.Class.php');
include_once( LIBRARIES_DIR . 'Exceptions.Class.php');
include_once( LIBRARIES_DIR . 'Helper.Class.php');
include_once( LIBRARIES_DIR . 'Security.Class.php');
include_once( LIBRARIES_DIR . 'Output.Class.php');
include_once( LIBRARIES_DIR . 'Utf8.Class.php');
include_once( LIBRARIES_DIR . 'Input.Class.php');
include_once( LIBRARIES_DIR . 'Loader.Class.php');
include_once( LIBRARIES_DIR . 'database/db.php');
include_once( LIBRARIES_DIR . 'Tendoo.Class.php');
include_once( LIBRARIES_DIR . 'Session.Class.php');
include_once( LIBRARIES_DIR . 'Notice.Class.php');
include_once( LIBRARIES_DIR . 'Roles.Class.php');
include_once( LIBRARIES_DIR . 'LCV.Class.php'); // @since 1.4
/* =-=-=-=-=-=-=-=-=-=-=-=-= LOAD HELPERS -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
include_once( HELPERS_DIR . 'apps_helper.php' );
include_once( HELPERS_DIR . 'form_helper.php' );
include_once( HELPERS_DIR . 'core_helper.php');
include_once( HELPERS_DIR . 'date.php');
include_once( HELPERS_DIR . 'text.php');
include_once( HELPERS_DIR . 'cookie_helper.php');
include_once( HELPERS_DIR . 'themes_helper.php');
include_once( HELPERS_DIR . 'modules_helper.php');
include_once( HELPERS_DIR . 'users_helper.php');
/* =-=-=-=-=-=-=-=-=-=-=-=-= LAUNCH TENDOO -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$instance =	new instance();
$instance ->	boot();
/* =-=-=-=-=-=-=-=-=-=-=-=-= Tendoo Foundation 2014 - http://tendoo.org -=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */