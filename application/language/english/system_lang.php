<?php
// System
$lang[ 'database-installed' ]			=	tendoo_success( __( 'Database has been installed.' ) );
$lang[ 'database-not-found' ]			=	tendoo_error( __( 'Tendoo can\'t access to the database.' ) );
$lang[ 'unable-to-connect' ]			=	tendoo_error( __( 'Tendoo cannot connect to your database host.' ) );
$lang[ 'error-occured' ]				=	tendoo_error( __( 'An error occured.' ) );
$lang[ 'unexpected-error' ]				=	tendoo_error( __( 'An unexpected error occured.' ) );
$lang[ 'access-denied' ]				=	tendoo_error( __( 'Access Denied.' ) );
// Login page
$lang[ 'signin-notice-message' ]		=	__( 'Sign in to start your session' );
$lang[ 'recovery-notice-message' ]		=	__( 'Please enter your email addresse. A recovery email will be send to you.' );
$lang[ 'user-logged-in' ]				= 	tendoo_success( __( 'You logged in successfully.' ) );
$lang[ 'wrong-password-or-credentials' ]= 	tendoo_error( __( 'Wrong Password or User Name' ) );
$lang[ 'login-required' ]				=	tendoo_info( __( 'Login is required.' ) );
// Registration
$lang[ 'username-used' ]				=	tendoo_error( __( 'Username is already used by another user.' ) );
$lang[ 'email-used' ]					=	tendoo_error( __( 'This email is already used.' ) );
$lang[ 'email-already-taken' ]			=	tendoo_error( __( 'This email seems to be already taken.' ) );
$lang[ 'username-already-taken' ]		=	tendoo_error( __( 'This username seems to be already taken.' ) );
$lang[ 'user-created' ]					=	tendoo_success( __( 'The user has been successfully created.' ) );
$lang[ 'account-activated' ]			=	tendoo_success( __( 'Your Account has been activated. Please Sign-up' ) );
// Recovery
$lang[ 'unknow-email' ]					=	tendoo_error( __( 'Unknow email address' ) );
$lang[ 'recovery-email-send' ]			=	tendoo_success( __( 'The recovery email has been send. Please check your email, open the recovery email and follow the instructions.' ) );
// Logout
$lang[ 'logout-required' ]				=	tendoo_info( __( 'You must logout first to access that page.' ) );
// General
$lang[ 'new-password-created' ]			=	tendoo_success( __( 'A new password has been created for your account. Check your email to get it.' ) );
$lang[ 'fetch-error-from-auth' ]		=	function(){
	$errors_array	=	get_instance()->users->auth->get_errors_array();
	$notice_array	=	get_instance()->users->auth->get_infos_array();
	foreach( $errors_array as $_error )
	{
		echo tendoo_error( $_error );
	}
	
	foreach( $notice_array as $notice )
	{
		echo tendoo_error( $notice );
	}};
// User Edition
$lang[ 'user-updated' ]					=	tendoo_success( __( 'User settings\'s has been updated.' ) );
$lang[ 'user-deleted' ]					=	tendoo_success( __( 'The user has been deleted.' ) );