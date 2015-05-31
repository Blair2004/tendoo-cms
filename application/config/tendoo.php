<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Reserved Controller
|--------------------------------------------------------------------------
|
| Set reserved controller for the app.
| 
*/

$config[ 'reserved-controllers' ]				= 	array( 'dashboard' , 'sign-in', 'sign-out' , 'sign-up' , 'tendoo-setup' );
$config[ 'controllers-requiring-installation' ]	=	array( 'dashboard' , 'sign-in' , 'sign-out' , 'sign-up' );
$config[ 'controllers-requiring-login' ]		=	array( 'dashboard' , 'sign-out' );
$config[ 'core-signature' ]						=	'Tendoo 1.5'; // core id
$config[ 'version' ]							=	'1.5'; // core id
$config[ 'supported-lang' ]						=	array( 'english' );
$config[ 'database-version' ]					=	'1.0';

