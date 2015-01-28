<?php
/**
 *	Tendoo Base Config
**/
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define( 'REWRITE_URL' , FALSE ); // use it if apache rewrite_mod is enabled, otherwise tendoo will crash.
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define( 'SAFE_MODE' , TRUE ); // hide script Errors
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define( 'DEBUG_MODE_ENABLED' , FALSE ); // Display Unexpected Errors
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define( 'LANG_RECORDER_ENABLED' , FALSE ); // record core lang passed as paramter to translate, __ , _e into a file saved on "tendoo-core/languages/en_US.po"
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define( 'LANG' , 'en_US' );
/* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
define( 'GUI_EXPIRE' , 3600 ); // GUI Form expiration time in seconds
/* =-=-=-=-=-=-=-=-=-=-=- Features Status -=-=-=-=-=-=-=-=-= */
define( 'TOOLS_ENABLED' , FALSE ); // in order to enable tools feature on tendoo
